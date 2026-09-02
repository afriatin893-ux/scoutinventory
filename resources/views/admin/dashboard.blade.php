@extends('layouts.app')

@section('content')
<div class="container">
    <div class="mb-4">
        <h1 class="h4 mb-1">{{ __('Selamat datang, :nama', ['nama' => $admin->nama]) }}</h1>
        <p class="text-muted mb-0">{{ __('Ringkasan Sistem Peminjaman Inventaris Pramuka') }}</p>
    </div>

    <div class="row g-3 mb-4">
        <div class="col-6 col-md-3">
            <div class="card h-100">
                <div class="card-body">
                    <div class="text-muted small">{{ __('Total Kategori') }}</div>
                    <div class="fs-3 fw-bold">{{ $totalKategori }}</div>
                </div>
            </div>
        </div>

        <div class="col-6 col-md-3">
            <div class="card h-100">
                <div class="card-body">
                    <div class="text-muted small">{{ __('Jenis Barang') }}</div>
                    <div class="fs-3 fw-bold">{{ $totalBarang }}</div>
                </div>
            </div>
        </div>

        <div class="col-6 col-md-3">
            <div class="card h-100">
                <div class="card-body">
                    <div class="text-muted small">{{ __('Total Stok') }}</div>
                    <div class="fs-3 fw-bold">{{ $totalStok ?? 0 }}</div>
                </div>
            </div>
        </div>

        <div class="col-6 col-md-3">
            <div class="card h-100">
                <div class="card-body">
                    <div class="text-muted small">{{ __('Peminjam Terdaftar') }}</div>
                    <div class="fs-3 fw-bold">{{ $totalPeminjam }}</div>
                </div>
            </div>
        </div>
    </div>

    <div class="card">
        <div class="card-header">{{ __('Menu Cepat') }}</div>
        <div class="card-body">
            <div class="d-flex flex-wrap gap-2">
                <a href="{{ route('admin.kategori.index') }}" class="btn btn-outline-primary">
                    {{ __('Kelola Kategori Barang') }}
                </a>
                <a href="{{ route('admin.profil.edit') }}" class="btn btn-outline-primary">
                    {{ __('Kelola Profil Admin') }}
                </a>
                <a href="{{ route('admin.barang.index') }}" class="btn btn-outline-primary">
                    {{ __('Kelola Data Barang') }}
                </a>
                <a href="{{ route('admin.peminjaman.pending') }}" class="btn btn-outline-primary">
                    {{ __('Verifikasi Pengajuan') }}
                </a>
            </div>
        </div>
    </div>
</div>
@endsection
