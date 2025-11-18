// login_project/tests/DatabaseTestUtility.php
<?php

// Fungsi untuk membuat koneksi ke database tes
function getTestConnection() {
    // Gunakan parameter koneksi yang sesuai untuk lingkungan CI/CD (GitHub Actions)
    $servername = "127.0.0.1"; // Host database service
    $username = "testuser";    // User untuk testing
    $password = "testpassword"; // Password untuk testing
    $database = "test_login_db"; // Nama database untuk testing

    // Gunakan mysqli dengan object-oriented style
    $conn = new mysqli($servername, $username, $password, $database);

    if ($conn->connect_error) {
        die("Koneksi Tes Gagal: " . $conn->connect_error);
    }
    
    // Pastikan tabel user ada untuk testing
    $conn->query("
        CREATE TABLE IF NOT EXISTS user (
            id INT AUTO_INCREMENT PRIMARY KEY,
            nama VARCHAR(255) NOT NULL,
            email VARCHAR(255) UNIQUE NOT NULL,
            password VARCHAR(255) NOT NULL
        )
    ");
    
    // Hapus semua data (cleanup)
    $conn->query("DELETE FROM user");
    
    // Tambahkan data dummy untuk Login Test
    $dummy_name = "Tester";
    $dummy_email = "test@example.com";
    $dummy_password = "password123";
    
    $stmt = $conn->prepare("INSERT INTO user (nama, email, password) VALUES (?, ?, ?)");
    $stmt->bind_param("sss", $dummy_name, $dummy_email, $dummy_password);
    $stmt->execute();
    
    return $conn;
}

?>
