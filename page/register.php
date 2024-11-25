<?php
// Mulai session
session_start();

// Menghubungkan ke database
include('../system/config/koneksi.php'); // Pastikan path ke koneksi benar

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Ambil data dari form
    $username = mysqli_real_escape_string($conn, $_POST['user']);
    $name = mysqli_real_escape_string($conn, $_POST['name']); // Ambil nama admin dari form
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $password = mysqli_real_escape_string($conn, $_POST['pass']);
    $confirm_password = mysqli_real_escape_string($conn, $_POST['confirm_pass']);
    $phone = mysqli_real_escape_string($conn, $_POST['phone']); // Ambil nomor telepon dari form

    // Validasi password dan confirm password
    if ($password != $confirm_password) {
        $error = "Password dan Konfirmasi Password tidak cocok!";
    } else {
        // Cek apakah username sudah ada di database
        $check_username = mysqli_query($conn, "SELECT * FROM admin WHERE nia='$username'");
        if (mysqli_num_rows($check_username) > 0) {
            $error = "Username sudah terdaftar!";
        } else {
            // Enkripsi password
            $hashed_password = password_hash($password, PASSWORD_DEFAULT);

            // Simpan data ke tabel admin (sesuaikan dengan kolom di tabel)
            $query = "INSERT INTO admin (nia, nama, email, password, telepon, level) VALUES ('$username', '$name', '$email', '$hashed_password', '$phone', 'admin')";
            $insert = mysqli_query($conn, $query);

            if ($insert) {
                // Jika pendaftaran berhasil, tampilkan SweetAlert dan redirect ke login.php
                echo "<script>
                    setTimeout(function() {
                        Swal.fire({
                            title: 'Berhasil!',
                            text: 'Pendaftaran berhasil!',
                            icon: 'success',
                            confirmButtonText: 'OK'
                        }).then(function() {
                            window.location = 'login.php';
                        });
                    }, 500);
                </script>";
            } else {
                $error = "Terjadi kesalahan saat menyimpan data!";
            }
        }
    }
}
?>

<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <title>Register</title>
    <link rel="stylesheet" href="../asset/internal/css/style_1.css"> <!-- Sama dengan login.php -->
    <link href="https://fonts.googleapis.com/css?family=Montserrat|Raleway:700" rel="stylesheet">
    <link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet">
	<link rel="shortcut icon" href="../asset/internal/img/img-local/favicon.ico">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script> <!-- SweetAlert2 -->
</head>

<body>
    <div class="loginBox"> <!-- Sama dengan login.php -->
        <h1>DAFTAR DISINI</h1>
        <?php if (isset($error)): ?>
            <p style="color: red;"><?php echo $error; ?></p>
        <?php endif; ?>
        <form action="register.php" method="post">
            <div class="inputBox">
                <input type="text" name="user" autocomplete="off" placeholder="Masukan nomor induk" required>
                <span><i class="fa fa-user" aria-hidden="true"></i></span>
            </div>
            <div class="inputBox">
                <input type="text" name="name" autocomplete="off" placeholder="Masukan nama admin" required> <!-- Input Nama Admin -->
                <span><i class="fa fa-user" aria-hidden="true"></i></span>
            </div>
            <div class="inputBox">
                <input type="email" name="email" autocomplete="off" placeholder="Masukan email" required>
                <span><i class="fa fa-envelope" aria-hidden="true"></i></span>
            </div>
            <div class="inputBox">
                <input type="text" name="phone" autocomplete="off" placeholder="Masukan nomor telepon" required> <!-- Input Nomor Telepon -->
                <span><i class="fa fa-phone" aria-hidden="true"></i></span>
            </div>
            <div class="inputBox">
                <input type="password" name="pass" autocomplete="off" placeholder="Masukan password" required>
                <span><i class="fa fa-lock" aria-hidden="true"></i></span>
            </div>
            <div class="inputBox">
                <input type="password" name="confirm_pass" autocomplete="off" placeholder="Konfirmasi password" required>
                <span><i class="fa fa-lock" aria-hidden="true"></i></span>
            </div>
            <input type="submit" name="register" value="Daftar">
        </form>
        <a href="login.php">Sudah punya akun? Masuk disini</a>
    </div>
</body>

</html>
