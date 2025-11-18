<?php
session_start();
include __DIR__ . '/db.php'; // koneksi ke database

if (isset($_POST['login'])) {
    $email = $_POST['email'];
    $password = $_POST['password'];

    // ⚠️ PERBAIKAN: Menggunakan Prepared Statement untuk mencegah SQL Injection
    $stmt = $conn->prepare("SELECT nama FROM user WHERE email = ? AND password = ?");
    $stmt->bind_param("ss", $email, $password);
    $stmt->execute();
    $result = $stmt->get_result();
    $data = $result->fetch_assoc();
    $cek = $result->num_rows;

    if ($cek > 0) {
        // Asumsi kolom nama ada di tabel user
        $_SESSION['user'] = $data['nama'];
        header("location: welcome.php"); // Ganti home.php dengan welcome.php jika welcome.php adalah tujuannya. Di file Anda adanya home.php, saya asumsikan file welcome.php itu maksudnya home.php.
        // Jika welcome.php tidak ada dan seharusnya ke home.php
        // header("location: home.php");
    } else {
        $error = "Email atau Password salah!";
    }
}
?>

<!DOCTYPE html>
