<?php
// Ambil parameter bulan dan tahun dari GET
$bulan = isset($_GET['bulan']) ? $_GET['bulan'] : '';
$tahun = isset($_GET['tahun']) ? $_GET['tahun'] : '';

// Ambil data dari data.json
$dataFile = 'data.json';
$json = file_get_contents($dataFile);
$data = json_decode($json, true);

// Fungsi untuk cek dan ambil bulan/tahun dari data
function cocok_periode($row, $bulan, $tahun) {
    // Cek field tanggal yang mungkin ada
    $tanggal = isset($row['tanggal_pengajuan']) ? $row['tanggal_pengajuan'] : (isset($row['tanggal']) ? $row['tanggal'] : '');
    if (!$tanggal) return false;
    // Format tanggal diasumsikan YYYY-MM-DD
    $parts = explode('-', $tanggal);
    if (count($parts) < 2) return false;
    return ($parts[0] == $tahun && $parts[1] == $bulan);
}

// Filter data: hanya yang layak dan sesuai periode
$data_layak = array_filter($data, function($row) use ($bulan, $tahun) {
    if (!isset($row['keterangan']) || strtolower($row['keterangan']) !== 'layak') return false;
    return cocok_periode($row, $bulan, $tahun);
});

// Untuk judul bulan
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
  <style>
    body {
      background: linear-gradient(135deg, #eaf6ff 0%, #fafdff 100%);
      font-family: 'Poppins', Arial, sans-serif;
      min-height: 100vh;
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
      font-family:'Poppins',sans-serif;font-weight:800;font-size:2.1rem;color:#4076b7;letter-spacing:1.5px;line-height:1.2;display:block;text-shadow:0 2px 8px rgba(80,180,255,0.10);text-align:center;width:100%;
    }
    .periode-laporan {
      font-style:italic;color:#6ba6df;font-size:1.13rem;font-weight:500;margin-bottom:8px;margin-top:2px;display:block;text-align:center;
    }
    .table-laporan th, .table-laporan td {
      padding: 14px 16px; text-align: center; font-size: 0.97rem; border-radius: 0 !important;
    }
    .table-laporan th {
      background: linear-gradient(90deg, #eaf2fb 0%, #dbeafe 100%);
      font-weight: 800;
      color: #336699;
      border-bottom: 2px solid #dbeafe;
      border-top-left-radius: 10px;
      border-top-right-radius: 10px;
    }
    .table-laporan td {
      background: #fff;
      color: #222;
      border-bottom: 1px solid #f0f4fa;
      transition: background 0.2s;
    }
    .table-laporan tr:nth-child(even) td { background: #f3f8fd; }
    .table-laporan tr:last-child td { border-bottom: none; }
    .table-laporan tbody tr:hover td { background: #eaf6ff; transition: background 0.2s; }
    .badge-layak {
      background: linear-gradient(90deg, #27ae60 0%, #00b894 100%);
      color: #fff;
      font-weight: 700;
      border-radius: 32px;
      padding: 8px 22px;
      font-size: 1.1rem;
      letter-spacing: 1.2px;
      box-shadow: 0 4px 18px rgba(51,102,153,0.15);
      border: 3px solid #fff;
      outline: 3px solid #4076b7;
      outline-offset: 2.5px;
    }
    @media (max-width: 700px) {
      .print-container { padding: 6px 1vw; font-size:0.93rem; }
      .header-flex { flex-direction: column; align-items: flex-start; gap: 6px; padding: 6px 2vw 4px 2vw; }
      .judul-laporan { font-size: 1.01rem; padding: 6px 0; }
      .logo-laporan { width: 38px; height: 38px; }
      .table-laporan th, .table-laporan td { font-size: 0.93rem; padding: 8px 8px; }
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
      color: #fff;
    }
    .btn-print:hover {
      background: linear-gradient(90deg, #4076b7 0%, #6ba6df 100%);
      color: #fff;
      box-shadow: 0 4px 18px rgba(51,102,153,0.18);
    }
  </style>
</head>
<body>
  <div class="container print-container">
    <div class="header-flex" style="background:transparent;box-shadow:none;padding-bottom:0;margin-bottom:0;">
      <div style="display:flex;align-items:center;gap:32px;width:100%;">
        <img src="img/logo.png" alt="Logo" class="logo-laporan">
        <div style="flex:1;">
          <span class="judul-laporan">Laporan Penerima Surat Keterangan Tidak Mampu (Layak)</span>
          <div class="periode-laporan">Periode: <b><?= htmlspecialchars($judul_periode) ?></b></div>
        </div>
      </div>
    </div>
    <div style="margin-top:18px;">
      <?php if (count($data_layak) > 0): ?>
      <table class="table table-bordered table-laporan mb-2" style="width:100%;border-radius:1.3rem;overflow:hidden;">
        <thead>
          <tr>
            <th>No</th>
            <th>Nama</th>
            <th>Pekerjaan</th>
            <th>Usia</th>
            <th>Status</th>
            <th>Penghasilan</th>
            <th>Kendaraan</th>
            <th>Kepemilikan</th>
            <th>Atap Bangunan</th>
            <th>Keterangan</th>
            <th>Tanggal</th>
          </tr>
        </thead>
        <tbody>
          <?php $no=1; foreach($data_layak as $row): ?>
          <tr>
            <td><?= $no++ ?></td>
            <td><?= !empty($row['nama']) ? htmlspecialchars($row['nama']) : '-' ?></td>
            <td><?= !empty($row['pekerjaan']) ? htmlspecialchars($row['pekerjaan']) : '-' ?></td>
            <td><?= !empty($row['usia']) ? htmlspecialchars($row['usia']) : '-' ?></td>
            <td><?= !empty($row['status']) ? htmlspecialchars($row['status']) : '-' ?></td>
            <td><?= !empty($row['penghasilan']) ? htmlspecialchars($row['penghasilan']) : '-' ?></td>
            <td><?= !empty($row['kendaraan']) ? htmlspecialchars($row['kendaraan']) : '-' ?></td>
            <td><?= !empty($row['kepemilikan']) ? htmlspecialchars($row['kepemilikan']) : '-' ?></td>
            <td><?= !empty($row['atap_bangunan']) ? htmlspecialchars($row['atap_bangunan']) : '-' ?></td>
            <td><span class="badge-layak">Layak</span></td>
            <td><?= isset($row['tanggal_pengajuan']) ? htmlspecialchars($row['tanggal_pengajuan']) : (isset($row['tanggal']) ? htmlspecialchars($row['tanggal']) : '-') ?></td>
          </tr>
          <?php endforeach; ?>
        </tbody>
      </table>
      <?php else: ?>
        <div class="alert alert-warning text-center" style="margin:32px auto;max-width:500px;font-size:1.1rem;">
          <i class="fas fa-exclamation-circle mr-2"></i>Data penerima layak untuk periode ini tidak ditemukan atau data belum memiliki tanggal.
        </div>
      <?php endif; ?>
    </div>
    <div class="d-print-none" style="display:flex;justify-content:center;align-items:center;margin-top:32px;">
      <button class="btn btn-print" onclick="window.print()">
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