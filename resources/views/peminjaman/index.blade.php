@extends('layouts.app')

@section('title', 'Daftar Transaksi Peminjaman')

@section('content')
<div class="card animate-fade-in" style="margin-bottom: 1.5rem;">
    <div class="card-header" style="flex-wrap: wrap; gap: 1rem; justify-content: space-between; align-items: center;">
        <div>
            <h2 class="card-title">Daftar Transaksi Peminjaman</h2>
            <p style="font-size: 0.875rem; color: var(--text-muted); margin-top: 2px;">Kelola dan pantau seluruh transaksi sirkulasi peminjaman buku</p>
        </div>
        <div style="display: flex; gap: 0.5rem; flex-wrap: wrap;">
            @if(auth()->user()->role === 'admin')
            <a href="{{ route('peminjaman.create') }}" class="btn btn-primary btn-sm">
                <i data-feather="plus-circle" style="width: 16px; height: 16px;"></i> Peminjaman Baru
            </a>
            @endif
        </div>
    </div>

    <!-- Filter Form Toolbar -->
    <div style="padding: 1.25rem 1.5rem; background: var(--bg-color); border-bottom: 1px solid var(--border);">
        <form action="{{ route('peminjaman.index') }}" method="GET" style="display: flex; flex-wrap: wrap; gap: 1rem; align-items: flex-end;">
            
            <!-- Filter Status -->
            <div style="flex: 1; min-width: 160px;">
                <label style="display: block; font-size: 0.8rem; font-weight: 600; color: var(--text-muted); margin-bottom: 4px;">Status Peminjaman</label>
                <select name="status" class="form-control" style="font-size: 0.875rem; padding: 0.5rem 0.75rem;">
                    <option value="">-- Semua Status --</option>
                    <option value="dipinjam" {{ request('status') == 'dipinjam' ? 'selected' : '' }}>Dipinjam</option>
                    <option value="selesai" {{ request('status') == 'selesai' ? 'selected' : '' }}>Selesai</option>
                </select>
            </div>

            <!-- Filter Denda -->
            <div style="flex: 1; min-width: 160px;">
                <label style="display: block; font-size: 0.8rem; font-weight: 600; color: var(--text-muted); margin-bottom: 4px;">Status Denda</label>
                <select name="denda" class="form-control" style="font-size: 0.875rem; padding: 0.5rem 0.75rem;">
                    <option value="">-- Semua Denda --</option>
                    <option value="ada" {{ request('denda') == 'ada' ? 'selected' : '' }}>Ada Denda</option>
                    <option value="tanpa" {{ request('denda') == 'tanpa' ? 'selected' : '' }}>Tanpa Denda</option>
                </select>
            </div>

            <!-- Filter Rentang Tanggal Mulai -->
            <div style="flex: 1; min-width: 150px;">
                <label style="display: block; font-size: 0.8rem; font-weight: 600; color: var(--text-muted); margin-bottom: 4px;">Tgl Pinjam Mulai</label>
                <input type="date" name="tgl_mulai" value="{{ request('tgl_mulai') }}" class="form-control" style="font-size: 0.875rem; padding: 0.5rem 0.75rem;">
            </div>

            <!-- Filter Rentang Tanggal Selesai -->
            <div style="flex: 1; min-width: 150px;">
                <label style="display: block; font-size: 0.8rem; font-weight: 600; color: var(--text-muted); margin-bottom: 4px;">Tgl Pinjam Sampai</label>
                <input type="date" name="tgl_selesai" value="{{ request('tgl_selesai') }}" class="form-control" style="font-size: 0.875rem; padding: 0.5rem 0.75rem;">
            </div>

            <!-- Filter Search -->
            <div style="flex: 1.5; min-width: 200px;">
                <label style="display: block; font-size: 0.8rem; font-weight: 600; color: var(--text-muted); margin-bottom: 4px;">Pencarian</label>
                <div style="position: relative;">
                    <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari ID/Anggota/Buku..." class="form-control" style="font-size: 0.875rem; padding: 0.5rem 0.75rem 0.5rem 2.2rem;">
                    <i data-feather="search" style="position: absolute; left: 0.75rem; top: 50%; transform: translateY(-50%); width: 15px; height: 15px; color: var(--text-muted);"></i>
                </div>
            </div>

            <!-- Action Buttons -->
            <div style="display: flex; gap: 0.5rem;">
                <button type="submit" class="btn btn-primary btn-sm" style="padding: 0.55rem 1rem;">
                    <i data-feather="filter" style="width: 15px; height: 15px;"></i> Filter
                </button>
                @if(request()->hasAny(['status', 'denda', 'tgl_mulai', 'tgl_selesai', 'search']))
                <a href="{{ route('peminjaman.index') }}" class="btn btn-secondary btn-sm" style="padding: 0.55rem 1rem;">
                    <i data-feather="refresh-cw" style="width: 15px; height: 15px;"></i> Reset
                </a>
                @endif
            </div>

        </form>
    </div>

    <!-- Table Section -->
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
                @forelse($peminjaman as $pinjam)
                @php
                    $dueDate = \Carbon\Carbon::parse($pinjam->tgl_kembali);
                    if ($pinjam->status == '1') {
                        $isLate = \Carbon\Carbon::now()->greaterThan($dueDate);
                        // Hitung denda: dueDateStart->diffInDays(today) agar hasilnya positif
                        $today = \Carbon\Carbon::today();
                        $dueDateStart = $dueDate->copy()->startOfDay();
                        $daysLate = $isLate ? max(0, (int) $dueDateStart->diffInDays($today)) : 0;
                        $dendaRow = $daysLate * 1000;
                    } else {
                        $isLate = false;
                        $dendaRow = max(0, (int) $pinjam->denda);
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
                            <p style="font-weight: 500;">Tidak ada transaksi peminjaman yang sesuai dengan filter.</p>
                        </div>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div style="padding: 1rem 1.5rem; border-top: 1px solid var(--border);">
        {{ $peminjaman->links('pagination::bootstrap-4') }}
    </div>
</div>
@endsection
