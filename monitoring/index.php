<?php
error_reporting(E_ERROR | E_PARSE);
require_once 'connection.php';
include_once '../function/function_monitoring.php';
session_start();
if (isset($_POST['lokasiRuangan'])) {
    $LokasiGet = $_POST['lokasiRuangan'];
}
if (isset($_POST['gedungRuangan'])) {
    $GedungGet = $_POST['gedungRuangan'];
}
if (isset($_POST['namaRuangan'])) {
    $NamaGet = $_POST['namaRuangan'];
}
if (isset($_POST['StartPeriod'])) {
    $StartGet = $_POST['StartPeriod'];
}
if (isset($_POST['EndPeriod'])) {
    $EndGet = $_POST['EndPeriod'];
}


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
                <h1><a href="../index.php" class="logo">Bagian Logistik <span>Telkom University</span></a></h1>
                <ul class="list-unstyled components mb-5">
                    <li>
                        <a href="../index.php"><span class="fa fa-user mr-3"></span> Admin Dashboard</a>
                    </li>
                    <li>
                        <a href="../services/document/form1.php"><span class="fa fa-cogs mr-3"></span> Layanan</a>
                    </li>
                    <li>
                        <a href="../services/data.php"><span class="fa fa-sticky-note mr-3"></span> Data</a>
                    </li>
                    <li class="active">
                        <a href="index.php"><span class="fa fa-pencil mr-3"></span> Monitoring</a>
                    </li>
                    <li>
                        <a href="../services/contact.php"><span class="fa fa-paper-plane mr-3"></span> Kontak</a>
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
            <?php if (!isset($_SESSION['Email'])) { ?>
                <div class="row">
                    <div class="col-12 center">
                        <img src="../asset/image/lock.png" alt="" style="width:auto; height:120px" ;>
                    </div>
                    <div class="col-12 center pt-4">
                        <h5>Oops, Anda harus Login untuk melanjutkan ke fitur ini!</h5>
                    </div>
                </div>
            <?php } else { ?>
                <h3>Formulir Monitoring Logistik dan Aset</h3>
                <div class="box-line"></div>

                <h4>Informasi Lokasi Monitoring</h4>
                <!-- PROGRESS BAR -->
                <div class="progress mb-4" style="height:30px">
                    <div class="progress-bar bg-danger" role="progressbar" style="width: 5%" aria-valuenow="5" aria-valuemin="0" aria-valuemax="5">0%</div>
                </div>

                <!-- FORMULIR -->
                <div class="row">
                    <div class="col-12">
                        <!-- FORMULIR LOKASI -->
                        <div class="mb-3">
                            <form action="index.php" method="POST" id="form-1">
                                <div class="mb-2">
                                    <div class="form-group">
                                        <label for="selectLokasi" class="mb-2"><strong> Informasi Lokasi Ruangan</strong></label>
                                        <div class="d-flex">
                                            <div class="form-group" style="width: 100%;">
                                                <select name="lokasiRuangan" class="form-select" aria-label="Default select example" id="selectLokasi">
                                                    <?php if (isset($_POST['lokasiRuangan'])) { ?>
                                                        <option selected><?php echo $LokasiGet ?></option>
                                                    <?php } else { ?>
                                                        <option selected>Pilih Lokasi Ruangan</option>
                                                    <?php } ?>
                                                    <?php
                                                    $query = mysqli_query($conn, "SELECT DISTINCT Lokasi_Ruangan FROM logistik_ruangan");
                                                    while ($row = mysqli_fetch_array($query)) {
                                                        $Lokasi_Ruangan = $row['Lokasi_Ruangan'];
                                                    ?>
                                                        <option value="<?php echo $Lokasi_Ruangan ?>"><?php echo $Lokasi_Ruangan ?></option>
                                                    <?php } ?>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                        <!-- FORMULIR GEDUNG -->
                        <div class="mb-3">
                            <form action="index.php" method="POST" id="form-2">
                                <div class="mb-2">
                                    <div class="form-group">
                                        <label for="selectGedung" class="mb-2"><strong> Informasi Gedung Ruangan</strong></label>
                                        <div class="d-flex">
                                            <div class="form-group" style="width: 100%;">
                                                <select name="gedungRuangan" class="form-select" aria-label="Default select example" id="selectGedung">
                                                    <?php if (isset($_POST['gedungRuangan'])) { ?>
                                                        <option selected><?php echo $GedungGet ?></option>
                                                    <?php } else { ?>
                                                        <option selected>Pilih Gedung Ruangan</option>
                                                    <?php } ?>
                                                    <?php
                                                    $query = mysqli_query($conn, "SELECT DISTINCT Gedung_Ruangan FROM logistik_ruangan WHERE Lokasi_Ruangan = '" . $_POST['lokasiRuangan'] . "'");
                                                    while ($row = mysqli_fetch_array($query)) {
                                                        $Gedung_Ruangan = $row['Gedung_Ruangan'];
                                                    ?>
                                                        <option value="<?php echo $Gedung_Ruangan ?>"><?php echo $Gedung_Ruangan ?></option>
                                                    <?php } ?>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <input type="hidden" name="lokasiRuangan" value=" <?php echo $LokasiGet ?>">
                            </form>
                        </div>
                        <!-- FORMULIR NAMA -->
                        <div class="mb-3">
                            <form action="index.php" method="POST" id="form-3">
                                <div class="mb-2">
                                    <div class="form-group">
                                        <label for="selectNama" class="mb-2"><strong> Informasi Nama Ruangan</strong></label>
                                        <div class="d-flex">
                                            <div class="form-group" style="width: 100%;">
                                                <select name="namaRuangan" class="form-select" aria-label="Default select example" id="selectNama">
                                                    <?php if (isset($_POST['namaRuangan'])) { ?>
                                                        <option selected><?php echo $NamaGet ?></option>
                                                    <?php } else { ?>
                                                        <option selected>Pilih Nama Ruangan</option>
                                                    <?php } ?>
                                                    <?php
                                                    $query = mysqli_query($conn, "SELECT DISTINCT Kode_Ruangan, Nama_Ruangan FROM logistik_ruangan WHERE Gedung_Ruangan = '" . $_POST['gedungRuangan'] . "'");
                                                    while ($row = mysqli_fetch_array($query)) {
                                                        $Nama_Ruangan = $row['Nama_Ruangan'];
                                                        $Kode_Ruangan = $row['Kode_Ruangan'];
                                                        $Option_Ruangan = $Kode_Ruangan." - ".$Nama_Ruangan;
                                                    ?>
                                                        <option value="<?php echo $Option_Ruangan ?>"><?php echo $Option_Ruangan ?></option>
                                                    <?php } ?>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <input type="hidden" name="lokasiRuangan" value=" <?php echo $LokasiGet ?>">
                                <input type="hidden" name="gedungRuangan" value="<?php echo $GedungGet ?>">
                            </form>
                        </div>

                        <!-- FORMULIR TANGGAL -->
                        <div class="mb-3">
                            <div class="mb-2">
                                <div class="form-group">
                                    <label for="selectMonthStart" class="mb-2"><strong> Bulan Awal Periode Monitoring</strong></label>
                                    <div class="d-flex">
                                        <div class="form-group" style="width: 100%;">
                                            <form action="index.php" method="POST">
                                                <?php if (isset($_POST['StartPeriod'])) { ?>
                                                    <input type="month" class="form-control" value="<?php echo $_POST['StartPeriod'] ?>">
                                                <?php } else { ?>
                                                    <input type="month" class="form-control" name="StartPeriod">
                                                <?php } ?>
                                                <input type="hidden" name="lokasiRuangan" value=" <?php echo $LokasiGet ?>">
                                                <input type="hidden" name="gedungRuangan" value="<?php echo $GedungGet ?>">
                                                <input type="hidden" name="namaRuangan" value="<?php echo $NamaGet ?>">
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- FORMULIR TANGGAL -->
                        <div class="mb-3">
                            <div class="mb-2">
                                <div class="form-group">
                                    <label for="selectMonthEnd" class="mb-2"><strong> Bulan Akhir Periode Monitoring</strong></label>
                                    <div class="d-flex">
                                        <div class="form-group" style="width: 100%;">
                                            <form action="insert.php" method="POST">
                                                <?php if (isset($_POST['EndPeriod'])) { ?>
                                                    <input type="month" class="form-control" value="<?php echo $_POST['EndPeriod'] ?>">
                                                <?php } else { ?>
                                                    <input type="month" class="form-control" name="EndPeriod">
                                                <?php } ?>
                                                <input type="hidden" name="lokasiRuangan" value=" <?php echo $LokasiGet ?>">
                                                <input type="hidden" name="gedungRuangan" value="<?php echo $GedungGet ?>">
                                                <input type="hidden" name="namaRuangan" value="<?php echo $NamaGet ?>">
                                                <input type="hidden" name="StartPeriod" value="<?php echo $StartGet ?>">
                                                <input type="hidden" name="SaveBtn" value="True">
                                                <button type="submit" class="btn btn-danger mt-2" style="width: 100%;">Simpan</button>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            <?php } ?>
        </div>
    </div>
</body>
<script src="../js/bootstrap.min.js"></script>
<script src="../js/jquery.min.js"></script>
<script src="../js/popper.js"></script>
<script src="../js/main.js"></script>
<script src="../js/script.js"></script>
<script src="../js/monitoring.js"></script>

<script>
    $('[name="lokasiRuangan"]').change(function() {
        $(this).closest('form').submit();
    });
</script>
<script>
    $('[name="gedungRuangan"]').change(function() {
        $(this).closest('form').submit();
    });
</script>
<script>
    $('[name="namaRuangan"]').change(function() {
        $(this).closest('form').submit();
    });
</script>
<script>
    $('[name="StartPeriod"]').change(function() {
        $(this).closest('form').submit();
    });
</script>

</html>