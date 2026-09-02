@extends('layouts.app')

@section('content')
<div class="container">
    <div class="mb-4">
        <h1 class="h4 mb-1">{{ __('Selamat datang, :nama', ['nama' => $peminjam->nama]) }}</h1>
        <p class="text-muted mb-0">{{ __('Sistem Peminjaman Inventaris Pramuka') }}</p>
    </div>

    <div class="row g-3 mb-4">
        <div class="col-6 col-md-4">
            <div class="card h-100">
                <div class="card-body">
                    <div class="text-muted small">{{ __('Kategori Tersedia') }}</div>
                    <div class="fs-3 fw-bold">{{ $totalKategori }}</div>
                </div>
            </div>
        </div>

        <div class="col-6 col-md-4">
            <div class="card h-100">
                <div class="card-body">
                    <div class="text-muted small">{{ __('Jenis Barang') }}</div>
                    <div class="fs-3 fw-bold">{{ $totalBarang }}</div>
                </div>
            </div>
        </div>
    </div>

    <div class="card">
        <div class="card-header">{{ __('Menu Cepat') }}</div>
        <div class="card-body">
            <div class="d-flex flex-wrap gap-2">
                <a href="{{ route('peminjam.barang.index') }}" class="btn btn-outline-primary">
                    {{ __('Lihat Barang Tersedia') }}
                </a>
                <a href="{{ route('peminjam.profil.edit') }}" class="btn btn-outline-primary">
                    {{ __('Kelola Profil Saya') }}
                </a>
                <a href="{{ route('peminjam.peminjaman.create') }}" class="btn btn-outline-primary">
                    {{ __('Ajukan Peminjaman') }}
                </a>
                <a href="{{ route('peminjam.peminjaman.index') }}" class="btn btn-outline-primary">
                    {{ __('Riwayat Peminjaman') }}
                </a>
            </div>
        </div>
    </div>
</div>
@endsection
