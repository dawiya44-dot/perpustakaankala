@extends('layouts.app')

@section('title', 'Dashboard')

@section('content')
<div class="page-header">
    <h1>Selamat Datang di KalaPustaka</h1>
    <p>Sistem Informasi Manajemen Perpustakaan Terpadu</p>
</div>

<div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(250px, 1fr)); gap: 1.5rem; margin-bottom: 2rem;">
    <div class="card" style="text-align: center;">
        <div style="color: var(--primary); margin-bottom: 1rem;"><i data-feather="book" style="width: 40px; height: 40px;"></i></div>
        <h3>{{ $total_buku }}</h3>
        <p class="text-muted">Total Fisik Buku</p>
    </div>
    <div class="card" style="text-align: center;">
        <div style="color: var(--secondary); margin-bottom: 1rem;"><i data-feather="users" style="width: 40px; height: 40px;"></i></div>
        <h3>{{ $total_anggota }}</h3>
        <p class="text-muted">Total Anggota</p>
    </div>
    <div class="card" style="text-align: center;">
        <div style="color: #f59e0b; margin-bottom: 1rem;"><i data-feather="bookmark" style="width: 40px; height: 40px;"></i></div>
        <h3>{{ $total_dipinjam }}</h3>
        <p class="text-muted">Buku Dipinjam</p>
    </div>
</div>

<div class="card">
    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 1.5rem; flex-wrap: wrap; gap: 10px;">
        <h2>Peminjaman Terbaru</h2>
        <div>
            @if(auth()->user()->role === 'admin')
            <a href="{{ route('laporan.index') }}" class="btn" style="background: var(--bg-color); border: 1px solid var(--border); margin-right: 10px;"><i data-feather="printer"></i> Cetak Laporan</a>
            @endif
            <a href="{{ route('peminjaman.create') }}" class="btn btn-primary"><i data-feather="plus"></i> Pinjam Buku</a>
        </div>
    </div>
    
    <div class="table-container">
        <table class="table">
            <thead>
                <tr>
                    <th>ID Pinjam</th>
                    <th>Tanggal</th>
                    <th>Nama Anggota</th>
                    <th>Judul Buku</th>
                    <th>No Fisik</th>
                    <th>Status</th>
                </tr>
            </thead>
            <tbody>
                @forelse($peminjaman_terbaru as $pinjam)
                <tr>
                    <td><strong>{{ $pinjam->id_pinjam }}</strong></td>
                    <td>{{ \Carbon\Carbon::parse($pinjam->tgl_pinjam)->format('d M Y, H:i') }}</td>
                    <td>{{ $pinjam->anggota->nama_anggota }}</td>
                    <td>{{ $pinjam->detailBuku->buku->judul_buku }}</td>
                    <td>{{ $pinjam->no_buku }}</td>
                    <td>
                        @if($pinjam->status == '1')
                            <span class="badge badge-warning">Dipinjam</span>
                        @else
                            <span class="badge badge-success">Selesai</span>
                        @endif
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="6" style="text-align: center; color: var(--text-muted);">Belum ada data peminjaman</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
