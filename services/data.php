<?php session_start();
error_reporting(E_ERROR | E_PARSE);
if(isset($_SESSION['Email'])){
    $emailActive = $_SESSION['Email'];
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
                <h1><a href="index.html" class="logo">Bagian Logistik <span>Telkom University</span></a></h1>
                <ul class="list-unstyled components mb-5">
                    <li>
                        <a href="../index.php"><span class="fa fa-user mr-3"></span> Admin Dashboard</a>
                    </li>
                    <li>
                        <a href="document/form1.php"><span class="fa fa-cogs mr-3"></span> Layanan</a>
                    </li>
                    <li class="active">
                        <a href="data.php"><span class="fa fa-sticky-note mr-3"></span> Data</a>
                    </li>
                    <li>
                        <a href="../monitoring/index.php"><span class="fa fa-pencil mr-3"></span> Monitoring</a>
                    </li>
                    <li>
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
                <h3>Data Berita Acara Serah Terima Barang</h3>
                <div class="box-line"></div>
                <div class="card-body">
                    <table class="table table-bordered" id="myTable">
                        <thead>
                            <tr>
                                <th scope="col">No BAST</th>
                                <th scope="col">Tanggal</th>
                                <th scope="col">Unit Penerima</th>
                                <th scope="col">Dokumen</th>
                                <th scope="col">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            include('connection.php');
                            $no = 1;
                            $query = mysqli_query($conn, "SELECT logistic_document.ID_Document,logistic_document.ID_LogDoc, Tanggal_BAST, InstitusiPenerima, File_Document FROM logistic_user_data JOIN logistic_doc_user ON logistic_user_data.ID_UserData = logistic_doc_user.ID_UserData JOIN logistic_document ON logistic_document.ID_LogDoc = logistic_doc_user.ID_LogDoc JOIN logistic_account ON logistic_account.ID_User = logistic_document.ID_User WHERE logistic_account.Email = '" . $emailActive . "';");
                            while ($row = mysqli_fetch_array($query)) {
                            ?>
                                <tr>
                                    <?php $ID_Document2 = $row['ID_Document'] ?>
                                    <?php $ID_Document = str_replace("/", "_", $ID_Document2) ?>
                                    <td><?php echo $ID_Document ?></td>
                                    <td><?php echo $row['Tanggal_BAST'] ?></td>
                                    <td><?php echo $row['InstitusiPenerima'] ?></td>
                                    <td class="text-center">
                                        <?php echo "<a href='../document/Bast_" . $ID_Document . ".pdf' target='_blank' class='btn btn-sm btn-danger fa fa-eye'></a>" ?>
                                        <?php echo "<a href='../document/Bast_" . $ID_Document . ".pdf' download='Dokumen_Bast_" . $ID_Document . ".pdf' class='btn btn-sm btn-danger fa fa-download'></a>" ?>
                                    </td>
                                    <td class="text-center">
                                        <a href="edit.php?ID_Document=<?php echo $row['ID_LogDoc'] ?>" class="btn btn-sm btn-danger fa fa-edit"></a>
                                        <a href="delete.php?ID_Document=<?php echo $row['ID_LogDoc'] ?>" onclick="return confirm('Apakah Anda yakin menghapus data ini?')" class="btn btn-sm btn-danger fa fa-trash">
                                        </a>
                                    </td>
                                </tr>

                            <?php } ?>
                        </tbody>
                    </table>
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

</html>