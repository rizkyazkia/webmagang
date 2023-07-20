<?php
include_once '../function/function.php';

use PDF as GlobalPDF;

ob_end_clean();
require('../fpdf185/fpdf.php');
require_once 'connection.php';

// DATABASE QUERY
$sql = "SELECT * FROM logistic_user_data 
JOIN logistic_doc_user ON logistic_user_data.ID_UserData = logistic_doc_user.ID_UserData
JOIN logistic_document ON logistic_doc_user.ID_LogDoc = logistic_document.ID_LogDoc
WHERE logistic_document.ID_LogDoc = Document_IDShow() LIMIT 1;";

$sql2 = "SELECT * FROM logistic_user_data 
JOIN logistic_doc_user ON logistic_user_data.ID_UserData = logistic_doc_user.ID_UserData
JOIN logistic_document ON logistic_doc_user.ID_LogDoc = logistic_document.ID_LogDoc
WHERE logistic_document.ID_LogDoc = Document_IDShow();";

$sql3 = "SELECT * FROM logistic_inventory
JOIN logistic_document ON logistic_document.ID_LogDoc = logistic_inventory.ID_LogDoc
WHERE logistic_document.ID_LogDoc = Document_IDShow();";

$sql4 = "SELECT Nama_Pengawas, InstitusiPengawas FROM logistic_user_data 
JOIN logistic_doc_user ON logistic_user_data.ID_UserData = logistic_doc_user.ID_UserData
WHERE logistic_doc_user.ID_LogDoc = Document_IDShow() ORDER BY logistic_doc_user.ID_UserData DESC LIMIT 1;";

foreach ($conn->query($sql) as  $row) {
    $ID_Document = $row['ID_Document'];
    $_SESSION['ID_Document2'] = $ID_Document;
}

// HEADER
class PDF extends FPDF
{
    function Header()
    {
        $this->SetX(150);
        $this->SetFont('Arial', '', '12');
        $this->Cell(($this->GetStringWidth($_SESSION['ID_Document2'])+10),7,'No.'.$_SESSION['ID_Document2'] ,1,1,'C');
        $this->Ln(10);
        $this->SetFont('Arial', 'B', '14');
        $this->Cell(176, 5, 'BERITA ACARA', 0, 0, 'C');
        $this->Ln();
        $this->Cell(176, 10, 'SERAH TERIMA BARANG/ASSET', 0, 0, 'C');
        $this->Ln(15);
    }
    function Footer()
    {
        $this->SetY(-15);
        $this->SetFont('Arial', 'I', '10');
        $this->Cell(0, 10, 'Unit Logistik dan Aset | Telkom University', 0, 0, "R");
    }
}
// Instantiate and use the FPDF class 
$pdf = new PDF("P","mm",array(215,300));

$pdf->SetMargins(20, 20, 20);
$pdf->AliasNbPages();
$pdf->AddPage();
$pdf->SetFont('Arial', '', 12);
$pdf->Ln(5);

