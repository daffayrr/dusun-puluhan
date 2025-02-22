<?php
require '../Database/config.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nama = $_POST['nama'];
    $nik = $_POST['nik'];
    $kk = $_POST['kk'];
    $alamat = $_POST['alamat'];
    $tanggal_lahir = $_POST['tanggal_lahir'];
    $pekerjaan = $_POST['pekerjaan'];

    $query = "INSERT INTO penduduk (nama, nik, kk, alamat, tanggal_lahir, pekerjaan) VALUES (?, ?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("ssssss", $nama, $nik, $kk, $alamat, $tanggal_lahir, $pekerjaan);

    if ($stmt->execute()) {
        header("Location: data_penduduk.php");
        exit();
    } else {
        echo "Error: " . $stmt->error;
    }
}
?>
