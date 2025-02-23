<?php
require '../assets/auth.php';
require '../Database/config.php';

// Ambil log dari database
$query = "SELECT * FROM app_log ORDER BY date DESC";
$result = mysqli_query($conn, $query);

if (!$result) {
    die("Error Query: " . mysqli_error($conn));
}

$log_text = "";
while ($row = mysqli_fetch_assoc($result)) {
    $log_text .= date('d-m-Y H:i:s', strtotime($row['date'])) . " [" . $row['user'] . "] " . $row['events'] . "\n";
}

if (empty($log_text)) {
    $log_text = "Belum ada log aktivitas.";
}

// Cek status HTTP server
function checkHttpStatus($url) {
    $ch = curl_init($url);
    curl_setopt($ch, CURLOPT_NOBODY, true);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
    curl_setopt($ch, CURLOPT_TIMEOUT, 5);
    curl_exec($ch);
    $http_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    curl_close($ch);
    return $http_code;
}

$server_url = "https://yourwebsite.com"; // Ganti dengan domain server
$http_status = checkHttpStatus($server_url);

// Cek ping server (hanya untuk sistem berbasis Linux)
function getPing($host) {
    $ping_result = exec("ping -c 1 " . escapeshellarg($host) . " | grep 'time='");
    preg_match('/time=([\d.]+) ms/', $ping_result, $matches);
    return isset($matches[1]) ? $matches[1] . " ms" : "Timeout";
}

$server_ping = getPing(parse_url($server_url, PHP_URL_HOST));

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

                        <!-- STATUS KONEKSI -->
                        <div class="card mt-4">
                            <div class="card-header bg-info text-white">
                                <h3 class="card-title"><i class="fas fa-signal"></i> Status Koneksi Server</h3>
                            </div>
                            <div class="card-body">
                                <p><strong>HTTP Status:</strong> <span id="http_status"><?php echo $http_status; ?></span></p>
                                <p><strong>Ping:</strong> <span id="server_ping"><?php echo $server_ping; ?></span></p>
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

<!-- AJAX untuk Update Status Koneksi -->
<script>
function updateConnectionStatus() {
    $.ajax({
        url: 'check_connection.php',
        type: 'GET',
        dataType: 'json',
        success: function(response) {
            $("#http_status").text(response.http_status);
            $("#server_ping").text(response.server_ping);
        },
        error: function() {
            $("#http_status").text("Error");
            $("#server_ping").text("Error");
        }
    });
}

// Update setiap 1 menit
setInterval(updateConnectionStatus, 60000);
</script>

</body>
</html>
