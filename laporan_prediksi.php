<?php
if (!isset($_GET['index'])) {
  echo '<h3>Data tidak ditemukan.</h3>';
  exit;
}
$idx = intval($_GET['index']);
$dataFile = 'data.json';
if (!file_exists($dataFile)) {
  echo '<h3>File data tidak ditemukan.</h3>';
  exit;
}
$json = file_get_contents($dataFile);
$data = json_decode($json, true);
if (!is_array($data) || !isset($data[$idx])) {
  echo '<h3>Data tidak ditemukan.</h3>';
  exit;
}
$row = $data[$idx];
function cetak($val) {
  return !empty($val) ? htmlspecialchars($val) : '-';
}
require_once 'autoload.php';
$obj = new Bayes();
$jumLayak      = $obj->sumLayak();
$jumTidakLayak = $obj->sumTidakLayak();
$jumData       = $obj->sumData();
$a1 = $row['pekerjaan'];
$a2 = $row['usia'];
$a3 = $row['status'];
$a4 = $row['penghasilan'];
$a5 = $row['kendaraan'];
$a6 = $row['kepemilikan'];
$a7 = $row['atap_bangunan'];
$pekerjaan_layak      = $obj->probPekerjaanUtama($a1, 1);
$usia_layak           = $obj->probUsiaUtama($a2, 1);
$status_layak         = $obj->probStatusUtama($a3, 1);
$penghasilan_layak    = $obj->probPenghasilanUtama($a4, 1);
$kendaraan_layak      = $obj->probKendaraanUtama($a5, 1);
$kepemilikan_layak    = $obj->probKepemilikanUtama($a6, 1);
$atap_layak           = $obj->probAtapUtama($a7, 1);
$pekerjaan_tidak      = $obj->probPekerjaanUtama($a1, 0);
$usia_tidak           = $obj->probUsiaUtama($a2, 0);
$status_tidak         = $obj->probStatusUtama($a3, 0);
$penghasilan_tidak    = $obj->probPenghasilanUtama($a4, 0);
$kendaraan_tidak      = $obj->probKendaraanUtama($a5, 0);
$kepemilikan_tidak    = $obj->probKepemilikanUtama($a6, 0);
$atap_tidak           = $obj->probAtapUtama($a7, 0);
$paLayak      = $obj->hasilLayakUtama($jumLayak, $jumData, $pekerjaan_layak, $usia_layak, $status_layak, $penghasilan_layak, $kendaraan_layak, $kepemilikan_layak, $atap_layak);
$paTidakLayak = $obj->hasilTidakLayakUtama($jumTidakLayak, $jumData, $pekerjaan_tidak, $usia_tidak, $status_tidak, $penghasilan_tidak, $kendaraan_tidak, $kepemilikan_tidak, $atap_tidak);
$result           = $obj->perbandingan($paLayak, $paTidakLayak);
$persenLayak      = round($result[1], 2);
$persenTidakLayak = round($result[2], 2);
$hasil_prediksi   = ($paLayak > $paTidakLayak) ? "layak" : "tidak layak";
?>
<!DOCTYPE html>
<html lang="id">
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
  <title>Laporan Hasil Prediksi Kelayakan Penerima Bantuan</title>
  <style>
    body {
      background: linear-gradient(135deg, #eaf6ff 0%, #fafdff 100%);
      font-family: 'Poppins', Arial, sans-serif;
      min-height: 100vh;
      font-size: 0.93rem; 
    }
    .main-container {
      margin-top:0;
      max-width:1140px;
      font-size: 0.97rem; 
    }
    .print-container {
      width: 100%;
      max-width: 1140px;
      margin: 90px auto 40px auto;
      background: rgba(255,255,255,0.90);
      border-radius: 28px;
      box-shadow: 0 12px 40px rgba(51,102,153,0.15);
      padding: 4px 38px 38px 38px;
      font-size: 0.98rem; 
      backdrop-filter: blur(10px);
      border: 2px solid #eaf6ff;
    }
    .header-flex {
      display: flex;
      align-items: center;
      justify-content: space-between;
      background: rgba(255,255,255,0.55);
      border-radius: 18px 18px 0 0;
      box-shadow: 0 2px 16px rgba(51,102,153,0.08);
      padding: 24px 28px 18px 28px;
      margin-bottom: 18px;
      gap: 18px;
      border-bottom: 2px solid #e0e7ff;
      position: relative;
      padding-top: 0;
      margin-top: 0;
    }
    .header-flex::after {
      content: '';
      display: block;
      position: absolute;
      left: 0; right: 0; bottom: 0;
      height: 2px;
      background: linear-gradient(90deg, #4076b7 0%, #6ba6df 100%);
      opacity: 0.13;
      border-radius: 0 0 8px 8px;
    }
    .logo-laporan {
      width: 100px; height: 100px; object-fit:contain; margin-bottom:0; display:block;
      filter: drop-shadow(0 2px 8px #eaf6ff);
    }
    .judul-laporan {
      font-family: 'Poppins', sans-serif;
      font-weight: 800;
      font-size: 1.45rem; 
      background: linear-gradient(90deg, #4076b7 0%, #6ba6df 100%);
      color: #fff;
      border-radius: 14px;
      padding: 14px 0 8px 0;
      letter-spacing: 1.5px;
      box-shadow: 0 2px 12px rgba(80,180,255,0.13);
      margin-bottom: 0;
      text-align: left;
      text-shadow: 0 2px 12px rgba(80,180,255,0.13);
      display: flex;
      align-items: center;
      gap: 18px;
    }
    .judul-laporan i { font-size: 1.7rem; margin-right: 12px; opacity: 0.92; }
    .subjudul-laporan {
      color: #6ba6df;
      font-size: 0.98rem;
      margin-top: 8px;
      font-style: italic;
      font-weight: 500;
      text-shadow: 0 1px 0 #fff;
    }
    .info-box-header {
      font-size: 0.93rem;
      color: #336699;
      margin-top: 10px;
      display: flex;
      gap: 22px;
      flex-wrap: wrap;
    }
    .section-card {
      background: rgba(255,255,255,0.82);
      border-radius: 22px;
      box-shadow: 0 6px 28px rgba(51,102,153,0.11);
      padding: 32px 32px 22px 32px;
      margin-bottom: 32px;
      border-left: 8px solid #4076b7;
      position: relative;
      overflow: hidden;
      backdrop-filter: blur(3px);
      transition: box-shadow 0.2s;
    }
    .section-card .watermark-icon {
      position: absolute;
      right: 18px;
      bottom: 10px;
      font-size: 6.5rem;
      color: #eaf6ff;
      opacity: 0.13;
      pointer-events: none;
      z-index: 0;
    }
    .section-title {
      color: #336699;
      font-weight: 800;
      font-size: 1.01rem;
      margin-bottom: 22px;
      letter-spacing: 0.7px;
      display: flex;
      align-items: center;
      gap: 16px;
      z-index: 1;
      position: relative;
      text-shadow: 0 1px 0 #fff;
    }
    .section-title i { color: #4076b7; font-size: 1.7rem; }
    .tabel-identitas th { width: 180px; background: #eaf2fb; color: #336699; font-weight: 600; }
    .tabel-identitas td { background: #fff; color: #222; }
    .tabel-modern th, .tabel-modern td { padding: 14px 16px; text-align: center; font-size: 0.97rem; border-radius: 0 !important; }
    .tabel-modern th {
      background: linear-gradient(90deg, #eaf2fb 0%, #dbeafe 100%);
      font-weight: 800;
      color: #336699;
      border-bottom: 2px solid #dbeafe;
      border-top-left-radius: 10px;
      border-top-right-radius: 10px;
    }
    .tabel-modern td {
      background: #fff;
      color: #222;
      border-bottom: 1px solid #f0f4fa;
      transition: background 0.2s;
    }
    .tabel-modern tr:nth-child(even) td { background: #f3f8fd; }
    .tabel-modern tr:last-child td { border-bottom: none; }
    .tabel-modern tbody tr:hover td { background: #eaf6ff; transition: background 0.2s; }
    .table { border-radius: 12px !important; overflow: hidden; }
    .badge-cetak {
      font-size: 1.1rem; 
      border-radius: 32px;
      padding: 12px 32px;
      font-weight: 900;
      letter-spacing: 1.2px;
      color: #fff;
      display: inline-block;
      box-shadow: 0 4px 18px rgba(51,102,153,0.15);
      border: 3px solid #fff;
      outline: 3px solid #4076b7;
      outline-offset: 2.5px;
      animation: pulse 2.2s infinite;
      transition: box-shadow 0.2s;
    }
    .badge-layak { background: linear-gradient(90deg, #27ae60 0%, #00b894 100%); }
    .badge-tidaklayak { background: linear-gradient(90deg, #e74c3c 0%, #ff7675 100%); }
    @keyframes pulse {
      0% { box-shadow: 0 0 0 0 rgba(39,174,96,0.18); }
      70% { box-shadow: 0 0 0 28px rgba(39,174,96,0.01); }
      100% { box-shadow: 0 0 0 0 rgba(39,174,96,0.18); }
    }
    .badge-tidaklayak { animation: pulse-red 2.2s infinite; }
    @keyframes pulse-red {
      0% { box-shadow: 0 0 0 0 rgba(231,76,60,0.18); }
      70% { box-shadow: 0 0 0 28px rgba(231,76,60,0.01); }
      100% { box-shadow: 0 0 0 0 rgba(231,76,60,0.18); }
    }
    .kesimpulan-box {
      display: flex;
      align-items: center;
      gap: 32px;
      background: linear-gradient(90deg, #eafaf1 0%, #eaf6ff 100%);
      border-radius: 22px;
      box-shadow: 0 4px 22px rgba(51,102,153,0.13);
      padding: 22px 18px 16px 18px;
      margin-bottom: 32px;
      font-size: 1.01rem;
      color: #222;
      border-left: 7px solid #4076b7;
    }
    .kesimpulan-box .icon {
      font-size: 2.2rem;
      flex-shrink: 0;
      opacity: 0.96;
      filter: drop-shadow(0 2px 8px #eaf6ff);
    }
    .kesimpulan-box.layak .icon { color: #27ae60; }
    .kesimpulan-box.tidaklayak .icon { color: #e74c3c; }
    .info-box {
      background: linear-gradient(90deg, #eaf6ff 0%, #fafdff 100%);
      border-left: 6px solid #4076b7;
      border-radius: 16px;
      padding: 12px 14px;
      margin-bottom: 22px;
      font-size: 0.93rem;
      color: #336699;
      display: flex;
      align-items: flex-start;
      gap: 18px;
      box-shadow: 0 2px 12px rgba(51,102,153,0.07);
    }
    .info-box i { font-size: 1.3rem; margin-top: 2px; opacity: 0.7; }
    .catatan-box {
      background: linear-gradient(90deg, #fffbe6 0%, #fffde6 100%);
      border-left: 6px solid #f7b731;
      border-radius: 16px;
      padding: 12px 14px;
      margin-bottom: 22px;
      font-size: 0.93rem;
      color: #b37b00;
      display: flex;
      align-items: flex-start;
      gap: 18px;
      box-shadow: 0 2px 12px rgba(247,183,49,0.07);
      font-style: italic;
    }
    .catatan-box i { font-size: 1.3rem; margin-top: 2px; opacity: 0.7; }
    .ttd-section { margin-top: 40px; display: flex; justify-content: flex-end; }
    .ttd-box { text-align: center; min-width: 220px; }
    .ttd-label { font-size: 1.07rem; color: #444; margin-bottom: 48px; }
    .ttd-nama { font-weight: 600; color: #336699; font-size: 1.13rem; border-top: 1.5px dashed #4076b7; margin-top: 18px; padding-top: 6px; }
    @media (max-width: 700px) {
      .print-container { padding: 6px 1vw; font-size:0.93rem; }
      .header-flex { flex-direction: column; align-items: flex-start; gap: 6px; padding: 6px 2vw 4px 2vw; }
      .judul-laporan { font-size: 1.01rem; padding: 6px 0; }
      .logo-laporan { width: 38px; height: 38px; }
      .section-card, .kesimpulan-box { padding: 6px 2vw 6px 2vw; font-size:0.93rem; }
      .section-title { font-size: 0.91rem; }
      .info-box, .catatan-box { padding: 6px 2vw; font-size: 0.91rem; }
      .badge-cetak { font-size: 0.93rem; padding: 8px 12px; }
    }
    @media print {
      .btn-print, .navbar, .page-footer { display: none !important; }
      body, html { background: #fff !important; }
      .print-container, .card, .card-body, .card-header {
        box-shadow: none !important;
        background: #fff !important;
        color: #222 !important;
      }
      .card {
        border-radius: 28px !important;
        margin-bottom: 2px !important;
      }
      .card-header {
        background: linear-gradient(90deg, #4076b7 0%, #6ba6df 100%) !important;
        color: #fff !important;
        border-radius: 0.7rem 0.7rem 0 0 !important;
      }
      .tabel-identitas, .tabel-modern, .table-bordered {
        background: #fafdff !important;
        border-radius: 1.3rem !important;
        box-shadow: 0 2px 16px rgba(51,102,153,0.10) !important;
        page-break-inside: avoid;
      }
      .tabel-identitas th {
        background: #eaf2fb !important;
        color: #336699 !important;
      }
      .tabel-identitas td {
        background: #fff !important;
        color: #222 !important;
      }
      .row {
        display: flex !important;
        flex-wrap: nowrap !important;
      }
      .col-md-6, .col-12 {
        width: 50% !important;
        flex: 50% !important;
        padding: 8px !important;
      }
      .card-body { padding: 24px 24px 18px 24px !important; }
      .print-container { margin-top: 0 !important; }
    }
    .btn-print {
      font-size: 1.01rem;
      padding: 8px 22px;
      border-radius: 32px;
      font-weight: 700;
      margin-top: 18px;
      box-shadow: 0 2px 12px rgba(51,102,153,0.13);
      background: linear-gradient(90deg, #27ae60 0%, #00b894 100%);
      border: none;
      transition: background 0.2s, box-shadow 0.2s;
    }
    .btn-print:hover {
      background: linear-gradient(90deg, #4076b7 0%, #6ba6df 100%);
      color: #fff;
      box-shadow: 0 4px 18px rgba(51,102,153,0.18);
    }
  </style>
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
        <li class="nav-item"><a class="nav-link" href="informasi_sistem.php">Informasi</a></li>
      </ul>
    </div>
  </div>
</nav>

<div class="container main-container">
  <div class="row justify-content-center">
    <div class="col-12 mt-5" style="padding:0;">
      <div class="print-container">
    <div class="header-flex" style="background:transparent;box-shadow:none;padding-bottom:0;margin-bottom:0;">
      <div style="display:flex;align-items:center;gap:32px;width:100%;">
        <img src="img/logo.png" alt="Logo" style="width:90px;height:90px;object-fit:contain;display:block;filter:drop-shadow(0 2px 8px #eaf6ff);margin-left:8px;">
        <div style="flex:1;">
          <div style="background:linear-gradient(90deg,#4076b7 0%,#6ba6df 100%);border-radius:18px;padding:18px 28px 12px 28px;box-shadow:0 4px 18px rgba(51,102,153,0.10);margin-bottom:10px;display:inline-block;width:100%;">
            <span style="font-family:'Poppins',sans-serif;font-weight:800;font-size:2.2rem;color:#fff;letter-spacing:1.5px;line-height:1.2;display:block;text-shadow:0 2px 8px rgba(80,180,255,0.10);text-align:center;width:100%;">Laporan Hasil Prediksi<br>Kelayakan Penerima Bantuan</span>
          </div>
          <div style="font-style:italic;color:#6ba6df;font-size:1.13rem;font-weight:500;margin-bottom:8px;margin-top:2px;display:block;text-align:center;">Sistem Prediksi Naive Bayes | Rukun Warga 002 Kelurahan Meruya Selatan</div>
          <div style="display:flex;gap:28px;flex-wrap:wrap;font-size:1.01rem;color:#4076b7;font-weight:500;margin-bottom:2px;align-items:center;justify-content:center;text-align:center;">
            <span><i class="fas fa-calendar-alt"></i> Tanggal Cetak: <?= date('d-m-Y H:i') ?> WIB</span>
            <span><i class="fas fa-file-alt"></i> Nomor Dokumen: <?= sprintf('NBV-%04d', $idx+1) ?></span>
          </div>
        </div>
      </div>
    </div>

    <div class="card shadow-lg border-0 rounded-lg w-100 mb-4" style="position:relative;overflow:hidden;">
      <div class="card-header text-white" style="background: linear-gradient(90deg, #4076b7 0%, #6ba6df 100%) !important; border-radius:0.7rem 0.7rem 0 0;">
        <h5 class="mb-0" style="font-family: 'Poppins', sans-serif; font-weight:700; letter-spacing:1px;"><i class="fas fa-user mr-2"></i>Data Calon Penerima</h5>
      </div>
      <div class="card-body p-4" style="background:#fafdff;position:relative;">
        <div class="row" style="margin:0;gap:18px;display:flex;flex-wrap:wrap;">
          <div class="col-12" style="padding:0;">
            <table class="table tabel-identitas mb-0" style="width:100%;">
              <tr>
                <th style="width:20%;">Nama</th>
                <td style="width:30%;"><?= cetak($row['nama']) ?></td>
                <th style="width:20%;">Penghasilan</th>
                <td style="width:30%;"><?= cetak($row['penghasilan']) ?></td>
              </tr>
              <tr>
                <th>Pekerjaan</th>
                <td><?= cetak($row['pekerjaan']) ?></td>
                <th>Kendaraan</th>
                <td><?= cetak($row['kendaraan']) ?></td>
              </tr>
              <tr>
                <th>Usia</th>
                <td><?= cetak($row['usia']) ?></td>
                <th>Kepemilikan</th>
                <td><?= cetak($row['kepemilikan']) ?></td>
              </tr>
              <tr>
                <th>Status</th>
                <td><?= cetak($row['status']) ?></td>
                <th>Atap Bangunan</th>
                <td><?= cetak($row['atap_bangunan']) ?></td>
              </tr>
            </table>
          </div>
        </div>
        <i class="fas fa-user-shield" style="position:absolute;right:24px;bottom:10px;font-size:4.5rem;color:#eaf6ff;opacity:0.13;pointer-events:none;z-index:1;"></i>
      </div>
    </div>

    <div class="card shadow-lg border-0 rounded-lg w-100 mb-4" style="position:relative;overflow:hidden;">
      <div class="card-header text-white" style="background: linear-gradient(90deg, #4076b7 0%, #6ba6df 100%) !important; border-radius:0.7rem 0.7rem 0 0; position:relative; z-index:2;">
        <h5 class="mb-0" style="font-family: 'Poppins', sans-serif; font-weight:700; letter-spacing:1px;"><i class="fas fa-database mr-2"></i>Ringkasan Data Sistem</h5>
      </div>
      <div class="card-body p-4" style="background:#fafdff;position:relative;">
        <div style="font-size:0.98rem;color:#555;margin-bottom:14px;font-style:italic;text-align:center;">Data berikut merupakan rekapitulasi jumlah data yang digunakan dalam sistem.</div>
        <div style="display:flex;justify-content:center;">
          <table class="table table-bordered mb-2" style="max-width:400px;border-radius:1.3rem;box-shadow:0 2px 16px rgba(51,102,153,0.10);overflow:hidden;">
            <tr style='background:linear-gradient(90deg,#eaf2fb 0%,#dbeafe 100%);'>
              <th style='color:#336699;font-weight:700;text-align:left;'>Total Data</th>
              <td style='text-align:right;font-weight:600;'><?= $jumData ?></td>
            </tr>
            <tr>
              <th style='color:#336699;font-weight:700;text-align:left;'>Layak</th>
              <td style='text-align:right;font-weight:600;'><?= $jumLayak ?></td>
            </tr>
            <tr>
              <th style='color:#336699;font-weight:700;text-align:left;'>Tidak Layak</th>
              <td style='text-align:right;font-weight:600;'><?= $jumTidakLayak ?></td>
            </tr>
          </table>
        </div>
        <i class="fas fa-database" style="position:absolute;right:24px;bottom:10px;font-size:4.5rem;color:#eaf6ff;opacity:0.13;pointer-events:none;z-index:1;"></i>
      </div>
    </div>

    <div class="card shadow-lg border-0 rounded-lg w-100 mb-4" style="position:relative;overflow:hidden;">
      <div class="card-header text-white" style="background: linear-gradient(90deg, #4076b7 0%, #6ba6df 100%) !important; border-radius:0.7rem 0.7rem 0 0; position:relative; z-index:2;">
        <h5 class="mb-0" style="font-family: 'Poppins', sans-serif; font-weight:700; letter-spacing:1px;"><i class="fas fa-chart-bar mr-2"></i>Analisis Prediksi</h5>
      </div>
      <div class="card-body p-4" style="background:#fafdff;">
        <div style="font-size:0.98rem;color:#555;margin-bottom:8px;text-align:center;">Detail probabilitas setiap kriteria dalam proses analisis</div>
        <table class="table tabel-modern mb-3">
          <tr>
            <th>Kriteria</th>
            <th>Layak</th>
            <th>Tidak Layak</th>
          </tr>
          <tr><td>pA</td><td><?= $jumLayak ?> / <?= $jumData ?></td><td><?= $jumTidakLayak ?> / <?= $jumData ?></td></tr>
          <tr><td>Pekerjaan</td><td><?= $pekerjaan_layak ?></td><td><?= $pekerjaan_tidak ?></td></tr>
          <tr><td>Usia</td><td><?= $usia_layak ?></td><td><?= $usia_tidak ?></td></tr>
          <tr><td>Status</td><td><?= $status_layak ?></td><td><?= $status_tidak ?></td></tr>
          <tr><td>Penghasilan</td><td><?= $penghasilan_layak ?></td><td><?= $penghasilan_tidak ?></td></tr>
          <tr><td>Kendaraan</td><td><?= $kendaraan_layak ?></td><td><?= $kendaraan_tidak ?></td></tr>
          <tr><td>Kepemilikan</td><td><?= $kepemilikan_layak ?></td><td><?= $kepemilikan_tidak ?></td></tr>
          <tr><td>Atap Bangunan</td><td><?= $atap_layak ?></td><td><?= $atap_tidak ?></td></tr>
        </table>
        <div style="font-size:0.98rem;color:#555;margin-bottom:8px;text-align:center;">Berikut adalah hasil akhir prediksi beserta tingkat keyakinan sistem</div>
        <div style="display:flex;gap:16px;align-items:center;flex-wrap:wrap;justify-content:center;">
          <table class="table tabel-modern mb-3" style="max-width:400px;min-width:260px;margin-bottom:0;border-radius:1.3rem;box-shadow:0 2px 16px rgba(51,102,153,0.10);">
            <tr>
              <th style='background:linear-gradient(90deg,#4076b7 0%,#6ba6df 100%);color:#fff;'>PREDIKSI Layak</th>
              <td><b><?= $paLayak ?></b> <span style="color:#27ae60;font-weight:600;margin-left:10px;">(<?= $persenLayak ?> %)</span></td>
            </tr>
            <tr>
              <th style='background:linear-gradient(90deg,#4076b7 0%,#6ba6df 100%);color:#fff;'>PREDIKSI Tidak Layak</th>
              <td><b><?= $paTidakLayak ?></b> <span style="color:#e74c3c;font-weight:600;margin-left:10px;">(<?= $persenTidakLayak ?> %)</span></td>
            </tr>
          </table>
          <div style="display:flex;justify-content:center;align-items:center;min-width:180px;margin-top:0;">
            <?php if ($result[0] == "LAYAK"): ?>
              <span class="badge-cetak badge-layak"><i class="fas fa-check-circle mr-2"></i>LAYAK</span>
            <?php else: ?>
              <span class="badge-cetak badge-tidaklayak"><i class="fas fa-times-circle mr-2"></i>TIDAK LAYAK</span>
            <?php endif; ?>
          </div>
        </div>
        <i class="fas fa-balance-scale" style="position:absolute;right:24px;bottom:10px;font-size:4.5rem;color:#eaf6ff;opacity:0.13;pointer-events:none;z-index:1;"></i>
      </div>
    </div>
    <!-- Kesimpulan Sistem -->
    <div class="card shadow-lg border-0 rounded-lg w-100 mb-4" style="position:relative;overflow:hidden;">
      <div class="card-header text-white" style="background: linear-gradient(90deg, #4076b7 0%, #6ba6df 100%) !important; border-radius:0.7rem 0.7rem 0 0;">
        <h5 class="mb-0" style="font-family: 'Poppins', sans-serif; font-weight:700; letter-spacing:1px;"><i class="fas fa-check-circle mr-2"></i>Kesimpulan Sistem</h5>
      </div>
      <div class="card-body p-4" style="background:#fafdff;position:relative;">
        <div class="d-flex align-items-center mb-3">
          <span style="font-size:2.5rem; margin-right:18px; color:<?= $result[0] == 'LAYAK' ? '#27ae60' : '#e74c3c' ?>;">
            <?php if ($result[0] == "LAYAK"): ?>
              <i class="fas fa-check-circle"></i>
            <?php else: ?>
              <i class="fas fa-times-circle"></i>
            <?php endif; ?>
          </span>
         <span style="font-size:1.11rem;">
           <?php if ($result[0] == "LAYAK"): ?>
             <b>Berdasarkan analisis sistem, data ini diprediksi <span style='color:#27ae60;'>LAYAK</span> menerima bantuan.</b><br>
           <?php else: ?>
             <b>Berdasarkan analisis sistem, data ini diprediksi <span style='color:#e74c3c;'>TIDAK LAYAK</span> menerima bantuan.</b><br>
           <?php endif; ?>
           <span style="font-weight:400;">Hasil ini dapat dijadikan referensi untuk verifikasi, administrasi, dan arsip. Keputusan akhir sepenuhnya menjadi kewenangan pihak berwenang.</span>
         </span>
        </div>
        <i class="fas fa-check-circle" style="position:absolute;right:24px;bottom:10px;font-size:4.5rem;color:#eaf6ff;opacity:0.13;pointer-events:none;z-index:1;"></i>
      </div>
    </div>

    <div class="card shadow-lg border-0 rounded-lg w-100 mb-4" style="position:relative;overflow:hidden;">
      <div class="card-header text-white" style="background: linear-gradient(90deg, #4076b7 0%, #6ba6df 100%) !important; border-radius:0.7rem 0.7rem 0 0; position:relative; z-index:2;">
        <h5 class="mb-0" style="font-family: 'Poppins', sans-serif; font-weight:700; letter-spacing:1px;">
          <i class="fas fa-info-circle mr-2"></i>Instruksi, Kontak & Catatan
        </h5>
      </div>
      <div class="card-body p-4" style="background:rgba(255,255,255,0.92);backdrop-filter:blur(8px);border-radius:0 0 2rem 2rem;box-shadow:0 8px 32px rgba(51,102,153,0.10);position:relative;z-index:2;">
        <div class="info-box mb-4" style="border-left:7px solid #4076b7;background:linear-gradient(90deg,#eaf6ff 0%,#fafdff 100%);border-radius:1.3rem;padding:22px 28px;box-shadow:0 2px 12px rgba(51,102,153,0.07);display:flex;align-items:flex-start;gap:18px;">
          <i class="fas fa-info-circle" style="font-size:2.2rem;color:#4076b7;opacity:0.85;"></i>
          <div style="font-size:1.01rem;color:#336699;">
            Gunakan dokumen ini untuk keperluan verifikasi, administrasi, atau arsip. Pastikan data sudah benar. Jika ada perubahan, segera konfirmasi ke pihak terkait.
          </div>
        </div>
        <div class="info-box mb-4" style="border-left:7px solid #6ba6df;background:linear-gradient(90deg,#fafdff 0%,#eaf6ff 100%);border-radius:1.3rem;padding:22px 28px;box-shadow:0 2px 12px rgba(51,102,153,0.07);display:flex;align-items:flex-start;gap:18px;">
          <i class="fas fa-building" style="font-size:2.2rem;color:#6ba6df;opacity:0.85;"></i>
          <div style="font-size:1.01rem;color:#336699;">
           Rukun Warga 002 Kelurahan Meruya Selatan<br>Telepon: 021-78888888<br>Email: pelayanan@meruyaselatan.com
          </div>
        </div>
        <div class="catatan-box mt-3" style="border-left:7px solid #f7b731;background:linear-gradient(90deg,#fffbe6 0%,#fffde6 100%);border-radius:1.3rem;padding:22px 28px;box-shadow:0 2px 12px rgba(247,183,49,0.07);display:flex;align-items:flex-start;gap:18px;">
          <i class="fas fa-exclamation-circle" style="font-size:2.2rem;color:#f7b731;opacity:0.85;"></i>
          <div style="font-size:1.01rem;color:#b37b00;font-style:italic;">
            <b>Catatan:</b> Hasil ini merupakan rekomendasi sistem berbasis data. Keputusan akhir sepenuhnya ada pada pihak berwenang. Simpan dokumen ini sebagai arsip.
          </div>
        </div>
        <i class="fas fa-shield-alt" style="position:absolute;right:24px;bottom:10px;font-size:4.5rem;color:#eaf6ff;opacity:0.13;pointer-events:none;z-index:1;"></i>
      </div>
    </div>
    <div class="d-print-none" style="display:flex;justify-content:center;align-items:center;margin-top:32px;">
      <button class="btn btn-print-glass" onclick="window.print()">
        <i class="fas fa-print"></i> Print
      </button>
    </div>
    <style>
      .btn-print-glass {
        background: linear-gradient(90deg, #4076b7 0%, #6ba6df 100%);
        color: #fff;
        border: none;
        border-radius: 2.5rem;
        font-weight: 700;
        font-size: 1.18rem;
        padding: 16px 44px 16px 36px;
        box-shadow: 0 4px 24px rgba(51,102,153,0.13), 0 1.5px 8px #eaf6ff;
        transition: all 0.22s cubic-bezier(.4,2,.3,1);
        display: inline-flex;
        align-items: center;
        gap: 16px;
        backdrop-filter: blur(6px);
        position: relative;
        overflow: hidden;
        outline: 2.5px solid #eaf6ff;
        outline-offset: 2.5px;
        margin-bottom: 8px;
      }
      .btn-print-glass i {
        font-size: 1.7em;
        margin-right: 8px;
        filter: drop-shadow(0 2px 8px #eaf6ff);
      }
      .btn-print-glass:hover, .btn-print-glass:focus {
        background: linear-gradient(90deg, #27ae60 0%, #00b894 100%);
        color: #fff;
        box-shadow: 0 8px 32px rgba(39,174,96,0.18), 0 2px 12px #eaf6ff;
        transform: scale(1.045);
        outline: 2.5px solid #27ae60;
      }
      @media (max-width: 700px) {
        .btn-print-glass {
          font-size: 1.01rem;
          padding: 10px 18px 10px 14px;
        }
        .btn-print-glass i { font-size: 1.2em; }
      }
    </style>
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
<script src="js/popper.min.js"></script>
<script src="js/bootstrap.min.js"></script>
</body>
</html> 