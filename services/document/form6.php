<?php
error_reporting(E_ERROR | E_PARSE);
session_start();
$ID_Document = str_replace("-", "_", $_GET['ID']);
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../../css/style.css">
    <link rel="stylesheet" href="../../css/bootstrap.min.css" type="text/css">
    <link href="https://fonts.googleapis.com/css?family=Poppins:300,400,500,600,700,800,900" rel="stylesheet">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
    <title>Bagian Logistik | Telkom University</title>
</head>

<body>
    <div class="wrapper d-flex align-items-stretch">
        <nav id="sidebar">
            <div class="custom-menu">
                <button type="button" id="sidebarCollapse" class="btn btn-danger">
                    <i class="fa fa-bars"></i>
                    <span class="sr-only">Toggle Menu</span>
                </button>
            </div>
            <div class="p-4">
                <h1><a href="../../index.php" class="logo">Bagian Logistik <span>Telkom University</span></a></h1>
                <ul class="list-unstyled components mb-5">
                    <li>
                        <a href="../../index.php"><span class="fa fa-user mr-3"></span> Admin Dashboard</a>
                    </li>
                    <li class="active">
                        <a href="index1.php"><span class="fa fa-cogs mr-3"></span> Layanan</a>
                    </li>
                    <li>
                        <a href="form1.php"><span class="fa fa-sticky-note mr-3"></span> Data</a>
                    </li>
                    <li>
                        <a href="../../monitoring/index.php"><span class="fa fa-pencil mr-3"></span> Monitoring</a>
                    </li>
                    <li>
                        <a href="../contact.php"><span class="fa fa-paper-plane mr-3"></span> Kontak</a>
                    </li>
                    <?php if (!isset($_SESSION['Email'])) { ?>
                        <li style="margin-bottom: 100px;">
                            <a href="../../account_auth/login.php"><span class="fa fa-sign-out mr-3"></span> Login</a>
                        </li>
                    <?php } else { ?>
                        <li style="margin-bottom: 100px;">
                            <a href="../../account_auth/logout.php" onclick="return confirm('Apakah Anda yakin ingin keluar?')"><span class="fa fa-sign-out mr-3"></span> Logout</a>
                        </li>
                    <?php } ?>

                    <?php if (isset($_SESSION['Email'])) { ?>
                        <h6>Current User</h6>
                        <li>
                            <span class="fa fa-envelope mr-1"></span><?php echo " " . $_SESSION['Email'] ?>
                        </li>
                    <?php } ?>
                </ul>
            </div>
        </nav>

        <!-- Page Content  -->
        <div id="content" class="row p-4 p-md-5 pt-5">
            <?php if (!isset($_SESSION['Email'])) { ?>
                <div class="row">
                    <div class="col-12 center">
                        <img src="../../asset/image/lock.png" alt="" style="width:auto; height:120px" ;>
                    </div>
                    <div class="col-12 center pt-4">
                        <h5>Oops, Anda harus Login untuk melanjutkan ke fitur ini!</h5>
                    </div>
                </div>
            <?php } else { ?>

                <!-- PROGRESS BAR -->
                <div class="progress mb-5" style="height:30px">
                    <div class="progress-bar bg-danger" role="progressbar" style="width: 100%" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100">100%</div>
                </div>

                <?php if (isset($_GET['ID'])) {
                    echo "<iframe src='../../document/Bast_" . $ID_Document . ".pdf' frameborder='0' width='900' height='600'></iframe>";
                    echo "<a href='../../document/Bast_" . $ID_Document . ".pdf' download='Dokumen_Bast_" . $ID_Document . ".pdf' class='mt-2'><button type='submit' class='btn btn-danger' style='width:100%'> <span class='fa fa-download'></span> Unduh Dokumen</button></a>";
                    echo "<a href='form1.php'><button type='submit' class='btn btn-warning mt-2' style='width:100%'>Selesai</button></a>";
                } ?>
            <?php } ?>
        </div>
    </div>
</body>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/signature_pad@2.3.2/dist/signature_pad.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/2.9.2/umd/popper.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.1.0/js/bootstrap.min.js"></script>

</html>