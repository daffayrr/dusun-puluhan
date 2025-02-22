<?php
require '../Database/config.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nama = $_POST['nama'] ?? '';
    $rt = $_POST['rt'] ?? '';
    $jenis_surat = $_POST['jenis_surat'] ?? '';
    $keperluan = $_POST['keperluan'] ?? '';
    $status = "pending"; // Default status
    $created_at = date("Y-m-d H:i:s");

    // Daftar jenis surat yang diizinkan (sesuai ENUM di database)
    $allowedJenisSurat = ['domisili', 'pengantar', 'lainnya'];

    // Validasi input kosong
    if (empty($nama) || empty($rt) || empty($jenis_surat) || empty($keperluan)) {
        $error = "❌ Semua field harus diisi!";
    } elseif (!in_array($jenis_surat, $allowedJenisSurat)) {
        $error = "❌ Jenis surat tidak valid! Pilih: domisili, pengantar, atau lainnya.";
    } else {
        // Pastikan folder `uploads` tersedia
        $uploadDir = __DIR__ . "/uploads"; // Direktori penyimpanan file
        if (!file_exists($uploadDir)) {
            mkdir($uploadDir, 0777, true); // Buat folder jika belum ada
        }

        // Proses upload file
        if (isset($_FILES['dokumen_pendukung']) && $_FILES['dokumen_pendukung']['error'] == 0) {
            $file = $_FILES['dokumen_pendukung'];
            $fileName = basename($file['name']);
            $fileTmp = $file['tmp_name'];
            $fileExt = strtolower(pathinfo($fileName, PATHINFO_EXTENSION));

            // Validasi ekstensi file
            $allowedExts = ['pdf', 'doc', 'docx'];
            if (!in_array($fileExt, $allowedExts)) {
                $error = "❌ Format file tidak didukung! Hanya PDF, DOC, dan DOCX.";
            } else {
                // Buat nama unik untuk file
                $newFileName = "dokumen_" . time() . "." . $fileExt;
                $filePath = $uploadDir . "/" . $newFileName;

                if (move_uploaded_file($fileTmp, $filePath)) {
                    // Simpan ke database (TANPA `user_id`)
                    $query = "INSERT INTO layanan_administrasi (nama, rt, jenis_surat, keperluan, status, created_at, dokumen_pendukung) 
                              VALUES (?, ?, ?, ?, ?, ?, ?)";
                    $stmt = mysqli_prepare($conn, $query);
                    mysqli_stmt_bind_param($stmt, "sssssss", $nama, $rt, $jenis_surat, $keperluan, $status, $created_at, $newFileName);

                    if (mysqli_stmt_execute($stmt)) {
                        $success = "✅ Pengajuan berhasil dikirim!";
                    } else {
                        $error = "❌ Terjadi kesalahan pada database: " . mysqli_error($conn);
                    }
                } else {
                    $error = "❌ Gagal mengunggah file!";
                }
            }
        } else {
            $error = "❌ Harap unggah dokumen pendukung!";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Upload Surat</title>
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
                        <h1 class="m-0">Upload Surat</h1>
                    </div>
                </div>
            </div>
        </div>

        <section class="content">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-md-8">
                        <div class="card">
                            <div class="card-header">
                                <h3 class="card-title">Form Upload Surat</h3>
                            </div>
                            <div class="card-body">
                                <?php if (isset($error)) { echo "<div class='alert alert-danger'>$error</div>"; } ?>
                                <?php if (isset($success)) { echo "<div class='alert alert-success'>$success</div>"; } ?>
                                
                                <form action="" method="POST" enctype="multipart/form-data">
                                    <div class="form-group">
                                        <label>Nama:</label>
                                        <input type="text" name="nama" class="form-control" required>
                                    </div>
                                    
                                    <div class="form-group">
                                        <label>RT:</label>
                                        <input type="text" name="rt" class="form-control" required>
                                    </div>

                                    <div class="form-group">
                                        <label>Jenis Surat:</label>
                                        <select name="jenis_surat" class="form-control" required>
                                            <option value="domisili">Domisili</option>
                                            <option value="pengantar">Pengantar</option>
                                            <option value="lainnya">Lainnya</option>
                                        </select>
                                    </div>

                                    <div class="form-group">
                                        <label>Keperluan:</label>
                                        <textarea name="keperluan" class="form-control" required></textarea>
                                    </div>

                                    <div class="form-group">
                                        <label>Upload Dokumen (PDF/DOC/DOCX):</label>
                                        <input type="file" name="dokumen_pendukung" class="form-control-file" accept=".pdf,.doc,.docx" required>
                                    </div>

                                    <button type="submit" class="btn btn-primary">Kirim</button>
                                </form>
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
