@extends('layouts.peminjam')

@section('page-title', __('Kelola Profil Peminjaman'))
@section('page-subtitle', __('Dashboard Peminjaman / Kelola Profil Peminjaman'))

@section('content')
<div class="card bg-white" style="max-width: 640px;">
    <div class="card-body p-4">
        <form method="POST" action="{{ route('peminjam.profil.update') }}" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <div class="mb-4 text-center">
                <div class="profile-photo-wrapper">
                    @if ($peminjam->foto)
                        <img id="fotoPreview" src="{{ asset('storage/'.$peminjam->foto) }}" alt="Foto profil">
                    @else
                        <div id="fotoPreview" class="profile-photo-placeholder">{{ __('Foto') }}</div>
                    @endif
                </div>

                <div class="profile-photo-input">
                    <input type="file" id="foto" name="foto" accept="image/*"
                           class="form-control form-control-sm @error('foto') is-invalid @enderror"
                           onchange="previewFoto(this)">

                    @error('foto')
                        <span class="invalid-feedback d-block" role="alert"><strong>{{ $message }}</strong></span>
                    @enderror
                </div>
            </div>

            <div class="mb-3">
                <label for="nama" class="form-label fw-semibold">{{ __('Nama Lengkap') }}</label>
                <input id="nama" type="text" class="form-control @error('nama') is-invalid @enderror"
                       name="nama" value="{{ old('nama', $peminjam->nama) }}" required autofocus>

                @error('nama')
                    <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                @enderror
            </div>

            <div class="mb-3">
                <label for="asal_organisasi" class="form-label fw-semibold">{{ __('Asal Organisasi') }}</label>
                <input id="asal_organisasi" type="text" class="form-control @error('asal_organisasi') is-invalid @enderror"
                       name="asal_organisasi" value="{{ old('asal_organisasi', $peminjam->asal_organisasi) }}" required>

                @error('asal_organisasi')
                    <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                @enderror
            </div>

            <div class="mb-3">
                <label for="email" class="form-label fw-semibold">{{ __('Email') }}</label>
                <input id="email" type="email" class="form-control @error('email') is-invalid @enderror"
                       name="email" value="{{ old('email', $peminjam->email) }}" required>

                @error('email')
                    <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                @enderror
            </div>

            <div class="mb-3">
                <label for="no_telepon" class="form-label fw-semibold">{{ __('No. Telepon') }}</label>
                <input id="no_telepon" type="text" class="form-control @error('no_telepon') is-invalid @enderror"
                       name="no_telepon" value="{{ old('no_telepon', $peminjam->no_telepon) }}" placeholder="08xx-xxxx-xxxx">

                @error('no_telepon')
                    <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                @enderror
            </div>

            <div class="mb-3">
                <label for="password" class="form-label fw-semibold">{{ __('Password Baru') }}</label>
                <input id="password" type="password" class="form-control @error('password') is-invalid @enderror"
                       name="password" placeholder="{{ __('Kosongkan jika tidak ingin mengubah password') }}">

                @error('password')
                    <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                @enderror
            </div>

            <div class="mb-4">
                <label for="password_confirmation" class="form-label fw-semibold">{{ __('Konfirmasi Password Baru') }}</label>
                <input id="password_confirmation" type="password" class="form-control" name="password_confirmation">
            </div>

            <button type="submit" class="btn btn-dark">{{ __('Simpan Perubahan') }}</button>
        </form>
    </div>
</div>

<script>
    function previewFoto(input) {
        if (!input.files || !input.files[0]) return;
        const reader = new FileReader();
        const wrapper = input.closest('.mb-4').querySelector('.profile-photo-wrapper');
        reader.onload = function (e) {
            wrapper.innerHTML = '<img src="' + e.target.result + '" alt="Foto profil">';
        };
        reader.readAsDataURL(input.files[0]);
    }
</script>
@endsection
