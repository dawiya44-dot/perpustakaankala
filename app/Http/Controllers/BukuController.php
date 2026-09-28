<?php

namespace App\Http\Controllers;

use App\Models\Buku;
use Illuminate\Http\Request;

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
        return view('buku.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'id_buku' => 'required|unique:buku,id_buku|max:10',
            'judul_buku' => 'required|max:100',
            'pengarang' => 'required|max:50',
            'penerbit' => 'required|max:50',
            'tahun_terbit' => 'required|integer',
            'jumlah' => 'required|integer|min:0',
        ]);

        Buku::create($request->all());

        return redirect()->route('buku.index')->with('success', 'Data Buku berhasil ditambahkan.');
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

        $buku = Buku::findOrFail($id);
        $buku->update($request->all());

        return redirect()->route('buku.index')->with('success', 'Data Buku berhasil diperbarui.');
    }

    public function destroy($id)
    {
        $buku = Buku::findOrFail($id);
        $buku->delete();

        return redirect()->route('buku.index')->with('success', 'Data Buku berhasil dihapus.');
    }
}
