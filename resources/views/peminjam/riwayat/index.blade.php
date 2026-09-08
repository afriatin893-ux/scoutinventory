@extends('layouts.peminjam')

@section('page-title', __('Riwayat Peminjaman'))
@section('page-subtitle', __('Dashboard Peminjam/ Riwayat Peminjaman'))

@section('content')
<div class="table-responsive">
    <table class="table table-bordered align-middle bg-white">
        <thead>
            <tr>
                <th>{{ __('Barang') }}</th>
                <th>{{ __('Tgl Pinjam') }}</th>
                <th>{{ __('Tgl Kembali') }}</th>
                <th>{{ __('Status') }}</th>
                <th style="width: 100px;">{{ __('Aksi') }}</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($peminjamans as $peminjaman)
                <tr>
                    <td>{{ $peminjaman->detailPeminjamans->pluck('barang.nama_barang')->join(', ') }}</td>
                    <td>{{ \Carbon\Carbon::parse($peminjaman->tanggal_pinjam)->format('d M Y') }}</td>
                    <td>{{ \Carbon\Carbon::parse($peminjaman->tanggal_rencana_kembali)->format('d M Y') }}</td>
                    <td>
                        <span class="badge {{ $peminjaman->status === 'Ditolak' ? 'bg-danger' : 'bg-success' }}">
                            {{ $peminjaman->status === 'Ditolak' ? __('Ditolak') : __('Selesai') }}
                        </span>
                    </td>
                    <td>
                        <a href="{{ route('peminjam.riwayat.show', $peminjaman->id_peminjaman) }}" class="btn btn-sm btn-outline-primary">
                            {{ __('Detail') }}
                        </a>
                    </td>
                </tr>
            @empty
                <tr><td colspan="5" class="text-center">{{ __('Belum ada riwayat peminjaman.') }}</td></tr>
            @endforelse
        </tbody>
    </table>
</div>
{{ $peminjamans->links() }}
@endsection
