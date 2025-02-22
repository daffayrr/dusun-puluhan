<?php
require '../assets/auth.php';
require '../Database/config.php';

// Ambil data layanan administrasi
$query = "SELECT * FROM layanan_administrasi";
$result = mysqli_query($conn, $query);

// Update status atau unggah ulang file
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id = $_POST['id'];
    
    if (isset($_POST['status'])) {
        $status = $_POST['status'];
        $updateQuery = "UPDATE layanan_administrasi SET status='$status' WHERE id='$id'";
        mysqli_query($conn, $updateQuery);
    }

    if (isset($_FILES['dokumen_admin']) && $_FILES['dokumen_admin']['error'] == 0) {
        $file_name = time() . "_" . $_FILES['dokumen_admin']['name'];
        $target_dir = "../uploads/";
        $target_file = $target_dir . basename($file_name);
        
        if (move_uploaded_file($_FILES['dokumen_admin']['tmp_name'], $target_file)) {
            $updateFileQuery = "UPDATE layanan_administrasi SET dokumen_admin='$file_name' WHERE id='$id'";
            mysqli_query($conn, $updateFileQuery);
        }
    }
    header("Location: layanan_administrasi.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Layanan Administrasi</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/admin-lte@3.2/dist/css/adminlte.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/admin-lte@3.2/plugins/fontawesome-free/css/all.min.css">
</head>
<body class="hold-transition sidebar-mini layout-fixed">
<div class="wrapper">
    <?php include '../assets/header.php'; ?>
    <?php include '../assets/sidebar.php'; ?>

    <div class="content-wrapper">
        <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1 class="m-0">Layanan Administrasi</h1>
                    </div>
                </div>
            </div>
        </div>

        <section class="content">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-header">
                                <h3 class="card-title">Daftar Permohonan</h3>
                            </div>
                            <div class="card-body">
                                <table class="table table-bordered">
                                    <thead>
                                        <tr>
                                            <th>ID</th>
                                            <th>Nama</th>
                                            <th>RT</th>
                                            <th>Jenis Surat</th>
                                            <th>Keperluan</th>
                                            <th>Dokumen Pendukung</th>
                                            <th>Dokumen Admin</th>
                                            <th>Status</th>
                                            <th>Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php while ($row = mysqli_fetch_assoc($result)) : ?>
                                            <tr>
                                                <td><?= $row['id']; ?></td>
                                                <td><?= $row['nama']; ?></td>
                                                <td><?= $row['rt']; ?></td>
                                                <td><?= $row['jenis_surat']; ?></td>
                                                <td><?= $row['keperluan']; ?></td>
                                                <td>
                                                    <?php if ($row['dokumen_pendukung']) : ?>
                                                        <a href="../uploads/<?= $row['dokumen_pendukung']; ?>" target="_blank">Lihat</a>
                                                    <?php endif; ?>
                                                </td>
                                                <td>
                                                    <?php if ($row['dokumen_admin']) : ?>
                                                        <a href="../uploads/<?= $row['dokumen_admin']; ?>" target="_blank">Lihat</a>
                                                    <?php endif; ?>
                                                </td>
                                                <td>
                                                    <form method="post">
                                                        <input type="hidden" name="id" value="<?= $row['id']; ?>">
                                                        <select name="status" class="form-control" onchange="this.form.submit()">
                                                            <option value="Menunggu" <?= $row['status'] == 'Menunggu' ? 'selected' : ''; ?>>Menunggu</option>
                                                            <option value="Diproses" <?= $row['status'] == 'Diproses' ? 'selected' : ''; ?>>Diproses</option>
                                                            <option value="Selesai" <?= $row['status'] == 'Selesai' ? 'selected' : ''; ?>>Selesai</option>
                                                        </select>
                                                    </form>
                                                </td>
                                                <td>
                                                    <form method="post" enctype="multipart/form-data">
                                                        <input type="hidden" name="id" value="<?= $row['id']; ?>">
                                                        <input type="file" name="dokumen_admin" class="form-control" accept=".pdf">
                                                        <button type="submit" class="btn btn-primary btn-sm mt-1">Upload</button>
                                                    </form>
                                                </td>
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
