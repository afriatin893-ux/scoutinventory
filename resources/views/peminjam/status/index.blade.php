@extends('layouts.peminjam')

@section('page-title', __('Status Peminjaman'))
@section('page-subtitle', __('Dashboard Peminjam / Status Peminjaman'))
@section('page-icon')
    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="20" height="20" fill="none" stroke="currentColor"
        stroke-width="2">
        <circle cx="12" cy="12" r="9" />
        <path d="M12 7v5l3 2" />
    </svg>
@endsection

@section('content')
    <div class="tab-pills">
        @foreach (['Diajukan' => 'Diajukan', 'Disetujui' => 'Diverifikasi', 'dipinjam' => 'Dipinjam', 'dikembalikan' => 'Dikembalikan'] as $value => $label)
            <a href="{{ route('peminjam.status.index', ['status' => $value]) }}"
                class="tab-pill {{ $tab === $value ? 'active' : '' }}">
                {{ $label }}
            </a>
        @endforeach
    </div>

    <div class="panel">
        <div style="overflow-x:auto;">
            <table class="data-table">
                <thead>
                    <tr>
                        <th>{{ __('Barang') }}</th>
                        <th>{{ __('Tgl Pinjam') }}</th>
                        <th>{{ __('Tgl Kembali') }}</th>
                        <th>{{ __('Status') }}</th>
                        <th style="width:110px;">{{ __('Aksi') }}</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($peminjamans as $peminjaman)
                        <tr>
                            <td class="cell-muted">
                                {{ $peminjaman->detailPeminjamans->pluck('barang.nama_barang')->join(', ') }}</td>
                            <td class="cell-muted">{{ \Carbon\Carbon::parse($peminjaman->tanggal_pinjam)->format('d M Y') }}
                            </td>
                            <td class="cell-muted">
                                {{ \Carbon\Carbon::parse($peminjaman->tanggal_rencana_kembali)->format('d M Y') }}</td>
                            @php
                                [$statusClass, $statusLabel] = match ($peminjaman->status) {
                                    'Diajukan' => ['badge-warn', 'Menunggu'],
                                    'Disetujui' => ['badge-good', 'Diverifikasi'],
                                    'dipinjam' => ['badge-info', 'Dipinjam'],
                                    'dikembalikan' => ['badge-good', 'Dikembalikan'],
                                    default => ['badge-bad', $peminjaman->status],
                                };
                            @endphp
                            <td><span class="badge-pill {{ $statusClass }}">{{ $statusLabel }}</span></td>
                            <td>
                                <a href="{{ route('peminjam.status.show', $peminjaman->id_peminjaman) }}"
                                    class="btn btn-outline btn-sm">
                                    {{ __('Detail') }}
                                </a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="empty-state">
                                <div class="empty-state-inner">
                                    <span class="empty-state-icon">
                                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="24"
                                            height="24" fill="none" stroke="currentColor" stroke-width="1.8">
                                            <circle cx="12" cy="12" r="9" />
                                            <path d="M12 7v5l3 2" />
                                        </svg>
                                    </span>
                                    <p class="empty-state-title">{{ __('Tidak ada data di tahap ini') }}</p>
                                    <p class="empty-state-text">{{ __('Belum ada pengajuan pada status yang dipilih.') }}
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
