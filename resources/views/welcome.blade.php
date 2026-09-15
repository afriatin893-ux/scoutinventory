<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ config('app.name', 'Sistem Peminjaman Pramuka') }}</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">

    <link rel="stylesheet" href="{{ asset('css/welcome.css') }}">
</head>
<body>
    <div class="hero">
        <div class="hero-nav">
            <div class="hero-brand">
                <span class="icon-chip">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="19" height="19" fill="none" stroke="currentColor" stroke-width="1.8">
                        <path d="M12 2 3 6v6c0 5 4 8.5 9 10 5-1.5 9-5 9-10V6l-9-4Z"/>
                        <path d="M9 12.5 11 14.5 15.5 9.5"/>
                    </svg>
                </span>
                Sistem Peminjaman Pramuka
            </div>

            @if (Route::has('login'))
                <a href="{{ route('login') }}" class="btn-login">
                    Login
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="15" height="15" fill="none" stroke="currentColor" stroke-width="2.4">
                        <path d="M5 12h14M13 6l6 6-6 6"/>
                    </svg>
                </a>
            @endif
        </div>

        <div class="hero-content">
            <span class="hero-eyebrow">GIAT PRASEDA A23</span>
            <h1 class="hero-title">Kelola Peminjaman Barang Pramuka</h1>
            <p class="hero-sub">
                Ajukan peminjaman, kelola inventaris, dan pantau pengembalian barang dalam satu sistem yang terorganisir.</p>

            <div class="hero-actions">
                @if (Route::has('login'))
                    <a href="{{ route('login') }}" class="btn-hero-primary">
                        Masuk ke Akun
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="16" height="16" fill="none" stroke="currentColor" stroke-width="2.4">
                            <path d="M5 12h14M13 6l6 6-6 6"/>
                        </svg>
                    </a>
                @endif
                @if (Route::has('register'))
                    <a href="{{ route('register') }}" class="btn-hero-secondary">Daftar akun baru</a>
                @endif
            </div>

            <div class="hero-stats">
                <div class="hero-stat">
                    <b>Praktis</b>
                    <span>Kelola barang dengan mudah</span>
                </div>
                <div class="hero-stat">
                    <b>Teratur</b>
                    <span>Data tersusun rapi</span>
                </div>
                <div class="hero-stat">
                    <b>Terpantau</b>
                    <span>Peminjaman tercatat</span>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
