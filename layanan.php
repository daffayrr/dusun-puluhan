<?php
require './assets/header_user.php';
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Layanan Dusun Puluhan</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
    <style>
        .card-layanan {
            transition: transform 0.3s ease-in-out;
            border-radius: 12px;
            text-align: center;
            padding: 20px;
        }
        .card-layanan:hover {
            transform: scale(1.05);
        }
        .icon-layanan {
            font-size: 50px;
            color: #007bff;
            margin-bottom: 10px;
        }
        .layanan-container {
            max-width: 900px;
            margin: auto;
            padding: 20px;
        }
    </style>
</head>
<body>

<div class="container layanan-container">
    <h1 class="text-center fw-bold my-4">Layanan Dusun Puluhan</h1>
    <p class="text-center text-muted">
        Silakan pilih layanan yang tersedia sesuai kebutuhan Anda. Kami menyediakan layanan pengaduan, administrasi surat-menyurat, dan akses data kependudukan.
    </p>
    </br>
    <div class="row g-4">
        <!-- Layanan Pengaduan -->
        <div class="col-md-4">
            <div class="card card-layanan shadow-sm">
                <div class="card-body">
                    <i class="fa-solid fa-exclamation-triangle icon-layanan"></i>
                    <h5 class="card-title fw-bold">Layanan Pengaduan</h5>
                    <p class="card-text">Laporkan permasalahan lingkungan atau kejadian yang membutuhkan perhatian.</p>
                </div>
            </div>
        </div>
        <!-- Layanan Administrasi -->
        <div class="col-md-4">
            <div class="card card-layanan shadow-sm">
                <div class="card-body">
                    <i class="fa-solid fa-file-alt icon-layanan"></i>
                    <h5 class="card-title fw-bold">Layanan Administrasi</h5>
                    <p class="card-text">Ajukan permohonan surat atau dokumen resmi dengan lebih mudah dan cepat.</p>
                </div>
            </div>
        </div>
        <!-- Layanan Data Penduduk -->
        <div class="col-md-4">
            <div class="card card-layanan shadow-sm">
                <div class="card-body">
                    <i class="fa-solid fa-users icon-layanan"></i>
                    <h5 class="card-title fw-bold">Layanan Data Penduduk</h5>
                    <p class="card-text">Akses dan Update data Warga secara Mandiri dan Aman.</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Tombol Masuk -->
    <div class="text-center mt-4">
        <a href="./warga/" class="btn btn-primary btn-lg">
            <i class="fas fa-arrow-right"></i> Masuk ke Layanan
        </a>
    </div>
</div>

<footer class="bg-dark text-white text-center py-4 mt-5">
    <p class="mb-0">&copy; 2025 Dusun Puluhan. Semua Hak Cipta Dilindungi.</p>
</footer>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
