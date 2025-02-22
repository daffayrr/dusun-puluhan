<?php
require './assets/header_user.php'; 
require './Database/config.php';

// Pastikan koneksi ke database berhasil
if (!$conn) {
    die("Koneksi ke database gagal: " . mysqli_connect_error());
}

// Ambil berita dari database
$queryBerita = "SELECT * FROM berita ORDER BY created_at DESC";
$resultBerita = mysqli_query($conn, $queryBerita);
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Berita - Dusun Puluhan</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css">
    <style>
        .news-img {
            width: 100%;
            height: 200px;
            object-fit: cover;
            border-radius: 8px;
        }
    </style>
</head>
<body>

<div class="container mt-5">
    <h2 class="text-center fw-bold mb-4">Berita Terbaru</h2>
    <div class="row">
        <?php while ($row = mysqli_fetch_assoc($resultBerita)): ?>
            <div class="col-md-4 mb-4">
                <div class="card shadow-sm">
                    <img src="<?php echo './uploads/' . $row['gambar']; ?>" class="news-img" alt="<?php echo htmlspecialchars($row['judul']); ?>">
                    <div class="card-body">
                        <h5 class="card-title"> <?php echo htmlspecialchars($row['judul']); ?> </h5>
                        <p class="text-muted"><i class="far fa-clock"></i> <?php echo $row['created_at']; ?> | <i class="fas fa-user"></i> <?php echo htmlspecialchars($row['created_by']); ?></p>
                        <p class="card-text"> <?php echo substr(strip_tags($row['isi']), 0, 100) . '...'; ?> </p>
                        <a href="berita_detail.php?id=<?php echo $row['id']; ?>" class="btn btn-primary btn-sm">Baca Selengkapnya</a>
                    </div>
                </div>
            </div>
        <?php endwhile; ?>
    </div>
</div>

<footer class="bg-dark text-white text-center py-4 mt-5">
    <p class="mb-0">&copy; 2025 Dusun Puluhan. Semua Hak Cipta Dilindungi.</p>
</footer>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
