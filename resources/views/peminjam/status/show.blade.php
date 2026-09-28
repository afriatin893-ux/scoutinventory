@extends('layouts.peminjam')

@section('page-title', __('Detail Status Peminjaman'))
@section('page-subtitle', __('Dashboard Peminjam / Status Peminjaman / Detail'))
@section('page-icon')
    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="20" height="20" fill="none" stroke="currentColor" stroke-width="2">
        <circle cx="12" cy="12" r="9"/><path d="M12 7v5l3 2"/>
    </svg>
@endsection

@section('content')
@php
    $steps = ['Diajukan' => 'Diajukan', 'Disetujui' => 'Diverifikasi', 'dipinjam' => 'Dipinjam', 'dikembalikan' => 'Dikembalikan'];
    $currentIndex = array_search($peminjaman->status, array_keys($steps));
    $currentIndex = $currentIndex === false ? -1 : $currentIndex;
    $statusText = match($peminjaman->status) {
        'Diajukan'  => 'Menunggu Verifikasi Admin',
        'Disetujui' => 'Disetujui, Menunggu Diambil',
        'dipinjam'  => 'Sedang Dipinjam',
        default     => ucfirst($peminjaman->status),
    };
@endphp

<div class="stepper">
    @foreach ($steps as $value => $label)
        <div class="step {{ $loop->index < $currentIndex ? 'done' : '' }} {{ $loop->index === $currentIndex ? 'current' : '' }}">
            <span class="step-dot">{{ $loop->index < $currentIndex ? '✓' : $loop->iteration }}</span>
            <span class="step-label">{{ $label }}</span>
        </div>
    @endforeach
</div>

<div class="split-2">
    <div class="panel">
        <div class="panel-header">
            {{ __('Barang yang Dipinjam') }}
            <span class="panel-header-count">{{ $peminjaman->detailPeminjamans->count() }} {{ __('jenis') }}</span>
        </div>
        <table class="data-table">
            <thead>
                <tr><th>{{ __('Barang') }}</th><th style="width:90px;">{{ __('Jumlah') }}</th></tr>
            </thead>
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

    <div class="panel">
        <div class="panel-header">{{ __('Informasi Peminjaman') }}</div>
        <div class="panel-body">
            <div class="info-grid">
                <div class="full">
                    <div class="info-label">{{ __('Status') }}</div>
                    <span class="badge-pill badge-info">{{ $statusText }}</span>
                </div>
                <div>
                    <div class="info-label">{{ __('Tgl Pinjam') }}</div>
                    <div class="info-value">{{ \Carbon\Carbon::parse($peminjaman->tanggal_pinjam)->format('d M Y') }}</div>
                </div>
                <div>
                    <div class="info-label">{{ __('Tgl Kembali') }}</div>
                    <div class="info-value">{{ \Carbon\Carbon::parse($peminjaman->tanggal_rencana_kembali)->format('d M Y') }}</div>
                </div>
                <div class="full">
                    <div class="info-label">{{ __('Keperluan') }}</div>
                    <div class="info-value" style="font-weight:400;">{{ $peminjaman->keperluan }}</div>
                </div>
                <div class="full">
                    <div class="info-label">{{ __('Penanggung Jawab') }}</div>
                    <div class="info-value" style="font-weight:400;">{{ $peminjaman->penanggung_jawab ?? '-' }}</div>
                </div>
            </div>
        </div>
    </div>
</div>

<a href="{{ route('peminjam.status.index') }}" class="back-link">
    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="14" height="14" fill="none" stroke="currentColor" stroke-width="2.4"><path d="M19 12H5M11 18l-6-6 6-6"/></svg>
    {{ __('Kembali') }}
</a>
@endsection
