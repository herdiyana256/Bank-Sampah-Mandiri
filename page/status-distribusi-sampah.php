<?php
// Mulai sesi
session_start();
include '../system/config/koneksi.php';

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
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Data Distribusi Sampah</title>
    <link rel="stylesheet" href="../datatables/css/jquery.dataTables.min.css">
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f9;
            color: #333;
            margin: 0;
            padding: 0;
        }
        h2 {
            font-size: 24px;
            color: #333;
            margin-bottom: 20px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }
        th, td {
            padding: 12px;
            text-align: left;
            border: 1px solid #ddd;
        }
        th {
            background-color: #f4f4f4;
        }
        form {
            margin-bottom: 20px;
            background-color: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
        }
        input[type="date"], input[type="text"], select, textarea {
            width: 100%;
            padding: 8px;
            margin: 10px 0;
            border: 1px solid #ddd;
            border-radius: 4px;
        }
        button {
            background-color: #4CAF50;
            color: white;
            padding: 10px 20px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            font-size: 16px;
        }
        button:hover {
            background-color: #45a049;
        }
        img {
            width: 50px;
            height: auto;
        }
    </style>
</head>
<body>

<h2>Data Distribusi Sampah</h2>

<!-- Form Filter -->
<form method="post" action="">
    <label for="start_date">Pilih Periode:</label>
    <input type="date" name="start_date" value="<?php echo $start_date; ?>" required>
    <input type="date" name="end_date" value="<?php echo $end_date; ?>" required>
    <button type="submit">Filter</button>
</form>

<!-- Tombol Laporan PDF -->
<a target="_blank" href="../system/function/generate_pdf.php?start_date=<?php echo urlencode($start_date); ?>&end_date=<?php echo urlencode($end_date); ?>&status=<?php echo urlencode($status_filter); ?>">
    <button><i class="fa fa-download"></i>Laporan PDF</button>
</a>



<!-- Tabel Data Distribusi Sampah -->
<table id="example" class="display">
    <thead>
        <tr>
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
        </tr>
    </thead>
    <tbody>
    <?php
    while ($row = mysqli_fetch_assoc($result)) {
        echo "<tr>";
        echo "<td>" . $row['id_setor'] . "</td>";
        echo "<td>" . $row['tanggal_setor'] . "</td>";
        echo "<td>" . $row['nama_nasabah'] . "</td>";
        echo "<td>" . $row['jenis_sampah'] . "</td>";
        echo "<td>" . $row['berat'] . "</td>";
        echo "<td>" . $row['harga'] . "</td>";
        echo "<td>" . $row['total'] . "</td>";
        echo "<td>" . $row['nia'] . "</td>";
        echo "<td>" . $row['status_pengolahan'] . "</td>";
        echo "<td>" . $row['status_distribusi'] . "</td>";
        echo "<td>" . $row['catatan_distribusi'] . "</td>";
        echo "<td>" . $row['pihak_bertanggung_jawab'] . "</td>";
        echo "<td>" . $row['tujuan_distribusi'] . "</td>";
        echo "<td>" . $row['tanggal_update'] . "</td>";
        echo "<td>" . $row['kategori'] . "</td>";
        echo "<td>" . $row['satuan'] . "</td>";
        echo "<td><img src='" . $row['gambar'] . "' alt='Gambar Sampah'></td>";
        echo "<td>" . $row['deskripsi'] . "</td>";
        
        // Form untuk memperbarui status distribusi
        echo "<td>
                <form method='post' action='update_statusd.php'>
                    <input type='hidden' name='id_setor' value='" . $row['id_setor'] . "'>
                    <select name='status_distribusi'>
                        <option value='Dalam Perjalanan'" . ($row['status_distribusi'] == 'Dalam Perjalanan' ? ' selected' : '') . ">Dalam Perjalanan</option>
                        <option value='Tiba'" . ($row['status_distribusi'] == 'Tiba' ? ' selected' : '') . ">Tiba</option>
                        <option value='Selesai'" . ($row['status_distribusi'] == 'Selesai' ? ' selected' : '') . ">Selesai</option>
                        <option value='Ditunda'" . ($row['status_distribusi'] == 'Ditunda' ? ' selected' : '') . ">Ditunda</option>
                        <option value='Bermasalah'" . ($row['status_distribusi'] == 'Bermasalah' ? ' selected' : '') . ">Bermasalah</option>
                    </select><br><br>
                    <textarea name='catatan_distribusi' placeholder='Catatan terkait distribusi'>" . $row['catatan_distribusi'] . "</textarea><br><br>
                    <input type='text' name='pihak_bertanggung_jawab' value='" . $row['pihak_bertanggung_jawab'] . "' placeholder='Nama Bank Sampah'><br><br>
                    <select name='tujuan_distribusi'>
                        <option value='Tempat Pengolahan Sampah Terpadu (TPST)' " . ($row['tujuan_distribusi'] == 'Tempat Pengolahan Sampah Terpadu (TPST)' ? ' selected' : '') . ">Tempat Pengolahan Sampah Terpadu (TPST)</option>
                        <option value='Pembuangan ke Tempat Sampah' " . ($row['tujuan_distribusi'] == 'Pembuangan ke Tempat Sampah' ? ' selected' : '') . ">Pembuangan ke Tempat Sampah</option>
                    </select><br><br>
                    <button type='submit'>Update</button>
                </form>
              </td>";
        
        echo "</tr>";
    }
    ?>
    </tbody>
</table>

<script src="../datatables/js/jquery.min.js"></script>
<script src="../datatables/js/jquery.dataTables.min.js"></script>
<script>
    $(document).ready(function() {
        $('#example').DataTable();
    });
</script>

</body>
</html>
