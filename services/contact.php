<?php session_start() ;
error_reporting(E_ERROR | E_PARSE);
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/style.css">
    <link rel="stylesheet" href="../css/bootstrap.min.css" type="text/css">
    <link href="https://fonts.googleapis.com/css?family=Poppins:300,400,500,600,700,800,900" rel="stylesheet">
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
                <h1><a href="index.html" class="logo">Bagian Logistik <span>Telkom University</span></a></h1>
                <ul class="list-unstyled components mb-5">
                    <li >
                        <a href="index.php"><span class="fa fa-user mr-3"></span> Admin Dashboard</a>
                    </li>
                    <li>
                        <a href="document/form1.php"><span class="fa fa-cogs mr-3"></span> Layanan</a>
                    </li>
                    <li>
                        <a href="data.php"><span class="fa fa-sticky-note mr-3"></span> Data</a>
                    </li>
                    <li>
                        <a href="../monitoring/index.php"><span class="fa fa-pencil mr-3"></span> Monitoring</a>
                    </li>
                    <li class="active">
                        <a href="contact.php"><span class="fa fa-paper-plane mr-3"></span> Kontak</a>
                    </li>
                    <?php if (!isset($_SESSION['Email'])) { ?>
                        <li style="margin-bottom: 100px;">
                            <a href="../account_auth/login.php"><span class="fa fa-sign-out mr-3"></span> Login</a>
                        </li>
                    <?php } else { ?>
                        <li style="margin-bottom: 100px;">
                            <a href="../account_auth/logout.php" onclick="return confirm('Apakah Anda yakin ingin keluar?')"><span class="fa fa-sign-out mr-3"></span> Logout</a>
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
        <div id="content" class="p-4 p-md-5 pt-5">
            <h3><strong>LOGISTIK DAN ASET TELKOM UNIVERSITY</strong> </h3>
            <div class="box-line2"></div>
            <p>Direktorat Logistik dan Aset merupakan Direktorat kerja pendukung layanan pengadaan barang/jasa dan manajemen aset di lingkungan Universitas Telkom yang mempunyai tugas pokok sebagai unit implementasi pengadaan barang/jasa yang dibutuhkan oleh unit akademik maupun unit pendukung. Fungsi unit logistik khususnya dalam proses pengaadaan barang dan jasa mempunyai peran stategis yaitu untuk memastikan semua kegiatan akademik dan operasional (proses belajar mengajar) dapat berjalan dengan lancar secara efektif dan efisien. Oleh karena itu unit logistik mempunyai peran penting dalam mendukung tercapainya visi misi Universitas Telkom menuju perguruan tinggi yang bermartabat (world class university).</p>
            <p>Unit logistik melayani lebih dari 20 unit kerja di lingkungan Universitas Telkom yang dalam pelaksanaan fungsi dan perannya berpedoman kepada Rencana Kerja dan Anggaran (RKA) tahuan yang ditetapkan oleh Yayasan Pendidikan Telkom. Peran strategis lainnya yang dimiliki unit logistik terkait dengan pengadaan barang dan jasa meliputi kegiatan perencanaan, monitoring dan evaluasi yang berkelanjutan.</p>
            <div class="row mt-5">
                <div class="col-6">
                    <div class="mapouter">
                        <div class="gmap_canvas"><iframe width="480" height="250" id="gmap_canvas" src="https://maps.google.com/maps?q=gedung deli, universitas telkom&t=k&z=16&ie=UTF8&iwloc=&output=embed" frameborder="0" scrolling="no" marginheight="0" marginwidth="0"></iframe><a href="https://2yu.co">2yu</a><br>
                            <style>
                                .mapouter {
                                    position: relative;
                                    text-align: right;
                                    height: 250px;
                                    width: 480px;
                                }
                            </style><a href="https://embedgooglemap.2yu.co">html embed google map</a>
                            <style>
                                .gmap_canvas {
                                    overflow: hidden;
                                    background: none !important;
                                    height: 250px;
                                    width: 480px;
                                }
                            </style>
                        </div>
                    </div>
                </div>
                <div class="col-6">
                    <h5>Hubungi Kami</h5>
                    <div class="">
                        <a href="https://wa.me/6281324874436?text=Halo,%20Bapak/Ibu%20Admin%20Unit%20Logistik%20&%20Aset%20Telkom%20University" target="_blank"><span class="btn btn-lg btn-danger fa fa-whatsapp me-2"></span></a>
                    </div>
                    <div class="mt-2">
                        <a href="https://www.instagram.com/logistik_telu/" target="_blank"><span class="btn btn-lg btn-danger fa fa-instagram me-2"></span></a>
                    </div>
                    <div class="mt-2">
                        <a href=""><span class="btn btn-lg btn-danger fa fa-telegram me-2"></span></a>
                    </div>
                    <div class="mt-2">
                        <a href=""><span class="btn btn-lg btn-danger fa fa-envelope me-2"></span></a>
                    </div>
                    <div class="mt-2">
                        <a href="https://logistik.telkomuniversity.ac.id/" target="_blank"><span class="btn btn-lg btn-danger fa fa-globe me-2"></span></a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
<script src="../js/bootstrap.min.js"></script>
<script src="../js/jquery.min.js"></script>
<script src="../js/popper.js"></script>
<script src="../js/main.js"></script>
<script src="../js/script.js"></script>

</html>