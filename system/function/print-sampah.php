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
            padding: 15px 13px;
            font-weight: 300;
        }
        img {
            width: 100px;
            height: 50px;
        }
    </style>
</head>
<body>

<h1 align="center">LAPORAN DATA SAMPAH</h1>
<table align="center" cellspacing="0">
    <thead>
        <tr>
            <th>JENIS SAMPAH</th>
            <th>SATUAN</th>
            <th>HARGA</th>
            <th>GAMBAR</th>
            <th>DESKRIPSI</th>
        </tr>
    </thead>
    <tbody>
    <?php
    // Load file koneksi.php
    require_once ('../config/koneksi.php');
    
    $query = "SELECT * FROM sampah"; // Tampilkan semua data sampah
    $sql = mysqli_query($conn, $query); // Eksekusi/Jalankan query dari variabel $query
    
    while ($data = mysqli_fetch_array($sql)) { // Ambil semua data dari hasil eksekusi $sql 
        ?>
        <tr align="center">
            <td><?php echo $data['jenis_sampah'] ?></td>
            <td><?php echo $data['satuan'] ?></td>
            <td><?php echo "Rp. " . number_format($data['harga'], 2, ",", ".") ?></td>
            <td><img src="../../asset/internal/img/uploads/<?php echo $data['gambar'] ?>" alt="Gambar Sampah"></td>
            <td><?php echo $data['deskripsi'] ?></td>
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
$filename = "Data-Sampah-(" . date('d-m-Y') . ").pdf";
$dompdf->stream($filename, ["Attachment" => true]);
?>
