@extends('layouts.app')

@section('title', 'Tambah Buku')

@section('container_style', 'style="max-width: 600px;"')

@section('content')
<div class="page-header">
    <h1>Tambah Buku Baru</h1>
</div>

@if ($errors->any())
    <div class="alert alert-error">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

<div class="card">
    <form action="{{ route('buku.store') }}" method="POST">
        @csrf
        <div class="form-group">
            <label class="form-label" for="id_buku">ID Buku</label>
            <input type="text" class="form-control" id="id_buku" name="id_buku" value="{{ old('id_buku') }}" required>
        </div>

        <div class="form-group">
            <label class="form-label" for="judul_buku">Judul Buku</label>
            <input type="text" class="form-control" id="judul_buku" name="judul_buku" value="{{ old('judul_buku') }}" required>
        </div>

        <div class="form-group">
            <label class="form-label" for="pengarang">Pengarang</label>
            <input type="text" class="form-control" id="pengarang" name="pengarang" value="{{ old('pengarang') }}" required>
        </div>
        
        <div class="form-group">
            <label class="form-label" for="penerbit">Penerbit</label>
            <input type="text" class="form-control" id="penerbit" name="penerbit" value="{{ old('penerbit') }}" required>
        </div>
        
        <div style="display: flex; gap: 1rem;">
            <div class="form-group" style="flex: 1;">
                <label class="form-label" for="tahun_terbit">Tahun Terbit</label>
                <input type="number" class="form-control" id="tahun_terbit" name="tahun_terbit" value="{{ old('tahun_terbit') }}" required>
            </div>
            
            <div class="form-group" style="flex: 1;">
                <label class="form-label" for="jumlah">Jumlah Stok</label>
                <input type="number" class="form-control" id="jumlah" name="jumlah" value="{{ old('jumlah') }}" required min="0">
            </div>
        </div>

        <div style="margin-top: 2rem;">
            <button type="submit" class="btn btn-primary" style="width: 100%;">
                <i data-feather="save"></i> Simpan Data Buku
            </button>
        </div>
    </form>
</div>
@endsection
