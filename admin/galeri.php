<?php
//session_start();
require '../assets/auth.php';
require '../Database/config.php';

error_reporting(E_ALL);
ini_set('display_errors', 1);

// Pastikan folder uploads ada
$targetDir = "../uploads/";
if (!is_dir($targetDir)) {
    mkdir($targetDir, 0777, true);
}

// Handle Hapus File
if (isset($_GET['hapus'])) {
    $id = mysqli_real_escape_string($conn, $_GET['hapus']);
    $query = "SELECT file_path FROM galeri WHERE id='$id'";
    $result = mysqli_query($conn, $query);
    $data = mysqli_fetch_assoc($result);

    if ($data) {
        $filePath = "../" . $data['file_path']; // Path sesuai dengan lokasi file fisik
        if (file_exists($filePath)) {
            unlink($filePath);
        }
        
        if (mysqli_query($conn, "DELETE FROM galeri WHERE id='$id'")) {
            $_SESSION['message'] = "File berhasil dihapus!";
        } else {
            $_SESSION['message'] = "Gagal menghapus file dari database!";
        }
    } else {
        $_SESSION['message'] = "File tidak ditemukan!";
    }
    header("Location: galeri.php");
    exit;
}

// Handle Upload File
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $judul = mysqli_real_escape_string($conn, $_POST['judul']);
    $tipe = mysqli_real_escape_string($conn, $_POST['tipe']);

    if (!empty($_FILES['file']['name'])) {
        $fileName = time() . "_" . basename($_FILES["file"]["name"]);
        $filePath = $targetDir . $fileName; // Path ke folder uploads/
        $fileType = strtolower(pathinfo($filePath, PATHINFO_EXTENSION));

        $allowedFoto = ['jpg', 'jpeg', 'png', 'gif'];
        $allowedVideo = ['mp4', 'mov', 'avi'];

        if (($tipe == "foto" && in_array($fileType, $allowedFoto)) || ($tipe == "video" && in_array($fileType, $allowedVideo))) {
            if (move_uploaded_file($_FILES["file"]["tmp_name"], $filePath)) {
                $dbPath = "uploads/" . $fileName; // Path yang akan disimpan di database
                $insertQuery = "INSERT INTO galeri (judul, file_path, tipe, created_at) VALUES ('$judul', '$dbPath', '$tipe', NOW())";
                
                if (mysqli_query($conn, $insertQuery)) {
                    $_SESSION['message'] = "File berhasil diupload!";
                } else {
                    $_SESSION['message'] = "Gagal menyimpan ke database!";
                }
            } else {
                $_SESSION['message'] = "Gagal mengupload file! Error: " . $_FILES["file"]["error"];
            }
        } else {
            $_SESSION['message'] = "Format file tidak didukung!";
        }
    } else {
        $_SESSION['message'] = "Pilih file untuk diupload!";
    }
    header("Location: galeri.php");
    exit;
}

// Ambil data galeri
$search = isset($_GET['search']) ? mysqli_real_escape_string($conn, $_GET['search']) : "";
$query = "SELECT * FROM galeri WHERE judul LIKE '%$search%' OR created_at LIKE '%$search%' ORDER BY created_at DESC";
$result = mysqli_query($conn, $query);
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Galeri</title>
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
                <h1 class="m-0">Galeri</h1>
            </div>
        </div>

        <section class="content">
            <div class="container-fluid">
                <?php if (isset($_SESSION['message'])) { echo "<div class='alert alert-info'>" . $_SESSION['message'] . "</div>"; unset($_SESSION['message']); } ?>
                
                <div class="card card-primary">
                    <div class="card-header">
                        <h3 class="card-title">Upload Foto/Video</h3>
                    </div>
                    <div class="card-body">
                        <form action="galeri.php" method="post" enctype="multipart/form-data">
                            <input type="text" name="judul" class="form-control" placeholder="Judul" required>
                            <select name="tipe" class="form-control mt-2" required>
                                <option value="foto">Foto</option>
                                <option value="video">Video</option>
                            </select>
                            <input type="file" name="file" class="form-control mt-2" required>
                            <button type="submit" class="btn btn-success mt-2">Upload</button>
                        </form>
                    </div>
                </div>
                
                <form method="get" action="galeri.php">
                    <div class="input-group mb-3">
                        <input type="text" name="search" class="form-control" placeholder="Cari berdasarkan judul/tanggal" value="<?= htmlspecialchars($search) ?>">
                        <div class="input-group-append">
                            <button type="submit" class="btn btn-primary"><i class="fas fa-search"></i> Cari</button>
                        </div>
                    </div>
                </form>

                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Daftar Foto & Video</h3>
                    </div>
                    <div class="card-body">
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Judul</th>
                                    <th>Jenis</th>
                                    <th>Preview</th>
                                    <th>Tanggal</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $no = 1;
                                while ($row = mysqli_fetch_assoc($result)) {
                                    echo "<tr>
                                        <td>{$no}</td>
                                        <td>{$row['judul']}</td>
                                        <td>{$row['tipe']}</td>
                                        <td>" . ($row['tipe'] == 'foto' ? "<img src='../{$row['file_path']}' width='100'>" : "<video width='150' controls><source src='../{$row['file_path']}' type='video/mp4'></video>") . "</td>
                                        <td>{$row['created_at']}</td>
                                        <td><a href='galeri.php?hapus={$row['id']}' class='btn btn-danger btn-sm' onclick='return confirm(\"Yakin ingin menghapus file ini?\");'><i class='fas fa-trash'></i> Hapus</a></td>
                                    </tr>";
                                    $no++;
                                }
                                ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </section>
    </div>
</div>
</body>
</html>
