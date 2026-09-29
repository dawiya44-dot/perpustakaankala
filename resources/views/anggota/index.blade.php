@extends('layouts.app')

@section('title', 'Daftar Anggota')

@section('content')
<div class="page-header animate-fade-in">
    <div class="page-header-content">
        <div>
            <h1>Data Anggota Perpustakaan</h1>
            <p>Kelola seluruh direktori keanggotaan KalaPustaka</p>
        </div>
        @if(auth()->user()->role === 'admin')
        <div>
            <a href="{{ route('anggota.create') }}" class="btn btn-primary">
                <i data-feather="user-plus"></i> Tambah Anggota Baru
            </a>
        </div>
        @endif
    </div>
</div>

<div class="card animate-fade-in">
    <!-- Filter and Search Bar -->
    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 1.5rem; flex-wrap: wrap; gap: 1rem;">
        <form action="{{ route('anggota.index') }}" method="GET" style="display: flex; gap: 0.5rem; flex-grow: 1; max-width: 450px;">
            <div style="position: relative; flex: 1;">
                <input type="text" name="search" class="form-control" placeholder="Cari ID atau Nama Anggota..." value="{{ request('search') }}" style="padding-left: 2.5rem;">
                <i data-feather="search" style="position: absolute; left: 0.85rem; top: 50%; transform: translateY(-50%); width: 18px; height: 18px; color: var(--text-muted);"></i>
            </div>
            <button type="submit" class="btn btn-primary">Cari</button>
            @if(request('search'))
            <a href="{{ route('anggota.index') }}" class="btn btn-secondary" title="Reset Search">
                <i data-feather="x"></i>
            </a>
            @endif
        </form>
    </div>
    
    <div class="table-container">
        <table class="table">
            <thead>
                <tr>
                    <th style="width: 140px;">ID Anggota</th>
                    <th>Nama Anggota</th>
                    <th style="width: 120px;">Kelas</th>
                    <th>Tempat & Tgl Lahir</th>
                    @if(auth()->user()->role === 'admin')
                    <th style="width: 130px; text-align: center;">Aksi</th>
                    @endif
                </tr>
            </thead>
            <tbody>
                @forelse($anggota as $item)
                <tr>
                    <td>
                        <span style="font-weight: 700; color: var(--primary); font-family: monospace; font-size: 0.95rem;">
                            {{ $item->id_anggota }}
                        </span>
                    </td>
                    <td>
                        <div style="display: flex; align-items: center; gap: 10px;">
                            <div style="width: 34px; height: 34px; border-radius: 50%; background: var(--secondary-light); color: var(--secondary); font-weight: 700; font-size: 0.85rem; display: flex; align-items: center; justify-content: center; flex-shrink: 0;">
                                {{ strtoupper(substr($item->nama_anggota, 0, 1)) }}
                            </div>
                            <span style="font-weight: 700; color: var(--text-dark); font-size: 0.95rem;">
                                {{ $item->nama_anggota }}
                            </span>
                        </div>
                    </td>
                    <td>
                        <span class="badge badge-info">
                            <i data-feather="bookmark" style="width: 12px; height: 12px;"></i> {{ $item->kelas }}
                        </span>
                    </td>
                    <td style="color: var(--text-body);">
                        <div style="display: flex; align-items: center; gap: 6px;">
                            <i data-feather="map-pin" style="width: 14px; height: 14px; color: var(--text-muted);"></i>
                            <span>{{ $item->tempatlahir }}, {{ \Carbon\Carbon::parse($item->tgllahir)->format('d M Y') }}</span>
                        </div>
                    </td>
                    @if(auth()->user()->role === 'admin')
                    <td style="text-align: center;">
                        <div style="display: flex; justify-content: center; gap: 6px;">
                            <a href="{{ route('anggota.edit', $item->id_anggota) }}" class="btn btn-secondary btn-sm btn-icon-only" title="Edit Anggota">
                                <i data-feather="edit-2" style="width: 16px; height: 16px; color: var(--primary);"></i>
                            </a>
                            <form action="{{ route('anggota.destroy', $item->id_anggota) }}" method="POST" style="display:inline;" onsubmit="return confirm('Apakah Anda yakin ingin menghapus data anggota ini?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-secondary btn-sm btn-icon-only" style="background: var(--danger-light); border-color: rgba(239, 68, 68, 0.2);" title="Hapus Anggota">
                                    <i data-feather="trash-2" style="width: 16px; height: 16px; color: var(--danger);"></i>
                                </button>
                            </form>
                        </div>
                    </td>
                    @endif
                </tr>
                @empty
                <tr>
                    <td colspan="5" style="text-align: center; padding: 3rem 1rem;">
                        <div style="color: var(--text-muted);">
                            <i data-feather="users" style="width: 44px; height: 44px; margin-bottom: 0.5rem; stroke-width: 1.5;"></i>
                            <p style="font-weight: 500;">Data anggota tidak ditemukan.</p>
                        </div>
                    </td>
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
