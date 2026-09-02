@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    {{ __('Status & Riwayat Peminjaman') }}
                    <a href="{{ route('peminjam.peminjaman.create') }}" class="btn btn-primary btn-sm">
                        {{ __('+ Ajukan Peminjaman') }}
                    </a>
                </div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success">{{ session('status') }}</div>
                    @endif

                    <table class="table table-bordered align-middle">
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
                                    <td>{{ \Illuminate\Support\Carbon::parse($peminjaman->tanggal_pinjam)->format('d M Y') }}</td>
                                    <td>{{ \Illuminate\Support\Carbon::parse($peminjaman->tanggal_rencana_kembali)->format('d M Y') }}</td>
                                    <td>
                                        @foreach ($peminjaman->detailPeminjamans as $detail)
                                            {{ $detail->barang->nama_barang ?? '-' }} ({{ $detail->jumlah }})@if (!$loop->last), @endif
                                        @endforeach
                                    </td>
                                    <td>
                                        @php
                                            $badge = match($peminjaman->status) {
                                                'Diajukan' => 'bg-warning text-dark',
                                                'Disetujui' => 'bg-primary',
                                                'Ditolak' => 'bg-danger',
                                                'Selesai' => 'bg-success',
                                                default => 'bg-secondary',
                                            };
                                        @endphp
                                        <span class="badge {{ $badge }}">{{ $peminjaman->status }}</span>
                                    </td>
                                    <td>
                                        <a href="{{ route('peminjam.peminjaman.show', $peminjaman->id_peminjaman) }}" class="btn btn-sm btn-outline-primary">
                                            {{ __('Detail') }}
                                        </a>
                                    </td>
                                </tr>
                            @empty
                                <tr><td colspan="5" class="text-center">{{ __('Belum ada pengajuan peminjaman.') }}</td></tr>
                            @endforelse
                        </tbody>
                    </table>

                    {{ $peminjamans->links() }}
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
