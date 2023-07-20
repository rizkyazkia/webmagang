<?php
session_start();
require_once 'connection.php';
include_once '../function/function_monitoring.php';
if (isset($_POST['SaveBtn'])) {
    $Lokasi = $_POST['lokasiRuangan'];
    $Gedung = $_POST['gedungRuangan'];
    $Nama   = $_POST['namaRuangan'];
    $Nama2  = explode(" - ", $Nama);
    $Start  = GetMonth($_POST['StartPeriod']);
    $End    = GetMonth($_POST['EndPeriod']);
    $Period = "" . $Start . "-" . $End . "";
    $query = mysqli_query($conn, "SELECT Kode_Ruangan FROM logistik_ruangan WHERE Nama_Ruangan = '" . $Nama2[1] . "' AND Kode_Ruangan = '" . $Nama2[0] . "'");
    while ($row = mysqli_fetch_array($query)) {
        $KodeRuangan = $row[0];
    }
    $sql = mysqli_prepare($conn, "CALL GetKodeRuangan(?,?)");
    $sql->bind_param('ss', $KodeRuangan, $Period);
    $sql->execute();

    $query = mysqli_query($conn, "SELECT Kode_Document FROM logistik_documents ORDER BY Kode_Document DESC LIMIT 1");
    while ($row = mysqli_fetch_array($query)) {
        $_SESSION['Kode_Document'] = $row['Kode_Document'];
    }
    $result = [
        'kode' => $KodeRuangan,
        'lokasi' => $Lokasi,
        'gedung' => $Gedung,
        'nama' => $Nama2[1],
        'Period' => $Period
    ];
    $result = http_build_query($result);
    header("Location: index2.php?" . $result);
}

if (isset($_POST['btn-status'])) {
    $KodeBarang = $_POST['Input_Kode_Barang'];
    $Nama_Barang = $_POST['Input_Nama_Barang'];
    $Jumlah_Barang = $_POST['Input_Jumlah_Barang'];
    $Satuan_Barang = $_POST['Input_Satuan_Barang'];
    $Ket_Barang = $_POST['Input_Keterangan_Barang'];
    $InputCheck = $_POST['Input_DataCheck'];
    $check = "";
    foreach ($InputCheck as $check1) {
        $check .= $check1 . ",";
    }
    $sql = mysqli_prepare($conn, "CALL InsertAssets(?,?,?,?,?,?)");
    $sql->bind_param('ssssss', $KodeBarang, $Nama_Barang, $Jumlah_Barang, $Satuan_Barang, $Ket_Barang, $check);
    $sql->execute();

    $result = "";
    $KodeDocument = $_SESSION['Kode_Document'];
    $query = mysqli_query($conn, "SELECT * FROM logistik_documents JOIN logistik_ruangan ON logistik_documents.Kode_Ruangan = logistik_ruangan.Kode_Ruangan WHERE Kode_Document = $KodeDocument");
    while ($row = mysqli_fetch_array($query)) {
        $KodeRuangan = $row['Kode_Ruangan'];
        $Lokasi = $row['Lokasi_Ruangan'];
        $Gedung = $row['Gedung_Ruangan'];
        $Nama = $row['Nama_Ruangan'];
        $Period = $row['Periode_Document'];
        $result = [
            'kode' => $KodeRuangan,
            'lokasi' => $Lokasi,
            'gedung' => $Gedung,
            'nama' => $Nama,
            'Period' => $Period
        ];
        $result = http_build_query($result);
    }

    if ($_POST['btn-status'] == "rephase") {
        header("Location: index2.php?" . $result);
    } elseif ($_POST['btn-status'] == "endphase") {
        header('Location: doc_pdf.php');
    }
}
