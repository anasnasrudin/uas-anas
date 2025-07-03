<?php

namespace App\Http\Controllers;

use App\Models\TableUser;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    public function login(){
        return view('login');
    }

    public function masuk(Request $request){
        $request->validate([
            'username' => 'required',
            'password' => 'required'
        ],[
            'username.required' => 'Mohon Masukkan Username!!!',
            'password.required' => 'Mohon Masukkan Password!!!'
        ]);
    
        $data = $request->only(['username','password']);
    
        if(Auth::guard('udin')->attempt($data)){
            $user = Auth::guard('udin')->user();
    
            \App\Models\TableLog::create([
                'waktu' => now(),
                'aktivitas' => 'Login',
                'id_user' => $user->id_user
            ]);
    
            if($user->tipe_user == 'admin'){
                return redirect('Admin/LogActivity');
            }elseif($user->tipe_user == 'kasir'){
                return redirect('Kasir/KelolaTransaksi');
            }elseif($user->tipe_user == 'gudang'){
                return redirect('Gudang/KelolaBarang');
            }
    
            return redirect('login')->with('pesan','Tipe user tidak dikenali.');
        }
    
        $u = TableUser::where('username', $request->username)->first();
    
        if($u && \Hash::check($request->password, $u->password)){
            Auth::guard('udin')->login($u);
    
            \App\Models\TableLog::create([
                'waktu' => now(),
                'aktivitas' => 'Login',
                'id_user' => $u->id_user
            ]);
    
            if($u->tipe_user == 'admin'){
                return redirect('Admin/LogActivity');
            }elseif($u->tipe_user == 'kasir'){
                return redirect('Kasir/KelolaTransaksi');
            }elseif($u->tipe_user == 'gudang'){
                return redirect('Gudang/KelolaBarang');
            }
    
            return redirect('login')->with('pesan','Tipe user tidak dikenali.');
        }
    
        return back()->with('pesan','Username atau password salah!!!');
    }    
    
    public function logout(){
        $user = Auth::guard('udin')->user();
    
        if($user){
            \App\Models\TableLog::create([
                'waktu' => now(),
                'aktivitas' => 'Logout',
                'id_user' => $user->id_user
            ]);
        }
    
        Auth::guard('udin')->logout();
        session()->forget('tiket');
        return redirect('login');
    }
}
