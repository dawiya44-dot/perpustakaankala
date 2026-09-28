<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - KalaPustaka</title>
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    <style>
        body {
            display: flex;
            align-items: center;
            justify-content: center;
            height: 100vh;
            background-color: var(--bg-color);
        }
        .login-card {
            width: 100%;
            max-width: 400px;
            padding: 2rem;
        }
        .login-header {
            text-align: center;
            margin-bottom: 2rem;
        }
        .login-header h1 {
            color: var(--primary);
            font-size: 1.8rem;
            margin-bottom: 0.5rem;
        }
    </style>
</head>
<body>

    <div class="card login-card">
        <div class="login-header">
            <h1>KalaPustaka</h1>
            <p class="text-muted">Sistem Informasi Perpustakaan</p>
        </div>

        @if ($errors->any())
            <div class="alert alert-error">
                <ul style="padding-left: 20px;">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('login.post') }}" method="POST">
            @csrf
            <div class="form-group">
                <label class="form-label" for="email">Email</label>
                <input type="email" class="form-control" id="email" name="email" value="{{ old('email') }}" required autofocus>
            </div>

            <div class="form-group">
                <label class="form-label" for="password">Password</label>
                <input type="password" class="form-control" id="password" name="password" required>
            </div>

            <button type="submit" class="btn btn-primary" style="width: 100%; margin-top: 1rem;">
                Login
            </button>
        </form>
        
        <div style="text-align: center; margin-top: 1.5rem;">
            <p class="text-muted">Belum punya akun? <a href="{{ route('register') }}" style="color: var(--primary); font-weight: 500;">Daftar di sini</a></p>
        </div>
    </div>

</body>
</html>
