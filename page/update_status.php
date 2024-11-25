<?php
// Mulai sesi
session_start();
include '../system/config/koneksi.php';

// Cek apakah data yang dibutuhkan ada
if (isset($_POST['status_pengolahan']) && isset($_POST['id_setor'])) {
    // Mengambil data yang di-post
    $status_pengolahan = mysqli_real_escape_string($conn, $_POST['status_pengolahan']);
    $id_setor = intval($_POST['id_setor']);
    
    // Mengecek apakah tanggal update di-post
    // Jika ada, gunakan tanggal yang dipilih; jika tidak, gunakan tanggal saat ini
    $tanggal_update = isset($_POST['tanggal_update']) && $_POST['tanggal_update'] != '' 
                        ? mysqli_real_escape_string($conn, $_POST['tanggal_update']) 
                        : date('Y-m-d'); // Gunakan tanggal saat ini jika tidak ada tanggal yang dipilih
    
    // Menyiapkan query untuk memperbarui status_pengolahan dan tanggal_update
    $query = "UPDATE setor SET status_pengolahan = '$status_pengolahan', tanggal_update = '$tanggal_update' WHERE id_setor = $id_setor";

    // Menjalankan query
    if (mysqli_query($conn, $query)) {
        // Jika berhasil, kembali ke halaman rekapitulasi
        header('Location: rekapitulasi-sampah.php');
        exit();
    } else {
        // Jika terjadi kesalahan, tampilkan pesan error
        echo "Error: " . mysqli_error($conn);
    }
} else {
    echo "Data tidak lengkap!";
}
?>
