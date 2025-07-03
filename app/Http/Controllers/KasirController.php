<?php

namespace App\Http\Controllers;

use App\Models\TableBarang;
use App\Models\TableTransaksi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class KasirController extends Controller
{
    public function kelola_transaksi(Request $request)
    {
        // Reset keranjang kalau ada query ?reset=1
        if ($request->query('reset') == 1) {
            session()->forget('keranjang');
            session()->forget('kembalian');
        }

        $db = TableBarang::all();
        return view('kasir.kelola-transaksi', [
            'data_barang' => $db,
            'keranjang' => session('keranjang', []),
            'kembalian' => session('kembalian', 0)
        ]);
    }

    public function handle_transaksi(Request $request)
    {
        switch ($request->input('action')) {
            case 'tambah':
                return $this->tambah_keranjang($request);
            case 'reset':
                return $this->reset_keranjang();
            case 'bayar':
                return $this->proses_bayar($request);
            case 'simpan':
                return $this->simpan_transaksi($request);
            default:
                return back()->with('pesan_gagal', 'Aksi tidak dikenali');
        }
    }

    public function tambah_keranjang(Request $request)
    {
        $request->validate([
            'kode_barang' => 'required',
            'nama_barang' => 'required',
            'harga_satuan' => 'required|integer',
            'jumlah' => 'required|integer|min:1',
        ],[
            'kode_barang.required' => 'Kode barang wajib diisi.',
            'nama_barang.required' => 'Nama barang wajib diisi.',
            'harga_satuan.required' => 'Harga satuan wajib diisi.',
            'harga_satuan.integer' => 'Harga satuan harus berupa angka.',
            'jumlah.required' => 'Jumlah barang wajib diisi.',
            'jumlah.integer' => 'Jumlah harus berupa angka.',
            'jumlah.min' => 'Jumlah minimal adalah 1.',
        ]);

        $item = [
            'kode_barang' => $request->kode_barang,
            'nama_barang' => $request->nama_barang,
            'harga_satuan' => $request->harga_satuan,
            'jumlah' => $request->jumlah,
            'subtotal' => $request->harga_satuan * $request->jumlah
        ];

        $keranjang = session()->get('keranjang', []);
        $keranjang[] = $item;
        session(['keranjang' => $keranjang]);

        return back()->with('pesan_berhasil', 'Barang berhasil ditambahkan ke keranjang');
    }

    public function reset_keranjang()
    {
        session()->forget('keranjang');
        session()->forget('kembalian');
        return back()->with('pesan_berhasil', 'Keranjang berhasil dikosongkan');
    }

    public function proses_bayar(Request $request)
    {
        $request->validate([
            'nominal_bayar' => 'required|integer|min:1',
        ]);

        $keranjang = session('keranjang', []);
        $total_harga = collect($keranjang)->sum('subtotal');
        $nominal = $request->input('nominal_bayar');

        if ($nominal < $total_harga) {
            return back()->with('pesan_gagal', 'Nominal bayar kurang dari total harga!');
        }

        $kembalian = $nominal - $total_harga;
        return redirect('Kasir/KelolaTransaksi')
            ->with('pesan_berhasil', 'Pembayaran berhasil!')
            ->with('kembalian', $kembalian);
    }

    public function simpan_transaksi(Request $request)
    {
        $keranjang = session('keranjang', []);
        $id_user = Auth::guard('udin')->user()->id_user;

        foreach ($keranjang as $index => $item) {
            TableTransaksi::create([
                'no_transaksi' => 'TSI-' . str_pad($index + 1, 3, '0', STR_PAD_LEFT),
                'tgl_transaksi' => now()->format('Y-m-d'),
                'total_bayar' => $item['subtotal'],
                'id_user' => $id_user,
                'id_barang' => TableBarang::where('kode_barang', $item['kode_barang'])->value('id_barang')
            ]);
        }

        session()->forget('keranjang');
        session()->forget('kembalian');

        return back()->with('pesan_berhasil', 'Transaksi berhasil disimpan!');
    }
}
