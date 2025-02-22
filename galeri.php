<?php
require './assets/header_user.php';
require './Database/config.php';

// Ambil semua data galeri dari database
$queryGaleri = "SELECT * FROM galeri ORDER BY created_at DESC";
$resultGaleri = mysqli_query($conn, $queryGaleri);
?>

<!-- Hero Section -->
<header class="hero-section text-white text-center position-relative">
    <img src="./assets/hero-bg.jpg" class="img-fluid hero-bg" alt="Galeri Dusun">
    <div class="hero-overlay"></div>
    <div class="hero-content">
        <h1>Galeri Dusun Puluhan</h1>
        <p>Dokumentasi foto dan video kegiatan dusun.</p>
    </div>
</header>

<div class="container mt-5">
    <h2 class="text-center mb-4">Galeri Terbaru</h2>

    <div class="row">
        <?php while ($row = mysqli_fetch_assoc($resultGaleri)): 
            $file_url = "./" . $row['file_path']; // Path yang benar dari database
        ?>
            <div class="col-lg-4 col-md-6 mb-4">
                <div class="card shadow-sm">
                    <div class="media-container">
                        <?php if (!empty($row['file_path']) && file_exists($row['file_path'])): ?>
                            <?php if ($row['tipe'] == 'foto'): ?>
                                <img src="<?php echo $file_url; ?>" 
                                     class="media-content" alt="<?php echo htmlspecialchars($row['judul']); ?>">
                            <?php elseif ($row['tipe'] == 'video'): ?>
                                <video class="media-content" controls>
                                    <source src="<?php echo $file_url; ?>" type="video/mp4">
                                    Browser Anda tidak mendukung tag video.
                                </video>
                            <?php endif; ?>
                        <?php else: ?>
                            <p class="text-danger text-center">File tidak ditemukan</p>
                        <?php endif; ?>
                    </div>
                    <div class="card-body">
                        <h5 class="card-title"><?php echo htmlspecialchars($row['judul']); ?></h5>
                        <p class="text-muted"><i class="far fa-clock"></i> <?php echo $row['created_at']; ?></p>
                    </div>
                </div>
            </div>
        <?php endwhile; ?>
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
    
    /* === Membuat Gambar & Video Seragam dengan Ratio 16:9 === */
    .media-container {
        position: relative;
        width: 100%;
        padding-top: 56.25%; /* 16:9 aspect ratio */
        overflow: hidden;
        background: #000;
    }
    .media-content {
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        object-fit: cover;
    }
    
    .card {
        transition: 0.3s;
    }
    .card:hover {
        transform: scale(1.05);
    }
</style>
</body>
</html>
