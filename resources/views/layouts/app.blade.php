<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title') - KalaPustaka</title>
    <!-- CSS -->
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    <script src="https://unpkg.com/feather-icons"></script>
</head>
<body>
    <nav class="navbar">
        <a href="{{ route('dashboard') }}" class="navbar-brand">
            <i data-feather="book-open"></i> KalaPustaka
        </a>
        <ul class="nav-links">
            <li><a href="{{ route('dashboard') }}" class="{{ request()->routeIs('dashboard') ? 'active' : '' }}">Dashboard</a></li>
            <li><a href="{{ route('buku.index') }}" class="{{ request()->routeIs('buku.*') ? 'active' : '' }}">Data Buku</a></li>
            <li><a href="{{ route('anggota.index') }}" class="{{ request()->routeIs('anggota.*') ? 'active' : '' }}">Data Anggota</a></li>
            <li><a href="{{ route('peminjaman.create') }}" class="{{ request()->routeIs('peminjaman.create') ? 'active' : '' }}">Peminjaman Baru</a></li>
            
            <li style="margin-left: 20px; border-left: 1px solid var(--border); padding-left: 20px;">
                <span style="color: var(--text-dark); font-weight: 500;">
                    <i data-feather="user" style="width: 16px; height: 16px; margin-bottom: -3px;"></i> 
                    {{ auth()->user()->name ?? 'Guest' }}
                </span>
            </li>
            <li>
                <form action="{{ route('logout') }}" method="POST" style="display:inline;">
                    @csrf
                    <button type="submit" style="background:none; border:none; color: #ef4444; font-weight: 500; cursor:pointer; font-family:inherit; font-size: 1rem;">Logout</button>
                </form>
            </li>
        </ul>
    </nav>

    <div class="container" @yield('container_style')>
        @yield('content')
    </div>

    <footer>
        <p>&copy; {{ date('Y') }} KalaPustaka. All rights reserved.</p>
    </footer>

    <script>
        feather.replace();
    </script>
</body>
</html>
