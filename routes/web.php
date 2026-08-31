<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Admin\KategoriController as AdminKategoriController;
use App\Http\Controllers\Peminjam\KategoriController as PeminjamKategoriController;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/login', [LoginController::class, 'showLogin'])
    ->name('login');

Route::post('/login', [LoginController::class, 'login'])
    ->name('login.proses');

Route::post('/logout', [LoginController::class, 'logout'])
    ->name('logout');

Route::get('/register', [RegisterController::class, 'showRegistrationForm'])
    ->name('register');

Route::post('/register', [RegisterController::class, 'register']);

Route::get('/admin/dashboard', function () {
    return 'Selamat datang Admin';
})->middleware('auth:admin')->name('admin.dashboard');

Route::get('/peminjam/dashboard', function () {
    return 'Selamat datang Peminjam';
})->middleware('auth:peminjam')->name('peminjam.dashboard');

Route::middleware('auth:admin')->prefix('admin')->name('admin.')->group(function () {
    Route::resource('kategori', AdminKategoriController::class)
        ->parameters(['kategori' => 'kategori'])
        ->except(['show']);
});

Route::middleware('auth:peminjam')->prefix('peminjam')->name('peminjam.')->group(function () {
    Route::get('kategori', [PeminjamKategoriController::class, 'index'])->name('kategori.index');
});
