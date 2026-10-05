@extends('layouts.peminjam')

@section('page-title', __('Status peminjaman'))
@section('page-subtitle', __('Pantau pengajuanmu dari diajukan sampai dikembalikan.'))

@section('content')
    @forelse ($peminjamans as $peminjaman)
        @php
            $status = strtolower($peminjaman->status);
            [$bdClass, $bdLabel] = match ($status) {
                'diajukan'  => ['w', 'Menunggu verifikasi'],
                'disetujui' => ['o', 'Disetujui, menunggu diambil'],
                'dipinjam'  => ['o', 'Sedang dipinjam'],
                default     => ['r', 'Ditolak'],
            };
        @endphp
        <article class="status-card">
            <div class="status-head">
                <div>
                    <h3>{{ $peminjaman->detailPeminjamans->map(fn ($d) => ($d->barang->nama_barang ?? '-') . ' × ' . $d->jumlah)->join(', ') }}</h3>
                    <small>{{ __('Diajukan') }} {{ $peminjaman->created_at->translatedFormat('d M Y') }}
                        &middot; {{ __('Pinjam') }} {{ \Carbon\Carbon::parse($peminjaman->tanggal_pinjam)->translatedFormat('d M') }}
                        - {{ \Carbon\Carbon::parse($peminjaman->tanggal_rencana_kembali)->translatedFormat('d M Y') }}</small>
                </div>
                <span class="bd {{ $bdClass }}">{{ $bdLabel }}</span>
            </div>

            @include('peminjam.partials.alur-status', ['peminjaman' => $peminjaman])

            @if ($status === 'ditolak')
                <div class="loan-reject">
                    <b>{{ __('Alasan dari admin:') }}</b> {{ $peminjaman->catatan_admin ?: __('Tidak ada alasan yang dicantumkan.') }}
                </div>
            @elseif ($status === 'dipinjam')
                <div class="loan-meta">{{ __('Kembalikan paling lambat') }}
                    <b>{{ \Carbon\Carbon::parse($peminjaman->tanggal_rencana_kembali)->translatedFormat('l, d F Y') }}</b></div>
            @endif

            <div class="status-actions">
                <a href="{{ route('peminjam.status.show', $peminjaman->id_peminjaman) }}" class="btn btn-outline btn-sm">{{ __('Detail') }}</a>
                @if ($status === 'ditolak')
                    <a href="{{ route('peminjam.peminjaman.create') }}" class="btn btn-primary btn-sm">{{ __('Ajukan ulang') }}</a>
                @endif
            </div>
        </article>
    @empty
        <div class="panel">
            <div class="panel-body" style="text-align:center;">
                <p class="empty-state-title">{{ __('Belum ada pengajuan aktif') }}</p>
                <p class="empty-state-text">{{ __('Pilih barang dari katalog, lalu ajukan peminjaman.') }}</p>
                <a href="{{ route('peminjam.barang.index') }}" class="btn btn-primary btn-sm">{{ __('Buka katalog') }}</a>
            </div>
        </div>
    @endforelse

    <div class="pagination-wrap">{{ $peminjamans->links() }}</div>
@endsection
