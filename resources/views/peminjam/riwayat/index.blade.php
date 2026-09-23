@extends('layouts.peminjam')

@section('page-title', __('Riwayat Peminjaman'))
@section('page-subtitle', __('Dashboard Peminjam / Riwayat Peminjaman'))
@section('page-icon')
    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="20" height="20" fill="none" stroke="currentColor" stroke-width="2">
        <path d="M8 6h13"/><path d="M8 12h13"/><path d="M8 18h13"/><path d="M3 6h.01"/><path d="M3 12h.01"/><path d="M3 18h.01"/>
    </svg>
@endsection

@section('content')
<div class="panel">
    <div class="panel-header">
        <span class="panel-header-icon">
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="16" height="16" fill="none" stroke="currentColor" stroke-width="2"><path d="M8 6h13"/><path d="M8 12h13"/><path d="M8 18h13"/><path d="M3 6h.01"/><path d="M3 12h.01"/><path d="M3 18h.01"/></svg>
        </span>
        {{ __('Riwayat Peminjaman') }}
        <span class="panel-header-count">{{ $peminjamans->total() }} {{ __('data') }}</span>
    </div>
    <div style="overflow-x:auto;">
        <table class="data-table">
            <thead>
                <tr>
                    <th>{{ __('Tanggal Pinjam') }}</th>
                    <th>{{ __('Rencana Kembali') }}</th>
                    <th>{{ __('Barang') }}</th>
                    <th>{{ __('Status') }}</th>
                    <th style="width:110px;">{{ __('Aksi') }}</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($peminjamans as $peminjaman)
                    <tr>
                        <td class="cell-muted">{{ \Carbon\Carbon::parse($peminjaman->tanggal_pinjam)->format('d M Y') }}</td>
                        <td class="cell-muted">{{ \Carbon\Carbon::parse($peminjaman->tanggal_rencana_kembali)->format('d M Y') }}</td>
                        <td class="cell-muted">
                            @foreach ($peminjaman->detailPeminjamans as $detail)
                                {{ $detail->barang->nama_barang ?? '-' }} ({{ $detail->jumlah }})@if (!$loop->last), @endif
                            @endforeach
                        </td>
                        <td>
                            <span class="badge-pill {{ $peminjaman->status === 'Ditolak' ? 'badge-bad' : 'badge-good' }}">
                                {{ $peminjaman->status === 'Ditolak' ? __('Ditolak') : __('Selesai') }}
                            </span>
                        </td>
                        <td>
                            <a href="{{ route('peminjam.riwayat.show', $peminjaman->id_peminjaman) }}" class="btn btn-outline btn-sm">
                                {{ __('Detail') }}
                            </a>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="empty-state">
                            <div class="empty-state-inner">
                                <span class="empty-state-icon">
                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="24" height="24" fill="none" stroke="currentColor" stroke-width="1.8">
                                        <path d="M8 6h13"/><path d="M8 12h13"/><path d="M8 18h13"/><path d="M3 6h.01"/><path d="M3 12h.01"/><path d="M3 18h.01"/>
                                    </svg>
                                </span>
                                <p class="empty-state-title">{{ __('Belum ada riwayat') }}</p>
                                <p class="empty-state-text">{{ __('Peminjaman yang sudah selesai atau ditolak akan muncul di sini.') }}</p>
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
