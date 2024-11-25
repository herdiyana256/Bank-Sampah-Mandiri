<?php
// Memulai sesi dan menginklusi file yang diperlukan
session_start();

require_once('../config/koneksi.php');  // Pastikan path ini benar
require '../../vendor/autoload.php';  // Pastikan path ini benar juga

use Dompdf\Dompdf;
use Dompdf\Options;

// Cek apakah user sudah login dan levelnya sesuai
if (!isset($_SESSION['level']) || $_SESSION['level'] != 'Dinas Lingkungan Hidup') {
    header('Location: login.php');
    exit();
}

// Menangkap filter (jika ada)
$start_date = isset($_POST['start_date']) ? $_POST['start_date'] : '';
$end_date = isset($_POST['end_date']) ? $_POST['end_date'] : '';

// Query SQL untuk mengambil data distribusi sampah
$query = "
    SELECT 
        s.id_setor, 
        s.tanggal_setor, 
        s.nin, 
        n.nama AS nama_nasabah, 
        s.jenis_sampah, 
        s.berat, 
        s.harga, 
        s.total, 
        s.nia, 
        s.status_pengolahan, 
        s.status_distribusi, 
        s.catatan_distribusi, 
        s.pihak_bertanggung_jawab, 
        s.tujuan_distribusi, 
        s.tanggal_update, 
        sa.kategori, 
        sa.satuan, 
        sa.gambar, 
        sa.deskripsi
    FROM 
        setor s
    JOIN 
        sampah sa ON s.jenis_sampah = sa.jenis_sampah
    JOIN 
        nasabah n ON s.nin = n.nin
";

// Tambahkan filter jika ada tanggal
if ($start_date && $end_date) {
    $query .= " WHERE s.tanggal_setor BETWEEN '$start_date' AND '$end_date'";
}

// Eksekusi query
$result = mysqli_query($conn, $query);

// Cek jika query berhasil
if (!$result) {
    die('Error: ' . mysqli_error($conn));
}

// Menyiapkan konten HTML untuk laporan
$html = '<h2 style="text-align: center; font-size: 18px;">Data Distribusi Bank Sampah Mandiri Kelurahan Kayu Putih - Jakarta Timur</h2>';
$html .= '<table border="1" cellpadding="5" cellspacing="0" style="font-size: 10px; width: 100%;">';
$html .= '<thead><tr>
            <th>ID Setor</th>
            <th>Tanggal Setor</th>
            <th>Nama Nasabah</th>
            <th>Jenis Sampah</th>
            <th>Berat (kg)</th>
            <th>Harga</th>
            <th>Total</th>
            <th>NIA</th>
            <th>Status Pengolahan</th>
            <th>Status Distribusi</th>
            <th>Catatan Distribusi</th>
            <th>Pihak Bertanggung Jawab</th>
            <th>Tujuan Distribusi</th>
            <th>Tanggal Update</th>
            <th>Kategori</th>
            <th>Satuan</th>
            <th>Gambar</th>
            <th>Deskripsi</th>
          </tr></thead>';
$html .= '<tbody>';

while ($row = mysqli_fetch_assoc($result)) {
    $html .= '<tr>';
    $html .= '<td>' . $row['id_setor'] . '</td>';
    $html .= '<td>' . $row['tanggal_setor'] . '</td>';
    $html .= '<td>' . $row['nama_nasabah'] . '</td>';
    $html .= '<td>' . $row['jenis_sampah'] . '</td>';
    $html .= '<td>' . $row['berat'] . '</td>';
    $html .= '<td>' . $row['harga'] . '</td>';
    $html .= '<td>' . $row['total'] . '</td>';
    $html .= '<td>' . $row['nia'] . '</td>';
    $html .= '<td>' . $row['status_pengolahan'] . '</td>';
    $html .= '<td>' . $row['status_distribusi'] . '</td>';
    $html .= '<td>' . $row['catatan_distribusi'] . '</td>';
    $html .= '<td>' . $row['pihak_bertanggung_jawab'] . '</td>';
    $html .= '<td>' . $row['tujuan_distribusi'] . '</td>';
    $html .= '<td>' . $row['tanggal_update'] . '</td>';
    $html .= '<td>' . $row['kategori'] . '</td>';
    $html .= '<td>' . $row['satuan'] . '</td>';
    $html .= '<td><img src="' . $row['gambar'] . '" alt="Gambar Sampah" style="width: 40px; height: auto;"></td>';
    $html .= '<td>' . $row['deskripsi'] . '</td>';
    $html .= '</tr>';
}

$html .= '</tbody>';
$html .= '</table>';

// Tambahkan tanda tangan dan waktu laporan
$html .= '<div class="ttd" style="text-align: center; margin-top: 30px;">
            <p>Mengetahui,</p>
            <br>
            <div class="line" style="width: 200px; border-top: 1px solid black; margin: 0 auto;"></div>
            <p>Dinas Lingkungan Hidup Jakarta</p>
          </div>';

$html .= '<p class="date" align="center" style="margin-top: 20px;">Waktu Laporan: ' . date('d-m-Y H:i:s') . '</p>';

// Inisialisasi objek DOMPDF
$options = new Options();
$options->set('isHtml5ParserEnabled', true);
$options->set('isPhpEnabled', true);
$dompdf = new Dompdf($options);

// Muat HTML ke dalam DOMPDF
$dompdf->loadHtml($html);

// Render PDF (termasuk ukuran halaman dan orientasi)
$dompdf->setPaper('A4', 'landscape'); // bisa diganti ke 'portrait' jika perlu
$dompdf->render();

// Output PDF ke browser
$dompdf->stream('laporan_distribusi_sampah.pdf', array("Attachment" => 0)); // Set Attachment ke 0 untuk membuka PDF di browser
?>
