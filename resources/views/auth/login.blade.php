<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - KalaPustaka</title>
    <!-- Google Fonts Plus Jakarta Sans -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <!-- App CSS -->
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    <!-- Feather Icons -->
    <script src="https://unpkg.com/feather-icons"></script>
</head>
<body style="background: #0f172a; overflow-x: hidden;">

    <div class="auth-wrapper">
        <!-- Ambient Glowing Background Circles -->
        <div class="auth-blob auth-blob-1"></div>
        <div class="auth-blob auth-blob-2"></div>

        <div class="auth-card animate-fade-in">
            <div class="auth-header">
                <div class="logo-badge">
                    <i data-feather="book-open" style="width: 28px; height: 28px;"></i>
                </div>
                <h1>KalaPustaka</h1>
                <p>Sistem Informasi Manajemen Perpustakaan</p>
            </div>

            @if ($errors->any())
                <div class="alert alert-error">
                    <i data-feather="alert-triangle" style="width: 18px; height: 18px; flex-shrink: 0;"></i>
                    <ul style="padding-left: 1rem; margin: 0; font-size: 0.875rem;">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form action="{{ route('login.post') }}" method="POST" id="loginForm">
                @csrf
                <div class="form-group">
                    <label class="form-label" for="email">Alamat Email</label>
                    <div style="position: relative;">
                        <input type="email" class="form-control" id="email" name="email" value="{{ old('email') }}" placeholder="nama@email.com" required autofocus style="padding-left: 2.5rem;">
                        <i data-feather="mail" style="position: absolute; left: 0.85rem; top: 50%; transform: translateY(-50%); width: 18px; height: 18px; color: var(--text-muted);"></i>
                    </div>
                </div>

                <div class="form-group">
                    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 0.45rem;">
                        <label class="form-label" for="password" style="margin-bottom: 0;">Password</label>
                    </div>
                    <div style="position: relative;">
                        <input type="password" class="form-control" id="password" name="password" placeholder="••••••••" required style="padding-left: 2.5rem;">
                        <i data-feather="lock" style="position: absolute; left: 0.85rem; top: 50%; transform: translateY(-50%); width: 18px; height: 18px; color: var(--text-muted);"></i>
                    </div>
                </div>

                <button type="submit" class="btn btn-primary" style="width: 100%; padding: 0.85rem; margin-top: 1rem; font-size: 1rem;">
                    <i data-feather="log-in" style="width: 18px; height: 18px;"></i> Masuk ke Akun
                </button>
            </form>

            <div style="text-align: center; margin-top: 1.5rem; padding-top: 1rem; border-top: 1px solid var(--border);">
                <p style="color: var(--text-muted); font-size: 0.9rem;">
                    Belum memiliki akun? <a href="{{ route('register') }}" style="color: var(--primary); font-weight: 700; text-decoration: none;">Daftar Akun Baru</a>
                </p>
            </div>
        </div>
    </div>

    <script>
        feather.replace();
    </script>
</body>
</html>
