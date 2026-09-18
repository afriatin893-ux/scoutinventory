@extends('layouts.admin')

@section('page-title', __('Detail Peminjaman'))
@section('page-subtitle', request('from') === 'verifikasi' ? __('Dashboard Admin / Verifikasi Pengajuan / Detail') :
    __('Dashboard Admin / Riwayat Peminjaman / Detail'))
@section('page-icon')
    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="20" height="20" fill="none" stroke="currentColor" stroke-width="2">
        <path d="M9 11 12 14 22 4"/><path d="M21 12v7a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h11"/>
    </svg>
@endsection

@section('content')
    @php
        $statusBadge = match($peminjaman->status) {
            'Diajukan' => 'badge-warn',
            'Disetujui' => 'badge-info',
            'dipinjam' => 'badge-good',
            'ditolak' => 'badge-bad',
            'dikembalikan' => 'badge-good',
            default => 'badge-info',
        };
    @endphp

    <div class="panel">
        <div class="panel-body">
            <div class="info-grid">
                <div>
                    <div class="info-label">{{ __('Peminjam') }}</div>
                    <div class="info-value">{{ $peminjaman->peminjam->nama }}</div>
                    <div class="info-value muted">{{ $peminjaman->peminjam->asal_organisasi }}</div>
                </div>
                <div>
                    <div class="info-label">{{ __('Status') }}</div>
                    <span class="badge-pill {{ $statusBadge }}">{{ ucfirst($peminjaman->status) }}</span>
                </div>
                <div>
                    <div class="info-label">{{ __('Tanggal Pinjam') }}</div>
                    <div class="info-value">{{ \Carbon\Carbon::parse($peminjaman->tanggal_pinjam)->format('d M Y') }}</div>
                </div>
                <div>
                    <div class="info-label">{{ __('Tanggal Rencana Kembali') }}</div>
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

    <div class="panel">
        <div class="panel-header">
            <span class="panel-header-icon">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="16" height="16" fill="none" stroke="currentColor" stroke-width="2"><path d="m21 8-9-5-9 5 9 5 9-5Z"/><path d="M3 8v8l9 5 9-5V8"/><path d="M12 13v8"/></svg>
            </span>
            {{ __('Barang Diajukan') }}
        </div>
        <table class="data-table">
            <thead>
                <tr>
                    <th>{{ __('Barang') }}</th>
                    <th style="width:150px;">{{ __('Jumlah Diajukan') }}</th>
                    <th style="width:150px;">{{ __('Stok Sekarang') }}</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($peminjaman->detailPeminjamans as $detail)
                    <tr>
                        <td class="cell-primary">{{ $detail->barang->nama_barang }}</td>
                        <td>{{ $detail->jumlah }}</td>
                        <td class="cell-muted">{{ $detail->barang->stok }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    @if ($errors->any())
        <div class="alert alert-danger">
            @foreach ($errors->all() as $error)
                <div>{{ $error }}</div>
            @endforeach
        </div>
    @endif

    @if ($peminjaman->status === 'Diajukan')
        <div class="action-panel">
            <div class="action-panel-header">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="16" height="16" fill="none" stroke="currentColor" stroke-width="2"><path d="M9 11 12 14 22 4"/><path d="M21 12v7a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h11"/></svg>
                {{ __('Verifikasi Pengajuan') }}
            </div>
            <div class="action-panel-body">
                <form method="POST" action="{{ route('admin.peminjaman.verifikasi', $peminjaman->id_peminjaman) }}">
                    @csrf
                    @method('PUT')
                    <div class="form-group">
                        <label class="form-label">{{ __('Catatan Admin (opsional)') }}</label>
                        <textarea name="catatan_admin" class="form-control" rows="2"></textarea>
                    </div>
                    <div class="form-actions">
                        <button type="submit" name="keputusan" value="setuju" class="btn btn-primary">{{ __('Setujui') }}</button>
                        <button type="submit" name="keputusan" value="tolak" class="btn btn-outline-danger">{{ __('Tolak') }}</button>
                    </div>
                </form>
            </div>
        </div>
    @elseif ($peminjaman->status === 'Disetujui')
        <div class="action-panel">
            <div class="action-panel-header">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="16" height="16" fill="none" stroke="currentColor" stroke-width="2"><path d="m21 8-9-5-9 5 9 5 9-5Z"/><path d="M3 8v8l9 5 9-5V8"/><path d="M12 13v8"/></svg>
                {{ __('Konfirmasi Pengambilan Barang') }}
            </div>
            <div class="action-panel-body">
                <p class="action-panel-text">{{ __('Peminjaman ini sudah disetujui. Klik tombol di bawah setelah peminjam benar-benar mengambil barangnya.') }}</p>
                <form method="POST" action="{{ route('admin.peminjaman.konfirmasi', $peminjaman->id_peminjaman) }}">
                    @csrf
                    @method('PUT')
                    <button type="submit" class="btn btn-primary">{{ __('Konfirmasi Pengambilan Barang') }}</button>
                </form>
            </div>
        </div>
    @elseif ($peminjaman->status === 'dipinjam')
        <a href="{{ route('admin.pengembalian.create', $peminjaman->id_peminjaman) }}" class="btn btn-primary">
            {{ __('Catat Pengembalian') }}
        </a>
    @elseif ($peminjaman->status === 'dikembalikan' && $peminjaman->pengembalians->isNotEmpty())
        @php $pengembalian = $peminjaman->pengembalians->first(); @endphp
        <div class="action-panel">
            <div class="action-panel-header">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="16" height="16" fill="none" stroke="currentColor" stroke-width="2"><path d="M3 12a9 9 0 1 0 9-9 9.75 9.75 0 0 0-6.74 2.74L3 8"/><path d="M3 3v5h5"/><path d="M12 7v5l4 2"/></svg>
                {{ __('Detail Pengembalian') }}
            </div>
            <div class="action-panel-body">
                <div class="info-grid">
                    <div>
                        <div class="info-label">{{ __('Tanggal') }}</div>
                        <div class="info-value">{{ \Carbon\Carbon::parse($pengembalian->tanggal_pengembalian)->format('d M Y') }}</div>
                    </div>
                    <div>
                        <div class="info-label">{{ __('Jumlah Kembali') }}</div>
                        <div class="info-value">{{ $pengembalian->jumlah_kembali }}</div>
                    </div>
                    <div>
                        <div class="info-label">{{ __('Kondisi') }}</div>
                        <div class="info-value">{{ $pengembalian->kondisi_barang }}</div>
                    </div>
                    @if ($pengembalian->catatan)
                        <div class="full">
                            <div class="info-label">{{ __('Catatan') }}</div>
                            <div class="info-value" style="font-weight:400;">{{ $pengembalian->catatan }}</div>
                        </div>
                    @endif
                </div>
                @if ($pengembalian->foto_kondisi)
                    <img src="{{ asset('storage/' . $pengembalian->foto_kondisi) }}" class="action-panel-photo" alt="Foto kondisi barang">
                @endif
            </div>
        </div>
    @endif

    @if (request('from') === 'verifikasi')
        <a href="{{ route('admin.peminjaman.pending') }}" class="back-link">
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="14" height="14" fill="none" stroke="currentColor" stroke-width="2.4"><path d="M19 12H5M11 18l-6-6 6-6"/></svg>
            {{ __('Kembali ke Verifikasi Pengajuan') }}
        </a>
    @else
        <a href="{{ route('admin.peminjaman.index') }}" class="back-link">
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="14" height="14" fill="none" stroke="currentColor" stroke-width="2.4"><path d="M19 12H5M11 18l-6-6 6-6"/></svg>
            {{ __('Kembali ke Riwayat Peminjaman') }}
        </a>
    @endif
@endsection
