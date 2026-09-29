<?php

namespace App\Http\Controllers;

use App\Models\Anggota;
use App\Models\DetailBuku;
use App\Models\Peminjaman;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $total_buku = DetailBuku::count();
        $total_anggota = Anggota::count();
        $total_dipinjam = DetailBuku::where('status', 'dipinjam')->count();

        $peminjaman_terbaru = Peminjaman::with(['anggota', 'detailBuku.buku'])
            ->orderBy('tgl_pinjam', 'desc')
            ->paginate(10);

        return view('dashboard', compact('total_buku', 'total_anggota', 'total_dipinjam', 'peminjaman_terbaru'));
    }

    public function laporan(Request $request)
    {
        $bulan = $request->input('bulan', date('m'));
        $tahun = $request->input('tahun', date('Y'));

        $peminjaman = Peminjaman::with(['anggota', 'detailBuku.buku'])
            ->whereMonth('tgl_pinjam', $bulan)
            ->whereYear('tgl_pinjam', $tahun)
            ->orderBy('tgl_pinjam', 'asc')
            ->get();

        return view('laporan', compact('peminjaman', 'bulan', 'tahun'));
    }

    public function exportExcel(Request $request)
    {
        $bulan = $request->input('bulan', date('m'));
        $tahun = $request->input('tahun', date('Y'));

        $peminjaman = Peminjaman::with(['anggota', 'detailBuku.buku'])
            ->whereMonth('tgl_pinjam', $bulan)
            ->whereYear('tgl_pinjam', $tahun)
            ->orderBy('tgl_pinjam', 'asc')
            ->get();

        $filename = "Laporan_Peminjaman_KalaPustaka_" . $bulan . "_" . $tahun . ".csv";

        $headers = [
            "Content-type" => "text/csv; charset=UTF-8",
            "Content-Disposition" => "attachment; filename=$filename",
            "Pragma" => "no-cache",
            "Cache-Control" => "must-revalidate, post-check=0, pre-check=0",
            "Expires" => "0"
        ];

        $callback = function() use ($peminjaman, $bulan, $tahun) {
            $file = fopen('php://output', 'w');
            // Write UTF-8 BOM so Excel opens accented & special chars correctly
            fprintf($file, chr(0xEF).chr(0xBB).chr(0xBF));
            
            // Header Row
            fputcsv($file, [
                'No',
                'ID Pinjam',
                'Tanggal Pinjam',
                'ID Anggota',
                'Nama Anggota',
                'Judul Buku',
                'No. Fisik Buku',
                'Status'
            ], ';');

            foreach ($peminjaman as $index => $row) {
                fputcsv($file, [
                    $index + 1,
                    $row->id_pinjam,
                    \Carbon\Carbon::parse($row->tgl_pinjam)->format('d-m-Y H:i'),
                    $row->id_anggota,
                    $row->anggota->nama_anggota ?? '-',
                    $row->detailBuku->buku->judul_buku ?? '-',
                    $row->no_buku,
                    $row->status == '1' ? 'Dipinjam' : 'Selesai'
                ], ';');
            }

            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }
}