$counter = 0;
foreach ($conn->query($sql) as $row) {
    $Tanggal        = $row['Tanggal_BAST'];
    $Arialtamp      = strtotime($Tanggal);
    $Date           = substr($Tanggal,8,2);
    $Day            = date('l', $Arialtamp);
    $TanggalFix     = pembilang($Date);
    // TRANSLATE HARI
    $hari           = getHari($Day);

    // TRANSLATE BULAN
    $Month          = date('F', $Arialtamp);
    $bulan          = getBulan($Month);
    $Year           = date('Y', $Arialtamp);
    $YearFix        = pembilang2($Year);
    $unit_penerima  = $row['InstitusiPenerima'];
    $unit_pengirim  = $row['InstitusiPengirim'];

    // BOLD ITALIC
    $ShowHari = $hari;
    $ShowTanggal = $TanggalFix;
    $ShowBulan = $bulan;
    $ShowTahun = $YearFix;
    $ShowUnitPengirim = strtoupper($unit_pengirim);
    $ShowUnitPenerima = strtoupper($unit_penerima);

    $pdf->SetFont('Arial', '', 12);
    $pdf->Write(7, "Pada hari ini ");
    $pdf->SetFont('Arial', 'BI', 12);
    $pdf->Write(7, $ShowHari);
    $pdf->SetFont('Arial', '', 12);
    $pdf->Write(7, " tanggal ");
    $pdf->SetFont('Arial', 'BI', 12);
    $pdf->Write(7, $ShowTanggal);
    $pdf->SetFont('Arial', '', 12);
    $pdf->Write(7, " bulan ");
    $pdf->SetFont('Arial', 'BI', 12);
    $pdf->Write(7, $ShowBulan);
    $pdf->SetFont('Arial', '', 12);
    $pdf->Write(7, " tahun ");
    $pdf->SetFont('Arial', 'BI', 12);
    $pdf->Write(7, $ShowTahun);
    $pdf->SetFont('Arial', '', 12);
    $pdf->Write(7, " bertempat di Telkom University Jalan Telekomunikasi No.1, telah dilakukan serah terima barang antara pihak ");
    $pdf->SetFont('Arial', 'BI', 12);
    $pdf->Write(7, $ShowUnitPengirim);
    $pdf->SetFont('Arial', '', 12);
    $pdf->Write(7, ' dengan ');
    $pdf->SetFont('Arial', 'BI', 12);
    $pdf->Write(7, $ShowUnitPenerima);
    $pdf->SetFont('Arial', '', 12);
    $pdf->Write(7, '.');
    $pdf->Ln(10);
    $pdf->MultiCell(176, 7, "Adapun rincian yang diserah terimakan secara lengkap sebagai berikut :");
    $pdf->Ln(2);
}

// TABEL RECORDS
$width_cell = array(10, 80, 20, 20, 40, 90, 80);
$pdf->SetFont('Arial', 'B', 11);

//Background color of header//
$pdf->SetFillColor(255, 255, 255);

// HEADER
$pdf->Cell($width_cell[0], 7, 'No.', 1, 0, 'C', true);
$pdf->Cell($width_cell[1], 7, 'Nama Barang', 1, 0, 'C', true);
$pdf->Cell($width_cell[2], 7, 'Vol', 1, 0, 'C', true);
$pdf->Cell($width_cell[3], 7, 'Satuan', 1, 0, 'C', true);
$pdf->Cell($width_cell[4], 7, 'Keterangan', 1, 0, 'C', true);
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
foreach ($conn->query($sql3) as $row) {
    $pdf->Cell($width_cell[0], 7, $no . ".", 1, 0, 'C', $fill);
    $pdf->Cell($width_cell[1], 7, $row['Nama_Barang'], 1, 0, 'C', $fill);
    $pdf->Cell($width_cell[2], 7, $row['Volume_Barang'], 1, 0, 'C', $fill);
    $pdf->Cell($width_cell[3], 7, $row['Satuan_Barang'], 1, 0, 'C', $fill);
    $pdf->Cell($width_cell[4], 7, $row['Ket_Barang'], 1, 1, 'C', $fill);
    $fill = !$fill;
    $no = $no + 1;
    $countVol = $countVol + (int)$row['Volume_Barang'];
}
$pdf->Cell($width_cell[5], 7, 'Jumlah', 1, 0, 'C', $fill);
$pdf->Cell($width_cell[6], 7, $countVol, 1, 0, 'L', $fill);


$pdf->Ln(10);
$textPDF2 = 'Demikian Berita Acara Serah Terima ini dibuat dengan sebenar-benarnya dan untuk dipergunakan sebagaimana mestinya, serta di tandatangani oleh kedua belah pihak.';
$pdf->MultiCell(176, 7, $textPDF2);
$pdf->Ln(7);

$pdf->SetFont('Arial', 'B', 12);
$width_cell2 = array(90, 85, 10);
$pdf->Cell($width_cell2[0], 7, 'Yang Menyerahkan', 0, 0, 'L', $fill);
$pdf->Cell($width_cell2[1], 7, 'Yang Menerima', 0, 1, 'L', $fill);
$pdf->SetFont('Arial', '', 12);

