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

// Pastikan id_setor dan status_pengolahan ada dalam POST
if (isset($_POST['id_setor']) && isset($_POST['status_pengolahan'])) {
    // Ambil id_setor dan status_pengolahan dari POST
    $id_setor = $_POST['id_setor'];
    $status_pengolahan = $_POST['status_pengolahan'];

    // Query untuk mengupdate status pengolahan
    $query = "UPDATE setor SET status_pengolahan = '$status_pengolahan' WHERE id_setor = '$id_setor'";

    // Eksekusi query
    if (mysqli_query($conn, $query)) {
        // Jika berhasil, redirect kembali ke halaman utama dengan pesan sukses
        $_SESSION['message'] = 'Status pengolahan berhasil diperbarui.';
        header('Location: rekapitulasi_sampah.php');
        exit();
    } else {
        // Jika gagal, beri pesan error
        $_SESSION['message'] = 'Gagal memperbarui status pengolahan: ' . mysqli_error($conn);
        header('Location: rekapitulasi_sampah.php');
        exit();
    }
} else {
    // Jika id_setor atau status_pengolahan tidak ada di POST, redirect ke halaman utama
    header('Location: rekapitulasi_sampah.php');
    exit();
}
?>
