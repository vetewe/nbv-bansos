<?php
require_once 'autoload.php';

$obj = new Bayes();

$jumLayak      = $obj->sumLayak();
$jumTidakLayak = $obj->sumTidakLayak();
$jumData       = $obj->sumData();

$a1   = $_POST['pekerjaan'];
$a2   = $_POST['usia'];
$a3   = $_POST['status'];
$a4   = $_POST['penghasilan'];
$a5   = $_POST['kendaraan'];
$a6   = $_POST['kepemilikan'];
$a7   = $_POST['atap_bangunan'];
$nama = isset($_POST['nama']) && trim($_POST['nama']) !== '' ? $_POST['nama'] : '-';

// Probabilitas atribut (tanpa Laplace smoothing)
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

// Hitung probabilitas akhir (tanpa Laplace)
$paLayak      = $obj->hasilLayakUtama($jumLayak, $jumData, $pekerjaan_layak, $usia_layak, $status_layak, $penghasilan_layak, $kendaraan_layak, $kepemilikan_layak, $atap_layak);
$paTidakLayak = $obj->hasilTidakLayakUtama($jumTidakLayak, $jumData, $pekerjaan_tidak, $usia_tidak, $status_tidak, $penghasilan_tidak, $kendaraan_tidak, $kepemilikan_tidak, $atap_tidak);

$result           = $obj->perbandingan($paLayak, $paTidakLayak);
$persenLayak      = round($result[1], 2);
$persenTidakLayak = round($result[2], 2);
$hasil_prediksi   = ($paLayak > $paTidakLayak) ? "layak" : "tidak layak";

// --- OUTPUT ---
echo "<div class='hasil-modern-container'>";

// Ringkasan Data
echo "
  <div class='hasil-card'>
    <div class='hasil-header'>
      <i class='fas fa-database hasil-icon'></i>
      <span>Ringkasan Data</span>
    </div>
    <div class='hasil-body'>
      <div class='hasil-row'><span>Jumlah Layak</span><span class='hasil-value'>{$jumLayak}</span></div>
      <div class='hasil-row'><span>Jumlah Tidak Layak</span><span class='hasil-value'>{$jumTidakLayak}</span></div>
      <div class='hasil-row'><span>Jumlah Total Data</span><span class='hasil-value'>{$jumData}</span></div>
    </div>
  </div>
";

// Probabilitas Setiap Kriteria
echo "
  <div class='hasil-card'>
    <div class='hasil-header'>
      <i class='fas fa-table hasil-icon'></i>
      <span>Probabilitas Setiap Kriteria</span>
    </div>
    <div class='hasil-body'>
      <table class='tabel-modern'>
        <tr>
          <th>Kriteria</th>
          <th>Layak</th>
          <th>Tidak Layak</th>
        </tr>
        <tr><td>pA</td><td>{$jumLayak} / {$jumData}</td><td>{$jumTidakLayak} / {$jumData}</td></tr>
        <tr><td>Pekerjaan</td><td>{$pekerjaan_layak}</td><td>{$pekerjaan_tidak}</td></tr>
        <tr><td>Usia</td><td>{$usia_layak}</td><td>{$usia_tidak}</td></tr>
        <tr><td>Status</td><td>{$status_layak}</td><td>{$status_tidak}</td></tr>
        <tr><td>Penghasilan</td><td>{$penghasilan_layak}</td><td>{$penghasilan_tidak}</td></tr>
        <tr><td>Kendaraan</td><td>{$kendaraan_layak}</td><td>{$kendaraan_tidak}</td></tr>
        <tr><td>Kepemilikan</td><td>{$kepemilikan_layak}</td><td>{$kepemilikan_tidak}</td></tr>
        <tr><td>Atap Bangunan</td><td>{$atap_layak}</td><td>{$atap_tidak}</td></tr>
      </table>
    </div>
  </div>
";

// Hasil Prediksi
echo "
  <div class='hasil-card'>
    <div class='hasil-header'>
      <i class='fas fa-percentage hasil-icon'></i>
      <span>Hasil Prediksi</span>
    </div>
    <div class='hasil-body'>
      <table class='tabel-modern'>
        <tr>
          <th class='tabel-label'>PREDIKSI Layak</th>
          <td><b>{$paLayak}</b></td>
        </tr>
        <tr>
          <th class='tabel-label'>PREDIKSI Tidak Layak</th>
          <td><b>{$paTidakLayak}</b></td>
        </tr>
      </table>
    </div>
  </div>
";

// Info Prediksi
if ($paLayak > $paTidakLayak) {
  echo "
    <div class='hasil-prediksi-info hasil-layak'>
      <span class='badge-prediksi badge-layak'><i class='fas fa-check-circle'></i> LAYAK</span>
      <span>PREDIKSI LAYAK LEBIH BESAR DARI TIDAK LAYAK</span>
      <div class='hasil-persen'>
        <span>PREDIKSI layak: <b>{$persenLayak} %</b></span>
        <span>PREDIKSI tidak layak: <b>{$persenTidakLayak} %</b></span>
      </div>
    </div>
  ";
} else {
  echo "
    <div class='hasil-prediksi-info hasil-tidaklayak'>
      <span class='badge-prediksi badge-tidaklayak'><i class='fas fa-times-circle'></i> TIDAK LAYAK</span>
      <span>PREDIKSI TIDAK LAYAK LEBIH BESAR DARI LAYAK</span>
      <div class='hasil-persen'>
        <span>PREDIKSI tidak layak: <b>{$persenTidakLayak} %</b></span>
        <span>PREDIKSI layak: <b>{$persenLayak} %</b></span>
      </div>
    </div>
  ";
}

// Card Kesimpulan
if ($result[0] == "LAYAK") {
  echo "
    <div class='kesimpulan-card'>
      <h4>Kesimpulan : LAYAK</h4>
      Selamat! berdasarkan hasil perhitungan Naive Bayes, anda diprediksi <b>layak!</b> sebagai penerima bantuan surat keterangan tidak mampu.
      <hr style='border-top:1.5px solid #27ae60;'>
    </div>
  ";
} else {
  echo "
    <div class='kesimpulan-card' style='background:#ffeaea;border:1.5px solid #ffb3b3;'>
      <h4 style='color:#e74c3c;'>Kesimpulan : TIDAK LAYAK</h4>
      Maaf, berdasarkan hasil perhitungan Naive Bayes, anda diprediksi <b>tidak layak!</b> sebagai penerima bantuan surat keterangan tidak mampu.
      <hr style='border-top:1.5px solid #e74c3c;'>
    </div>
  ";
}

// Simpan data baru jika nama diisi
if ($nama !== '-') {
    $dataFile = 'data.json';
    $dataBaru = [
        "nama"         => $nama,
        "pekerjaan"    => $a1,
        "usia"         => $a2,
        "status"       => $a3,
        "penghasilan"  => $a4,
        "kendaraan"    => $a5,
        "kepemilikan"  => $a6,
        "atap_bangunan"=> $a7,
        "keterangan"   => $hasil_prediksi
    ];
    $data = [];
    if (file_exists($dataFile)) {
        $data = json_decode(file_get_contents($dataFile), true);
        if (!is_array($data)) $data = [];
    }
    $data[] = $dataBaru;
    file_put_contents($dataFile, json_encode($data, JSON_PRETTY_PRINT));
}

echo "</div>";

