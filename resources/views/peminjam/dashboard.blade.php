@extends('layouts.peminjam')

@section('content')
    <h1 class="dash-welcome">{{ __('Selamat Datang, :nama!', ['nama' => $peminjam->nama]) }} 👋</h1>

    <div class="dash-stats">
        <div class="dash-stat">
            <svg viewBox="0 0 64 64" width="72" height="72" fill="none" aria-hidden="true">
                <path d="M6 18a4 4 0 0 1 4-4h14l6 7h24a4 4 0 0 1 4 4v25a4 4 0 0 1-4 4H10a4 4 0 0 1-4-4V18Z" fill="#c99a6b"/>
                <path d="M6 28a4 4 0 0 1 4-4h44a4 4 0 0 1 4 4v21a4 4 0 0 1-4 4H10a4 4 0 0 1-4-4V28Z" fill="#a5673f"/>
            </svg>
            <div>
                <div class="dash-stat-label">{{ __('Kategori Tersedia') }}</div>
                <div class="dash-stat-value">{{ $totalKategori }}</div>
            </div>
        </div>

        <div class="dash-stat">
            <svg viewBox="0 0 64 64" width="72" height="72" fill="none" aria-hidden="true">
                <path d="M32 6 8 18l24 12 24-12L32 6Z" fill="#e8c9a0"/>
                <path d="M32 30v28L8 46V18l24 12Z" fill="#a5673f"/>
                <path d="M32 30v28l24-12V18L32 30Z" fill="#c08454"/>
            </svg>
            <div>
                <div class="dash-stat-label">{{ __('Jenis Barang') }}</div>
                <div class="dash-stat-value">{{ $totalBarang }}</div>
            </div>
        </div>
    </div>

    <h2 class="dash-section-title">{{ __('Menu Cepat') }}</h2>

    <div class="dash-menu">
        <a href="{{ route('peminjam.barang.index') }}" class="dash-menu-card">
            <span class="dash-menu-icon">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="32" height="32" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
                    <circle cx="11" cy="11" r="7"/><path d="m21 21-4.3-4.3"/>
                </svg>
            </span>
            <div class="dash-menu-title">{{ __('Lihat Barang Tersedia') }}</div>
            <div class="dash-menu-desc">{{ __('Cek katalog peralatan yang dapat dipinjam.') }}</div>
        </a>

        <a href="{{ route('peminjam.peminjaman.create') }}" class="dash-menu-card">
            <span class="dash-menu-icon">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="32" height="32" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M14 3H7a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h10a2 2 0 0 0 2-2V8Z"/><path d="M14 3v5h5"/><path d="M12 12v6"/><path d="M9 15h6"/>
                </svg>
            </span>
            <div class="dash-menu-title">{{ __('Ajukan Peminjaman') }}</div>
            <div class="dash-menu-desc">{{ __('Mulai formulir pengajuan peminjaman barang.') }}</div>
        </a>

        <a href="{{ route('peminjam.status.index') }}" class="dash-menu-card">
            <span class="dash-menu-icon">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="32" height="32" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
                    <rect x="8" y="2" width="8" height="4" rx="1"/><path d="M16 4h2a2 2 0 0 1 2 2v14a2 2 0 0 1-2 2H6a2 2 0 0 1-2-2V6a2 2 0 0 1 2-2h2"/><path d="m9 14 2 2 4-4"/>
                </svg>
            </span>
            <div class="dash-menu-title">{{ __('Status Peminjaman') }}</div>
            <div class="dash-menu-desc">{{ __('Pantau pengajuan peminjaman Anda.') }}</div>
        </a>
    </div>
@endsection
