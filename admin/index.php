<?php
require '../assets/auth.php';
require '../Database/config.php';

// Ambil jumlah penduduk dari tabel
$queryPenduduk = "SELECT COUNT(*) AS total_penduduk FROM penduduk"; 
$resultPenduduk = mysqli_query($conn, $queryPenduduk);
$rowPenduduk = mysqli_fetch_assoc($resultPenduduk);
$total_penduduk = $rowPenduduk['total_penduduk'];

// Ambil jumlah informasi tersedia
$queryInformasi = "SELECT COUNT(*) AS total_informasi FROM informasi";
$resultInformasi = mysqli_query($conn, $queryInformasi);
$rowInformasi = mysqli_fetch_assoc($resultInformasi);
$total_informasi = $rowInformasi['total_informasi'];

// Ambil jumlah laporan baru
$queryLaporan = "SELECT COUNT(*) AS total_laporan FROM pengaduan WHERE status = 'baru'";
$resultLaporan = mysqli_query($conn, $queryLaporan);
$rowLaporan = mysqli_fetch_assoc($resultLaporan);
$total_laporan = $rowLaporan['total_laporan'];

// Ambil jumlah permohonan surat
$queryPermohonan = "SELECT COUNT(*) AS total_permohonan FROM layanan_administrasi";
$resultPermohonan = mysqli_query($conn, $queryPermohonan);
$rowPermohonan = mysqli_fetch_assoc($resultPermohonan);
$total_permohonan = $rowPermohonan['total_permohonan'];

// Ambil jumlah user
$queryUser = "SELECT COUNT(*) AS total_user FROM users";
$resultUser = mysqli_query($conn, $queryUser);
$rowUser = mysqli_fetch_assoc($resultUser);
$total_user = $rowUser['total_user'];
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Admin</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/admin-lte@3.2/dist/css/adminlte.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/admin-lte@3.2/plugins/fontawesome-free/css/all.min.css">
</head>
<body class="hold-transition sidebar-mini layout-fixed">
<div class="wrapper">

    <!-- Navbar -->
    <?php include '../assets/header.php'; ?>

    <!-- Sidebar -->
    <?php include '../assets/sidebar.php'; ?>

    <!-- Content -->
    <div class="content-wrapper">
        <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1 class="m-0">Dashboard Admin</h1>
                    </div>
                </div>
            </div>
        </div>

        <section class="content">
            <div class="container-fluid">
                <div class="row">
                    <!-- Card Jumlah Penduduk -->
                    <div class="col-lg-3 col-6">
                        <div class="small-box bg-info">
                            <div class="inner">
                                <h3><?php echo $total_penduduk; ?></h3>
                                <p>Jumlah Penduduk</p>
                            </div>
                            <div class="icon">
                                <i class="fas fa-users"></i>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Card Jumlah Informasi -->
                    <div class="col-lg-3 col-6">
                        <div class="small-box bg-success">
                            <div class="inner">
                                <h3><?php echo $total_informasi; ?></h3>
                                <p>Jumlah Informasi Tersedia</p>
                            </div>
                            <div class="icon">
                                <i class="fas fa-info-circle"></i>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Card Jumlah Laporan Baru -->
                    <div class="col-lg-3 col-6">
                        <div class="small-box bg-warning">
                            <div class="inner">
                                <h3><?php echo $total_laporan; ?></h3>
                                <p>Jumlah Laporan Baru</p>
                            </div>
                            <div class="icon">
                                <i class="fas fa-exclamation-triangle"></i>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Card Jumlah Permohonan Surat -->
                    <div class="col-lg-3 col-6">
                        <div class="small-box bg-danger">
                            <div class="inner">
                                <h3><?php echo $total_permohonan; ?></h3>
                                <p>Jumlah Permohonan Surat</p>
                            </div>
                            <div class="icon">
                                <i class="fas fa-envelope"></i>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Card Jumlah User -->
                    <div class="col-lg-3 col-6">
                        <div class="small-box bg-primary">
                            <div class="inner">
                                <h3><?php echo $total_user; ?></h3>
                                <p>Jumlah User</p>
                            </div>
                            <div class="icon">
                                <i class="fas fa-user"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>

    <footer class="main-footer">
        <strong>Copyright &copy; 2025 Dusun Puluhan.</strong> All rights reserved.
    </footer>
</div>

<script src="https://cdn.jsdelivr.net/npm/admin-lte@3.2/plugins/jquery/jquery.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/admin-lte@3.2/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/admin-lte@3.2/dist/js/adminlte.min.js"></script>
</body>
</html>
