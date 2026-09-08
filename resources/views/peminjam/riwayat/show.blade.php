@extends('layouts.peminjam')

@section('page-title', __('Detail Riwayat Peminjaman'))
@section('page-subtitle', __('Dashboard Peminjam/ Riwayat Peminjaman/ Detail'))

@section('content')
<div class="card">
    <div class="card-body">
        <div class="mb-3">
            <div class="text-muted small">{{ __('Barang') }}</div>
            <div>{{ $peminjaman->detailPeminjamans->pluck('barang.nama_barang')->join(', ') }}</div>
        </div>
        <div class="mb-3">
            <div class="text-muted small">{{ __('Jumlah') }}</div>
            <div>{{ $peminjaman->detailPeminjamans->sum('jumlah') }}</div>
        </div>
        <div class="mb-3">
            <div class="text-muted small">{{ __('Tgl Pinjam - Kembali') }}</div>
            <div>
                {{ \Carbon\Carbon::parse($peminjaman->tanggal_pinjam)->format('d M Y') }} -
                {{ \Carbon\Carbon::parse($peminjaman->tanggal_rencana_kembali)->format('d M Y') }}
            </div>
        </div>
        <div class="mb-3">
            <div class="text-muted small">{{ __('Status') }}</div>
            <span class="badge {{ $peminjaman->status === 'Ditolak' ? 'bg-danger' : 'bg-success' }}">
                {{ $peminjaman->status === 'Ditolak' ? __('Ditolak') : __('Selesai') }}
            </span>
        </div>

        @if ($peminjaman->status === 'dikembalikan' && $peminjaman->pengembalians->isNotEmpty())
            <div class="mb-4">
                <div class="text-muted small">{{ __('Kondisi Saat Dikembalikan') }}</div>
                <div>{{ $peminjaman->pengembalians->first()->kondisi_barang }}</div>
            </div>
        @elseif ($peminjaman->status === 'Ditolak')
            <div class="mb-4">
                <div class="text-muted small">{{ __('Catatan Admin') }}</div>
                <div>{{ $peminjaman->catatan_admin ?? '-' }}</div>
            </div>
        @endif

        <a href="{{ route('peminjam.riwayat.index') }}" class="btn btn-outline-secondary">{{ __('Kembali ke Riwayat') }}</a>
    </div>
</div>
@endsection
