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
                        <h1 class="m-0">Informasi</h1>
                    </div>
                </div>
            </div>
        </div>

        <section class="content">
            <div class="container-fluid">
                <div class="row">
                <!--ISI KODE-->
                <?php
                // Proses Hapus Data
                if (isset($_GET['hapus'])) {
                    $id_hapus = $_GET['hapus'];
                    $deleteQuery = "DELETE FROM informasi WHERE id = $id_hapus";
                    
                    if (mysqli_query($conn, $deleteQuery)) {
                        echo "<div class='alert alert-success'>Informasi berhasil dihapus!</div>";
                    } else {
                        echo "<div class='alert alert-danger'>Gagal menghapus informasi!</div>";
                    }
                }

                // Proses Simpan Data
                if ($_SERVER["REQUEST_METHOD"] == "POST") {
                    $judul = mysqli_real_escape_string($conn, $_POST['judul']);
                    $isi = mysqli_real_escape_string($conn, $_POST['isi']);
                    $tanggal_kegiatan = $_POST['tanggal_kegiatan'];

                    $insertQuery = "INSERT INTO informasi (judul, isi, tanggal_kegiatan) VALUES ('$judul', '$isi', '$tanggal_kegiatan')";
                    
                    if (mysqli_query($conn, $insertQuery)) {
                        echo "<div class='alert alert-success'>Informasi berhasil ditambahkan!</div>";
                    } else {
                        echo "<div class='alert alert-danger'>Terjadi kesalahan: " . mysqli_error($conn) . "</div>";
                    }
                }
                ?>

                <div class="col-md-8">
                    <div class="card">
                        <div class="card-header bg-primary text-white">
                            <h3 class="card-title">Tambah Informasi</h3>
                        </div>
                        <div class="card-body">
                            <form method="POST">
                                <div class="form-group">
                                    <label>Judul</label>
                                    <input type="text" name="judul" class="form-control" required>
                                </div>
                                <div class="form-group">
                                    <label>Isi Pengumuman</label>
                                    <textarea name="isi" class="form-control" rows="4" required></textarea>
                                </div>
                                <div class="form-group">
                                    <label>Tanggal Kegiatan</label>
                                    <input type="date" name="tanggal_kegiatan" class="form-control" required>
                                </div>
                                <button type="submit" class="btn btn-success"><i class="fas fa-save"></i> Simpan</button>
                            </form>
                        </div>
                    </div>
                </div>

                <div class="col-md-12 mt-4">
                    <div class="card">
                        <div class="card-header bg-secondary text-white">
                            <h3 class="card-title">Daftar Informasi</h3>
                        </div>
                        <div class="card-body">
                            <table class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Judul</th>
                                        <th>Isi</th>
                                        <th>Tanggal Kegiatan</th>
                                        <th>Tanggal Dibuat</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $query = "SELECT * FROM informasi ORDER BY tanggal_dibuat DESC";
                                    $result = mysqli_query($conn, $query);
                                    $no = 1;
                                    while ($row = mysqli_fetch_assoc($result)) {
                                        echo "<tr>
                                                <td>{$no}</td>
                                                <td>{$row['judul']}</td>
                                                <td>{$row['isi']}</td>
                                                <td>{$row['tanggal_kegiatan']}</td>
                                                <td>{$row['tanggal_dibuat']}</td>
                                                <td>
                                                    <a href='?hapus={$row['id']}' class='btn btn-danger btn-sm' onclick='return confirm(\"Hapus informasi ini?\")'>
                                                        <i class='fas fa-trash'></i> Hapus
                                                    </a>
                                                </td>
                                            </tr>";
                                        $no++;
                                    }
                                    ?>
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
