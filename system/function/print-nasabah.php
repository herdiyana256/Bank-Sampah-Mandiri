<?php 
// Memulai output buffering
ob_start(); 
?>
<html>
<head>
    <title>Cetak PDF</title>
    <link rel="shortcut icon" href="../../asset/internal/img/img-local/favicon.ico">
    <style>
        h1 {
            color: #262626;
        }
        table {
            max-width: 960px;
            margin: 10px auto;
            border-collapse: collapse;
        }
        thead th {
            font-weight: 400;
            background: #8a97a0;
            color: #FFF;
        }
        tr {
            background: #f4f7f8;
            border-bottom: 1px solid #FFF;
            margin-bottom: 5px;
        }
        tr:nth-child(even) {
            background: #e8eeef;
        }
        th, td {
            text-align: center;
            padding: 15px 10px;
            font-weight: 300;
        }
    </style>
</head>
<body>
  
<h1 align="center">LAPORAN DATA NASABAH</h1>
<table align="center" cellspacing="0">
    <thead>
        <tr>
            <th>NIN</th>
            <th>NAMA</th>
            <th>ALAMAT</th>
            <th>TELEPON</th>
            <th>USERNAME</th>
            <th>SALDO</th>
            <th>BERAT</th>
        </tr>
    </thead>
    <tbody>
    <?php
    // Load file koneksi.php
    require_once ('../config/koneksi.php');

    $query = "SELECT * FROM nasabah"; // Tampilkan semua data nasabah
    $sql = mysqli_query($conn, $query); // Eksekusi/Jalankan query dari variabel $query
    
    while ($data = mysqli_fetch_array($sql)) { // Ambil semua data dari hasil eksekusi $sql 
        ?>
        <tr>
            <td><?php echo $data['nin'] ?></td>
            <td><?php echo $data['nama'] ?></td>
            <td><?php echo $data['alamat'] ?></td>
            <td><?php echo $data['telepon'] ?></td>
            <td><?php echo $data['email'] ?></td>
            <td><?php echo "Rp. " . number_format($data['saldo'], 2, ",", ".") ?></td>
            <td><?php echo number_format($data['sampah']) . " Kg" ?></td>
        </tr>
        <?php 
    } 
    ?>
    </tbody>
</table>
</body>
</html>

<?php
$html = ob_get_contents();
ob_end_clean();

// Memasukkan file Dompdf
require_once '../../vendor/autoload.php'; // Sesuaikan dengan path ke autoload.php

use Dompdf\Dompdf;
use Dompdf\Options;

// Membuat instance Dompdf
$options = new Options();
$options->set('defaultFont', 'Arial'); // Set default font jika diperlukan
$dompdf = new Dompdf($options);

// Memuat HTML ke Dompdf
$dompdf->loadHtml($html);

// Mengatur ukuran kertas dan orientasi
$dompdf->setPaper('A4', 'portrait');

// Merender PDF
$dompdf->render();

// Mengatur nama file dan mengunduh
$filename = "Data-Nasabah-(" . date('d-m-Y') . ").pdf";
$dompdf->stream($filename, ["Attachment" => true]);
?>
