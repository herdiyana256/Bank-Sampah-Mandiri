<?php
// Mulai sesi
session_start();
include '../system/config/koneksi.php';

// Cek apakah user sudah login dan levelnya adalah "Dinas Lingkungan Hidup"
if (!isset($_SESSION['level']) || $_SESSION['level'] != 'Dinas Lingkungan Hidup') {
    // Jika tidak login atau bukan level "Dinas Lingkungan Hidup", arahkan ke login.php
    header('Location: login.php');
    exit();
}

// Menangkap tanggal periode yang dipilih (jika ada)
$start_date = isset($_POST['start_date']) ? $_POST['start_date'] : '';
$end_date = isset($_POST['end_date']) ? $_POST['end_date'] : '';

// Menangkap status pengolahan (jika ada)
$status_filter = isset($_POST['status_pengolahan']) ? $_POST['status_pengolahan'] : '';

// Menyiapkan query SQL untuk menampilkan data rekapitulasi setor sampah
$query = "SELECT setor.id_setor, nasabah.nama, nasabah.rt, nasabah.alamat, setor.jenis_sampah, setor.berat, setor.harga, setor.total, setor.tanggal_setor, setor.status_pengolahan, setor.tanggal_update
          FROM setor
          JOIN nasabah ON setor.nin = nasabah.nin
          WHERE setor.tanggal_setor BETWEEN '$start_date' AND '$end_date'";

// Jika status pengolahan dipilih, tambahkan filter pada query
if ($status_filter && $status_filter != 'All') {
    $query .= " AND setor.status_pengolahan = '$status_filter'";
}

// Jalankan query
$result = mysqli_query($conn, $query);

