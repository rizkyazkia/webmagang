<!-- THIS PAGE TO CONTROL THE URL ACCESS -->
<?php 

// LOGIN PATH
if (isset($_GET['LoginState'])){
    $resultmsgs = $_GET['LoginState'];
    $resultmsg  = substr($resultmsgs, -1);
    if (isset($resultmsg)){
        if ($resultmsg == "1") {
            header('Location: ../services/document/form1.php');
            die();
        } elseif ($resultmsg == "0"){
            header('Location: ../account_auth/login.php?State=False');
        }
    }
}

// INDEX
?>