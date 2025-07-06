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
              <div class="d-flex justify-content-between align-items-center mb-2">
                <div></div>
                <button class="btn btn-primary btn-sm" id="btnTambahDataLatih">
                  <i class="fas fa-plus mr-1"></i>Tambah Data Latih
                </button>
              </div>
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
                  </tr>
                </thead>
                <tbody>
                <?php
                  $dataFile = 'data.json';
                  $json = file_get_contents($dataFile);
                  $hasil = json_decode($json, true);
                  $no = 1;
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
    <div class="modal-content" style="border-radius:1rem;">
      <div class="modal-header" style="background: linear-gradient(90deg, #4076b7 0%, #6ba6df 100%); border-radius:1rem 1rem 0 0;">
        <h5 class="modal-title text-white font-weight-bold" id="modalTambahDataLatihLabel">
          <i class="fas fa-plus-circle mr-2"></i>Tambah Data Latih
        </h5>
        <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close" style="opacity:1;">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <form id="formTambahDataLatih" autocomplete="off">
        <div class="modal-body" style="background:#fafdff;">
          <div class="row">
            <div class="col-md-6 mb-3">
              <label><i class="fas fa-user mr-1"></i>Nama</label>
              <input type="text" class="form-control" name="nama" placeholder="Nama Lengkap" required>
            </div>
            <div class="col-md-6 mb-3">
              <label><i class="fas fa-user-friends mr-1"></i>Usia</label>
              <input type="text" class="form-control" name="usia" placeholder="Contoh: 18-25 Tahun" required>
            </div>
            <div class="col-md-6 mb-3">
              <label><i class="fas fa-briefcase mr-1"></i>Pekerjaan</label>
              <input type="text" class="form-control" name="pekerjaan" placeholder="Contoh: Petani" required>
            </div>
            <div class="col-md-6 mb-3">
              <label><i class="fas fa-heart mr-1"></i>Status</label>
              <input type="text" class="form-control" name="status" placeholder="Contoh: Belum Kawin" required>
            </div>
            <div class="col-md-6 mb-3">
              <label><i class="fas fa-car mr-1"></i>Kendaraan</label>
              <input type="text" class="form-control" name="kendaraan" placeholder="Contoh: Motor" required>
            </div>
            <div class="col-md-6 mb-3">
              <label><i class="fas fa-money-bill-wave mr-1"></i>Penghasilan</label>
              <input type="text" class="form-control" name="penghasilan" placeholder="Contoh: 1000000 - 2000000" required>
            </div>
            <div class="col-md-6 mb-3">
              <label><i class="fas fa-home mr-1"></i>Kepemilikan</label>
              <input type="text" class="form-control" name="kepemilikan" placeholder="Contoh: Pribadi" required>
            </div>
            <div class="col-md-6 mb-3">
              <label><i class="fas fa-warehouse mr-1"></i>Atap Bangunan</label>
              <input type="text" class="form-control" name="atap_bangunan" placeholder="Contoh: Genteng" required>
            </div>
          </div>
        </div>
        <div class="modal-footer" style="background:#fafdff;">
          <button type="submit" class="btn btn-success"><i class="fas fa-save mr-1"></i>Submit</button>
          <button type="button" class="btn btn-secondary" data-dismiss="modal"><i class="fas fa-times mr-1"></i>Batal</button>
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
        '<span class="badge badge-secondary" style="padding:10px">-</span>'
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
  });
</script>

</body>
</html>
