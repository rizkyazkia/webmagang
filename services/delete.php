<?php
include_once  'connection.php';
$ID_Documents = $_GET['ID_Document'];
$sql = mysqli_prepare($conn, 'CALL DeleteData(?)');
$sql->bind_param('s', $ID_Documents);
$sql->execute();
header('Location: data.php');
