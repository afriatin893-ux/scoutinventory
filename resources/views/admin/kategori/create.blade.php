@extends('layouts.admin')

@section('page-title', __('Tambah Kategori Barang'))
@section('page-subtitle', __('Dashboard Admin / Kelola Kategori Barang / Tambah'))

@section('content')
<div class="card bg-white" style="max-width: 640px;">
    <div class="card-body p-4">
        <form method="POST" action="{{ route('admin.kategori.store') }}">
            @csrf

            <div class="mb-4">
                <label for="nama_kategori" class="form-label fw-semibold">{{ __('Nama Kategori') }}</label>
                <input id="nama_kategori" type="text"
                       class="form-control @error('nama_kategori') is-invalid @enderror" name="nama_kategori"
                       value="{{ old('nama_kategori') }}" placeholder="{{ __('Contoh: Perkemahan') }}" required autofocus>

                @error('nama_kategori')
                    <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                @enderror
            </div>

            <div class="mb-4">
                <label for="deskripsi" class="form-label fw-semibold">{{ __('Deskripsi') }}</label>
                <textarea id="deskripsi" rows="5" class="form-control @error('deskripsi') is-invalid @enderror"
                          name="deskripsi" placeholder="{{ __('Deskripsi singkat kategori (opsional)') }}">{{ old('deskripsi') }}</textarea>

                @error('deskripsi')
                    <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                @enderror
            </div>

            <button type="submit" class="btn btn-dark">{{ __('Simpan Perubahan') }}</button>
            <a href="{{ route('admin.kategori.index') }}" class="btn btn-outline-secondary">{{ __('Batal') }}</a>
        </form>
    </div>
</div>
@endsection
