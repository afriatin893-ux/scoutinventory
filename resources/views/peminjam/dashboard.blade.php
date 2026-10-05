@extends('layouts.peminjam')

@section('content')
    {{-- ===== HERO: sapaan + peminjaman terakhir ===== --}}
    <section class="hero-peminjam">
        <div class="hero-inner">
            <div>
                <h1>{{ __('Siap berkegiatan,') }} {{ $peminjam->nama ?? __('Peminjam') }}?</h1>
                <p>{{ __('Pilih perlengkapan yang kamu butuhkan, ajukan peminjaman, dan pantau persetujuannya dari satu tempat.') }}</p>
                <a class="btn-hero" href="{{ route('peminjam.peminjaman.create') }}">{{ __('Ajukan peminjaman') }}</a>
                <a class="btn-hero ghost" href="{{ route('peminjam.barang.index') }}">{{ __('Lihat katalog') }}</a>
                <div class="hero-info">
                    <span>{{ $totalKategori }} {{ __('kategori') }}</span>
                    <span>{{ $totalBarang }} {{ __('jenis barang') }}</span>
                </div>
            </div>

            <div class="loan-card" aria-label="{{ __('Peminjaman terakhir') }}">
                <small>{{ __('Peminjaman terakhir') }}</small>

                @if ($terakhir)
                    <h3>
                        {{ $terakhir->detailPeminjamans->take(2)->map(fn ($d) => ($d->barang->nama_barang ?? '-') . ' × ' . $d->jumlah)->implode(', ') }}
                        @if ($terakhir->detailPeminjamans->count() > 2)
                            {{ __('dan') }} {{ $terakhir->detailPeminjamans->count() - 2 }} {{ __('lainnya') }}
                        @endif
                    </h3>

                    @include('peminjam.partials.alur-status', ['peminjaman' => $terakhir])

                    @if (strtolower($terakhir->status) === 'ditolak')
                        <div class="loan-reject">
                            <b>{{ __('Alasan dari admin:') }}</b>
                            {{ $terakhir->catatan_admin ?: __('Tidak ada alasan yang dicantumkan.') }}
                        </div>
                        <a class="loan-link" href="{{ route('peminjam.peminjaman.create') }}">{{ __('Ajukan ulang') }}</a>
                    @else
                        <div class="loan-meta">
                            {{ __('Kembalikan paling lambat') }}
                            <b>{{ \Carbon\Carbon::parse($terakhir->tanggal_rencana_kembali)->translatedFormat('l, d F Y') }}</b>
                        </div>
                        <a class="loan-link" href="{{ route('peminjam.status.show', $terakhir) }}">{{ __('Lihat detail') }}</a>
                    @endif
                @else
                    <div class="loan-empty">
                        {{ __('Belum ada peminjaman. Mulai dari katalog atau langsung isi form pengajuan.') }}
                    </div>
                @endif
            </div>
        </div>
    </section>

    {{-- ===== MENU CEPAT ===== --}}
    <div class="dash-body">
        <div class="dash-menu">
            <a href="{{ route('peminjam.barang.index') }}" class="dash-menu-card">
                <span class="dash-menu-icon">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="28" height="28" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><circle cx="11" cy="11" r="7"/><path d="m21 21-4.3-4.3"/></svg>
                </span>
                <div>
                    <div class="dash-menu-title">{{ __('Cari barang') }}</div>
                    <div class="dash-menu-desc">{{ __('Cek katalog peralatan yang dapat dipinjam.') }}</div>
                </div>
            </a>

            <a href="{{ route('peminjam.peminjaman.create') }}" class="dash-menu-card">
                <span class="dash-menu-icon">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="28" height="28" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><path d="M14 3H7a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h10a2 2 0 0 0 2-2V8Z"/><path d="M14 3v5h5"/><path d="M12 12v6"/><path d="M9 15h6"/></svg>
                </span>
                <div>
                    <div class="dash-menu-title">{{ __('Isi form pengajuan') }}</div>
                    <div class="dash-menu-desc">{{ __('Pilih barang, tanggal pinjam, dan keperluan.') }}</div>
                </div>
            </a>

            <a href="{{ route('peminjam.status.index') }}" class="dash-menu-card">
                <span class="dash-menu-icon">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="28" height="28" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><rect x="8" y="2" width="8" height="4" rx="1"/><path d="M16 4h2a2 2 0 0 1 2 2v14a2 2 0 0 1-2 2H6a2 2 0 0 1-2-2V6a2 2 0 0 1 2-2h2"/><path d="m9 14 2 2 4-4"/></svg>
                </span>
                <div>
                    <div class="dash-menu-title">{{ __('Cek status') }}</div>
                    <div class="dash-menu-desc">{{ __('Pantau pengajuan yang menunggu atau disetujui.') }}</div>
                </div>
            </a>
        </div>
    </div>
@endsection
