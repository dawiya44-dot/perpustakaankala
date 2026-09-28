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
            ->limit(5)
            ->get();

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
}
