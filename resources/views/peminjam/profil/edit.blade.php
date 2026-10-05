@extends('layouts.peminjam')

@section('page-title', __('Kelola Profil Saya'))
@section('page-subtitle', __('Dashboard Peminjam / Kelola Profil Saya'))
@section('page-icon')
    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="20" height="20" fill="none" stroke="currentColor" stroke-width="2">
        <circle cx="12" cy="8" r="4"/><path d="M4 21a8 8 0 0 1 16 0"/>
    </svg>
@endsection

@section('content')
<form method="POST" action="{{ route('peminjam.profil.update') }}" enctype="multipart/form-data" class="profile-layout">
    @csrf
    @method('PUT')

    <div class="panel">
        <div class="panel-body profile-side">
            <div class="form-group">
                <div class="profile-photo-wrapper">
                    @if ($peminjam->foto)
                        <img id="fotoPreview" src="{{ asset('storage/'.$peminjam->foto) }}" alt="Foto profil">
                    @else
                        <div id="fotoPreview" class="profile-photo-placeholder">{{ $peminjam->inisial }}</div>
                    @endif
                </div>

                <div class="profile-side-name">{{ $peminjam->nama }}</div>
                <div class="profile-side-org">{{ $peminjam->asal_organisasi }}</div>

                <label for="foto" class="btn btn-outline btn-sm">{{ __('Ganti Foto') }}</label>
                <input type="file" id="foto" name="foto" accept="image/*" class="visually-hidden" onchange="previewFoto(this)">
                @error('foto')
                    <span class="form-error">{{ $message }}</span>
                @enderror
            </div>
        </div>
    </div>

    <div class="panel">
        <div class="panel-header">{{ __('Data Diri') }}</div>
        <div class="panel-body">
            <div class="form-grid">
                <div class="form-group">
                    <label for="nama" class="form-label">{{ __('Nama Lengkap') }}</label>
                    <input id="nama" type="text" class="form-control @error('nama') is-invalid @enderror"
                           name="nama" value="{{ old('nama', $peminjam->nama) }}" required autofocus>
                    @error('nama') <span class="form-error">{{ $message }}</span> @enderror
                </div>

                <div class="form-group">
                    <label for="asal_organisasi" class="form-label">{{ __('Asal Organisasi') }}</label>
                    <input id="asal_organisasi" type="text" class="form-control @error('asal_organisasi') is-invalid @enderror"
                           name="asal_organisasi" value="{{ old('asal_organisasi', $peminjam->asal_organisasi) }}" required>
                    @error('asal_organisasi') <span class="form-error">{{ $message }}</span> @enderror
                </div>

                <div class="form-group">
                    <label for="email" class="form-label">{{ __('Email') }}</label>
                    <input id="email" type="email" class="form-control @error('email') is-invalid @enderror"
                           name="email" value="{{ old('email', $peminjam->email) }}" required>
                    @error('email') <span class="form-error">{{ $message }}</span> @enderror
                </div>

                <div class="form-group">
                    <label for="no_telepon" class="form-label">{{ __('No. Telepon') }}</label>
                    <input id="no_telepon" type="text" class="form-control @error('no_telepon') is-invalid @enderror"
                           name="no_telepon" value="{{ old('no_telepon', $peminjam->no_telepon) }}" placeholder="08xx-xxxx-xxxx">
                    @error('no_telepon') <span class="form-error">{{ $message }}</span> @enderror
                </div>
            </div>
        </div>

        <div class="panel-header" style="border-top:1px solid var(--border);">{{ __('Ubah Password') }}</div>
        <div class="panel-body">
            <div class="form-grid">
                <div class="form-group">
                    <label for="password" class="form-label">{{ __('Password Baru') }}</label>
                    <input id="password" type="password" class="form-control @error('password') is-invalid @enderror"
                           name="password" placeholder="{{ __('Kosongkan jika tidak diubah') }}">
                    @error('password') <span class="form-error">{{ $message }}</span> @enderror
                </div>

                <div class="form-group">
                    <label for="password_confirmation" class="form-label">{{ __('Konfirmasi Password Baru') }}</label>
                    <input id="password_confirmation" type="password" class="form-control" name="password_confirmation">
                </div>
            </div>

            <button type="submit" class="btn btn-primary">{{ __('Simpan Perubahan') }}</button>
        </div>
    </div>
</form>

<script>
    function previewFoto(input) {
        if (!input.files || !input.files[0]) return;
        const reader = new FileReader();
        const wrapper = input.closest('.form-group').querySelector('.profile-photo-wrapper');
        reader.onload = function (e) {
            wrapper.innerHTML = '<img src="' + e.target.result + '" alt="Foto profil">';
        };
        reader.readAsDataURL(input.files[0]);
    }
</script>
@endsection
