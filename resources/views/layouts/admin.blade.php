<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Sistem Peminjaman') }} - Admin</title>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=Nunito" rel="stylesheet">

    <!-- Scripts -->
    @vite(['resources/sass/app.scss', 'resources/js/app.js'])
</head>

<body>
    <div class="app-shell">
        <header class="app-topbar">
            <span class="app-topbar-title">{{ __('Sistem Peminjaman - Admin') }}</span>

            <div class="dropdown">
                <a href="#" class="app-topbar-user dropdown-toggle d-flex align-items-center gap-2" id="adminMenu"
                    role="button" data-bs-toggle="dropdown" aria-expanded="false">
                    @if (Auth::guard('admin')->user()->foto)
                        <img src="{{ asset('storage/' . Auth::guard('admin')->user()->foto) }}" alt="Foto admin"
                            style="width:28px;height:28px;object-fit:cover;border-radius:50%;">
                    @else
                        <span class="status-dot"></span>
                    @endif
                    {{ Auth::guard('admin')->user()->nama ?? __('Admin') }}
                </a>
                <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="adminMenu">
                    <li><a class="dropdown-item" href="{{ route('admin.profil.edit') }}">{{ __('Profil Saya') }}</a>
                    </li>
                    <li>
                        <a class="dropdown-item" href="{{ route('logout') }}"
                            onclick="event.preventDefault(); document.getElementById('admin-logout-form').submit();">
                            {{ __('Logout') }}
                        </a>
                        <form id="admin-logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                            @csrf
                        </form>
                    </li>
                </ul>
            </div>
        </header>

        <div class="app-body">
            <aside class="app-sidebar">
                <nav>
                    <a href="{{ route('admin.dashboard') }}"
                        class="sidebar-link {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
                        {{ __('Dashboard') }}
                    </a>
                    <a href="{{ route('admin.kategori.index') }}"
                        class="sidebar-link {{ request()->routeIs('admin.kategori.*') ? 'active' : '' }}">
                        {{ __('Kelola Kategori Barang') }}
                    </a>
                    <a href="{{ route('admin.barang.index') }}"
                        class="sidebar-link {{ request()->routeIs('admin.barang.*') ? 'active' : '' }}">
                        {{ __('Kelola Data Barang') }}
                    </a>
                    <a href="{{ route('admin.peminjaman.pending') }}"
                        class="sidebar-link {{ request()->routeIs('admin.peminjaman.pending') || (request()->routeIs('admin.peminjaman.show') && request('from') === 'verifikasi') ? 'active' : '' }}">
                        {{ 'Verifikasi Pengajuan' }}
                    </a>
                    <a href="{{ route('admin.pengembalian.index') }}"
                        class="sidebar-link {{ request()->routeIs('admin.pengembalian.*') ? 'active' : '' }}">
                        {{ 'Catat Pengembalian' }}
                    </a>
                    <a href="{{ route('admin.peminjaman.index') }}"
                        class="sidebar-link {{ request()->routeIs('admin.peminjaman.index') || (request()->routeIs('admin.peminjaman.show') && request('from') !== 'verifikasi') ? 'active' : '' }}">
                        {{ 'Riwayat Peminjaman' }}
                    </a>
                    <a href="{{ route('admin.profil.edit') }}"
                        class="sidebar-link {{ request()->routeIs('admin.profil.*') ? 'active' : '' }}">
                        {{ __('Profil Admin') }}
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

                @if (session('success'))
                    <div class="alert alert-success" role="alert">{{ session('success') }}</div>
                @endif

                @if (session('error'))
                    <div class="alert alert-danger" role="alert">{{ session('error') }}</div>
                @endif

                @yield('content')
            </main>
        </div>
    </div>
</body>

</html>
