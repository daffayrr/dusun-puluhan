<?php
$host = "localhost"; // Ganti jika menggunakan server lain
$user = "root"; // Username MySQL
$pass = "abc_123"; // Password MySQL (biarkan kosong jika default)
$dbname = "dusun_puluhan"; // Nama database

// Membuat koneksi
$conn = new mysqli($host, $user, $pass, $dbname);

// Cek koneksi
if ($conn->connect_error) {
    die("Koneksi gagal: " . $conn->connect_error);
}

// Mengatur charset agar mendukung karakter UTF-8
$conn->set_charset("utf8");

// Jika ingin memastikan koneksi berhasil
// echo "Koneksi berhasil!";
?>
