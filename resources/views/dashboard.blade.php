@extends('layouts.app')

@section('title', 'Dashboard')

@section('content')
<!-- Hero Welcome Banner -->
<div class="hero-banner animate-fade-in">
    <div style="display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 1.5rem; position: relative; z-index: 2;">
        <div>
            <div style="display: inline-flex; align-items: center; gap: 6px; padding: 4px 12px; background: rgba(255,255,255,0.15); border-radius: 9999px; font-size: 0.8rem; font-weight: 600; margin-bottom: 0.75rem;">
                <i data-feather="shield" style="width: 14px; height: 14px;"></i> Akses Peran: {{ strtoupper(auth()->user()->role ?? 'user') }}
            </div>
            <h1>Halo, {{ auth()->user()->name ?? 'User' }} 👋</h1>
            <p>
                @if(auth()->user()->role === 'admin')
                    Anda masuk sebagai <strong>Admin (Petugas Perpustakaan)</strong> dengan hak pengelolaan data penuh (Buku, Anggota, Peminjaman, & Laporan).
                @else
                    Selamat datang di KalaPustaka. Jelajahi koleksi buku dan lakukan transaksi peminjaman buku favorit Anda.
                @endif
            </p>
        </div>
        <div style="display: flex; gap: 0.75rem; flex-wrap: wrap;">
            @if(auth()->user()->role === 'admin')
            <a href="{{ route('laporan.index') }}" class="btn" style="background: rgba(255, 255, 255, 0.2); color: white; border: 1px solid rgba(255, 255, 255, 0.3); backdrop-filter: blur(8px);">
                <i data-feather="printer"></i> Laporan & Ekspor
            </a>
            @endif
            @if(auth()->user()->role === 'admin')
            <a href="{{ route('peminjaman.create') }}" class="btn" style="background: white; color: var(--primary); font-weight: 700; box-shadow: 0 4px 15px rgba(0,0,0,0.15);">
                <i data-feather="plus-circle"></i> Pinjam Buku Baru
            </a>
            @endif
        </div>
    </div>
</div>

<!-- KPI Stats Grid -->
<div class="stats-grid animate-fade-in">
    @if(auth()->user()->role === 'admin')
    <!-- Stat 1: Total Buku -->
    <div class="stat-card" style="--card-accent: #6366f1;">
        <div class="stat-icon" style="--stat-icon-bg: #eef2ff; --stat-icon-color: #6366f1;">
            <i data-feather="book-open"></i>
        </div>
        <div class="stat-info">
            <h3>{{ $total_buku ?? 0 }}</h3>
            <p>Total Fisik Eksemplar Buku</p>
        </div>
    </div>

    <!-- Stat 2: Total Anggota -->
    <div class="stat-card" style="--card-accent: #10b981;">
        <div class="stat-icon" style="--stat-icon-bg: #ecfdf5; --stat-icon-color: #10b981;">
            <i data-feather="users"></i>
        </div>
        <div class="stat-info">
            <h3>{{ $total_anggota ?? 0 }}</h3>
            <p>Anggota Terdaftar</p>
        </div>
    </div>

    <!-- Stat 3: Buku Dipinjam -->
    <div class="stat-card" style="--card-accent: #f59e0b;">
        <div class="stat-icon" style="--stat-icon-bg: #fffbeb; --stat-icon-color: #f59e0b;">
            <i data-feather="bookmark"></i>
        </div>
        <div class="stat-info">
            <h3>{{ $total_dipinjam ?? 0 }}</h3>
            <p>Buku Sedang Dipinjam</p>
        </div>
    </div>

    <!-- Stat 4: Aktivitas Layanan -->
    <div class="stat-card" style="--card-accent: #3b82f6;">
        <div class="stat-icon" style="--stat-icon-bg: #eff6ff; --stat-icon-color: #3b82f6;">
            <i data-feather="activity"></i>
        </div>
        <div class="stat-info">
            <h3>{{ $peminjaman_terbaru->total() }}</h3>
            <p>Total Transaksi Sirkulasi</p>
        </div>
    </div>

    <!-- Stat 5: Denda Global -->
    <div class="stat-card" style="--card-accent: #ef4444;">
        <div class="stat-icon" style="--stat-icon-bg: #fef2f2; --stat-icon-color: #ef4444;">
            <i data-feather="alert-triangle"></i>
        </div>
        <div class="stat-info">
            <h3>Rp {{ number_format($total_denda_global ?? 0, 0, ',', '.') }}</h3>
            <p>Denda Keterlambatan Aktif</p>
        </div>
    </div>
    @else
    <!-- Stat User 1: Buku Sedang Dipinjam -->
    <div class="stat-card" style="--card-accent: #f59e0b;">
        <div class="stat-icon" style="--stat-icon-bg: #fffbeb; --stat-icon-color: #f59e0b;">
            <i data-feather="bookmark"></i>
        </div>
        <div class="stat-info">
            <h3>{{ $buku_sedang_dipinjam ?? 0 }}</h3>
            <p>Buku Sedang Saya Pinjam</p>
        </div>
    </div>

    <!-- Stat User 2: Total Denda -->
    <div class="stat-card" style="--card-accent: #ef4444;">
        <div class="stat-icon" style="--stat-icon-bg: #fef2f2; --stat-icon-color: #ef4444;">
            <i data-feather="alert-circle"></i>
        </div>
        <div class="stat-info">
            <h3>Rp {{ number_format($total_denda ?? 0, 0, ',', '.') }}</h3>
            <p>Total Denda Saya</p>
        </div>
    </div>
    @endif
