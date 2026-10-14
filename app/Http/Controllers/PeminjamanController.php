<?php

namespace App\Http\Controllers;

use App\Models\Anggota;
use App\Models\DetailBuku;
use App\Models\Peminjaman;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PeminjamanController extends Controller
{
    /**
     * Menampilkan daftar transaksi peminjaman dengan berbagai filter dan pencarian.
     * Admin dapat melihat semua transaksi; anggota hanya melihat miliknya sendiri.
     */
    public function index(Request $request)
    {
        $user = auth()->user();

        $query = Peminjaman::with(['anggota', 'detailBuku.buku']);

        if ($user->role !== 'admin') {
            $anggota = Anggota::where('nama_anggota', $user->name)->first();
            $id_anggota = $anggota ? $anggota->id_anggota : null;
            if ($id_anggota) {
                $query->where('id_anggota', $id_anggota);
            } else {
                $query->whereRaw('1 = 0');
            }
        }

        // Filter Status
        if ($request->filled('status')) {
            if ($request->status === 'dipinjam') {
                $query->where('status', '1');
            } elseif ($request->status === 'selesai') {
                $query->where('status', '0');
            }
        }

        // Filter Denda
        if ($request->filled('denda')) {
            $now = now();
            if ($request->denda === 'ada') {
                $query->where(function ($q) use ($now) {
                    $q->where(function ($q1) {
                        $q1->where('status', '0')->where('denda', '>', 0);
                    })->orWhere(function ($q2) use ($now) {
                        $q2->where('status', '1')->where('tgl_kembali', '<', $now);
                    });
                });
            } elseif ($request->denda === 'tanpa') {
                $query->where(function ($q) use ($now) {
                    $q->where(function ($q1) {
                        $q1->where('status', '0')->where('denda', '=', 0);
                    })->orWhere(function ($q2) use ($now) {
                        $q2->where('status', '1')->where('tgl_kembali', '>=', $now);
                    });
                });
            }
        }

        // Filter Rentang Tanggal
        if ($request->filled('tgl_mulai')) {
            $query->whereDate('tgl_pinjam', '>=', $request->tgl_mulai);
        }
        if ($request->filled('tgl_selesai')) {
            $query->whereDate('tgl_pinjam', '<=', $request->tgl_selesai);
        }

        // Filter Pencarian
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('id_pinjam', 'like', "%{$search}%")
                  ->orWhere('id_anggota', 'like', "%{$search}%")
                  ->orWhere('no_buku', 'like', "%{$search}%")
                  ->orWhereHas('anggota', function ($qa) use ($search) {
                      $qa->where('nama_anggota', 'like', "%{$search}%");
                  })
                  ->orWhereHas('detailBuku.buku', function ($qb) use ($search) {
                      $qb->where('judul_buku', 'like', "%{$search}%");
                  });
            });
        }

        $peminjaman = $query->orderBy('tgl_pinjam', 'desc')->paginate(10)->withQueryString();

        return view('peminjaman.index', compact('peminjaman'));
    }
    /**
     * Menampilkan form peminjaman baru dengan auto-generate ID transaksi.
     */
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

    /**
     * Menyimpan transaksi peminjaman baru dan mengubah status buku menjadi 'dipinjam'.
     * Menggunakan DB transaction untuk menjamin konsistensi data.
     */
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

    /**
     * Memproses pengembalian buku: menghitung denda jika terlambat
     * dan mengembalikan status fisik buku menjadi 'ada'.
     */
    public function kembali($id)
    {
        $peminjaman = Peminjaman::findOrFail($id);

        DB::beginTransaction();
        try {
            $tgl_kembali = \Carbon\Carbon::parse($peminjaman->tgl_kembali);
            $sekarang = \Carbon\Carbon::now();
            $denda = 0;
            $pesan = 'Buku (No. Fisik: ' . $peminjaman->no_buku . ') berhasil dikembalikan dan stok diperbarui!';

            // Hitung denda hanya jika waktu pengembalian aktual MELEBIHI tenggat waktu
            if ($sekarang->greaterThan($tgl_kembali)) {
                $today = \Carbon\Carbon::today();
                $tglKembaliStart = $tgl_kembali->copy()->startOfDay();
                // diffInDays(target): target - self => harus tglKembaliStart->diffInDays(today) agar positif
                $daysLate = max(0, (int) $tglKembaliStart->diffInDays($today));
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
