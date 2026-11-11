<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="KalaPustaka - Sistem Informasi Perpustakaan Terpadu untuk pengelolaan buku, anggota, dan transaksi peminjaman.">
    <meta name="author" content="KalaPustaka">
    <title>@yield('title') - KalaPustaka</title>
    <!-- Google Fonts Plus Jakarta Sans & Icons -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <!-- App CSS -->
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    <!-- Feather Icons -->
    <script src="https://unpkg.com/feather-icons"></script>
    <!-- Dark mode: apply before render to prevent flash -->
    <script>
        (function () {
            const saved = localStorage.getItem('kp-theme');
            if (saved === 'dark') {
                document.documentElement.setAttribute('data-theme', 'dark');
            }
        })();
    </script>
</head>
<body>
    <!-- Navbar Header -->
    <nav class="navbar">
        <div class="navbar-top">
            <a href="{{ route('dashboard') }}" class="navbar-brand">
                <div class="brand-icon-wrapper">
                    <i data-feather="book-open" style="width: 22px; height: 22px;"></i>
                </div>
                <span class="brand-title">KalaPustaka</span>
            </a>

            <!-- Hamburger Button (Mobile Only) -->
            <button class="nav-hamburger" id="navToggle" aria-label="Toggle navigation">
                <i data-feather="menu" style="width: 22px; height: 22px;"></i>
            </button>
        </div>

        <div class="nav-collapse" id="navCollapse">
            <ul class="nav-links">
                <li>
                    <a href="{{ route('dashboard') }}" class="{{ request()->routeIs('dashboard') ? 'active' : '' }}">
                        <i data-feather="grid" style="width: 18px; height: 18px;"></i> Dashboard
                    </a>
                </li>
                <li>
                    <a href="{{ route('buku.index') }}" class="{{ request()->routeIs('buku.*') ? 'active' : '' }}">
                        <i data-feather="book" style="width: 18px; height: 18px;"></i> Data Buku
                    </a>
                </li>
                <li>
                    <a href="{{ route('peminjaman.index') }}" class="{{ request()->routeIs('peminjaman.index') ? 'active' : '' }}">
                        <i data-feather="repeat" style="width: 18px; height: 18px;"></i> Transaksi
                    </a>
                </li>
                @if(auth()->user()->role === 'admin')
                <li>
                    <a href="{{ route('anggota.index') }}" class="{{ request()->routeIs('anggota.*') ? 'active' : '' }}">
                        <i data-feather="users" style="width: 18px; height: 18px;"></i> Data Anggota
                    </a>
                </li>
                <li>
                    <a href="{{ route('peminjaman.create') }}" class="{{ request()->routeIs('peminjaman.create') ? 'active' : '' }}">
                        <i data-feather="plus-circle" style="width: 18px; height: 18px;"></i> Peminjaman Baru
                    </a>
                </li>
                @endif
            </ul>

            <div class="nav-user">
                <div class="user-profile-badge">
                    <div class="user-avatar">
                        {{ strtoupper(substr(auth()->user()->name ?? 'G', 0, 1)) }}
                    </div>
                    <span class="user-name-text">{{ auth()->user()->name ?? 'Guest' }}</span>
                    <span class="badge badge-info" style="font-size: 0.7rem; padding: 2px 6px; text-transform: uppercase;">
                        {{ auth()->user()->role ?? 'user' }}
                    </span>
                </div>

                <!-- Dark Mode Toggle -->
                <button class="btn btn-secondary btn-sm btn-theme-toggle" id="themeToggle" title="Ganti Tema" aria-label="Toggle dark mode">
                    <i data-feather="moon" class="icon-moon" style="width: 16px; height: 16px;"></i>
                    <i data-feather="sun" class="icon-sun" style="width: 16px; height: 16px; display: none;"></i>
                </button>

                <form action="{{ route('logout') }}" method="POST" style="margin: 0;">
                    @csrf
                    <button type="submit" class="btn btn-secondary btn-sm" style="color: var(--danger); border-color: rgba(239, 68, 68, 0.2); background: var(--danger-light);" title="Keluar dari sesi">
                        <i data-feather="log-out" style="width: 16px; height: 16px;"></i> <span class="logout-text">Logout</span>
                    </button>
                </form>
            </div>

        </div>
    </nav>

    <!-- Main Container -->
    <main class="container" @yield('container_style')>
        <!-- Global Flash Alerts -->
        @if (session('success'))
            <div class="alert alert-success animate-fade-in" id="flash-alert">
                <i data-feather="check-circle" style="width: 20px; height: 20px; color: #10b981;"></i>
                <div style="flex: 1;">{{ session('success') }}</div>
                <button type="button" onclick="this.parentElement.remove()" style="background: none; border: none; cursor: pointer; color: #065f46;">
                    <i data-feather="x" style="width: 18px; height: 18px;"></i>
                </button>
            </div>
        @endif

        @if (session('error'))
            <div class="alert alert-error animate-fade-in" id="flash-alert">
                <i data-feather="alert-circle" style="width: 20px; height: 20px; color: #ef4444;"></i>
                <div style="flex: 1;">{{ session('error') }}</div>
                <button type="button" onclick="this.parentElement.remove()" style="background: none; border: none; cursor: pointer; color: #991b1b;">
                    <i data-feather="x" style="width: 18px; height: 18px;"></i>
                </button>
            </div>
        @endif

        @yield('content')
    </main>

    <!-- Footer -->
    <footer>
        <div style="display: flex; align-items: center; justify-content: center; gap: 8px; margin-bottom: 6px;">
            <i data-feather="book-open" style="width: 16px; height: 16px; color: var(--primary);"></i>
            <strong>KalaPustaka</strong>
        </div>
        <p>&copy; {{ date('Y') }} KalaPustaka. Sistem Informasi Perpustakaan Terpadu. All rights reserved.</p>
    </footer>

    <script>
        feather.replace();

        // ── Dark Mode ────────────────────────────────────────────────
        const html         = document.documentElement;
        const themeToggle  = document.getElementById('themeToggle');
        const iconMoon     = themeToggle?.querySelector('.icon-moon');
        const iconSun      = themeToggle?.querySelector('.icon-sun');

        function applyTheme(isDark) {
            if (isDark) {
                html.setAttribute('data-theme', 'dark');
                if (iconMoon) iconMoon.style.display = 'none';
                if (iconSun)  iconSun.style.display  = '';
                localStorage.setItem('kp-theme', 'dark');
            } else {
                html.removeAttribute('data-theme');
                if (iconMoon) iconMoon.style.display = '';
                if (iconSun)  iconSun.style.display  = 'none';
                localStorage.setItem('kp-theme', 'light');
            }
        }

        // Init icon state based on saved theme
        const savedTheme = localStorage.getItem('kp-theme');
        applyTheme(savedTheme === 'dark');

        if (themeToggle) {
            themeToggle.addEventListener('click', function () {
                const isDark = html.getAttribute('data-theme') === 'dark';
                applyTheme(!isDark);
            });
        }

        // ── Auto-dismiss alerts ───────────────────────────────────────
        setTimeout(function () {
            const alert = document.getElementById('flash-alert');
            if (alert) {
                alert.style.transition = 'opacity 0.5s ease';
                alert.style.opacity = '0';
                setTimeout(() => alert.remove(), 500);
            }
        }, 5000);

        // ── Mobile hamburger toggle ───────────────────────────────────
        const navToggle  = document.getElementById('navToggle');
        const navCollapse = document.getElementById('navCollapse');
        if (navToggle && navCollapse) {
            navToggle.addEventListener('click', function () {
                const isOpen = navCollapse.classList.toggle('open');
                navToggle.setAttribute('aria-expanded', isOpen);
                navToggle.innerHTML = isOpen
                    ? '<svg xmlns="http://www.w3.org/2000/svg" width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><line x1="18" y1="6" x2="6" y2="18"></line><line x1="6" y1="6" x2="18" y2="18"></line></svg>'
                    : '<svg xmlns="http://www.w3.org/2000/svg" width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><line x1="3" y1="12" x2="21" y2="12"></line><line x1="3" y1="6" x2="21" y2="6"></line><line x1="3" y1="18" x2="21" y2="18"></line></svg>';
            });
            navCollapse.querySelectorAll('a').forEach(link => {
                link.addEventListener('click', () => {
                    navCollapse.classList.remove('open');
                    navToggle.setAttribute('aria-expanded', false);
                });
            });
        }
    </script>
</body>
</html>

