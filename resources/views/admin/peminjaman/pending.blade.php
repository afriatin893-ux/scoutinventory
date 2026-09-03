@extends('layouts.admin')

@section('page-title', __('Verifikasi Pengajuan Peminjaman'))
@section('page-subtitle', __('Dashboard Admin/ Verifikasi Pengajuan Peminjaman'))

@section('content')
@if (session('status'))
    <div class="alert alert-success">{{ session('status') }}</div>
@endif

<div class="table-responsive">
    <table class="table table-bordered align-middle bg-white">
        <thead>
            <tr>
                <th>No</th><th>Peminjam</th><th>Barang</th>
                <th>Tgl Pinjam</th><th>Tgl Rencana Kembali</th><th style="width:110px;">Aksi</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($peminjamans as $p)
            <tr>
                <td>{{ $loop->iteration }}</td>
                <td>{{ $p->peminjam->nama }}</td>
                <td>{{ $p->detailPeminjamans->pluck('barang.nama_barang')->join(', ') }}</td>
                <td>{{ \Carbon\Carbon::parse($p->tanggal_pinjam)->format('d M Y') }}</td>
                <td>{{ \Carbon\Carbon::parse($p->tanggal_rencana_kembali)->format('d M Y') }}</td>
                <td><a href="{{ route('admin.peminjaman.show', $p->id_peminjaman) }}" class="btn btn-sm btn-outline-primary">Detail</a></td>
            </tr>
            @empty
            <tr><td colspan="6" class="text-center">Tidak ada pengajuan menunggu.</td></tr>
            @endforelse
        </tbody>
    </table>
</div>
{{ $peminjamans->links() }}
@endsection
