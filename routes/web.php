<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Peminjam\DashboardController;
use App\Http\Controllers\Admin\BarangController;
use App\Http\Controllers\Admin\PeminjamanController;
use App\Http\Controllers\Admin\PengembalianController;


Route::get('/', function () {return view('welcome');});

Route::get('/login', [\App\Http\Controllers\Auth\LoginController::class, 'showLogin'])->name('login');

Route::post('/login', [\App\Http\Controllers\Auth\LoginController::class, 'login'])->name('login.proses');

Route::post('/logout', [\App\Http\Controllers\Auth\LoginController::class, 'logout'])->name('logout');

Route::get('/register', [\App\Http\Controllers\Auth\RegisterController::class, 'showRegistrationForm'])->name('register');

Route::post('/register', [\App\Http\Controllers\Auth\RegisterController::class, 'register']);

Route::get('/admin/dashboard', [DashboardController::class, 'index'])
    ->middleware('auth:admin')
    ->name('admin.dashboard');

Route::get('/peminjam/dashboard', function () {return 'Selamat datang Peminjam';})->middleware('auth:peminjam')->name('peminjam.dashboard');

Route::get('/admin/kategori', [\App\Http\Controllers\Admin\KategoriController::class, 'index'])->middleware('auth:admin')->name('admin.kategori.index');

Route::get('/admin/kategori/create', [\App\Http\Controllers\Admin\KategoriController::class, 'create'])->middleware('auth:admin')->name('admin.kategori.create');

Route::post('/admin/kategori', [\App\Http\Controllers\Admin\KategoriController::class, 'store'])->middleware('auth:admin')->name('admin.kategori.store');

Route::get('/admin/kategori/{kategori}/edit', [\App\Http\Controllers\Admin\KategoriController::class, 'edit'])
    ->middleware('auth:admin')
    ->name('admin.kategori.edit');

Route::put('/admin/kategori/{kategori}', [\App\Http\Controllers\Admin\KategoriController::class, 'update'])
    ->middleware('auth:admin')
    ->name('admin.kategori.update');

Route::delete('/admin/kategori/{kategori}', [\App\Http\Controllers\Admin\KategoriController::class, 'destroy'])
    ->middleware('auth:admin')
    ->name('admin.kategori.destroy');

Route::middleware('auth:admin')->prefix('admin')->name('admin.')->group(function () {
    Route::resource('barang', BarangController::class);
});

Route::middleware('auth:admin')->prefix('admin')->name('admin.')->group(function () {

    Route::get('/peminjaman/pending', [PeminjamanController::class, 'pending'])
        ->name('peminjaman.pending');

    Route::get('/peminjaman', [PeminjamanController::class, 'index'])
        ->name('peminjaman.index');

    Route::get('/peminjaman/{peminjaman}', [PeminjamanController::class, 'show'])
        ->name('peminjaman.show');

    Route::put('/peminjaman/{peminjaman}/verifikasi', [PeminjamanController::class, 'verifikasi'])
        ->name('peminjaman.verifikasi');

});

Route::middleware('auth:admin')->prefix('admin')->name('admin.')->group(function () {

    Route::get('/pengembalian/{idPeminjaman}', [PengembalianController::class, 'create'])
        ->name('pengembalian.create');

    Route::post('/pengembalian/{idPeminjaman}', [PengembalianController::class, 'store'])
        ->name('pengembalian.store');

});

Route::get('/admin/profil', [\App\Http\Controllers\Admin\ProfilController::class, 'edit'])->middleware('auth:admin')->name('admin.profil.edit');

Route::put('/admin/profil', [\App\Http\Controllers\Admin\ProfilController::class, 'update'])->middleware('auth:admin')->name('admin.profil.update');

Route::get('/peminjam/kategori', [\App\Http\Controllers\Peminjam\KategoriController::class, 'index'])->middleware('auth:peminjam')->name('peminjam.kategori.index');

Route::get('/peminjam/profil', [\App\Http\Controllers\Peminjam\ProfilController::class, 'edit'])->middleware('auth:peminjam')->name('peminjam.profil.edit');

Route::put('/peminjam/profil', [\App\Http\Controllers\Peminjam\ProfilController::class, 'update'])->middleware('auth:peminjam')->name('peminjam.profil.update');
