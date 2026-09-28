<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laporan Peminjaman KalaPustaka</title>
    <style>
        body {
            font-family: 'Times New Roman', Times, serif;
            color: #000;
            line-height: 1.5;
            margin: 0;
            padding: 2cm;
            background: #fff;
        }
        .header {
            text-align: center;
            border-bottom: 2px solid #000;
            padding-bottom: 10px;
            margin-bottom: 20px;
        }
        .header h1 {
            margin: 0;
            font-size: 24px;
            text-transform: uppercase;
        }
        .header p {
            margin: 5px 0 0;
            font-size: 14px;
        }
        .title {
            text-align: center;
            font-size: 18px;
            font-weight: bold;
            margin-bottom: 20px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }
        th, td {
            border: 1px solid #000;
            padding: 8px;
            text-align: left;
            font-size: 14px;
        }
        th {
            background-color: #f2f2f2;
        }
        .print-btn {
            display: block;
            margin: 20px auto;
            padding: 10px 20px;
            background-color: #4f46e5;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-size: 16px;
        }
        .filter-form {
            text-align: center;
            margin-bottom: 20px;
        }
        @media print {
            .print-btn, .filter-form {
                display: none !important;
            }
            body {
                padding: 0;
            }
        }
    </style>
</head>
<body>

    <div class="filter-form">
        <form action="{{ route('laporan.index') }}" method="GET">
            Bulan: 
            <select name="bulan">
                @for($i=1; $i<=12; $i++)
                    <option value="{{ str_pad($i, 2, '0', STR_PAD_LEFT) }}" {{ $bulan == str_pad($i, 2, '0', STR_PAD_LEFT) ? 'selected' : '' }}>{{ str_pad($i, 2, '0', STR_PAD_LEFT) }}</option>
                @endfor
            </select>
            Tahun: 
            <input type="number" name="tahun" value="{{ $tahun }}" style="width: 80px;">
            <button type="submit" style="padding: 4px 10px;">Filter</button>
            <a href="{{ route('dashboard') }}" style="margin-left: 10px; color: blue;">Kembali ke Dashboard</a>
        </form>
    </div>

    <div class="header">
        <h1>KalaPustaka</h1>
        <p>Sistem Informasi Manajemen Perpustakaan Terpadu<br>
        Laporan Rekapitulasi Data Peminjaman Buku</p>
    </div>

    <div class="title">
        LAPORAN PEMINJAMAN BULAN {{ $bulan }} TAHUN {{ $tahun }}
    </div>

    <table>
        <thead>
            <tr>
                <th style="width: 5%;">No</th>
                <th style="width: 15%;">ID Pinjam</th>
                <th style="width: 20%;">Tanggal</th>
                <th style="width: 25%;">Nama Anggota</th>
                <th style="width: 25%;">Judul Buku</th>
                <th style="width: 10%;">Status</th>
            </tr>
        </thead>
        <tbody>
            @forelse($peminjaman as $index => $pinjam)
            <tr>
                <td style="text-align: center;">{{ $index + 1 }}</td>
                <td>{{ $pinjam->id_pinjam }}</td>
                <td>{{ \Carbon\Carbon::parse($pinjam->tgl_pinjam)->format('d-m-Y H:i') }}</td>
                <td>{{ $pinjam->anggota->nama_anggota }}</td>
                <td>{{ $pinjam->detailBuku->buku->judul_buku }}</td>
                <td>{{ $pinjam->status == '1' ? 'Dipinjam' : 'Selesai' }}</td>
            </tr>
            @empty
            <tr>
                <td colspan="6" style="text-align: center;">Tidak ada transaksi pada periode ini.</td>
            </tr>
            @endforelse
        </tbody>
    </table>

    <div style="text-align: right; margin-top: 40px; font-size: 14px;">
        <p>Dicetak pada: {{ date('d-m-Y H:i') }}</p>
        <br><br><br>
        <p><strong>Admin Perpustakaan</strong></p>
    </div>

    <button class="print-btn" onclick="window.print()">🖨️ Cetak Laporan (PDF)</button>

</body>
</html>
