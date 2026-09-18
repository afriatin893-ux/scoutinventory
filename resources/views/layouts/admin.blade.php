<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Sistem Peminjaman') }} - Admin</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">

    <!-- External stylesheet -->
    <link rel="stylesheet" href="{{ asset('css/admin.css') }}">
</head>

<body>
    <div class="app-shell">
        <aside class="app-sidebar" id="appSidebar">
            <div class="sidebar-brand">
                <span class="icon-chip">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="18" height="18" fill="none" stroke="currentColor" stroke-width="1.8">
                        <path d="M12 2 3 6v6c0 5 4 8.5 9 10 5-1.5 9-5 9-10V6l-9-4Z"/>
                        <path d="M9 12.5 11 14.5 15.5 9.5"/>
                    </svg>
                </span>
                {{ __('Sistem Peminjaman - Admin') }}
            </div>

            <nav class="sidebar-nav">
                <a href="{{ route('admin.dashboard') }}"
                    class="sidebar-link {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="17" height="17" fill="none" stroke="currentColor" stroke-width="2">
                        <rect x="3" y="3" width="7" height="9" rx="1.5"/><rect x="14" y="3" width="7" height="5" rx="1.5"/>
                        <rect x="14" y="12" width="7" height="9" rx="1.5"/><rect x="3" y="16" width="7" height="5" rx="1.5"/>
                    </svg>
                    {{ __('Dashboard') }}
                </a>
                <a href="{{ route('admin.kategori.index') }}"
                    class="sidebar-link {{ request()->routeIs('admin.kategori.*') ? 'active' : '' }}">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="17" height="17" fill="none" stroke="currentColor" stroke-width="2">
                        <path d="M20.59 13.41 11 3.83A2 2 0 0 0 9.59 3.24H4a1 1 0 0 0-1 1v5.59a2 2 0 0 0 .59 1.41l9.58 9.58a2 2 0 0 0 2.83 0l5.59-5.59a2 2 0 0 0 0-2.82Z"/>
                        <circle cx="7.5" cy="7.5" r="1.2"/>
                    </svg>
                    {{ __('Kelola Kategori Barang') }}
                </a>
                <a href="{{ route('admin.barang.index') }}"
                    class="sidebar-link {{ request()->routeIs('admin.barang.*') ? 'active' : '' }}">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="17" height="17" fill="none" stroke="currentColor" stroke-width="2">
                        <path d="m21 8-9-5-9 5 9 5 9-5Z"/><path d="M3 8v8l9 5 9-5V8"/><path d="M12 13v8"/>
                    </svg>
                    {{ __('Kelola Data Barang') }}
                </a>
                <a href="{{ route('admin.peminjaman.pending') }}"
                    class="sidebar-link {{ request()->routeIs('admin.peminjaman.pending') || (request()->routeIs('admin.peminjaman.show') && request('from') === 'verifikasi') ? 'active' : '' }}">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="17" height="17" fill="none" stroke="currentColor" stroke-width="2">
                        <path d="M9 11 12 14 22 4"/><path d="M21 12v7a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h11"/>
                    </svg>
                    {{ 'Verifikasi Pengajuan' }}
                </a>
                <a href="{{ route('admin.pengembalian.index') }}"
                    class="sidebar-link {{ request()->routeIs('admin.pengembalian.*') ? 'active' : '' }}">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="17" height="17" fill="none" stroke="currentColor" stroke-width="2">
                        <path d="M3 12a9 9 0 1 0 9-9 9.75 9.75 0 0 0-6.74 2.74L3 8"/><path d="M3 3v5h5"/><path d="M12 7v5l4 2"/>
                    </svg>
                    {{ 'Catat Pengembalian' }}
                </a>
                <a href="{{ route('admin.peminjaman.index') }}"
                    class="sidebar-link {{ request()->routeIs('admin.peminjaman.index') || (request()->routeIs('admin.peminjaman.show') && request('from') !== 'verifikasi') ? 'active' : '' }}">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="17" height="17" fill="none" stroke="currentColor" stroke-width="2">
                        <path d="M8 6h13"/><path d="M8 12h13"/><path d="M8 18h13"/><path d="M3 6h.01"/><path d="M3 12h.01"/><path d="M3 18h.01"/>
                    </svg>
                    {{ 'Riwayat Peminjaman' }}
                </a>
                <a href="{{ route('admin.profil.edit') }}"
                    class="sidebar-link {{ request()->routeIs('admin.profil.*') ? 'active' : '' }}">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="17" height="17" fill="none" stroke="currentColor" stroke-width="2">
                        <circle cx="12" cy="8" r="4"/><path d="M4 21a8 8 0 0 1 16 0"/>
                    </svg>
                    {{ __('Profil Admin') }}
                </a>
            </nav>

            <div class="sidebar-foot">&copy; {{ date('Y') }} {{ config('app.name', 'Sistem Peminjaman Pramuka') }}</div>
        </aside>

        <div class="app-main">
            <header class="app-topbar">
                <span class="app-topbar-title">{{ __('Sistem Peminjaman - Admin') }}</span>

                @php
                    $unread = Auth::guard('admin')->user()->unreadNotifications;
                @endphp

                <div class="topbar-actions">
                    <div class="dropdown-wrap">
                        <button type="button" class="icon-btn" data-dropdown-toggle="notifDropdown">
                            🔔
                            @if ($unread->count())
                                <span class="dot-badge">{{ $unread->count() }}</span>
                            @endif
                        </button>
                        <div class="dropdown-panel" id="notifDropdown" style="min-width:280px;">
                            @forelse ($unread as $n)
                                <div class="dropdown-notif-item">{{ $n->data['pesan'] }}</div>
                            @empty
                                <div class="dropdown-empty">{{ __('Tidak ada notifikasi baru.') }}</div>
                            @endforelse
                        </div>
                    </div>

                    <div class="dropdown-wrap">
                        <button type="button" class="user-trigger" data-dropdown-toggle="userDropdown">
                            @if (Auth::guard('admin')->user()->foto)
                                <img class="user-avatar" src="{{ asset('storage/' . Auth::guard('admin')->user()->foto) }}" alt="Foto admin">
                            @else
                                <span class="user-avatar-fallback"></span>
                            @endif
                            {{ Auth::guard('admin')->user()->nama ?? __('Admin') }}
                        </button>
                        <div class="dropdown-panel" id="userDropdown">
                            <a class="dropdown-item" href="{{ route('admin.profil.edit') }}">{{ __('Profil Saya') }}</a>
                            <button type="button" class="dropdown-item"
                                onclick="document.getElementById('admin-logout-form').submit();">
                                {{ __('Logout') }}
                            </button>
                            <form id="admin-logout-form" action="{{ route('logout') }}" method="POST" style="display:none;">
                                @csrf
                            </form>
                        </div>
                    </div>
                </div>
            </header>

            <main class="app-content">
                @hasSection('page-title')
                    <div class="page-header-row">
                        <span class="page-header-icon">
                            @hasSection('page-icon')
                                @yield('page-icon')
                            @else
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="20" height="20" fill="none" stroke="currentColor" stroke-width="2"><rect x="3" y="3" width="7" height="9" rx="1.5"/><rect x="14" y="3" width="7" height="5" rx="1.5"/><rect x="14" y="12" width="7" height="9" rx="1.5"/><rect x="3" y="16" width="7" height="5" rx="1.5"/></svg>
                            @endif
                        </span>
                        <div>
                            <h1>@yield('page-title')</h1>
                            @hasSection('page-subtitle')
                                <p class="page-subtitle">@yield('page-subtitle')</p>
                            @endif
                        </div>
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

    <script>
        document.addEventListener('click', function (e) {
            const trigger = e.target.closest('[data-dropdown-toggle]');
            document.querySelectorAll('.dropdown-panel.open').forEach(function (panel) {
                if (!trigger || panel.id !== trigger.getAttribute('data-dropdown-toggle')) {
                    panel.classList.remove('open');
                }
            });
            if (trigger) {
                const panel = document.getElementById(trigger.getAttribute('data-dropdown-toggle'));
                if (panel) panel.classList.toggle('open');
            } else if (!e.target.closest('.dropdown-panel')) {
                document.querySelectorAll('.dropdown-panel.open').forEach(p => p.classList.remove('open'));
            }
        });
    </script>

    @yield('scripts')
</body>

</html>
