<?php 
require_once ('../config/koneksi.php');

// Mengatur header untuk mengunduh file Excel
header("Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet");
header("Content-Disposition: attachment; filename=\"excel-admin (".date('d-m-Y').").xls\"");
header("Cache-Control: max-age=0");

// Memulai output HTML
echo "<h2 style='font-size: 30px; color: #262626;'>Data Administrator</h2>";
echo "<br>";
echo "<table border='1' cellspacing='0' cellpadding='5'>";
echo "<tr>
        <th>No</th>
        <th>NIA</th>
        <th>Nama Admin</th>
        <th>Nomor Telepon</th>
        <th>Username</th>
        <th>Password</th>
        <th>Level</th>
      </tr>";

$no = 0;
$query = mysqli_query($conn, "SELECT * FROM admin ORDER BY nia ASC");
while ($row = mysqli_fetch_assoc($query)) {
    $no++;
    echo "<tr align='center'>
            <td>{$no}</td>
            <td>{$row['nia']}</td>
            <td>{$row['nama']}</td>
            <td>{$row['telepon']}</td>
            <td>{$row['username']}</td>
            <td>{$row['password']}</td>
            <td>{$row['level']}</td>
          </tr>";
}

echo "</table>";
?>
