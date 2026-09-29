<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pendaftaran - KalaPustaka</title>
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

        <div class="auth-card animate-fade-in" style="max-width: 480px;">
            <div class="auth-header">
                <div class="logo-badge">
                    <i data-feather="user-plus" style="width: 28px; height: 28px;"></i>
                </div>
                <h1>Pendaftaran Akun Baru</h1>
                <p>Bergabunglah dengan Layanan KalaPustaka</p>
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

            <form action="{{ route('register.post') }}" method="POST">
                @csrf
                
                <div class="form-group">
                    <label class="form-label" for="name">Nama Lengkap</label>
                    <div style="position: relative;">
                        <input type="text" class="form-control" id="name" name="name" value="{{ old('name') }}" placeholder="Masukkan nama lengkap" required autofocus style="padding-left: 2.5rem;">
                        <i data-feather="user" style="position: absolute; left: 0.85rem; top: 50%; transform: translateY(-50%); width: 18px; height: 18px; color: var(--text-muted);"></i>
                    </div>
                </div>

                <div class="form-group">
                    <label class="form-label" for="email">Alamat Email</label>
                    <div style="position: relative;">
                        <input type="email" class="form-control" id="email" name="email" value="{{ old('email') }}" placeholder="nama@email.com" required style="padding-left: 2.5rem;">
                        <i data-feather="mail" style="position: absolute; left: 0.85rem; top: 50%; transform: translateY(-50%); width: 18px; height: 18px; color: var(--text-muted);"></i>
                    </div>
                </div>

                <div class="form-group">
                    <label class="form-label" for="role">Pilihan Peran Akses (Role)</label>
                    <div style="position: relative;">
                        <select class="form-control" id="role" name="role" required style="padding-left: 2.5rem;">
                            <option value="user" {{ old('role') == 'user' ? 'selected' : '' }}>User (Anggota / Siswa)</option>
                            <option value="admin" {{ old('role') == 'admin' ? 'selected' : '' }}>Admin (Petugas Perpustakaan)</option>
                        </select>
                        <i data-feather="shield" style="position: absolute; left: 0.85rem; top: 50%; transform: translateY(-50%); width: 18px; height: 18px; color: var(--text-muted); pointer-events: none;"></i>
                    </div>
                </div>

                <div class="form-group">
                    <label class="form-label" for="password">Password</label>
                    <div style="position: relative;">
                        <input type="password" class="form-control" id="password" name="password" placeholder="Minimal 6 karakter" required style="padding-left: 2.5rem;">
                        <i data-feather="lock" style="position: absolute; left: 0.85rem; top: 50%; transform: translateY(-50%); width: 18px; height: 18px; color: var(--text-muted);"></i>
                    </div>
                </div>
                
                <div class="form-group">
                    <label class="form-label" for="password_confirmation">Konfirmasi Password</label>
                    <div style="position: relative;">
                        <input type="password" class="form-control" id="password_confirmation" name="password_confirmation" placeholder="Ulangi password" required style="padding-left: 2.5rem;">
                        <i data-feather="check-circle" style="position: absolute; left: 0.85rem; top: 50%; transform: translateY(-50%); width: 18px; height: 18px; color: var(--text-muted);"></i>
                    </div>
                </div>

                <button type="submit" class="btn btn-primary" style="width: 100%; padding: 0.85rem; margin-top: 1rem; font-size: 1rem;">
                    <i data-feather="arrow-right" style="width: 18px; height: 18px;"></i> Daftar Sekarang
                </button>
            </form>
            
            <div style="text-align: center; margin-top: 1.75rem; padding-top: 1.25rem; border-top: 1px solid var(--border);">
                <p style="color: var(--text-muted); font-size: 0.9rem;">
                    Sudah memiliki akun? <a href="{{ route('login') }}" style="color: var(--primary); font-weight: 700; text-decoration: none;">Masuk di sini</a>
                </p>
            </div>
        </div>
    </div>

    <script>
        feather.replace();
    </script>
</body>
</html>
