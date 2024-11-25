<?php
use PHPUnit\Framework\TestCase;

class KoneksiTest extends TestCase
{
    protected $db;

    protected function setUp(): void
    {
        require 'system/config/koneksi.php';  // Pastikan path ini sesuai dengan lokasi file koneksi.php
        $this->db = $conn; // Sesuaikan variabel koneksi ke $conn
    }

    public function testDatabaseConnection()
    {
        // Pastikan koneksi tidak null
        $this->assertNotNull($this->db, 'Database connection should not be null');
    }
}
