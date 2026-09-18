@extends('layouts.admin')

@section('page-title', __('Verifikasi Pengajuan Peminjaman'))
@section('page-subtitle', __('Dashboard Admin / Verifikasi Pengajuan Peminjaman'))
@section('page-icon')
    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="20" height="20" fill="none" stroke="currentColor"
        stroke-width="2">
        <path d="M9 11 12 14 22 4" />
        <path d="M21 12v7a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h11" />
    </svg>
@endsection

@section('content')

    <div class="panel">
        <div class="panel-header">
            <span class="panel-header-icon">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="16" height="16" fill="none"
                    stroke="currentColor" stroke-width="2">
                    <path d="M9 11 12 14 22 4" />
                    <path d="M21 12v7a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h11" />
                </svg>
            </span>
            {{ __('Menunggu Verifikasi') }}
            <span class="panel-header-count">{{ $peminjamans->total() }} {{ __('pengajuan') }}</span>
        </div>
        <div style="overflow-x:auto;">
            <table class="data-table">
                <thead>
                    <tr>
                        <th style="width:50px;">{{ __('No') }}</th>
                        <th>{{ __('Peminjam') }}</th>
                        <th>{{ __('Barang') }}</th>
                        <th>{{ __('Tgl Pinjam') }}</th>
                        <th>{{ __('Tgl Rencana Kembali') }}</th>
                        <th style="width:110px;">{{ __('Aksi') }}</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($peminjamans as $peminjaman)
                        <tr>
                            <td class="cell-muted">{{ $loop->iteration }}</td>
                            <td>
                                <div class="cell-primary">{{ $peminjaman->peminjam->nama }}</div>
                                <div class="cell-muted">{{ $peminjaman->peminjam->asal_organisasi }}</div>
                            </td>
                            <td class="cell-muted">
                                {{ $peminjaman->detailPeminjamans->pluck('barang.nama_barang')->join(', ') }}</td>
                            <td class="cell-muted">
                                {{ \Carbon\Carbon::parse($peminjaman->tanggal_pinjam)->format('d M Y') }}</td>
                            <td class="cell-muted">
                                {{ \Carbon\Carbon::parse($peminjaman->tanggal_rencana_kembali)->format('d M Y') }}</td>
                            <td>
                                <a href="{{ route('admin.peminjaman.show', ['peminjaman' => $peminjaman->id_peminjaman, 'from' => 'verifikasi']) }}"
                                    class="btn btn-outline btn-sm">
                                    {{ __('Detail') }}
                                </a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="empty-state">
                                <div class="empty-state-inner">
                                    <span class="empty-state-icon">
                                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="24"
                                            height="24" fill="none" stroke="currentColor" stroke-width="1.8">
                                            <path d="M9 11 12 14 22 4" />
                                            <path d="M21 12v7a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h11" />
                                        </svg>
                                    </span>
                                    <p class="empty-state-title">{{ __('Tidak ada pengajuan menunggu') }}</p>
                                    <p class="empty-state-text">
                                        {{ __('Semua pengajuan peminjaman sudah diverifikasi. Pengajuan baru akan muncul di sini.') }}
                                    </p>
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
