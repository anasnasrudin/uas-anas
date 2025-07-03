<?php

namespace App\Http\Controllers;

use App\Models\TableUser;
use App\Models\TableTransaksi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Carbon\Carbon;

class UserController extends Controller
{
    public function kelola_user(Request $request){
        $u = new TableUser();

        if ($request->cari) {
            $cari = $request->cari;
            $u = $u->where('nama', 'like', "%$cari%")
                ->orWhere('username', 'like', "%$cari%")
                ->orWhere('telepon', 'like', "%$cari%");
        }

        return view('admin.kelola-user', [
            'data_user' => $u->paginate(5)
        ]);
    }

    public function handle_user(Request $request){
        switch ($request->input('action')) {
            case 'tambah':
                return $this->tambah_user($request);
            case 'edit':
                return $this->edit_user($request);
            case 'hapus':
                return $this->hapus_user($request);
            default:
                return back()->with('pesan_gagal','aksi tidak dikenali');
        }
    }

    public function tambah_user(Request $request){
        $request->validate([
            'tipe_user' => 'required|in:gudang,kasir',
            'nama' => 'required',
            'telepon' => 'required',
            'alamat' => 'required',
            'username' => 'required',
            'password' => 'required',
        ], [
            'tipe_user.required' => 'Tipe user wajib dipilih.',
            'tipe_user.in' => 'Tipe user harus bernilai gudang atau kasir.',
            'nama.required' => 'Nama wajib diisi.',
            'telepon.required' => 'Nomor telepon wajib diisi.',
            'alamat.required' => 'Alamat wajib diisi.',
            'username.required' => 'Username wajib diisi.',
            'password.required' => 'Password wajib diisi.',
        ]);

        $u = new TableUser();
        $u->tipe_user = $request->tipe_user;
        $u->nama = $request->nama;
        $u->telepon = $request->telepon;
        $u->alamat = $request->alamat;
        $u->username = $request->username;
        $u->password = Hash::make($request->password);

        if ($u->save()) {
            return redirect('Admin/KelolaUser')->with('pesan_berhasil','Data berhasil ditambahkan');
        }
        return back()->with('pesan_gagal','data gagal ditambahkan');
    }

    public function edit_user(Request $request){
        $request->validate([
            'id_user' => 'required|exists:table_users,id_user',
            'tipe_user' => 'required|in:gudang,kasir',
            'nama' => 'required',
            'telepon' => 'required',
            'alamat' => 'required',
            'username' => 'required'
        ], [
            'id_user.required' => 'ID user wajib diisi.',
            'id_user.exists' => 'ID user tidak ditemukan di dalam database.',
            'tipe_user.required' => 'Tipe user wajib dipilih.',
            'tipe_user.in' => 'Tipe user harus bernilai gudang atau kasir.',
            'nama.required' => 'Nama wajib diisi.',
            'telepon.required' => 'Nomor telepon wajib diisi.',
            'alamat.required' => 'Alamat wajib diisi.',
            'username.required' => 'Username wajib diisi.',
        ]);
        
        $u = TableUser::find($request->id_user);

        if ($u) {
            $u->tipe_user = $request->tipe_user;
            $u->nama = $request->nama;
            $u->telepon = $request->telepon;
            $u->alamat = $request->alamat;
            $u->username = $request->username;

            if ($request->filled('password')) {
                $u->password = Hash::make($request->password);
            }

            $u->save();

            return redirect('Admin/KelolaUser')->with('pesan_berhasil', 'Data berhasil diperbarui');
        }

        return back()->with('pesan_gagal', 'User tidak ditemukan');
    }

    public function hapus_user(Request $request){
        $u = TableUser::find($request->id_user);

        if ($u) {
            $u->delete();
            return redirect('Admin/KelolaUser')->with('pesan_berhasil', 'User berhasil dihapus');
        }

        return back()->with('pesan_gagal', 'User tidak ditemukan');
    }

    public function kelola_laporan(Request $request){
        $query = TableTransaksi::with('user');
    
        if ($request->filled('tanggal_awal') && $request->filled('tanggal_akhir')) {
            $start = Carbon::parse($request->tanggal_awal)->startOfDay();
            $end = Carbon::parse($request->tanggal_akhir)->endOfDay();
    
            $query->whereBetween('created_at', [$start, $end]);
        }
    
        $data_transaksi = $query->orderBy('created_at', 'asc')->paginate(5);
    
        return view('admin.kelola-laporan', [
            'data_transaksi' => $data_transaksi,
            'tanggal_awal' => $request->tanggal_awal,
            'tanggal_akhir' => $request->tanggal_akhir
        ]);
    }
}
