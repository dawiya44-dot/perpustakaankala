<?php

namespace App\Http\Controllers;

use App\Models\Anggota;
use App\Models\DetailBuku;
use App\Models\Peminjaman;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PeminjamanController extends Controller
{
    public function create()
    {
        $anggota = Anggota::orderBy('nama_anggota', 'asc')->get();
        $buku = DetailBuku::with('buku')
            ->where('status', 'ada')
            ->get()
            ->sortBy(function($detail) {
                return $detail->buku->judul_buku ?? '';
            });

        // Generate ID Pinjam
        $last_pinjam = Peminjaman::orderBy('id_pinjam', 'desc')->first();
        $next_id = "p0001";
        if ($last_pinjam) {
            $num = (int) preg_replace('/[^0-9]/', '', $last_pinjam->id_pinjam);
            $next_id = 'p' . str_pad($num + 1, 4, '0', STR_PAD_LEFT);
        }

        $default_tgl_kembali = now()->addDays(7)->format('Y-m-d\TH:i');

        return view('peminjaman.create', compact('anggota', 'buku', 'next_id', 'default_tgl_kembali'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'id_pinjam' => 'required|unique:peminjaman,id_pinjam',
            'id_anggota' => 'required|exists:anggota,id_anggota',
            'no_buku' => 'required|exists:detail_buku,no_buku',
            'tgl_kembali' => 'required|date'
        ]);

        DB::beginTransaction();

        try {
            $tgl_kembali = \Carbon\Carbon::parse($request->tgl_kembali);
            
            Peminjaman::create([
                'id_pinjam' => $request->id_pinjam,
                'tgl_pinjam' => now(),
                'tgl_kembali' => $tgl_kembali,
                'id_anggota' => $request->id_anggota,
                'no_buku' => $request->no_buku,
                'status' => '1' // 1 = dipinjam
            ]);

            DetailBuku::where('no_buku', $request->no_buku)->update(['status' => 'dipinjam']);

            DB::commit();

            return redirect()->route('dashboard')->with('success', 'Transaksi peminjaman buku berhasil disimpan! Tenggat waktu: ' . $tgl_kembali->format('d-m-Y H:i'));
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->route('peminjaman.create')->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    public function kembali($id)
    {
        $peminjaman = Peminjaman::findOrFail($id);

        DB::beginTransaction();
        try {
            $tgl_kembali = \Carbon\Carbon::parse($peminjaman->tgl_kembali);
            $sekarang = now();
            $denda = 0;
            $pesan = 'Buku (No. Fisik: ' . $peminjaman->no_buku . ') berhasil dikembalikan dan stok diperbarui!';
            
            if ($sekarang->greaterThan($tgl_kembali)) {
                $daysLate = $sekarang->startOfDay()->diffInDays($tgl_kembali->startOfDay());
                if ($daysLate > 0) {
                    $denda = $daysLate * 1000;
                    $pesan = 'Buku berhasil dikembalikan. Terdapat keterlambatan ' . $daysLate . ' hari. Total denda dibayarkan: Rp ' . number_format($denda, 0, ',', '.');
                }
            }

            // Update status peminjaman menjadi 0 (Selesai/Dikembalikan)
            $peminjaman->update([
                'status' => '0',
                'tgl_dikembalikan' => $sekarang,
                'denda' => $denda
            ]);

            // Kembalikan status fisik buku di detail_buku menjadi 'ada'
            DetailBuku::where('no_buku', $peminjaman->no_buku)->update(['status' => 'ada']);

            DB::commit();

            return redirect()->back()->with('success', $pesan);
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', 'Gagal memproses pengembalian buku: ' . $e->getMessage());
        }
    }
}
