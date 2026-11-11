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

        <div class="auth-card animate-fade-in" style="max-width: 540px;">
            <div class="auth-header" style="margin-bottom: 1rem;">
                <div class="logo-badge" style="width: 48px; height: 48px;">
                    <i data-feather="user-plus" style="width: 22px; height: 22px;"></i>
                </div>
                <h1 style="font-size: 1.4rem; margin-top: 0.5rem;">Pendaftaran Akun Baru</h1>
                <p style="font-size: 0.85rem; margin-top: 0.25rem;">Bergabunglah dengan Layanan KalaPustaka</p>
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

                <!-- ── Bagian: Informasi Akun ── -->
                <p style="font-size: 0.7rem; font-weight: 700; text-transform: uppercase; letter-spacing: 0.09em; color: var(--text-muted); margin: 0 0 0.6rem 0; padding-bottom: 0.35rem; border-bottom: 1px solid var(--border);">Informasi Akun</p>

                <div class="form-group" style="margin-bottom: 0.65rem;">
                    <label class="form-label" for="name" style="font-size: 0.8rem; margin-bottom: 0.3rem;">Nama Lengkap</label>
                    <div style="position: relative;">
                        <input type="text" class="form-control" id="name" name="name" value="{{ old('name') }}" placeholder="Masukkan nama lengkap" required autofocus style="padding-left: 2.5rem; padding-top: 0.5rem; padding-bottom: 0.5rem; font-size: 0.875rem;">
                        <i data-feather="user" style="position: absolute; left: 0.85rem; top: 50%; transform: translateY(-50%); width: 16px; height: 16px; color: var(--text-muted);"></i>
                    </div>
                </div>

                <div class="form-group" style="margin-bottom: 0.65rem;">
                    <label class="form-label" for="email" style="font-size: 0.8rem; margin-bottom: 0.3rem;">Alamat Email</label>
                    <div style="position: relative;">
                        <input type="email" class="form-control" id="email" name="email" value="{{ old('email') }}" placeholder="nama@email.com" required style="padding-left: 2.5rem; padding-top: 0.5rem; padding-bottom: 0.5rem; font-size: 0.875rem;">
                        <i data-feather="mail" style="position: absolute; left: 0.85rem; top: 50%; transform: translateY(-50%); width: 16px; height: 16px; color: var(--text-muted);"></i>
                    </div>
                </div>

                <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 0.75rem; margin-bottom: 0.65rem;">
                    <div class="form-group" style="margin-bottom: 0;">
                        <label class="form-label" for="password" style="font-size: 0.8rem; margin-bottom: 0.3rem;">Password</label>
                        <div style="position: relative;">
                            <input type="password" class="form-control" id="password" name="password" placeholder="Min. 6 karakter" required style="padding-left: 2.5rem; padding-top: 0.5rem; padding-bottom: 0.5rem; font-size: 0.875rem;">
                            <i data-feather="lock" style="position: absolute; left: 0.85rem; top: 50%; transform: translateY(-50%); width: 16px; height: 16px; color: var(--text-muted);"></i>
                        </div>
                    </div>
                    <div class="form-group" style="margin-bottom: 0;">
                        <label class="form-label" for="password_confirmation" style="font-size: 0.8rem; margin-bottom: 0.3rem;">Konfirmasi Password</label>
                        <div style="position: relative;">
                            <input type="password" class="form-control" id="password_confirmation" name="password_confirmation" placeholder="Ulangi password" required style="padding-left: 2.5rem; padding-top: 0.5rem; padding-bottom: 0.5rem; font-size: 0.875rem;">
                            <i data-feather="check-circle" style="position: absolute; left: 0.85rem; top: 50%; transform: translateY(-50%); width: 16px; height: 16px; color: var(--text-muted);"></i>
                        </div>
                    </div>
                </div>

                <!-- ── Bagian: Data Anggota ── -->
                <p style="font-size: 0.7rem; font-weight: 700; text-transform: uppercase; letter-spacing: 0.09em; color: var(--text-muted); margin: 0.75rem 0 0.6rem 0; padding-bottom: 0.35rem; border-bottom: 1px solid var(--border);">
                    Data Anggota <span style="font-weight: 400; text-transform: none; letter-spacing: 0;">(opsional)</span>
                </p>

                <!-- Kelas & No. WhatsApp -->
                <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 0.75rem; margin-bottom: 0.65rem;">
                    <div class="form-group" style="margin-bottom: 0;">
                        <label class="form-label" for="kelas" style="font-size: 0.8rem; margin-bottom: 0.3rem;">Kelas</label>
                        <div style="position: relative;">
                            <input type="text" class="form-control" id="kelas" name="kelas" value="{{ old('kelas') }}" placeholder="Cth: XII IPA 1" maxlength="20" style="padding-left: 2.5rem; padding-top: 0.5rem; padding-bottom: 0.5rem; font-size: 0.875rem;">
                            <i data-feather="layers" style="position: absolute; left: 0.85rem; top: 50%; transform: translateY(-50%); width: 16px; height: 16px; color: var(--text-muted);"></i>
                        </div>
                    </div>
                    <div class="form-group" style="margin-bottom: 0;">
                        <label class="form-label" for="no_wa" style="font-size: 0.8rem; margin-bottom: 0.3rem;">No. WhatsApp</label>
                        <div style="position: relative;">
                            <input type="text" class="form-control" id="no_wa" name="no_wa" value="{{ old('no_wa') }}" placeholder="08xxxxxxxxxx" maxlength="20" style="padding-left: 2.5rem; padding-top: 0.5rem; padding-bottom: 0.5rem; font-size: 0.875rem;">
                            <i data-feather="smartphone" style="position: absolute; left: 0.85rem; top: 50%; transform: translateY(-50%); width: 16px; height: 16px; color: var(--text-muted);"></i>
                        </div>
                    </div>
                </div>

                <!-- Tempat Lahir & Tanggal Lahir -->
                <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 0.75rem;">
                    <div class="form-group" style="margin-bottom: 0;">
                        <label class="form-label" for="tempatlahir" style="font-size: 0.8rem; margin-bottom: 0.3rem;">Tempat Lahir</label>
                        <div style="position: relative;">
                            <input type="text" class="form-control" id="tempatlahir" name="tempatlahir" value="{{ old('tempatlahir') }}" placeholder="Kota tempat lahir" maxlength="30" style="padding-left: 2.5rem; padding-top: 0.5rem; padding-bottom: 0.5rem; font-size: 0.875rem;">
                            <i data-feather="map-pin" style="position: absolute; left: 0.85rem; top: 50%; transform: translateY(-50%); width: 16px; height: 16px; color: var(--text-muted);"></i>
                        </div>
                    </div>
                    <div class="form-group" style="margin-bottom: 0;">
                        <label class="form-label" for="tgllahir" style="font-size: 0.8rem; margin-bottom: 0.3rem;">Tanggal Lahir</label>
                        <div style="position: relative;">
                            <input type="date" class="form-control" id="tgllahir" name="tgllahir" value="{{ old('tgllahir') }}" style="padding-left: 2.5rem; padding-top: 0.5rem; padding-bottom: 0.5rem; font-size: 0.875rem;">
                            <i data-feather="gift" style="position: absolute; left: 0.85rem; top: 50%; transform: translateY(-50%); width: 16px; height: 16px; color: var(--text-muted); pointer-events: none;"></i>
                        </div>
                    </div>
                </div>

                <button type="submit" class="btn btn-primary" id="btn-daftar" style="width: 100%; padding: 0.7rem; margin-top: 1rem; font-size: 0.95rem;">
                    <i data-feather="arrow-right" style="width: 16px; height: 16px;"></i> Daftar Sekarang
                </button>
            </form>
            
            <div style="text-align: center; margin-top: 1rem; padding-top: 0.85rem; border-top: 1px solid var(--border);">
                <p style="color: var(--text-muted); font-size: 0.85rem;">
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
