<?php
require '../assets/auth.php';
require '../Database/config.php';

// Ambil jumlah penduduk dari tabel
$query = "SELECT COUNT(*) AS total_penduduk FROM penduduk"; 
$result = mysqli_query($conn, $query);
$row = mysqli_fetch_assoc($result);
$total_penduduk = $row['total_penduduk'];
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Informasi</title>
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
                        <h1 class="m-0">Informasi Pengaduan Masyarakat</h1>
                    </div>
                </div>
            </div>
        </div>

        <section class="content">
            <div class="container-fluid">
                <div class="row">
                <!--ISI KODE-->

                <?php
                require '../Database/config.php';

                // Ambil jumlah penduduk dari tabel
                $query = "SELECT COUNT(*) AS total_penduduk FROM penduduk";
                $result = mysqli_query($conn, $query);
                $row = mysqli_fetch_assoc($result);
                $total_penduduk = $row['total_penduduk'];

                // Ambil status filter jika ada
                $status_filter = isset($_GET['status']) ? $_GET['status'] : '';

                // Query untuk mengambil data pengaduan
                $query_pengaduan = "SELECT * FROM pengaduan";
                if ($status_filter && in_array($status_filter, ['baru', 'diproses', 'selesai'])) {
                    $query_pengaduan .= " WHERE status = '" . mysqli_real_escape_string($conn, $status_filter) . "'";
                }
                $result_pengaduan = mysqli_query($conn, $query_pengaduan);
                ?>

                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">Daftar Pengaduan</h3>
                        </div>
                        <div class="card-body">
                            <div class="mb-3">
                                <form method="GET">
                                    <label for="status">Filter Status:</label>
                                    <select name="status" id="status" class="form-control w-25 d-inline">
                                        <option value="">Semua</option>
                                        <option value="baru" <?= ($status_filter == 'pendinbarug') ? 'selected' : '' ?>>Baru</option>
                                        <option value="diproses" <?= ($status_filter == 'diproses') ? 'selected' : '' ?>>Diproses</option>
                                        <option value="selesai" <?= ($status_filter == 'selesai') ? 'selected' : '' ?>>Selesai</option>
                                    </select>
                                    <button type="submit" class="btn btn-primary">Filter</button>
                                </form>
                            </div>
                            <table class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>Nama</th>
                                        <th>Email</th>
                                        <th>Pesan</th>
                                        <th>Status</th>
                                        <th>Waktu</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php while ($row = mysqli_fetch_assoc($result_pengaduan)) : ?>
                                        <tr>
                                            <td><?= htmlspecialchars($row['id']) ?></td>
                                            <td><?= htmlspecialchars($row['nama']) ?></td>
                                            <td><?= htmlspecialchars($row['email']) ?></td>
                                            <td><?= htmlspecialchars($row['pesan']) ?></td>
                                            <td><span class="badge bg-<?= $row['status'] == 'pending' ? 'warning' : ($row['status'] == 'diproses' ? 'info' : 'success') ?>"><?= htmlspecialchars($row['status']) ?></span></td>
                                            <td><?= htmlspecialchars($row['created_at']) ?></td>
                                        </tr>
                                    <?php endwhile; ?>
                                </tbody>
                            </table>
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