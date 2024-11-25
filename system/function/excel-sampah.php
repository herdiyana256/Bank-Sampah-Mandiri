<?php 
require_once ('../config/koneksi.php');

// Fungsi header untuk mengirimkan raw data Excel
header("Content-Type: application/vnd.ms-excel");
header("Content-Disposition: attachment; filename=excel-sampah (" . date('d-m-Y') . ").xls");
header("Pragma: no-cache");
header("Expires: 0");
?>

<h2 style="font-size: 30px; color: #262626;">Data Sampah</h2>
<br>
<table border="1" cellspacing="0" width="100%">
    <tr>
        <th>No</th>
        <th>Jenis Sampah</th>
        <th>Satuan</th>
        <th>Harga</th>
        <th>Deskripsi</th>
    </tr>
    <?php
    $no = 0;
    $query = mysqli_query($conn, "SELECT * FROM sampah ORDER BY jenis_sampah ASC");
    while ($row = mysqli_fetch_assoc($query)) {
        $no++;
    ?>
        <tr align="center">
            <td><?php echo $no; ?></td>
            <td><?php echo htmlspecialchars($row['jenis_sampah']); ?></td>
            <td><?php echo htmlspecialchars($row['satuan']); ?></td>
            <td><?php echo "Rp. " . number_format($row['harga'], 2, ",", "."); ?></td>
            <td><?php echo htmlspecialchars($row['deskripsi']); ?></td>
        </tr>
    <?php 
    } 
    ?>
</table>
