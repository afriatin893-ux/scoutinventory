@extends('layouts.admin')

@section('page-title', __('Edit Barang'))
@section('page-subtitle', __('Dashboard Admin / Kelola Data Barang / Edit'))
@section('page-icon')
    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="20" height="20" fill="none" stroke="currentColor"
        stroke-width="2">
        <path d="m21 8-9-5-9 5 9 5 9-5Z" />
        <path d="M3 8v8l9 5 9-5V8" />
        <path d="M12 13v8" />
    </svg>

@section('content')
    <div class="form-card">
        <form method="POST" action="{{ route('admin.barang.update', $barang->id_barang) }}" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <div class="form-group">
                <label for="id_kategori" class="form-label">{{ __('Kategori') }}</label>
                <select id="id_kategori" name="id_kategori" class="form-select @error('id_kategori') is-invalid @enderror"
                    required>
                    <option value="">{{ __('-- Pilih Kategori --') }}</option>
                    @foreach ($categories as $kategori)
                        <option value="{{ $kategori->id_kategori }}"
                            {{ old('id_kategori', $barang->id_kategori) == $kategori->id_kategori ? 'selected' : '' }}>
                            {{ $kategori->nama_kategori }}
                        </option>
                    @endforeach
                </select>
                @error('id_kategori')
                    <span class="form-error">{{ $message }}</span>
                @enderror
            </div>

            <div class="form-group">
                <label for="nama_barang" class="form-label">{{ __('Nama Barang') }}</label>
                <input id="nama_barang" type="text" class="form-control @error('nama_barang') is-invalid @enderror"
                    name="nama_barang" value="{{ old('nama_barang', $barang->nama_barang) }}" required>
                @error('nama_barang')
                    <span class="form-error">{{ $message }}</span>
                @enderror
            </div>

            <div class="form-group">
                <label for="foto" class="form-label">{{ __('Foto Barang') }}</label>
                @if ($barang->foto)
                    <div><img src="{{ asset('storage/' . $barang->foto) }}" alt="Foto barang" class="form-photo-preview">
                    </div>
                @endif
                <input id="foto" type="file" accept="image/*"
                    class="form-control @error('foto') is-invalid @enderror" name="foto">
                <div class="form-hint">{{ __('Kosongkan jika tidak ingin mengubah foto.') }}</div>
                @error('foto')
                    <span class="form-error">{{ $message }}</span>
                @enderror
            </div>

            <div class="form-row">
                <div class="form-group">
                    <label for="stok" class="form-label">{{ __('Stok') }}</label>
                    <input id="stok" type="number" min="0"
                        class="form-control @error('stok') is-invalid @enderror" name="stok"
                        value="{{ old('stok', $barang->stok) }}" required>
                    @error('stok')
                        <span class="form-error">{{ $message }}</span>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="kondisi" class="form-label">{{ __('Kondisi') }}</label>
                    <select id="kondisi" name="kondisi" class="form-select @error('kondisi') is-invalid @enderror"
                        required>
                        @foreach (['Baik', 'Rusak Ringan', 'Rusak Berat'] as $opsi)
                            <option value="{{ $opsi }}"
                                {{ old('kondisi', $barang->kondisi) === $opsi ? 'selected' : '' }}>{{ $opsi }}
                            </option>
                        @endforeach
                    </select>
                    @error('kondisi')
                        <span class="form-error">{{ $message }}</span>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="tanggal_pengadaan" class="form-label">{{ __('Tanggal Pengadaan') }}</label>
                    <input id="tanggal_pengadaan" type="date"
                        class="form-control @error('tanggal_pengadaan') is-invalid @enderror" name="tanggal_pengadaan"
                        value="{{ old('tanggal_pengadaan', \Illuminate\Support\Carbon::parse($barang->tanggal_pengadaan)->format('Y-m-d')) }}"
                        required>
                    @error('tanggal_pengadaan')
                        <span class="form-error">{{ $message }}</span>
                    @enderror
                </div>
            </div>

            <div class="form-group">
                <label for="lokasi" class="form-label">{{ __('Lokasi Penyimpanan') }}</label>
                <input id="lokasi" type="text" class="form-control @error('lokasi') is-invalid @enderror"
                    name="lokasi" value="{{ old('lokasi', $barang->lokasi) }}" required>
                @error('lokasi')
                    <span class="form-error">{{ $message }}</span>
                @enderror
            </div>

            <div class="form-actions">
                <button type="submit" class="btn btn-primary">{{ __('Simpan Perubahan') }}</button>
                <a href="{{ route('admin.barang.index') }}" class="btn btn-outline">{{ __('Batal') }}</a>
            </div>
        </form>
    </div>
@endsection