</div>

<!-- Notifikasi Pengembalian Buku (khusus User/Anggota) -->
@if(auth()->user()->role !== 'admin' && isset($notifikasi_peminjaman) && $notifikasi_peminjaman->count() > 0)
<div class="card animate-fade-in" style="margin-bottom: 2rem; border-left: 4px solid var(--primary);">
    <div class="card-header" style="border-bottom: 1px solid var(--border);">
        <div style="display: flex; align-items: center; gap: 0.75rem;">
            <div style="background: var(--primary-light); color: var(--primary); padding: 8px; border-radius: 8px; display: flex; align-items: center; justify-content: center;">
                <i data-feather="bell" style="width: 20px; height: 20px;"></i>
            </div>
            <div>
                <h2 class="card-title" style="font-size: 1.15rem;">Notifikasi & Status Pengembalian Buku</h2>
                <p style="font-size: 0.85rem; color: var(--text-muted); margin-top: 2px;">Pantau sisa waktu dan tenggat peminjaman aktif Anda</p>
            </div>
        </div>
    </div>
    <div style="padding: 1.25rem;">
        <div style="display: flex; flex-direction: column; gap: 1rem;">
            @foreach($notifikasi_peminjaman as $notif)
                @if($notif->is_terlambat)
                    <!-- Peringatan Terlambat (Teks & Box Merah) -->
                    <div style="background-color: #fef2f2; border: 1px solid #fca5a5; border-radius: 10px; padding: 1rem 1.25rem; display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 1rem;">
                        <div style="display: flex; align-items: flex-start; gap: 0.85rem;">
                            <div style="background: #ef4444; color: white; border-radius: 50%; width: 36px; height: 36px; display: flex; align-items: center; justify-content: center; flex-shrink: 0; margin-top: 2px;">
                                <i data-feather="alert-triangle" style="width: 20px; height: 20px;"></i>
                            </div>
                            <div>
                                <h4 style="color: #991b1b; font-weight: 700; margin: 0 0 4px 0; font-size: 1rem;">
                                    ⚠️ PERINGATAN: Pengembalian Buku Terlambat!
                                </h4>
                                <p style="color: #b91c1c; font-size: 0.9rem; margin: 0 0 6px 0;">
                                    Buku <strong>"{{ $notif->judul_buku }}"</strong> (No. Fisik: <code>{{ $notif->no_buku }}</code>) telah melewati batas tenggat pengembalian <strong>({{ $notif->dueDateFormatted }})</strong>.
                                </p>
                                <div style="display: flex; gap: 0.75rem; font-size: 0.825rem; font-weight: 600; color: #991b1b; flex-wrap: wrap;">
                                    <span style="background: #fee2e2; padding: 2px 8px; border-radius: 4px;">
                                        🚨 Terlambat: {{ $notif->hari_terlambat }} Hari
                                    </span>
                                    <span style="background: #fee2e2; padding: 2px 8px; border-radius: 4px; color: #dc2626;">
                                        💸 Estimasi Denda: Rp {{ number_format($notif->denda, 0, ',', '.') }}
                                    </span>
                                </div>
                            </div>
                        </div>
                        <div>
                            <span style="display: inline-block; background: #dc2626; color: white; padding: 6px 14px; border-radius: 6px; font-weight: 600; font-size: 0.85rem;">
                                Segera Kembalikan ke Petugas
                            </span>
                        </div>
                    </div>
                @elseif($notif->sisa_hari == 0)
                    <!-- Batas Waktu Hari Ini (Kuning/Oranye) -->
                    <div style="background-color: #fffbeb; border: 1px solid #fcd34d; border-radius: 10px; padding: 1rem 1.25rem; display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 1rem;">
                        <div style="display: flex; align-items: flex-start; gap: 0.85rem;">
                            <div style="background: #f59e0b; color: white; border-radius: 50%; width: 36px; height: 36px; display: flex; align-items: center; justify-content: center; flex-shrink: 0; margin-top: 2px;">
                                <i data-feather="clock" style="width: 20px; height: 20px;"></i>
                            </div>
                            <div>
                                <h4 style="color: #92400e; font-weight: 700; margin: 0 0 4px 0; font-size: 1rem;">
                                    ⏳ BATAS PENGEMBALIAN HARI INI!
                                </h4>
                                <p style="color: #b45309; font-size: 0.9rem; margin: 0;">
                                    Buku <strong>"{{ $notif->judul_buku }}"</strong> (No. Fisik: <code>{{ $notif->no_buku }}</code>) jatuh tempo hari ini (<strong>{{ $notif->dueDateFormatted }}</strong>). Mohon segera kembalikan ke perpustakaan hari ini untuk menghindari denda keterlambatan.
                                </p>
                            </div>
                        </div>
                    </div>
                @else
                    <!-- Status Normal (Biru/Hijau Info) -->
                    <div style="background-color: #eff6ff; border: 1px solid #93c5fd; border-radius: 10px; padding: 1rem 1.25rem; display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 1rem;">
                        <div style="display: flex; align-items: flex-start; gap: 0.85rem;">
                            <div style="background: #3b82f6; color: white; border-radius: 50%; width: 36px; height: 36px; display: flex; align-items: center; justify-content: center; flex-shrink: 0; margin-top: 2px;">
                                <i data-feather="book-open" style="width: 20px; height: 20px;"></i>
                            </div>
                            <div>
                                <h4 style="color: #1e40af; font-weight: 700; margin: 0 0 4px 0; font-size: 1rem;">
                                    📖 Status Peminjaman Aktif
                                </h4>
                                <p style="color: #1d4ed8; font-size: 0.9rem; margin: 0 0 4px 0;">
                                    Buku <strong>"{{ $notif->judul_buku }}"</strong> (No. Fisik: <code>{{ $notif->no_buku }}</code>) sedang Anda pinjam.
                                </p>
                                <span style="font-size: 0.825rem; color: #2563eb; font-weight: 600; background: #dbeafe; padding: 2px 8px; border-radius: 4px;">
                                    🗓️ Tenggat Waktu: {{ $notif->dueDateFormatted }} (Sisa {{ $notif->sisa_hari }} hari lagi)
                                </span>
                            </div>
                        </div>
                    </div>
                @endif
            @endforeach
        </div>
    </div>
