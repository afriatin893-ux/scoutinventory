@extends('layouts.peminjam')

@section('page-title', __('Detail Peminjaman'))
@section('page-subtitle', __('Dashboard Peminjam/ Status & Riwayat Peminjaman/ Detail'))

@section('content')
    <div class="card">
        <div class="card-body">
            <dl class="row">
                <dt class="col-sm-4">{{ __('Status') }}</dt>
                <dd class="col-sm-8">
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
                </dd>

                <dt class="col-sm-4">{{ __('Tanggal Pinjam') }}</dt>
                <dd class="col-sm-8">{{ \Carbon\Carbon::parse($peminjaman->tanggal_pinjam)->format('d M Y') }}</dd>

                <dt class="col-sm-4">{{ __('Rencana Kembali') }}</dt>
                <dd class="col-sm-8">{{ \Carbon\Carbon::parse($peminjaman->tanggal_rencana_kembali)->format('d M Y') }}</dd>

                <dt class="col-sm-4">{{ __('Keperluan') }}</dt>
                <dd class="col-sm-8">{{ $peminjaman->keperluan }}</dd>

                <dt class="col-sm-4">{{ __('Barang Diajukan') }}</dt>
                <dd class="col-sm-8">
                    <ul class="mb-0">
                        @foreach ($peminjaman->detailPeminjamans as $detail)
                            <li>{{ $detail->barang->nama_barang ?? '-' }} &times; {{ $detail->jumlah }}</li>
                        @endforeach
                    </ul>
                </dd>

                @if ($peminjaman->catatan_admin)
                    <dt class="col-sm-4">{{ __('Catatan Admin') }}</dt>
                    <dd class="col-sm-8">{{ $peminjaman->catatan_admin }}</dd>
                @endif

                @if ($peminjaman->pengembalians->isNotEmpty())
                    <dt class="col-sm-4">{{ __('Pengembalian') }}</dt>
                    <dd class="col-sm-8">
                        @foreach ($peminjaman->pengembalians as $pengembalian)
                            {{ \Carbon\Carbon::parse($pengembalian->tanggal_pengembalian)->format('d M Y') }}
                            — {{ $pengembalian->jumlah_kembali }} barang, kondisi: {{ $pengembalian->kondisi_barang }}
                        @endforeach
                    </dd>
                @endif
            </dl>

            <a href="{{ route('peminjam.peminjaman.index') }}" class="btn btn-link ps-0">{{ __('Kembali ke daftar') }}</a>
        </div>
    </div>
@endsection
