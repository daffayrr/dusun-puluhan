<?php
//require './Database/config.php'; // Koneksi database
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dusun Puluhan</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
    <style>
        .navbar {
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }
    </style>
</head>
<body>

<!-- Navbar -->
<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
    <div class="container">
        <a class="navbar-brand" href="index.php"><i class="fas fa-home"></i> Dusun Puluhan</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav ms-auto">
                <li class="nav-item"><a class="nav-link" href="./index.php"><i class="fas fa-home"></i> Beranda</a></li>
                <li class="nav-item"><a class="nav-link" href="./informasi.php"><i class="fas fa-info-circle"></i> Informasi</a></li>
                <li class="nav-item"><a class="nav-link" href="./berita.php"><i class="fas fa-newspaper"></i> Berita</a></li>
                <li class="nav-item"><a class="nav-link" href="./galeri.php"><i class="fas fa-images"></i> Galeri</a></li>
                <li class="nav-item"><a class="nav-link" href="./layanan.php"><i class="fas fa-concierge-bell"></i> Layanan</a></li>
                <li class="nav-item"><a class="nav-link" href="./kontak.php"><i class="fas fa-envelope"></i> Kontak</a></li>
            </ul>
        </div>
    </div>
</nav>
