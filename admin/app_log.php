<?php
require '../assets/auth.php';
require '../Database/config.php';

// Ambil log dari database
$query = "SELECT * FROM app_log ORDER BY date DESC";
$result = mysqli_query($conn, $query);

// Periksa apakah query berhasil
if (!$result) {
    die("Error Query: " . mysqli_error($conn)); // Debugging jika query gagal
}

$log_text = "";
while ($row = mysqli_fetch_assoc($result)) {
    $log_text .= date('d-m-Y H:i:s', strtotime($row['date'])) . " [" . $row['user'] . "] " . $row['events'] . "\n";
}

// Jika tidak ada log
if (empty($log_text)) {
    $log_text = "Belum ada log aktivitas.";
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Log Aplikasi</title>
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
                        <h1 class="m-0">Log Aplikasi</h1>
                    </div>
                </div>
            </div>
        </div>

        <section class="content">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-md-12">
                        <div class="card">
                            <div class="card-header">
                                <h3 class="card-title">Catatan Aktivitas</h3>
                            </div>
                            <div class="card-body">
                                <textarea class="form-control" rows="15" readonly><?php echo htmlspecialchars($log_text); ?></textarea>
                            </div>
                            <div class="card-footer">
                                <a href="export_log.php?type=excel" class="btn btn-success"><i class="fas fa-file-excel"></i> Export Excel</a>
                                <a href="export_log.php?type=pdf" class="btn btn-danger"><i class="fas fa-file-pdf"></i> Export PDF</a>
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
