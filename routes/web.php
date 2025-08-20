<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\TindakanController;
use App\Http\Controllers\ObatController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\Admin\DashboardController as AdminDashboardController;
use App\Http\Controllers\Pendaftaran\DashboardController as PendaftaranDashboardController;
use App\Http\Controllers\Dokter\DashboardController as DokterDashboardController;
use App\Http\Controllers\Kasir\DashboardController as KasirDashboardController;

// Route default (Welcome Page)
Route::get('/', [LoginController::class, 'showLoginForm'])->name('login');

// Auth (login, register, forgot password, dll)
Auth::routes();

// Dashboard setelah login
Route::get('/home', [HomeController::class, 'index'])
    ->name('home')
    ->middleware('auth');

// =======================
// Admin Only
// =======================
Route::middleware(['auth', 'role:Admin'])->prefix('admin')->as('admin.')->group(function () {

    Route::get('dashboard', [AdminDashboardController::class, 'index'])->name('dashboard');

    Route::resource('wilayah', 'Admin\WilayahController');
    Route::resource('user', 'Admin\UserController');
    Route::resource('pegawai', 'Admin\PegawaiController');
    Route::resource('tindakan', 'Admin\TindakanController');
    Route::resource('obat', 'Admin\ObatController');
    Route::resource('laporan', 'Admin\LaporanController');

     Route::post('laporan/export', [App\Http\Controllers\Admin\LaporanController::class, 'export'])->name('laporan.export');
});


// =======================
// Pendaftaran Only
// =======================

Route::middleware(['auth', 'role:Pendaftaran'])->prefix('pendaftaran')->as('pendaftaran.')->group(function () {
    Route::get('dashboard', [PendaftaranDashboardController::class, 'index'])->name('dashboard');
    Route::resource('pasien', 'Pendaftaran\PasienController');
    Route::resource('pendaftaran', 'Pendaftaran\PendaftaranController');;
});



// =======================
// Dokter Only
// =======================


Route::middleware(['auth', 'role:Dokter'])->prefix('dokter')->name('dokter.')->group(function () {
    Route::get('/dashboard', [DokterDashboardController::class, 'index'])->name('index');
    Route::get('/antrian', [DokterDashboardController::class, 'antrian'])->name('antrian');
    Route::get('/transaksi/{id}', [DokterDashboardController::class, 'viewPasien'])->name('transaksi.view');
    Route::post('/transaksi/simpan', [DokterDashboardController::class, 'simpanTransaksi'])->name('transaksi.simpan');
    Route::post('/logout', [DokterDashboardController::class, 'logout'])->name('logout');
});

// =======================
// Kasir Only
// =======================

Route::middleware(['auth', 'role:Kasir'])->prefix('kasir')->name('kasir.')->group(function () {
    Route::get('/dashboard', [KasirDashboardController::class, 'dashboard'])->name('dashboard');
    Route::get('/tagihan', [KasirDashboardController::class, 'tagihan'])->name('tagihan');
    Route::get('/pembayaran/{id}', [KasirDashboardController::class, 'showPembayaran'])->name('pembayaran.show');
    Route::post('/pembayaran/{id}', [KasirDashboardController::class, 'prosesPembayaran'])->name('pembayaran.proses');
    Route::get('/riwayat', [KasirDashboardController::class, 'riwayat'])->name('riwayat');
    Route::get('/struk/{id}', [KasirDashboardController::class, 'printStruk'])->name('struk.print');
    Route::post('/logout', [KasirDashboardController::class, 'logout'])->name('logout');

});
