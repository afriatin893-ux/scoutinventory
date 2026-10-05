<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Sistem Peminjaman') }} - Peminjam</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&family=Bitter:wght@600;800&display=swap" rel="stylesheet">

    <!-- Scripts -->
    @vite(['resources/css/peminjam.css', 'resources/js/app.js'])
</head>

<body>
    <div class="app-shell">

        {{-- ===== NAVBAR (satu, full width) ===== --}}
        <header class="app-topbar">
            <div class="topbar-brand">
                <img src="{{ asset('images/logo.png') }}" alt="Logo Pramuka" class="sidebar-logo">
                <div class="topbar-brand-text">
                    <span class="app-topbar-title">{{ __('SCOUTINVENTORY') }}</span>
                    <span class="app-topbar-sub">{{ __('praseda') }}</span>
                </div>
            </div>

            <nav class="top-nav" aria-label="Menu peminjam">
                <a href="{{ route('peminjam.dashboard') }}" class="{{ request()->routeIs('peminjam.dashboard') ? 'active' : '' }}">{{ __('Beranda') }}</a>
                <a href="{{ route('peminjam.barang.index') }}" class="{{ request()->routeIs('peminjam.barang.*') ? 'active' : '' }}">{{ __('Katalog') }}</a>
                <a href="{{ route('peminjam.peminjaman.create') }}" class="{{ request()->routeIs('peminjam.peminjaman.*') ? 'active' : '' }}">{{ __('Ajukan') }}</a>
                <a href="{{ route('peminjam.status.index') }}" class="{{ request()->routeIs('peminjam.status.*') ? 'active' : '' }}">{{ __('Status') }}</a>
                <a href="{{ route('peminjam.riwayat.index') }}" class="{{ request()->routeIs('peminjam.riwayat.*') ? 'active' : '' }}">{{ __('Riwayat') }}</a>
            </nav>

            @php
                $unread = Auth::guard('peminjam')->user()->unreadNotifications;
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
                            <a href="{{ route('peminjam.notifikasi.buka', $n->id) }}" class="dropdown-notif-item">
                                {{ $n->data['pesan'] }}
                            </a>
                        @empty
                            <div class="dropdown-empty">{{ __('Tidak ada notifikasi baru.') }}</div>
                        @endforelse
                    </div>
                </div>

                <div class="dropdown-wrap">
                    <button type="button" class="user-trigger" data-dropdown-toggle="userDropdown">
                        @if (Auth::guard('peminjam')->user()->foto)
                            <img class="user-avatar"
                                src="{{ asset('storage/' . Auth::guard('peminjam')->user()->foto) }}"
                                alt="Foto peminjam">
                        @else
                            <span class="user-avatar-fallback" aria-hidden="true">{{ Auth::guard('peminjam')->user()->inisial }}</span>
                        @endif
                        {{ Auth::guard('peminjam')->user()->nama ?? __('Peminjam') }}
                    </button>
                    <div class="dropdown-panel" id="userDropdown">
                        <a class="dropdown-item"
                            href="{{ route('peminjam.profil.edit') }}">{{ __('Profil Saya') }}</a>
                        <button type="button" class="dropdown-item"
                            onclick="document.getElementById('peminjam-logout-form').submit();">
                            {{ __('Logout') }}
                        </button>
                        <form id="peminjam-logout-form" action="{{ route('logout') }}" method="POST"
                            style="display:none;">
                            @csrf
                        </form>
                    </div>
                </div>
            </div>
        </header>

        {{-- ===== SIDEBAR + KONTEN ===== --}}
        <div class="app-body">
            <div class="app-main">
                <main class="app-content">
                    @hasSection('page-title')
                        <div class="page-band">
                            <div class="page-band-in">
                                <h1>@yield('page-title')</h1>
                                @hasSection('page-subtitle')
                                    <p>@yield('page-subtitle')</p>
                                @endif
                            </div>
                        </div>
                    @endif

                    <div class="@hasSection('page-title') band-body @endif">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">{{ session('status') }}</div>
                    @endif

                    @if (session('success'))
                        <div class="alert alert-success" role="alert">{{ session('success') }}</div>
                    @endif

                    @yield('content')
                    </div>
                </main>

                <footer class="app-footer">
                    <span>&copy; {{ date('Y') }} {{ __('ScoutInventory') }} &ndash; {{ __('Peminjam') }}</span>
                    <span>{{ now()->translatedFormat('d F Y') }}</span>
                </footer>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('click', function(e) {
            const trigger = e.target.closest('[data-dropdown-toggle]');
            document.querySelectorAll('.dropdown-panel.open').forEach(function(panel) {
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
