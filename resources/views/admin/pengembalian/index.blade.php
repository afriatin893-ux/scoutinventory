@extends('layouts.admin')

@section('page-title', __('Catat Pengembalian'))
@section('page-subtitle', __('Dashboard Admin / Catat Pengembalian'))
@section('page-icon')
    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="20" height="20" fill="none" stroke="currentColor" stroke-width="2">
        <path d="M3 12a9 9 0 1 0 9-9 9.75 9.75 0 0 0-6.74 2.74L3 8"/><path d="M3 3v5h5"/><path d="M12 7v5l4 2"/>
    </svg>
@endsection

@section('content')
@if (session('error'))
    <div class="alert alert-danger">{{ session('error') }}</div>
@endif

<div class="panel">
    <div class="panel-header">
        <span class="panel-header-icon">
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="16" height="16" fill="none" stroke="currentColor" stroke-width="2"><path d="M3 12a9 9 0 1 0 9-9 9.75 9.75 0 0 0-6.74 2.74L3 8"/><path d="M3 3v5h5"/><path d="M12 7v5l4 2"/></svg>
        </span>
        {{ __('Sedang Dipinjam') }}
        <span class="panel-header-count">{{ $peminjamans->total() }} {{ __('barang') }}</span>
    </div>
    <div style="overflow-x:auto;">
        <table class="data-table">
            <thead>
                <tr>
                    <th style="width:50px;">{{ __('No') }}</th>
                    <th>{{ __('Peminjam') }}</th>
                    <th>{{ __('Barang') }}</th>
                    <th>{{ __('Tgl Pinjam') }}</th>
                    <th>{{ __('Tgl Rencana Kembali') }}</th>
                    <th style="width:180px;">{{ __('Aksi') }}</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($peminjamans as $peminjaman)
                    <tr>
                        <td class="cell-muted">{{ $loop->iteration + ($peminjamans->currentPage() - 1) * $peminjamans->perPage() }}</td>
                        <td class="cell-primary">{{ $peminjaman->peminjam->nama }}</td>
                        <td class="cell-muted">{{ $peminjaman->detailPeminjamans->pluck('barang.nama_barang')->join(', ') }}</td>
                        <td class="cell-muted">{{ \Carbon\Carbon::parse($peminjaman->tanggal_pinjam)->format('d M Y') }}</td>
                        <td class="cell-muted">
                            {{ \Carbon\Carbon::parse($peminjaman->tanggal_rencana_kembali)->format('d M Y') }}
                            @if (\Carbon\Carbon::parse($peminjaman->tanggal_rencana_kembali)->isPast())
                                <span class="late-tag">{{ __('Terlambat') }}</span>
                            @endif
                        </td>
                        <td>
                            <a href="{{ route('admin.pengembalian.create', $peminjaman->id_peminjaman) }}" class="btn btn-primary btn-sm">
                                {{ __('Catat Pengembalian') }}
                            </a>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="empty-state">
                            <div class="empty-state-inner">
                                <span class="empty-state-icon">
                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="24" height="24" fill="none" stroke="currentColor" stroke-width="1.8">
                                        <path d="M3 12a9 9 0 1 0 9-9 9.75 9.75 0 0 0-6.74 2.74L3 8"/><path d="M3 3v5h5"/><path d="M12 7v5l4 2"/>
                                    </svg>
                                </span>
                                <p class="empty-state-title">{{ __('Tidak ada barang yang sedang dipinjam') }}</p>
                                <p class="empty-state-text">{{ __('Barang yang sedang dipinjam dan menunggu pengembalian akan muncul di sini.') }}</p>
                            </div>
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

<div class="pagination-wrap">{{ $peminjamans->links() }}</div>
@endsection
