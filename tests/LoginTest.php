// login_project/tests/LoginTest.php
<?php

use PHPUnit\Framework\TestCase;

// Import fungsi koneksi tes
require_once __DIR__ . '/DatabaseTestUtility.php';

class LoginTest extends TestCase
{
    private $conn;

    protected function setUp(): void
    {
        // Setup koneksi database khusus untuk tes
        $this->conn = getTestConnection();
    }

    protected function tearDown(): void
    {
        // Tutup koneksi setelah tes
        $this->conn->close();
    }

    // --- TEST LOGIN BERHASIL ---
    public function testSuccessfulLogin()
    {
        $email = "test@example.com";
        $password = "password123";
        
        $stmt = $this->conn->prepare("SELECT nama FROM user WHERE email = ? AND password = ?");
        $this->assertNotFalse($stmt, "Failed to prepare statement for successful login");
        $stmt->bind_param("ss", $email, $password);
        $stmt->execute();
        $result = $stmt->get_result();
        $data = $result->fetch_assoc();
        $cek = $result->num_rows;

        // Assert: Cek harus lebih dari 0 dan nama harus 'Tester'
        $this->assertGreaterThan(0, $cek, "Login seharusnya berhasil");
        $this->assertEquals("Tester", $data['nama'], "Nama user harus sesuai");
    }
    
    // --- TEST LOGIN GAGAL (Password Salah) ---
    public function testFailedLoginWrongPassword()
    {
        $email = "test@example.com";
        $password = "salahpassword"; // Password salah
        
        $stmt = $this->conn->prepare("SELECT nama FROM user WHERE email = ? AND password = ?");
        $this->assertNotFalse($stmt, "Failed to prepare statement for failed login (wrong password)");
        $stmt->bind_param("ss", $email, $password);
        $stmt->execute();
        $result = $stmt->get_result();
        $cek = $result->num_rows;

        // Assert: Cek harus 0
        $this->assertEquals(0, $cek, "Login seharusnya gagal dengan password salah");
    }

    // --- TEST LOGIN GAGAL (Email Tidak Ditemukan) ---
    public function testFailedLoginEmailNotFound()
    {
        $email = "nonexistent@example.com"; // Email tidak ada
        $password = "password123";
        
        $stmt = $this->conn->prepare("SELECT nama FROM user WHERE email = ? AND password = ?");
        $this->assertNotFalse($stmt, "Failed to prepare statement for failed login (email not found)");
        $stmt->bind_param("ss", $email, $password);
        $stmt->execute();
        $result = $stmt->get_result();
        $cek = $result->num_rows;

        // Assert: Cek harus 0
        $this->assertEquals(0, $cek, "Login seharusnya gagal karena email tidak terdaftar");
    }
}
?>
