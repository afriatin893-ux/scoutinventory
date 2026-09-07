@extends('layouts.admin')

@section('page-title', __('Catat Pengembalian & Foto Kondisi'))
@section('page-subtitle', __('Dashboard Admin/ Catat Pengembalian / Detail'))

@section('content')
@if ($errors->any())
    <div class="alert alert-danger">
        @foreach ($errors->all() as $error)<div>{{ $error }}</div>@endforeach
    </div>
@endif

<form method="POST" action="{{ route('admin.pengembalian.store', $peminjaman->id_peminjaman) }}" enctype="multipart/form-data">
    @csrf

    <div class="row g-3">
        <div class="col-md-6">
            <div class="card h-100">
                <div class="card-header">{{ __('Detail Peminjaman') }}</div>
                <div class="card-body">
                    <div class="mb-3">
                        <div class="text-muted small">{{ __('Peminjam') }}</div>
                        <div class="fw-semibold">{{ $peminjaman->peminjam->nama }}</div>
                    </div>

                    <div class="mb-3">
                        <div class="text-muted small">{{ __('Barang') }}</div>
                        <div class="fw-semibold">
                            {{ $peminjaman->detailPeminjamans->pluck('barang.nama_barang')->join(', ') }}
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-6">
                            <div class="text-muted small">{{ __('Tgl Pinjam') }}</div>
                            <div>{{ \Carbon\Carbon::parse($peminjaman->tanggal_pinjam)->format('d M Y') }}</div>
                        </div>
                        <div class="col-6">
                            <div class="text-muted small">{{ __('Tgl Kembali') }}</div>
                            <div>{{ \Carbon\Carbon::parse($peminjaman->tanggal_rencana_kembali)->format('d M Y') }}</div>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">{{ __('Kondisi Barang Saat Dikembalikan') }}</label>
                        <select name="kondisi_barang" class="form-select @error('kondisi_barang') is-invalid @enderror" required>
                            <option value="">{{ __('-- Pilih kondisi --') }}</option>
                            <option value="Baik" {{ old('kondisi_barang') === 'Baik' ? 'selected' : '' }}>{{ __('Baik') }}</option>
                            <option value="Rusak Ringan" {{ old('kondisi_barang') === 'Rusak Ringan' ? 'selected' : '' }}>{{ __('Rusak Ringan') }}</option>
                            <option value="Rusak Berat" {{ old('kondisi_barang') === 'Rusak Berat' ? 'selected' : '' }}>{{ __('Rusak Berat') }}</option>
                        </select>
                        @error('kondisi_barang')<span class="invalid-feedback">{{ $message }}</span>@enderror
                    </div>

                    <div class="mb-0">
                        <label class="form-label">{{ __('Catatan Admin') }}</label>
                        <textarea name="catatan" class="form-control" rows="2" placeholder="-">{{ old('catatan') }}</textarea>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-6">
            <div class="card h-100">
                <div class="card-header">{{ __('Foto Kondisi Barang') }}</div>
                <div class="card-body d-flex flex-column">
                    <div class="border border-dashed rounded d-flex align-items-center justify-content-center text-muted mb-3 flex-grow-1"
                         style="min-height: 220px;" id="previewBox">
                        <span id="previewText">{{ __('Upload / Preview Foto Barang') }}</span>
                        <img id="previewImg" src="" alt="" style="display:none; max-width:100%; max-height:220px; object-fit:contain;">
                    </div>

                    <input type="file" name="foto_kondisi" id="fotoKondisi" accept="image/*"
                           class="form-control mb-3 @error('foto_kondisi') is-invalid @enderror">
                    @error('foto_kondisi')<span class="invalid-feedback d-block mb-3">{{ $message }}</span>@enderror

                    <button type="submit" class="btn btn-primary">{{ __('Konfirmasi Pengembalian') }}</button>
                    <a href="{{ route('admin.pengembalian.index') }}" class="btn btn-link">{{ __('Batal') }}</a>
                </div>
            </div>
        </div>
    </div>
</form>

<script>
    document.getElementById('fotoKondisi').addEventListener('change', function (e) {
        const file = e.target.files[0];
        const img = document.getElementById('previewImg');
        const text = document.getElementById('previewText');
        if (file) {
            img.src = URL.createObjectURL(file);
            img.style.display = 'block';
            text.style.display = 'none';
        } else {
            img.style.display = 'none';
            text.style.display = 'block';
        }
    });
</script>
@endsection
