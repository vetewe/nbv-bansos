<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <link rel="icon" type="image/x-icon" href="img/logo.png" />
  <link rel="stylesheet" href="css/bootstrap.min.css" />
  <link rel="stylesheet" href="css/fontawesome.css" />
  <link rel="stylesheet" href="css/brands.css" />
  <link rel="stylesheet" href="css/solid.css" />
  <link rel="stylesheet" href="css/gaya.css">
  <link href="https://fonts.googleapis.com/css?family=Lato:400,700&display=swap" rel="stylesheet">
  <link href="https://fonts.googleapis.com/css?family=Poppins:300,400,500,700&display=swap" rel="stylesheet">
  <title>Naive Bayes - Informasi Sistem</title>
</head>
<body>
<nav class="navbar navbar-expand-lg fixed-top navbar-light bg-light static-top">
  <div class="container">
    <a class="navbar-brand" href="index.php">
      <img src="img/logo.png" alt="" width=65 height=65>
    </a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarResponsive" aria-controls="navbarResponsive" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarResponsive">
      <ul class="navbar-nav ml-auto">
        <li class="nav-item"><a class="nav-link" href="index.php">Prediksi</a></li>
        <li class="nav-item"><a class="nav-link" href="data_studi_kasus.php">Data</a></li>
        <li class="nav-item active"><a class="nav-link" href="informasi_sistem.php">Informasi<span class="sr-only">(current)</span></a></li>
      </ul>
    </div>
  </div>
</nav>
<div class="container" style='margin-top:90px;max-width:1140px;'>
  <div class="row justify-content-center">
    <div class="col-12 mt-5" style="padding:0;">
      <div class="card shadow-lg border-0 rounded-lg" style="margin-bottom:32px;">
        <div class="card-header text-white text-center" style="background: linear-gradient(90deg, #4076b7 0%, #6ba6df 100%) !important; border-radius:0.7rem 0.7rem 0 0;">
          <h3 class="mb-0" style="font-family: 'Poppins', sans-serif; font-weight:700; letter-spacing:1px;">
            <i class="fas fa-info-circle mr-2"></i>Informasi Sistem
          </h3>
          <div style="font-size:1.1rem;font-weight:400;color:#eaf6ff;">
            Tentang Aplikasi Prediksi Kelayakan Bantuan Sosial
          </div>
        </div>
        <div class="card-body p-4" style="background:#fafdff;">
          <section style="max-width:1000px;margin:auto;">
            <h4 class="mb-2" style="color:#336699;font-weight:600;">
              <i class="fas fa-cogs mr-2"></i>Metode & Algoritma
            </h4>
            <p class="desc">
              Algoritma <b>Naive Bayes</b> adalah metode klasifikasi berbasis probabilitas dan statistik yang dikembangkan oleh Thomas Bayes. Naive Bayes memprediksi peluang suatu kejadian berdasarkan data sebelumnya (Teorema Bayes), dengan asumsi independensi antar fitur.
            </p>
            <hr>
            <h4 class="mb-2" style="color:#336699;font-weight:600;">
              <i class="fas fa-users mr-2"></i>Studi Kasus
            </h4>
            <p class="desc">
              Studi kasus pada sistem ini adalah <b>prediksi kelayakan penerima bantuan sosial</b> berdasarkan data survei warga.<br>
              <b>Data latih</b> yang digunakan diambil dari jurnal:<br>
              <span style="display:block;margin:8px 0 4px 0;font-size:1.01rem;">
                <b>Penerapan Algoritma Naive Bayes Untuk Klasifikasi Penerima Bantuan Surat Keterangan Tidak Mampu</b><br>
                <i>Nurulfah Riyanah, Fatmawati. JTIM: Jurnal Teknologi Informasi dan Multimedia, Vol. 2, No. 4, Februari 2021, hlm. 206-213</i>
              </span>
              Data tersebut berisi atribut: nama, pekerjaan, usia, status, penghasilan, kendaraan, kepemilikan, atap bangunan, dan keterangan kelayakan.
            </p>
            <hr>
            <h4 class="mb-2" style="color:#336699;font-weight:600;">
              <i class="fas fa-toolbox mr-2"></i>Tools
            </h4>
            <ul class="list-unstyled ml-3 mb-3" style="font-size:1.05rem;">
              <li><i class="fas fa-check-circle text-success mr-2"></i>Bootstrap 4.0</li>
              <li><i class="fas fa-check-circle text-success mr-2"></i>Font Awesome</li>
              <li><i class="fas fa-check-circle text-success mr-2"></i>Data latih format JSON (diambil dari jurnal JTIM, Google Scholar)</li>
              <li><i class="fas fa-check-circle text-success mr-2"></i>jQuery</li>
            </ul>
            <hr>
            <h4 class="mb-2" style="color:#336699;font-weight:600;">
              <i class="fas fa-star mr-2"></i>Fitur
            </h4>
            <ul class="list-unstyled ml-3" style="font-size:1.05rem;">
              <li><i class="fas fa-check text-success mr-2"></i>Prediksi kelayakan penerima bantuan sosial</li>
              <li><i class="fas fa-check text-success mr-2"></i>Prediksi tanpa reload halaman (AJAX)</li>
              <li><i class="fas fa-check text-success mr-2"></i>Tampilan modern dan responsif</li>
              <li><i class="fas fa-check text-success mr-2"></i>Data latih atribut: pekerjaan, usia, status, penghasilan, kendaraan, kepemilikan, atap bangunan, keterangan</li>
            </ul>
          </section>
        </div>
      </div>
    </div>
  </div>
</div>
<footer class="page-footer font-small abu1 mt-5">
  <div class="footer-copyright text-center py-3 abu2">
    ©<?php echo date('Y'); ?> Naïve Bayes Classifier
  </div>
</footer>
<script src="js/jquery.js"></script>
</body>
</html>
