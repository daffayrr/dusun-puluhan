<?php
require '../Database/config.php';

if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $query = "DELETE FROM penduduk WHERE id = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("i", $id);

    if ($stmt->execute()) {
        header("Location: data_penduduk.php");
        exit();
    } else {
        echo "Error: " . $stmt->error;
    }
}
?>
