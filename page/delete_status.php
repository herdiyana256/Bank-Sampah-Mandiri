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

// Pastikan id_setor ada dalam POST
if (isset($_POST['id_setor'])) {
    // Ambil id_setor dari POST
    $id_setor = $_POST['id_setor'];

    // Query untuk menghapus data
    $query = "DELETE FROM setor WHERE id_setor = '$id_setor'";

    // Eksekusi query
    if (mysqli_query($conn, $query)) {
        // Jika berhasil, redirect kembali ke halaman utama dengan pesan sukses
        $_SESSION['message'] = 'Status pengolahan berhasil dihapus.';
        header('Location: rekapitulasi_sampah.php');
        exit();
    } else {
        // Jika gagal, beri pesan error
        $_SESSION['message'] = 'Gagal menghapus status pengolahan: ' . mysqli_error($conn);
        header('Location: rekapitulasi_sampah.php');
        exit();
    }
} else {
    // Jika tidak ada id_setor di POST, redirect ke halaman utama
    header('Location: rekapitulasi_sampah.php');
    exit();
}
?>
