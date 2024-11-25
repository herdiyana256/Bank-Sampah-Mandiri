<?php
session_start();
include '../system/config/koneksi.php';

// Pastikan user sudah login dan memiliki level yang sesuai
if (!isset($_SESSION['level']) || $_SESSION['level'] != 'Dinas Lingkungan Hidup') {
    header('Location: login.php');
    exit();
}

// Periksa apakah data yang diperlukan dikirim
if (isset($_POST['id_setor']) && isset($_POST['status_distribusi']) && isset($_POST['catatan_distribusi']) && isset($_POST['pihak_bertanggung_jawab']) && isset($_POST['tujuan_distribusi'])) {
    $id_setor = $_POST['id_setor'];
    $status_distribusi = $_POST['status_distribusi'];
    $catatan_distribusi = $_POST['catatan_distribusi'];
    $pihak_bertanggung_jawab = $_POST['pihak_bertanggung_jawab'];
    $tujuan_distribusi = $_POST['tujuan_distribusi'];

    // Query untuk memperbarui status distribusi dan kolom lainnya
    $query = "UPDATE setor 
              SET 
                  status_distribusi = '$status_distribusi', 
                  catatan_distribusi = '$catatan_distribusi', 
                  pihak_bertanggung_jawab = '$pihak_bertanggung_jawab', 
                  tujuan_distribusi = '$tujuan_distribusi' 
              WHERE id_setor = $id_setor";

    if (mysqli_query($conn, $query)) {
        // Redirect ke halaman data distribusi jika update berhasil
        header('Location: status-distribusi-sampah.php');
        exit();
    } else {
        echo "Error: " . mysqli_error($conn);
    }
} else {
    echo "Data tidak lengkap!";
}
?>
