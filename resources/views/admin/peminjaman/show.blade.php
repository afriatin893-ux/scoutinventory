@extends('layouts.admin')

@section('page-title', __('Detail Peminjaman'))
@section('page-subtitle', __('Dashboard Admin/ Riwayat Peminjaman/ Detail'))

@section('content')
    <div class="card mb-4">
        <div class="card-body">
            <div class="row g-3">
                <div class="col-md-6">
                    <div class="text-muted small">Peminjam</div>
                    <div class="fw-semibold">{{ $peminjaman->peminjam->nama }}</div>
                    <div class="text-muted small">{{ $peminjaman->peminjam->asal_organisasi }}</div>
                </div>
                <div class="col-md-6">
                    <div class="text-muted small">Status</div>
                    <span class="badge bg-secondary">{{ ucfirst($peminjaman->status) }}</span>
                </div>
                <div class="col-md-6">
                    <div class="text-muted small">Tanggal Pinjam</div>
                    <div>{{ \Carbon\Carbon::parse($peminjaman->tanggal_pinjam)->format('d M Y') }}</div>
                </div>
                <div class="col-md-6">
                    <div class="text-muted small">Tanggal Rencana Kembali</div>
                    <div>{{ \Carbon\Carbon::parse($peminjaman->tanggal_rencana_kembali)->format('d M Y') }}</div>
                </div>
                <div class="col-12">
                    <div class="text-muted small">Keperluan</div>
                    <div>{{ $peminjaman->keperluan }}</div>
                </div>
            </div>
        </div>
    </div>

    <div class="table-responsive mb-4">
        <table class="table table-bordered align-middle bg-white">
            <thead>
                <tr>
                    <th>Barang</th>
                    <th style="width:140px;">Jumlah Diajukan</th>
                    <th style="width:140px;">Stok Sekarang</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($peminjaman->detailPeminjamans as $detail)
                    <tr>
                        <td>{{ $detail->barang->nama_barang }}</td>
                        <td>{{ $detail->jumlah }}</td>
                        <td>{{ $detail->barang->stok }}</td>
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
        <div class="card">
            <div class="card-header">Verifikasi Pengajuan</div>
            <div class="card-body">
                <form method="POST" action="{{ route('admin.peminjaman.verifikasi', $peminjaman->id_peminjaman) }}">
                    @csrf
                    @method('PUT')
                    <div class="mb-3">
                        <label class="form-label">Catatan Admin (opsional)</label>
                        <textarea name="catatan_admin" class="form-control" rows="2"></textarea>
                    </div>
                    <button type="submit" name="keputusan" value="setuju" class="btn btn-primary">Setujui</button>
                    <button type="submit" name="keputusan" value="tolak" class="btn btn-outline-danger">Tolak</button>
                </form>
            </div>
        </div>
    @elseif ($peminjaman->status === 'dipinjam')
        <a href="{{ route('admin.pengembalian.create', $peminjaman->id_peminjaman) }}" class="btn btn-primary">
            Catat Pengembalian
        </a>
    @elseif ($peminjaman->status === 'dikembalikan' && $peminjaman->pengembalians->isNotEmpty())
        @php $pengembalian = $peminjaman->pengembalians->first(); @endphp
        <div class="card">
            <div class="card-header">Detail Pengembalian</div>
            <div class="card-body">
                <p><strong>Tanggal:</strong>
                    {{ \Carbon\Carbon::parse($pengembalian->tanggal_pengembalian)->format('d M Y') }}</p>
                <p><strong>Jumlah Kembali:</strong> {{ $pengembalian->jumlah_kembali }}</p>
                <p><strong>Kondisi:</strong> {{ $pengembalian->kondisi_barang }}</p>
                @if ($pengembalian->foto_kondisi)
                    <img src="{{ asset('storage/' . $pengembalian->foto_kondisi) }}" style="max-width:240px;"
                        class="rounded border">
                @endif
                @if ($pengembalian->catatan)
                    <p class="mt-2"><strong>Catatan:</strong> {{ $pengembalian->catatan }}</p>
                @endif
            </div>
        </div>
    @endif

    <div class="mt-3">
        <a href="{{ route('admin.peminjaman.index') }}"
            class="btn btn-link ps-0">{{ __('Kembali ke Riwayat Peminjaman') }}</a>
    </div>
@endsection