</div>
@endif

<!-- Recent Transactions Card -->
<div class="card animate-fade-in">
    <div class="card-header" style="flex-wrap: wrap; gap: 1rem;">
        <div>
            <h2 class="card-title">Daftar Transaksi Peminjaman</h2>
            <p style="font-size: 0.875rem; color: var(--text-muted); margin-top: 2px;">Daftar transaksi sirkulasi peminjaman & pengembalian buku</p>
        </div>
        <div style="display: flex; gap: 0.5rem;">
            @if(auth()->user()->role === 'admin')
            <a href="{{ route('peminjaman.create') }}" class="btn btn-primary btn-sm">
                <i data-feather="plus" style="width: 16px; height: 16px;"></i> Peminjaman Baru
            </a>
            @endif
        </div>
    </div>
    
    <div class="table-container">
        <table class="table">
            <thead>
                <tr>
                    <th>ID Transaksi</th>
                    <th>Waktu Pinjam</th>
                    <th>Tenggat Waktu</th>
                    <th>Nama Anggota</th>
                    <th>Judul Buku</th>
                    <th>No Fisik</th>
                    <th>Status</th>
                    <th>Denda</th>
                    @if(auth()->user()->role === 'admin')
                    <th style="text-align: center; width: 220px;">Aksi Sirkulasi & WA</th>
                    @endif
                </tr>
            </thead>
            <tbody>
                @forelse($peminjaman_terbaru as $pinjam)
                @php
                    $dueDate = \Carbon\Carbon::parse($pinjam->tgl_kembali);
                    if ($pinjam->status == '1') {
                        $isLate = now()->greaterThan($dueDate);
                        $daysLate = $isLate ? now()->startOfDay()->diffInDays($dueDate->startOfDay()) : 0;
                        $dendaRow = $daysLate * 1000;
                    } else {
                        $isLate = false;
                        $dendaRow = $pinjam->denda;
                    }

                    // Format WhatsApp message & link
                    $namaAnggota = $pinjam->anggota->nama_anggota ?? 'Anggota';
                    $judulBuku   = $pinjam->detailBuku->buku->judul_buku ?? 'Buku';
                    $noFisik     = $pinjam->no_buku;
                    $dueDateStr  = $dueDate->format('d-m-Y');
                    $noWa        = $pinjam->anggota->no_wa ?? null;

                    if ($noWa) {
                        $cleanWa = preg_replace('/[^0-9]/', '', $noWa);
                        if (substr($cleanWa, 0, 1) === '0') {
                            $cleanWa = '62' . substr($cleanWa, 1);
                        } elseif (substr($cleanWa, 0, 1) === '8') {
                            $cleanWa = '62' . $cleanWa;
                        }

                        if ($isLate) {
                            $pesanWa = "Halo {$namaAnggota}, ini adalah pengingat dari KalaPustaka bahwa peminjaman buku \"{$judulBuku}\" dengan nomor fisik {$noFisik} telah MELEWATI batas waktu pengembalian pada tanggal {$dueDateStr}. Mohon segera dikembalikan ke perpustakaan. Terima kasih.";
                        } else {
                            $pesanWa = "Halo {$namaAnggota}, ini adalah pengingat dari KalaPustaka bahwa buku \"{$judulBuku}\" dengan nomor fisik {$noFisik} harus dikembalikan pada tanggal {$dueDateStr}. Mohon dikembalikan tepat waktu untuk menghindari denda. Terima kasih.";
                        }

                        $waUrl = "https://wa.me/{$cleanWa}?text=" . rawurlencode($pesanWa);
                    } else {
                        $waUrl = null;
                    }
                @endphp
                <tr>
                    <td>
                        <span style="font-weight: 700; color: var(--primary); font-family: monospace; font-size: 0.95rem;">
                            {{ $pinjam->id_pinjam }}
                        </span>
                    </td>
                    <td style="color: var(--text-muted); font-size: 0.875rem;">
                        <i data-feather="calendar" style="width: 14px; height: 14px; margin-bottom: -2px; margin-right: 4px;"></i>
                        {{ \Carbon\Carbon::parse($pinjam->tgl_pinjam)->format('d M Y, H:i') }}
                    </td>
                    <td style="color: var(--text-muted); font-size: 0.875rem;">
                        <i data-feather="clock" style="width: 14px; height: 14px; margin-bottom: -2px; margin-right: 4px;"></i>
                        {{ $dueDate->format('d M Y') }}
                    </td>
                    <td>
                        <div style="display: flex; align-items: center; gap: 8px;">
                            <div style="width: 28px; height: 28px; border-radius: 50%; background: var(--primary-light); color: var(--primary); font-weight: 700; font-size: 0.75rem; display: flex; align-items: center; justify-content: center;">
                                {{ strtoupper(substr($pinjam->anggota->nama_anggota ?? 'A', 0, 1)) }}
                            </div>
                            <span style="font-weight: 600; color: var(--text-dark);">
                                {{ $pinjam->anggota->nama_anggota ?? '-' }}
                            </span>
                        </div>
                    </td>
                    <td>
                        <span style="font-weight: 600; color: var(--text-dark);">
                            {{ $pinjam->detailBuku->buku->judul_buku ?? '-' }}
                        </span>
                    </td>
                    <td>
                        <span class="badge" style="background: var(--bg-color); color: var(--text-body); border: 1px solid var(--border);">
                            <i data-feather="hash" style="width: 12px; height: 12px;"></i> {{ $pinjam->no_buku }}
                        </span>
                    </td>
                    <td>
                        @if($pinjam->status == '1')
                            @if($isLate)
                                <span class="badge badge-danger">Terlambat</span>
                            @else
                                <span class="badge badge-warning">Dipinjam</span>
                            @endif
                        @else
                            <span class="badge badge-success">Selesai</span>
                        @endif
                    </td>
                    <td>
                        @if($dendaRow > 0)
                            <span style="color: #ef4444; font-weight: 700;">Rp {{ number_format($dendaRow, 0, ',', '.') }}</span>
                        @else
                            <span style="color: var(--text-muted);">-</span>
                        @endif
                    </td>
                    @if(auth()->user()->role === 'admin')
                    <td style="text-align: center;">
                        <div style="display: flex; justify-content: center; align-items: center; gap: 6px; flex-wrap: wrap;">
                            @if($pinjam->status == '1')
                                @if($waUrl)
                                    <a href="{{ $waUrl }}" target="_blank" class="btn btn-sm" style="background: #25D366; color: white; border: none; font-weight: 600; padding: 0.35rem 0.65rem;" title="Kirim Pengingat WhatsApp ke {{ $namaAnggota }}">
                                        <i data-feather="message-circle" style="width: 14px; height: 14px; margin-bottom: -2px;"></i> Kirim WA
                                    </a>
                                @else
                                    <button class="btn btn-secondary btn-sm" disabled style="opacity: 0.55; cursor: not-allowed; padding: 0.35rem 0.65rem;" title="Nomor WhatsApp anggota belum diisi">
                                        <i data-feather="message-circle" style="width: 14px; height: 14px; margin-bottom: -2px;"></i> No WA (-)
                                    </button>
                                @endif

                                <form action="{{ route('peminjaman.kembali', $pinjam->id_pinjam) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin buku ini sudah dikembalikan?{{ $isLate ? '\n\n⚠️ PERHATIAN: Buku ini terlambat! Total Denda: Rp ' . number_format($dendaRow, 0, ',', '.') . '. Pastikan anggota telah membayar denda sebelum menyelesaikan transaksi.' : '' }}');" style="margin: 0;">
                                    @csrf
                                    <button type="submit" class="btn btn-secondary btn-sm" style="background: var(--secondary-light); color: #047857; border-color: rgba(16, 185, 129, 0.3);" title="Kembalikan Buku">
                                        <i data-feather="check-circle" style="width: 14px; height: 14px;"></i> Kembalikan
                                    </button>
                                </form>
                            @else
                                <span style="font-size: 0.8rem; color: var(--text-muted); font-weight: 600;">- Terkembali -</span>
                            @endif
                        </div>
                    </td>
                    @endif
                </tr>
                @empty
                <tr>
                    <td colspan="10" style="text-align: center; padding: 3rem 1rem;">
                        <div style="color: var(--text-muted);">
                            <i data-feather="inbox" style="width: 44px; height: 44px; margin-bottom: 0.5rem; stroke-width: 1.5;"></i>
                            <p style="font-weight: 500;">Belum ada transaksi peminjaman tercatat.</p>
                        </div>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div style="margin-top: 1.5rem;">
        {{ $peminjaman_terbaru->links('pagination::bootstrap-4') }}
    </div>
</div>
@endsection
