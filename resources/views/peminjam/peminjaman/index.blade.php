@extends('layouts.peminjam')

@section('page-title', __('Status & Riwayat Peminjaman'))
@section('page-subtitle', __('Dashboard Peminjam/ Status & Riwayat Peminjaman'))

@section('content')
    @if (session('status'))
        <div class="alert alert-success">{{ session('status') }}</div>
    @endif

    <div class="d-flex justify-content-end mb-3">
        <a href="{{ route('peminjam.peminjaman.create') }}" class="btn btn-primary btn-sm">
            {{ __('+ Ajukan Peminjaman') }}
        </a>
    </div>

    <div class="table-responsive">
        <table class="table table-bordered align-middle bg-white">
            <thead>
                <tr>
                    <th>{{ __('Tanggal Pinjam') }}</th>
                    <th>{{ __('Rencana Kembali') }}</th>
                    <th>{{ __('Barang') }}</th>
                    <th>{{ __('Status') }}</th>
                    <th style="width: 100px;">{{ __('Aksi') }}</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($peminjamans as $peminjaman)
                    <tr>
                        <td>{{ \Carbon\Carbon::parse($peminjaman->tanggal_pinjam)->format('d M Y') }}</td>
                        <td>{{ \Carbon\Carbon::parse($peminjaman->tanggal_rencana_kembali)->format('d M Y') }}</td>
                        <td>
                            @foreach ($peminjaman->detailPeminjamans as $detail)
                                {{ $detail->barang->nama_barang ?? '-' }} ({{ $detail->jumlah }})@if (!$loop->last)
                                    ,
                                @endif
                            @endforeach
                        </td>
                        <td>
                            @php
                                $badge = match ($peminjaman->status) {
                                    'Diajukan' => 'bg-warning text-dark',
                                    'dipinjam' => 'bg-primary',
                                    'Ditolak' => 'bg-danger',
                                    'dikembalikan' => 'bg-success',
                                    default => 'bg-secondary',
                                };
                            @endphp
                            <span class="badge {{ $badge }}">{{ ucfirst($peminjaman->status) }}</span>
                        </td>
                        <td>
                            <a href="{{ route('peminjam.peminjaman.show', $peminjaman->id_peminjaman) }}"
                                class="btn btn-sm btn-outline-primary">
                                {{ __('Detail') }}
                            </a>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="text-center">{{ __('Belum ada pengajuan peminjaman.') }}</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    {{ $peminjamans->links() }}
@endsection
