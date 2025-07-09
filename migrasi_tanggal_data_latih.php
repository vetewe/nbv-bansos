<?php
// Script migrasi untuk menambahkan field 'tanggal_pengajuan' pada data lama di data.json

$file = 'data.json';
$defaultTanggal = '2025-07-03';

if (!file_exists($file)) {
    die('File data.json tidak ditemukan.');
}

$data = json_decode(file_get_contents($file), true);

if (!is_array($data)) {
    die('Format data.json tidak valid.');
}

$updated = false;
foreach ($data as $i => $item) {
    // Pastikan field tanggal_pengajuan benar-benar ditambahkan jika belum ada
    if (!array_key_exists('tanggal_pengajuan', $item)) {
        $data[$i]['tanggal_pengajuan'] = $defaultTanggal;
        $updated = true;
    }
}

if ($updated) {
    // Simpan ulang data.json dengan field baru
    file_put_contents($file, json_encode($data, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE));
    echo "Migrasi selesai. Field 'tanggal_pengajuan' telah ditambahkan pada data yang belum memilikinya.";
} else {
    echo "Semua data sudah memiliki field 'tanggal_pengajuan'. Tidak ada perubahan.";
} 