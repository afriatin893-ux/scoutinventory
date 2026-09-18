@extends('layouts.admin')

@section('page-title', 'Tambah Kategori Barang')
@section('page-subtitle', 'Dashboard Admin / Kelola Kategori Barang / Tambah')
@section('page-icon')
    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="20" height="20" fill="none" stroke="currentColor"
        stroke-width="2">
        <path
            d="M20.59 13.41 11 3.83A2 2 0 0 0 9.59 3.24H4a1 1 0 0 0-1 1v5.59a2 2 0 0 0 .59 1.41l9.58 9.58a2 2 0 0 0 2.83 0l5.59-5.59a2 2 0 0 0 0-2.82Z" />
        <circle cx="7.5" cy="7.5" r="1.2" />
    </svg>

@section('content')
    <div class="form-card">
        <form method="POST" action="{{ route('admin.kategori.store') }}">
            @csrf

            <div class="form-group">
                <label for="nama_kategori" class="form-label">{{ 'Nama Kategori' }}</label>
                <input id="nama_kategori" type="text" class="form-control @error('nama_kategori') is-invalid @enderror"
                    name="nama_kategori" value="{{ old('nama_kategori') }}" placeholder="{{ 'Contoh: Perkemahan' }}"
                    required autofocus>
                @error('nama_kategori')
                    <span class="form-error">{{ $message }}</span>
                @enderror
            </div>

            <div class="form-group">
                <label for="deskripsi" class="form-label">{{ 'Deskripsi' }}</label>
                <textarea id="deskripsi" rows="5" class="form-control @error('deskripsi') is-invalid @enderror" name="deskripsi"
                    placeholder="{{ 'Deskripsi singkat kategori (opsional)' }}">{{ old('deskripsi') }}</textarea>
                @error('deskripsi')
                    <span class="form-error">{{ $message }}</span>
                @enderror
            </div>

            <div class="form-actions">
                <button type="submit" class="btn btn-primary">{{ __('Simpan Perubahan') }}</button>
                <a href="{{ route('admin.kategori.index') }}" class="btn btn-outline">{{ 'Batal' }}</a>
            </div>
        </form>
    </div>
@endsection
