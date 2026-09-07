@extends('layouts.admin')

@section('page-title', __('Catat Pengembalian'))
@section('page-subtitle', __('Dashboard Admin/ Catat Pengembalian'))

@section('content')
@if (session('error'))
    <div class="alert alert-danger">{{ session('error') }}</div>
@endif

<div class="table-responsive">
    <table class="table table-bordered align-middle bg-white">
        <thead>
            <tr>
                <th>No</th>
                <th>Peminjam</th>
                <th>Barang</th>
                <th>Tgl Pinjam</th>
                <th>Tgl Rencana Kembali</th>
                <th style="width: 160px;">Aksi</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($peminjamans as $peminjaman)
                <tr>
                    <td>{{ $loop->iteration + ($peminjamans->currentPage() - 1) * $peminjamans->perPage() }}</td>
                    <td>{{ $peminjaman->peminjam->nama }}</td>
                    <td>{{ $peminjaman->detailPeminjamans->pluck('barang.nama_barang')->join(', ') }}</td>
                    <td>{{ \Carbon\Carbon::parse($peminjaman->tanggal_pinjam)->format('d M Y') }}</td>
                    <td>
                        {{ \Carbon\Carbon::parse($peminjaman->tanggal_rencana_kembali)->format('d M Y') }}
                        @if (\Carbon\Carbon::parse($peminjaman->tanggal_rencana_kembali)->isPast())
                            <span class="badge bg-danger ms-1">Terlambat</span>
                        @endif
                    </td>
                    <td>
                        <a href="{{ route('admin.pengembalian.create', $peminjaman->id_peminjaman) }}" class="btn btn-sm btn-primary">
                            Catat Pengembalian
                        </a>
                    </td>
                </tr>
            @empty
                <tr><td colspan="6" class="text-center">Tidak ada barang yang sedang dipinjam.</td></tr>
            @endforelse
        </tbody>
    </table>
</div>
{{ $peminjamans->links() }}
@endsection
