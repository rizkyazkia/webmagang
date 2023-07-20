<?php
error_reporting(E_ERROR | E_PARSE);
session_start();
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
                        <a href="../index.php"><span class="fa fa-user mr-3"></span> Admin Dashboard</a>
                    </li>
                    <li class="active">
                        <a href="form1.php"><span class="fa fa-cogs mr-3"></span> Layanan</a>
                    </li>
                    <li>
                        <a href="../data.php"><span class="fa fa-sticky-note mr-3"></span> Data</a>
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
                <?php if (isset($_GET['status'])) { ?>
                    <div class="alert alert-success" role="alert">
                        Data barang berhasil disimpan!
                    </div>
                <?php } ?>

                <h3>Formulir Berita Acara Serah Terima Barang</h3>
                <div class="box-line"></div>

                <!-- PROGRESS BAR -->
                <div class="progress mb-5" style="height:30px">
                    <div class="progress-bar bg-danger" role="progressbar" style="width: 25%" aria-valuenow="25" aria-valuemin="0" aria-valuemax="25">25%</div>
                </div>
                <!-- FORMULIR -->
                <form action="../process.php" method="POST" id="form-2">
                    <div class="mb-3">
                        <label for="inputNamaBarang" class="form-label">Nama Barang</label>
                        <input type="text" class="form-control" id="inputNamaBarang" name="NamaBarangInput" placeholder="Cth. Kursi Kantor">
                    </div>

                    <div class="mb-3">
                        <label for="inputVolBarang" class="form-label">Volume Barang</label>
                        <input type="number" id="inputVolBarang" class="form-control" name="VolBarangInput">
                    </div>

                    <div class="mb-3">
                        <label for="inputSatuanBarang" class="form-label">Satuan Barang</label>
                        <input type="text" id="inputSatuanBarang" class="form-control" name="SatuanBarangInput" placeholder="Cth. Unit, Pax, Box">
                    </div>

                    <div class="mb-3">
                        <label for="inputKetBarang" class="form-label">Keterangan Barang</label>
                        <input type="text" id="inputKetBarang" class="form-control" name="KetBarangInput" placeholder="Cth. Kondisi Baik">
                    </div>
                    <input type="hidden" name="form-control" value="2">
                    <button class="btn btn-danger mb-5" type="submit" value="nextphase" name="simpanbarangbtn">Simpan</button>
                    <button class="btn btn-warning mb-5" type="submit" value="rephase" name="simpanbarangbtn">Tambahkan Barang</button>
                </form>
            <?php } ?>
        </div>
    </div>
</body>
<script src="../../js/bootstrap.min.js"></script>
<script src="../../js/jquery.min.js"></script>
<script src="../../js/popper.js"></script>
<script src="../../js/main.js"></script>
<script src="../../js/script.js"></script>

</html>