tests/KoneksiTest.php

php
Copy code
<?php
use PHPUnit\Framework\TestCase;

class KoneksiTest extends TestCase
{
    protected $db;

    protected function setUp(): void
    {
        require 'system/config/koneksi.php';
        $this->db = $koneksi; // Asumsikan variabel koneksi database adalah $koneksi
    }

    public function testDatabaseConnection()
    {
        // Pastikan koneksi tidak null
        $this->assertNotNull($this->db, 'Database connection should not be null');
    }
}
4. Jalankan PHPUnit:
Setelah file test dibuat, kamu bisa menjalankan PHPUnit untuk melakukan testing dari terminal.

Jika PHPUnit terinstall secara lokal di vendor/bin/, kamu bisa menjalankan perintah berikut:

bash
Copy code
vendor/bin/phpunit --testdox tests
Ini akan menjalankan semua test yang ada di folder tests. Jika ada test yang gagal, kamu akan melihat detail error di terminal.

5. Konfigurasi PHPUnit (Opsional):
Jika kamu sering menjalankan testing, kamu bisa membuat file konfigurasi phpunit.xml di root project agar lebih mudah menjalankan perintah testing tanpa harus menulis jalur lengkap. Contoh isi phpunit.xml:

xml
Copy code
<phpunit bootstrap="vendor/autoload.php">
    <testsuites>
        <testsuite name="Project Test Suite">
            <directory>tests</directory>
        </testsuite>
    </testsuites>
</phpunit>
Setelah itu, kamu hanya perlu menjalankan perintah sederhana ini untuk menjalankan semua test:

bash
Copy code
vendor/bin/phpunit
Output di Terminal:
Jika tes berhasil, kamu akan melihat output seperti ini di terminal VSCode:

bash
Copy code
Project Test Suite
 ✔ KoneksiTest > testDatabaseConnection0