<?php

class Bayes
{
    private $bansos = "data.json";

    // Jumlah kemungkinan nilai atribut (untuk Laplace smoothing)
    private $nPekerjaan   = 2;
    private $nUsia        = 2;
    private $nStatus      = 2;
    private $nPenghasilan = 4;
    private $nKendaraan   = 3;
    private $nKepemilikan = 3;
    private $nAtap        = 2;

    private function getData()
    {
        $data = file_get_contents($this->bansos);
        return json_decode($data, true);
    }

    // SUM LAYAK & TIDAK LAYAK
    function sumLayak()
    {
        $hasil = $this->getData();
        return count(array_filter($hasil, function ($row) {
            return isset($row['keterangan']) && strtolower($row['keterangan']) == "layak";
        }));
    }

    function sumTidakLayak()
    {
        $hasil = $this->getData();
        return count(array_filter($hasil, function ($row) {
            return isset($row['keterangan']) && strtolower($row['keterangan']) == "tidak layak";
        }));
    }

    function sumData()
    {
        $hasil = $this->getData();
        return count($hasil);
    }

    // PROBABILITAS UTAMA (TANPA LAPLACE SMOOTHING)
    private function probAtributUtama($atribut, $value, $isLayak)
    {
        $hasil = $this->getData();
        $target = $isLayak ? "layak" : "tidak layak";
        $count = 0;
        $total = 0;
        foreach ($hasil as $row) {
            if (isset($row['keterangan']) && strtolower($row['keterangan']) == $target) {
                $total++;
                if (isset($row[$atribut]) && $row[$atribut] == $value) {
                    $count++;
                }
            }
        }
        // Jika total 0, return 0 agar tidak error
        return $total > 0 ? $count / $total : 0;
    }

    function probPekerjaanUtama($pekerjaan, $isLayak)
    {
        return $this->probAtributUtama('pekerjaan', $pekerjaan, $isLayak);
    }

    function probUsiaUtama($usia, $isLayak)
    {
        return $this->probAtributUtama('usia', $usia, $isLayak);
    }

    function probStatusUtama($status, $isLayak)
    {
        return $this->probAtributUtama('status', $status, $isLayak);
    }

    function probPenghasilanUtama($penghasilan, $isLayak)
    {
        return $this->probAtributUtama('penghasilan', $penghasilan, $isLayak);
    }

    function probKendaraanUtama($kendaraan, $isLayak)
    {
        return $this->probAtributUtama('kendaraan', $kendaraan, $isLayak);
    }

    function probKepemilikanUtama($kepemilikan, $isLayak)
    {
        return $this->probAtributUtama('kepemilikan', $kepemilikan, $isLayak);
    }

    function probAtapUtama($atap, $isLayak)
    {
        return $this->probAtributUtama('atap_bangunan', $atap, $isLayak);
    }

    // PROBABILITAS DATA LATIH BARU (DENGAN LAPLACE SMOOTHING)
    private function probAtributLaplace($atribut, $value, $isLayak, $nKategori)
    {
        $hasil = $this->getData();
        $target = $isLayak ? "layak" : "tidak layak";
        $count = 0;
        $total = 0;
        foreach ($hasil as $row) {
            if (isset($row['keterangan']) && strtolower($row['keterangan']) == $target) {
                $total++;
                if (isset($row[$atribut]) && $row[$atribut] == $value) {
                    $count++;
                }
            }
        }
        // Laplace smoothing
        return ($count + 1) / ($total + $nKategori);
    }

    function probPekerjaanLaplace($pekerjaan, $isLayak)
    {
        return $this->probAtributLaplace('pekerjaan', $pekerjaan, $isLayak, $this->nPekerjaan);
    }

    function probUsiaLaplace($usia, $isLayak)
    {
        return $this->probAtributLaplace('usia', $usia, $isLayak, $this->nUsia);
    }

    function probStatusLaplace($status, $isLayak)
    {
        return $this->probAtributLaplace('status', $status, $isLayak, $this->nStatus);
    }

    function probPenghasilanLaplace($penghasilan, $isLayak)
    {
        return $this->probAtributLaplace('penghasilan', $penghasilan, $isLayak, $this->nPenghasilan);
    }

    function probKendaraanLaplace($kendaraan, $isLayak)
    {
        return $this->probAtributLaplace('kendaraan', $kendaraan, $isLayak, $this->nKendaraan);
    }

    function probKepemilikanLaplace($kepemilikan, $isLayak)
    {
        return $this->probAtributLaplace('kepemilikan', $kepemilikan, $isLayak, $this->nKepemilikan);
    }

    function probAtapLaplace($atap, $isLayak)
    {
        return $this->probAtributLaplace('atap_bangunan', $atap, $isLayak, $this->nAtap);
    }

    // HITUNG NAIVE BAYES UTAMA (TANPA LAPLACE)
    function hasilLayakUtama($sLayak, $sData, ...$probs)
    {
        if ($sLayak == 0 || $sData == 0) return 0;
        $paLayak = $sLayak / $sData;
        $hasil = $paLayak;
        foreach ($probs as $p) {
            $hasil *= $p;
        }
        return $hasil;
    }

    function hasilTidakLayakUtama($sTidakLayak, $sData, ...$probs)
    {
        if ($sTidakLayak == 0 || $sData == 0) return 0;
        $paTidakLayak = $sTidakLayak / $sData;
        $hasil = $paTidakLayak;
        foreach ($probs as $p) {
            $hasil *= $p;
        }
        return $hasil;
    }

    // HITUNG NAIVE BAYES DATA LATIH BARU (DENGAN LAPLACE)
    function hasilLayakLaplace($sLayak, $sData, ...$probs)
    {
        if ($sLayak == 0 || $sData == 0) return 0;
        $paLayak = $sLayak / $sData;
        $hasil = $paLayak;
        foreach ($probs as $p) {
            $hasil *= $p;
        }
        return $hasil;
    }

    function hasilTidakLayakLaplace($sTidakLayak, $sData, ...$probs)
    {
        if ($sTidakLayak == 0 || $sData == 0) return 0;
        $paTidakLayak = $sTidakLayak / $sData;
        $hasil = $paTidakLayak;
        foreach ($probs as $p) {
            $hasil *= $p;
        }
        return $hasil;
    }

    function perbandingan($pLayak, $pTidakLayak)
    {
        if ($pLayak > $pTidakLayak) {
            $stt = "LAYAK";
            $persenLayak = ($pLayak / ($pLayak + $pTidakLayak)) * 100;
            $persenTidakLayak = 100 - $persenLayak;
        } elseif ($pTidakLayak > $pLayak) {
            $stt = "TIDAK LAYAK";
            $persenTidakLayak = ($pTidakLayak / ($pLayak + $pTidakLayak)) * 100;
            $persenLayak = 100 - $persenTidakLayak;
        } else {
            $stt = "SAMA";
            $persenLayak = $persenTidakLayak = 50;
        }
        return array($stt, $persenLayak, $persenTidakLayak);
    }
}
