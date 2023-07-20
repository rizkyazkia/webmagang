<?php
function getHari($Day)
{
    switch ($Day) {
        case 'Sunday':
            $hari = 'MINGGU';
            break;
        case 'Monday':
            $hari = 'SENIN';
            break;
        case 'Tuesday':
            $hari = 'SELASA';
            break;
        case 'Wednesday':
            $hari = 'RABU';
            break;
        case 'Thursday':
            $hari = 'KAMIS';
            break;
        case 'Friday':
            $hari = 'JUM\'AT';
            break;
        case 'Saturday':
            $hari = 'SABTU';
            break;
        default:
            $hari = 'Tidak ada';
            break;
    }
    return $hari;
}

function getBulan($Bulan)
{
    switch ($Bulan) {
        case 'January':
            $Bulan = 'JANUARI';
            break;
        case 'February':
            $Bulan = 'FEBRUARI';
            break;
        case 'March':
            $Bulan = 'MARET';
            break;
        case 'May':
            $Bulan = 'MEI';
            break;
        case 'June':
            $Bulan = 'JUNI';
            break;
        case 'July':
            $Bulan = 'JULI';
            break;
        case 'August':
            $Bulan = 'AGUSTUS';
            break;
        case 'September':
            $Bulan = 'SEPTEMBER';
            break;
        case 'October':
            $Bulan = 'OKTOBER';
            break;
        case 'November':
            $Bulan = 'NOVEMBER';
            break;
        case 'December':
            $Bulan = 'DESEMBER';
            break;
        default:
            break;
    }
    return $Bulan;
}

function penyebut($tanggal)
{
    $tanggal    = abs($tanggal);
    $kata       = array("", "SATU", "DUA", "TIGA", "EMPAT", "LIMA", "ENAM", "TUJUH", "DELAPAN", "SEMBILAN", "SEPULUH", "SEBELAS");
    $temp       = "";
    if ($tanggal < 12) {
        $temp = " " . $kata[$tanggal];
    } else if ($tanggal < 20) {
        $temp = penyebut($tanggal - 10) . " BELAS";
    } else if ($tanggal < 100) {
        $temp = penyebut($tanggal / 10) . " PULUH" . penyebut($tanggal % 10);
    }
    return $temp;
}

function pembilang($tanggal)
{
    if ($tanggal < 0) {
        $hasil = "Tanggal tidak valid";
    } else {
        $hasil = trim(penyebut($tanggal));
    }
    return $hasil;
}

function penyebut2($tanggal)
{
    $tanggal    = abs($tanggal);
    $kata       = array("", "SATU", "DUA", "TIGA", "EMPAT", "LIMA", "ENAM", "TUJUH", "DELAPAN", "SEMBILAN", "SEPULUH", "SEBELAS");
    $temp       = "";
    if ($tanggal < 12) {
        $temp = " " . $kata[$tanggal];
    } else if ($tanggal < 20) {
        $temp = penyebut2($tanggal - 10) . " BELAS";
    } else if ($tanggal < 100) {
        $temp = penyebut2($tanggal / 10) . " PULUH" . penyebut2($tanggal % 10);
    } else if ($tanggal < 200) {
        $temp = " SERATUS" . penyebut($tanggal - 100);
    } else if ($tanggal < 1000) {
        $temp = penyebut($tanggal / 100) . " RATUS" . penyebut($tanggal % 100);
    } else if ($tanggal < 2000) {
        $temp = " SERIBU" . penyebut($tanggal - 1000);
    } else if ($tanggal < 1000000) {
        $temp = penyebut($tanggal / 1000) . " RIBU" . penyebut($tanggal % 1000);
    }
    return $temp;
}

function pembilang2($tanggal)
{
    if ($tanggal < 0) {
        $hasil = "Tanggal tidak valid";
    } else {
        $hasil = trim(penyebut2($tanggal));
    }
    return $hasil;
}
