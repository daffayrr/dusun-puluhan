<?php
require './assets/header_user.php'; 
require './Database/config.php';

// Pastikan koneksi ke database berhasil
if (!$conn) {
    die("Koneksi ke database gagal: " . mysqli_connect_error());
}

// Ambil jumlah penduduk dengan validasi
$queryPenduduk = "SELECT COUNT(*) AS total_penduduk FROM penduduk";
$resultPenduduk = mysqli_query($conn, $queryPenduduk);
$total_penduduk = ($resultPenduduk && mysqli_num_rows($resultPenduduk) > 0) 
    ? mysqli_fetch_assoc($resultPenduduk)['total_penduduk'] 
    : 0;

// Ambil 3 galeri terbaru dengan validasi
$queryGaleri = "SELECT * FROM galeri ORDER BY created_at DESC LIMIT 3";
$resultGaleri = mysqli_query($conn, $queryGaleri);
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Beranda - Dusun Puluhan</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
    <style>
        .hero-section {
            position: relative;
            height: 450px;
            display: flex;
            justify-content: center;
            align-items: center;
            text-align: center;
            background: url('./assets/hero-bg.jpg') no-repeat center center/cover;
            color: white;
        }
        .hero-overlay {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.5);
        }
        .hero-content {
            position: relative;
            z-index: 2;
        }
        .card {
            min-height: 200px;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            text-align: center;
        }
        .card:hover {
            transform: scale(1.05);
            transition: 0.3s;

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

    </style>
</head>
<body>

<!-- Hero Section -->
<header class="hero-section">
    <div class="hero-overlay"></div>
    <div class="hero-content">
        <h1 class="fw-bold">Selamat Datang di Dusun Puluhan</h1>
        <p class="lead">Informasi terkini dan layanan terbaik untuk warga.</p>
        <a href="informasi.php" class="btn btn-lg btn-light mt-3 shadow-lg">
            <i class="fas fa-info-circle"></i> Lihat Informasi
        </a>
    </div>
</header>

<!-- Informasi Dusun -->
<section class="container mt-5">
    <div class="row text-center g-4">
        <div class="col-md-4">
            <div class="card shadow-lg p-4 border-0 rounded-lg">
                <i class="fas fa-users fa-3x text-primary"></i>
                <h3 class="mt-3">Jumlah Penduduk</h3>
                <p class="display-5 fw-bold text-dark"> <?php echo $total_penduduk; ?> Jiwa</p>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card shadow-lg p-4 border-0 rounded-lg">
                <i class="fas fa-hand-holding-heart fa-3x text-danger"></i>
                <h3 class="mt-3">Layanan</h3>
                <p class="text-muted">Pembuatan surat, administrasi, dan lainnya.</p>
                <a href="./admin/login.php" class="btn btn-primary">Ajukan Permohonan</a>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card shadow-lg p-4 border-0 rounded-lg">
                <i class="fas fa-newspaper fa-3x text-success"></i>
                <h3 class="mt-3">Berita Terbaru</h3>
                <p class="text-muted">Informasi terkini seputar dusun.</p>
                <a href="berita.php" class="btn btn-primary">Lihat Berita</a>
            </div>
        </div>
    </div>
</section>

<!-- Galeri Terbaru -->
<section class="container mt-5">
    <h2 class="text-center fw-bold mb-4">Galeri Terbaru</h2>
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
</section>

<!-- Footer -->
<footer class="bg-dark text-white text-center py-4 mt-5">
    <p class="mb-0">&copy; 2025 Dusun Puluhan. Semua Hak Cipta Dilindungi.</p>
    <div class="mt-2">
        <a href="#" class="text-white me-3"><i class="fab fa-facebook fa-lg"></i></a>
        <a href="#" class="text-white me-3"><i class="fab fa-instagram fa-lg"></i></a>
        <a href="#" class="text-white"><i class="fab fa-whatsapp fa-lg"></i></a>
    </div>
</footer>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
