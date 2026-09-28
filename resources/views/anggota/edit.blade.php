@extends('layouts.app')

@section('title', 'Edit Anggota')

@section('container_style', 'style="max-width: 600px;"')

@section('content')
<div class="page-header">
    <h1>Edit Data Anggota</h1>
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
    <form action="{{ route('anggota.update', $anggota->id_anggota) }}" method="POST">
        @csrf
        @method('PUT')
        
        <div class="form-group">
            <label class="form-label" for="id_anggota">ID Anggota</label>
            <input type="text" class="form-control" id="id_anggota" name="id_anggota" value="{{ $anggota->id_anggota }}" readonly style="background-color: #e5e7eb;">
        </div>

        <div class="form-group">
            <label class="form-label" for="nama_anggota">Nama Lengkap</label>
            <input type="text" class="form-control" id="nama_anggota" name="nama_anggota" value="{{ old('nama_anggota', $anggota->nama_anggota) }}" required>
        </div>

        <div class="form-group">
            <label class="form-label" for="kelas">Kelas</label>
            <input type="text" class="form-control" id="kelas" name="kelas" value="{{ old('kelas', $anggota->kelas) }}" required>
        </div>
        
        <div class="form-group">
            <label class="form-label" for="tempatlahir">Tempat Lahir</label>
            <input type="text" class="form-control" id="tempatlahir" name="tempatlahir" value="{{ old('tempatlahir', $anggota->tempatlahir) }}" required>
        </div>
        
        <div class="form-group">
            <label class="form-label" for="tgllahir">Tanggal Lahir</label>
            <input type="date" class="form-control" id="tgllahir" name="tgllahir" value="{{ old('tgllahir', $anggota->tgllahir) }}" required>
        </div>

        <div style="margin-top: 2rem; display: flex; gap: 1rem;">
            <button type="submit" class="btn btn-primary" style="flex: 1;">
                <i data-feather="save"></i> Update Data
            </button>
            <a href="{{ route('anggota.index') }}" class="btn" style="flex: 1; border: 1px solid var(--border); background: var(--bg-color);">
                Batal
            </a>
        </div>
    </form>
</div>
@endsection
