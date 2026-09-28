<?php

namespace App\Http\Controllers;

use App\Models\Anggota;
use Illuminate\Http\Request;

class AnggotaController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->input('search');
        $anggota = Anggota::when($search, function ($query, $search) {
            return $query->where('nama_anggota', 'like', "%{$search}%")
                         ->orWhere('id_anggota', 'like', "%{$search}%");
        })->orderBy('id_anggota', 'asc')->paginate(10);
        
        return view('anggota.index', compact('anggota', 'search'));
    }

    public function create()
    {
        return view('anggota.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'id_anggota' => 'required|unique:anggota,id_anggota|max:10',
            'nama_anggota' => 'required|max:50',
            'kelas' => 'required|max:10',
            'tempatlahir' => 'required|max:30',
            'tgllahir' => 'required|date',
        ]);

        Anggota::create($request->all());

        return redirect()->route('anggota.index')->with('success', 'Data Anggota berhasil ditambahkan.');
    }

    public function edit(Anggota $anggotum) // Route model binding, param name is anggotum due to grammar rules, we'll override it manually to be safe
    {
        // Not using route model binding for safe naming
    }
    
    public function editById($id)
    {
        $anggota = Anggota::findOrFail($id);
        return view('anggota.edit', compact('anggota'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'nama_anggota' => 'required|max:50',
            'kelas' => 'required|max:10',
            'tempatlahir' => 'required|max:30',
            'tgllahir' => 'required|date',
        ]);

        $anggota = Anggota::findOrFail($id);
        $anggota->update($request->all());

        return redirect()->route('anggota.index')->with('success', 'Data Anggota berhasil diperbarui.');
    }

    public function destroy($id)
    {
        $anggota = Anggota::findOrFail($id);
        $anggota->delete();

        return redirect()->route('anggota.index')->with('success', 'Data Anggota berhasil dihapus.');
    }
}
