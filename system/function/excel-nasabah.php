<?php
// Pastikan file autoload.php dimuat dengan benar
require_once __DIR__ . '/../../vendor/autoload.php';

// Membuat objek Spreadsheet
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

// Membuat objek Spreadsheet baru
$spreadsheet = new Spreadsheet();
$sheet = $spreadsheet->getActiveSheet();

// Menulis data ke dalam spreadsheet
$sheet->setCellValue('A1', 'No');
$sheet->setCellValue('B1', 'NIN');
$sheet->setCellValue('C1', 'Nama Nasabah');
$sheet->setCellValue('D1', 'Alamat');
$sheet->setCellValue('E1', 'Nomor Telepon');
$sheet->setCellValue('F1', 'Username');
$sheet->setCellValue('G1', 'Password');
$sheet->setCellValue('H1', 'Saldo (Rp)');
$sheet->setCellValue('I1', 'Berat (Kg)');

// Query untuk mendapatkan data nasabah
require_once('../config/koneksi.php'); // Menghubungkan ke database

$query = mysqli_query($conn, "SELECT * FROM nasabah ORDER BY nin ASC");
$rowNumber = 2; // Menentukan baris mulai dari baris kedua
while ($row = mysqli_fetch_assoc($query)) {
    $sheet->setCellValue('A' . $rowNumber, $rowNumber - 1);
    $sheet->setCellValue('B' . $rowNumber, $row['nin']);
    $sheet->setCellValue('C' . $rowNumber, $row['nama']);
    $sheet->setCellValue('D' . $rowNumber, $row['alamat']);
    $sheet->setCellValue('E' . $rowNumber, $row['telepon']);
    $sheet->setCellValue('F' . $rowNumber, $row['username']);
    $sheet->setCellValue('G' . $rowNumber, $row['password']);
    $sheet->setCellValue('H' . $rowNumber, $row['saldo']);
    $sheet->setCellValue('I' . $rowNumber, $row['sampah']);
    $rowNumber++;
}

// Mengatur header agar file Excel diunduh
header("Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet");
header("Content-Disposition: attachment; filename=\"excel-nasabah (" . date('d-m-Y') . ").xls\"");
header("Cache-Control: max-age=0");

// Menulis file ke output
$writer = new Xlsx($spreadsheet);
$writer->save('php://output');
?>
