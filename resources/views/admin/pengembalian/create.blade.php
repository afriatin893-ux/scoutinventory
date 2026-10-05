@extends('layouts.admin')

@section('page-title', __('Catat Pengembalian & Foto Kondisi'))
@section('page-subtitle', __('Dashboard Admin / Catat Pengembalian / Detail'))
@section('page-icon')
    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="20" height="20" fill="none" stroke="currentColor"
        stroke-width="2">
        <path d="M3 12a9 9 0 1 0 9-9 9.75 9.75 0 0 0-6.74 2.74L3 8" />
        <path d="M3 3v5h5" />
        <path d="M12 7v5l4 2" />
    </svg>
@endsection

@section('content')
    @if ($errors->any())
        <div class="alert alert-danger">
            @foreach ($errors->all() as $error)
                <div>{{ $error }}</div>
            @endforeach
        </div>
    @endif

    <form method="POST" action="{{ route('admin.pengembalian.store', $peminjaman->id_peminjaman) }}"
        enctype="multipart/form-data">
        @csrf

        <div class="grid-2">
            <div class="panel" style="margin-bottom:0;">
                <div class="panel-header">
                    <span class="panel-header-icon">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="16" height="16"
                            fill="none" stroke="currentColor" stroke-width="2">
                            <path d="M9 11 12 14 22 4" />
                            <path d="M21 12v7a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h11" />
                        </svg>
                    </span>
                    {{ __('Detail Peminjaman') }}
                </div>
                <div class="panel-body">
                    <div class="info-grid">
                        <div class="full">
                            <div class="info-label">{{ __('Peminjam') }}</div>
                            <div class="info-value">{{ $peminjaman->peminjam->nama }}</div>
                        </div>
                        <div class="full">
                            <div class="info-label">{{ __('Barang') }}</div>
                            <div class="info-value" style="font-weight:400;">
                                {{ $peminjaman->detailPeminjamans->pluck('barang.nama_barang')->join(', ') }}
                            </div>
                        </div>
                        <div>
                            <div class="info-label">{{ __('Tgl Pinjam') }}</div>
                            <div class="info-value" style="font-weight:400;">
                                {{ \Carbon\Carbon::parse($peminjaman->tanggal_pinjam)->format('d M Y') }}</div>
                        </div>
                        <div>
                            <div class="info-label">{{ __('Tgl Kembali') }}</div>
                            <div class="info-value" style="font-weight:400;">
                                {{ \Carbon\Carbon::parse($peminjaman->tanggal_rencana_kembali)->format('d M Y') }}</div>
                        </div>
                    </div>

                    <div class="form-group" style="margin-top:1.2rem;">
                        <label class="form-label">{{ __('Tanggal Pengembalian') }}</label>
                        <input type="date" name="tanggal_pengembalian"
                            class="form-control @error('tanggal_pengembalian') is-invalid @enderror"
                            value="{{ old('tanggal_pengembalian', now()->toDateString()) }}"
                            min="{{ $peminjaman->tanggal_pinjam }}" max="{{ now()->toDateString() }}" required>
                        <small
                            style="color:#6b6258;">{{ __('Isi sesuai tanggal barang benar-benar diserahkan. Bisa lebih awal dari tanggal rencana.') }}</small>
                        @error('tanggal_pengembalian')
                            <span class="form-error">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label class="form-label">{{ __('Kondisi Barang Saat Dikembalikan') }}</label>
                        <select name="kondisi_barang" class="form-select @error('kondisi_barang') is-invalid @enderror"
                            required>
                            <option value="">{{ __('-- Pilih kondisi --') }}</option>
                            <option value="Baik" {{ old('kondisi_barang') === 'Baik' ? 'selected' : '' }}>
                                {{ __('Baik') }}</option>
                            <option value="Rusak Ringan" {{ old('kondisi_barang') === 'Rusak Ringan' ? 'selected' : '' }}>
                                {{ __('Rusak Ringan') }}</option>
                            <option value="Rusak Berat" {{ old('kondisi_barang') === 'Rusak Berat' ? 'selected' : '' }}>
                                {{ __('Rusak Berat') }}</option>
                        </select>
                        @error('kondisi_barang')
                            <span class="form-error">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="form-group" style="margin-bottom:0;">
                        <label class="form-label">{{ __('Catatan Admin') }}</label>
                        <textarea name="catatan" class="form-control" rows="2" placeholder="-">{{ old('catatan') }}</textarea>
                    </div>
                </div>
            </div>

            <div class="panel" style="margin-bottom:0;">
                <div class="panel-header">
                    <span class="panel-header-icon">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="16" height="16"
                            fill="none" stroke="currentColor" stroke-width="2">
                            <rect x="3" y="3" width="18" height="18" rx="2" />
                            <circle cx="9" cy="9" r="2" />
                            <path d="m21 15-5-5L5 21" />
                        </svg>
                    </span>
                    {{ __('Foto Kondisi Barang') }}
                </div>
                <div class="panel-body">
                    <div class="upload-box" id="previewBox">
                        <span class="upload-icon" id="previewText">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="20" height="20"
                                fill="none" stroke="currentColor" stroke-width="2">
                                <rect x="3" y="3" width="18" height="18" rx="2" />
                                <circle cx="9" cy="9" r="2" />
                                <path d="m21 15-5-5L5 21" />
                            </svg>
                        </span>
                        <span id="previewLabel">{{ __('Upload / Preview Foto Barang') }}</span>
                        <img id="previewImg" src="" alt="">
                    </div>

                    <div class="form-group">
                        <input type="file" name="foto_kondisi" id="fotoKondisi" accept="image/*"
                            class="form-control @error('foto_kondisi') is-invalid @enderror">
                        @error('foto_kondisi')
                            <span class="form-error">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="form-actions">
                        <button type="submit" class="btn btn-primary">{{ __('Konfirmasi Pengembalian') }}</button>
                        <a href="{{ route('admin.pengembalian.index') }}"
                            class="btn btn-outline">{{ __('Batal') }}</a>
                    </div>
                </div>
            </div>
        </div>
    </form>

    <script>
        document.getElementById('fotoKondisi').addEventListener('change', function(e) {
            const file = e.target.files[0];
            const img = document.getElementById('previewImg');
            const icon = document.getElementById('previewText');
            const label = document.getElementById('previewLabel');
            if (file) {
                img.src = URL.createObjectURL(file);
                img.style.display = 'block';
                icon.style.display = 'none';
                label.style.display = 'none';
            } else {
                img.style.display = 'none';
                icon.style.display = 'flex';
                label.style.display = 'inline';
            }
        });
    </script>
@endsection
