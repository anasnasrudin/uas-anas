<?php

namespace App\Http\Controllers;

use App\Models\TableBarang;
use Illuminate\Http\Request;

class GudangController extends Controller
{
    public function kelola_barang(Request $request){
        $b = new TableBarang();

        if ($request->cari) {
            $cari = $request->cari;
            $b = $b->where('nama_barang', 'like', "%$cari%")
                ->orWhere('kode_barang', 'like', "%$cari%")
                ->orWhere('satuan', 'like', "%$cari%");
        }

        return view('gudang.kelola-barang', [
            'data_barang' => $b->paginate(5)
        ]);
    }

    public function handle_barang(Request $request){
        switch ($request->input('action')) {
            case 'tambah':
                return $this->tambah_barang($request);
            case 'edit':
                return $this->edit_barang($request);
            case 'hapus':
                return $this->hapus_barang($request);
            default:
                return back()->with('pesan_gagal', 'Aksi tidak dikenali');
        }
    }

    public function tambah_barang(Request $request){
        // proses validasi
        $request->validate([
            'kode_barang' => 'required',
            'nama_barang' => 'required',
            'expired_date' => 'required|date',
            'jumlah_barang' => 'required|integer|min:1',
            'satuan' => 'required',
            'harga_satuan' => 'required|integer|min:0',
        ],[
            'kode_barang.required' => 'Kode barang wajib diisi.',
            'nama_barang.required' => 'Nama barang wajib diisi.',
            'expired_date.required' => 'Tanggal kedaluwarsa wajib diisi.',
            'expired_date.date' => 'Tanggal kedaluwarsa harus berupa format tanggal yang valid.',
            'jumlah_barang.required' => 'Jumlah barang wajib diisi.',
            'jumlah_barang.integer' => 'Jumlah barang harus berupa angka.',
            'jumlah_barang.min' => 'Jumlah barang minimal adalah 1.',
            'satuan.required' => 'Satuan barang wajib diisi.',
            'harga_satuan.required' => 'Harga satuan wajib diisi.',
            'harga_satuan.integer' => 'Harga satuan harus berupa angka.',
            'harga_satuan.min' => 'Harga satuan tidak boleh negatif.',
        ]);

        // proses simpan
        $b = new TableBarang();
        $b->kode_barang = $request->kode_barang;
        $b->nama_barang = $request->nama_barang;
        $b->expired_date = $request->expired_date;
        $b->jumlah_barang = $request->jumlah_barang;
        $b->satuan = $request->satuan;
        $b->harga_satuan = $request->harga_satuan;

        if ($b->save()) {
            return redirect('Gudang/KelolaBarang')->with('pesan_berhasil', 'Data barang berhasil ditambahkan');
        }

        return back()->with('pesan_gagal', 'Data barang gagal ditambahkan');
    }

    public function edit_barang(Request $request){
        // proses validasi
        $request->validate([
            'id_barang' => 'required|exists:table_barangs,id_barang',
            'kode_barang' => 'required',
            'nama_barang' => 'required',
            'expired_date' => 'required|date',
            'jumlah_barang' => 'required|integer|min:1',
            'satuan' => 'required',
            'harga_satuan' => 'required|integer|min:0',
        ], [
            'id_barang.required' => 'ID barang wajib diisi.',
            'id_barang.exists' => 'ID barang tidak ditemukan di dalam database.',
            'kode_barang.required' => 'Kode barang wajib diisi.',
            'nama_barang.required' => 'Nama barang wajib diisi.',
            'expired_date.required' => 'Tanggal kedaluwarsa wajib diisi.',
            'expired_date.date' => 'Tanggal kedaluwarsa harus berupa tanggal yang valid.',
            'jumlah_barang.required' => 'Jumlah barang wajib diisi.',
            'jumlah_barang.integer' => 'Jumlah barang harus berupa angka.',
            'jumlah_barang.min' => 'Jumlah barang minimal adalah 1.',
            'satuan.required' => 'Satuan barang wajib diisi.',
            'harga_satuan.required' => 'Harga satuan wajib diisi.',
            'harga_satuan.integer' => 'Harga satuan harus berupa angka.',
            'harga_satuan.min' => 'Harga satuan tidak boleh negatif.',
        ]);

        $b = TableBarang::find($request->id_barang);

        if ($b) {
            $b->kode_barang = $request->kode_barang;
            $b->nama_barang = $request->nama_barang;
            $b->expired_date = $request->expired_date;
            $b->jumlah_barang = $request->jumlah_barang;
            $b->satuan = $request->satuan;
            $b->harga_satuan = $request->harga_satuan;

            $b->save();

            return redirect('Gudang/KelolaBarang')->with('pesan_berhasil', 'Data barang berhasil diperbarui');
        }

        return back()->with('pesan_gagal', 'Barang tidak ditemukan');
    }

    public function hapus_barang(Request $request){
        $b = TableBarang::find($request->id_barang);

        if ($b) {
            $b->delete();
            return redirect('Gudang/KelolaBarang')->with('pesan_berhasil', 'Data barang berhasil dihapus');
        }

        return back()->with('pesan_gagal', 'Barang tidak ditemukan');
    }
}
