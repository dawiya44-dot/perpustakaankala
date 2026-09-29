<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title') - KalaPustaka</title>
    <!-- Google Fonts Plus Jakarta Sans & Icons -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <!-- App CSS -->
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    <!-- Feather Icons -->
    <script src="https://unpkg.com/feather-icons"></script>
</head>
<body>
    <!-- Navbar Header -->
    <nav class="navbar">
        <a href="{{ route('dashboard') }}" class="navbar-brand">
            <div class="brand-icon-wrapper">
                <i data-feather="book-open" style="width: 22px; height: 22px;"></i>
            </div>
            <span class="brand-title">KalaPustaka</span>
        </a>

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
                <a href="{{ route('anggota.index') }}" class="{{ request()->routeIs('anggota.*') ? 'active' : '' }}">
                    <i data-feather="users" style="width: 18px; height: 18px;"></i> Data Anggota
                </a>
            </li>
            <li>
                <a href="{{ route('peminjaman.create') }}" class="{{ request()->routeIs('peminjaman.create') ? 'active' : '' }}">
                    <i data-feather="plus-circle" style="width: 18px; height: 18px;"></i> Peminjaman Baru
                </a>
            </li>
            
            <li style="margin-left: 12px; padding-left: 16px; border-left: 1px solid var(--border); display: flex; align-items: center; gap: 12px;">
                <div class="user-profile-badge">
                    <div class="user-avatar">
                        {{ strtoupper(substr(auth()->user()->name ?? 'G', 0, 1)) }}
                    </div>
                    <span>{{ auth()->user()->name ?? 'Guest' }}</span>
                    <span class="badge badge-info" style="font-size: 0.7rem; padding: 2px 6px; text-transform: uppercase;">
                        {{ auth()->user()->role ?? 'user' }}
                    </span>
                </div>
                
                <form action="{{ route('logout') }}" method="POST" style="margin: 0;">
                    @csrf
                    <button type="submit" class="btn btn-secondary btn-sm" style="color: var(--danger); border-color: rgba(239, 68, 68, 0.2); background: var(--danger-light);" title="Logout">
                        <i data-feather="log-out" style="width: 16px; height: 16px;"></i> Logout
                    </button>
                </form>
            </li>
        </ul>
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

    <!-- Init Feather Icons -->
    <script>
        feather.replace();
    </script>
</body>
</html>
