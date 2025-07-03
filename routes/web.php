<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\GudangController;
use App\Http\Controllers\KasirController;
use App\Http\Controllers\LogController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\UserController;
use App\Http\Middleware\CekLogin;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
})->middleware(CekLogin::class);

Route::get('login', [LoginController::class, 'login'])->name('login');
Route::post('login', [LoginController::class, 'masuk']);
Route::post('logout', [LoginController::class, 'logout'])->middleware('auth:udin');

Route::middleware(['auth:udin', \App\Http\Middleware\CekTipeUser::class . ':admin'])->group(function () {
    Route::get('Admin/LogActivity', [LogController::class, 'log_activity']);
    Route::get('Admin/KelolaUser', [UserController::class, 'kelola_user']);
    Route::post('Admin/KelolaUser', [UserController::class, 'handle_user']);
    Route::get('Admin/KelolaLaporan', [UserController::class, 'kelola_laporan']);
});

Route::middleware(['auth:udin', \App\Http\Middleware\CekTipeUser::class . ':kasir'])->group(function () {
    Route::get('Kasir/KelolaTransaksi', [KasirController::class, 'kelola_transaksi']);
    Route::post('Kasir/KelolaTransaksi', [KasirController::class, 'handle_transaksi']);
});

Route::middleware(['auth:udin', \App\Http\Middleware\CekTipeUser::class . ':gudang'])->group(function () {
    Route::get('Gudang/KelolaBarang', [GudangController::class, 'kelola_barang']);
    Route::post('Gudang/KelolaBarang', [GudangController::class, 'handle_barang']);
});
