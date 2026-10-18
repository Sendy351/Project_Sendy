<?php

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\JasaController;
use App\Http\Controllers\Api\KategoriJasaController;
use App\Http\Controllers\Api\PembayaranController;
use App\Http\Controllers\Api\PenyediaJasaController;
use App\Http\Controllers\Api\PermintaanJasaController;
use App\Http\Controllers\Api\PesananController;
use App\Http\Controllers\Api\UlasanController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| REST API Routes - Sistem Informasi Jasa Multifungsi (Jasa_Kita)
|--------------------------------------------------------------------------
*/

Route::prefix('auth')->group(function () {
    Route::post('/register', [AuthController::class, 'register'])->name('api.auth.register');
    Route::post('/login', [AuthController::class, 'login'])->name('api.auth.login');
    Route::get('/profile/{id}', [AuthController::class, 'profile'])->name('api.auth.profile');
});

// Kategori Jasa
Route::get('/kategori-jasa', [KategoriJasaController::class, 'index'])->name('api.kategori.index');
Route::get('/kategori-jasa/{id}', [KategoriJasaController::class, 'show'])->name('api.kategori.show');
Route::post('/kategori-jasa', [KategoriJasaController::class, 'store'])->name('api.kategori.store');

// Penyedia Jasa
Route::get('/penyedia-jasa', [PenyediaJasaController::class, 'index'])->name('api.penyedia.index');
Route::get('/penyedia-jasa/{id}', [PenyediaJasaController::class, 'show'])->name('api.penyedia.show');
Route::post('/penyedia-jasa', [PenyediaJasaController::class, 'store'])->name('api.penyedia.store');

// Katalog Jasa
Route::get('/jasa', [JasaController::class, 'index'])->name('api.jasa.index');
Route::get('/jasa/{id}', [JasaController::class, 'show'])->name('api.jasa.show');
Route::post('/jasa', [JasaController::class, 'store'])->name('api.jasa.store');

// Permintaan Jasa
Route::get('/permintaan-jasa', [PermintaanJasaController::class, 'index'])->name('api.permintaan.index');
Route::get('/permintaan-jasa/{id}', [PermintaanJasaController::class, 'show'])->name('api.permintaan.show');
Route::post('/permintaan-jasa', [PermintaanJasaController::class, 'store'])->name('api.permintaan.store');

// Pesanan & Lifecycle
Route::get('/pesanan', [PesananController::class, 'index'])->name('api.pesanan.index');
Route::get('/pesanan/{id}', [PesananController::class, 'show'])->name('api.pesanan.show');
Route::post('/pesanan', [PesananController::class, 'store'])->name('api.pesanan.store');
Route::patch('/pesanan/{id}/status', [PesananController::class, 'updateStatus'])->name('api.pesanan.update_status');

// Pembayaran
Route::get('/pembayaran/{id}', [PembayaranController::class, 'show'])->name('api.pembayaran.show');
Route::post('/pembayaran', [PembayaranController::class, 'store'])->name('api.pembayaran.store');

// Ulasan
Route::get('/ulasan', [UlasanController::class, 'index'])->name('api.ulasan.index');
Route::post('/ulasan', [UlasanController::class, 'store'])->name('api.ulasan.store');
