@extends('layouts.admin')

@section('page-title', __('Catat Pengembalian'))
@section('page-subtitle', __('Dashboard Admin/ Catat Pengembalian & Foto Kondisi'))

@section('content')
<div class="card mb-4">
    <div class="card-body">
        <p class="text-muted mb-1">Peminjam: <strong>{{ $peminjaman->peminjam->nama }}</strong></p>
        <p class="text-muted mb-0">Barang: {{ $peminjaman->detailPeminjamans->pluck('barang.nama_barang')->join(', ') }}</p>
    </div>
</div>

@if ($errors->any())
    <div class="alert alert-danger">@foreach ($errors->all() as $e)<div>{{ $e }}</div>@endforeach</div>
@endif

<div class="card">
    <div class="card-body">
        <form method="POST" action="{{ route('admin.pengembalian.store', $peminjaman->id_peminjaman) }}" enctype="multipart/form-data">
            @csrf
            <div class="mb-3">
                <label class="form-label">Tanggal Pengembalian</label>
                <input type="date" name="tanggal_pengembalian" class="form-control" value="{{ old('tanggal_pengembalian', now()->toDateString()) }}" required>
            </div>
            <div class="mb-3">
                <label class="form-label">Jumlah Barang Dikembalikan</label>
                <input type="number" name="jumlah_kembali" class="form-control" min="1" value="{{ old('jumlah_kembali') }}" required>
            </div>
            <div class="mb-3">
                <label class="form-label">Kondisi Barang</label>
                <select name="kondisi_barang" class="form-select" required>
                    <option value="">Pilih kondisi</option>
                    <option value="Baik">Baik</option>
                    <option value="Rusak Ringan">Rusak Ringan</option>
                    <option value="Rusak Berat">Rusak Berat</option>
                    <option value="Hilang">Hilang</option>
                </select>
            </div>
            <div class="mb-3">
                <label class="form-label">Foto Kondisi Barang (opsional)</label>
                <input type="file" name="foto_kondisi" class="form-control" accept="image/*">
            </div>
            <div class="mb-3">
                <label class="form-label">Catatan (opsional)</label>
                <textarea name="catatan" class="form-control" rows="2">{{ old('catatan') }}</textarea>
            </div>
            <button type="submit" class="btn btn-primary">Konfirmasi Pengembalian</button>
            <a href="{{ route('admin.peminjaman.show', $peminjaman->id_peminjaman) }}" class="btn btn-outline-secondary">Batal</a>
        </form>
    </div>
</div>
@endsection
