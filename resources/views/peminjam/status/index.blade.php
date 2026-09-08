@extends('layouts.peminjam')

@section('page-title', __('Status Peminjaman'))
@section('page-subtitle', __('Dashboard Peminjam/ Status Peminjaman'))

@section('content')
<div class="d-flex flex-wrap gap-2 mb-4">
    @foreach (['Diajukan' => 'Diajukan', 'Disetujui' => 'Diverifikasi', 'dipinjam' => 'Dipinjam', 'dikembalikan' => 'Dikembalikan'] as $value => $label)
        <a href="{{ route('peminjam.status.index', ['status' => $value]) }}"
           class="btn btn-sm {{ $tab === $value ? 'btn-primary' : 'btn-outline-secondary' }}">
            {{ $label }}
        </a>
    @endforeach
</div>

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
                    <td><span class="badge bg-secondary">{{ __('Menunggu') }}</span></td>
                    <td>
                        <a href="{{ route('peminjam.status.show', $peminjaman->id_peminjaman) }}" class="btn btn-sm btn-outline-primary">
                            {{ __('Detail') }}
                        </a>
                    </td>
                </tr>
            @empty
                <tr><td colspan="5" class="text-center">{{ __('Tidak ada data di tahap ini.') }}</td></tr>
            @endforelse
        </tbody>
    </table>
</div>
{{ $peminjamans->links() }}
@endsection
