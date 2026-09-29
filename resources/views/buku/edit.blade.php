@extends('layouts.app')

@section('title', 'Edit Buku')

@section('container_style', 'style="max-width: 650px;"')

@section('content')
<div class="page-header animate-fade-in" style="margin-bottom: 1.5rem;">
    <div style="display: flex; align-items: center; gap: 12px;">
        <a href="{{ route('buku.index') }}" class="btn btn-secondary btn-icon-only" title="Kembali">
            <i data-feather="arrow-left" style="width: 18px; height: 18px;"></i>
        </a>
        <div>
            <h1>Edit Data Buku</h1>
            <p style="margin: 0;">Perbarui rincian informasi koleksi buku</p>
        </div>
    </div>
</div>

@if ($errors->any())
    <div class="alert alert-error animate-fade-in">
        <i data-feather="alert-triangle" style="width: 18px; height: 18px;"></i>
        <ul style="padding-left: 1rem; margin: 0;">
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

<div class="card animate-fade-in">
    <form action="{{ route('buku.update', $buku->id_buku) }}" method="POST">
        @csrf
        @method('PUT')
        
        <div class="form-group">
            <label class="form-label" for="id_buku">ID Buku (Tidak dapat diubah)</label>
            <input type="text" class="form-control" id="id_buku" name="id_buku" value="{{ $buku->id_buku }}" readonly style="background-color: var(--bg-color); color: var(--text-muted); font-family: monospace; font-weight: 700;">
        </div>

        <div class="form-group">
            <label class="form-label" for="judul_buku">Judul Buku</label>
            <input type="text" class="form-control" id="judul_buku" name="judul_buku" value="{{ old('judul_buku', $buku->judul_buku) }}" required>
        </div>

        <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1rem;">
            <div class="form-group">
                <label class="form-label" for="pengarang">Pengarang</label>
                <input type="text" class="form-control" id="pengarang" name="pengarang" value="{{ old('pengarang', $buku->pengarang) }}" required>
            </div>
            
            <div class="form-group">
                <label class="form-label" for="penerbit">Penerbit</label>
                <input type="text" class="form-control" id="penerbit" name="penerbit" value="{{ old('penerbit', $buku->penerbit) }}" required>
            </div>
        </div>
        
        <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1rem;">
            <div class="form-group">
                <label class="form-label" for="tahun_terbit">Tahun Terbit</label>
                <input type="number" class="form-control" id="tahun_terbit" name="tahun_terbit" value="{{ old('tahun_terbit', $buku->tahun_terbit) }}" required>
            </div>
            
            <div class="form-group">
                <label class="form-label" for="jumlah">Jumlah Stok (Exemplar)</label>
                <input type="number" class="form-control" id="jumlah" name="jumlah" value="{{ old('jumlah', $buku->jumlah) }}" required min="0">
            </div>
        </div>

        <div style="margin-top: 2rem; display: flex; gap: 1rem;">
            <button type="submit" class="btn btn-primary" style="flex: 1; padding: 0.8rem;">
                <i data-feather="check"></i> Simpan Perubahan
            </button>
            <a href="{{ route('buku.index') }}" class="btn btn-secondary" style="padding: 0.8rem 1.5rem;">
                Batal
            </a>
        </div>
    </form>
</div>
@endsection
