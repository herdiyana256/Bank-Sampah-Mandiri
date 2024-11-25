<?php
if (isset($_POST['simpan'])) {
    require_once("../system/config/koneksi.php");
    
    $tanggal_setor = $_POST['tanggal_setor'];
    $nin = $_POST['nin'];
    $jenis_sampah = $_POST['jenis_sampah'];
    $berat = $_POST['berat'];
    $nia = $_POST['nia'];

    // Ambil harga sampah dari database berdasarkan jenis sampah
    $query_harga = mysqli_query($conn, "SELECT harga FROM sampah WHERE jenis_sampah = '$jenis_sampah'");
    $data_harga = mysqli_fetch_assoc($query_harga);
    $harga = $data_harga['harga'];
    $total = $harga * $berat;

    // Pastikan variabel tidak null sebelum digunakan
    if ($tanggal_setor && $nin && $jenis_sampah && $berat && $nia) {
        $query = "INSERT INTO setor(tanggal_setor, nin, jenis_sampah, berat, harga, total, nia) 
                  VALUES ('$tanggal_setor','$nin','$jenis_sampah','$berat','$harga','$total','$nia')";
        $queryact = mysqli_query($conn, $query);

        if ($queryact) {
            echo "<script>alert('Selamat berhasil input data!')</script>";
        } else {
            echo "<script>alert('Gagal input data: " . mysqli_error($conn) . "')</script>";
        }

        echo "<meta http-equiv='refresh' content='0; url=http://localhost/bsk09/page/admin.php?page=data-setor'>";
    } else {
        echo "<script>alert('Harap isi semua data yang diperlukan!')</script>";
    }
}
?>

<html>
<head>
    <title>Homepage</title>
    <script type="text/javascript" src="../asset/plugin/datepicker/jquery.min.js"></script>
    <link rel="stylesheet" type="text/css" href="../asset/plugin/datepicker/css/jquery.datepick.css"> 
    <script type="text/javascript" src="../asset/plugin/datepicker/js/jquery.plugin.js"></script> 
    <script type="text/javascript" src="../asset/plugin/datepicker/js/jquery.datepick.js"></script>
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

    <script type="text/javascript">
        function cek_data() {
            var x = document.getElementById("date").value;

            if (x == "") {
                alert("Maaf harap input tanggal setor!");
                document.getElementById("date").focus(); 
                return false;
            }

            var pnin = document.forms['daftar_user'].nin.value;
            if (pnin == "pnin") {
                alert("Maaf harap input nomor induk nasabah!");
                return false;
            }

            var pjs = document.forms['daftar_user'].jenis_sampah.value;
            if (pjs == "pjs") {
                alert("Maaf harap input jenis sampah!");
                return false;
            }

            var berat = document.forms['daftar_user'].berat.value;
            var angka = /^[0-9]+$/;

            if (berat == "") {
                alert("Maaf harap input berat sampah!");
                document.forms['daftar_user'].berat.focus(); 
                return false;
            }
            if (!berat.match(angka)) {
                alert("Berat sampah harus di input angka!");
                document.forms['daftar_user'].berat.focus();
                return false;
            }

            return confirm("Apakah Anda yakin sudah input data dengan benar?");
        }

        function sum() {
            var berat = document.getElementById("berat").value;
            var jenisSampah = document.getElementById("jenis_sampah").value;

            // Ambil harga berdasarkan jenis sampah
            if (jenisSampah !== "pjs") {
                $.ajax({
                    url: 'get_harga.php', // Ganti dengan path file PHP yang mengembalikan harga
                    type: 'POST',
                    data: {jenis_sampah: jenisSampah},
                    success: function(data) {
                        var harga = parseFloat(data);
                        var total = harga * berat;
                        document.getElementById("harga").value = harga;
                        document.getElementById("total").value = total;
                    }
                });
            }
        }
    </script>
</head>

<body>
    <h2 style="font-size: 30px; color: #262626;">Setor Sampah</h2>
    
    <form id="daftar_user" action="" method="post" onsubmit="return cek_data()">
        <div class="form-group">
            <label class="text-left">Tanggal Penyetoran</label>
            <input type="text" placeholder="Masukan tanggal setor" id="date" name="tanggal_setor" />
            <script type="text/javascript">  $('#date').datepick({dateFormat: 'yyyy-mm-dd'});</script>    
        </div>

        <div class="form-group">
            <label class="">Nomor Induk Nasabah</label>
            <select class="nomornasabah" name="nin">
                <option value="pnin">---Pilih NIN---</option>
                <?php 
                $query = mysqli_query($conn, "SELECT * FROM nasabah");
                while ($row = mysqli_fetch_array($query)) {
                    echo '<option value="'.$row['nin'].'">'. $row['nin'] . '</option>';
                }
                ?>
            </select>
        </div>

        <div class="form-group">
            <label class="">Jenis Sampah</label>
            <select class="jensampah" name="jenis_sampah" onchange="sum()" id="jenis_sampah">
                <option value="pjs">---Pilih Jenis Sampah---</option>
                <?php 
                $query = mysqli_query($conn, "SELECT * FROM sampah");
                while ($row = mysqli_fetch_array($query)) {
                    echo '<option value="'. $row['jenis_sampah'].'">' . $row['jenis_sampah'] . '</option>'; 
                }
                ?>
            </select>
        </div>

        <div class="form-group">
            <label class="">Berat Sampah</label>
            <input type="text" placeholder="Masukan berat sampah" id="berat" name="berat" onkeyup="sum();" />
        </div>

        <div class="form-group">
            <label class="">Harga Sampah (Rp)</label>
            <input type="text" placeholder="otomatis terisi" style="cursor: not-allowed;" id="harga" name="harga" readonly />
        </div>

        <div class="form-group">
            <label class="">Total (Rp)</label>
            <input type="text" placeholder="Otomatis terisi" style="cursor: not-allowed;" id="total" name="total" readonly />
        </div>

        <div class="form-group">
            <label class="">Nomor Induk Admin</label>
            <input type="text" style="cursor: not-allowed;" name="nia" value="<?php echo $_SESSION['nia']; ?>" readonly />
        </div>

        <input type="submit" name="simpan" value="Simpan" />
    </form>
</body>
</html>
