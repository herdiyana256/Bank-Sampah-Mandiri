<?php
require '../../vendor/autoload.php'; // Sesuaikan path ini
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
<h1 align="center">LAPORAN DATA ADMINISTRATOR</h1>
<table align="center" cellspacing="0">
    <thead>
        <tr>
            <th>NIA</th>
            <th>NAMA</th>
            <th>TELEPON</th>
            <th>E-MAIL</th>
            <th>LEVEL</th>
        </tr>
    </thead>
    <tbody>
    <?php
    // Load file koneksi.php
    require_once ('../config/koneksi.php');

    $query = "SELECT * FROM admin"; // Tampilkan semua data admin
    $sql = mysqli_query($conn, $query); // Eksekusi query
    while ($data = mysqli_fetch_array($sql)) { // Ambil semua data
        ?>
        <tr>
            <td><?php echo htmlspecialchars($data['nia']) ?></td>
            <td><?php echo htmlspecialchars($data['nama']) ?></td>
            <td><?php echo htmlspecialchars($data['telepon']) ?></td>
            <td><?php echo htmlspecialchars($data['email']) ?></td>
            <td><?php echo htmlspecialchars($data['level']) ?></td>
        </tr>
    <?php } ?>
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
$filename = "Data-Admin-(" . date('d-m-Y') . ").pdf";
$dompdf->stream($filename, ['Attachment' => true]);
?>
