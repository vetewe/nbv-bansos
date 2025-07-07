<?php
require_once 'autoload.php';

function prediksi_kelayakan($data) {
    $obj = new Bayes();

    // Ambil jumlah data untuk masing-masing kelas
    $jumLayak      = $obj->sumLayak();
    $jumTidakLayak = $obj->sumTidakLayak();
    $jumData       = $obj->sumData();

    // Ambil atribut dari data input
    $atribut = [
        'pekerjaan'      => $data['pekerjaan'],
        'usia'           => $data['usia'],
        'status'         => $data['status'],
        'penghasilan'    => $data['penghasilan'],
        'kendaraan'      => $data['kendaraan'],
        'kepemilikan'    => $data['kepemilikan'],
        'atap_bangunan'  => $data['atap_bangunan'],
    ];

    // Hitung probabilitas untuk kelas layak dan tidak layak (Laplace Smoothing)
    $prob_layak = [
        $obj->probPekerjaanLaplace($atribut['pekerjaan'], isLayak: 1),
        $obj->probUsiaLaplace($atribut['usia'], 1),
        $obj->probStatusLaplace($atribut['status'], 1),
        $obj->probPenghasilanLaplace($atribut['penghasilan'], 1),
        $obj->probKendaraanLaplace($atribut['kendaraan'], 1),
        $obj->probKepemilikanLaplace($atribut['kepemilikan'], 1),
        $obj->probAtapLaplace($atribut['atap_bangunan'], 1)
    ];

    $prob_tidak = [
        $obj->probPekerjaanLaplace($atribut['pekerjaan'], 0),
        $obj->probUsiaLaplace($atribut['usia'], 0),
        $obj->probStatusLaplace($atribut['status'], 0),
        $obj->probPenghasilanLaplace($atribut['penghasilan'], 0),
        $obj->probKendaraanLaplace($atribut['kendaraan'], 0),
        $obj->probKepemilikanLaplace($atribut['kepemilikan'], 0),
        $obj->probAtapLaplace($atribut['atap_bangunan'], 0)
    ];

    // Hitung probabilitas akhir untuk masing-masing kelas (Laplace)
    $paLayak = $obj->hasilLayakLaplace($jumLayak, $jumData, ...$prob_layak);
    $paTidakLayak = $obj->hasilTidakLayakLaplace($jumTidakLayak, $jumData, ...$prob_tidak);

    return ($paLayak > $paTidakLayak) ? 'layak' : 'tidak layak';
}