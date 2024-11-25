<?php
require '../../vendor/autoload.php';

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

require_once('../config/koneksi.php'); // Pastikan koneksi database bekerja dengan baik

// Mengambil parameter dari URL
$start_date = isset($_GET['start_date']) ? $_GET['start_date'] : '';
$end_date = isset($_GET['end_date']) ? $_GET['end_date'] : '';
$status = isset($_GET['status']) ? $_GET['status'] : '';

// Validasi jika parameter kosong
if (empty($start_date) || empty($end_date)) {
    die('Error: Start Date or End Date is missing.');
}

// Query untuk mengambil data
$query = "SELECT setor.id_setor, nasabah.nama, nasabah.rt, nasabah.alamat, setor.jenis_sampah, setor.berat, setor.harga, setor.total, setor.tanggal_setor, setor.status_pengolahan
          FROM setor
          JOIN nasabah ON setor.nin = nasabah.nin
          WHERE setor.tanggal_setor BETWEEN '$start_date' AND '$end_date'";

// Jika status dipilih, tambahkan filter status pengolahan
if ($status && $status != 'All') {
    $query .= " AND setor.status_pengolahan = '$status'";
}

// Menjalankan query
$result = mysqli_query($conn, $query);

// Memastikan query berhasil
if (!$result) {
    die('Error: ' . mysqli_error($conn));
}

// Membuat Spreadsheet baru
$spreadsheet = new Spreadsheet();
$sheet = $spreadsheet->getActiveSheet();

// Menambahkan header kolom
$sheet->setCellValue('A1', 'Nomor Transaksi')
      ->setCellValue('B1', 'Nama Nasabah')
      ->setCellValue('C1', 'RT')
      ->setCellValue('D1', 'Alamat')
      ->setCellValue('E1', 'Jenis Sampah')
      ->setCellValue('F1', 'Berat Sampah (KG)')
      ->setCellValue('G1', 'Harga (Rp)')
      ->setCellValue('H1', 'Total (Rp)')
      ->setCellValue('I1', 'Tanggal Setor')
      ->setCellValue('J1', 'Status Pengolahan');

// Menambahkan data dari hasil query ke spreadsheet
$rowNum = 2;
while ($row = mysqli_fetch_assoc($result)) {
    $sheet->setCellValue('A' . $rowNum, $row['id_setor'])
          ->setCellValue('B' . $rowNum, $row['nama'])
          ->setCellValue('C' . $rowNum, $row['rt'])
          ->setCellValue('D' . $rowNum, $row['alamat'])
          ->setCellValue('E' . $rowNum, $row['jenis_sampah'])
          ->setCellValue('F' . $rowNum, $row['berat'])
          ->setCellValue('G' . $rowNum, $row['harga'])
          ->setCellValue('H' . $rowNum, $row['total'])
          ->setCellValue('I' . $rowNum, $row['tanggal_setor'])
          ->setCellValue('J' . $rowNum, $row['status_pengolahan']);
    $rowNum++;
}

// Menyiapkan header untuk unduhan Excel
header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
header('Content-Disposition: attachment;filename="laporan_rekapitulasi.xls"');
header('Cache-Control: max-age=0');

// Menulis ke output
$writer = new Xlsx($spreadsheet);
$writer->save('php://output');
exit;
?>
