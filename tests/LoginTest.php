<?php
use PHPUnit\Framework\TestCase;

class LoginTest extends TestCase
{
    protected $db;

    protected function setUp(): void
    {
        require '../system/config/koneksi.php'; // Pastikan path ini benar
        $this->db = $conn; // Pastikan koneksi database sesuai
    }

    public function testLoginSuccess()
    {
        // Simulasikan login dengan data yang valid
        $_POST['user'] = 'admin_user'; // Ganti dengan user yang valid
        $_POST['pass'] = 'admin_password'; // Ganti dengan password yang valid

        ob_start(); // Mulai output buffering
        include '../page/cek_login.php'; // Memanggil file cek_login.php
        $output = ob_get_clean(); // Tangkap output

        // Periksa apakah output mengandung pesan login berhasil
        $this->assertStringContainsString('Selamat Anda berhasil login!', $output);
    }

    public function testLoginFailure()
    {
        // Simulasikan login dengan data yang tidak valid
        $_POST['user'] = 'invalid_user'; // User tidak valid
        $_POST['pass'] = 'invalid_password'; // Password tidak valid

        ob_start(); // Mulai output buffering
        include '../page/cek_login.php'; // Memanggil file cek_login.php
        $output = ob_get_clean(); // Tangkap output

        // Periksa apakah output mengandung pesan login gagal
        $this->assertStringContainsString('Maaf username dan password tidak valid!', $output);
    }
}
