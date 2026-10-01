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
        $user = auth()->user();

        if ($user->role === 'admin') {
            $total_buku = DetailBuku::count();
            $total_anggota = Anggota::count();
            $total_dipinjam = DetailBuku::where('status', 'dipinjam')->count();

            $peminjaman_terbaru = Peminjaman::with(['anggota', 'detailBuku.buku'])
                ->orderBy('tgl_pinjam', 'desc')
                ->paginate(10);

            // Calculate total active unpaid fines for all members
            $total_denda_global = 0;
            $all_active_loans = Peminjaman::where('status', '1')->get();
            foreach ($all_active_loans as $loan) {
                $dueDate = \Carbon\Carbon::parse($loan->tgl_kembali);
                if (now()->greaterThan($dueDate)) {
                    $daysLate = now()->startOfDay()->diffInDays($dueDate->startOfDay());
                    $total_denda_global += ($daysLate * 1000);
                }
            }

            return view('dashboard', compact('total_buku', 'total_anggota', 'total_dipinjam', 'peminjaman_terbaru', 'total_denda_global'));
        } else {
            // User Role Logic
            $anggota = Anggota::where('nama_anggota', $user->name)->first();
            $id_anggota = $anggota ? $anggota->id_anggota : null;

            // Fetch user's transactions
            $peminjaman_terbaru = Peminjaman::with(['anggota', 'detailBuku.buku'])
                ->when($id_anggota, function($query) use ($id_anggota) {
                    return $query->where('id_anggota', $id_anggota);
                }, function($query) {
                    return $query->whereRaw('1 = 0'); // Empty result if no mapping
                })
                ->orderBy('tgl_pinjam', 'desc')
                ->paginate(10);

            // Calculate active borrowings
            $buku_sedang_dipinjam = Peminjaman::where('status', '1')
                ->when($id_anggota, function($query) use ($id_anggota) {
                    return $query->where('id_anggota', $id_anggota);
                }, function($query) {
                    return $query->whereRaw('1 = 0');
                })->count();

            // Calculate active unpaid fines & notifications for user
            $total_denda = 0;
            $notifikasi_peminjaman = collect();

            if ($id_anggota) {
                $active_loans = Peminjaman::with(['detailBuku.buku'])
                    ->where('id_anggota', $id_anggota)
                    ->where('status', '1')
                    ->orderBy('tgl_kembali', 'asc')
                    ->get();

                $today = \Carbon\Carbon::now()->startOfDay();

                $notifikasi_peminjaman = $active_loans->map(function ($loan) use ($today, &$total_denda) {
                    $dueDate = \Carbon\Carbon::parse($loan->tgl_kembali);
                    $dueStart = $dueDate->copy()->startOfDay();

                    $isTerlambat = \Carbon\Carbon::now()->greaterThan($dueDate);
                    $hariTerlambat = $isTerlambat ? $today->diffInDays($dueStart) : 0;
                    $sisaHari = !$isTerlambat ? $today->diffInDays($dueStart) : 0;
                    $dendaEstimasi = $hariTerlambat * 1000;

                    $total_denda += $dendaEstimasi;

                    return (object) [
                        'id_pinjam'        => $loan->id_pinjam,
                        'judul_buku'       => $loan->detailBuku->buku->judul_buku ?? 'Buku Tidak Ditemukan',
                        'no_buku'          => $loan->no_buku,
                        'tgl_pinjam'       => $loan->tgl_pinjam,
                        'tgl_kembali'      => $loan->tgl_kembali,
                        'dueDateFormatted' => $dueDate->format('d M Y, H:i'),
                        'is_terlambat'     => $isTerlambat,
                        'hari_terlambat'   => $hariTerlambat,
                        'sisa_hari'        => $sisaHari,
                        'denda'            => $dendaEstimasi,
                    ];
                });
            }

            return view('dashboard', compact('peminjaman_terbaru', 'buku_sedang_dipinjam', 'total_denda', 'notifikasi_peminjaman'));
        }
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
