<?php
session_start();
include_once 'connection.php';

if (isset($_POST['form-control'])) {
    // FORM CONTROL 1
    if ($_POST['form-control'] == '1') {
        // GET DATA
        $ID_User        = $_SESSION['ID_User'];
        $NomorInput     = $_POST['NomorSuratInput'];
        $TanggalInput   = $_POST['TanggalInput'];
        // INSERT TO DB
        $sql = mysqli_prepare($conn, 'CALL InsertNewDoc(?,?,?)');
        $sql->bind_param('sss', $ID_User, $NomorInput, $TanggalInput);
        $sql->execute();
        $sql->close();
        header('Location: document/form2.php');
    }
    // FORM CONTROL 2
    elseif ($_POST['form-control'] == '2') {
        // GET DATA
        $NamaBrgInput   = $_POST['NamaBarangInput'];
        $VolBrgInput    = $_POST['VolBarangInput'];
        $SatuanBrgInput = $_POST['SatuanBarangInput'];
        $KetBrgInput    = $_POST['KetBarangInput'];
        $Status         = $_POST['simpanbarangbtn'];
        // INSERT TO DB
        $sql = mysqli_prepare($conn, 'CALL insertDataBarang(?,?,?,?)');
        $sql->bind_param('ssss', $NamaBrgInput, $VolBrgInput, $SatuanBrgInput, $KetBrgInput);
        $sql->execute();
        $sql->close();
        if ($Status == 'rephase') {
            header('Location: document/form2.php?status=True');
        } else {
            header('Location: document/form3.php');
        }
    }
    // FORM CONTROL 3
    elseif ($_POST['form-control'] == '3') {
        // GET DATA
        $NamaPengirim   = $_POST['NamaPengirimInput'];
        $InstPengirim   = $_POST['InstitusiPengirimInput'];
        $SignPengirim   = $_POST['UIDInput1'];
        // SAVING FILE SIGN TO LOCAL
        $folderPath         = "../upload/pengirim/";
        $image_parts        = explode(";base64,", $_POST['signed1']);
        $image_type_aux     = explode("image/", $image_parts[0]);
        $image_type         = $image_type_aux[1];
        $image_base64       = base64_decode($image_parts[1]);
        $file = $folderPath . $SignPengirim . '.' . $image_type;
        file_put_contents($file, $image_base64);
        // INSERT TO DB
        $sql = mysqli_prepare($conn, 'CALL SetUserDataPengirim(?,?,?)');
        $sql->bind_param('sss', $NamaPengirim, $InstPengirim, $SignPengirim);
        $sql->execute();
        $sql->close();
        header('Location: document/form4.php');
    }
    // FORM CONTROL 3-1
    elseif ($_POST['form-control'] == '3-1') {
        // GET DATA
        $NamaPengirim   = $_POST['NamaPengirimInput'];
        $InstPengirim   = $_POST['InstitusiPengirimInput'];
        $SignPengirim   = $_POST['UIDInput1'];
        // SAVING FILE SIGN TO LOCAL
        $folderPath         = "../upload/pengirim/";
        $image_parts        = explode(";base64,", $_POST['signed1']);
        $image_type_aux     = explode("image/", $image_parts[0]);
        $image_type         = $image_type_aux[1];
        $image_base64       = base64_decode($image_parts[1]);
        $file = $folderPath . $SignPengirim . '.' . $image_type;
        file_put_contents($file, $image_base64);
        // INSERT TO DB
        $sql = mysqli_prepare($conn, 'CALL SetUserDataPengirim2(?,?,?)');
        $sql->bind_param('sss', $NamaPengirim, $InstPengirim, $SignPengirim);
        $sql->execute();
        $sql->close();
        header('Location: document/form4.php');
    }
    // FORM CONTROL 4
    elseif ($_POST['form-control'] == '4') {
        // GET DATA
        $NamaPenerima   = $_POST['NamaPenerimaInput'];
        $InstPenerima   = $_POST['InstitusiPenerimaInput'];
        $SignPenerima   = $_POST['UIDInput2'];
        // SAVING FILE SIGN TO LOCAL
        $folderPath         = "../upload/penerima/";
        $image_parts        = explode(";base64,", $_POST['signed2']);
        $image_type_aux     = explode("image/", $image_parts[0]);
        $image_type         = $image_type_aux[1];
        $image_base64       = base64_decode($image_parts[1]);
        $file = $folderPath . $SignPenerima . '.' . $image_type;
        file_put_contents($file, $image_base64);
        // INSERT TO DB
        $sql = mysqli_prepare($conn, 'CALL SetUserDataPenerima(?,?,?)');
        $sql->bind_param('sss', $NamaPenerima, $InstPenerima, $SignPenerima);
        $sql->execute();
        $sql->close();
        header('Location: document/form5.php');
    }
}
