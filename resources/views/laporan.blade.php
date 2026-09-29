<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laporan Peminjaman KalaPustaka</title>
    <!-- Google Fonts Plus Jakarta Sans -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <!-- App CSS -->
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    <!-- Feather Icons -->
    <script src="https://unpkg.com/feather-icons"></script>
    <style>
        body {
            background-color: var(--bg-color);
            padding: 2rem 1rem;
            color: #0f172a;
        }

        .filter-toolbar {
            max-width: 950px;
            margin: 0 auto 1.5rem auto;
            background: var(--surface);
            padding: 1rem 1.5rem;
            border-radius: var(--radius-lg);
            border: 1px solid var(--border);
            box-shadow: var(--shadow);
            display: flex;
            justify-content: space-between;
            align-items: center;
            flex-wrap: wrap;
            gap: 1rem;
        }

        .paper-sheet {
            max-width: 950px;
            margin: 0 auto;
            background: #ffffff;
            padding: 3rem 2.5rem;
            border-radius: var(--radius-lg);
            box-shadow: var(--shadow-md);
            border: 1px solid var(--border);
            position: relative;
        }

        .report-header {
            text-align: center;
            border-bottom: 2px dashed #cbd5e1;
            padding-bottom: 1.25rem;
            margin-bottom: 1.5rem;
        }

        .report-header h1 {
            font-size: 1.6rem;
            font-weight: 800;
            color: var(--primary);
            margin: 0;
            letter-spacing: -0.02em;
        }

        .report-header p {
            font-size: 0.9rem;
            color: var(--text-muted);
            margin-top: 0.25rem;
        }

        .report-title {
            text-align: center;
            font-size: 1.1rem;
            font-weight: 700;
            color: #0f172a;
            margin-bottom: 1.5rem;
            text-transform: uppercase;
            letter-spacing: 0.04em;
        }

        .report-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 2rem;
            font-size: 0.9rem;
        }

        .report-table th, .report-table td {
            border: 1px solid #cbd5e1;
            padding: 0.75rem 0.85rem;
            text-align: left;
        }

        .report-table th {
            background-color: #f1f5f9;
            font-weight: 700;
            color: #334155;
            text-transform: uppercase;
            font-size: 0.75rem;
            letter-spacing: 0.05em;
        }

        @media print {
            .filter-toolbar {
                display: none !important;
            }
            body {
                background: white !important;
                padding: 0 !important;
            }
            .paper-sheet {
                box-shadow: none !important;
                border: none !important;
                padding: 0 !important;
                max-width: 100% !important;
            }
        }
    </style>
</head>
<body>

    <!-- Filter & Action Toolbar -->
    <div class="filter-toolbar">
        <form action="{{ route('laporan.index') }}" method="GET" style="display: flex; align-items: center; gap: 0.75rem; flex-wrap: wrap;">
            <div style="display: flex; align-items: center; gap: 0.5rem;">
                <label style="font-weight: 600; font-size: 0.875rem;">Bulan:</label>
                <select name="bulan" class="form-control" style="width: 120px; padding: 0.4rem 0.75rem; font-size: 0.875rem;">
                    @for($i=1; $i<=12; $i++)
                        @php $val = str_pad($i, 2, '0', STR_PAD_LEFT); @endphp
                        <option value="{{ $val }}" {{ $bulan == $val ? 'selected' : '' }}>{{ $val }}</option>
                    @endfor
                </select>
            </div>

            <div style="display: flex; align-items: center; gap: 0.5rem;">
                <label style="font-weight: 600; font-size: 0.875rem;">Tahun:</label>
                <input type="number" name="tahun" value="{{ $tahun }}" class="form-control" style="width: 100px; padding: 0.4rem 0.75rem; font-size: 0.875rem;">
            </div>

            <button type="submit" class="btn btn-primary btn-sm">
                <i data-feather="filter" style="width: 14px; height: 14px;"></i> Filter
            </button>
            
            <a href="{{ route('dashboard') }}" class="btn btn-secondary btn-sm">
                <i data-feather="arrow-left" style="width: 14px; height: 14px;"></i> Dashboard
            </a>
        </form>

        <div style="display: flex; gap: 0.5rem; flex-wrap: wrap;">
            <!-- Export Excel Button -->
            <a href="{{ route('laporan.excel', ['bulan' => $bulan, 'tahun' => $tahun]) }}" class="btn" style="background: #10b981; color: white; border: none;">
                <i data-feather="file-text"></i> Ekspor Excel (.csv/.xlsx)
            </a>

            <!-- Print PDF Button -->
            <button class="btn btn-primary" onclick="window.print()" style="background: #4f46e5; border-color: #4f46e5;">
                <i data-feather="printer"></i> Cetak Laporan (PDF)
            </button>
        </div>
    </div>

    <!-- Printable Paper Sheet -->
    <div class="paper-sheet">
        <div class="report-header">
            <h1>KalaPustaka</h1>
            <p>Sistem Informasi Manajemen Perpustakaan Terpadu<br>
            Jl. Perpustakaan Utama No. 1, Indonesia | Telepon: (021) 555-0199</p>
        </div>

        <div class="report-title">
            LAPORAN REKAPITULASI PEMINJAMAN BULAN {{ $bulan }} TAHUN {{ $tahun }}
        </div>

        <table class="report-table">
            <thead>
                <tr>
                    <th style="width: 5%; text-align: center;">No</th>
                    <th style="width: 15%;">ID Pinjam</th>
                    <th style="width: 20%;">Tanggal & Waktu</th>
                    <th style="width: 25%;">Nama Anggota</th>
                    <th style="width: 25%;">Judul Buku</th>
                    <th style="width: 10%; text-align: center;">Status</th>
                </tr>
            </thead>
            <tbody>
                @forelse($peminjaman as $index => $pinjam)
                <tr>
                    <td style="text-align: center; font-weight: 600;">{{ $index + 1 }}</td>
                    <td style="font-family: monospace; font-weight: 700; color: #4338ca;">{{ $pinjam->id_pinjam }}</td>
                    <td>{{ \Carbon\Carbon::parse($pinjam->tgl_pinjam)->format('d-m-Y H:i') }}</td>
                    <td><strong>{{ $pinjam->anggota->nama_anggota ?? '-' }}</strong></td>
                    <td>{{ $pinjam->detailBuku->buku->judul_buku ?? '-' }}</td>
                    <td style="text-align: center;">
                        <span style="font-weight: 700; font-size: 0.8rem; color: {{ $pinjam->status == '1' ? '#d97706' : '#059669' }};">
                            {{ $pinjam->status == '1' ? 'Dipinjam' : 'Selesai' }}
                        </span>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="6" style="text-align: center; color: #64748b; padding: 2rem;">
                        Tidak ada transaksi peminjaman tercatat pada periode ini.
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>

        <div style="display: flex; justify-content: space-between; align-items: flex-end; margin-top: 3rem; font-size: 0.875rem;">
            <div>
                <p style="color: #64748b; font-size: 0.8rem;">Dokumen ini dicetak secara otomatis melalui Sistem KalaPustaka.</p>
            </div>
            <div style="text-align: center; width: 220px;">
                <p>Dicetak pada: {{ date('d-m-Y H:i') }}</p>
                <div style="height: 60px;"></div>
                <p style="border-top: 1px solid #000; padding-top: 4px;"><strong>Admin Perpustakaan</strong></p>
            </div>
        </div>
    </div>

    <script>
        feather.replace();
    </script>
</body>
</html>
