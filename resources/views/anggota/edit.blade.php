@extends('layouts.app')

@section('title', 'Edit Anggota')

@section('container_style', 'style="max-width: 650px;"')

@section('content')
<div class="page-header animate-fade-in" style="margin-bottom: 1.5rem;">
    <div style="display: flex; align-items: center; gap: 12px;">
        <a href="{{ route('anggota.index') }}" class="btn btn-secondary btn-icon-only" title="Kembali">
            <i data-feather="arrow-left" style="width: 18px; height: 18px;"></i>
        </a>
        <div>
            <h1>Edit Data Anggota</h1>
            <p style="margin: 0;">Perbarui rincian informasi anggota perpustakaan</p>
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
    <form action="{{ route('anggota.update', $anggota->id_anggota) }}" method="POST">
        @csrf
        @method('PUT')
        
        <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1rem;">
            <div class="form-group">
                <label class="form-label" for="id_anggota">ID Anggota (Readonly)</label>
                <input type="text" class="form-control" id="id_anggota" name="id_anggota" value="{{ $anggota->id_anggota }}" readonly style="background-color: var(--bg-color); color: var(--text-muted); font-family: monospace; font-weight: 700;">
            </div>

            <div class="form-group">
                <label class="form-label" for="kelas">Kelas / Tingkat</label>
                <input type="text" class="form-control" id="kelas" name="kelas" value="{{ old('kelas', $anggota->kelas) }}" required>
            </div>
        </div>

        <div class="form-group">
            <label class="form-label" for="nama_anggota">Nama Lengkap Anggota</label>
            <input type="text" class="form-control" id="nama_anggota" name="nama_anggota" value="{{ old('nama_anggota', $anggota->nama_anggota) }}" required>
        </div>

        <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1rem;">
            <div class="form-group">
                <label class="form-label" for="tempatlahir">Tempat Lahir</label>
                <input type="text" class="form-control" id="tempatlahir" name="tempatlahir" value="{{ old('tempatlahir', $anggota->tempatlahir) }}" required>
            </div>
            
            <div class="form-group">
                <label class="form-label" for="tgllahir">Tanggal Lahir</label>
                <input type="date" class="form-control" id="tgllahir" name="tgllahir" value="{{ old('tgllahir', $anggota->tgllahir) }}" required>
            </div>
        </div>

        <div style="margin-top: 2rem; display: flex; gap: 1rem;">
            <button type="submit" class="btn btn-primary" style="flex: 1; padding: 0.8rem;">
                <i data-feather="check"></i> Simpan Perubahan
            </button>
            <a href="{{ route('anggota.index') }}" class="btn btn-secondary" style="padding: 0.8rem 1.5rem;">
                Batal
            </a>
        </div>
    </form>
</div>
@endsection
