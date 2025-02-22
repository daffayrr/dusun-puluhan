<?php
require './assets/header_user.php';
require './Database/config.php';

// Ambil semua pengumuman dari database
$queryInformasi = "SELECT * FROM informasi ORDER BY tanggal_kegiatan DESC";
$resultInformasi = mysqli_query($conn, $queryInformasi);

// Jika ada parameter `id`, ambil detail pengumuman
$informasiDetail = null;
if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $queryDetail = "SELECT * FROM informasi WHERE id = $id";
    $resultDetail = mysqli_query($conn, $queryDetail);
    $informasiDetail = mysqli_fetch_assoc($resultDetail);
}
?>

<!-- Hero Section -->
<header class="hero-section text-white text-center position-relative">
    <img src="./assets/hero-bg.jpg" class="img-fluid hero-bg" alt="Informasi Dusun">
    <div class="hero-overlay"></div>
    <div class="hero-content">
        <h1>Informasi & Pengumuman</h1> 
        <p>Berita dan informasi terbaru untuk warga Dusun Puluhan.</p>
    </div>
</header>

<div class="container mt-5">
    <div class="row">
        <!-- Bagian Daftar Pengumuman -->
        <div class="col-md-6">
            <h2 class="mb-4">Pengumuman Terbaru</h2>
            <ul class="list-group">
                <?php while ($row = mysqli_fetch_assoc($resultInformasi)): ?>
                    <li class="list-group-item">
                        <a href="informasi.php?id=<?php echo $row['id']; ?>" class="text-dark">
                            <h5 class="mb-1"><?php echo $row['judul']; ?></h5>
                            <p class="text-muted"><i class="far fa-clock"></i> <?php echo $row['tanggal_kegiatan']; ?></p>
                        </a>
                    </li>
                <?php endwhile; ?>
            </ul>
        </div>

        <!-- Bagian Detail Pengumuman -->
        <div class="col-md-6">
            <?php if ($informasiDetail): ?>
                <div class="card shadow-lg p-4">
                    <h2><?php echo $informasiDetail['judul']; ?></h2>
                    <p class="text-muted"><i class="far fa-clock"></i> <?php echo $informasiDetail['tanggal_kegiatan']; ?></p>
                    <p><?php echo nl2br($informasiDetail['isi']); ?></p>
                    <a href="informasi.php" class="btn btn-secondary"><i class="fas fa-arrow-left"></i> Kembali</a>
                </div>
            <?php else: ?>
                <div class="alert alert-info">
                    <h4>Silakan pilih pengumuman untuk melihat detail.</h4>
                </div>
            <?php endif; ?>
        </div>
    </div>
</div>

<!-- Footer -->
<footer class="bg-dark text-white text-center py-3 mt-5">
    <p>&copy; 2025 Dusun Puluhan. Semua Hak Cipta Dilindungi.</p>
</footer>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
<style>
    .hero-section {
        position: relative;
        height: 300px;
        display: flex;
        justify-content: center;
        align-items: center;
        text-align: center;
    }
    .hero-bg {
        width: 100%;
        height: 300px;
        object-fit: cover;
        filter: brightness(50%);
        position: absolute;
        top: 0;
        left: 0;
        z-index: -1;
    }
    .hero-content {
        position: relative;
        z-index: 2;
    }
    .list-group-item:hover {
        background: #f8f9fa;
        transition: 0.3s;
    }
</style>
</body>
</html>
