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

<div class="panel">
    <div class="panel-header">
        <span class="panel-header-icon">
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="16" height="16" fill="none" stroke="currentColor" stroke-width="2"><path d="m21 8-9-5-9 5 9 5 9-5Z"/><path d="M3 8v8l9 5 9-5V8"/><path d="M12 13v8"/></svg>
        </span>
        {{ __('Daftar Barang') }}
        <span class="panel-header-count">{{ $barangs->total() }} {{ __('barang') }}</span>
    </div>
    <div style="overflow-x:auto;">
        <table class="data-table">
            <thead>
                <tr>
                    <th style="width:50px;">No</th>
                    <th style="width:60px;">{{ __('Foto') }}</th>
                    <th>{{ __('Nama Barang') }}</th>
                    <th>{{ __('Kategori') }}</th>
                    <th>{{ __('Stok Tersedia') }}</th>
                    <th>{{ __('Kondisi') }}</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($barangs as $barang)
                    <tr>
                        <td class="cell-muted">{{ $loop->iteration + ($barangs->currentPage() - 1) * $barangs->perPage() }}</td>
                        <td>
                            @if ($barang->foto)
                                <img src="{{ asset('storage/' . $barang->foto) }}" alt="{{ $barang->nama_barang }}" class="thumb-sm">
                            @else
                                <span class="thumb-placeholder">-</span>
                            @endif
                        </td>
                        <td class="cell-primary">{{ $barang->nama_barang }}</td>
                        <td>
                            <span class="tag-pill">
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="12" height="12" fill="none" stroke="currentColor" stroke-width="2.4"><path d="M20.59 13.41 11 3.83A2 2 0 0 0 9.59 3.24H4a1 1 0 0 0-1 1v5.59a2 2 0 0 0 .59 1.41l9.58 9.58a2 2 0 0 0 2.83 0l5.59-5.59a2 2 0 0 0 0-2.82Z"/></svg>
                                {{ $barang->kategori->nama_kategori ?? '-' }}
                            </span>
                        </td>
                        <td class="cell-primary">{{ $barang->stok }}</td>
                        <td>
                            @php
                                $badgeClass = match($barang->kondisi) {
                                    'Baik' => 'badge-good',
                                    'Rusak Ringan' => 'badge-warn',
                                    default => 'badge-bad',
                                };
                            @endphp
                            <span class="badge-pill {{ $badgeClass }}">{{ $barang->kondisi }}</span>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="empty-state">
                            <div class="empty-state-inner">
                                <span class="empty-state-icon">
                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="24" height="24" fill="none" stroke="currentColor" stroke-width="1.8">
                                        <path d="m21 8-9-5-9 5 9 5 9-5Z"/><path d="M3 8v8l9 5 9-5V8"/><path d="M12 13v8"/>
                                    </svg>
                                </span>
                                <p class="empty-state-title">{{ __('Belum ada barang') }}</p>
                                <p class="empty-state-text">{{ __('Barang inventaris yang tersedia akan muncul di sini.') }}</p>
                            </div>
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

<div class="pagination-wrap">{{ $barangs->links() }}</div>
@endsection
