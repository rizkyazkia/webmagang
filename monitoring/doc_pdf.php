<?php
session_start();
include_once '../function/function_monitoring.php';

use PDF as GlobalPDF;

ob_end_clean();
require('../fpdf185/fpdf.php');
require_once 'connection.php';

$KodeDoc = $_SESSION['Kode_Document'];

// DATABASE QUERY
$sql = "SELECT * FROM logistik_ruangan JOIN logistik_documents 
ON logistik_ruangan.Kode_Ruangan = logistik_documents.Kode_Ruangan WHERE Kode_Document = $KodeDoc";

$sql2 = "SELECT * FROM logistik_assets JOIN logistik_documents
ON logistik_assets.Kode_Document = logistik_documents.Kode_Document WHERE logistik_documents.Kode_Document = $KodeDoc";

$sql3 = "SELECT * FROM logistik_documents ORDER BY Kode_Document DESC LIMIT 1";
// HEADER
class PDF extends FPDF
{
    function Header()
    {
        $this->SetFont('Times', 'B', '12');
        $this->Cell(256, 7, "KARTU MONITORING ASET", 1, 1, 'C');
        $this->Ln(7);
    }
    function Footer()
    {
        $this->SetY(-15);
        $this->SetFont('Times', 'I', '10');
        $this->Cell(0, 10, 'Unit Logistik dan Aset | Telkom University', 0, 0, "R");
    }
}

// WRAP FUNCTION
$arrayData = array();
$query = mysqli_query($conn, $sql2);
while ($row = mysqli_fetch_array($query)) {
    $len_data = strlen($row['Kode_Barang']);
    array_push($arrayData, $len_data);
};
$length = max($arrayData);

// Instantiate and use the FPDF class 
$pdf = new PDF("L", "mm", array(215, 325 + $length));

$pdf->SetMargins(20, 20, 20);
$pdf->AliasNbPages();
$pdf->AddPage();

$width_cell1 = array(55, 40);
$pdf->SetFont('Times', 'B', 10);

// TABEL INFORMASI RUANG
$query = mysqli_query($conn, $sql);
while ($row = mysqli_fetch_array($query)) {
    $pdf->Cell($width_cell1[1], 6, 'Nomor Ruang', 0, 0, 'L', false);
    $pdf->Cell($width_cell1[0], 6, ': ' . $row['Kode_Ruangan'], 0, 1, 'L', false);
    $pdf->Cell($width_cell1[1], 6, 'Nama Ruang', 0, 0, 'L', false);
    $pdf->Cell($width_cell1[0], 6, ': ' . $row['Nama_Ruangan'], 0, 1, 'L', false);
    $pdf->Cell($width_cell1[1], 6, 'Gedung Ruang', 0, 0, 'L', false);
    $pdf->Cell($width_cell1[0], 6, ': ' . $row['Gedung_Ruangan'], 0, 1, 'L', false);
    $pdf->Cell($width_cell1[1], 6, 'Lokasi Ruang', 0, 0, 'L', false);
    $pdf->Cell($width_cell1[0], 6, ': ' . $row['Lokasi_Ruangan'], 0, 1, 'L', false);
}
$pdf->Ln(8);

// TITLE PENDATAAN BARANG
$pdf->SetFont('Times', 'B', 11);
$pdf->Cell(256, 7, "PENDATAAN BARANG", 0, 1, 'C');
$pdf->Ln(2);

// TABEL RECORDS


$width_cell = array(10, $length*2+20 , 60, 15, 20, 56, 28, 105 + $length*2+20 , 14);
$pdf->SetFont('Times', 'B', 10);

//Background color of header//
$pdf->SetFillColor(255, 255, 255);


// HEADER
$pdf->Cell($width_cell[0], 14, 'No.', 1, 0, 'C', true);
$pdf->Cell($width_cell[1], 14, 'Kode Barang', 1, 0, 'C', true);
$pdf->Cell($width_cell[2], 14, 'Nama Barang', 1, 0, 'C', true);
$pdf->Cell($width_cell[3], 14, 'Jumlah', 1, 0, 'C', true);
$pdf->Cell($width_cell[4], 14, 'Satuan', 1, 0, 'C', true);
$pdf->Cell($width_cell[5], 7, 'Keterangan', 1, 0, 'C', true);
$pdf->Cell($width_cell[5], 7, 'Pengecekan Fisik', 1, 1, 'C', true);
$pdf->Cell($width_cell[7], 7, '', 0, 0, 'C', false);
$pdf->Cell($width_cell[6], 7, 'Berfungsi', 1, 0, 'C', true);
$pdf->Cell($width_cell[6], 7, 'Tidak Berfungsi', 1, 0, 'C', true);
$query = mysqli_query($conn, $sql);
while ($row = mysqli_fetch_array($query)) {
    $data = $row['Periode_Document'];
    $data = getListMonth($data);
    foreach ($data as $month) {
        $pdf->Cell($width_cell[8], 7, $month, 1, 0, 'C', false);
    }
}
$pdf->Ln();
// HEADER ENDS

$pdf->SetFont('Arial', '', 9);
//Background color of header//
$pdf->SetFillColor(255, 255, 255);
//to give alternate background fill color to rows// 
$fill = false;

// EACH RECORD IS ONE ROW
$no = 1;
$countVol = 0;
$query = mysqli_query($conn, $sql2);
while ($row = mysqli_fetch_array($query)) {
    $pdf->Cell($width_cell[0], 7, $no . ".", 1, 0, 'C', $fill);
    $pdf->Cell($width_cell[1], 7, $row['Kode_Barang'], 1, 0, 'C', $fill);
    $pdf->Cell($width_cell[2], 7, $row['Nama_Barang'], 1, 0, 'C', $fill);
    $pdf->Cell($width_cell[3], 7, $row['Jumlah_Barang'], 1, 0, 'C', $fill);
    $pdf->Cell($width_cell[4], 7, $row['Satuan_Barang'], 1, 0, 'C', $fill);
    $data = $row['Ket_Barang'];
    $pdf->SetFont('ZapfDingBats', '', '8');
    if ($data == "Berfungsi") {
        $pdf->Cell($width_cell[6], 7, 4, 1, 0, 'C', $fill);
        $pdf->Cell($width_cell[6], 7, '', 1, 0, 'C', $fill);
    } else {
        $pdf->Cell($width_cell[6], 7, '', 1, 0, 'C', $fill);
        $pdf->Cell($width_cell[6], 7, 4, 1, 0, 'C', $fill);
    }
    $dataMonth = $row['Periode_Document'];
    $dataMonth2 = getListMonth($dataMonth);
    $loops = count($dataMonth2);
    $data = explode(",", $row['Pengecekan_Barang']);
    foreach ($dataMonth2 as $dataPeriod => $element) {
        if ($dataPeriod === array_key_last($dataMonth2)) {
            if (in_array($element, $data)) {
                $pdf->Cell($width_cell[8], 7, 4, 1, 1, 'C', $fill);
            } else {
                $pdf->Cell($width_cell[8], 7, '', 1, 1, 'C', $fill);
            }
        } else {
            if (in_array($element, $data)) {
                $pdf->Cell($width_cell[8], 7, 4, 1, 0, 'C', $fill);
            } else {
                $pdf->Cell($width_cell[8], 7, '', 1, 0, 'C', $fill);
            }
        }
    }
    $pdf->SetFont('Arial', '', 9);
    $fill = !$fill;
    $no = $no + 1;
}
$filename = $KodeDoc . ".pdf";
$pdf->Output('F', 'document/' . $filename);
header('Location: index3.php?Doc=' . $filename);