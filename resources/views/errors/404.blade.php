<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Halaman Tidak Ditemukan - KalaPustaka</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    <script src="https://unpkg.com/feather-icons"></script>
    <style>
        body {
            display: flex;
            align-items: center;
            justify-content: center;
            height: 100vh;
            background-color: #0f172a;
            overflow: hidden;
            margin: 0;
            font-family: 'Plus Jakarta Sans', sans-serif;
        }
        .error-card {
            background: rgba(255, 255, 255, 0.95);
            padding: 3rem 2rem;
            border-radius: 24px;
            box-shadow: 0 20px 40px rgba(0,0,0,0.2);
            text-align: center;
            max-width: 450px;
            width: 90%;
            position: relative;
            z-index: 10;
        }
        .error-code {
            font-size: 5rem;
            font-weight: 800;
            color: var(--primary);
            margin: 0;
            line-height: 1;
            background: linear-gradient(135deg, var(--primary), var(--secondary));
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
        }
        .error-title {
            font-size: 1.5rem;
            font-weight: 700;
            color: #1e293b;
            margin-top: 1rem;
            margin-bottom: 0.5rem;
        }
        .error-message {
            color: #64748b;
            margin-bottom: 2rem;
            font-size: 1rem;
        }
        .btn-back {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 0.5rem;
            background: var(--primary);
            color: white;
            padding: 0.85rem 1.5rem;
            border-radius: 12px;
            text-decoration: none;
            font-weight: 600;
            transition: all 0.3s ease;
        }
        .btn-back:hover {
            background: var(--primary-hover);
            transform: translateY(-2px);
            box-shadow: 0 10px 20px rgba(99, 102, 241, 0.3);
        }
    </style>
</head>
<body>
    <div class="auth-blob auth-blob-1"></div>
    <div class="auth-blob auth-blob-2"></div>

    <div class="error-card animate-fade-in">
        <div style="margin-bottom: 1rem; color: #f59e0b;">
            <i data-feather="map-pin" style="width: 48px; height: 48px;"></i>
        </div>
        <h1 class="error-code">404</h1>
        <h2 class="error-title">Halaman Tidak Ditemukan</h2>
        <p class="error-message">Halaman yang Anda cari mungkin telah dipindahkan atau tidak pernah ada. Mari kembali ke jalan yang benar.</p>
        <a href="{{ route('dashboard') }}" class="btn-back">
            <i data-feather="home"></i> Kembali ke Dashboard
        </a>
    </div>

    <script>
        feather.replace();
    </script>
</body>
</html>
