<?php
require_once("../system/config/koneksi.php");

// Fungsi untuk mendapatkan NIA baru dengan pilihan default
function getNewNIA($conn, $level) {
    if ($level === 'Dinas Lingkungan Hidup') {
        return "DLH-Jakarta" . date("Y");  // Format khusus untuk Dinas Lingkungan Hidup
    }

    // Ambil NIA terakhir dari database untuk level lainnya
    $no = mysqli_query($conn, "SELECT nia FROM admin ORDER BY nia DESC LIMIT 1");
    $nia = mysqli_fetch_array($no);
    $kode = isset($nia['nia']) ? $nia['nia'] : null;

    // Jika belum ada admin sama sekali
    if (!$kode) {
        return "ADM" . date("y") . date("m") . "000";
    }

    // Ambil urutan terakhir dari NIA dan tambahkan 1
    $urut = substr($kode, 7); // Ambil bagian urutan dari NIA
    $tambah = (int)$urut + 1; // Tambah urutan
    $thn = date("y");
    $bln = date("m");

    // Format NIA baru (dengan urutan hingga 3 digit)
    return "ADM" . $thn . $bln . str_pad($tambah, 3, "0", STR_PAD_LEFT);
}

// Mendapatkan NIA default berdasarkan level yang dipilih
$level = isset($_POST['level']) ? $_POST['level'] : '';
$niaDefault = getNewNIA($conn, $level);
$niaInput = $niaDefault; // Default NIA yang ditampilkan di form

// Menangani penyimpanan data
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['simpan'])) {
    // Ambil data dari form
    $nia = $_POST['nia'];
    $nama = $_POST['nama'];
    $telepon = $_POST['telepon'];
    $email = $_POST['email'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT); // Enkripsi password
    $level = $_POST['level'];

    // Cek apakah NIA sudah terdaftar
    $sql = mysqli_query($conn, "SELECT * FROM admin WHERE nia = '$nia'");

    // Jika NIA sudah ada, tampilkan pesan error
    if (mysqli_num_rows($sql) > 0) {
        echo "<script>alert('Maaf, NIA sudah terdaftar! Silakan gunakan NIA lain.');</script>";
        echo "<meta http-equiv='refresh' content='0; url=http://localhost/bank_sampah/page/admin.php?page=data-admin-full'>";
        exit; // Gunakan exit untuk menghentikan eksekusi lebih lanjut
    }

    // Insert data admin baru ke database menggunakan prepared statements
    $insert_query = $conn->prepare("INSERT INTO admin (nia, nama, telepon, email, password, level) VALUES (?, ?, ?, ?, ?, ?)");
    $insert_query->bind_param("ssssss", $nia, $nama, $telepon, $email, $password, $level);

    if ($insert_query->execute()) {
        echo "<script>alert('Selamat, data berhasil diinput!');</script>";
    } else {
        echo "<script>alert('Gagal menambahkan data: " . $insert_query->error . "');</script>";
    }

    echo "<meta http-equiv='refresh' content='0; url=http://localhost/bank_sampah/page/admin.php?page=data-admin-full'>";
    $insert_query->close();
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Tambah Administrator</title>
    <style>
        label {
            font-family: Montserrat, sans-serif;
            font-size: 18px;
            display: block;
            color: #262626;
        }
        input[type=text], input[type=password], select {
            border-radius: 5px;
            width: 40%;
            height: 35px;
            background: #eee;
            padding: 0 10px;
            box-shadow: 1px 2px 2px 1px #ccc;
            color: #262626;
            margin-bottom: 10px;
        }
        input[type=submit] {
            height: 35px;
            width: 200px;
            background: #8cd91a;
            border-radius: 20px;
            color: #fff;
            margin-top: 20px;
            cursor: pointer;
        }
        input, select {
            font-family: Montserrat, sans-serif;
            font-size: 16px;
        }
    </style>
    <script type="text/javascript">
        function cek_data() {
            var nama = document.forms["daftar_user"]["nama"].value;
            if (nama === "") {
                alert("Maaf, harap input nama admin!");
                document.forms["daftar_user"]["nama"].focus();
                return false;
            }

            var telepon = document.forms["daftar_user"]["telepon"].value;
            var angka = /^[0-9]+$/;
            if (telepon === "") {
                alert("Maaf, harap input nomor telepon!");
                document.forms["daftar_user"]["telepon"].focus();
                return false;
            }
            if (!telepon.match(angka)) {
                alert("Maaf, nomor telepon harus di input angka!");
                document.forms["daftar_user"]["telepon"].focus();
                return false;
            }
            if (telepon.length !== 12) {
                alert("Nomor telepon harus 12 karakter!");
                document.forms["daftar_user"]["telepon"].focus();
                return false;
            }

            var email = document.forms["daftar_user"]["email"].value;
            var cek_email = /^[a-zA-Z0-9._-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,4}$/;
            if (email === "") {
                alert("Maaf, harap input email!");
                document.forms["daftar_user"]["email"].focus();
                return false;
            }
            if (!email.match(cek_email)) {
                alert("Format penulisan email tidak sesuai!");
                document.forms["daftar_user"]["email"].focus();
                return false;
            }

            var password = document.forms["daftar_user"]["password"].value;
            if (password === "") {
                alert("Maaf, harap input password!");
                document.forms["daftar_user"]["password"].focus();
                return false;
            }
            if (password.length < 6 || password.length > 20) {
                alert("Password harus minimum 6 karakter dan maksimum 20 karakter!");
                document.forms["daftar_user"]["password"].focus();
                return false;
            }

            var level = document.forms["daftar_user"]["level"].value;
            if (level === "p") {
                alert("Maaf, harap input level admin!");
                return false;
            }

            return confirm("Apakah Anda yakin sudah input data dengan benar?");
        }
    </script>
</head>
<body>
    <h2 style="font-size: 30px; color: #262626;">Tambah Data Administrator</h2>
    <form id="daftar_user" name="daftar_user" action="" method="post" onsubmit="return cek_data()">
        <div>
            <label>Nomor Induk Admin</label>
            <input style="cursor: text;" type="text" name="nia" value="<?php echo htmlspecialchars($niaInput); ?>" required readonly />
        </div>
        <div>
            <label>Nama Admin</label>
            <input type="text" name="nama" placeholder="Masukan nama admin" required />
        </div>
        <div>
            <label>Nomor Telepon</label>
            <input type="text" placeholder="Masukan nomor telepon" name="telepon" required />
        </div>
        <div>
            <label>E-mail</label>
            <input type="text" placeholder="Masukan alamat email" name="email" required />
        </div>
        <div>
            <label>Password</label>
            <input type="password" placeholder="Masukan password" name="password" required />
        </div>
        <div>
            <label>Level</label>
            <select name="level" required>
                <option value="p">---Pilih Level---</option>
                <option value="Master-admin">Master-admin</option>
                <option value="Dinas Lingkungan Hidup">Dinas Lingkungan Hidup</option>
                <option value="admin">Admin</option>
            </select>
        </div>
        <input type="submit" name="simpan" value="Simpan" />
    </form>
</body>
</html>
