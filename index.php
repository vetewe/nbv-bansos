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
  <title>Prediksi Naive Bayes</title>
</head>
<body>

<?php
$data_json = [];
if (file_exists('data.json')) {
  $json = file_get_contents('data.json');
  $data_json = json_decode($json, true);
}

function unique_options($data_json, $field) {
  $opts = [];
  foreach ($data_json as $row) {
    if (!empty($row[$field]) && !in_array($row[$field], $opts)) {
      $opts[] = $row[$field];
    }
  }
  sort($opts);
  return $opts;
}
?>

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
        <li class="nav-item active"><a class="nav-link" href="index.php">Prediksi<span class="sr-only">(current)</span></a></li>
        <li class="nav-item"><a class="nav-link" href="data_studi_kasus.php">Data</a></li>
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
            <i class="fas fa-search mr-2"></i>Prediksi Kelayakan Bantuan Sosial
          </h3>
          <div style="font-size:1.1rem;font-weight:400;color:#eaf6ff;">
            Metode Naive Bayes
          </div>
        </div>
        <div class="card-body p-4" style="background:#fafdff;">
          <section style="max-width:1000px;margin:auto;">
            <form method="POST" onsubmit="return simulasi()">
              <div class="form-row">
                <div class="form-group col-12">
                  <label for="nama" class="form-label"><i class="fas fa-user"></i> Nama</label>
                  <input type="text" name="nama" id="nama" class="form-control" placeholder="Nama Lengkap" required>
                </div>
              </div>
              <div class="form-row">
                <div class="form-group col-md-6">
                  <label for="pekerjaan" class="form-label"><i class="fas fa-briefcase"></i> Pekerjaan</label>
                  <select name="pekerjaan" id="pekerjaan" class="form-control selBox" required>
                    <option value="" disabled selected>-- pilih pekerjaan --</option>
                    <?php foreach(unique_options($data_json, 'pekerjaan') as $opt): ?>
                      <option value="<?= htmlspecialchars($opt) ?>"><?= htmlspecialchars($opt) ?></option>
                    <?php endforeach; ?>
                  </select>
                </div>
                <div class="form-group col-md-6">
                  <label for="usia" class="form-label"><i class="fas fa-user-clock"></i> Usia</label>
                  <select name="usia" id="usia" class="form-control selBox" required>
                    <option value="" disabled selected>-- pilih usia --</option>
                    <?php foreach(unique_options($data_json, 'usia') as $opt): ?>
                      <option value="<?= htmlspecialchars($opt) ?>"><?= htmlspecialchars($opt) ?></option>
                    <?php endforeach; ?>
                  </select>
                </div>
              </div>
              <div class="form-row">
                <div class="form-group col-md-6">
                  <label for="status" class="form-label"><i class="fas fa-heart"></i> Status</label>
                  <select name="status" id="status" class="form-control selBox" required>
                    <option value="" disabled selected>-- pilih status --</option>
                    <?php foreach(unique_options($data_json, 'status') as $opt): ?>
                      <option value="<?= htmlspecialchars($opt) ?>"><?= htmlspecialchars($opt) ?></option>
                    <?php endforeach; ?>
                  </select>
                </div>
                <div class="form-group col-md-6">
                  <label for="penghasilan" class="form-label"><i class="fas fa-money-bill-wave"></i> Penghasilan</label>
                  <select name="penghasilan" id="penghasilan" class="form-control selBox" required>
                    <option value="" disabled selected>-- pilih penghasilan --</option>
                    <?php foreach(unique_options($data_json, 'penghasilan') as $opt): ?>
                      <option value="<?= htmlspecialchars($opt) ?>"><?= htmlspecialchars($opt) ?></option>
                    <?php endforeach; ?>
                  </select>
                </div>
              </div>
              <div class="form-row">
                <div class="form-group col-md-6">
                  <label for="kendaraan" class="form-label"><i class="fas fa-car"></i> Kendaraan</label>
                  <select name="kendaraan" id="kendaraan" class="form-control selBox" required>
                    <option value="" disabled selected>-- pilih kendaraan --</option>
                    <?php foreach(unique_options($data_json, 'kendaraan') as $opt): ?>
                      <option value="<?= htmlspecialchars($opt) ?>"><?= htmlspecialchars($opt) ?></option>
                    <?php endforeach; ?>
                  </select>
                </div>
                <div class="form-group col-md-6">
                  <label for="kepemilikan" class="form-label"><i class="fas fa-home"></i> Kepemilikan</label>
                  <select name="kepemilikan" id="kepemilikan" class="form-control selBox" required>
                    <option value="" disabled selected>-- pilih kepemilikan --</option>
                    <?php foreach(unique_options($data_json, 'kepemilikan') as $opt): ?>
                      <option value="<?= htmlspecialchars($opt) ?>"><?= htmlspecialchars($opt) ?></option>
                    <?php endforeach; ?>
                  </select>
                </div>
              </div>
              <div class="form-row">
                <div class="form-group col-12">
                  <label for="atap_bangunan" class="form-label"><i class="fas fa-warehouse"></i> Atap Bangunan</label>
                  <select name="atap_bangunan" id="atap_bangunan" class="form-control selBox" required>
                    <option value="" disabled selected>-- pilih atap bangunan --</option>
                    <?php foreach(unique_options($data_json, 'atap_bangunan') as $opt): ?>
                      <option value="<?= htmlspecialchars($opt) ?>"><?= htmlspecialchars($opt) ?></option>
                    <?php endforeach; ?>
                  </select>
                </div>
              </div>
              <div class="form-row justify-content-center mt-4">
                <button type="submit" class="btn btn-success mr-2">
                  <i class="fas fa-paper-plane"></i> Submit
                </button>
                <button type="reset" class="btn btn-secondary">
                  <i class="fas fa-sync-alt"></i> Reset
                </button>
              </div>
            </form>
          </section>
        </div>
      </div>
      <div class="col-12 mt-2 mb-3">
        <div class="card shadow-lg border-0 rounded-lg" style="background:#fafdff;">
          <div class="card-header text-white text-center" style="background: linear-gradient(90deg, #4076b7 0%, #6ba6df 100%) !important; border-radius:0.7rem 0.7rem 0 0;">
            <h5 class="mb-0" style="font-family: 'Poppins', sans-serif; font-weight:600;">
              <i class="fas fa-check-circle mr-2"></i>Hasil Prediksi
            </h5>
          </div>
          <div class="card-body" id="hasilSIM" style="min-height:60px;">
            <div class="text-center text-muted" style="font-size:1.05rem;">
              Silakan masukkan data prediksi terlebih dahulu
            </div>
          </div>
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
<script src="jspopper.min.js"></script>
<script src="js/bootstrap.min.js"></script>
<script>
  function simulasi() {
    const fields = [
      { id: "nama", msg: "Nama tidak boleh kosong" },
      { id: "pekerjaan", msg: "Pekerjaan tidak boleh kosong" },
      { id: "usia", msg: "Usia tidak boleh kosong" },
      { id: "status", msg: "Status tidak boleh kosong" },
      { id: "penghasilan", msg: "Penghasilan tidak boleh kosong" },
      { id: "kendaraan", msg: "Kendaraan tidak boleh kosong" },
      { id: "kepemilikan", msg: "Kepemilikan tidak boleh kosong" },
      { id: "atap_bangunan", msg: "Atap Bangunan tidak boleh kosong" }
    ];

    let data = {};
    for (let field of fields) {
      let val = $("#" + field.id).val();
      if (!val) {
        alert(field.msg);
        return false;
      }
      data[field.id] = val;
    }

    $.ajax({
      url: 'studi_kasus.php',
      type: 'POST',
      dataType: 'html',
      data: data,
      success: function (data) {
        $("#hasilSIM").html(data);
        $('html, body').animate({
          scrollTop: $("#hasilSIM").offset().top
        }, 500);
      }
    });

    return false;
  }

  $(document).ready(function () {
    $('form').on('reset', function () {
      setTimeout(function () {
        $('#hasilSIM').html(
          '<div class="text-center text-muted" style="font-size:1.05rem;">' +
          'Silakan masukkan data prediksi terlebih dahulu' +
          '</div>'
        );
      }, 10);
    });
  });
</script>
</body>
</html>
