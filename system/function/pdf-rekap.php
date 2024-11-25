<?php
require_once('../config/koneksi.php');  // Pastikan path ini benar
require '../../vendor/autoload.php';  // Pastikan path ini benar juga

use Dompdf\Dompdf;

// Debugging: Cek apakah koneksi berhasil
if (!$conn) {
    die("Koneksi gagal: " . mysqli_connect_error());
}

// Ambil parameter dari URL
$start_date = isset($_GET['start_date']) ? $_GET['start_date'] : '';
$end_date = isset($_GET['end_date']) ? $_GET['end_date'] : '';
$status = isset($_GET['status']) ? $_GET['status'] : '';

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

// Mulai output buffering
ob_start();
?>
<html>
<head>
    <title>Cetak PDF</title>
    <style>
        h1 {
            color: #262626;
            display: inline-block;
        }
        .date {
            font-size: 14px;
            margin-left: 20px;
            font-weight: normal;
        }
        table {
            max-width: 100%;
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
        .ttd {
            margin-top: 30px;
            text-align: right;
        }
        .line {
            border-top: 1px solid #000;
            margin-top: 20px;
            width: 200px;
            display: inline-block;
        }
    </style>
</head>
<body>
    <h1 align="center">LAPORAN REKAPITULASI SAMPAH</h1>
    <p class="date" align="center">Waktu Laporan: <?php echo date('d-m-Y H:i:s'); ?></p>

    <table align="center" cellspacing="0">
        <thead>
            <tr>
                <th>Nomor Transaksi</th>
                <th>Nama Nasabah</th>
                <th>RT</th>
                <th>Alamat</th>
                <th>Jenis Sampah</th>
                <th>Berat Sampah (KG)</th>
                <th>Harga (Rp)</th>
                <th>Total (Rp)</th>
                <th>Tanggal Setor</th>
                <th>Status Pengolahan</th>
            </tr>
        </thead>
        <tbody>
        <?php
        // Menambahkan data dari hasil query ke spreadsheet
        while ($row = mysqli_fetch_assoc($result)) {
            ?>
            <tr>
                <td><?php echo htmlspecialchars($row['id_setor']); ?></td>
                <td><?php echo htmlspecialchars($row['nama']); ?></td>
                <td><?php echo htmlspecialchars($row['rt']); ?></td>
                <td><?php echo htmlspecialchars($row['alamat']); ?></td>
                <td><?php echo htmlspecialchars($row['jenis_sampah']); ?></td>
                <td><?php echo htmlspecialchars($row['berat']); ?></td>
                <td><?php echo htmlspecialchars($row['harga']); ?></td>
                <td><?php echo htmlspecialchars($row['total']); ?></td>
                <td><?php echo htmlspecialchars($row['tanggal_setor']); ?></td>
                <td><?php echo htmlspecialchars($row['status_pengolahan']); ?></td>
            </tr>
        <?php } ?>
        </tbody>
    </table>

    <div class="ttd">
        <p>Mengetahui,</p>
        <div class="line"></div>
        <p>Dinas Lingkungan Hidup Jakarta</p>
    </div>
</body>
</html>

<?php
// Ambil konten dan bersihkan buffer
$html = ob_get_clean();

// Inisialisasi Dompdf
$dompdf = new Dompdf();
$dompdf->loadHtml($html);
$dompdf->setPaper('A4', 'landscape');
$dompdf->render();

// Output PDF ke browser
$filename = "Laporan-Rekapitulasi-Sampah-" . date('d-m-Y') . ".pdf";
$dompdf->stream($filename, ['Attachment' => true]);
exit;
?>
