@extends('layouts.peminjam')

@section('page-title', __('Daftar Barang Tersedia'))
@section('page-subtitle', __('Dashboard Peminjam / Lihat Barang'))
@section('page-icon')
    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="20" height="20" fill="none" stroke="currentColor" stroke-width="2">
        <path d="m21 8-9-5-9 5 9 5 9-5Z"/><path d="M3 8v8l9 5 9-5V8"/><path d="M12 13v8"/>
    </svg>
@endsection

@section('content')
<div class="toolbar-row">
    <form method="GET">
        <select name="id_kategori" class="filter-select" onchange="this.form.submit()">
            <option value="">{{ __('Semua Kategori') }}</option>
            @foreach ($categories as $kategori)
                <option value="{{ $kategori->id_kategori }}" {{ request('id_kategori') == $kategori->id_kategori ? 'selected' : '' }}>
                    {{ $kategori->nama_kategori }}
                </option>
            @endforeach
        </select>
    </form>

    <a href="{{ route('peminjam.peminjaman.create') }}" class="btn btn-primary">
        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="15" height="15" fill="none" stroke="currentColor" stroke-width="2.4"><path d="M12 5v14M5 12h14"/></svg>
        {{ __('Ajukan Peminjaman') }}
    </a>
</div>

<div class="catalog-head">
    <span class="catalog-title">{{ __('Daftar Barang') }}</span>
    <span class="panel-header-count">{{ $barangs->total() }} {{ __('barang') }}</span>
</div>

@if ($barangs->count())
    <div class="catalog-grid">
        @foreach ($barangs as $barang)
            @php
                $badgeClass = match($barang->kondisi) {
                    'Baik' => 'badge-good',
                    'Rusak Ringan' => 'badge-warn',
                    default => 'badge-bad',
                };
            @endphp
            <div class="catalog-card">
                <div class="catalog-photo">
                    @if ($barang->foto)
                        <img src="{{ asset('storage/' . $barang->foto) }}" alt="{{ $barang->nama_barang }}">
                    @else
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="34" height="34" fill="none" stroke="currentColor" stroke-width="1.6">
                            <path d="m21 8-9-5-9 5 9 5 9-5Z"/><path d="M3 8v8l9 5 9-5V8"/><path d="M12 13v8"/>
                        </svg>
                    @endif
                </div>

                <div class="catalog-body">
                    <span class="tag-pill">{{ $barang->kategori->nama_kategori ?? '-' }}</span>
                    <div class="catalog-name">{{ $barang->nama_barang }}</div>
                    @if ($barang->lokasi)
                        <div class="catalog-meta">{{ $barang->lokasi }}</div>
                    @endif

                    <div class="catalog-foot">
                        <div>
                            <div class="catalog-meta">{{ __('Stok tersedia') }}</div>
                            <div class="catalog-stok">{{ $barang->stok }}</div>
                        </div>
                        <span class="badge-pill {{ $badgeClass }}">{{ $barang->kondisi }}</span>
                    </div>

                    @if ($barang->stok > 0)
                        <a href="{{ route('peminjam.peminjaman.create', ['barang' => $barang->id_barang]) }}"
                           class="btn btn-outline btn-sm catalog-btn">{{ __('Ajukan') }}</a>
                    @else
                        <span class="btn btn-outline btn-sm catalog-btn is-disabled">{{ __('Stok habis') }}</span>
                    @endif
                </div>
            </div>
        @endforeach
    </div>
@else
    <div class="panel">
        <div class="panel-body" style="text-align:center;">
            <p class="empty-state-title">{{ __('Belum ada barang') }}</p>
            <p class="empty-state-text">{{ __('Barang inventaris yang tersedia akan muncul di sini.') }}</p>
        </div>
    </div>
@endif

<div class="pagination-wrap">{{ $barangs->links() }}</div>
@endsection
