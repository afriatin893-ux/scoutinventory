@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Edit Barang') }}</div>

                <div class="card-body">
                    <form method="POST" action="{{ route('admin.barang.update', $barang->id_barang) }}" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')

                        <div class="mb-3">
                            <label for="id_kategori" class="form-label">{{ __('Kategori') }}</label>
                            <select id="id_kategori" name="id_kategori" class="form-select @error('id_kategori') is-invalid @enderror" required>
                                <option value="">{{ __('-- Pilih Kategori --') }}</option>
                                @foreach ($kategoris as $kategori)
                                    <option value="{{ $kategori->id_kategori }}" {{ old('id_kategori', $barang->id_kategori) == $kategori->id_kategori ? 'selected' : '' }}>
                                        {{ $kategori->nama_kategori }}
                                    </option>
                                @endforeach
                            </select>
                            @error('id_kategori')<span class="invalid-feedback">{{ $message }}</span>@enderror
                        </div>

                        <div class="mb-3">
                            <label for="kode_barang" class="form-label">{{ __('Kode Barang') }}</label>
                            <input id="kode_barang" type="text" class="form-control @error('kode_barang') is-invalid @enderror"
                                   name="kode_barang" value="{{ old('kode_barang', $barang->kode_barang) }}" required>
                            @error('kode_barang')<span class="invalid-feedback">{{ $message }}</span>@enderror
                        </div>

                        <div class="mb-3">
                            <label for="nama_barang" class="form-label">{{ __('Nama Barang') }}</label>
                            <input id="nama_barang" type="text" class="form-control @error('nama_barang') is-invalid @enderror"
                                   name="nama_barang" value="{{ old('nama_barang', $barang->nama_barang) }}" required>
                            @error('nama_barang')<span class="invalid-feedback">{{ $message }}</span>@enderror
                        </div>

                        <div class="mb-3">
                            <label for="foto" class="form-label">{{ __('Foto Barang') }}</label>
                            @if ($barang->foto)
                                <div class="mb-2">
                                    <img src="{{ asset('storage/'.$barang->foto) }}" alt="Foto barang" style="width:90px;height:90px;object-fit:cover;border-radius:.5rem;">
                                </div>
                            @endif
                            <input id="foto" type="file" accept="image/*" class="form-control @error('foto') is-invalid @enderror" name="foto">
                            <div class="form-text">{{ __('Kosongkan jika tidak ingin mengubah foto.') }}</div>
                            @error('foto')<span class="invalid-feedback">{{ $message }}</span>@enderror
                        </div>

                        <div class="row">
                            <div class="col-md-4 mb-3">
                                <label for="stok" class="form-label">{{ __('Stok') }}</label>
                                <input id="stok" type="number" min="0" class="form-control @error('stok') is-invalid @enderror"
                                       name="stok" value="{{ old('stok', $barang->stok) }}" required>
                                @error('stok')<span class="invalid-feedback">{{ $message }}</span>@enderror
                            </div>

                            <div class="col-md-4 mb-3">
                                <label for="kondisi" class="form-label">{{ __('Kondisi') }}</label>
                                <select id="kondisi" name="kondisi" class="form-select @error('kondisi') is-invalid @enderror" required>
                                    @foreach (['Baik', 'Rusak Ringan', 'Rusak Berat'] as $opsi)
                                        <option value="{{ $opsi }}" {{ old('kondisi', $barang->kondisi) === $opsi ? 'selected' : '' }}>{{ $opsi }}</option>
                                    @endforeach
                                </select>
                                @error('kondisi')<span class="invalid-feedback">{{ $message }}</span>@enderror
                            </div>

                            <div class="col-md-4 mb-3">
                                <label for="tanggal_pengadaan" class="form-label">{{ __('Tanggal Pengadaan') }}</label>
                                <input id="tanggal_pengadaan" type="date" class="form-control @error('tanggal_pengadaan') is-invalid @enderror"
                                       name="tanggal_pengadaan" value="{{ old('tanggal_pengadaan', \Illuminate\Support\Carbon::parse($barang->tanggal_pengadaan)->format('Y-m-d')) }}" required>
                                @error('tanggal_pengadaan')<span class="invalid-feedback">{{ $message }}</span>@enderror
                            </div>
                        </div>

                        <div class="mb-3">
                            <label for="lokasi" class="form-label">{{ __('Lokasi Penyimpanan') }}</label>
                            <input id="lokasi" type="text" class="form-control @error('lokasi') is-invalid @enderror"
                                   name="lokasi" value="{{ old('lokasi', $barang->lokasi) }}" required>
                            @error('lokasi')<span class="invalid-feedback">{{ $message }}</span>@enderror
                        </div>

                        <button type="submit" class="btn btn-primary">{{ __('Simpan Perubahan') }}</button>
                        <a href="{{ route('admin.barang.index') }}" class="btn btn-link">{{ __('Batal') }}</a>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
