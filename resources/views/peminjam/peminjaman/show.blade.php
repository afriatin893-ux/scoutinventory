@extends('layouts.peminjam')

@section('page-title', __('Detail Peminjaman'))
@section('page-subtitle', __('Dashboard Peminjam / Status & Riwayat Peminjaman / Detail'))
@section('page-icon')
    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="20" height="20" fill="none" stroke="currentColor" stroke-width="2">
        <path d="M9 11 12 14 22 4"/><path d="M21 12v7a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h11"/>
    </svg>
@endsection

@section('content')
@php
    $statusBadge = match($peminjaman->status) {
        'Diajukan' => 'badge-warn',
        'Disetujui' => 'badge-info',
        'dipinjam' => 'badge-good',
        'Ditolak', 'ditolak' => 'badge-bad',
        'dikembalikan' => 'badge-good',
        default => 'badge-info',
    };
@endphp

<div class="panel">
    <div class="panel-body">
        <div class="info-grid">
            <div>
                <div class="info-label">{{ __('Status') }}</div>
                <span class="badge-pill {{ $statusBadge }}">{{ ucfirst($peminjaman->status) }}</span>
            </div>
            <div>
                <div class="info-label">{{ __('Penanggung Jawab') }}</div>
                <div class="info-value" style="font-weight:400;">{{ $peminjaman->penanggung_jawab ?? '-' }}</div>
            </div>
            <div>
                <div class="info-label">{{ __('Tanggal Pinjam') }}</div>
                <div class="info-value" style="font-weight:400;">{{ \Carbon\Carbon::parse($peminjaman->tanggal_pinjam)->format('d M Y') }}</div>
            </div>
            <div>
                <div class="info-label">{{ __('Rencana Kembali') }}</div>
                <div class="info-value" style="font-weight:400;">{{ \Carbon\Carbon::parse($peminjaman->tanggal_rencana_kembali)->format('d M Y') }}</div>
            </div>
            <div class="full">
                <div class="info-label">{{ __('Keperluan') }}</div>
                <div class="info-value" style="font-weight:400;">{{ $peminjaman->keperluan }}</div>
            </div>
            @if ($peminjaman->catatan_admin)
                <div class="full">
                    <div class="info-label">{{ __('Catatan Admin') }}</div>
                    <div class="info-value" style="font-weight:400;">{{ $peminjaman->catatan_admin }}</div>
                </div>
            @endif
        </div>
    </div>
</div>

<div class="panel">
    <div class="panel-header">
        <span class="panel-header-icon">
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="16" height="16" fill="none" stroke="currentColor" stroke-width="2"><path d="m21 8-9-5-9 5 9 5 9-5Z"/><path d="M3 8v8l9 5 9-5V8"/><path d="M12 13v8"/></svg>
        </span>
        {{ __('Barang Diajukan') }}
    </div>
    <table class="data-table">
        <thead><tr><th>{{ __('Barang') }}</th><th style="width:120px;">{{ __('Jumlah') }}</th></tr></thead>
        <tbody>
            @foreach ($peminjaman->detailPeminjamans as $detail)
                <tr>
                    <td class="cell-primary">{{ $detail->barang->nama_barang ?? '-' }}</td>
                    <td>{{ $detail->jumlah }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>

@if ($peminjaman->pengembalians->isNotEmpty())
    @php $pengembalian = $peminjaman->pengembalians->first(); @endphp
    <div class="action-panel">
        <div class="action-panel-header">
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="16" height="16" fill="none" stroke="currentColor" stroke-width="2"><path d="M3 12a9 9 0 1 0 9-9 9.75 9.75 0 0 0-6.74 2.74L3 8"/><path d="M3 3v5h5"/><path d="M12 7v5l4 2"/></svg>
            {{ __('Detail Pengembalian') }}
        </div>
        <div class="action-panel-body">
            <div class="info-grid">
                <div>
                    <div class="info-label">{{ __('Tanggal') }}</div>
                    <div class="info-value" style="font-weight:400;">{{ \Carbon\Carbon::parse($pengembalian->tanggal_pengembalian)->format('d M Y') }}</div>
                </div>
                <div>
                    <div class="info-label">{{ __('Jumlah Kembali') }}</div>
                    <div class="info-value" style="font-weight:400;">{{ $pengembalian->jumlah_kembali }}</div>
                </div>
                <div>
                    <div class="info-label">{{ __('Kondisi') }}</div>
                    <div class="info-value" style="font-weight:400;">{{ $pengembalian->kondisi_barang }}</div>
                </div>
            </div>
        </div>
    </div>
@endif

<a href="{{ route('peminjam.peminjaman.index') }}" class="back-link">
    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="14" height="14" fill="none" stroke="currentColor" stroke-width="2.4"><path d="M19 12H5M11 18l-6-6 6-6"/></svg>
    {{ __('Kembali ke daftar') }}
</a>
@endsection
