@extends('layouts.guest')

@section('content')
<div class="auth-shell">

    <div class="auth-topbrand">
        <div class="icon-chip">
            🛡️
        </div>
        <span>Sistem Peminjaman Pramuka</span>
    </div>

    <div class="auth-card">

        <div class="auth-badge-wrap">
            <div class="auth-badge">
                🛡️
            </div>
        </div>

        <div style="text-align: center;">
            <div class="auth-eyebrow">
                Buat Akun
            </div>

            <h1 class="auth-heading">
                Daftar sebagai Peminjam
            </h1>

            <p class="auth-subheading">
                Buat akun untuk mengajukan peminjaman barang Pramuka.
            </p>
        </div>

        @if ($errors->any())
            <div class="alert-flash">
                <div>
                    <strong>Periksa kembali data yang kamu masukkan.</strong>
                </div>
            </div>
        @endif

        <form method="POST" action="{{ route('register') }}">
            @csrf

            {{-- Nama --}}
            <div class="field-group">
                <label for="nama" class="field-label">
                    Nama
                </label>

                <div class="field-shell @error('nama') has-error @enderror">
                    <div class="field-icon">
                        👤
                    </div>

                    <input
                        id="nama"
                        type="text"
                        name="nama"
                        value="{{ old('nama') }}"
                        placeholder="Masukkan nama lengkap"
                        required
                        autofocus
                    >
                </div>

                @error('nama')
                    <span class="field-error">{{ $message }}</span>
                @enderror
            </div>

            {{-- Asal Organisasi --}}
            <div class="field-group">
                <label for="asal_organisasi" class="field-label">
                    Asal Organisasi
                </label>

                <div class="field-shell @error('asal_organisasi') has-error @enderror">
                    <div class="field-icon">
                        🏢
                    </div>

                    <input
                        id="asal_organisasi"
                        type="text"
                        name="asal_organisasi"
                        value="{{ old('asal_organisasi') }}"
                        placeholder="Contoh: OSIS"
                        required
                    >
                </div>

                @error('asal_organisasi')
                    <span class="field-error">{{ $message }}</span>
                @enderror
            </div>

            {{-- Email --}}
            <div class="field-group">
                <label for="email" class="field-label">
                    Email
                </label>

                <div class="field-shell @error('email') has-error @enderror">
                    <div class="field-icon">
                        ✉️
                    </div>

                    <input
                        id="email"
                        type="email"
                        name="email"
                        value="{{ old('email') }}"
                        placeholder="Masukkan alamat email"
                        required
                    >
                </div>

                @error('email')
                    <span class="field-error">{{ $message }}</span>
                @enderror
            </div>

            {{-- Password --}}
            <div class="field-group">
                <label for="password" class="field-label">
                    Password
                </label>

                <div class="field-shell @error('password') has-error @enderror">
                    <div class="field-icon">
                        🔒
                    </div>

                    <input
                        id="password"
                        type="password"
                        name="password"
                        placeholder="Masukkan password"
                        required
                    >

                    <button
                        type="button"
                        class="field-toggle"
                        onclick="togglePassword('password', this)"
                    >
                        Lihat
                    </button>
                </div>

                @error('password')
                    <span class="field-error">{{ $message }}</span>
                @enderror
            </div>

            {{-- Konfirmasi Password --}}
            <div class="field-group">
                <label for="password-confirm" class="field-label">
                    Konfirmasi Password
                </label>

                <div class="field-shell">
                    <div class="field-icon">
                        🔒
                    </div>

                    <input
                        id="password-confirm"
                        type="password"
                        name="password_confirmation"
                        placeholder="Ulangi password"
                        required
                    >

                    <button
                        type="button"
                        class="field-toggle"
                        onclick="togglePassword('password-confirm', this)"
                    >
                        Lihat
                    </button>
                </div>
            </div>

            <button type="submit" class="btn-brown">
                Daftar Akun →
            </button>
        </form>

        <div class="auth-divider">
            atau
        </div>

        <div class="auth-foot">
            Sudah punya akun?
            <a href="{{ route('login') }}" class="link-muted">
                Masuk di sini
            </a>
        </div>

    </div>

    <div class="auth-bottom-note">
        © {{ date('Y') }} Sistem Peminjaman Pramuka
    </div>

</div>

<script>
    function togglePassword(id, button) {
        const input = document.getElementById(id);

        if (input.type === 'password') {
            input.type = 'text';
            button.textContent = 'Sembunyikan';
        } else {
            input.type = 'password';
            button.textContent = 'Lihat';
        }
    }
</script>
@endsection
