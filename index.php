<?php
require 'system/config/koneksi.php'
?>

<!DOCTYPE html>
<html>

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">

  <title>Beranda</title>
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
  <link href="https://fonts.googleapis.com/css?family=Montserrat|Contrail+One|Raleway" rel="stylesheet">
  <link href="http://fonts.googleapis.com/css?family=Cookie" rel="stylesheet" type="text/css">
  <link rel="stylesheet" href="http://maxcdn.bootstrapcdn.com/font-awesome/4.2.0/css/font-awesome.min.css">
  <link rel='stylesheet prefetch' href='https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css'>
  <link rel="shortcut icon" href="asset/internal/img/logo.png">
  <link rel="stylesheet" href="asset/internal/css/style-index1.css">
  <link rel="stylesheet" href="asset/internal/css/style-index2.css">
  <link rel="icon" type="image/png" href="./asset/favicon.png">
  <link rel="manifest" href="Manifest.json">



  <script src="asset/internal/js/preloader.js" type="text/javascript"></script>
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>

  <script>
    $(document).ready(function() {
      $(".preloader").fadeOut();
    })
  </script>


<script>
  const menuIcon = document.getElementById('menu-icon');
  const topMenu = document.getElementById('top-menu');

  menuIcon.addEventListener('click', function () {
    topMenu.classList.toggle('active'); // Tampilkan/Sembunyikan menu
  });
</script>


</head>

<body>

  <!--Pre Loader-->
  <div class="preloader">
    <div class="loading">
      <img src="asset/internal/img/img-local/spiner.gif" width="80">
    </div>
  </div>


  <!--Navbar-->
  <header>
    <a href="#" id="logo"></a>
    <nav>
      <a href="#" id="menu-icon"></a>
      <ul id="top-menu">
        <li style="list-style: none; display: inline"></li>
        <li class="active">
          <a href="#">Beranda</a>
        </li>
        <li style="list-style: none; display: inline"></li>
        <li>
          <a href="#foo">Petunjuk</a>
        </li>
        <li style="list-style: none; display: inline"></li>
        <li>
          <a href="#bar">Tim Kami</a>
        </li>
        <li style="list-style: none; display: inline"></li>
        <li>
          <a href="#baz">Lokasi</a>
        </li>
        <li style="list-style: none; display: inline"></li>
      </ul>
    </nav>
  </header>

  <!-- konten1 -->
  <div class="page-wrap">
    <div class="header">
      <div class="box-1">
        <h1 disabled>Bank Sampah Mandiri</h1>
        <p> Merubah sampah menjadi penghasilan tambahan Anda !!! </p>
        <br> <br> <br>

        <div class="center">
          <a href="page/login.php" target="_blank">
            <div class="btn" align="center">Login</div>
          </a> <!-- End Btn -->
    <br>
          <!-- <div class="center"> -->
          <a href="page/register.php" target="_blank">
            <div class="btn" align="center">Register</div>
        </div>
      </div>
    </div>
  </div>
  </div>






  <!--konten2-->
  <div id="foo">
    <section class="team">
      <div class="container">
        <div class="row">
          <h1>TERTARIK BERGABUNG ???</h1>
          <p>Bank Sampah Sejahtra adalah organisasi peduli lingkungan yang berlokasi di Kelurahan Pulogadung, Jakarta Timur. Selain bidang bank sampah, kami juga berfokus pada pengelolaan sampah, seperti komposting berbasis sampah, kerajinan berbahan baku sampah, dan masih banyak lagi program yang kami kembangkan. Saat ini, Bank Sampah Sejahtra melayani warga Kelurahan Pulogadung yang berjumlah lebih dari 500 kepala keluarga. Hal itu menunjukkan bahwa warga masyarakat Pulogadung sangat antusias dengan adanya program ini, dan tentu Bank Sampah Sejahtra mendapatkan perhatian khusus dari warga sekitar. Jika Anda berminat untuk bergabung, silakan ikuti langkah berikut ini.</p>
          </div>
        <div class="row mgt50px">
          <div class="coloumn">
            <div class="imgBox">
              <img src="asset/internal/img/img-content/1.jpg">
            </div>
            <div class="details">
              <h3>#Tahap1<br><span>Lakukan Pendaftaran</span></h3>
            </div>
          </div>
          <div class="coloumn">
            <div class="imgBox">
              <img src="asset/internal/img/img-content/2.jpg">
            </div>
            <div class="details">
              <h3>#Tahap2<br><span>Pemilahan Sampah</span></h3>
            </div>
          </div>
          <div class="coloumn">
            <div class="imgBox">
              <img src="asset/internal/img/img-content/3.jpg">
            </div>
            <div class="details">
              <h3>#Tahap3<br><span>Penimbangan Sampah</span></h3>
            </div>
          </div>
          <div class="coloumn">
            <div class="imgBox">
              <img src="asset/internal/img/img-content/4.jpg">
            </div>
            <div class="details">
              <h3>#Tahap4<br><span>Mendapat Keuntungan</span></h3>
            </div>
          </div>
          <div style="clear: both;"></div>
        </div>
      </div>
    </section>
  </div>

  <script src='http://cdnjs.cloudflare.com/ajax/libs/jquery/2.1.3/jquery.min.js'></script>
  <script src="asset/internal/js/index.js"></script>

