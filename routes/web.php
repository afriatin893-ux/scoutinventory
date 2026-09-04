<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\BarangController;
use App\Http\Controllers\Admin\PeminjamanController;
use App\Http\Controllers\Admin\PengembalianController;
use App\Http\Controllers\Peminjam\DashboardController as PeminjamDashboardController;
use App\Http\Controllers\Peminjam\BarangController as PeminjamBarangController;
use App\Http\Controllers\Peminjam\PeminjamanController as PeminjamPeminjamanController;

Route::get('/', function () {return view('welcome');});

Route::get('/login', [\App\Http\Controllers\Auth\LoginController::class, 'showLogin'])->name('login');
Route::post('/login', [\App\Http\Controllers\Auth\LoginController::class, 'login'])->name('login.proses');
Route::post('/logout', [\App\Http\Controllers\Auth\LoginController::class, 'logout'])->name('logout');
Route::get('/register', [\App\Http\Controllers\Auth\RegisterController::class, 'showRegistrationForm'])->name('register');
Route::post('/register', [\App\Http\Controllers\Auth\RegisterController::class, 'register']);

// ================= ADMIN =================
Route::get('/admin/dashboard', [DashboardController::class, 'index'])
    ->middleware('auth:admin')
    ->name('admin.dashboard');

Route::middleware('auth:admin')->prefix('admin')->name('admin.')->group(function () {

    Route::get('/kategori', [\App\Http\Controllers\Admin\KategoriController::class, 'index'])->name('kategori.index');
    Route::get('/kategori/create', [\App\Http\Controllers\Admin\KategoriController::class, 'create'])->name('kategori.create');
    Route::post('/kategori', [\App\Http\Controllers\Admin\KategoriController::class, 'store'])->name('kategori.store');
    Route::get('/kategori/{kategori}/edit', [\App\Http\Controllers\Admin\KategoriController::class, 'edit'])->name('kategori.edit');
    Route::put('/kategori/{kategori}', [\App\Http\Controllers\Admin\KategoriController::class, 'update'])->name('kategori.update');
    Route::delete('/kategori/{kategori}', [\App\Http\Controllers\Admin\KategoriController::class, 'destroy'])->name('kategori.destroy');

    Route::resource('barang', BarangController::class);

    Route::get('/peminjaman/pending', [PeminjamanController::class, 'pending'])->name('peminjaman.pending');
    Route::get('/peminjaman', [PeminjamanController::class, 'index'])->name('peminjaman.index');
    Route::get('/peminjaman/{peminjaman}', [PeminjamanController::class, 'show'])->name('peminjaman.show');
    Route::put('/peminjaman/{peminjaman}/verifikasi', [PeminjamanController::class, 'verifikasi'])->name('peminjaman.verifikasi');

    Route::get('/pengembalian/{idPeminjaman}', [PengembalianController::class, 'create'])->name('pengembalian.create');
    Route::post('/pengembalian/{idPeminjaman}', [PengembalianController::class, 'store'])->name('pengembalian.store');

    Route::get('/profil', [\App\Http\Controllers\Admin\ProfilController::class, 'edit'])->name('profil.edit');
    Route::put('/profil', [\App\Http\Controllers\Admin\ProfilController::class, 'update'])->name('profil.update');
});

// ================= PEMINJAM =================
Route::middleware('auth:peminjam')->prefix('peminjam')->name('peminjam.')->group(function () {

    Route::get('/dashboard', [PeminjamDashboardController::class, 'index'])->name('dashboard');

    Route::get('/kategori', [\App\Http\Controllers\Peminjam\KategoriController::class, 'index'])->name('kategori.index');

    Route::get('/barang', [PeminjamBarangController::class, 'index'])->name('barang.index');

    Route::get('/peminjaman/create', [PeminjamPeminjamanController::class, 'create'])->name('peminjaman.create');
    Route::post('/peminjaman', [PeminjamPeminjamanController::class, 'store'])->name('peminjaman.store');
    Route::get('/peminjaman', [PeminjamPeminjamanController::class, 'index'])->name('peminjaman.index');
    Route::get('/peminjaman/{peminjaman}', [PeminjamPeminjamanController::class, 'show'])->name('peminjaman.show');

    Route::get('/profil', [\App\Http\Controllers\Peminjam\ProfilController::class, 'edit'])->name('profil.edit');
    Route::put('/profil', [\App\Http\Controllers\Peminjam\ProfilController::class, 'update'])->name('profil.update');
});
