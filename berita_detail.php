<?php
require './assets/header_user.php';
require './Database/config.php';

// Pastikan koneksi ke database berhasil
if (!$conn) {
    die("Koneksi ke database gagal: " . mysqli_connect_error());
}

// Pastikan parameter ID berita tersedia
if (!isset($_GET['id']) || empty($_GET['id'])) {
    header("Location: berita.php");
    exit();
}

$berita_id = mysqli_real_escape_string($conn, $_GET['id']);

// Ambil data berita berdasarkan ID
$queryBerita = "SELECT * FROM berita WHERE id = '$berita_id'";
$resultBerita = mysqli_query($conn, $queryBerita);

// Cek apakah berita ditemukan
if (!$resultBerita || mysqli_num_rows($resultBerita) == 0) {
    header("Location: berita.php");
    exit();
}

$berita = mysqli_fetch_assoc($resultBerita);
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo htmlspecialchars($berita['judul']); ?></title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
    <style>
        .news-image {
            width: 100%;
            height: auto;
            max-height: 400px;
            object-fit: cover;
            border-radius: 8px;
        }
        .news-container {
            max-width: 800px;
            margin: auto;
            padding: 20px;
        }
    </style>
</head>
<body>

<div class="container news-container">
    <h1 class="fw-bold text-center"><?php echo htmlspecialchars($berita['judul']); ?></h1>
    <p class="text-muted text-center">
        <i class="far fa-user"></i> <?php echo htmlspecialchars($berita['created_by']); ?> | 
        <i class="far fa-clock"></i> <?php echo date("d-m-Y H:i", strtotime($berita['created_at'])); ?>
    </p>

    <!-- Perbaikan path gambar -->
    <?php 
    $gambar_path = !empty($berita['gambar']) ? "./uploads/" . $berita['gambar'] : "../assets/no-image.jpg"; 
    ?>
    <div class="text-center">
        <img src="<?php echo $gambar_path; ?>" alt="<?php echo htmlspecialchars($berita['judul']); ?>" class="news-image">
    </div>

    <p class="mt-4"><?php echo nl2br(htmlspecialchars($berita['isi'])); ?></p>

    <a href="berita.php" class="btn btn-primary mt-3"><i class="fas fa-arrow-left"></i> Kembali ke Berita</a>
</div>

<footer class="bg-dark text-white text-center py-4 mt-5">
    <p class="mb-0">&copy; 2025 Dusun Puluhan. Semua Hak Cipta Dilindungi.</p>
</footer>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>

<?php mysqli_close($conn); ?>
