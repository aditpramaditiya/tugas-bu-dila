<?php
include __DIR__ . '/db.php';

if (isset($_POST['register'])) {
    $nama = $_POST['nama'];
    $email = $_POST['email'];
    $password = $_POST['password'];

    // 1. Cek Email (Menggunakan Prepared Statement)
    $stmt_check = $conn->prepare("SELECT email FROM user WHERE email = ?");
    $stmt_check->bind_param("s", $email);
    $stmt_check->execute();
    $result_check = $stmt_check->get_result();
    
    if ($result_check->num_rows > 0) {
        $error = "Email sudah terdaftar!";
    } else {
        // 2. Insert User (Menggunakan Prepared Statement)
        $stmt_insert = $conn->prepare("INSERT INTO user (nama, email, password) VALUES (?, ?, ?)");
        $stmt_insert->bind_param("sss", $nama, $email, $password);
        
        if ($stmt_insert->execute()) {
            header("location: login.php");
        } else {
            $error = "Gagal daftar. Coba lagi! " . $conn->error;
        }
    }
}
?>

<!DOCTYPE html>
