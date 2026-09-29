@extends('layouts.guest')

@section('content')
<div class="auth-shell">
    <div class="auth-topbrand">
        <span class="icon-chip">
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="18" height="18" fill="none" stroke="currentColor" stroke-width="1.8">
                <path d="M12 2 3 6v6c0 5 4 8.5 9 10 5-1.5 9-5 9-10V6l-9-4Z"/>
                <path d="M9 12.5 11 14.5 15.5 9.5"/>
            </svg>
        </span>
        Sistem Peminjaman Pramuka
    </div>

    <div class="auth-card">
        <div class="auth-badge-wrap">
            <div class="auth-badge">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="24" height="24" fill="none" stroke="currentColor" stroke-width="1.6">
                    <path d="M12 2 3 6v6c0 5 4 8.5 9 10 5-1.5 9-5 9-10V6l-9-4Z"/>
                    <path d="M9 12.5 11 14.5 15.5 9.5"/>
                </svg>
            </div>
        </div>

        <h1 class="auth-heading">Selamat datang <em>kembali</em></h1>
        <p class="auth-subheading">Masuk untuk mengelola inventaris & peminjaman barang</p>

        @if (session('error'))
            <div class="alert-flash">{{ session('error') }}</div>
        @endif

        <form method="POST" action="{{ route('login') }}">
            @csrf

            <div class="field-group">
                <label for="email" class="field-label">{{ __('Email') }}</label>
                <div class="field-shell @error('email') has-error @enderror">
                    <input id="email" type="email" name="email" value="{{ old('email') }}"
                           placeholder="nama@gmail.com" required autocomplete="email" autofocus>
                </div>
                @error('email')
                    <span class="field-error">{{ $message }}</span>
                @enderror
            </div>

            <div class="field-group">
                <label for="password" class="field-label">{{ __('Password') }}</label>
                <div class="field-shell @error('password') has-error @enderror">
                    <input id="password" type="password" name="password" required autocomplete="current-password">
                    <button class="field-toggle" type="button" id="togglePassword" tabindex="-1">{{ __('Lihat') }}</button>
                </div>
                @error('password')
                    <span class="field-error">{{ $message }}</span>
                @enderror
            </div>

            <div class="field-row">
                <label class="field-check">
                    <input type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>
                    {{ __('Ingat saya') }}
                </label>

                @if (Route::has('password.request'))
                    <a class="link-muted" href="{{ route('password.request') }}">{{ __('Lupa password?') }}</a>
                @endif
            </div>

            <button type="submit" class="btn-brown">{{ __('Masuk') }}</button>

            @if (Route::has('register'))
                <div class="auth-divider">atau</div>
                <p class="auth-foot">
                    {{ __('Belum punya akun?') }}
                    <a class="link-muted" href="{{ route('register') }}">{{ __('Daftar di sini') }}</a>
                </p>
            @endif
        </form>
    </div>
</div>

<script>
    const togglePassword = document.getElementById('togglePassword');
    const passwordInput = document.getElementById('password');
    if (togglePassword && passwordInput) {
        togglePassword.addEventListener('click', function () {
            const isHidden = passwordInput.type === 'password';
            passwordInput.type = isHidden ? 'text' : 'password';
            togglePassword.textContent = isHidden ? '{{ __('Sembunyikan') }}' : '{{ __('Lihat') }}';
        });
    }
</script>
@endsection
