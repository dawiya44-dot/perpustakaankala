<?php

namespace App\Http\Controllers;

use App\Models\Buku;
use App\Models\DetailBuku;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class BukuController extends Controller
{
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

    public function create()
    {
        $last_buku = Buku::orderBy('id_buku', 'desc')->first();
        $next_id = 'b001';
        if ($last_buku) {
            $num = (int) preg_replace('/[^0-9]/', '', $last_buku->id_buku);
            $next_id = 'b' . str_pad($num + 1, 3, '0', STR_PAD_LEFT);
        }

        return view('buku.create', compact('next_id'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'id_buku' => 'required|unique:buku,id_buku|max:10',
            'judul_buku' => 'required|max:100',
            'pengarang' => 'required|max:50',
            'penerbit' => 'required|max:50',
            'tahun_terbit' => 'required|integer',
            'jumlah' => 'required|integer|min:1',
        ]);

        DB::beginTransaction();
        try {
            $buku = Buku::create([
                'id_buku' => $request->id_buku,
                'judul_buku' => $request->judul_buku,
                'pengarang' => $request->pengarang,
                'penerbit' => $request->penerbit,
                'tahun_terbit' => $request->tahun_terbit,
                'jumlah' => $request->jumlah,
            ]);

            // Auto-generate physical book copies in detail_buku table
            for ($i = 1; $i <= $request->jumlah; $i++) {
                $no_buku = $request->id_buku . '_' . str_pad($i, 2, '0', STR_PAD_LEFT);
                DetailBuku::updateOrInsert(
                    ['no_buku' => $no_buku],
                    [
                        'id_buku' => $request->id_buku,
                        'status' => 'ada',
                        'updated_at' => now(),
                        'created_at' => now(),
                    ]
                );
            }

            DB::commit();
            return redirect()->route('buku.index')->with('success', 'Data Buku "' . $request->judul_buku . '" dan ' . $request->jumlah . ' fisik eksemplar berhasil ditambahkan.');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->withInput()->withErrors(['error' => 'Gagal menyimpan buku: ' . $e->getMessage()]);
        }
    }

    public function editById($id)
    {
        $buku = Buku::findOrFail($id);
        return view('buku.edit', compact('buku'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'judul_buku' => 'required|max:100',
            'pengarang' => 'required|max:50',
            'penerbit' => 'required|max:50',
            'tahun_terbit' => 'required|integer',
            'jumlah' => 'required|integer|min:0',
        ]);

        DB::beginTransaction();
        try {
            $buku = Buku::findOrFail($id);
            $buku->update([
                'judul_buku' => $request->judul_buku,
                'pengarang' => $request->pengarang,
                'penerbit' => $request->penerbit,
                'tahun_terbit' => $request->tahun_terbit,
                'jumlah' => $request->jumlah,
            ]);

            // Ensure detail_buku has at least $jumlah physical copies
            for ($i = 1; $i <= $request->jumlah; $i++) {
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
            return redirect()->route('buku.index')->with('success', 'Data Buku berhasil diperbarui.');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->withInput()->withErrors(['error' => 'Gagal memperbarui buku: ' . $e->getMessage()]);
        }
    }

    public function destroy($id)
    {
        $buku = Buku::findOrFail($id);
        $buku->delete();

        return redirect()->route('buku.index')->with('success', 'Data Buku berhasil dihapus.');
    }
}
