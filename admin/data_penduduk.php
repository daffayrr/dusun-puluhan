<?php
session_start();
require '../Database/config.php';

// Tambah Data Penduduk
if (isset($_POST['tambah'])) {
    $nama = $_POST['nama'];
    $nik = $_POST['nik'];
    $kk = $_POST['kk'];
    $alamat = $_POST['alamat'];
    $rt = $_POST['rt'];
    $tanggal_lahir = $_POST['tanggal_lahir'];
    $pekerjaan = $_POST['pekerjaan'];

    $query = "INSERT INTO penduduk (nama, nik, kk, alamat, rt, tanggal_lahir, pekerjaan) VALUES (?, ?, ?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("sssssss", $nama, $nik, $kk, $alamat, $rt, $tanggal_lahir, $pekerjaan);
    $stmt->execute();
    header("Location: data_penduduk.php");
    exit();
}

// Edit Data Penduduk
if (isset($_POST['edit'])) {
    $id = $_POST['id'];
    $nama = $_POST['nama'];
    $nik = $_POST['nik'];
    $kk = $_POST['kk'];
    $alamat = $_POST['alamat'];
    $rt = $_POST['rt'];
    $tanggal_lahir = $_POST['tanggal_lahir'];
    $pekerjaan = $_POST['pekerjaan'];

    $query = "UPDATE penduduk SET nama=?, nik=?, kk=?, alamat=?, rt=?, tanggal_lahir=?, pekerjaan=? WHERE id=?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("sssssssi", $nama, $nik, $kk, $alamat, $rt, $tanggal_lahir, $pekerjaan, $id);
    $stmt->execute();
    header("Location: data_penduduk.php");
    exit();
}

// Hapus Data Penduduk
if (isset($_GET['hapus'])) {
    $id = $_GET['hapus'];
    $conn->query("DELETE FROM penduduk WHERE id=$id");
    header("Location: data_penduduk.php");
    exit();
}

// Ambil Data Penduduk
$search = "";
$whereClause = "";
if (isset($_GET['search'])) {
    $search = $_GET['search'];
    $whereClause = "WHERE nama LIKE '%$search%' OR nik LIKE '%$search%' OR kk LIKE '%$search%'";
}
$result = $conn->query("SELECT * FROM penduduk $whereClause ORDER BY id DESC");
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kelola Data Penduduk</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/admin-lte@3.2/dist/css/adminlte.min.css">
    <script src="https://cdn.jsdelivr.net/npm/jquery/dist/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/datatables.net/js/jquery.dataTables.min.js"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/datatables.net-dt/css/jquery.dataTables.min.css">
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
                        <h1 class="m-0">Kelola Data Penduduk</h1>
                    </div>
                </div>
            </div>
        </div>
        <section class="content">
            <div class="container-fluid">
                <form method="POST" class="mb-3">
                    <div class="row">
                        <div class="col-md-4">
                            <input type="text" name="nama" class="form-control" placeholder="Nama" required>
                        </div>
                        <div class="col-md-3">
                            <input type="text" name="nik" class="form-control" placeholder="NIK" required>
                        </div>
                        <div class="col-md-3">
                            <input type="text" name="kk" class="form-control" placeholder="KK" required>
                        </div>
                    </div>
                    <div class="row mt-2">
                        <div class="col-md-4">
                            <input type="text" name="alamat" class="form-control" placeholder="Alamat" required>
                        </div>
                        <div class="col-md-2">
                            <input type="text" name="rt" class="form-control" placeholder="RT" required>
                        </div>
                        <div class="col-md-2">
                            <input type="date" name="tanggal_lahir" class="form-control" required>
                        </div>
                        <div class="col-md-3">
                            <input type="text" name="pekerjaan" class="form-control" placeholder="Pekerjaan">
                        </div>
                    </div>
                    <button type="submit" name="tambah" class="btn btn-success mt-2">Tambah Data</button>
                </form>
                <table id="pendudukTable" class="table table-striped">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Nama</th>
                            <th>NIK</th>
                            <th>KK</th>
                            <th>Alamat</th>
                            <th>RT</th>
                            <th>Tanggal Lahir</th>
                            <th>Pekerjaan</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php while ($row = $result->fetch_assoc()) { ?>
                        <tr>
                            <td><?php echo $row['id']; ?></td>
                            <td><?php echo $row['nama']; ?></td>
                            <td><?php echo $row['nik']; ?></td>
                            <td><?php echo $row['kk']; ?></td>
                            <td><?php echo $row['alamat']; ?></td>
                            <td><?php echo $row['rt']; ?></td>
                            <td><?php echo $row['tanggal_lahir']; ?></td>
                            <td><?php echo $row['pekerjaan']; ?></td>
                            <td>
                                <button class="btn btn-warning btn-sm editBtn" data-id="<?php echo $row['id']; ?>">Edit</button>
                                <a href="?hapus=<?php echo $row['id']; ?>" class="btn btn-danger btn-sm" onclick="return confirm('Hapus data ini?');">Hapus</a>
                            </td>
                        </tr>
                        <?php } ?>
                    </tbody>
                </table>
            </div>
        </section>
    </div>
</div>
<script>
$(document).ready(function() {
    $('#pendudukTable').DataTable();
});
</script>
</body>
</html>