<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    require_once 'fp_new_dl.php';
    $dataFile = 'data.json';
    $fields = ['nama', 'pekerjaan', 'usia', 'status', 'penghasilan', 'kendaraan', 'kepemilikan', 'atap_bangunan'];
    $dataBaru = [];
    foreach ($fields as $field) {
        $dataBaru[$field] = $_POST[$field] ?? '';
    }
    $dataBaru['keterangan'] = prediksi_kelayakan($dataBaru);
    $dataBaru['tanggal_pengajuan'] = date('Y-m-d');
    $data = [];
    if (file_exists($dataFile)) {
        $json = file_get_contents($dataFile);
        $data = json_decode($json, true);
        if (!is_array($data)) $data = [];
    }
    $data[] = $dataBaru;
    file_put_contents($dataFile, json_encode($data, JSON_PRETTY_PRINT));
    echo json_encode([
        'status' => 'success',
        'keterangan' => $dataBaru['keterangan']
    ]);
    exit;
}
echo json_encode(['status' => 'error']);