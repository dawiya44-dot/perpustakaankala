@extends('layouts.app')

@section('title', 'Daftar Buku')

@section('content')
<div class="page-header animate-fade-in">
    <div class="page-header-content">
        <div>
            <h1>Katalog & Data Buku</h1>
            <p>Kelola seluruh koleksi dan persediaan buku di perpustakaan</p>
        </div>
        @if(auth()->user()->role === 'admin')
        <div>
            <a href="{{ route('buku.create') }}" class="btn btn-primary">
                <i data-feather="plus-circle"></i> Tambah Buku Baru
            </a>
        </div>
        @endif
    </div>
</div>

<div class="card animate-fade-in">
    <!-- Filter and Search Bar -->
    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 1.5rem; flex-wrap: wrap; gap: 1rem;">
        <form action="{{ route('buku.index') }}" method="GET" style="display: flex; gap: 0.5rem; flex-grow: 1; max-width: 450px;">
            <div style="position: relative; flex: 1;">
                <input type="text" name="search" class="form-control" placeholder="Cari Judul, Pengarang, atau ID..." value="{{ request('search') }}" style="padding-left: 2.5rem;">
                <i data-feather="search" style="position: absolute; left: 0.85rem; top: 50%; transform: translateY(-50%); width: 18px; height: 18px; color: var(--text-muted);"></i>
            </div>
            <button type="submit" class="btn btn-primary">Cari</button>
            @if(request('search'))
            <a href="{{ route('buku.index') }}" class="btn btn-secondary" title="Reset Search">
                <i data-feather="x"></i>
            </a>
            @endif
        </form>
    </div>
    
    <div class="table-container">
        <table class="table">
            <thead>
                <tr>
                    <th style="width: 120px;">ID Buku</th>
                    <th>Judul Buku</th>
                    <th>Pengarang & Penerbit</th>
                    <th style="width: 100px;">Tahun</th>
                    <th style="width: 120px;">Jumlah Stok</th>
                    @if(auth()->user()->role === 'admin')
                    <th style="width: 130px; text-align: center;">Aksi</th>
                    @endif
                </tr>
            </thead>
            <tbody>
                @forelse($buku as $item)
                <tr>
                    <td>
                        <span style="font-weight: 700; color: var(--primary); font-family: monospace; font-size: 0.95rem;">
                            {{ $item->id_buku }}
                        </span>
                    </td>
                    <td>
                        <div style="display: flex; align-items: center; gap: 10px;">
                            <div style="width: 34px; height: 34px; border-radius: 8px; background: var(--primary-light); color: var(--primary); display: flex; align-items: center; justify-content: center; flex-shrink: 0;">
                                <i data-feather="book" style="width: 18px; height: 18px;"></i>
                            </div>
                            <span style="font-weight: 700; color: var(--text-dark); font-size: 0.95rem;">
                                {{ $item->judul_buku }}
                            </span>
                        </div>
                    </td>
                    <td>
                        <div style="font-weight: 600; color: var(--text-dark);">{{ $item->pengarang }}</div>
                        <div style="font-size: 0.825rem; color: var(--text-muted); display: flex; align-items: center; gap: 4px; margin-top: 2px;">
                            <i data-feather="printer" style="width: 12px; height: 12px;"></i> {{ $item->penerbit }}
                        </div>
                    </td>
                    <td>
                        <span class="badge" style="background: var(--bg-color); color: var(--text-body); border: 1px solid var(--border);">
                            {{ $item->tahun_terbit }}
                        </span>
                    </td>
                    <td>
                        @if($item->jumlah > 0)
                            <span class="badge badge-success">
                                {{ $item->jumlah }} Unit
                            </span>
                        @else
                            <span class="badge badge-danger">
                                Habis
                            </span>
                        @endif
                    </td>
                    @if(auth()->user()->role === 'admin')
                    <td style="text-align: center;">
                        <div style="display: flex; justify-content: center; gap: 6px;">
                            <a href="{{ route('buku.edit', $item->id_buku) }}" class="btn btn-secondary btn-sm btn-icon-only" title="Edit Buku">
                                <i data-feather="edit-2" style="width: 16px; height: 16px; color: var(--primary);"></i>
                            </a>
                            <form action="{{ route('buku.destroy', $item->id_buku) }}" method="POST" style="display:inline;" onsubmit="return confirm('Apakah Anda yakin ingin menghapus buku ini?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-secondary btn-sm btn-icon-only" style="background: var(--danger-light); border-color: rgba(239, 68, 68, 0.2);" title="Hapus Buku">
                                    <i data-feather="trash-2" style="width: 16px; height: 16px; color: var(--danger);"></i>
                                </button>
                            </form>
                        </div>
                    </td>
                    @endif
                </tr>
                @empty
                <tr>
                    <td colspan="6" style="text-align: center; padding: 3rem 1rem;">
                        <div style="color: var(--text-muted);">
                            <i data-feather="book-open" style="width: 44px; height: 44px; margin-bottom: 0.5rem; stroke-width: 1.5;"></i>
                            <p style="font-weight: 500;">Data buku tidak ditemukan.</p>
                        </div>
                    </td>
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
