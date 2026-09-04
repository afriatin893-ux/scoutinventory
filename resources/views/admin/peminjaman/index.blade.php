@extends('layouts.admin')

@section('page-title', __('Riwayat Peminjaman'))
@section('page-subtitle', __('Dashboard Admin/ Riwayat Peminjaman'))

@section('content')
@if (session('success'))
    <div class="alert alert-success">{{ session('success') }}</div>
@endif

<div class="toolbar-row mb-3">
    <form method="GET" action="{{ route('admin.peminjaman.index') }}">
        <select name="status" class="form-select" onchange="this.form.submit()">
            <option value="">{{ __('Semua Status') }}</option>
            @foreach (['Diajukan', 'Ditolak', 'dipinjam', 'dikembalikan'] as $status)
                <option value="{{ $status }}" {{ request('status') === $status ? 'selected' : '' }}>
                    {{ ucfirst($status) }}
                </option>
            @endforeach
        </select>
    </form>
</div>

<div class="table-responsive">
    <table class="table table-bordered align-middle bg-white">
        <thead>
            <tr>
                <th>No</th><th>Peminjam</th><th>Barang</th>
                <th>Tgl Pinjam</th><th>Tgl Rencana Kembali</th><th>Status</th><th style="width:110px;">Aksi</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($peminjamans as $peminjaman)
            <tr>
                <td>{{ $loop->iteration + ($peminjamans->currentPage()-1) * $peminjamans->perPage() }}</td>
                <td>{{ $p->peminjam->nama }}</td>
                <td>{{ $p->detailPeminjamans->pluck('barang.nama_barang')->join(', ') }}</td>
                <td>{{ \Carbon\Carbon::parse($p->tanggal_pinjam)->format('d M Y') }}</td>
                <td>{{ \Carbon\Carbon::parse($p->tanggal_rencana_kembali)->format('d M Y') }}</td>
                <td><span class="badge bg-secondary">{{ ucfirst($p->status) }}</span></td>
                <td><a href="{{ route('admin.peminjaman.show', $p->id_peminjaman) }}" class="btn btn-sm btn-outline-secondary">Detail</a></td>
            </tr>
            @empty
            <tr><td colspan="7" class="text-center">Belum ada riwayat peminjaman.</td></tr>
            @endforelse
        </tbody>
    </table>
</div>
{{ $peminjamans->links() }}
@endsection
