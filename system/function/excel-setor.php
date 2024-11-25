<?php
require 'vendor/autoload.php'; // Pastikan path ini benar sesuai lokasi autoload.php Anda
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

require_once('../config/koneksi.php');

// Buat objek spreadsheet
$spreadsheet = new Spreadsheet();
$sheet = $spreadsheet->getActiveSheet();

// Set header kolom
$sheet->setCellValue('A1', 'No');
$sheet->setCellValue('B1', 'ID Setor');
$sheet->setCellValue('C1', 'Tanggal Penyetoran');
$sheet->setCellValue('D1', 'Nomor Induk Nasabah');
$sheet->setCellValue('E1', 'Jenis Sampah');
$sheet->setCellValue('F1', 'Berat (Kg)');
$sheet->setCellValue('G1', 'Harga (Rp)');
$sheet->setCellValue('H1', 'Total (Rp)');
$sheet->setCellValue('I1', 'Nomor Induk Admin');

// Ambil data dari database
$query = mysqli_query($conn, "SELECT * FROM setor ORDER BY id_setor ASC");
$no = 1;

while ($row = mysqli_fetch_assoc($query)) {
    $sheet->setCellValue('A' . ($no + 1), $no);
    $sheet->setCellValue('B' . ($no + 1), $row['id_setor']);
    $sheet->setCellValue('C' . ($no + 1), $row['tanggal_setor']);
    $sheet->setCellValue('D' . ($no + 1), $row['nin']);
    $sheet->setCellValue('E' . ($no + 1), $row['jenis_sampah']);
    $sheet->setCellValue('F' . ($no + 1), $row['berat']);
    $sheet->setCellValue('G' . ($no + 1), $row['harga']);
    $sheet->setCellValue('H' . ($no + 1), $row['total']);
    $sheet->setCellValue('I' . ($no + 1), $row['nia']);
    $no++;
}

// Set header untuk output
header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
header('Content-Disposition: attachment; filename="excel-setor (' . date('d-m-Y') . ').xls"');
header('Cache-Control: max-age=0');

// Tulis file ke output
$writer = new Xlsx($spreadsheet);
$writer->save('php://output');
exit;
?>
