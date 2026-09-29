@extends('layouts.app')

@section('title', 'Input Peminjaman')

@section('container_style', 'style="max-width: 650px;"')

@section('content')
<div class="page-header animate-fade-in" style="margin-bottom: 1.5rem;">
    <div style="display: flex; align-items: center; gap: 12px;">
        <a href="{{ route('dashboard') }}" class="btn btn-secondary btn-icon-only" title="Kembali ke Dashboard">
            <i data-feather="arrow-left" style="width: 18px; height: 18px;"></i>
        </a>
        <div>
            <h1>Transaksi Peminjaman Baru</h1>
            <p style="margin: 0;">Catat sirkulasi peminjaman fisik buku kepada anggota perpustakaan</p>
        </div>
    </div>
</div>

@if ($errors->any())
    <div class="alert alert-error animate-fade-in">
        <i data-feather="alert-triangle" style="width: 18px; height: 18px;"></i>
        <ul style="padding-left: 1rem; margin: 0;">
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

<div class="card animate-fade-in">
    <form action="{{ route('peminjaman.store') }}" method="POST">
        @csrf
        
        <div class="form-group">
            <label class="form-label" for="id_pinjam">ID Transaksi Peminjaman (Otomatis)</label>
            <div style="position: relative;">
                <input type="text" class="form-control" id="id_pinjam" name="id_pinjam" value="{{ old('id_pinjam', $next_id) }}" readonly style="background-color: var(--bg-color); color: var(--primary); font-family: monospace; font-weight: 800; padding-left: 2.5rem;">
                <i data-feather="hash" style="position: absolute; left: 0.85rem; top: 50%; transform: translateY(-50%); width: 18px; height: 18px; color: var(--primary);"></i>
            </div>
        </div>

        <div class="form-group">
            <label class="form-label" for="id_anggota">Pilih Anggota Peminjam</label>
            <div style="position: relative;">
                <select class="form-control" id="id_anggota" name="id_anggota" required style="padding-left: 2.5rem;">
                    <option value="">-- Pilih Anggota Perpustakaan --</option>
                    @foreach($anggota as $a)
                        <option value="{{ $a->id_anggota }}" {{ old('id_anggota') == $a->id_anggota ? 'selected' : '' }}>
                            {{ $a->id_anggota }} — {{ $a->nama_anggota }} ({{ $a->kelas }})
                        </option>
                    @endforeach
                </select>
                <i data-feather="user" style="position: absolute; left: 0.85rem; top: 50%; transform: translateY(-50%); width: 18px; height: 18px; color: var(--text-muted); pointer-events: none;"></i>
            </div>
        </div>

        <div class="form-group">
            <label class="form-label" for="no_buku">Pilih Fisik Buku yang Dipinjam</label>
            <div style="position: relative;">
                <select class="form-control" id="no_buku" name="no_buku" required style="padding-left: 2.5rem;">
                    <option value="">-- Pilih Fisik Buku (No. Fisik - Judul) --</option>
                    @foreach($buku as $b)
                        <option value="{{ $b->no_buku }}" {{ old('no_buku') == $b->no_buku ? 'selected' : '' }}>
                            No. Fisik: {{ $b->no_buku }} — {{ $b->buku->judul_buku }} (Oleh: {{ $b->buku->pengarang }})
                        </option>
                    @endforeach
                </select>
                <i data-feather="book-open" style="position: absolute; left: 0.85rem; top: 50%; transform: translateY(-50%); width: 18px; height: 18px; color: var(--text-muted); pointer-events: none;"></i>
            </div>
        </div>

        <div class="form-group">
            <label class="form-label" for="tgl_kembali">Tenggat Waktu Pengembalian (Due Date)</label>
            <div style="position: relative;">
                <input type="datetime-local" class="form-control" id="tgl_kembali" name="tgl_kembali" value="{{ old('tgl_kembali', $default_tgl_kembali) }}" required style="padding-left: 2.5rem;">
                <i data-feather="clock" style="position: absolute; left: 0.85rem; top: 50%; transform: translateY(-50%); width: 18px; height: 18px; color: var(--text-muted); pointer-events: none;"></i>
            </div>
            <p style="font-size: 0.8rem; color: var(--text-muted); margin-top: 0.4rem; margin-bottom: 0;">Secara default diatur 7 hari ke depan. Silakan sesuaikan jika perlu.</p>
        </div>

        <div style="margin-top: 2.25rem; display: flex; gap: 1rem;">
            <button type="submit" class="btn btn-primary" style="flex: 1; padding: 0.85rem;">
                <i data-feather="check-circle"></i> Proses Peminjaman
            </button>
            <a href="{{ route('dashboard') }}" class="btn btn-secondary" style="padding: 0.85rem 1.5rem;">
                Batal
            </a>
        </div>
    </form>
</div>
@endsection
