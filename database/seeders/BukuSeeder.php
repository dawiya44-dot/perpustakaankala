<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class BukuSeeder extends Seeder
{
    /**
     * Seed data buku dari dump database PDF.
     * - Menggunakan updateOrInsert berdasarkan judul_buku agar tidak ada duplikat.
     * - ID buku di-generate otomatis secara berurutan mulai dari angka tertinggi yang ada.
     * - ISBN tidak disertakan (tidak ada kolom isbn di tabel).
     * - penerbit dikosongkan (null) karena tidak ada di data PDF.
     * - jumlah default 2 eksemplar per buku.
     */
    public function run(): void
    {
        $books = [
            ['judul_buku' => 'Belajar SQL',                                        'pengarang' => 'John Doe',                      'tahun_terbit' => 2023, 'kategori' => 'Nonfiksi'],
            ['judul_buku' => 'Belajar 101',                                         'pengarang' => 'John Doe',                      'tahun_terbit' => 2022, 'kategori' => 'Nonfiksi'],
            ['judul_buku' => 'SQL Lanjutan',                                        'pengarang' => 'John Doe',                      'tahun_terbit' => 2024, 'kategori' => 'Nonfiksi'],
            ['judul_buku' => 'Jejak Senja',                                         'pengarang' => 'Aulia Rahman',                  'tahun_terbit' => 2010, 'kategori' => 'Fiksi'],
            ['judul_buku' => 'Langit Tanpa Batas',                                  'pengarang' => 'Dewi Lestari',                  'tahun_terbit' => 2011, 'kategori' => 'Fiksi'],
            ['judul_buku' => 'Hujan di Bulan Juni',                                 'pengarang' => 'Sapardi Djoko Damono',          'tahun_terbit' => 1994, 'kategori' => 'Fiksi'],
            ['judul_buku' => 'Pulang',                                              'pengarang' => 'Tere Liye',                     'tahun_terbit' => 2015, 'kategori' => 'Fiksi'],
            ['judul_buku' => 'Pergi',                                               'pengarang' => 'Tere Liye',                     'tahun_terbit' => 2018, 'kategori' => 'Fiksi'],
            ['judul_buku' => 'Bumi',                                                'pengarang' => 'Tere Liye',                     'tahun_terbit' => 2014, 'kategori' => 'Fiksi'],
            ['judul_buku' => 'Bulan',                                               'pengarang' => 'Tere Liye',                     'tahun_terbit' => 2015, 'kategori' => 'Fiksi'],
            ['judul_buku' => 'Matahari',                                            'pengarang' => 'Tere Liye',                     'tahun_terbit' => 2016, 'kategori' => 'Fiksi'],
            ['judul_buku' => 'Bintang',                                             'pengarang' => 'Tere Liye',                     'tahun_terbit' => 2017, 'kategori' => 'Fiksi'],
            ['judul_buku' => 'Ceros dan Batozar',                                   'pengarang' => 'Tere Liye',                     'tahun_terbit' => 2018, 'kategori' => 'Fiksi'],
            ['judul_buku' => 'Laskar Pelangi',                                      'pengarang' => 'Andrea Hirata',                 'tahun_terbit' => 2005, 'kategori' => 'Fiksi'],
            ['judul_buku' => 'Sang Pemimpi',                                        'pengarang' => 'Andrea Hirata',                 'tahun_terbit' => 2006, 'kategori' => 'Fiksi'],
            ['judul_buku' => 'Edensor',                                             'pengarang' => 'Andrea Hirata',                 'tahun_terbit' => 2007, 'kategori' => 'Fiksi'],
            ['judul_buku' => 'Maryamah Karpov',                                     'pengarang' => 'Andrea Hirata',                 'tahun_terbit' => 2008, 'kategori' => 'Fiksi'],
            ['judul_buku' => 'Ayat-Ayat Cinta',                                     'pengarang' => 'Habiburrahman El Shirazy',      'tahun_terbit' => 2004, 'kategori' => 'Fiksi'],
            ['judul_buku' => 'Ketika Cinta Bertasbih',                              'pengarang' => 'Habiburrahman El Shirazy',      'tahun_terbit' => 2007, 'kategori' => 'Fiksi'],
            ['judul_buku' => 'Negeri 5 Menara',                                     'pengarang' => 'Ahmad Fuadi',                   'tahun_terbit' => 2009, 'kategori' => 'Fiksi'],
            ['judul_buku' => 'Ranah 3 Warna',                                       'pengarang' => 'Ahmad Fuadi',                   'tahun_terbit' => 2011, 'kategori' => 'Fiksi'],
            ['judul_buku' => 'Rantau 1 Muara',                                      'pengarang' => 'Ahmad Fuadi',                   'tahun_terbit' => 2013, 'kategori' => 'Fiksi'],
            ['judul_buku' => 'Perahu Kertas',                                       'pengarang' => 'Dewi Lestari',                  'tahun_terbit' => 2009, 'kategori' => 'Fiksi'],
            ['judul_buku' => 'Supernova',                                           'pengarang' => 'Dewi Lestari',                  'tahun_terbit' => 2001, 'kategori' => 'Fiksi'],
            ['judul_buku' => 'Filosofi Kopi',                                       'pengarang' => 'Dewi Lestari',                  'tahun_terbit' => 2006, 'kategori' => 'Fiksi'],
            ['judul_buku' => 'Critical Eleven',                                     'pengarang' => 'Ika Natassa',                   'tahun_terbit' => 2015, 'kategori' => 'Fiksi'],
            ['judul_buku' => 'Antologi Rasa',                                       'pengarang' => 'Ika Natassa',                   'tahun_terbit' => 2011, 'kategori' => 'Fiksi'],
            ['judul_buku' => 'Rectoverso',                                          'pengarang' => 'Dewi Lestari',                  'tahun_terbit' => 2008, 'kategori' => 'Fiksi'],
            ['judul_buku' => 'Dilan 1990',                                          'pengarang' => 'Pidi Baiq',                     'tahun_terbit' => 2014, 'kategori' => 'Fiksi'],
            ['judul_buku' => 'Dilan 1991',                                          'pengarang' => 'Pidi Baiq',                     'tahun_terbit' => 2015, 'kategori' => 'Fiksi'],
            ['judul_buku' => 'Milea',                                               'pengarang' => 'Pidi Baiq',                     'tahun_terbit' => 2016, 'kategori' => 'Fiksi'],
            ['judul_buku' => 'Orang-Orang Biasa',                                   'pengarang' => 'Andrea Hirata',                 'tahun_terbit' => 2019, 'kategori' => 'Fiksi'],
            ['judul_buku' => 'Garis Waktu',                                         'pengarang' => 'Fiersa Besari',                 'tahun_terbit' => 2016, 'kategori' => 'Fiksi'],
            ['judul_buku' => 'Konspirasi Alam Semesta',                             'pengarang' => 'Fiersa Besari',                 'tahun_terbit' => 2017, 'kategori' => 'Fiksi'],
            ['judul_buku' => 'Catatan Juang',                                       'pengarang' => 'Fiersa Besari',                 'tahun_terbit' => 2018, 'kategori' => 'Nonfiksi'],
            ['judul_buku' => 'Rindu',                                               'pengarang' => 'Tere Liye',                     'tahun_terbit' => 2014, 'kategori' => 'Fiksi'],
            ['judul_buku' => 'Daun yang Jatuh Tak Pernah Membenci Angin',           'pengarang' => 'Tere Liye',                     'tahun_terbit' => 2010, 'kategori' => 'Fiksi'],
            ['judul_buku' => 'Sepotong Hati yang Baru',                             'pengarang' => 'Tere Liye',                     'tahun_terbit' => 2012, 'kategori' => 'Fiksi'],
            ['judul_buku' => 'Sunset Bersama Rosie',                                'pengarang' => 'Tere Liye',                     'tahun_terbit' => 2011, 'kategori' => 'Fiksi'],
            ['judul_buku' => 'Tentang Kamu',                                        'pengarang' => 'Tere Liye',                     'tahun_terbit' => 2016, 'kategori' => 'Fiksi'],
            ['judul_buku' => 'Janji',                                               'pengarang' => 'Tere Liye',                     'tahun_terbit' => 2021, 'kategori' => 'Fiksi'],
            ['judul_buku' => 'Laut Bercerita',                                      'pengarang' => 'Leila S. Chudori',              'tahun_terbit' => 2017, 'kategori' => 'Fiksi'],
            ['judul_buku' => 'Pulang Pergi',                                        'pengarang' => 'Tere Liye',                     'tahun_terbit' => 2022, 'kategori' => 'Fiksi'],
            ['judul_buku' => 'Cantik Itu Luka',                                     'pengarang' => 'Eka Kurniawan',                 'tahun_terbit' => 2002, 'kategori' => 'Fiksi'],
            ['judul_buku' => 'Lelaki Harimau',                                      'pengarang' => 'Eka Kurniawan',                 'tahun_terbit' => 2004, 'kategori' => 'Fiksi'],
            ['judul_buku' => 'Perempuan yang Menangis kepada Bulan Hitam',          'pengarang' => 'Eka Kurniawan',                 'tahun_terbit' => 2019, 'kategori' => 'Fiksi'],
            ['judul_buku' => 'Saman',                                               'pengarang' => 'Ayu Utami',                     'tahun_terbit' => 1998, 'kategori' => 'Fiksi'],
            ['judul_buku' => 'Larung',                                              'pengarang' => 'Ayu Utami',                     'tahun_terbit' => 2001, 'kategori' => 'Fiksi'],
            ['judul_buku' => 'Dari Dalam Kubur',                                    'pengarang' => 'Soe Hok Gie',                   'tahun_terbit' => 1983, 'kategori' => 'Nonfiksi'],
            ['judul_buku' => 'Catatan Seorang Demonstran',                          'pengarang' => 'Soe Hok Gie',                   'tahun_terbit' => 1982, 'kategori' => 'Nonfiksi'],
            ['judul_buku' => 'Bumi Manusia',                                        'pengarang' => 'Pramoedya Ananta Toer',         'tahun_terbit' => 1980, 'kategori' => 'Fiksi'],
            ['judul_buku' => 'Anak Semua Bangsa',                                   'pengarang' => 'Pramoedya Ananta Toer',         'tahun_terbit' => 1981, 'kategori' => 'Fiksi'],
            ['judul_buku' => 'Jejak Langkah',                                       'pengarang' => 'Pramoedya Ananta Toer',         'tahun_terbit' => 1985, 'kategori' => 'Fiksi'],
            ['judul_buku' => 'Rumah Kaca',                                          'pengarang' => 'Pramoedya Ananta Toer',         'tahun_terbit' => 1988, 'kategori' => 'Fiksi'],
            ['judul_buku' => 'Orang-Orang Proyek',                                  'pengarang' => 'Ahmad Tohari',                  'tahun_terbit' => 2001, 'kategori' => 'Fiksi'],
            ['judul_buku' => 'Ronggeng Dukuh Paruk',                                'pengarang' => 'Ahmad Tohari',                  'tahun_terbit' => 1982, 'kategori' => 'Fiksi'],
            ['judul_buku' => 'Bekisar Merah',                                       'pengarang' => 'Ahmad Tohari',                  'tahun_terbit' => 1993, 'kategori' => 'Fiksi'],
            ['judul_buku' => 'Kubah',                                               'pengarang' => 'Ahmad Tohari',                  'tahun_terbit' => 1980, 'kategori' => 'Fiksi'],
            ['judul_buku' => 'Sirkus Pohon',                                        'pengarang' => 'Andrea Hirata',                 'tahun_terbit' => 2017, 'kategori' => 'Fiksi'],
            ['judul_buku' => 'Guru Aini',                                           'pengarang' => 'Andrea Hirata',                 'tahun_terbit' => 2020, 'kategori' => 'Fiksi'],
            ['judul_buku' => 'Sebelas Patriot',                                     'pengarang' => 'Andrea Hirata',                 'tahun_terbit' => 2011, 'kategori' => 'Fiksi'],
            ['judul_buku' => 'Ayah',                                                'pengarang' => 'Andrea Hirata',                 'tahun_terbit' => 2015, 'kategori' => 'Fiksi'],
            ['judul_buku' => 'Ibu',                                                 'pengarang' => 'Andrea Hirata',                 'tahun_terbit' => 2018, 'kategori' => 'Fiksi'],
            ['judul_buku' => 'Hujan',                                               'pengarang' => 'Tere Liye',                     'tahun_terbit' => 2016, 'kategori' => 'Fiksi'],
            ['judul_buku' => 'Selamat Tinggal',                                     'pengarang' => 'Tere Liye',                     'tahun_terbit' => 2020, 'kategori' => 'Fiksi'],
            ['judul_buku' => 'Komet',                                               'pengarang' => 'Tere Liye',                     'tahun_terbit' => 2018, 'kategori' => 'Fiksi'],
            ['judul_buku' => 'Komet Minor',                                         'pengarang' => 'Tere Liye',                     'tahun_terbit' => 2019, 'kategori' => 'Fiksi'],
            ['judul_buku' => 'Nebula',                                              'pengarang' => 'Tere Liye',                     'tahun_terbit' => 2020, 'kategori' => 'Fiksi'],
            ['judul_buku' => 'Si Anak Cahaya',                                      'pengarang' => 'Tere Liye',                     'tahun_terbit' => 2021, 'kategori' => 'Fiksi'],
            ['judul_buku' => 'Si Anak Spesial',                                     'pengarang' => 'Tere Liye',                     'tahun_terbit' => 2019, 'kategori' => 'Fiksi'],
            ['judul_buku' => 'Si Anak Kuat',                                        'pengarang' => 'Tere Liye',                     'tahun_terbit' => 2018, 'kategori' => 'Fiksi'],
            ['judul_buku' => 'Si Anak Pintar',                                      'pengarang' => 'Tere Liye',                     'tahun_terbit' => 2017, 'kategori' => 'Fiksi'],
            ['judul_buku' => 'Si Anak Badai',                                       'pengarang' => 'Tere Liye',                     'tahun_terbit' => 2020, 'kategori' => 'Fiksi'],
            ['judul_buku' => 'Senja di Mata Ibu',                                   'pengarang' => 'Aisyah Putri',                  'tahun_terbit' => 2012, 'kategori' => 'Fiksi'],
            ['judul_buku' => 'Pagi yang Tak Pernah Sama',                           'pengarang' => 'Nadya Prameswari',              'tahun_terbit' => 2013, 'kategori' => 'Fiksi'],
            ['judul_buku' => 'Ruang Rindu',                                         'pengarang' => 'Alfina Zahra',                  'tahun_terbit' => 2014, 'kategori' => 'Fiksi'],
            ['judul_buku' => 'Langkah Kecil',                                       'pengarang' => 'Rizky Maulana',                 'tahun_terbit' => 2015, 'kategori' => 'Fiksi'],
            ['judul_buku' => 'Cerita Tentang Kita',                                 'pengarang' => 'Putri Amalia',                  'tahun_terbit' => 2016, 'kategori' => 'Fiksi'],
            ['judul_buku' => 'Waktu yang Hilang',                                   'pengarang' => 'Dimas Pratama',                 'tahun_terbit' => 2017, 'kategori' => 'Fiksi'],
            ['judul_buku' => 'Kisah di Balik Hujan',                                'pengarang' => 'Fajar Nugroho',                 'tahun_terbit' => 2018, 'kategori' => 'Fiksi'],
            ['judul_buku' => 'Hening di Tengah Riuh',                               'pengarang' => 'Salma Nabila',                  'tahun_terbit' => 2019, 'kategori' => 'Fiksi'],
            ['judul_buku' => 'Menyapa Pagi',                                        'pengarang' => 'Arif Hidayat',                  'tahun_terbit' => 2020, 'kategori' => 'Fiksi'],
            ['judul_buku' => 'Langit Biru Itu',                                     'pengarang' => 'Nanda Syahputra',               'tahun_terbit' => 2021, 'kategori' => 'Fiksi'],
            ['judul_buku' => 'Jejak Asa',                                           'pengarang' => 'Rahmawati',                     'tahun_terbit' => 2022, 'kategori' => 'Fiksi'],
            ['judul_buku' => 'Doa dalam Diam',                                      'pengarang' => 'Hana Safitri',                  'tahun_terbit' => 2023, 'kategori' => 'Fiksi'],
            ['judul_buku' => 'Peluk Sunyi',                                         'pengarang' => 'Maya Lestari',                  'tahun_terbit' => 2024, 'kategori' => 'Fiksi'],
            ['judul_buku' => 'Harap yang Pulang',                                   'pengarang' => 'Raka Aditya',                   'tahun_terbit' => 2024, 'kategori' => 'Fiksi'],
            ['judul_buku' => 'Cerita Tengah Malam',                                 'pengarang' => 'Novi Andriani',                 'tahun_terbit' => 2023, 'kategori' => 'Fiksi'],
            ['judul_buku' => 'Langkah Terakhir',                                    'pengarang' => 'Bima Sakti',                    'tahun_terbit' => 2022, 'kategori' => 'Fiksi'],
            ['judul_buku' => 'Bersama Waktu',                                       'pengarang' => 'Ari Wibowo',                    'tahun_terbit' => 2021, 'kategori' => 'Fiksi'],
            ['judul_buku' => 'Tak Pernah Sendiri',                                  'pengarang' => 'Indah Permata',                 'tahun_terbit' => 2020, 'kategori' => 'Fiksi'],
            ['judul_buku' => 'Sisa Rasa',                                           'pengarang' => 'Reno Prakoso',                  'tahun_terbit' => 2019, 'kategori' => 'Fiksi'],
            ['judul_buku' => 'Jejak Kenangan',                                      'pengarang' => 'Salsa Putri',                   'tahun_terbit' => 2018, 'kategori' => 'Fiksi'],
            ['judul_buku' => 'Mimpi yang Tertunda',                                 'pengarang' => 'Fahri Ramadhan',                'tahun_terbit' => 2017, 'kategori' => 'Fiksi'],
            ['judul_buku' => 'Dalam Diam',                                          'pengarang' => 'Nisa Khairunnisa',              'tahun_terbit' => 2016, 'kategori' => 'Fiksi'],
            ['judul_buku' => 'Pelangi Setelah Hujan',                               'pengarang' => 'Yusuf Hakim',                   'tahun_terbit' => 2015, 'kategori' => 'Fiksi'],
            ['judul_buku' => 'Satu Hari Lagi',                                      'pengarang' => 'Kevin Surya',                   'tahun_terbit' => 2014, 'kategori' => 'Fiksi'],
            ['judul_buku' => 'Ruang Hati',                                          'pengarang' => 'Zahra Aulia',                   'tahun_terbit' => 2013, 'kategori' => 'Fiksi'],
            ['judul_buku' => 'Kala Senja Datang',                                   'pengarang' => 'Ilham Pratama',                 'tahun_terbit' => 2012, 'kategori' => 'Fiksi'],
            ['judul_buku' => 'Sepucuk Harap',                                       'pengarang' => 'Mega Puspita',                  'tahun_terbit' => 2011, 'kategori' => 'Fiksi'],
            ['judul_buku' => 'Dalam Waktu',                                         'pengarang' => 'Randi Kurniawan',               'tahun_terbit' => 2010, 'kategori' => 'Fiksi'],
            ['judul_buku' => 'Jejak Langkah Kita',                                  'pengarang' => 'Putra Mahendra',                'tahun_terbit' => 2009, 'kategori' => 'Fiksi'],
            ['judul_buku' => 'Cerita yang Usai',                                    'pengarang' => 'Lina Marcellina',               'tahun_terbit' => 2008, 'kategori' => 'Fiksi'],
            ['judul_buku' => 'Metanoia',                                            'pengarang' => 'Murasaki',                      'tahun_terbit' => 2017, 'kategori' => 'Fiksi'],
        ];

        // Get the last existing id_buku to generate new IDs sequentially
        $lastBuku = DB::table('buku')->orderByRaw("CAST(SUBSTRING(id_buku, 2) AS UNSIGNED) DESC")->first();
        $lastNum = $lastBuku ? (int) preg_replace('/[^0-9]/', '', $lastBuku->id_buku) : 0;

        $added = 0;
        $skipped = 0;

        foreach ($books as $book) {
            // Check if book already exists (by judul_buku)
            $exists = DB::table('buku')
                ->where('judul_buku', $book['judul_buku'])
                ->exists();

            if ($exists) {
                $skipped++;
                continue;
            }

            $lastNum++;
            $id_buku = 'b' . str_pad($lastNum, 3, '0', STR_PAD_LEFT);

            DB::table('buku')->insert([
                'id_buku'      => $id_buku,
                'judul_buku'   => $book['judul_buku'],
                'pengarang'    => $book['pengarang'],
                'penerbit'     => '',
                'tahun_terbit' => $book['tahun_terbit'],
                'jumlah'       => 2,
                'kategori'     => $book['kategori'],
                'created_at'   => now(),
                'updated_at'   => now(),
            ]);

            // Auto-generate 2 physical copies in detail_buku
            for ($i = 1; $i <= 2; $i++) {
                $no_buku = $id_buku . '_' . str_pad($i, 2, '0', STR_PAD_LEFT);
                DB::table('detail_buku')->insertOrIgnore([
                    'no_buku'    => $no_buku,
                    'id_buku'    => $id_buku,
                    'status'     => 'ada',
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            }

            $added++;
        }

        $this->command->info("BukuSeeder selesai: {$added} buku ditambahkan, {$skipped} dilewati (sudah ada).");
    }
}
