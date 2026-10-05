@extends('layouts.peminjam')

@section('page-title', __('Riwayat peminjaman'))
@section('page-subtitle', __('Semua peminjaman yang pernah kamu lakukan.'))
@section('page-icon')
    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="20" height="20" fill="none" stroke="currentColor" stroke-width="2">
        <path d="M8 6h13"/><path d="M8 12h13"/><path d="M8 18h13"/><path d="M3 6h.01"/><path d="M3 12h.01"/><path d="M3 18h.01"/>
    </svg>
@endsection

@section('content')
<div class="chips">
    @foreach (['semua' => 'Semua', 'selesai' => 'Selesai', 'ditolak' => 'Ditolak'] as $k => $label)
        <a href="{{ route('peminjam.riwayat.index', $k === 'semua' ? [] : ['f' => $k]) }}" class="chip {{ $filter === $k ? 'on' : '' }}">{{ $label }}</a>
    @endforeach
</div>

<div class="panel riwayat-list">
    @forelse ($peminjamans as $peminjaman)
        @php $ditolak = $peminjaman->status === 'Ditolak'; @endphp
        <a href="{{ route('peminjam.riwayat.show', $peminjaman->id_peminjaman) }}" class="riwayat-row">
            <time>
                {{ \Carbon\Carbon::parse($peminjaman->tanggal_pinjam)->translatedFormat('d M Y') }}
                <span>{{ __('s/d') }} {{ \Carbon\Carbon::parse($peminjaman->tanggal_rencana_kembali)->translatedFormat('d M Y') }}</span>
            </time>
            <div>
                <b>{{ $peminjaman->detailPeminjamans->map(fn ($d) => ($d->barang->nama_barang ?? '-') . ' × ' . $d->jumlah)->join(', ') }}</b>
                <p>{{ \Illuminate\Support\Str::limit($peminjaman->keperluan, 70) }}</p>
            </div>
            <span class="bd {{ $ditolak ? 'r' : 'g' }}">{{ $ditolak ? __('Ditolak') : __('Dikembalikan') }}</span>
        </a>
    @empty
        <div class="panel-body" style="text-align:center;">
            <p class="empty-state-title">{{ __('Belum ada riwayat') }}</p>
            <p class="empty-state-text">{{ __('Peminjaman yang sudah selesai atau ditolak akan muncul di sini.') }}</p>
        </div>
    @endforelse
</div>

<div class="pagination-wrap">{{ $peminjamans->links() }}</div>
@endsection
