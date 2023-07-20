<?php
require_once 'connection.php';
include_once '../function/function_monitoring.php';
session_start();
if (isset($_SESSION['Kode_Document'])) {
    $KodeDocument = $_SESSION['Kode_Document'];
}
if (isset($_GET['kode'])) {
    $kode   = $_GET['kode'];
    $nama       = $_GET['nama'];
    $lokasi     = $_GET['lokasi'];
    $gedung     = $_GET['gedung'];
    $periode    = $_GET['Period'];
    $dataPeriod = getListMonth($periode);
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
                <!-- INPUT ASET (TABLE) -->
                <form action="insert.php" method="POST">
                    <table class="table">
                        <thead>

                            <tr>
                                <th scope="col" colspan="1">Nomor Ruang</th>
                                <th scope="col" colspan="3">: <?php echo $kode ?></th>
                            </tr>
                            <tr>
                                <th scope="col" colspan="1">Nama Ruang</th>
                                <th scope="col" colspan="3">: <?php echo $nama ?></th>
                            </tr>
                            <tr>
                                <th scope="col" colspan="1">Lokasi Ruang</th>
                                <th scope="col" colspan="3">: <?php echo $lokasi ?></th>
                            </tr>
                            <tr>
                                <th scope="col" colspan="1">Nama Gedung</th>
                                <th scope="col" colspan="3">: <?php echo $gedung ?></th>
                            </tr>
                            <tr>
                                <th scope="col" colspan="1">Periode Monitoring</th>
                                <th scope="col" colspan="3">: <?php echo $periode ?></th>
                            </tr>

                        </thead>
                    </table>
                    <table class="table" id="myTable">
                        <thead>
                            <tr>
                                <th scope="col">Kode Barang</th>
                                <th scope="col">Nama Barang</th>
                                <th scope="col">Jumlah</th>
                                <th scope="col">Satuan</th>
                                <th scope="col">Keterangan</th>
                                <th colspan="<?php echo count($dataPeriod) ?>">Pengecekan Fisik</th>
                            </tr>
                            <tr>
                                <th></th>
                                <th></th>
                                <th></th>
                                <th></th>
                                <th></th>
                                <?php foreach ($dataPeriod as $Month) { ?>
                                    <th><?php echo $Month ?></th>
                                <?php } ?>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $query = mysqli_query($conn, "SELECT count(*) as total FROM logistik_assets WHERE Kode_Document = $KodeDocument");
                            $data = mysqli_fetch_assoc($query);
                            if ($data['total'] != 0) {
                                $query = mysqli_query($conn, "SELECT * FROM logistik_assets WHERE Kode_Document = $KodeDocument");
                                while ($row = mysqli_fetch_array($query)) { ?>
                                    <tr>
                                        <td><?php echo $row['Kode_Barang'] ?></td>
                                        <td><?php echo $row['Nama_Barang'] ?></td>
                                        <td><?php echo $row['Jumlah_Barang'] ?></td>
                                        <td><?php echo $row['Satuan_Barang'] ?></td>
                                        <td><?php echo $row['Ket_Barang'] ?></td>
                                        <?php
                                        $dataChecked = $row['Pengecekan_Barang'];
                                        $dataChecked = explode(",", $dataChecked);
                                        foreach ($dataPeriod as $data) {
                                            if (in_array($data, $dataChecked)) { ?>
                                                <td class="align-middle">
                                                    <div class="center">
                                                        <input class="form-check-input" type="checkbox" id="checkboxNoLabel" checked disabled>
                                                    </div>
                                                </td>
                                            <?php } else { ?>
                                                <td class="align-middle">
                                                    <div class="center">
                                                        <input class="form-check-input" type="checkbox" id="checkboxNoLabel" disabled>
                                                    </div>
                                                </td>
                                            <?php } ?>
                                        <?php } ?>
                                    <tr>
                                    <?php } ?>
                                <?php } ?>
                                <td><input type="text" class="form-control" name="Input_Kode_Barang" placeholder="Masukkan kode barang"></td>
                                <td>
                                    <input type="text" list="namaBarang" class="form-control" name="Input_Nama_Barang" placeholder="Cth. Meja Kantor">
                                </td>
                                <td><input type="number" class="form-control" name="Input_Jumlah_Barang"></td>
                                <td><select class="form-control" name="Input_Satuan_Barang" id="">
                                        <option value="Unit" selected>Unit</option>
                                        <option value="Pcs">Pcs</option>
                                        <option value="M">M</option>
                                        <option value="Kg">Kg</option>
                                        <option value="Set">Set</option>
                                        <option value="Ls">Ls</option>
                                        <option value="Roll">Roll</option>
                                        <option value="Buah">Buah</option>
                                    </select></td>
                                <td>
                                    <select class="form-control" name="Input_Keterangan_Barang" id="">
                                        <option value="Berfungsi" selected>Berfungsi</option>
                                        <option value="Tidak Berfungsi">Tidak Berfungsi</option>
                                    </select>
                                </td>
                                <?php foreach ($dataPeriod as $data) { ?>
                                    <td class="align-middle">
                                        <div class="center">
                                            <input class="form-check-input" type="checkbox" id="checkboxNoLabel" value="<?php echo $data ?>" name="Input_DataCheck[]">
                                        </div>
                                    </td>
                                <?php } ?>
                                    </tr>
                        </tbody>
                    </table>
                    <div class="center">
                        <button type="submit" class="btn btn-danger" style="width: 100%;" name ="btn-status" value="rephase">Tambah Baris</button>
                        <button type="submit" class="btn btn-warning" name="btn-status" value="endphase">Selesai</button>
                    </div>
                </form>
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

</html>