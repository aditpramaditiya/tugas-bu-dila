<?php
// Ganti mysqli_connect ke gaya OOP
$servername = "localhost";
$username = "root";
$password = "";
$database = "login_db";

// Koneksi ke database (Menggunakan OOP)
$conn = new mysqli($servername, $username, $password, $database);

// Cek koneksi
if ($conn->connect_error) {
    die("Koneksi gagal: " . $conn->connect_error);
}
// Jika perlu set karakter, tambahkan: $conn->set_charset("utf8");
?>
