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
  <link rel="stylesheet" href="css/datatables.css">
  <style>
    .btnPrintData {
      background: linear-gradient(90deg, #f7b731 0%, #4076b7 100%) !important;
      color: #fff !important;
      border: none;
      border-radius: 20px !important;
      font-weight: 600;
      font-size: 0.85rem;
      padding: 6px 18px 6px 12px !important;
      box-shadow: 0 2px 8px rgba(80,180,255,0.10);
      transition: all 0.2s;
      display: inline-flex;
      align-items: center;
      gap: 6px;
    }
    .btnPrintData i {
      margin-right: 4px;
      font-size: 1.1em;
    }
    .btnPrintData:hover {
      background: linear-gradient(90deg, #4076b7 0%, #f7b731 100%) !important;
      color: #fff !important;
      transform: scale(1.08);
      box-shadow: 0 4px 16px rgba(80,180,255,0.18);
    }
    @media (max-width: 600px) {
      .btnPrintData {
        font-size: 0.75rem;
        padding: 5px 10px 5px 8px !important;
      }
    }
    /* Modal Pilih Periode Laporan */
    #modalCetakPeriode .modal-content {
      border-radius: 1.2rem;
      box-shadow: 0 8px 32px rgba(39,174,96,0.13), 0 2px 12px #eaf6ff;
      overflow: hidden;
      border: none;
    }
    #modalCetakPeriode .modal-header {
      background: linear-gradient(90deg, #27ae60 0%, #00b894 100%);
      border-radius: 1.2rem 1.2rem 0 0;
      padding: 22px 28px 16px 28px;
      box-shadow: 0 2px 12px #eaf6ff;
      border-bottom: none;
    }
    #modalCetakPeriode .modal-title {
      font-size: 1.25rem;
      font-weight: 700;
      letter-spacing: 1px;
      color: #fff;
      display: flex;
      align-items: center;
      gap: 10px;
    }
    #modalCetakPeriode .modal-title i {
      font-size: 1.5em;
      margin-right: 6px;
    }
    #modalCetakPeriode .close {
      color: #fff;
      opacity: 1;
      font-size: 2rem;
      font-weight: 700;
      text-shadow: none;
      outline: none;
    }
    #modalCetakPeriode .modal-body {
      background: #fafdff;
      padding: 28px 28px 18px 28px;
    }
    #modalCetakPeriode .form-group {
      background: rgba(255,255,255,0.85);
      border-radius: 1rem;
      padding: 16px 18px 10px 18px;
      margin-bottom: 18px;
      box-shadow: 0 2px 12px #eaf6ff33;
    }
    #modalCetakPeriode label {
      font-weight: 700;
      color: #27ae60;
      font-size: 1.08rem;
      margin-bottom: 6px;
      display: flex;
      align-items: center;
      gap: 8px;
    }
    #modalCetakPeriode label i {
      font-size: 1.2em;
      color: #00b894;
      margin-right: 6px;
    }
    #modalCetakPeriode select.form-control {
      border-radius: 0.7rem;
      font-size: 1.07rem;
      padding: 10px 14px;
      box-shadow: 0 1.5px 8px #eaf6ff33;
      border: 1.5px solid #eaf6ff;
      background: #fff;
      color: #336699;
      font-weight: 500;
      margin-top: 4px;
      height: auto;
      min-height: 48px;
      line-height: 1.4;
      white-space: normal;
      overflow: visible;
    }
    #modalCetakPeriode .modal-footer {
      background: #fafdff;
      border-top: none;
      padding: 18px 28px 22px 28px;
      display: flex;
      gap: 12px;
      justify-content: flex-end;
    }
    .btn-detail-periode-modal {
      background: linear-gradient(90deg, #27ae60 0%, #00b894 100%);
      color: #fff;
      font-weight: 700;
      border-radius: 2.5rem;
      font-size: 1.13rem;
      min-width: 140px;
      box-shadow: 0 4px 24px rgba(39,174,96,0.13), 0 1.5px 8px #eaf6ff;
      padding: 10px 28px;
      border: none;
      outline: 2.5px solid #eaf6ff;
      outline-offset: 2.5px;
      transition: all 0.18s cubic-bezier(.4,2,.3,1);
      display: inline-flex;
      align-items: center;
      gap: 10px;
    }
    .btn-detail-periode-modal:hover, .btn-detail-periode-modal:focus {
      background: linear-gradient(90deg, #00b894 0%, #27ae60 100%);
      color: #fff;
      box-shadow: 0 8px 32px rgba(39,174,96,0.18), 0 2px 12px #eaf6ff, 0 0 16px 2px #00b89455;
      outline: 2.5px solid #27ae60;
      transform: scale(1.045);
    }
    #modalCetakPeriode .btn-secondary {
      border-radius: 2.5rem;
      font-size: 1.13rem;
      min-width: 120px;
      font-weight: 700;
      padding: 10px 24px;
      background: #888;
      color: #fff;
      border: none;
      box-shadow: 0 2px 8px #eaf6ff33;
      transition: all 0.18s cubic-bezier(.4,2,.3,1);
    }
    #modalCetakPeriode .btn-secondary:hover, #modalCetakPeriode .btn-secondary:focus {
      background: #555;
      color: #fff;
      outline: 2.5px solid #888;
      transform: scale(1.045);
    }
    @media (max-width: 600px) {
      #modalCetakPeriode .modal-dialog {
        margin: 0.5rem;
      }
      #modalCetakPeriode .modal-content, #modalCetakPeriode .modal-header, #modalCetakPeriode .modal-footer, #modalCetakPeriode .modal-body {
        padding-left: 8px !important;
        padding-right: 8px !important;
      }
      #modalCetakPeriode .modal-header, #modalCetakPeriode .modal-footer {
        flex-direction: column;
        align-items: stretch;
        gap: 8px;
      }
      #modalCetakPeriode .btn-detail-periode-modal, #modalCetakPeriode .btn-secondary {
        width: 100%;
        min-width: 0;
        margin-bottom: 8px;
      }
    }
  </style>
  <title>Naive Bayes - Data Studi Kasus</title>
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
        <li class="nav-item active"><a class="nav-link" href="data_studi_kasus.php">Data<span class="sr-only">(current)</span></a></li>
        <li class="nav-item"><a class="nav-link" href="informasi_sistem.php">Informasi</a></li>
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
            <i class="fas fa-database mr-2"></i>Data Studi Kasus
          </h3>
          <div style="font-size:1.1rem;font-weight:400;color:#eaf6ff;">
            Data Latih Naive Bayes
          </div>
        </div>
        <div class="card-body p-4" style="background:#fafdff;">
          <section style="max-width:1000px;margin:auto;">
            <p class="desc" style="max-width:1100px;margin:auto;">
              Berikut adalah data acuan yang digunakan dalam membangun sistem untuk mendapatkan <b>Prediksi Penerima Bantuan Surat Keterangan Tidak Mampu</b> menggunakan metode Naive Bayes.<br><br>
              Data ini diambil melalui jurnal yang tersedia di Google Scholar dan telah diseleksi sesuai dengan kebutuhan penelitian.<br><br>
              Data ini akan digunakan sebagai dasar dalam proses pelatihan model agar sistem dapat melakukan prediksi secara akurat dan membantu proses pengambilan keputusan dalam penyaluran bantuan secara tepat
            </p>
            <div style="width:100%;overflow-x:auto;">
              <!-- Tombol Tambah Data Latih di atas tabel -->
              <div class="d-flex flex-row flex-wrap align-items-center justify-content-end mb-3 tombol-grup-laporan" style="gap:16px;">
                <button class="btn btn-tambah-latih" id="btnTambahDataLatih" type="button">
                  <i class="fas fa-plus mr-1"></i>Tambah Data Latih
                </button>
              </div>
              <div class="row justify-content-center mb-4">
                <div class="col-md-6">
                  <canvas id="pieChartKelayakan"></canvas>
                  <div class="d-flex justify-content-center mt-3">
                    <button class="btn btn-cetak-periode" id="btnCetakPeriode" type="button">
                      <i class="fas fa-print mr-1"></i> Cetak Laporan Periode
                    </button>
                  </div>
                </div>
              </div>
              <style>
                .tombol-grup-laporan .btn {
                  min-width: 220px;
                  height: 48px;
                  font-size: 1.13rem;
                  font-weight: 700;
                  border-radius: 2.5rem;
                  display: inline-flex;
                  align-items: center;
                  justify-content: center;
                  gap: 10px;
                  box-shadow: 0 4px 24px rgba(51,102,153,0.13), 0 1.5px 8px #eaf6ff;
                  padding: 0 36px;
                  transition: all 0.22s cubic-bezier(.4,2,.3,1);
                  margin: 0;
                  border: none;
                  backdrop-filter: blur(6px);
                  background: rgba(255,255,255,0.18);
                  outline: 2.5px solid #eaf6ff;
                  outline-offset: 2.5px;
                  position: relative;
                  overflow: hidden;
                }
                .btn-tambah-latih {
                  background: linear-gradient(90deg, #4076b7 0%, #6ba6df 100%);
                  color: #fff;
                  box-shadow: 0 4px 24px rgba(64,118,183,0.13), 0 1.5px 8px #eaf6ff;
                }
                .btn-tambah-latih:hover, .btn-tambah-latih:focus {
                  background: linear-gradient(90deg, #336699 0%, #4076b7 100%);
                  color: #fff;
                  box-shadow: 0 8px 32px rgba(64,118,183,0.18), 0 2px 12px #eaf6ff;
                  transform: scale(1.045);
                  outline: 2.5px solid #4076b7;
                }
                .btn-cetak-periode {
                  background: linear-gradient(90deg, #27ae60 0%, #00b894 100%);
                  color: #fff;
                  border: 2.5px solid #00b894;
                  box-shadow: 0 4px 24px rgba(39,174,96,0.13), 0 1.5px 8px #eaf6ff;
                  outline: 2.5px solid #eaf6ff;
                  outline-offset: 2.5px;
                }
                .btn-cetak-periode:hover, .btn-cetak-periode:focus {
                  background: linear-gradient(90deg, #00b894 0%, #27ae60 100%);
                  color: #fff;
                  box-shadow: 0 8px 32px rgba(39,174,96,0.18), 0 2px 12px #eaf6ff, 0 0 16px 2px #00b89455;
                  border-color: #27ae60;
                  transform: scale(1.045);
                  outline: 2.5px solid #27ae60;
                }
                .tombol-grup-laporan .btn i, .btn-cetak-periode i {
                  font-size: 1.25em;
                  margin-right: 8px;
                  filter: drop-shadow(0 2px 8px #eaf6ff);
                }
                @media (max-width: 600px) {
                  .tombol-grup-laporan {
                    flex-direction: column !important;
                    align-items: stretch !important;
                  }
                  .tombol-grup-laporan .btn {
                    min-width: 0;
                    width: 100%;
                    margin-bottom: 8px;
                  }
                }
                /* Tombol cetak di bawah pie chart */
                .btn-cetak-periode {
                  margin-top: 12px;
                }
              </style>
              <?php
                $dataFile = 'data.json';
                $json = file_get_contents($dataFile);
                $hasil = json_decode($json, true);
                $no = 1;
                // Hitung jumlah layak dan tidak layak
                $jumlah_layak = 0;
                $jumlah_tidak_layak = 0;
                foreach ($hasil as $row) {
                  if (isset($row['keterangan'])) {
                    if (strtolower($row['keterangan']) == 'layak') {
                      $jumlah_layak++;
                    } elseif (strtolower($row['keterangan']) == 'tidak layak') {
                      $jumlah_tidak_layak++;
                    }
                  }
                }
              ?>
              <table id="dataLatih" class="display pt-3 mb-3" style="width:100%;margin:auto;font-size:0.97rem;">
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
                    <th>Aksi</th>
                  </tr>
                </thead>
                <tbody>
                <?php
                  foreach ($hasil as $row):
                ?>
                <tr>
                  <td><?= $no++; ?></td>
                  <td><?= !empty($row['nama']) ? htmlspecialchars($row['nama']) : "-" ?></td>
                  <td><?= !empty($row['pekerjaan']) ? htmlspecialchars($row['pekerjaan']) : "-" ?></td>
                  <td><?= !empty($row['usia']) ? htmlspecialchars($row['usia']) : "-" ?></td>
                  <td><?= !empty($row['status']) ? htmlspecialchars($row['status']) : "-" ?></td>
                  <td><?= !empty($row['penghasilan']) ? htmlspecialchars($row['penghasilan']) : "-" ?></td>
                  <td><?= !empty($row['kendaraan']) ? htmlspecialchars($row['kendaraan']) : "-" ?></td>
                  <td><?= !empty($row['kepemilikan']) ? htmlspecialchars($row['kepemilikan']) : "-" ?></td>
                  <td><?= !empty($row['atap_bangunan']) ? htmlspecialchars($row['atap_bangunan']) : "-" ?></td>
                  <td>
                    <?php if (isset($row['keterangan'])): ?>
                      <?php if (strtolower($row['keterangan']) == "layak"): ?>
                        <span class='badge badge-success' style='padding:10px'>layak</span>
                      <?php elseif (strtolower($row['keterangan']) == "tidak layak"): ?>
                        <span class='badge badge-danger' style='padding:10px'>tidak layak</span>
                      <?php else: ?>
                        <?= htmlspecialchars($row['keterangan']) ?>
                      <?php endif; ?>
                    <?php else: ?>
                      -
                    <?php endif; ?>
                  </td>
                  <td>
                    <button class="btn btnPrintData btnDetailData" title="Detail" data-index="<?= $no-2 ?>"><i class="fas fa-eye"></i> Detail</button>
                  </td>
                </tr>
                <?php endforeach; ?>
                </tbody>
              </table>
            </div>
          </section>
        </div>
      </div>
    </div>
  </div>
</div>

<!-- Modal Tambah Data Latih -->
<div class="modal fade" id="modalTambahDataLatih" tabindex="-1" role="dialog" aria-labelledby="modalTambahDataLatihLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
    <div class="modal-content modal-glass" style="border-radius:1.3rem; box-shadow: 0 8px 32px rgba(64,118,183,0.18), 0 2px 12px #eaf6ff; border: none; overflow: hidden;">
      <div class="modal-header" style="background: linear-gradient(90deg, #4076b7 0%, #6ba6df 100%); border-radius:1.3rem 1.3rem 0 0; padding: 1.2rem 2rem;">
        <h5 class="modal-title text-white font-weight-bold" id="modalTambahDataLatihLabel" style="font-size:1.35rem; letter-spacing:0.5px;">
          <i class="fas fa-plus-circle mr-2"></i>Tambah Data Latih
        </h5>
        <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close" style="opacity:1; font-size:2rem;">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <form id="formTambahDataLatih" autocomplete="off">
        <div class="modal-body" style="background:rgba(255,255,255,0.82);backdrop-filter:blur(12px);padding:2.2rem 2.2rem 1.2rem 2.2rem;">
          <div class="row">
            <div class="col-md-6 mb-3">
              <label class="font-weight-bold"><i class="fas fa-user mr-1"></i>Nama</label>
              <input type="text" class="form-control input-glass" name="nama" placeholder="Nama Lengkap" required>
            </div>
            <div class="col-md-6 mb-3">
              <label class="font-weight-bold"><i class="fas fa-user-friends mr-1"></i>Usia</label>
              <input type="text" class="form-control input-glass" name="usia" placeholder="Contoh: 18-25 Tahun" required>
            </div>
            <div class="col-md-6 mb-3">
              <label class="font-weight-bold"><i class="fas fa-briefcase mr-1"></i>Pekerjaan</label>
              <input type="text" class="form-control input-glass" name="pekerjaan" placeholder="Contoh: Petani" required>
            </div>
            <div class="col-md-6 mb-3">
              <label class="font-weight-bold"><i class="fas fa-heart mr-1"></i>Status</label>
              <input type="text" class="form-control input-glass" name="status" placeholder="Contoh: Belum Kawin" required>
            </div>
            <div class="col-md-6 mb-3">
              <label class="font-weight-bold"><i class="fas fa-car mr-1"></i>Kendaraan</label>
              <input type="text" class="form-control input-glass" name="kendaraan" placeholder="Contoh: Motor" required>
            </div>
            <div class="col-md-6 mb-3">
              <label class="font-weight-bold"><i class="fas fa-money-bill-wave mr-1"></i>Penghasilan</label>
              <input type="text" class="form-control input-glass" name="penghasilan" placeholder="Contoh: 1000000 - 2000000" required>
            </div>
            <div class="col-md-6 mb-3">
              <label class="font-weight-bold"><i class="fas fa-home mr-1"></i>Kepemilikan</label>
              <input type="text" class="form-control input-glass" name="kepemilikan" placeholder="Contoh: Pribadi" required>
            </div>
            <div class="col-md-6 mb-3">
              <label class="font-weight-bold"><i class="fas fa-warehouse mr-1"></i>Atap Bangunan</label>
              <input type="text" class="form-control input-glass" name="atap_bangunan" placeholder="Contoh: Genteng" required>
            </div>
          </div>
        </div>
        <div class="modal-footer" style="background:rgba(250,253,255,0.95);border-top:none;padding:1.2rem 2.2rem 1.7rem 2.2rem;">
          <button type="submit" class="btn btn-success btn-glass mr-2" style="min-width:140px;font-size:1.08rem;font-weight:600;border-radius:2rem;box-shadow:0 2px 8px rgba(39,174,96,0.10);"><i class="fas fa-save mr-1"></i>Submit</button>
          <button type="button" class="btn btn-secondary btn-glass" data-dismiss="modal" style="min-width:110px;font-size:1.08rem;font-weight:600;border-radius:2rem;box-shadow:0 2px 8px rgba(51,102,153,0.10);"><i class="fas fa-times mr-1"></i>Batal</button>
        </div>
      </form>
    </div>
  </div>
</div>

<!-- Modal Pilih Periode Cetak -->
<div class="modal fade" id="modalCetakPeriode" tabindex="-1" role="dialog" aria-labelledby="modalCetakPeriodeLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content" style="border-radius:1rem;">
      <div class="modal-header" style="background: linear-gradient(90deg, #27ae60 0%, #00b894 100%); border-radius:1rem 1rem 0 0;">
        <h5 class="modal-title text-white font-weight-bold" id="modalCetakPeriodeLabel">
          <i class="fas fa-calendar-alt mr-2"></i>Pilih Periode Laporan
        </h5>
        <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close" style="opacity:1;">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <form id="formPilihPeriode" action="laporan_per_periode.php" method="get">
        <div class="modal-body" style="background:#fafdff;">
          <div class="form-group">
            <label for="bulanCetak"><i class="fas fa-calendar mr-1"></i>Bulan</label>
            <select class="form-control" id="bulanCetak" name="bulan" required>
              <option value="" disabled selected>Pilih Bulan</option>
              <option value="01">Januari</option>
              <option value="02">Februari</option>
              <option value="03">Maret</option>
              <option value="04">April</option>
              <option value="05">Mei</option>
              <option value="06">Juni</option>
              <option value="07">Juli</option>
              <option value="08">Agustus</option>
              <option value="09">September</option>
              <option value="10">Oktober</option>
              <option value="11">November</option>
              <option value="12">Desember</option>
            </select>
          </div>
          <div class="form-group">
            <label for="tahunCetak"><i class="fas fa-calendar-alt mr-1"></i>Tahun</label>
            <select class="form-control" id="tahunCetak" name="tahun" required>
              <!-- Tahun akan diisi via JS -->
            </select>
          </div>
        </div>
        <div class="modal-footer" style="background:#fafdff;">
          <button type="submit" class="btn btn-detail-periode-modal"><i class="fas fa-print mr-1"></i>Detail</button>
          <button type="button" class="btn btn-secondary" data-dismiss="modal"><i class="fas fa-times mr-1"></i>Tutup</button>
        </div>
      </form>
    </div>
  </div>
</div>

<footer class="page-footer font-small abu1 mt-5">
  <div class="footer-copyright text-center py-3 abu2">
    ©<?php echo date('Y'); ?> Naïve Bayes Classifier
  </div>
</footer>

<script src="js/jquery.js"></script>
<script src="jspopper.min.js"></script>
<script src="js/bootstrap.min.js"></script>
<script src="js/datatables.js"></script>
<!-- Chart.js CDN -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
  $(document).ready(function() {
    var table = $('#dataLatih').DataTable({
      "pageLength": 10,
      "columnDefs": [
        { "searchable": false, "orderable": false, "targets": 0 }
      ],
      "order": []
    });

    // Auto-numbering kolom No
    table.on('order.dt search.dt draw.dt', function () {
      table.column(0, {search:'applied', order:'applied'}).nodes().each(function (cell, i) {
        cell.innerHTML = i + 1;
      });
    }).draw();

    $("#btnTambahDataLatih").appendTo($('#dataLatih_filter'));

    $('#btnTambahDataLatih')
      .removeClass('btn-primary')
      .addClass('btn-info btn-xs shadow-sm')
      .css({
        'margin-top':'12px',
        'margin-bottom':'4px',
        'margin-left':'120px',
        'display':'block',
        'font-size':'0.70rem',
        'padding':'4px 16px',
        'border-radius':'16px',
        'font-weight':'600',
        'letter-spacing':'0.5px',
        'box-shadow':'0 2px 8px rgba(80,180,255,0.10)'
      })
      .html('<i class="fas fa-plus-circle mr-1"></i>Tambah Data Latih');

    $('#btnTambahDataLatih').on('click', function() {
      $('#modalTambahDataLatih').modal('show');
    });

    $('#formTambahDataLatih').on('submit', function(e) {
      e.preventDefault();
      var formData = $(this).serializeArray();
      var dataObj = {};
      formData.forEach(function(item) {
        dataObj[item.name] = item.value;
      });
      dataObj['keterangan'] = '-';

      // Tambahkan ke tabel DataTables (tanpa reload)
      table.row.add([
        "", // kolom No diisi otomatis
        dataObj['nama'],
        dataObj['pekerjaan'],
        dataObj['usia'],
        dataObj['status'],
        dataObj['penghasilan'],
        dataObj['kendaraan'],
        dataObj['kepemilikan'],
        dataObj['atap_bangunan'],
        '<span class="badge badge-secondary" style="padding:10px">-</span>',
        '<button class="btn btnPrintData btnDetailData" title="Detail" data-index="NEW">' +
        '<i class="fas fa-eye"></i> Detail</button>'
      ]).draw(false);

      // Simpan ke data.json via AJAX
      $.ajax({
        url: 'simpan_data_latih.php',
        method: 'POST',
        data: dataObj,
        success: function(res) {
          let hasil = res;
          if (typeof res === "string") hasil = JSON.parse(res);

          let badge = '-';
          if (hasil.keterangan === 'layak') {
            badge = "<span class='badge badge-success' style='padding:10px'>layak</span>";
          } else if (hasil.keterangan === 'tidak layak') {
            badge = "<span class='badge badge-danger' style='padding:10px'>tidak layak</span>";
          }

          // Update baris terakhir (data baru) dengan badge keterangan
          let rowIdx = table.rows().count() - 1;
          table.cell(rowIdx, 9).data(badge).draw(false);

          // Notifikasi sukses
          $('<div class="alert alert-success alert-dismissible fade show" role="alert" style="position:fixed;top:80px;right:30px;z-index:9999;min-width:220px;">' +
            '<i class="fas fa-check-circle mr-2"></i>Data berhasil ditambahkan!' +
            '<button type="button" class="close" data-dismiss="alert" aria-label="Close" style="outline:none;"><span aria-hidden="true">&times;</span></button>' +
            '</div>').appendTo('body');
          setTimeout(function() {
            $('.alert-success').alert('close');
          }, 2000);
        },
        error: function() {
          alert('Gagal menyimpan data ke file!');
        }
      });

      $('#modalTambahDataLatih').modal('hide');
      this.reset();
    });

    // Pie Chart Kelayakan (otomatis update)
    var ctx = document.getElementById('pieChartKelayakan').getContext('2d');
    var pieChart = new Chart(ctx, {
      type: 'pie',
      data: {
        labels: ['Layak', 'Tidak Layak'],
        datasets: [{
          data: [0, 0],
          backgroundColor: [
            'rgba(39, 174, 96, 0.8)',
            'rgba(231, 76, 60, 0.8)'
          ],
          borderColor: [
            'rgba(39, 174, 96, 1)',
            'rgba(231, 76, 60, 1)'
          ],
          borderWidth: 2
        }]
      },
      options: {
        responsive: true,
        plugins: {
          legend: {
            display: true,
            position: 'bottom',
            labels: {
              font: { size: 15 }
            }
          },
          title: {
            display: true,
            text: 'Distribusi Data Kelayakan',
            font: { size: 18 }
          }
        }
      }
    });

    function updatePieChart() {
      $.getJSON('data.json', function(data) {
        var layak = 0, tidak = 0;
        data.forEach(function(row) {
          if (row.keterangan && row.keterangan.toLowerCase() === 'layak') layak++;
          else if (row.keterangan && row.keterangan.toLowerCase() === 'tidak layak') tidak++;
        });
        pieChart.data.datasets[0].data = [layak, tidak];
        pieChart.update();
      });
    }
    updatePieChart();
    setInterval(updatePieChart, 5000); // update tiap 5 detik

    // Event Detail Data
    $('#dataLatih tbody').on('click', '.btnDetailData', function() {
      var rowIdx = $(this).attr('data-index');
      if (rowIdx === 'NEW') {
        rowIdx = table.rows().count() - 1;
      }
      // Ambil data dari tabel
      var rowData = table.row(rowIdx).data();
      // Misal tanggal ada di kolom ke-10 (index 9)
      var tanggal = rowData[9]; // Pastikan index sesuai kolom tanggal
      if (tanggal && tanggal.length >= 10) {
        var tahun = tanggal.substr(0,4);
        var bulan = tanggal.substr(5,2);
        window.location.href = 'laporan_per_periode.php?bulan=' + bulan + '&tahun=' + tahun;
      } else {
        alert('Tanggal tidak ditemukan pada data ini!');
      }
    });

    $('#btnCetakPeriode').on('click', function() {
      var tahunSekarang = new Date().getFullYear();
      var tahunMulai = 2025;
      var $tahunSelect = $('#tahunCetak');
      $tahunSelect.empty();
      $tahunSelect.append('<option value="" disabled selected>Pilih Tahun</option>');
      for (var t = tahunMulai; t <= tahunSekarang; t++) {
        $tahunSelect.append('<option value="'+t+'">'+t+'</option>');
      }
      $('#modalCetakPeriode').modal('show');
    });

    // Validasi sebelum submit form pilih periode
    $('#formPilihPeriode').on('submit', function(e) {
      var bulan = $('#bulanCetak').val();
      var tahun = $('#tahunCetak').val();
      if (!bulan || !tahun) {
        alert('Silakan pilih bulan dan tahun terlebih dahulu!');
        e.preventDefault();
        return false;
      }
      // Jika valid, biarkan form submit secara default (GET)
    });
  });
</script>
<style>
  .modal-glass {
    background: rgba(255,255,255,0.82) !important;
    backdrop-filter: blur(14px) !important;
    box-shadow: 0 8px 32px rgba(64,118,183,0.18), 0 2px 12px #eaf6ff !important;
    border-radius: 1.3rem !important;
    border: none !important;
    overflow: hidden;
  }
  .input-glass {
    background: rgba(255,255,255,0.65) !important;
    border: 1.5px solid #eaf6ff !important;
    border-radius: 1.2rem !important;
    box-shadow: 0 2px 8px rgba(51,102,153,0.06);
    font-size: 1.07rem;
    padding: 0.85rem 1.2rem;
    transition: border 0.18s, box-shadow 0.18s;
  }
  .input-glass:focus {
    border: 1.5px solid #4076b7 !important;
    box-shadow: 0 4px 16px rgba(64,118,183,0.13);
    background: #fff !important;
  }
  .btn-glass {
    box-shadow: 0 2px 8px rgba(51,102,153,0.08);
    border-radius: 2rem;
    font-weight: 600;
    letter-spacing: 0.5px;
    transition: all 0.18s;
  }
  .btn-glass:active, .btn-glass:focus {
    outline: 2.5px solid #4076b7;
    outline-offset: 2.5px;
  }
  @media (max-width: 600px) {
    .modal-body {
      padding: 1.1rem 0.7rem 0.7rem 0.7rem !important;
    }
    .modal-footer {
      padding: 1.1rem 0.7rem 1.2rem 0.7rem !important;
    }
  }
</style>

</body>
</html>
