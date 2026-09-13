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

            @php
                $unread = Auth::guard('peminjam')->user()->unreadNotifications;
            @endphp
            <div class="dropdown">
                <a href="#" class="nav-link position-relative" data-bs-toggle="dropdown">
                    🔔
                    @if ($unread->count())
                        <span class="badge bg-danger position-absolute top-0 start-100 translate-middle">
                            {{ $unread->count() }}
                        </span>
                    @endif
                </a>
                <ul class="dropdown-menu dropdown-menu-end p-2" style="min-width:280px;">
                    @forelse ($unread as $n)
                        <li class="small border-bottom py-1">{{ $n->data['pesan'] }}</li>
                    @empty
                        <li class="small text-muted">{{ __('Tidak ada notifikasi baru.') }}</li>
                    @endforelse
                </ul>
            </div>

            <div class="dropdown">
                <a href="#" class="app-topbar-user dropdown-toggle d-flex align-items-center gap-2"
                    id="peminjamMenu" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                    @if (Auth::guard('peminjam')->user()->foto)
                        <img src="{{ asset('storage/' . Auth::guard('peminjam')->user()->foto) }}" alt="Foto peminjam"
                            style="width:28px;height:28px;object-fit:cover;border-radius:50%;">
                    @else
                        <span class="status-dot"></span>
                    @endif
                    {{ Auth::guard('peminjam')->user()->nama ?? __('Peminjam') }}
                </a>
                <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="peminjamMenu">
                    <li><a class="dropdown-item" href="{{ route('peminjam.profil.edit') }}">{{ __('Profil Saya') }}</a>
                    </li>
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
                    <a href="{{ route('peminjam.barang.index') }}"
                        class="sidebar-link {{ request()->routeIs('peminjam.barang.*') ? 'active' : '' }}">
                        {{ __('Lihat Barang') }}
                    </a>
                    <a href="{{ route('peminjam.peminjaman.create') }}"
                        class="sidebar-link {{ request()->routeIs('peminjam.peminjaman.create') ? 'active' : '' }}">
                        {{ __('Form Pengajuan') }}
                    </a>
                    <a href="{{ route('peminjam.status.index') }}"
                        class="sidebar-link {{ request()->routeIs('peminjam.status.*') ? 'active' : '' }}">
                        {{ __('Status Peminjaman') }}
                    </a>
                    <a href="{{ route('peminjam.riwayat.index') }}"
                        class="sidebar-link {{ request()->routeIs('peminjam.riwayat.*') ? 'active' : '' }}">
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
