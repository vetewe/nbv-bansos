<?php
require_once 'autoload.php';

$obj = new Bayes();

$jumLayak      = $obj->sumLayak();
$jumTidakLayak = $obj->sumTidakLayak();
$jumData       = $obj->sumData();

// Contoh input data (ubah sesuai kebutuhan)
$input = [
    'pekerjaan'      => "Wiraswasta",
    'usia'           => "20-29 Tahun",
    'status'         => "Belum Kawin",
    'penghasilan'    => "2000000-3000000",
    'kendaraan'      => "Motor",
    'kepemilikan'    => "Orang Tua",
    'atap_bangunan'  => "Asbes"
];

// Probabilitas atribut (tanpa Laplace smoothing)
$prob_layak = [
    $obj->probPekerjaanUtama($input['pekerjaan'], 1),
    $obj->probUsiaUtama($input['usia'], 1),
    $obj->probStatusUtama($input['status'], 1),
    $obj->probPenghasilanUtama($input['penghasilan'], 1),
    $obj->probKendaraanUtama($input['kendaraan'], 1),
    $obj->probKepemilikanUtama($input['kepemilikan'], 1),
    $obj->probAtapUtama($input['atap_bangunan'], 1)
];

$prob_tidak = [
    $obj->probPekerjaanUtama($input['pekerjaan'], 0),
    $obj->probUsiaUtama($input['usia'], 0),
    $obj->probStatusUtama($input['status'], 0),
    $obj->probPenghasilanUtama($input['penghasilan'], 0),
    $obj->probKendaraanUtama($input['kendaraan'], 0),
    $obj->probKepemilikanUtama($input['kepemilikan'], 0),
    $obj->probAtapUtama($input['atap_bangunan'], 0)
];

// Hitung probabilitas akhir (tanpa Laplace)
$paLayak      = $obj->hasilLayakUtama($jumLayak, $jumData, ...$prob_layak);
$paTidakLayak = $obj->hasilTidakLayakUtama($jumTidakLayak, $jumData, ...$prob_tidak);

$result = $obj->perbandingan($paLayak, $paTidakLayak);

echo "<pre>";
echo "======================================\n";
echo "Input Data:\n";
foreach ($input as $k => $v) {
    echo ucfirst(str_replace('_', ' ', $k)) . " : $v\n";
}
echo "======================================\n\n";

echo "======================================\n";
echo "Probabilitas Kelas:\n";
echo "Jumlah Layak        : $jumLayak\n";
echo "Jumlah Tidak Layak  : $jumTidakLayak\n";
echo "Jumlah Data         : $jumData\n";
echo "======================================\n\n";

echo "======================================\n";
echo "PREDIKSI:\n";
echo "Layak        : $paLayak\n";
echo "Tidak Layak  : $paTidakLayak\n";
echo "======================================\n\n";

if ($paLayak > $paTidakLayak) {
    echo "PREDIKSI: LAYAK lebih besar dari TIDAK LAYAK\n";
} elseif ($paTidakLayak > $paLayak) {
    echo "PREDIKSI: TIDAK LAYAK lebih besar dari LAYAK\n";
} else {
    echo "PREDIKSI: NILAI SAMA\n";
}

echo "\nStatus Prediksi : {$result[0]}\n";
echo "Persentase Layak       : " . round($result[1], 2) . " %\n";
echo "Persentase Tidak Layak : " . round($result[2], 2) . " %\n";
echo "</pre>";
?>
