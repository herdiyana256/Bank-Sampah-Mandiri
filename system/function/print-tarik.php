<?php
require '../../vendor/autoload.php'; // Sesuaikan jalur ini
use Dompdf\Dompdf;

// Mulai output buffering
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
        }
        tr:nth-child(even) {
            background: #e8eeef;
        }
        th, td {
            text-align: center;
            padding: 15px 20px;
            font-weight: 300;
        }
    </style>
</head>
<body>
<h1 align="center">DATA PENARIKAN SALDO</h1>
<table align="center" cellspacing="0">
    <thead>
        <tr>
            <th>NO</th>
            <th>ID</th>
            <th>TANGGAL TARIK</th>
            <th>NIN</th>
            <th>SALDO</th>
            <th>JUMLAH TARIK</th>
            <th>NIA</th>
        </tr>
    </thead>
    <tbody>
    <?php
    // Load file koneksi.php
    require_once ('../config/koneksi.php');

    $query = "SELECT * FROM tarik"; 
    $sql = mysqli_query($conn, $query); 

    $no = 0;
    while($data = mysqli_fetch_array($sql)) {
        $no++;
        ?>
        <tr>
            <td><?php echo $no; ?></td>
            <td><?php echo $data['id_tarik']; ?></td>
            <td><?php echo $data['tanggal_tarik']; ?></td>
            <td><?php echo $data['nin']; ?></td>
            <td><?php echo "Rp. " . number_format($data['saldo'], 2, ",", "."); ?></td>
            <td><?php echo "Rp. " . number_format($data['jumlah_tarik'], 2, ",", "."); ?></td>
            <td><?php echo $data['nia']; ?></td>
        </tr>
        <?php 
    } 
    ?>
    </tbody>
</table>
</body>
</html>

<?php
// Ambil konten dan bersihkan buffer
$html = ob_get_clean();

// Inisialisasi Dompdf
$dompdf = new Dompdf();
$dompdf->loadHtml($html);
$dompdf->setPaper('A4', 'portrait');
$dompdf->render();

// Output PDF ke browser
$filename = "Data-Tarik-(" . date('d-m-Y') . ").pdf";
$dompdf->stream($filename, ['Attachment' => true]);
?>
