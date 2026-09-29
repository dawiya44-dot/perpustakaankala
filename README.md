# 📚 KalaPustaka - Sistem Informasi Manajemen Perpustakaan Terpadu

**KalaPustaka** adalah aplikasi Sistem Informasi Perpustakaan berbasis web modern yang dibangun menggunakan framework **Laravel**. Aplikasi ini dirancang untuk mempermudah pengelolaan koleksi buku, data anggota, transaksi sirkulasi peminjaman & pengembalian buku, serta pembuatan laporan terperinci.

---

## ✨ Fitur Utama

1. **Autentikasi & Multi-Peran (2 Peran: Admin & User)**
   - **Admin (Petugas Perpustakaan)**: Memiliki akses penuh terhadap manajemen buku (CRUD), data anggota (CRUD), transaksi peminjaman & pengembalian buku, serta cetak laporan (PDF) dan ekspor laporan (Excel).
   - **User (Anggota / Siswa)**: Memiliki akses menjelajah katalog buku, mencari buku, melihat data anggota, dan melakukan pengajuan transaksi peminjaman.
2. **CRUD Lengkap Data Buku & Fisik Buku (`detail_buku`)**
   - Otomatis membuat nomor fisik eksemplar buku (`BK001_01`, `BK001_02`, dst.) saat buku baru ditambahkan.
3. **CRUD Lengkap Data Anggota**
   - Otomatis menghasilkan kode unik ID Anggota (`a0001`, `a0002`, dst.) dan mengelola biodata keanggotaan.
4. **Sirkulasi Peminjaman & Pengembalian Buku**
   - Pencatatan peminjaman secara *real-time* dan fitur *Kembalikan Buku* yang memulihkan stok fisik eksemplar secara otomatis.
5. **Pencarian (Search) & Pagination**
   - Fitur pencarian interaktif untuk Katalog Buku, Data Anggota, dan Transaksi.
   - Fitur *pagination* dinamis pada tabel data.
6. **Laporan Cetak & Ekspor (PDF & Excel)**
   - **Cetak Laporan PDF**: Layout khusus dokumen siap cetak langsung dari browser.
   - **Ekspor Excel (`.xlsx` / `.csv`)**: Mengunduh rekapitulasi laporan bulanan dalam format kompatibel Microsoft Excel.
7. **Keamanan Dasar**
   - Sandi di-hash menggunakan algoritma **Bcrypt**.
   - Bebas dari SQL Injection menggunakan Laravel Eloquent Prepared Statements.
   - Validasi input form yang ketat.
8. **Tampilan Responsif & Modern (Design System)**
   - Mengusung tema *Glassmorphism*, font Google *Plus Jakarta Sans*, *layered shadows*, dan *responsive layout* untuk perangkat HP/Tablet/Desktop.

---

## 🔑 Akun Demo (Demo Accounts)

Aplikasi telah dilengkapi *database seeder* dengan dua akun sampel siap pakai:

| Peran (Role) | Email | Password | Hak Akses |
| :--- | :--- | :--- | :--- |
| **Admin** | `admin@kalapustaka.com` | `password` | Akses Penuh (CRUD, Pengembalian, Laporan PDF & Excel) |
| **User (Siswa)** | `user@kalapustaka.com` | `password` | Akses Katalog, Anggota, & Peminjaman Buku |

> 💡 *Pengguna baru juga dapat melakukan pendaftaran akun dengan memilih peran Admin atau User pada halaman Registrasi.*

---

## 🗄️ Skema Database & ERD

Aplikasi ini menggunakan 5 tabel utama yang saling terelasi:
- **`users`**: `id`, `name`, `email`, `password`, `role` (`admin`/`user`), `timestamps`
- **`buku`**: `id_buku` (PK), `judul_buku`, `pengarang`, `penerbit`, `tahun_terbit`, `jumlah`, `timestamps`
- **`detail_buku`**: `no_buku` (PK), `id_buku` (FK -> `buku.id_buku`), `status` (`ada`/`dipinjam`), `timestamps`
- **`anggota`**: `id_anggota` (PK), `nama_anggota`, `kelas`, `tempatlahir`, `tgllahir`, `timestamps`
- **`peminjaman`**: `id_pinjam` (PK), `tgl_pinjam`, `id_anggota` (FK -> `anggota.id_anggota`), `no_buku` (FK -> `detail_buku.no_buku`), `status` (`1`=dipinjam, `0`=selesai), `timestamps`

---

## 🚀 Cara Instalasi & Menjalankan Aplikasi

1. **Clone Repository / Buka Direktori Proyek**
   ```bash
   cd c:\xampp\htdocs\KalaPustaka
   ```

2. **Instal Dependencies (Composer)**
   ```bash
   composer install
   ```

3. **Konfigurasi Environment (`.env`)**
   Pastikan pengatur basis data sesuai dengan konfigurasi XAMPP MySQL lokal Anda:
   ```env
   DB_CONNECTION=mysql
   DB_HOST=127.0.0.1
   DB_PORT=3306
   DB_DATABASE=kalapustaka
   DB_USERNAME=root
   DB_PASSWORD=
   ```

4. **Jalankan Migrasi Database & Seeder**
   ```bash
   php artisan migrate --seed
   ```

5. **Jalankan Server Lokal**
   ```bash
   php artisan serve
   ```
   Buka browser di: `http://127.0.0.1:8000` (atau via XAMPP `http://localhost/KalaPustaka/public`).

---

## 📄 Lisensi
Proyek ini dibuat untuk keperluan tugas akademik Sistem Informasi Perpustakaan KalaPustaka.