<hr>



<!--konten2-->
<div id="bar">
    <section class="team">
      <div class="container">
        <div class="row">
          <h1>TIM KAMI</h1>
          <br>
        <!-- Card 1: DLH DKI Jakarta -->
        <div class="col-md-4">
          <div class="card">
            <img src="./asset/gambar1.jpg" class="card-img-top" alt="Dinas Lingkungan Hidup DKI Jakarta">
            <div class="card-body">
              <h5 class="card-title">Dinas Lingkungan Hidup DKI Jakarta</h5>
              <p class="card-text">DLH DKI Jakarta bertanggung jawab atas kebersihan dan pengelolaan lingkungan hidup di seluruh wilayah DKI Jakarta.</p>
            </div>
          </div>
        </div>

        <!-- Card 2: Sudin LH Jakarta Timur -->
        <div class="col-md-4">
          <div class="card">
            <img src="./asset/gambar2.png" class="card-img-top" alt="Suku Dinas Lingkungan Hidup Jakarta Timur">
            <div class="card-body">
              <h5 class="card-title">Suku Dinas Lingkungan Hidup Jakarta Timur</h5>
              <p class="card-text">Sudin LH Jakarta Timur menangani kebersihan wilayah Jakarta Timur, termasuk pengelolaan sampah di tingkat kecamatan, kelurahan, dan RT/RW.</p>
            </div>
          </div>
        </div>

        <!-- Card 3: Unit Pengelola Sampah (UPS) -->
        <div class="col-md-4">
          <div class="card">
            <img src="./asset/gambar3.jpg" class="card-img-top" alt="Unit Pengelola Sampah">
            <div class="card-body">
              <h5 class="card-title">Unit Pengelola Sampah (UPS)</h5>
              <p class="card-text">UPS mengelola bank sampah dan fasilitas pengelolaan sampah di tingkat lokal untuk mendukung pengelolaan sampah terpadu.</p>
            </div>
          </div>
        </div>
      </div>

 

      
      </div>
    </div>
  </section>
</div>

<hr>

  <!--konten maps-->

<!--konten maps-->
<br>
<div id="baz">
    <div class="row mgt50px">
        <h1 style="text-align: center;">Lokasi Bank Sampah</h1>
        <br>
        <br>
        <div class="map-container">
            <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3966.588596329078!2d106.89370280000001!3d-6.1857738!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x2e69f4c36f338be5%3A0x2c0012024a36ad72!2sKantor%20Kelurahan%20Pulo%20Gadung%20Jakarta%20Timur!5e0!3m2!1sid!2sid!4v1729015884934!5m2!1sid!2sid" width="2000" height="500" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
        </div>
    </div>
</div>




  <!--footer-->
  <footer class="footer-distributed">

    <div class="footer-left">

      <a href="#" id="logo_f"></a>
      <br>

      <p class="footer-links">
      <ul>
        <a href="#">Beranda</a>
        ·
        <a href="#foo">Petunjuk</a>
        ·
        <a href="#bar">Tim Kami</a>
        ·
        <a href="#baz">Lokasi</a>
        </p>

        <p><font color="white">Copyright &#169; - Alkat Zakaria <script type='text/javascript'>var creditsyear = new Date();document.write(creditsyear.getFullYear());</script> <a expr:href='data:blog.homepageUrl'><data:blog.title/></a>. All rights reserved.</font></p>
    </div>

    <div class="footer-center">

      <div>
        <i class="fa fa-map-marker"></i>
        <p><span>Jakarta Timur</span> Kecamatan Pulogadung </p>
      </div>

      <div>
        <i class="fa fa-phone"></i>
        <p><a href="sms:(+62)85694519585">+62 821-7569-9795</a></p>
      </div>

      <div>
        <i class="fa fa-envelope"></i>
        <p><a href="mailto:Official_bsk09@gmail.com">banksampah_sejahtra@gmail.com</a></p>
      </div>

    </div>

    <div class="footer-right">

      <p class="footer-company-about">
        <span>Kunjungi Sosial Media Kami!</span>
        Untuk yang ingin lebih dekat dengan Bank Sampah Sejahtra, silahkan kunjungi sosial media kami dibawah ini!
      </p>

      <div class="footer-icons">

        <a href="#" target="_blank"><i class="fa fa-facebook"></i></a>
        <a href="#" target="_blank"><i class="fa fa-twitter"></i></a>
        <a href="#" target="_blank"><i class="fa fa-instagram"></i></a>

      </div>

    </div>

  </footer>

</body>

</html>