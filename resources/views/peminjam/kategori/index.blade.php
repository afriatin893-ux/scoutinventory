@extends('layouts.peminjam')

@section('page-title', __('Kategori Barang'))
@section('page-subtitle', __('Dashboard Peminjam / Kategori Barang'))
@section('page-icon')
    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="20" height="20" fill="none" stroke="currentColor" stroke-width="2">
        <path d="M20.59 13.41 11 3.83A2 2 0 0 0 9.59 3.24H4a1 1 0 0 0-1 1v5.59a2 2 0 0 0 .59 1.41l9.58 9.58a2 2 0 0 0 2.83 0l5.59-5.59a2 2 0 0 0 0-2.82Z"/>
        <circle cx="7.5" cy="7.5" r="1.2"/>
    </svg>
@endsection

@section('content')
<div class="panel">
    <div class="panel-header">
        <span class="panel-header-icon">
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="16" height="16" fill="none" stroke="currentColor" stroke-width="2">
                <path d="M20.59 13.41 11 3.83A2 2 0 0 0 9.59 3.24H4a1 1 0 0 0-1 1v5.59a2 2 0 0 0 .59 1.41l9.58 9.58a2 2 0 0 0 2.83 0l5.59-5.59a2 2 0 0 0 0-2.82Z"/>
                <circle cx="7.5" cy="7.5" r="1.2"/>
            </svg>
        </span>
        {{ __('Daftar Kategori') }}
        <span class="panel-header-count">{{ $categories->total() }} {{ __('kategori') }}</span>
    </div>
    <div style="overflow-x:auto;">
        <table class="data-table">
            <thead>
                <tr>
                    <th style="width:60px;">{{ __('No') }}</th>
                    <th>{{ __('Nama Kategori') }}</th>
                    <th style="width:160px;">{{ __('Jumlah Barang') }}</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($categories as $kategori)
                    <tr>
                        <td class="cell-muted">{{ $loop->iteration + ($categories->currentPage() - 1) * $categories->perPage() }}</td>
                        <td class="cell-primary">{{ $kategori->nama_kategori }}</td>
                        <td>
                            <span class="tag-pill">
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="12" height="12" fill="none" stroke="currentColor" stroke-width="2.4"><path d="m21 8-9-5-9 5 9 5 9-5Z"/><path d="M3 8v8l9 5 9-5V8"/></svg>
                                {{ $kategori->barangs_count }}
                            </span>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="3" class="empty-state">
                            <div class="empty-state-inner">
                                <span class="empty-state-icon">
                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="24" height="24" fill="none" stroke="currentColor" stroke-width="1.8">
                                        <path d="M20.59 13.41 11 3.83A2 2 0 0 0 9.59 3.24H4a1 1 0 0 0-1 1v5.59a2 2 0 0 0 .59 1.41l9.58 9.58a2 2 0 0 0 2.83 0l5.59-5.59a2 2 0 0 0 0-2.82Z"/>
                                    </svg>
                                </span>
                                <p class="empty-state-title">{{ __('Belum ada kategori') }}</p>
                                <p class="empty-state-text">{{ __('Kategori barang yang tersedia akan muncul di sini.') }}</p>
                            </div>
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

<div class="pagination-wrap">{{ $categories->links() }}</div>
@endsection
