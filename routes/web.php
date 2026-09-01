<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/login', [\App\Http\Controllers\Auth\LoginController::class, 'showLogin'])->name('login');

Route::post('/login', [\App\Http\Controllers\Auth\LoginController::class, 'login'])->name('login.proses');

Route::post('/logout', [\App\Http\Controllers\Auth\LoginController::class, 'logout'])->name('logout');

Route::get('/register', [\App\Http\Controllers\Auth\RegisterController::class, 'showRegistrationForm'])->name('register');

Route::post('/register', [\App\Http\Controllers\Auth\RegisterController::class, 'register']);

Route::get('/admin/dashboard', function () {
    return 'Selamat datang Admin';
})->middleware('auth:admin')->name('admin.dashboard');

Route::get('/peminjam/dashboard', function () {
    return 'Selamat datang Peminjam';
})->middleware('auth:peminjam')->name('peminjam.dashboard');

Route::get('/admin/kategori', [\App\Http\Controllers\Admin\KategoriController::class, 'index'])->middleware('auth:admin')->name('admin.kategori.index');

Route::get('/admin/kategori/create', [\App\Http\Controllers\Admin\KategoriController::class, 'create'])->middleware('auth:admin')->name('admin.kategori.create');

Route::post('/admin/kategori', [\App\Http\Controllers\Admin\KategoriController::class, 'store'])->middleware('auth:admin')->name('admin.kategori.store');

Route::get('/admin/kategori/{id}/edit', [\App\Http\Controllers\Admin\KategoriController::class, 'edit'])->middleware('auth:admin')->name('admin.kategori.edit');

Route::put('/admin/kategori/{id}', [\App\Http\Controllers\Admin\KategoriController::class, 'update'])->middleware('auth:admin')->name('admin.kategori.update');

Route::delete('/admin/kategori/{id}', [\App\Http\Controllers\Admin\KategoriController::class, 'destroy'])->middleware('auth:admin')->name('admin.kategori.destroy');

Route::get('/admin/profil', [\App\Http\Controllers\Admin\ProfilController::class, 'edit'])->middleware('auth:admin')->name('admin.profil.edit');

Route::put('/admin/profil', [\App\Http\Controllers\Admin\ProfilController::class, 'update'])->middleware('auth:admin')->name('admin.profil.update');

Route::get('/peminjam/kategori', [\App\Http\Controllers\Peminjam\KategoriController::class, 'index'])->middleware('auth:peminjam')->name('peminjam.kategori.index');

Route::get('/peminjam/profil', [\App\Http\Controllers\Peminjam\ProfilController::class, 'edit'])->middleware('auth:peminjam')->name('peminjam.profil.edit');

Route::put('/peminjam/profil', [\App\Http\Controllers\Peminjam\ProfilController::class, 'update'])->middleware('auth:peminjam')->name('peminjam.profil.update');
