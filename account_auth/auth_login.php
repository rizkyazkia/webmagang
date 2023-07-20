<?php 
include_once "../services/connection.php";
session_start();

if ($_POST['btnlogin'] == 'clicked'){
    $username = $_POST['usernameinput'];
    $password = $_POST['passwordinput'];

    // SQL ACCOUNT VALIDATION
    $statuslogin = 1;
    $query = mysqli_query($conn, "SELECT ValidateLogin('". $username ."','".$password."')");
    while ($row = mysqli_fetch_array($query)) {
        if ($row[0] == 'False'){
            $statuslogin = uniqid("LoginState=", true).'0';
        } else {
            $statuslogin = uniqid('LoginState=', true).'1';
            $sql = "SELECT * FROM logistic_account WHERE email = '" . $username ."'";
            $query = mysqli_query($conn, $sql);
            while ($data = mysqli_fetch_array($query)){
                $_SESSION['ID_User']    = $data[0];
                $_SESSION['Email']      = $data[1];
            }
        }
    }
    header("Location: ../services/controller.php?$statuslogin");
    die();
}
?>