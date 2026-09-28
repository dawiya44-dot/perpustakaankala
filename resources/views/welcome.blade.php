<?php
require_once 'config.php';

// Mengambil 5 data peminjaman terbaru untuk ditampilkan di tabel dashboard
$query_pinjam = "SELECT p.id_pinjam, p.tgl_pinjam, a.nama_anggota, b.judul_buku, p.no_buku, p.status
                 FROM peminjaman p
                 JOIN anggota a ON p.id_anggota = a.id_anggota
                 JOIN detail_buku db ON p.no_buku = db.no_buku
                 JOIN buku b ON db.id_buku = b.id_buku
                 ORDER BY p.tgl_pinjam DESC LIMIT 5";
$result_pinjam = $conn->query($query_pinjam);

// Menghitung statistik untuk ditampilkan di kartu (cards)
$q_buku = $conn->query("SELECT COUNT(*) as total FROM detail_buku");
$total_buku = $q_buku->fetch_assoc()['total'];

$q_anggota = $conn->query("SELECT COUNT(*) as total FROM anggota");
$total_anggota = $q_anggota->fetch_assoc()['total'];

$q_dipinjam = $conn->query("SELECT COUNT(*) as total FROM detail_buku WHERE status = 'dipinjam'");
$total_dipinjam = $q_dipinjam->fetch_assoc()['total'];

?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard - KalaPustaka</title>
    <!-- Memanggil file CSS yang mengatur warna soft dan desain -->
    <link rel="stylesheet" href="assets/style.css">
    <!-- Icon keren dari Feather Icons -->
    <script src="https://unpkg.com/feather-icons"></script>
</head>
<body>
    <!-- Navbar Atas -->
    <nav class="navbar">
        <a href="index.php" class="navbar-brand">
            <i data-feather="book-open"></i> KalaPustaka
        </a>
        <ul class="nav-links">
            <li><a href="index.php" class="active">Dashboard</a></li>
            <li><a href="peminjaman.php">Peminjaman Baru</a></li>
        </ul>
    </nav>

    <!-- Konten Utama -->
    <div class="container">
        <div class="page-header">
            <h1>Selamat Datang di KalaPustaka</h1>
            <p>Sistem Informasi Manajemen Perpustakaan Terpadu</p>
        </div>

        <!-- Kartu Statistik -->
        <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(250px, 1fr)); gap: 1.5rem; margin-bottom: 2rem;">
            <div class="card" style="text-align: center;">
                <div style="color: var(--primary); margin-bottom: 1rem;"><i data-feather="book" style="width: 40px; height: 40px;"></i></div>
                <h3><?php echo $total_buku; ?></h3>
                <p class="text-muted">Total Fisik Buku</p>
            </div>
            <div class="card" style="text-align: center;">
                <div style="color: var(--secondary); margin-bottom: 1rem;"><i data-feather="users" style="width: 40px; height: 40px;"></i></div>
                <h3><?php echo $total_anggota; ?></h3>
                <p class="text-muted">Total Anggota</p>
            </div>
            <div class="card" style="text-align: center;">
                <div style="color: #f59e0b; margin-bottom: 1rem;"><i data-feather="bookmark" style="width: 40px; height: 40px;"></i></div>
                <h3><?php echo $total_dipinjam; ?></h3>
                <p class="text-muted">Buku Dipinjam</p>
            </div>
        </div>

        <!-- Tabel Peminjaman Terbaru -->
        <div class="card">
            <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 1.5rem;">
                <h2>Peminjaman Terbaru</h2>
                <a href="peminjaman.php" class="btn btn-primary"><i data-feather="plus"></i> Pinjam Buku</a>
            </div>

            <div class="table-container">
                <table class="table">
                    <thead>
                        <tr>
                            <th>ID Pinjam</th>
                            <th>Tanggal</th>
                            <th>Nama Anggota</th>
                            <th>Judul Buku</th>
                            <th>No Fisik</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if ($result_pinjam && $result_pinjam->num_rows > 0): ?>
                            <?php while($row = $result_pinjam->fetch_assoc()): ?>
                            <tr>
                                <td><strong><?php echo htmlspecialchars($row['id_pinjam']); ?></strong></td>
                                <td><?php echo date('d M Y, H:i', strtotime($row['tgl_pinjam'])); ?></td>
                                <td><?php echo htmlspecialchars($row['nama_anggota']); ?></td>
                                <td><?php echo htmlspecialchars($row['judul_buku']); ?></td>
                                <td><?php echo htmlspecialchars($row['no_buku']); ?></td>
                                <td>
                                    <?php if($row['status'] == '1'): ?>
                                        <span class="badge badge-warning">Dipinjam</span>
                                    <?php else: ?>
                                        <span class="badge badge-success">Selesai</span>
                                    <?php endif; ?>
                                </td>
                            </tr>
                            <?php endwhile; ?>
                        <?php else: ?>
                            <tr>
                                <td colspan="6" style="text-align: center; color: var(--text-muted);">Belum ada data peminjaman</td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <footer>
        <p>&copy; 2026 KalaPustaka. All rights reserved.</p>
    </footer>

    <!-- Script untuk me-render icon -->
    <script>
        feather.replace();
    </script>
</body>
</html>