$pdf->Ln();
$pdf->SetFillColor(255, 255, 255);
//to give alternate background fill color to rows// 
$fill = false;
$width_cell3 = array(40, 10, 30, 50);
$counter = 1;
$positionY = -3;
foreach ($conn->query($sql2) as  $row) {
    $imageSign1 = "../upload/pengirim/" . $row["Sign_File_Pengirim"] . ".png";
    $imageSign2 = "../upload/penerima/" . $row["Sign_File_Penerima"] . ".png";
    $pdf->Cell($width_cell3[0], 5, $counter . '.' . $row['Nama_Pengirim'], 0, 0, 'L', $fill);
    $pdf->Cell($width_cell3[1], 5, ' : ', 0, 0, 'L', $fill);
    $pdf->Cell($width_cell3[0], 5,  $pdf->Image($imageSign1, $pdf->GetX(), $pdf->GetY() + $positionY, 35, 10), 0, 0, 'L', $fill);
    $pdf->Cell($width_cell3[0], 5, $counter . '.' . $row['Nama_Penerima'], 0, 0, 'L', $fill);
    $pdf->Cell($width_cell3[1], 5, ' : ', 0, 0, 'L', $fill);
    $pdf->SetFont('Arial', '', 12);
    $pdf->Cell($width_cell3[0], 5,  $pdf->Image($imageSign2, $pdf->GetX(), $pdf->GetY() + $positionY, 35, 10), 0, 1, 'L', $fill);
    $pdf->Cell($width_cell3[0], 5, $row['InstitusiPengirim'], 0, 0, 'L', $fill);
    $pdf->Cell($width_cell3[3], 5, "", 0, 0, 'L', $fill);
    $pdf->Cell($width_cell3[0], 5, $row['InstitusiPenerima'], 0, 1, 'L', $fill);
    $pdf->Cell($width_cell3[0], 10, '', 0, 0, 'L', $fill);
    $pdf->Cell($width_cell3[0], 10, '', 0, 1, 'L', $fill);
    $counter = $counter + 1;
    $positionY = $positionY - 2;
}
$pdf->Ln(10);
$pdf->Cell(176, 7, "Mengetahui,", 0, 1, 'C');
$pdf->Ln(20);

foreach ($conn->query($sql4) as $row) {
    $NamaPengawas = $row['Nama_Pengawas'];
    $InstitusiPengawas = $row['InstitusiPengawas'];
    if(is_null($row['Nama_Pengawas']) and is_null($row['InstitusiPengawas'])){
        $pdf->SetFont('Arial', 'BU', 12);
        $pdf->Cell(176, 5, 'Aris Hartaman', 0, 1, 'C');
        $pdf->SetFont('Arial', '', 11);
        $pdf->Cell(176, 7, 'Kabag. Aset', 0, 0, 'C');
    } else {
        $pdf->SetFont('Arial', 'BU', 12);
        $pdf->Cell(176, 5, 'Aris Hartaman', 0, 1, 'C');
        $pdf->SetFont('Arial', '', 11);
        $pdf->Cell(176, 7, 'Kabag. Aset', 0, 0, 'C');
    }
}
$pdf->Ln(20);
$width_cell4 = array(7, 20);
$pdf->Cell($width_cell4[0], 7, '', 1, 0, 'L', false);
$pdf->Cell($width_cell4[1], 7, 'Input Sim Aset', 0, 1, 'L', false);
$pdf->Ln(1);
$pdf->Cell($width_cell4[0], 7, '', 1, 0, 'L', false);
$pdf->Cell($width_cell4[1], 7, 'Barcode / Label', 0, 1, 'L', false);


foreach ($conn->query($sql) as  $row) {
    $ID_Document = $row['ID_Document'];
    $ID_Document2 = str_replace("/","_",$ID_Document);
    $filename = "Bast_" . $ID_Document2 . '.pdf';
    $sql3   = "UPDATE logistic_document SET File_Document = '$filename' WHERE ID_Document = '$ID_Document'";
    mysqli_query($conn, $sql3);
    $pdf->Output('F', '../document/' . $filename);
    unset($_SESSION['ID_Document']);
    header('Location: document/form6.php?ID=' . $ID_Document2);
}
