<?php
require '../Database/config.php';

if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $result = $conn->query("SELECT * FROM penduduk WHERE id = $id");
    $data = $result->fetch_assoc();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nama = $_POST['nama'];
    $nik = $_POST['nik'];
    $kk = $_POST['kk'];
    $alamat = $_POST['alamat'];
    $tanggal_lahir = $_POST['tanggal_lahir'];
    $pekerjaan = $_POST['pekerjaan'];

    $query = "UPDATE penduduk SET nama=?, nik=?, kk=?, alamat=?, tanggal_lahir=?, pekerjaan=? WHERE id=?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("ssssssi", $nama, $nik, $kk, $alamat, $tanggal_lahir, $pekerjaan, $id);

    if ($stmt->execute()) {
        header("Location: data_penduduk.php");
        exit();
    } else {
        echo "Error: " . $stmt->error;
    }
}
?>
