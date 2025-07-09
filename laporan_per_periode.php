<?php
$bulan = isset($_GET['bulan']) ? $_GET['bulan'] : '';
$tahun = isset($_GET['tahun']) ? $_GET['tahun'] : '';
$dataFile = 'data.json';
$json = file_get_contents($dataFile);
$data = json_decode($json, true);
function cocok_periode($row, $bulan, $tahun) {
    $tanggal = isset($row['tanggal_pengajuan']) ? $row['tanggal_pengajuan'] : (isset($row['tanggal']) ? $row['tanggal'] : '');
    if (!$tanggal) return false;
    $parts = explode('-', $tanggal);
    if (count($parts) < 2) return false;
    return ($parts[0] == $tahun && $parts[1] == $bulan);
}
$data_layak = array_filter($data, function($row) use ($bulan, $tahun) {
    if (!isset($row['keterangan']) || strtolower($row['keterangan']) !== 'layak') return false;
    return cocok_periode($row, $bulan, $tahun);
});
$nama_bulan = [
    '01' => 'Januari', '02' => 'Februari', '03' => 'Maret', '04' => 'April',
    '05' => 'Mei', '06' => 'Juni', '07' => 'Juli', '08' => 'Agustus',
    '09' => 'September', '10' => 'Oktober', '11' => 'November', '12' => 'Desember'
];
$judul_periode = ($bulan && $tahun) ? ($nama_bulan[$bulan] . ' ' . $tahun) : '-';
?>

