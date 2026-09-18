@extends('layouts.admin')

@section('page-title', __('Kelola Profil Admin'))
@section('page-subtitle', __('Dashboard Admin / Kelola Profil Admin'))
@section('page-icon')
    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="20" height="20" fill="none" stroke="currentColor"
        stroke-width="2">
        <circle cx="12" cy="8" r="4" />
        <path d="M4 21a8 8 0 0 1 16 0" />
    </svg>
@endsection

@section('content')
    <div class="form-card" style="text-align:center;">
        <form method="POST" action="{{ route('admin.profil.update') }}" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <div class="form-group">
                <div class="profile-photo-wrapper">
                    @if ($admin->foto)
                        <img id="fotoPreview" src="{{ asset('storage/' . $admin->foto) }}" alt="Foto profil">
                    @else
                        <div id="fotoPreview" class="profile-photo-placeholder">{{ __('Foto') }}</div>
                    @endif
                </div>

                <div class="profile-photo-input">
                    <input type="file" id="foto" name="foto" accept="image/*"
                        class="form-control @error('foto') is-invalid @enderror" onchange="previewFoto(this)">
                    @error('foto')
                        <span class="form-error">{{ $message }}</span>
                    @enderror
                </div>
            </div>

            <div class="form-group" style="text-align:left;">
                <label for="nama" class="form-label">{{ __('Nama Lengkap') }}</label>
                <input id="nama" type="text" class="form-control @error('nama') is-invalid @enderror" name="nama"
                    value="{{ old('nama', $admin->nama) }}" required autofocus>
                @error('nama')
                    <span class="form-error">{{ $message }}</span>
                @enderror
            </div>

            <div class="form-group" style="text-align:left;">
                <label for="email" class="form-label">{{ __('Email') }}</label>
                <input id="email" type="email" class="form-control @error('email') is-invalid @enderror"
                    name="email" value="{{ old('email', $admin->email) }}" required>
                @error('email')
                    <span class="form-error">{{ $message }}</span>
                @enderror
            </div>

            <div class="form-group" style="text-align:left;">
                <label for="no_telepon" class="form-label">{{ __('No. Telepon') }}</label>
                <input id="no_telepon" type="text" class="form-control @error('no_telepon') is-invalid @enderror"
                    name="no_telepon" value="{{ old('no_telepon', $admin->no_telepon) }}" placeholder="08xx-xxxx-xxxx">
                @error('no_telepon')
                    <span class="form-error">{{ $message }}</span>
                @enderror
            </div>

            <div class="form-group" style="text-align:left;">
                <label for="password" class="form-label">{{ __('Password Baru') }}</label>
                <input id="password" type="password" class="form-control @error('password') is-invalid @enderror"
                    name="password" placeholder="{{ __('Kosongkan jika tidak ingin mengubah password') }}">
                @error('password')
                    <span class="form-error">{{ $message }}</span>
                @enderror
            </div>

            <div class="form-actions" style="justify-content:center;">
                <button type="submit" class="btn btn-primary">{{ __('Simpan Perubahan') }}</button>
            </div>
        </form>
    </div>

    <script>
        function previewFoto(input) {
            if (!input.files || !input.files[0]) return;
            const reader = new FileReader();
            const wrapper = input.closest('.form-group').querySelector('.profile-photo-wrapper');
            reader.onload = function(e) {
                wrapper.innerHTML = '<img src="' + e.target.result + '" alt="Foto profil">';
            };
            reader.readAsDataURL(input.files[0]);
        }
    </script>
@endsection
