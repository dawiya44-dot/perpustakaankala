<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Seed Admin User
        DB::table('users')->updateOrInsert(
            ['email' => 'admin@kalapustaka.com'],
            [
                'name' => 'Administrator',
                'password' => Hash::make('password'),
                'role' => 'admin',
                'updated_at' => now(),
                'created_at' => now(),
            ]
        );

        // Seed Regular User
        DB::table('users')->updateOrInsert(
            ['email' => 'user@kalapustaka.com'],
            [
                'name' => 'User Siswa',
                'password' => Hash::make('password'),
                'role' => 'user',
                'updated_at' => now(),
                'created_at' => now(),
            ]
        );

        // Seed Anggota
        DB::table('anggota')->updateOrInsert(
            ['id_anggota' => 'a0001'],
            ['nama_anggota' => 'Budi Santoso', 'kelas' => 'X RPL 1', 'tempatlahir' => 'Jakarta', 'tgllahir' => '2008-05-15']
        );
        DB::table('anggota')->updateOrInsert(
            ['id_anggota' => 'a0002'],
            ['nama_anggota' => 'Siti Aminah', 'kelas' => 'XI TKJ 2', 'tempatlahir' => 'Bandung', 'tgllahir' => '2007-12-20']
        );
        DB::table('anggota')->updateOrInsert(
            ['id_anggota' => 'a0003'],
            ['nama_anggota' => 'Andi Wijaya', 'kelas' => 'XII RPL', 'tempatlahir' => 'Surabaya', 'tgllahir' => '2006-08-10']
        );

        // Seed Buku
        DB::table('buku')->updateOrInsert(
            ['id_buku' => 'b001'],
            ['judul_buku' => 'Pemrograman Dasar', 'pengarang' => 'Eko Kurniawan', 'penerbit' => 'Informatika', 'tahun_terbit' => 2021, 'jumlah' => 4]
        );
        DB::table('buku')->updateOrInsert(
            ['id_buku' => 'b002'],
            ['judul_buku' => 'Jaringan Komputer', 'pengarang' => 'Onno W. Purbo', 'penerbit' => 'Andi Publisher', 'tahun_terbit' => 2020, 'jumlah' => 2]
        );

        // Seed Detail Buku
        DB::table('detail_buku')->updateOrInsert(['no_buku' => 'b001_01'], ['id_buku' => 'b001', 'status' => 'ada']);
        DB::table('detail_buku')->updateOrInsert(['no_buku' => 'b001_02'], ['id_buku' => 'b001', 'status' => 'ada']);
        DB::table('detail_buku')->updateOrInsert(['no_buku' => 'b001_03'], ['id_buku' => 'b001', 'status' => 'dipinjam']);
        DB::table('detail_buku')->updateOrInsert(['no_buku' => 'b001_04'], ['id_buku' => 'b001', 'status' => 'ada']);
        DB::table('detail_buku')->updateOrInsert(['no_buku' => 'b002_01'], ['id_buku' => 'b002', 'status' => 'ada']);
        DB::table('detail_buku')->updateOrInsert(['no_buku' => 'b002_02'], ['id_buku' => 'b002', 'status' => 'ada']);

        // Seed Peminjaman
        DB::table('peminjaman')->updateOrInsert(
            ['id_pinjam' => 'p0001'],
            ['tgl_pinjam' => '2026-09-28 08:53:14', 'id_anggota' => 'a0001', 'no_buku' => 'b001_03', 'status' => '1']
        );
    }
}
