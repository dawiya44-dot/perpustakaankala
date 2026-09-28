<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\PeminjamanController;
use App\Http\Controllers\AuthController;

// Auth Routes
Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('login.post');
Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
Route::post('/register', [AuthController::class, 'register'])->name('register.post');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// Protected Routes
Route::middleware(['auth'])->group(function () {
    Route::get('/', [DashboardController::class, 'index'])->name('dashboard');
    
    // Peminjaman
    Route::get('/peminjaman/baru', [PeminjamanController::class, 'create'])->name('peminjaman.create');
    Route::post('/peminjaman', [PeminjamanController::class, 'store'])->name('peminjaman.store');

    // Anggota (CRUD)
    Route::get('/anggota', [App\Http\Controllers\AnggotaController::class, 'index'])->name('anggota.index');
    Route::get('/anggota/create', [App\Http\Controllers\AnggotaController::class, 'create'])->name('anggota.create');
    Route::post('/anggota', [App\Http\Controllers\AnggotaController::class, 'store'])->name('anggota.store');
    Route::get('/anggota/{id}/edit', [App\Http\Controllers\AnggotaController::class, 'editById'])->name('anggota.edit');
    Route::put('/anggota/{id}', [App\Http\Controllers\AnggotaController::class, 'update'])->name('anggota.update');
    Route::delete('/anggota/{id}', [App\Http\Controllers\AnggotaController::class, 'destroy'])->name('anggota.destroy');

    // Buku (CRUD)
    Route::get('/buku', [App\Http\Controllers\BukuController::class, 'index'])->name('buku.index');
    Route::get('/buku/create', [App\Http\Controllers\BukuController::class, 'create'])->name('buku.create');
    Route::post('/buku', [App\Http\Controllers\BukuController::class, 'store'])->name('buku.store');
    Route::get('/buku/{id}/edit', [App\Http\Controllers\BukuController::class, 'editById'])->name('buku.edit');
    Route::put('/buku/{id}', [App\Http\Controllers\BukuController::class, 'update'])->name('buku.update');
    Route::delete('/buku/{id}', [App\Http\Controllers\BukuController::class, 'destroy'])->name('buku.destroy');

    // Laporan
    Route::get('/laporan', [App\Http\Controllers\DashboardController::class, 'laporan'])->name('laporan.index');
});
