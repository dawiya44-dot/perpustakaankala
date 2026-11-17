<?php

namespace App\Http\Controllers;

use App\Models\Buku;
use App\Models\DetailBuku;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class BukuController extends Controller
{
    /**
     * Menampilkan daftar buku dengan fitur pencarian dan pagination.
     */
    public function index(Request $request)
    {
        $search = $request->input('search');
        $buku = Buku::when($search, function ($query, $search) {
            return $query->where('judul_buku', 'like', "%{$search}%")
                         ->orWhere('id_buku', 'like', "%{$search}%")
                         ->orWhere('pengarang', 'like', "%{$search}%");
        })->orderBy('id_buku', 'asc')->paginate(10);
        
        return view('buku.index', compact('buku', 'search'));
    }

    /**
     * Menampilkan form tambah buku baru dengan auto-generate ID.
     */
    public function create()
    {
        abort_if(auth()->user()->role !== 'admin', 403);
        // FIX: Gunakan urutan numerik agar b009 < b010, bukan urutan string
        $last_buku = Buku::orderByRaw('CAST(SUBSTRING(id_buku, 2) AS UNSIGNED) DESC')->first();
        $next_id = 'b001';
        if ($last_buku) {
            $num = (int) preg_replace('/[^0-9]/', '', $last_buku->id_buku);
            $next_id = 'b' . str_pad($num + 1, 3, '0', STR_PAD_LEFT);
        }

        return view('buku.create', compact('next_id'));
    }

    /**
     * Menyimpan data buku baru dan auto-generate eksemplar fisik di detail_buku.
     */
    public function store(Request $request)
    {
        abort_if(auth()->user()->role !== 'admin', 403);
        $validated = $request->validate([
            'id_buku'      => 'required|unique:buku,id_buku|max:10|regex:/^b\d+$/',
            'judul_buku'   => 'required|max:100',
            'pengarang'    => 'required|max:50',
            'penerbit'     => 'nullable|max:50',
            'tahun_terbit' => 'required|integer|min:1900|max:' . date('Y'),
            'jumlah'       => 'required|integer|min:1|max:999',
            'kategori'     => 'nullable|in:Fiksi,Nonfiksi',
        ]);

        // FIX: Simpan null jika penerbit kosong, bukan string ''
        $validated['penerbit'] = $validated['penerbit'] ?: null;

        DB::beginTransaction();
        try {
            $buku = Buku::create($validated);

            // Auto-generate physical book copies in detail_buku table
            for ($i = 1; $i <= $validated['jumlah']; $i++) {
                $no_buku = $validated['id_buku'] . '_' . str_pad($i, 2, '0', STR_PAD_LEFT);
                DetailBuku::updateOrInsert(
                    ['no_buku' => $no_buku],
                    [
                        'id_buku' => $validated['id_buku'],
                        'status' => 'ada',
                        'updated_at' => now(),
                        'created_at' => now(),
                    ]
                );
            }

            DB::commit();
            return redirect()->route('buku.index')->with('success', 'Buku "' . $validated['judul_buku'] . '" dan ' . $validated['jumlah'] . ' eksemplar berhasil ditambahkan.');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->withInput()->withErrors(['error' => 'Gagal menyimpan buku: ' . $e->getMessage()]);
        }
    }

    /**
     * Menampilkan form edit data buku berdasarkan ID.
     */
    public function editById($id)
    {
        abort_if(auth()->user()->role !== 'admin', 403);
        $buku = Buku::findOrFail($id);
        return view('buku.edit', compact('buku'));
    }

    /**
     * Memperbarui data buku dan sinkronisasi eksemplar fisik jika jumlah berubah.
     */
    public function update(Request $request, $id)
    {
        abort_if(auth()->user()->role !== 'admin', 403);
        $validated = $request->validate([
            'judul_buku'   => 'required|max:100',
            'pengarang'    => 'required|max:50',
            'penerbit'     => 'nullable|max:50',
            'tahun_terbit' => 'required|integer|min:1900|max:' . date('Y'), // FIX: tambah max
            'jumlah'       => 'required|integer|min:0|max:999',
            'kategori'     => 'nullable|in:Fiksi,Nonfiksi',
        ]);

        // FIX: Simpan null jika penerbit kosong, bukan string ''
        $validated['penerbit'] = $validated['penerbit'] ?: null;

        DB::beginTransaction();
        try {
            $buku = Buku::findOrFail($id);
            $buku->update($validated);

            // Ensure detail_buku has at least $jumlah physical copies
            for ($i = 1; $i <= $validated['jumlah']; $i++) {
                $no_buku = $buku->id_buku . '_' . str_pad($i, 2, '0', STR_PAD_LEFT);
                DetailBuku::firstOrCreate(
                    ['no_buku' => $no_buku],
                    [
                        'id_buku' => $buku->id_buku,
                        'status' => 'ada',
                    ]
                );
            }

            DB::commit();
            return redirect()->route('buku.index')->with('success', 'Data Buku "' . $buku->judul_buku . '" berhasil diperbarui.');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->withInput()->withErrors(['error' => 'Gagal memperbarui buku: ' . $e->getMessage()]);
        }
    }

    /**
     * Menghapus data buku beserta eksemplar fisiknya.
     */
    public function destroy($id)
    {
        abort_if(auth()->user()->role !== 'admin', 403);
        $buku = Buku::findOrFail($id);
        $judul = $buku->judul_buku;
        $buku->delete();

        return redirect()->route('buku.index')->with('success', 'Buku "' . $judul . '" berhasil dihapus.');
    }
}
