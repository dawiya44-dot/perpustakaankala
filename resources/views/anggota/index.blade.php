@extends('layouts.app')

@section('title', 'Daftar Anggota')

@section('content')
<div class="page-header">
    <h1>Data Anggota</h1>
    <p>Kelola data anggota perpustakaan di sini.</p>
</div>

@if (session('success'))
    <div class="alert alert-success">
        {{ session('success') }}
    </div>
@endif

<div class="card">
    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 1.5rem; flex-wrap: wrap; gap: 1rem;">
        <form action="{{ route('anggota.index') }}" method="GET" style="display: flex; gap: 0.5rem; flex-grow: 1; max-width: 400px;">
            <input type="text" name="search" class="form-control" placeholder="Cari ID atau Nama..." value="{{ request('search') }}">
            <button type="submit" class="btn btn-primary"><i data-feather="search"></i> Cari</button>
        </form>
        @if(auth()->user()->role === 'admin')
        <a href="{{ route('anggota.create') }}" class="btn btn-primary"><i data-feather="plus"></i> Tambah Anggota</a>
        @endif
    </div>
    
    <div class="table-container">
        <table class="table">
            <thead>
                <tr>
                    <th>ID Anggota</th>
                    <th>Nama</th>
                    <th>Kelas</th>
                    <th>Tempat, Tgl Lahir</th>
                    @if(auth()->user()->role === 'admin')
                    <th style="width: 150px; text-align: center;">Aksi</th>
                    @endif
                </tr>
            </thead>
            <tbody>
                @forelse($anggota as $item)
                <tr>
                    <td><strong>{{ $item->id_anggota }}</strong></td>
                    <td>{{ $item->nama_anggota }}</td>
                    <td>{{ $item->kelas }}</td>
                    <td>{{ $item->tempatlahir }}, {{ \Carbon\Carbon::parse($item->tgllahir)->format('d M Y') }}</td>
                    @if(auth()->user()->role === 'admin')
                    <td style="text-align: center;">
                        <a href="{{ route('anggota.edit', $item->id_anggota) }}" class="btn" style="padding: 0.4rem; background: #e0e7ff; color: #4f46e5; margin-right: 4px;"><i data-feather="edit" style="width:16px;height:16px;"></i></a>
                        <form action="{{ route('anggota.destroy', $item->id_anggota) }}" method="POST" style="display:inline;" onsubmit="return confirm('Yakin ingin menghapus data ini?');">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn" style="padding: 0.4rem; background: #fee2e2; color: #dc2626;"><i data-feather="trash-2" style="width:16px;height:16px;"></i></button>
                        </form>
                    </td>
                    @endif
                </tr>
                @empty
                <tr>
                    <td colspan="5" style="text-align: center; color: var(--text-muted);">Data anggota tidak ditemukan.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    
    <div style="margin-top: 1.5rem;">
        {{ $anggota->links('pagination::bootstrap-4') }}
    </div>
</div>
@endsection
