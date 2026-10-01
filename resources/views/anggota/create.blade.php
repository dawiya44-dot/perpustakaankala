@extends('layouts.app')

@section('title', 'Tambah Anggota')

@section('container_style', 'style="max-width: 650px;"')

@section('content')
<div class="page-header animate-fade-in" style="margin-bottom: 1.5rem;">
    <div style="display: flex; align-items: center; gap: 12px;">
        <a href="{{ route('anggota.index') }}" class="btn btn-secondary btn-icon-only" title="Kembali">
            <i data-feather="arrow-left" style="width: 18px; height: 18px;"></i>
        </a>
        <div>
            <h1>Tambah Anggota Baru</h1>
            <p style="margin: 0;">Isi rincian informasi data anggota perpustakaan</p>
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
    <form action="{{ route('anggota.store') }}" method="POST">
        @csrf
        
        <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1rem;">
            <div class="form-group">
                <label class="form-label" for="id_anggota">ID Anggota (Kode Unik)</label>
                <input type="text" class="form-control" id="id_anggota" name="id_anggota" value="{{ old('id_anggota', $next_id) }}" placeholder="Contoh: a0004" required autofocus>
            </div>

            <div class="form-group">
                <label class="form-label" for="kelas">Kelas / Tingkat</label>
                <input type="text" class="form-control" id="kelas" name="kelas" value="{{ old('kelas') }}" placeholder="Contoh: X RPL 1" required>
            </div>
        </div>

        <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1rem;">
            <div class="form-group">
                <label class="form-label" for="nama_anggota">Nama Lengkap Anggota</label>
                <input type="text" class="form-control" id="nama_anggota" name="nama_anggota" value="{{ old('nama_anggota') }}" placeholder="Masukkan nama lengkap" required>
            </div>

            <div class="form-group">
                <label class="form-label" for="no_wa">No. WhatsApp / HP</label>
                <input type="text" class="form-control" id="no_wa" name="no_wa" value="{{ old('no_wa') }}" placeholder="Contoh: 08123456789">
            </div>
        </div>

        <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1rem;">
            <div class="form-group">
                <label class="form-label" for="tempatlahir">Tempat Lahir</label>
                <input type="text" class="form-control" id="tempatlahir" name="tempatlahir" value="{{ old('tempatlahir') }}" placeholder="Kota tempat lahir" required>
            </div>
            
            <div class="form-group">
                <label class="form-label" for="tgllahir">Tanggal Lahir</label>
                <input type="date" class="form-control" id="tgllahir" name="tgllahir" value="{{ old('tgllahir', '2008-01-01') }}" required>
            </div>
        </div>

        <div style="margin-top: 2rem; display: flex; gap: 1rem;">
            <button type="submit" class="btn btn-primary" style="flex: 1; padding: 0.8rem;">
                <i data-feather="save"></i> Simpan Data Anggota
            </button>
            <a href="{{ route('anggota.index') }}" class="btn btn-secondary" style="padding: 0.8rem 1.5rem;">
                Batal
            </a>
        </div>
    </form>
</div>
@endsection
