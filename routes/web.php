<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});


Route::get('/login', [\App\Http\Controllers\Auth\LoginController::class, 'showLogin'])->name('login');

Route::post('/login', [\App\Http\Controllers\Auth\LoginController::class, 'login'])->name('login.proses');

Route::post('/logout', [\App\Http\Controllers\Auth\LoginController::class, 'logout'])->name('logout');

Route::get('/register', [\App\Http\Controllers\Auth\RegisterController::class, 'showRegistrationForm'])->name('register');

Route::post('/register', [\App\Http\Controllers\Auth\RegisterController::class, 'register'])->name('register.proses');


Route::prefix('admin')->name('admin.')->middleware('auth:admin')->group(function () {
Route::get('/dashboard', function () {return view('admin.dashboard');})->name('dashboard');
Route::resource('kategori', \App\Http\Controllers\Admin\KategoriController::class);
Route::resource('barang', \App\Http\Controllers\Admin\BarangController::class);
Route::get('/peminjaman', [\App\Http\Controllers\Admin\PeminjamanController::class, 'index'])->name('peminjaman.index');
Route::get('/peminjaman/{id}', [\App\Http\Controllers\Admin\PeminjamanController::class, 'show'])->name('peminjaman.show');
Route::put('/peminjaman/{id}', [\App\Http\Controllers\Admin\PeminjamanController::class, 'update'])->name('peminjaman.update');
Route::get('/peminjaman/{peminjaman}/pengembalian/create', [\App\Http\Controllers\Admin\PengembalianController::class, 'create'])->name('peminjaman.pengembalian.create');
Route::post('/peminjaman/{peminjaman}/pengembalian', [\App\Http\Controllers\Admin\PengembalianController::class, 'store'])->name('peminjaman.pengembalian.store');
Route::get('/profile', [\App\Http\Controllers\Admin\ProfileController::class, 'edit'])->name('profile.edit');
Route::put('/profile', [\App\Http\Controllers\Admin\ProfileController::class, 'update'])->name('profile.update');
});

Route::prefix('peminjam')->name('peminjam.')->middleware('auth:peminjam')->group(function () {
Route::get('/dashboard', function () {return view('peminjam.dashboard');})->name('dashboard');
Route::get('/barang', [\App\Http\Controllers\Peminjam\BarangController::class, 'index'])->name('barang.index');
Route::get('/barang/{id}', [\App\Http\Controllers\Peminjam\BarangController::class, 'show'])->name('barang.show');
Route::get('/peminjaman', [\App\Http\Controllers\Peminjam\PeminjamanController::class, 'index'])->name('peminjaman.index');
Route::get('/peminjaman/create', [\App\Http\Controllers\Peminjam\PeminjamanController::class, 'create'])->name('peminjaman.create');
Route::post('/peminjaman', [\App\Http\Controllers\Peminjam\PeminjamanController::class, 'store'])->name('peminjaman.store');
Route::get('/peminjaman/{id}', [\App\Http\Controllers\Peminjam\PeminjamanController::class, 'show'])->name('peminjaman.show');
Route::get('/profile', [\App\Http\Controllers\Peminjam\ProfileController::class, 'edit'])->name('profile.edit');
Route::put('/profile', [\App\Http\Controllers\Peminjam\ProfileController::class, 'update'])->name('profile.update');
});