<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        DB::table('users')->insert([
            ['name' => 'Administrator', 'email' => 'admin@kalapustaka.com', 'password' => bcrypt('password'), 'role' => 'admin'],
            ['name' => 'User Siswa', 'email' => 'user@kalapustaka.com', 'password' => bcrypt('password'), 'role' => 'user'],
        ]);


        DB::table('anggota')->insert([
            ['id_anggota' => 'a0001', 'nama_anggota' => 'Budi Santoso', 'kelas' => 'X RPL 1', 'tempatlahir' => 'Jakarta', 'tgllahir' => '2008-05-15'],
            ['id_anggota' => 'a0002', 'nama_anggota' => 'Siti Aminah', 'kelas' => 'XI TKJ 2', 'tempatlahir' => 'Bandung', 'tgllahir' => '2007-12-20'],
            ['id_anggota' => 'a0003', 'nama_anggota' => 'Andi Wijaya', 'kelas' => 'XII RPL', 'tempatlahir' => 'Surabaya', 'tgllahir' => '2006-08-10'],
        ]);

        DB::table('buku')->insert([
            ['id_buku' => 'b001', 'judul_buku' => 'Pemrograman Dasar', 'pengarang' => 'Eko Kurniawan', 'penerbit' => 'Informatika', 'tahun_terbit' => 2021, 'jumlah' => 38],
            ['id_buku' => 'b002', 'judul_buku' => 'Jaringan Komputer', 'pengarang' => 'Onno W. Purbo', 'penerbit' => 'Andi Publisher', 'tahun_terbit' => 2020, 'jumlah' => 15],
        ]);

        DB::table('detail_buku')->insert([
            ['no_buku' => 'b001_01', 'id_buku' => 'b001', 'status' => 'ada'],
            ['no_buku' => 'b001_02', 'id_buku' => 'b001', 'status' => 'ada'],
            ['no_buku' => 'b001_15', 'id_buku' => 'b001', 'status' => 'dipinjam'],
            ['no_buku' => 'b001_16', 'id_buku' => 'b001', 'status' => 'ada'],
            ['no_buku' => 'b002_01', 'id_buku' => 'b002', 'status' => 'ada'],
            ['no_buku' => 'b002_02', 'id_buku' => 'b002', 'status' => 'ada'],
        ]);

        DB::table('peminjaman')->insert([
            ['id_pinjam' => 'p0001', 'tgl_pinjam' => '2026-09-28 08:53:14', 'id_anggota' => 'a0001', 'no_buku' => 'b001_15', 'status' => '1'],
        ]);
    }
}
