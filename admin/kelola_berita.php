<?php
session_start();
//require '../assets/auth.php';
require '../Database/config.php';

// Ambil nama pengguna yang sedang login
$created_by = isset($_SESSION['nama']) ? $_SESSION['nama'] : "Admin";

$uploadError = "";
$successMessage = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $judul = mysqli_real_escape_string($conn, $_POST['judul']);
    $isi = mysqli_real_escape_string($conn, $_POST['isi']);

    // Cek apakah ada file yang diunggah
    if (!empty($_FILES["gambar"]["name"])) {
        $targetDir = "../uploads/";
        $fileName = time() . "_" . basename($_FILES["gambar"]["name"]);
        $targetFilePath = $targetDir . $fileName;
        $fileType = pathinfo($targetFilePath, PATHINFO_EXTENSION);

        $allowTypes = ['jpg', 'png', 'jpeg', 'gif'];
        if (in_array($fileType, $allowTypes)) {
            if (move_uploaded_file($_FILES["gambar"]["tmp_name"], $targetFilePath)) {
                $gambar = $fileName;
            } else {
                $uploadError = "Gagal mengunggah gambar.";
            }
        } else {
            $uploadError = "Format gambar tidak valid (jpg, png, jpeg, gif).";
        }
    } else {
        $gambar = "";
    }

    if (empty($uploadError)) {
        // Masukkan created_by sebagai STRING dalam query
        $query = "INSERT INTO berita (judul, isi, gambar, created_by, created_at) 
                  VALUES ('$judul', '$isi', '$gambar', '$created_by', NOW())";
        
        if (mysqli_query($conn, $query)) {
            $successMessage = "Berita berhasil ditambahkan.";
        } else {
            $uploadError = "Gagal menyimpan berita: " . mysqli_error($conn);
        }
    }
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
    <title>Kelola Berita</title>
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
                        <h1 class="m-0">Kelola Berita</h1>
                    </div>
                </div>
            </div>
        </div>

        <section class="content">
            <div class="container-fluid">
                <!-- Form Tambah Berita -->
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Tambah Berita</h3>
                    </div>
                    <div class="card-body">
                        <?php if (!empty($successMessage)): ?>
                            <div class="alert alert-success"><?php echo $successMessage; ?></div>
                        <?php endif; ?>
                        <?php if (!empty($uploadError)): ?>
                            <div class="alert alert-danger"><?php echo $uploadError; ?></div>
                        <?php endif; ?>

                        <form action="" method="POST" enctype="multipart/form-data">
                            <div class="form-group">
                                <label>Judul</label>
                                <input type="text" name="judul" class="form-control" required>
                            </div>
                            <div class="form-group">
                                <label>Isi</label>
                                <textarea name="isi" class="form-control" rows="4" required></textarea>
                            </div>
                            <div class="form-group">
                                <label>Gambar</label>
                                <input type="file" name="gambar" class="form-control">
                            </div>
                            <button type="submit" class="btn btn-primary">Simpan</button>
                        </form>
                    </div>
                </div>

                <!-- Daftar Berita -->
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Daftar Berita</h3>
                    </div>
                    <div class="card-body">
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Judul</th>
                                    <th>Isi</th>
                                    <th>Gambar</th>
                                    <th>Penulis</th>
                                    <th>Tanggal</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $no = 1; ?>
                                <?php while ($row = mysqli_fetch_assoc($resultBerita)): ?>
                                    <tr>
                                        <td><?php echo $no++; ?></td>
                                        <td><?php echo $row['judul']; ?></td>
                                        <td><?php echo substr($row['isi'], 0, 50) . '...'; ?></td>
                                        <td>
                                            <?php if (!empty($row['gambar'])): ?>
                                                <img src="../uploads/<?php echo $row['gambar']; ?>" width="100">
                                            <?php else: ?>
                                                Tidak ada gambar
                                            <?php endif; ?>
                                        </td>
                                        <td><?php echo $row['created_by']; ?></td>
                                        <td><?php echo $row['created_at']; ?></td>
                                    </tr>
                                <?php endwhile; ?>
                            </tbody>
                        </table>
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
