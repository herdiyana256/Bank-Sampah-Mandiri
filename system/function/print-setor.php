<?php
// Memuat autoloader Dompdf
require '../../vendor/autoload.php'; // Sesuaikan path ke lokasi Dompdf

use Dompdf\Dompdf;

// Mulai output buffering
ob_start();
?>
<html>
<head>
  <title>Cetak PDF</title>
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
        padding: 7px;
        font-weight: 300;
      }
  </style>
</head>
<body>

<h1 align="center">DATA PENYETORAN SAMPAH</h1>
<table align="center" cellspacing="0">
<thead>
<tr>
  <th>NO</th>
  <th>ID</th>
  <th>TANGGAL SETOR</th>
  <th>NIN</th>
  <th>JENIS SAMPAH</th>
  <th>BERAT</th>
  <th>HARGA</th>
  <th>TOTAL</th>
  <th>NIA</th>
</tr>
</thead>
<tbody>
<?php
// Load file koneksi.php
require_once('../config/koneksi.php');

// Query untuk mengambil data dari tabel 'setor'
$query = "SELECT * FROM setor";
$sql = mysqli_query($conn, $query);

$no = 0;
while($data = mysqli_fetch_array($sql)) {
    $no++;
    ?>
    <tr>
        <td><?php echo $no; ?></td>
        <td><?php echo htmlspecialchars($data['id_setor']); ?></td>
        <td><?php echo htmlspecialchars($data['tanggal_setor']); ?></td>
        <td><?php echo htmlspecialchars($data['nin']); ?></td>
        <td><?php echo htmlspecialchars($data['jenis_sampah']); ?></td>
        <td><?php echo number_format($data['berat'], 2) . " Kg"; ?></td>
        <td><?php echo "Rp. " . number_format($data['harga'], 2, ",", "."); ?></td>
        <td><?php echo "Rp. " . number_format($data['total'], 2, ",", "."); ?></td>
        <td><?php echo htmlspecialchars($data['nia']); ?></td>
    </tr>
    <?php
}
?>
</tbody>
</table>
</body>
</html>

<?php
// Ambil konten dari buffer
$html = ob_get_clean();

// Inisialisasi Dompdf
$dompdf = new Dompdf();

// Muat konten HTML ke Dompdf
$dompdf->loadHtml($html);

// Set ukuran kertas dan orientasi
$dompdf->setPaper('A4', 'portrait');

// Render HTML sebagai PDF
$dompdf->render();

// Nama file yang akan diunduh
$filename = "Data-Setor-(" . date('d-m-Y') . ").pdf";

// Output file PDF ke browser
$dompdf->stream($filename, ['Attachment' => 1]); // Mengatur Attachment menjadi 1 untuk langsung mendownload
?>
