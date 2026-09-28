@extends('layouts.app')

@section('title', 'Input Peminjaman')

@section('container_style', 'style="max-width: 600px;"')

@section('content')
<div class="page-header">
    <h1>Input Peminjaman Buku</h1>
    <p>Formulir untuk mencatat transaksi peminjaman buku baru.</p>
</div>

@if (session('success'))
    <div class="alert alert-success">
        {{ session('success') }}
    </div>
@endif

@if (session('error'))
    <div class="alert alert-error">
        {{ session('error') }}
    </div>
@endif

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
    <form action="{{ route('peminjaman.store') }}" method="POST">
        @csrf
        <div class="form-group">
            <label class="form-label" for="id_pinjam">ID Peminjaman</label>
            <input type="text" class="form-control" id="id_pinjam" name="id_pinjam" value="{{ old('id_pinjam', $next_id) }}" readonly style="background-color: #e5e7eb; cursor: not-allowed;">
        </div>

        <div class="form-group">
            <label class="form-label" for="id_anggota">Anggota Peminjam</label>
            <select class="form-control" id="id_anggota" name="id_anggota" required>
                <option value="">-- Pilih Anggota --</option>
                @foreach($anggota as $a)
                    <option value="{{ $a->id_anggota }}" {{ old('id_anggota') == $a->id_anggota ? 'selected' : '' }}>
                        {{ $a->id_anggota }} - {{ $a->nama_anggota }}
                    </option>
                @endforeach
            </select>
        </div>

        <div class="form-group">
            <label class="form-label" for="no_buku">Buku yang Dipinjam</label>
            <select class="form-control" id="no_buku" name="no_buku" required>
                <option value="">-- Pilih Buku --</option>
                @foreach($buku as $b)
                    <option value="{{ $b->no_buku }}" {{ old('no_buku') == $b->no_buku ? 'selected' : '' }}>
                        {{ $b->no_buku }} - {{ $b->buku->judul_buku }}
                    </option>
                @endforeach
            </select>
        </div>

        <div style="margin-top: 2rem;">
            <button type="submit" class="btn btn-primary" style="width: 100%;">
                <i data-feather="save"></i> Simpan Peminjaman
            </button>
        </div>
    </form>
</div>
@endsection
