<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Sistem Peminjaman') }} - Peminjam</title>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=Nunito" rel="stylesheet">

    <!-- Scripts -->
    @vite(['resources/sass/app.scss', 'resources/js/app.js'])
</head>
<body>
    <div class="app-shell">
        <header class="app-topbar">
            <span class="app-topbar-title">{{ __('Sistem Peminjaman - Peminjam') }}</span>

            <div class="dropdown">
                <a href="#" class="app-topbar-user dropdown-toggle" id="peminjamMenu" role="button"
                   data-bs-toggle="dropdown" aria-expanded="false">
                    {{ Auth::guard('peminjam')->user()->nama ?? __('Peminjam') }}
                    <span class="status-dot"></span>
                </a>
                <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="peminjamMenu">
                    <li><a class="dropdown-item" href="{{ route('peminjam.profil.edit') }}">{{ __('Profil Saya') }}</a></li>
                    <li>
                        <a class="dropdown-item" href="{{ route('logout') }}"
                           onclick="event.preventDefault(); document.getElementById('peminjam-logout-form').submit();">
                            {{ __('Logout') }}
                        </a>
                        <form id="peminjam-logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                            @csrf
                        </form>
                    </li>
                </ul>
            </div>
        </header>

        <div class="app-body">
            <aside class="app-sidebar">
                <nav>
                    <a href="{{ route('peminjam.dashboard') }}"
                       class="sidebar-link {{ request()->routeIs('peminjam.dashboard') ? 'active' : '' }}">
                        {{ __('Dashboard') }}
                    </a>
                    <a href="{{ route('peminjam.kategori.index') }}"
                       class="sidebar-link {{ request()->routeIs('peminjam.kategori.*') ? 'active' : '' }}">
                        {{ __('Kelola Kategori Barang') }}
                    </a>
                    <a href="#" class="sidebar-link disabled" onclick="return false;">
                        {{ __('Form Pengajuan') }}
                    </a>
                    <a href="#" class="sidebar-link disabled" onclick="return false;">
                        {{ __('Status Peminjaman') }}
                    </a>
                    <a href="#" class="sidebar-link disabled" onclick="return false;">
                        {{ __('Riwayat Peminjaman') }}
                    </a>
                    <a href="{{ route('peminjam.profil.edit') }}"
                       class="sidebar-link {{ request()->routeIs('peminjam.profil.*') ? 'active' : '' }}">
                        {{ __('Profil Saya') }}
                    </a>
                </nav>
            </aside>

            <main class="app-content">
                @hasSection('page-title')
                    <div class="page-header">
                        <h1>@yield('page-title')</h1>
                        @hasSection('page-subtitle')
                            <p class="page-subtitle">@yield('page-subtitle')</p>
                        @endif
                    </div>
                @endif

                @if (session('status'))
                    <div class="alert alert-success" role="alert">{{ session('status') }}</div>
                @endif

                @if (session('success'))
                    <div class="alert alert-success" role="alert">{{ session('success') }}</div>
                @endif

                @yield('content')
            </main>
        </div>
    </div>
</body>
</html>
