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
                return $detail->buku->judul_buku;
            });

        // Generate ID Pinjam
        $last_pinjam = Peminjaman::orderBy('id_pinjam', 'desc')->first();
        $next_id = "p0001";
        if ($last_pinjam) {
            $num = (int)substr($last_pinjam->id_pinjam, 1);
            $next_id = 'p' . str_pad($num + 1, 4, '0', STR_PAD_LEFT);
        }

        return view('peminjaman.create', compact('anggota', 'buku', 'next_id'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'id_pinjam' => 'required|unique:peminjaman,id_pinjam',
            'id_anggota' => 'required|exists:anggota,id_anggota',
            'no_buku' => 'required|exists:detail_buku,no_buku'
        ]);

        DB::beginTransaction();

        try {
            Peminjaman::create([
                'id_pinjam' => $request->id_pinjam,
                'tgl_pinjam' => now(),
                'id_anggota' => $request->id_anggota,
                'no_buku' => $request->no_buku,
                'status' => '1' // 1 = dipinjam
            ]);

            DetailBuku::where('no_buku', $request->no_buku)->update(['status' => 'dipinjam']);

            DB::commit();

            return redirect()->route('peminjaman.create')->with('success', 'Peminjaman berhasil disimpan!');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->route('peminjaman.create')->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }
}
