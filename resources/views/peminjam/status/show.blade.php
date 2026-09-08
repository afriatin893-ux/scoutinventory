@extends('layouts.peminjam')

@section('page-title', __('Detail Status Peminjaman'))
@section('page-subtitle', __('Dashboard Peminjam/ Status Peminjaman/ Detail'))

@section('content')
<div class="d-flex flex-wrap gap-2 mb-4">
    @foreach (['Diajukan' => 'Diajukan', 'Disetujui' => 'Diverifikasi', 'dipinjam' => 'Dipinjam', 'dikembalikan' => 'Dikembalikan'] as $value => $label)
        <span class="btn btn-sm {{ $peminjaman->status === $value ? 'btn-primary' : 'btn-outline-secondary disabled' }}">
            {{ $label }}
        </span>
    @endforeach
</div>

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
            <span class="badge bg-secondary">
                @switch($peminjaman->status)
                    @case('Diajukan') {{ __('MENUNGGU VERIFIKASI ADMIN') }} @break
                    @case('Disetujui') {{ __('DISETUJUI, MENUNGGU DIAMBIL') }} @break
                    @case('dipinjam') {{ __('SEDANG DIPINJAM') }} @break
                    @default {{ strtoupper($peminjaman->status) }}
                @endswitch
            </span>
        </div>
        <div class="mb-4">
            <div class="text-muted small">{{ __('Keterangan') }}</div>
            <div>{{ $peminjaman->keperluan }}</div>
        </div>

        <a href="{{ route('peminjam.status.index') }}" class="btn btn-outline-secondary">{{ __('Kembali') }}</a>
    </div>
</div>
@endsection
