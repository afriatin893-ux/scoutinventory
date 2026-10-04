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
        href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap"rel="stylesheet">

    <!-- Scripts -->
    @vite(['resources/css/peminjam.css', 'resources/js/app.js'])
</head>

<body>
    <div class="app-shell">

        {{-- ===== NAVBAR (satu, full width) ===== --}}
        <header class="app-topbar">
            <div class="topbar-brand">
                <img src="{{ asset('images/logo.png') }}" alt="Logo Pramuka" class="sidebar-logo">
                <span class="app-topbar-title">{{ __('Sistem Peminjaman - Peminjam') }}</span>
            </div>

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
                            <a href="{{ route('peminjam.notifikasi.buka', $n->id) }}"
                                class="dropdown-notif-item">
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
                            <span class="user-avatar-fallback"></span>
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
            <aside class="app-sidebar">
                <nav class="sidebar-nav">
                    <a href="{{ route('peminjam.dashboard') }}"
                        class="sidebar-link {{ request()->routeIs('peminjam.dashboard') ? 'active' : '' }}">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="17" height="17"
                            fill="none" stroke="currentColor" stroke-width="2">
                            <rect x="3" y="3" width="7" height="9" rx="1.5" />
                            <rect x="14" y="3" width="7" height="5" rx="1.5" />
                            <rect x="14" y="12" width="7" height="9" rx="1.5" />
                            <rect x="3" y="16" width="7" height="5" rx="1.5" />
                        </svg>
                        {{ __('Dashboard') }}
                    </a>
                    <a href="{{ route('peminjam.barang.index') }}"
                        class="sidebar-link {{ request()->routeIs('peminjam.barang.*') ? 'active' : '' }}">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="17" height="17"
                            fill="none" stroke="currentColor" stroke-width="2">
                            <path d="m21 8-9-5-9 5 9 5 9-5Z" />
                            <path d="M3 8v8l9 5 9-5V8" />
                            <path d="M12 13v8" />
                        </svg>
                        {{ __('Lihat Barang') }}
                    </a>
                    <a href="{{ route('peminjam.peminjaman.create') }}"
                        class="sidebar-link {{ request()->routeIs('peminjam.peminjaman.create') ? 'active' : '' }}">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="17" height="17"
                            fill="none" stroke="currentColor" stroke-width="2">
                            <path d="M14 3H7a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h10a2 2 0 0 0 2-2V8Z" />
                            <path d="M14 3v5h5" />
                            <path d="M12 12v6" />
                            <path d="M9 15h6" />
                        </svg>
                        {{ __('Form Pengajuan') }}
                    </a>
                    <a href="{{ route('peminjam.status.index') }}"
                        class="sidebar-link {{ request()->routeIs('peminjam.status.*') ? 'active' : '' }}">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="17" height="17"
                            fill="none" stroke="currentColor" stroke-width="2">
                            <circle cx="12" cy="12" r="9" />
                            <path d="M12 7v5l3 2" />
                        </svg>
                        {{ __('Status Peminjaman') }}
                    </a>
                    <a href="{{ route('peminjam.riwayat.index') }}"
                        class="sidebar-link {{ request()->routeIs('peminjam.riwayat.*') ? 'active' : '' }}">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="17" height="17"
                            fill="none" stroke="currentColor" stroke-width="2">
                            <path d="M8 6h13" />
                            <path d="M8 12h13" />
                            <path d="M8 18h13" />
                            <path d="M3 6h.01" />
                            <path d="M3 12h.01" />
                            <path d="M3 18h.01" />
                        </svg>
                        {{ __('Riwayat Peminjaman') }}
                    </a>
                    <a href="{{ route('peminjam.profil.edit') }}"
                        class="sidebar-link {{ request()->routeIs('peminjam.profil.*') ? 'active' : '' }}">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="17" height="17"
                            fill="none" stroke="currentColor" stroke-width="2">
                            <circle cx="12" cy="8" r="4" />
                            <path d="M4 21a8 8 0 0 1 16 0" />
                        </svg>
                        {{ __('Profil Saya') }}
                    </a>
                </nav>
            </aside>

            <div class="app-main">
                <main class="app-content">
                    @hasSection('page-title')
                        <div class="page-header-row">
                            <span class="page-header-icon">
                                @hasSection('page-icon')
                                    @yield('page-icon')
                                @else
                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="20"
                                        height="20" fill="none" stroke="currentColor" stroke-width="2">
                                        <rect x="3" y="3" width="7" height="9" rx="1.5" />
                                        <rect x="14" y="3" width="7" height="5" rx="1.5" />
                                        <rect x="14" y="12" width="7" height="9" rx="1.5" />
                                        <rect x="3" y="16" width="7" height="5" rx="1.5" />
                                    </svg>
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

                    @if (session('status'))
                        <div class="alert alert-success" role="alert">{{ session('status') }}</div>
                    @endif

                    @if (session('success'))
                        <div class="alert alert-success" role="alert">{{ session('success') }}</div>
                    @endif

                    @yield('content')
                </main>

                <footer class="app-footer">
                    <span>&copy; {{ date('Y') }} {{ __('Sistem Peminjaman') }} &ndash; {{ __('Peminjam') }}</span>
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
