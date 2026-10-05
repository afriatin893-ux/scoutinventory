@extends('layouts.peminjam')

@section('page-title', __('Detail Riwayat Peminjaman'))
@section('page-subtitle', __('Dashboard Peminjam / Riwayat Peminjaman / Detail'))
@section('page-icon')
    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="20" height="20" fill="none" stroke="currentColor"
        stroke-width="2">
        <path d="M8 6h13" />
        <path d="M8 12h13" />
        <path d="M8 18h13" />
        <path d="M3 6h.01" />
        <path d="M3 12h.01" />
        <path d="M3 18h.01" />
    </svg>
@endsection

@section('content')
    @php $ditolak = $peminjaman->status === 'Ditolak'; @endphp

    <div class="split-2">
        <div class="panel">
            <div class="panel-header">
                {{ __('Barang yang Dipinjam') }}
                <span class="panel-header-count">{{ $peminjaman->detailPeminjamans->count() }} {{ __('jenis') }}</span>
            </div>
            <table class="data-table">
                <thead>
                    <tr>
                        <th>{{ __('Barang') }}</th>
                        <th style="width:90px;">{{ __('Jumlah') }}</th>
                    </tr>
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
                        <span class="badge-pill {{ $ditolak ? 'badge-bad' : 'badge-good' }}">
                            {{ $ditolak ? __('Ditolak') : __('Selesai') }}
                        </span>
                    </div>
                    <div>
                        <div class="info-label">{{ __('Tgl Pinjam') }}</div>
                        <div class="info-value">{{ \Carbon\Carbon::parse($peminjaman->tanggal_pinjam)->format('d M Y') }}
                        </div>
                    </div>
                    <div>
                        <div class="info-label">{{ __('Rencana Kembali') }}</div>
                        <div class="info-value">
                            {{ \Carbon\Carbon::parse($peminjaman->tanggal_rencana_kembali)->format('d M Y') }}</div>
                    </div>
                    <div class="full">
                        <div class="info-label">{{ __('Penanggung Jawab') }}</div>
                        <div class="info-value" style="font-weight:400;">{{ $peminjaman->penanggung_jawab ?? '-' }}</div>
                    </div>

                    @if ($peminjaman->status === 'dikembalikan' && $peminjaman->pengembalians->isNotEmpty())
                        @php $pengembalian = $peminjaman->pengembalians->first(); @endphp
                        <div>
                            <div class="info-label">{{ __('Tanggal Dikembalikan') }}</div>
                            <div class="info-value">
                                {{ \Carbon\Carbon::parse($pengembalian->tanggal_pengembalian)->format('d M Y') }}</div>
                        </div>
                        <div>
                            <div class="info-label">{{ __('Ketepatan Waktu') }}</div>
                            <span
                                class="badge-pill {{ $pengembalian->keterangan_waktu['badge'] }}">{{ $pengembalian->keterangan_waktu['label'] }}</span>
                        </div>
                        <div class="full">
                            <div class="info-label">{{ __('Kondisi Saat Dikembalikan') }}</div>
                            <div class="info-value" style="font-weight:400;">
                                {{ $peminjaman->pengembalians->first()->kondisi_barang }}</div>
                        </div>
                    @elseif ($ditolak)
                        <div class="full">
                            <div class="info-label">{{ __('Catatan Admin') }}</div>
                            <div class="info-value" style="font-weight:400;">{{ $peminjaman->catatan_admin ?? '-' }}</div>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <a href="{{ route('peminjam.riwayat.index') }}" class="back-link">
        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="14" height="14" fill="none"
            stroke="currentColor" stroke-width="2.4">
            <path d="M19 12H5M11 18l-6-6 6-6" />
        </svg>
        {{ __('Kembali ke Riwayat') }}
    </a>
@endsection
