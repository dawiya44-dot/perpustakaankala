@extends('layouts.app')

@section('title', 'Daftar Buku')

@section('content')
<style>
.kp-pagination{display:flex!important;list-style:none!important;padding:0!important;margin:0!important;gap:4px;flex-wrap:wrap;align-items:center;justify-content:center}
.kp-pagination li{display:inline-flex!important;list-style:none!important}
.kp-pagination li::before,.kp-pagination li::marker{display:none!important;content:none!important}
.kp-pagination a,.kp-pagination span{display:inline-flex;align-items:center;justify-content:center;min-width:36px;height:36px;padding:0 10px;border-radius:8px;border:1px solid #e2e8f0;background:#fff;color:#334155;font-size:.875rem;font-weight:500;text-decoration:none;font-family:inherit;transition:all .15s;cursor:pointer}
.kp-pagination a:hover{background:#eef2ff;border-color:#6366f1;color:#6366f1}
.kp-pagination .active span{background:linear-gradient(135deg,#6366f1,#4f46e5)!important;border-color:#6366f1!important;color:#fff!important;font-weight:700!important;box-shadow:0 2px 8px rgba(99,102,241,.35)}
.kp-pagination .disabled span{background:#f8fafc;color:#94a3b8;cursor:default;opacity:.6}
.pengarang-nama{font-weight:600;color:#0f172a;white-space:nowrap;overflow:hidden;text-overflow:ellipsis;display:block;max-width:170px}
.penerbit-nama{font-size:.825rem;color:#64748b;display:flex;align-items:center;gap:4px;margin-top:2px;white-space:nowrap;overflow:hidden;text-overflow:ellipsis;max-width:170px}
</style>
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
        <form action="{{ route('buku.index') }}" method="GET" class="search-form" style="display: flex; gap: 0.5rem; flex-grow: 1; max-width: 450px;" autocomplete="off">
            <div style="position: relative; flex: 1;">
                <input type="text" name="search" class="form-control" placeholder="Cari Judul, Pengarang, atau ID..." value="{{ request('search') }}" style="padding-left: 2.5rem;" autocomplete="off">
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
        <table class="table table-mobile-cards">
            <thead>
                <tr>
                    <th style="width: 90px;">ID Buku</th>
                    <th>Judul Buku</th>
                    <th style="width: 190px;">Pengarang & Penerbit</th>
                    <th style="width: 90px;">Tahun</th>
                    <th style="width: 100px;">Kategori</th>
                    <th style="width: 110px;">Jumlah Stok</th>
                    @if(auth()->user()->role === 'admin')
                    <th style="width: 130px; text-align: center;">Aksi</th>
                    @endif
                </tr>
            </thead>
            <tbody>
                @forelse($buku as $item)
                <tr>
                    <td data-label="ID Buku">
                        <span style="font-weight: 700; color: var(--primary); font-family: monospace; font-size: 0.95rem;">
                            {{ $item->id_buku }}
                        </span>
                    </td>
                    <td data-label="Judul Buku">
                        <div style="display: flex; align-items: center; gap: 10px;">
                            <div style="width: 34px; height: 34px; border-radius: 8px; background: var(--primary-light); color: var(--primary); display: flex; align-items: center; justify-content: center; flex-shrink: 0;">
                                <i data-feather="book" style="width: 18px; height: 18px;"></i>
                            </div>
                            <span style="font-weight: 700; color: var(--text-dark); font-size: 0.95rem;">
                                {{ $item->judul_buku }}
                            </span>
                        </div>
                    </td>
                    <td data-label="Pengarang" class="col-pengarang" style="max-width: 190px;">
                        <div style="overflow: hidden; max-width: 100%;">
                            <span class="pengarang-nama" title="{{ $item->pengarang }}">{{ $item->pengarang }}</span>
                            @if($item->penerbit)
                            <div class="penerbit-nama" title="{{ $item->penerbit }}">
                                <i data-feather="printer" style="width: 12px; height: 12px; flex-shrink: 0;"></i>
                                <span style="overflow: hidden; text-overflow: ellipsis; white-space: nowrap;">{{ $item->penerbit }}</span>
                            </div>
                            @else
                            <div style="font-size: 0.825rem; color: var(--text-muted); margin-top: 2px; font-style: italic;">—</div>
                            @endif
                        </div>
                    </td>
                    <td data-label="Tahun">
                        <span class="badge" style="background: var(--bg-color); color: var(--text-body); border: 1px solid var(--border);">
                            {{ $item->tahun_terbit }}
                        </span>
                    </td>
                    <td data-label="Kategori">
                        @if($item->kategori)
                            <span class="badge" style="background: {{ $item->kategori === 'Fiksi' ? '#fef3c7' : '#dbeafe' }}; color: {{ $item->kategori === 'Fiksi' ? '#92400e' : '#1e40af' }}; border: 1px solid {{ $item->kategori === 'Fiksi' ? '#fde68a' : '#bfdbfe' }}; font-weight: 600; font-size: 0.78rem;">
                                {{ $item->kategori }}
                            </span>
                        @else
                            <span style="color: var(--text-muted); font-size: 0.85rem;">—</span>
                        @endif
                    </td>
                    <td data-label="Stok">
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
                    <td class="td-action">
                        <div style="display: flex; justify-content: center; gap: 6px;">
                            <a href="{{ route('buku.edit', $item->id_buku) }}" class="btn btn-secondary btn-sm btn-icon-only" title="Edit Buku" aria-label="Edit buku {{ $item->judul_buku }}">
                                <i data-feather="edit-2" style="width: 16px; height: 16px; color: var(--primary);"></i>
                            </a>
                            <form action="{{ route('buku.destroy', $item->id_buku) }}" method="POST" style="display:inline;" onsubmit="return confirm('Hapus buku {{ addslashes($item->judul_buku) }}?\n\nData buku dan seluruh eksemplar fisiknya akan dihapus permanen.');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-secondary btn-sm btn-icon-only" style="background: var(--danger-light); border-color: rgba(239, 68, 68, 0.2);" title="Hapus Buku" aria-label="Hapus buku {{ $item->judul_buku }}">
                                    <i data-feather="trash-2" style="width: 16px; height: 16px; color: var(--danger);"></i>
                                </button>
                            </form>
                        </div>
                    </td>
                    @endif
                </tr>
                @empty
                <tr>
                    <td colspan="7" style="text-align: center; padding: 3rem 1rem; border-bottom: none;">
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
    
    {{-- Pagination --}}
    @if ($buku->hasPages())
    <div style="margin-top:1.5rem; display:flex; justify-content:center;">
        <ul class="kp-pagination">
            {{-- Prev --}}
            @if ($buku->onFirstPage())
                <li class="disabled"><span>&laquo;</span></li>
            @else
                <li><a href="{{ $buku->previousPageUrl() }}">&laquo;</a></li>
            @endif

            {{-- Pages --}}
            @foreach ($buku->getUrlRange(1, $buku->lastPage()) as $page => $url)
                @if ($page == $buku->currentPage())
                    <li class="active"><span>{{ $page }}</span></li>
                @else
                    <li><a href="{{ $url }}">{{ $page }}</a></li>
                @endif
            @endforeach

            {{-- Next --}}
            @if ($buku->hasMorePages())
                <li><a href="{{ $buku->nextPageUrl() }}">&raquo;</a></li>
            @else
                <li class="disabled"><span>&raquo;</span></li>
            @endif
        </ul>
    </div>
    @endif
</div>
@endsection
