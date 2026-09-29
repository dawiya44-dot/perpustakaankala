@extends('layouts.app')

@section('title', 'Selamat Datang')

@section('content')
<div class="hero-banner animate-fade-in" style="text-align: center; padding: 4rem 2rem;">
    <div style="max-width: 700px; margin: 0 auto; position: relative; z-index: 2;">
        <div style="width: 70px; height: 70px; border-radius: 20px; background: rgba(255,255,255,0.2); color: white; display: inline-flex; align-items: center; justify-content: center; margin-bottom: 1.5rem; backdrop-filter: blur(10px);">
            <i data-feather="book-open" style="width: 36px; height: 36px;"></i>
        </div>
        <h1 style="font-size: 2.5rem; font-weight: 800; margin-bottom: 1rem;">Selamat Datang di KalaPustaka</h1>
        <p style="font-size: 1.15rem; opacity: 0.9; margin-bottom: 2rem;">Sistem Informasi Manajemen Perpustakaan Terpadu dengan Layanan Modern, Cepat, dan Efisien.</p>
        <div style="display: flex; justify-content: center; gap: 1rem; flex-wrap: wrap;">
            @auth
                <a href="{{ route('dashboard') }}" class="btn" style="background: white; color: var(--primary); font-weight: 700; padding: 0.85rem 2rem; font-size: 1rem;">
                    <i data-feather="grid"></i> Buka Dashboard
                </a>
            @else
                <a href="{{ route('login') }}" class="btn" style="background: white; color: var(--primary); font-weight: 700; padding: 0.85rem 2rem; font-size: 1rem;">
                    <i data-feather="log-in"></i> Masuk Sekarang
                </a>
                <a href="{{ route('register') }}" class="btn" style="background: rgba(255,255,255,0.2); color: white; border: 1px solid rgba(255,255,255,0.4); padding: 0.85rem 2rem; font-size: 1rem;">
                    Daftar Anggota
                </a>
            @endauth
        </div>
    </div>
</div>
@endsection
