@extends('layouts.app')

@section('title', 'Daftar Buku')

@section('content')
<div class="page-header">
    <h1>Katalog Buku</h1>
    <p>Daftar koleksi buku yang tersedia di perpustakaan.</p>
</div>

@if (session('success'))
    <div class="alert alert-success">
        {{ session('success') }}
    </div>
@endif

<div class="card">
    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 1.5rem; flex-wrap: wrap; gap: 1rem;">
        <form action="{{ route('buku.index') }}" method="GET" style="display: flex; gap: 0.5rem; flex-grow: 1; max-width: 400px;">
            <input type="text" name="search" class="form-control" placeholder="Cari Judul, Pengarang, atau ID..." value="{{ request('search') }}">
            <button type="submit" class="btn btn-primary"><i data-feather="search"></i> Cari</button>
        </form>
        @if(auth()->user()->role === 'admin')
        <a href="{{ route('buku.create') }}" class="btn btn-primary"><i data-feather="plus"></i> Tambah Buku</a>
        @endif
    </div>
    
    <div class="table-container">
        <table class="table">
            <thead>
                <tr>
                    <th>ID Buku</th>
                    <th>Judul Buku</th>
                    <th>Pengarang & Penerbit</th>
                    <th>Tahun</th>
                    <th>Jumlah</th>
                    @if(auth()->user()->role === 'admin')
                    <th style="width: 150px; text-align: center;">Aksi</th>
                    @endif
                </tr>
            </thead>
            <tbody>
                @forelse($buku as $item)
                <tr>
                    <td><strong>{{ $item->id_buku }}</strong></td>
                    <td>{{ $item->judul_buku }}</td>
                    <td>
                        {{ $item->pengarang }}<br>
                        <small class="text-muted">{{ $item->penerbit }}</small>
                    </td>
                    <td>{{ $item->tahun_terbit }}</td>
                    <td>{{ $item->jumlah }}</td>
                    @if(auth()->user()->role === 'admin')
                    <td style="text-align: center;">
                        <a href="{{ route('buku.edit', $item->id_buku) }}" class="btn" style="padding: 0.4rem; background: #e0e7ff; color: #4f46e5; margin-right: 4px;"><i data-feather="edit" style="width:16px;height:16px;"></i></a>
                        <form action="{{ route('buku.destroy', $item->id_buku) }}" method="POST" style="display:inline;" onsubmit="return confirm('Yakin ingin menghapus data ini?');">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn" style="padding: 0.4rem; background: #fee2e2; color: #dc2626;"><i data-feather="trash-2" style="width:16px;height:16px;"></i></button>
                        </form>
                    </td>
                    @endif
                </tr>
                @empty
                <tr>
                    <td colspan="6" style="text-align: center; color: var(--text-muted);">Data buku tidak ditemukan.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    
    <div style="margin-top: 1.5rem;">
        {{ $buku->links('pagination::bootstrap-4') }}
    </div>
</div>
@endsection
