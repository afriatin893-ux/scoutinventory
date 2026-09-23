@extends('layouts.peminjam')

@section('page-title', __('Detail Status Peminjaman'))
@section('page-subtitle', __('Dashboard Peminjam / Status Peminjaman / Detail'))
@section('page-icon')
    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="20" height="20" fill="none" stroke="currentColor" stroke-width="2">
        <circle cx="12" cy="12" r="9"/><path d="M12 7v5l3 2"/>
    </svg>
@endsection

@section('content')
<div class="tab-pills">
    @foreach (['Diajukan' => 'Diajukan', 'Disetujui' => 'Diverifikasi', 'dipinjam' => 'Dipinjam', 'dikembalikan' => 'Dikembalikan'] as $value => $label)
        <span class="tab-pill {{ $peminjaman->status === $value ? 'active' : 'disabled' }}">
            {{ $label }}
        </span>
    @endforeach
</div>

<div class="panel">
    <div class="panel-body">
        <div class="info-grid">
            <div class="full">
                <div class="info-label">{{ __('Barang') }}</div>
                <div class="info-value" style="font-weight:400;">{{ $peminjaman->detailPeminjamans->pluck('barang.nama_barang')->join(', ') }}</div>
            </div>
            <div>
                <div class="info-label">{{ __('Jumlah') }}</div>
                <div class="info-value" style="font-weight:400;">{{ $peminjaman->detailPeminjamans->sum('jumlah') }}</div>
            </div>
            <div>
                <div class="info-label">{{ __('Status') }}</div>
                <span class="badge-pill badge-info">
                    @switch($peminjaman->status)
                        @case('Diajukan')
                            {{ __('Menunggu Verifikasi Admin') }}
                            @break
                        @case('Disetujui')
                            {{ __('Disetujui, Menunggu Diambil') }}
                            @break
                        @case('dipinjam')
                            {{ __('Sedang Dipinjam') }}
                            @break
                        @default
                            {{ ucfirst($peminjaman->status) }}
                    @endswitch
                </span>
            </div>
            <div class="full">
                <div class="info-label">{{ __('Tgl Pinjam - Kembali') }}</div>
                <div class="info-value" style="font-weight:400;">
                    {{ \Carbon\Carbon::parse($peminjaman->tanggal_pinjam)->format('d M Y') }} &ndash;
                    {{ \Carbon\Carbon::parse($peminjaman->tanggal_rencana_kembali)->format('d M Y') }}
                </div>
            </div>
            <div class="full">
                <div class="info-label">{{ __('Keterangan') }}</div>
                <div class="info-value" style="font-weight:400;">{{ $peminjaman->keperluan }}</div>
            </div>
            <div class="full">
                <div class="info-label">{{ __('Penanggung Jawab') }}</div>
                <div class="info-value" style="font-weight:400;">{{ $peminjaman->penanggung_jawab ?? '-' }}</div>
            </div>
        </div>
    </div>
</div>

<a href="{{ route('peminjam.status.index') }}" class="back-link">
    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="14" height="14" fill="none" stroke="currentColor" stroke-width="2.4"><path d="M19 12H5M11 18l-6-6 6-6"/></svg>
    {{ __('Kembali') }}
</a>
@endsection