// Memastikan jika query berhasil
if (!$result) {
    die('Error: ' . mysqli_error($conn));
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Rekapitulasi Sampah</title>
    <link rel="stylesheet" href="../datatables/css/jquery.dataTables.min.css">
    <link rel="stylesheet" href="https://code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
    <style>
        body {
            font-family: Arial, sans-serif;
        }

        h2 {
            font-size: 30px;
            color: #262626;
        }

        label {
            font-family: Montserrat;
            font-size: 18px;
            display: block;
            color: #262626;
        }

        button {
            margin: 5px;
            padding: 10px;
            background-color: #4CAF50;
            color: white;
            border: none;
            cursor: pointer;
            border-radius: 5px;
        }

        button:hover {
            background-color: #45a049;
        }

        /* CSS untuk logo di sebelah kanan */
        .logo-container {
            display: flex;
            justify-content: flex-end;
            align-items: center;
            margin-bottom: 10px; /* Memberikan jarak dari elemen atas */
        }

        .logo-container img {
            width: 150px; /* Ukuran logo */
            height: auto; /* Menjaga proporsi gambar */
            margin-left: 20px; /* Memberikan sedikit jarak antara logo dan form */
        }

        .form-container {
            display: flex;
            align-items: center;
        }

        .form-container label,
        .form-container input,
        .form-container select {
            margin-right: 10px;
        }

        .form-container input,
        .form-container select {
            margin-bottom: 0; /* Menghilangkan margin bawah pada input/select */
        }
    </style>
    
</head>
<body>

<!-- Menambahkan Logo Dinas Lingkungan Hidup di sebelah kanan -->
<!-- <div class="logo-container">
    <img src="../asset/gambar1.jpg" alt="Logo Dinas Lingkungan Hidup">
</div> -->

<h2 >Rekapitulasi Sampah</h2>

<!-- Form Filter Periode dan Status -->
<form method="post" action="">
    <div class="form-container">
        <label for="start_date">Pilih Periode:</label>
        <input type="date" name="start_date" value="<?php echo $start_date; ?>" required>
        <input type="date" name="end_date" value="<?php echo $end_date; ?>" required>

        <label for="status_pengolahan">Pilih Status Pengolahan:</label>
        <select name="status_pengolahan">
            <option value="All" <?php echo ($status_filter == 'All' ? 'selected' : ''); ?>>All Status</option>
            <option value="Belum Diproses" <?php echo ($status_filter == 'Belum Diproses' ? 'selected' : ''); ?>>Belum Diproses</option>
            <option value="Sudah Diproses" <?php echo ($status_filter == 'Sudah Diproses' ? 'selected' : ''); ?>>Sudah Diproses</option>
            <option value="Closed" <?php echo ($status_filter == 'Closed' ? 'selected' : ''); ?>>Closed</option>
        </select>

        <button type="submit">Filter</button>
    </div>
</form>


<!-- Tombol Export -->
<a target="_blank" href="../system/function/excel-rekap.php?start_date=<?php echo $start_date; ?>&end_date=<?php echo $end_date; ?>&status=<?php echo $status_filter; ?>">
    <button><i class="fa fa-download"></i> Laporan Excel</button>
</a>

<a target="_blank" href="../system/function/pdf-rekap.php?start_date=<?php echo $start_date; ?>&end_date=<?php echo $end_date; ?>&status=<?php echo $status_filter; ?>">
    <button><i class="fa fa-download"></i>Laporan PDF</button>
</a>

<br><br>



<table id="example" class="display" cellspacing="0" width="100%" border="1">
    <thead>
        <tr>
            <th>Nomor Transaksi</th>
            <th>Nama Nasabah</th>
            <th>RT</th>
            <th>Alamat</th>
            <th>Jenis Sampah</th>
            <th>Berat Sampah (KG)</th>
            <th>Tanggal Setor</th>
            <th>Status Pengolahan</th>
            <th>Tanggal Update Status</th>
            <th>Aksi</th>
        </tr>
    </thead>
   
    <tbody>
    <?php
    // Menampilkan data rekapitulasi sampah
    while ($row = mysqli_fetch_assoc($result)) {
        echo "<tr>";
        echo "<td>" . $row['id_setor'] . "</td>";
        echo "<td>" . $row['nama'] . "</td>";
        echo "<td>" . $row['rt'] . "</td>";
        echo "<td>" . $row['alamat'] . "</td>";
        echo "<td>" . $row['jenis_sampah'] . "</td>";
        echo "<td>" . $row['berat'] . "</td>";
        echo "<td>" . $row['tanggal_setor'] . "</td>";

        // Tampilkan status pengolahan
        $status = $row['status_pengolahan'] ? $row['status_pengolahan'] : 'Belum Diproses';
        echo "<td>$status</td>";

        // Tampilkan tanggal update status dengan datepicker
        $tanggal_update = $row['tanggal_update'] ? $row['tanggal_update'] : '';
        echo "<td><input type='text' class='datepicker' name='tanggal_update' value='$tanggal_update' id='date_{$row['id_setor']}' /></td>";

        // Form untuk memilih status pengolahan
        echo "<td>
                <form method='post' action='./update_status.php'>
                    <select name='status_pengolahan' required>
                        <option value='Belum Diproses'" . ($row['status_pengolahan'] == 'Belum Diproses' ? ' selected' : '') . ">Belum Diproses</option>
                        <option value='Sudah Diproses'" . ($row['status_pengolahan'] == 'Sudah Diproses' ? ' selected' : '') . ">Sudah Diproses</option>
                        <option value='Closed'" . ($row['status_pengolahan'] == 'Closed' ? ' selected' : '') . ">Closed</option>
                    </select>
                    <input type='hidden' name='id_setor' value='" . $row['id_setor'] . "' />
                    <input type='hidden' name='tanggal_update' value='" . $row['tanggal_update'] . "' /> <!-- Menambahkan tanggal update -->
                    <button type='submit'>Update</button>
                </form>
              </td>";

        // Tombol Hapus
        echo "<td>
                <form method='post' action='delete_status.php'>
                    <input type='hidden' name='id_setor' value='" . $row['id_setor'] . "' />
                    <button type='submit'>Hapus</button>
                </form>
              </td>";
        
        echo "</tr>";
    }
    ?>
    </tbody>
</table>

<script type="text/javascript" src="../datatables/js/jquery.min.js"></script>
<script type="text/javascript" src="../datatables/js/jquery.dataTables.min.js"></script>
<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.min.js"></script>
<script>
    $(document).ready(function() {
        $('#example').DataTable();
        
        // Initialize datepicker untuk setiap input tanggal
        $('.datepicker').datepicker({
            dateFormat: 'yy-mm-dd',
            changeMonth: true,
            changeYear: true,
        });
    });
</script>

</body>
</html>
