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
        $last_anggota = Anggota::orderBy('id_anggota', 'desc')->first();
        $next_id = 'a0001';
        if ($last_anggota) {
            $num = (int) preg_replace('/[^0-9]/', '', $last_anggota->id_anggota);
            $next_id = 'a' . str_pad($num + 1, 4, '0', STR_PAD_LEFT);
        }

        return view('anggota.create', compact('next_id'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'id_anggota' => 'required|unique:anggota,id_anggota|max:10',
            'nama_anggota' => 'required|max:50',
            'kelas' => 'required|max:20',
            'no_wa' => 'nullable|string|max:20',
            'tempatlahir' => 'required|max:30',
            'tgllahir' => 'required|date',
        ]);

        try {
            Anggota::create([
                'id_anggota' => $request->id_anggota,
                'nama_anggota' => $request->nama_anggota,
                'kelas' => $request->kelas,
                'no_wa' => $request->no_wa,
                'tempatlahir' => $request->tempatlahir,
                'tgllahir' => $request->tgllahir,
            ]);

            return redirect()->route('anggota.index')->with('success', 'Data Anggota "' . $request->nama_anggota . '" berhasil ditambahkan.');
        } catch (\Exception $e) {
            return redirect()->back()->withInput()->withErrors(['error' => 'Gagal menyimpan data anggota: ' . $e->getMessage()]);
        }
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
            'kelas' => 'required|max:20',
            'no_wa' => 'nullable|string|max:20',
            'tempatlahir' => 'required|max:30',
            'tgllahir' => 'required|date',
        ]);

        try {
            $anggota = Anggota::findOrFail($id);
            $anggota->update([
                'nama_anggota' => $request->nama_anggota,
                'kelas' => $request->kelas,
                'no_wa' => $request->no_wa,
                'tempatlahir' => $request->tempatlahir,
                'tgllahir' => $request->tgllahir,
            ]);

            return redirect()->route('anggota.index')->with('success', 'Data Anggota berhasil diperbarui.');
        } catch (\Exception $e) {
            return redirect()->back()->withInput()->withErrors(['error' => 'Gagal memperbarui data anggota: ' . $e->getMessage()]);
        }
    }

    public function destroy($id)
    {
        $anggota = Anggota::findOrFail($id);
        $anggota->delete();

        return redirect()->route('anggota.index')->with('success', 'Data Anggota berhasil dihapus.');
    }
}
