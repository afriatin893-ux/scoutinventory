@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Edit Kategori') }}</div>

                <div class="card-body">
                    <form method="POST" action="{{ route('admin.kategori.update', $kategori->id_kategori) }}">
                        @csrf
                        @method('PUT')

                        <div class="mb-3">
                            <label for="nama_kategori" class="form-label">{{ __('Nama Kategori') }}</label>
                            <input id="nama_kategori" type="text"
                                   class="form-control @error('nama_kategori') is-invalid @enderror"
                                   name="nama_kategori" value="{{ old('nama_kategori', $kategori->nama_kategori) }}" required autofocus>

                            @error('nama_kategori')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        <button type="submit" class="btn btn-primary">{{ __('Simpan Perubahan') }}</button>
                        <a href="{{ route('admin.kategori.index') }}" class="btn btn-link">{{ __('Batal') }}</a>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
