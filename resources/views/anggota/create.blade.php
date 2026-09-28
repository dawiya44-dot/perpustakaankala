@extends('layouts.app')

@section('title', 'Tambah Anggota')

@section('container_style', 'style="max-width: 600px;"')

@section('content')
<div class="page-header">
    <h1>Tambah Anggota Baru</h1>
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
    <form action="{{ route('anggota.store') }}" method="POST">
        @csrf
        <div class="form-group">
            <label class="form-label" for="id_anggota">ID Anggota</label>
            <input type="text" class="form-control" id="id_anggota" name="id_anggota" value="{{ old('id_anggota') }}" required>
        </div>

        <div class="form-group">
            <label class="form-label" for="nama_anggota">Nama Lengkap</label>
            <input type="text" class="form-control" id="nama_anggota" name="nama_anggota" value="{{ old('nama_anggota') }}" required>
        </div>

        <div class="form-group">
            <label class="form-label" for="kelas">Kelas</label>
            <input type="text" class="form-control" id="kelas" name="kelas" value="{{ old('kelas') }}" required>
        </div>
        
        <div class="form-group">
            <label class="form-label" for="tempatlahir">Tempat Lahir</label>
            <input type="text" class="form-control" id="tempatlahir" name="tempatlahir" value="{{ old('tempatlahir') }}" required>
        </div>
        
        <div class="form-group">
            <label class="form-label" for="tgllahir">Tanggal Lahir</label>
            <input type="date" class="form-control" id="tgllahir" name="tgllahir" value="{{ old('tgllahir') }}" required>
        </div>

        <div style="margin-top: 2rem;">
            <button type="submit" class="btn btn-primary" style="width: 100%;">
                <i data-feather="save"></i> Simpan Data Anggota
            </button>
        </div>
    </form>
</div>
@endsection
