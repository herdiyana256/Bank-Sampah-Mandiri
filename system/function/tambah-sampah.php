<?php
if (isset($_POST['simpan'])) {
    require_once("../system/config/koneksi.php");
    $jenis_sampah = $_POST['jenis_sampah'];
    $kategori = $_POST['kategori']; // Ambil nilai kategori
    $satuan = $_POST['satuan'];
    $harga = $_POST['harga'];
    $nama_file = $_FILES['gambar']['name'];
    $source = $_FILES['gambar']['tmp_name'];
    $folder = '../asset/internal/img/uploads/';
    $deskripsi = $_POST['deskripsi'];

    move_uploaded_file($source, $folder . $nama_file);

    // Menyisipkan data kategori
    $query = mysqli_query($conn, "INSERT INTO sampah (jenis_sampah, kategori, satuan, harga, gambar, deskripsi) 
    VALUES ('$jenis_sampah', '$kategori', '$satuan', '$harga', '$nama_file', '$deskripsi')");

    if ($query) {
        echo "
            <script>
                alert('Berhasil Menambah Data!');
            </script>
        ";
        echo "<meta http-equiv='refresh' content='0; url=http://localhost/bsk09/page/admin.php?page=data-sampah'>";
    } else {
        echo "
            <script>
                alert('Gagal Menambah Data!');
            </script>
        ";
        echo "<meta http-equiv='refresh' content='0; url=http://localhost/bsk09/page/admin.php?page=data-sampah'>";
    }
}
?>

<html>
<head>
    <title>Homepage</title>
    <style>
        label {
            font-family: Montserrat;
            font-size: 18px;
            display: block;
            color: #262626;
        }

        input[type=text], input[type=password] {
            border-radius: 5px;
            width: 40%;
            height: 35px;
            background: #eee;
            padding: 0 10px;
            box-shadow: 1px 2px 2px 1px #ccc;
            color: #262626;
        }

        select {
            border-radius: 5px;
            width: 42%;
            height: 39px;
            background: #eee;
            padding: 0 10px;
            box-shadow: 1px 2px 2px 1px #ccc;
            color: #262626;
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
            font-family: Montserrat;
            font-size: 16px;
        }

        .form-group {
            padding: 5px 0;
        }
    </style>
</head>
<body>
    <h2 style="font-size: 30px; color: #262626;">Tambah Data Sampah</h2>

    <form id="daftar_user" action="" method="post" enctype="multipart/form-data">
        <div class="form-group">
            <label class="text-left">Jenis Sampah</label>
            <input type="text" placeholder="Masukan jenis sampah" name="jenis_sampah" />
        </div>

        <div class="form-group">
            <label>Kategori</label>
            <select name="kategori">
                <option value="">---Pilih Kategori---</option>
                <option value="Organik">Organik</option>
                <option value="Anorganik">Anorganik</option>
            </select>
        </div>

        <div class="form-group">
            <label>Satuan</label>
            <select name="satuan">
                <option value="p">---Pilih Satuan---</option>
                <option value="KG">Kilogram</option>
                <option value="PC">Pieces</option>
                <option value="LT">Liter</option>
            </select>
        </div>

        <div class="form-group">
            <label>Harga (Rp)</label>
            <input type="text" placeholder="Masukan harga (Rp)" name="harga" />
        </div>

        <div class="form-group">
            <label>Gambar</label>
            <input type="file" name="gambar" />
        </div>

        <div class="form-group">
            <label>Deskripsi</label>
            <input type="text" placeholder="Masukan deskripsi sampah" name="deskripsi" />
        </div>

        <input type="submit" name="simpan" value="Simpan">
    </form>
</body>
</html>