<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Laporan Penerima SKTM Layak - Periode <?= htmlspecialchars($judul_periode) ?></title>
  <link rel="icon" type="image/x-icon" href="img/logo.png" />
  <link rel="stylesheet" href="css/bootstrap.min.css" />
  <link rel="stylesheet" href="css/fontawesome.css" />
  <link rel="stylesheet" href="css/brands.css" />
  <link rel="stylesheet" href="css/solid.css" />
  <link rel="stylesheet" href="css/gaya.css">
  <link href="https://fonts.googleapis.com/css?family=Lato:400,700&display=swap" rel="stylesheet">
  <link href="https://fonts.googleapis.com/css?family=Poppins:300,400,500,700&display=swap" rel="stylesheet">
  <style>
    body {
      background: linear-gradient(135deg, #eaf6ff 0%, #fafdff 100%);
      font-family: 'Poppins', Arial, sans-serif;
      min-height: 100vh;
      font-size: 0.97rem;
      padding-top: 90px;
    }
    .navbar {
      background: linear-gradient(90deg, #4076b7 0%, #6ba6df 100%) !important;
      box-shadow: 0 2px 8px rgba(51,102,153,0.10);
    }
    .navbar-brand img {
      border-radius: 50%;
      background: #fff;
      padding: 2px;
      box-shadow: 0 2px 8px #eaf6ff;
    }
    .navbar-nav .nav-link {
      color: #fff !important;
      font-weight: 700;
      font-size: 1.08rem;
      margin-left: 18px;
    }
    .hero-section {
      width: 100%;
      min-height: 120px;
      border-bottom-left-radius: 22px;
      border-bottom-right-radius: 22px;
      box-shadow: 0 4px 24px rgba(51,102,153,0.10);
      position: relative;
      z-index: 1;
    }
    .print-container {
      width: 100%;
      max-width: 1140px;
      margin: -70px auto 40px auto;
      background: rgba(255,255,255,0.95);
      border-radius: 28px;
      box-shadow: 0 12px 40px rgba(51,102,153,0.15);
      padding: 4px 38px 38px 38px;
      font-size: 0.98rem;
      backdrop-filter: blur(10px);
      border: 2px solid #eaf6ff;
      position: relative;
      z-index: 2;
    }
    .header-flex {
      display: flex;
      align-items: center;
      justify-content: space-between;
      background: transparent;
      border-radius: 18px 18px 0 0;
      box-shadow: none;
      padding: 0 0 0 0;
      margin-bottom: 20px;
      gap: 18px;
      border-bottom: none;
      position: relative;
      padding-top: 0;
      margin-top: 0;
    }
    .logo-laporan {
      width: 90px; height: 90px; object-fit:contain; margin-bottom:0; display:block;
      filter: drop-shadow(0 2px 8px #eaf6ff);
      background: #fff; border-radius: 50%;
      border: 3px solid #eaf6ff;
    }
    .judul-laporan {
      font-family: 'Poppins', sans-serif;
      font-weight: 800;
      font-size: 2.1rem;
      color: #fff;
      letter-spacing: 1.5px;
      line-height: 1.2;
      display: block;
      text-shadow: 0 2px 8px rgba(80,180,255,0.10);
      text-align: center;
      width: 100%;
      background: linear-gradient(90deg,#4076b7 0%,#6ba6df 100%);
      border-radius:18px;
      padding:18px 28px 12px 28px;
      box-shadow:0 4px 18px rgba(51,102,153,0.10);
      margin-bottom:10px;
    }
    .periode-laporan {
      color: #6ba6df;
      font-size: 1.13rem;
      font-weight: 500;
      margin-bottom: 8px;
      margin-top: 2px;
      display: block;
      text-align: center;
      font-style: italic;
      width: 100%;
      margin-left: auto;
      margin-right: auto;
    }
    .table-laporan th, .table-laporan td {
      padding: 8px 8px; text-align: center; font-size: 0.93rem; border-radius: 0 !important;
    }
    .table-laporan th {
      background: linear-gradient(90deg, #eaf2fb 0%, #dbeafe 100%);
      font-weight: 800;
      color: #336699;
      border-bottom: 2px solid #dbeafe;
      border-top-left-radius: 10px;
      border-top-right-radius: 10px;
      font-size: 1.01rem;
      letter-spacing: 1px;
      box-shadow: 0 2px 8px #eaf6ff;
    }
    .table-laporan td {
      background: #fff;
      color: #222;
      border-bottom: 1px solid #f0f4fa;
      transition: background 0.2s;
      vertical-align: middle;
    }
    .table-laporan tr:nth-child(even) td { background: #f3f8fd; }
    .table-laporan tr:last-child td { border-bottom: none; }
    .table-laporan tbody tr:hover td { background: #eaf6ff; transition: background 0.2s; }
    .badge-layak {
      background: linear-gradient(90deg, #27ae60 0%, #00b894 100%);
      color: #fff;
      font-weight: 700;
      border-radius: 32px;
      padding: 7px 18px;
      font-size: 0.98rem;
      letter-spacing: 1.1px;
      box-shadow: 0 2px 12px #27ae6055, 0 1.5px 8px #eaf6ff;
      outline: 3px solid #4076b7;
      outline-offset: 2.5px;
      animation: pulse 2.2s infinite;
      transition: box-shadow 0.2s;
    }
    @keyframes pulse {
      0% { box-shadow: 0 0 0 0 rgba(39,174,96,0.18); }
      70% { box-shadow: 0 0 0 28px rgba(39,174,96,0.01); }
      100% { box-shadow: 0 0 0 0 rgba(39,174,96,0.18); }
    }
    .watermark-icon {
      position: absolute;
      right: 24px;
      bottom: 10px;
      font-size: 5.5rem;
      color: #eaf6ff;
      opacity: 0.13;
      pointer-events: none;
      z-index: 0;
    }
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
    }
    @media (max-width: 700px) {
      .print-container { padding: 6px 1vw; font-size:0.93rem; margin-top:-18px; }
      .header-flex { flex-direction: column; align-items: flex-start; gap: 6px; padding: 6px 2vw 4px 2vw; }
      .judul-laporan { font-size: 1.01rem; padding: 6px 0; }
      .logo-laporan { width: 38px; height: 38px; }
      .table-laporan th, .table-laporan td { font-size: 0.91rem; padding: 6px 6px; }
      .btn-print-glass { font-size: 0.93rem; padding: 8px 12px; }
    }
    @media print {
      .btn-print-glass, .navbar, .page-footer, .hero-section { display: none !important; }
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
      .table-laporan {
        background: #fafdff !important;
        border-radius: 1.3rem !important;
        box-shadow: 0 2px 16px rgba(51,102,153,0.10) !important;
        page-break-inside: avoid;
      }
      .table-laporan th {
        background: #eaf2fb !important;
        color: #336699 !important;
      }
      .table-laporan td {
        background: #fff !important;
        color: #222 !important;
      }
    }
  </style>
</head>
<body>
  <nav class="navbar navbar-expand-lg fixed-top navbar-light static-top">
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
 
  <div class="hero-section"></div>
  <div class="container print-container">
    <div class="header-flex" style="background:transparent;box-shadow:none;padding-bottom:0;margin-bottom:20px;">
      <div style="display:flex;align-items:center;gap:32px;width:100%;">
        <img src="img/logo.png" alt="Logo" class="logo-laporan">
        <div style="flex:1;">
          <span class="judul-laporan">
            Laporan Penerima SKTM Layak
          </span>
          <div class="periode-laporan">Periode: <b><?= htmlspecialchars($judul_periode) ?></b></div>
        </div>
      </div>
      <i class="fas fa-users watermark-icon"></i>
    </div>
    <div style="font-size:1.08rem;color:#4076b7;font-weight:500;text-align:center;margin-bottom:18px;margin-top:8px;">
      Berikut adalah daftar penerima SKTM layak hasil seleksi sistem pada periode ini.
    </div>
   
    <div class="card shadow-lg border-0 rounded-lg w-100 mb-4" style="position:relative;overflow:hidden;margin-bottom:8px !important;">
      <div class="card-header text-white" style="background: linear-gradient(90deg, #4076b7 0%, #6ba6df 100%) !important; border-radius:0.7rem 0.7rem 0 0;">
        <h5 class="mb-0" style="font-family: 'Poppins', sans-serif; font-weight:700; letter-spacing:1px;">
          <i class="fas fa-database mr-2"></i>Ringkasan Data Periode Ini
        </h5>
      </div>
      <div class="card-body p-4" style="background:#fafdff; padding-bottom:18px !important; padding-top:18px !important;">
        <div style="font-size:1.05rem;color:#4076b7;font-weight:600;text-align:center;margin-bottom:0;margin-top:0;">
          Total Penerima Layak: <?= count($data_layak) ?> Orang
        </div>
      </div>
    </div>
   
    <div style="margin-top:-6px;">
      <?php if (count($data_layak) > 0): ?>
      <div style="overflow-x:auto;display:flex;justify-content:center;">
      <table class="table table-bordered table-laporan mb-2" style="width:100%;max-width:700px;margin:auto;border-radius:1.1rem;overflow:hidden;box-shadow:0 4px 18px rgba(51,102,153,0.10);background:#fafdff;font-size:0.89rem;">
        <thead style="position:sticky;top:0;z-index:2;">
          <tr>
            <th style="background:linear-gradient(90deg,#4076b7 0%,#6ba6df 100%);color:#fff;font-size:0.95rem;letter-spacing:1px;box-shadow:0 2px 8px #eaf6ff;padding:5px 5px;">No</th>
            <th style="padding:5px 5px;">Nama</th>
            <th style="padding:5px 5px;">Pekerjaan</th>
            <th style="padding:5px 5px;">Usia</th>
            <th style="padding:5px 5px;">Status</th>
            <th style="padding:5px 5px;">Penghasilan</th>
            <th style="padding:5px 5px;">Kendaraan</th>
            <th style="padding:5px 5px;">Kepemilikan</th>
            <th style="padding:5px 5px;">Atap Bangunan</th>
            <th style="padding:5px 5px;">Keterangan</th>
          </tr>
        </thead>
        <tbody>
          <?php $no=1; foreach($data_layak as $row): ?>
          <tr style="transition:background 0.18s;">
            <td style="font-weight:700;padding:5px 5px;vertical-align:middle;"><?= $no++ ?></td>
            <td style="padding:5px 5px;vertical-align:middle;"><?= !empty($row['nama']) ? htmlspecialchars($row['nama']) : '-' ?></td>
            <td style="padding:5px 5px;vertical-align:middle;"><?= !empty($row['pekerjaan']) ? htmlspecialchars($row['pekerjaan']) : '-' ?></td>
            <td style="padding:5px 5px;vertical-align:middle;"><?= !empty($row['usia']) ? htmlspecialchars($row['usia']) : '-' ?></td>
            <td style="padding:5px 5px;vertical-align:middle;"><?= !empty($row['status']) ? htmlspecialchars($row['status']) : '-' ?></td>
            <td style="padding:5px 5px;vertical-align:middle;"><?= !empty($row['penghasilan']) ? htmlspecialchars($row['penghasilan']) : '-' ?></td>
            <td style="padding:5px 5px;vertical-align:middle;"><?= !empty($row['kendaraan']) ? htmlspecialchars($row['kendaraan']) : '-' ?></td>
            <td style="padding:5px 5px;vertical-align:middle;"><?= !empty($row['kepemilikan']) ? htmlspecialchars($row['kepemilikan']) : '-' ?></td>
            <td style="padding:5px 5px;vertical-align:middle;"><?= !empty($row['atap_bangunan']) ? htmlspecialchars($row['atap_bangunan']) : '-' ?></td>
            <td style="padding:5px 5px;vertical-align:middle;"><span class="badge-layak" style="font-size:0.89rem;padding:5px 12px;box-shadow:0 2px 12px #27ae6055,0 1.5px 8px #eaf6ff;letter-spacing:1.1px;">Layak</span></td>
          </tr>
          <?php endforeach; ?>
        </tbody>
      </table>
      </div>
      <?php else: ?>
        <div class="alert alert-warning text-center" style="margin:32px auto;max-width:500px;font-size:1.1rem;">
          <i class="fas fa-exclamation-circle mr-2"></i>Data penerima layak untuk periode ini tidak ditemukan.
        </div>
      <?php endif; ?>
    </div>
   
    <div class="card shadow-lg border-0 rounded-lg w-100 mb-4" style="position:relative;overflow:hidden;margin-top:18px;">
      <div class="card-header text-white" style="background: linear-gradient(90deg, #4076b7 0%, #6ba6df 100%) !important; border-radius:0.7rem 0.7rem 0 0; position:relative; z-index:2;">
        <h5 class="mb-0" style="font-family: 'Poppins', sans-serif; font-weight:700; letter-spacing:1px;">
          <i class="fas fa-info-circle mr-2"></i>Informasi & Catatan Penting
        </h5>
      </div>
      <div class="card-body p-4" style="background:rgba(255,255,255,0.92);backdrop-filter:blur(8px);border-radius:0 0 2rem 2rem;box-shadow:0 8px 32px rgba(51,102,153,0.10);position:relative;z-index:2;">
        <div class="info-box mb-4" style="border-left:7px solid #4076b7;background:linear-gradient(90deg,#eaf6ff 0%,#fafdff 100%);border-radius:1.3rem;padding:22px 28px;box-shadow:0 2px 12px rgba(51,102,153,0.07);display:flex;align-items:flex-start;gap:18px;">
          <i class="fas fa-info-circle" style="font-size:2.2rem;color:#4076b7;opacity:0.85;"></i>
          <div style="font-size:1.01rem;color:#336699;">
            Data ini merupakan hasil rekapitulasi sistem. Untuk keperluan administrasi, verifikasi, atau arsip, silakan gunakan dokumen ini sesuai kebutuhan.
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
            <b>Catatan:</b> Data ini merupakan hasil sistem. Keputusan akhir tetap pada pihak berwenang. Simpan dokumen ini sebagai arsip.
          </div>
        </div>
        <i class="fas fa-shield-alt watermark-icon"></i>
      </div>
    </div>
 
    <div class="d-print-none" style="display:flex;justify-content:center;align-items:center;margin-top:32px;">
      <button class="btn btn-print-glass" onclick="window.print()">
        <i class="fas fa-print"></i> Print
      </button>
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
  <script src="js/datatables.js"></script>
  <script src="js/fontawesome.js"></script>
</body>
</html> 