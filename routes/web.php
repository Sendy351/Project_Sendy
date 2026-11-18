<?php

use App\Http\Controllers\ProductController;
use App\Http\Controllers\TaskController;
use App\Http\Controllers\Web\AuthController as WebAuth;
use App\Http\Controllers\Web\ChatController;
use App\Http\Controllers\Web\JasaController;
use App\Http\Controllers\Web\KategoriController;
use App\Http\Controllers\Web\PesananController;
use App\Models\Jasa;
use App\Models\Pengguna;
use App\Models\PenyediaJasa;
use App\Models\Pesanan;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes - Sistem On-Demand Campus Errand (Lalamove Style) Sesuai ERD
|--------------------------------------------------------------------------
*/

// Halaman Utama: Live Order Pool Kampus (Tempat posting & ambil orderan bebas)
Route::get('/', [PesananController::class, 'pool'])->name('home');

// Autentikasi Pengguna Mahasiswa & Mitra Runner
Route::get('/login', [WebAuth::class, 'showLogin'])->name('login');
Route::post('/login', [WebAuth::class, 'login'])->name('login.post');
Route::post('/quick-login/{id}', [WebAuth::class, 'quickLogin'])->name('login.quick');
Route::get('/register', [WebAuth::class, 'showRegister'])->name('register');
Route::post('/register', [WebAuth::class, 'register'])->name('register.post');
Route::post('/logout', [WebAuth::class, 'logout'])->name('logout');

// Alur Pool Orderan ala Lalamove
Route::middleware('auth')->group(function () {
    Route::post('/order/post', [PesananController::class, 'postOrder'])->name('order.post');
    Route::post('/order/{id}/claim', [PesananController::class, 'claimOrder'])->name('order.claim');
});

// Katalog Acuan Layanan Jasa Kampus (CRUD)
Route::get('/katalog', [JasaController::class, 'index'])->name('jasa.index');
Route::get('/jasa/create', [JasaController::class, 'create'])->middleware('auth')->name('jasa.create');
Route::post('/jasa', [JasaController::class, 'store'])->middleware('auth')->name('jasa.store');
Route::get('/jasa/{id}', [JasaController::class, 'show'])->name('jasa.show');
Route::get('/jasa/{id}/edit', [JasaController::class, 'edit'])->middleware('auth')->name('jasa.edit');
Route::put('/jasa/{id}', [JasaController::class, 'update'])->middleware('auth')->name('jasa.update');
Route::delete('/jasa/{id}', [JasaController::class, 'destroy'])->middleware('auth')->name('jasa.destroy');

// Master Kategori Jasa (CRUD)
Route::get('/kategori', [KategoriController::class, 'index'])->name('kategori.index');
Route::post('/kategori', [KategoriController::class, 'store'])->middleware('auth')->name('kategori.store');
Route::put('/kategori/{id}', [KategoriController::class, 'update'])->middleware('auth')->name('kategori.update');
Route::delete('/kategori/{id}', [KategoriController::class, 'destroy'])->middleware('auth')->name('kategori.destroy');

// Aktivitas Pesanan, Lifecycle Pengerjaan, Pembayaran & Ulasan
Route::middleware('auth')->group(function () {
    Route::get('/pesanan', [PesananController::class, 'index'])->name('pesanan.index');
    Route::get('/pesanan/{id}', [PesananController::class, 'show'])->name('pesanan.show');
    Route::post('/pesanan/booking', [PesananController::class, 'booking'])->name('pesanan.booking');
    Route::post('/pesanan/{id}/status', [PesananController::class, 'updateStatus'])->name('pesanan.update_status');
    Route::post('/pesanan/{id}/bayar', [PesananController::class, 'bayar'])->name('pesanan.bayar');
    Route::post('/pesanan/{id}/ulasan', [PesananController::class, 'kirimUlasan'])->name('pesanan.ulasan');

    // Chat in-app pemesan <-> runner (teks + foto lokasi)
    Route::get('/pesanan/{id}/chat', [ChatController::class, 'index'])->name('chat.index');
    Route::post('/pesanan/{id}/chat', [ChatController::class, 'store'])->middleware('throttle:30,1')->name('chat.store');
    Route::get('/chat/foto/{pesanId}', [ChatController::class, 'foto'])->name('chat.foto');
});

// Presentasi UTS & Demo API Explorer
Route::get('/uts', function () {
    $stats = [
        'pengguna' => Pengguna::count(),
        'penyedia' => PenyediaJasa::count(),
        'jasa' => Jasa::count(),
        'pesanan' => Pesanan::count(),
    ];
    $jasaList = Jasa::with(['kategori', 'penyedia'])->get();
    return view('dashboard', compact('stats', 'jasaList'));
})->name('uts.dashboard');

/*
|--------------------------------------------------------------------------
| Web Routes - Project Mahasiswa Sendy (P2P Tasks & Modul Produk)
|--------------------------------------------------------------------------
*/
Route::get('/tasks', [TaskController::class, 'index'])->name('tasks.index');
Route::post('/tasks', [TaskController::class, 'store'])->name('tasks.store');
Route::post('/tasks/{task}/claim', [TaskController::class, 'claim'])->name('tasks.claim');
Route::post('/tasks/{task}/proof', [TaskController::class, 'submitProof'])->name('tasks.proof');
Route::post('/tasks/{task}/complete', [TaskController::class, 'confirmComplete'])->name('tasks.complete');
Route::post('/switch-user', [TaskController::class, 'switchUser'])->name('tasks.switch_user');

Route::resource('products', ProductController::class);