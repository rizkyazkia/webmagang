<?php
session_start();
error_reporting(E_ERROR | E_PARSE);
$UIDInput2  = uniqid("SIGN_PENERIMA", true);
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
    <link type="text/css" href="http://ajax.googleapis.com/ajax/libs/jqueryui/1.12.1/themes/south-street/jquery-ui.css" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="../../asset/jquery.signature.css">
    <script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
    <script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js"></script>
    <script type="text/javascript" src="../../asset/jquery.signature.min.js"></script>
    <style>
        .kbw-signature {
            width: 400px;
            height: 200px;
        }

        #sig canvas {
            width: 100% !important;
            height: auto;
        }
    </style>
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
        <div id="content" class="p-4 p-md-5 pt-5">
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
                <h3>Formulir Berita Acara Serah Terima Barang</h3>
                <div class="box-line"></div>

                <h4>Identitas Penerima</h4>
                <!-- PROGRESS BAR -->
                <div class="progress mb-5" style="height:30px">
                    <div class="progress-bar bg-danger" role="progressbar" style="width: 5%" aria-valuenow="5" aria-valuemin="0" aria-valuemax="5">0%</div>
                </div>

                <!-- FORMULIR -->
                <div class="row">
                    <div class="col-12">
                        <form action="../process.php" method="POST" id="form-4">
                            <div class="mb-3">
                                <label for="inputNamaPenerima" class="form-label">Nama Penerima</label>
                                <input type="text" id="inputNamaPenerima" class="form-control" name="NamaPenerimaInput" placeholder="Cth. Imam Sudrajat">
                            </div>
                            <div class="mb-3">
                                <label for="inputInstitusiPenerima" class="form-label">Asal Institusi Pihak Penerima</label>
                                <input type="text" class="form-control" id="inputInstitusiPenerima" name="InstitusiPenerimaInput" placeholder="Cth. Unit SDM">
                            </div>
                            <!-- TANDA TANGAN Penerima -->
                            <div class="mb-1">
                                Form Tanda Tangan Penerima
                            </div>
                            <div id="sig"></div>
                            <textarea id="signature64" name="signed2" style="display: none"></textarea>
                            <div class="mt-2 mb-3">
                                <input type="hidden" value="<?php echo $UIDInput2 ?>" name="UIDInput2">
                                <button id="clear" class="btn btn-warning">Clear Signature</button>
                            </div>
                            <input type="hidden" name="form-control" value="4">
                            <button id="ButtonFormSubmit" class="btn btn-danger" style="width:100%">Simpan</button>
                        </form>
                    </div>
                </div>
        </div>

        <script type="text/javascript">
            var sig = $('#sig').signature({
                syncField: '#signature64',
                syncFormat: 'PNG'
            });
            $('#clear').click(function(e) {
                e.preventDefault();
                sig.signature('clear');
                $("#signature64").val('');
            });
            $('#ButtonFormSubmit').click(function(e) {
                alert("Data Penerima berhasil disimpan!");
            });
        </script>
    <?php } ?>
    </div>
    </div>
</body>
<script src="../../js/bootstrap.min.js"></script>
<script src="../../js/jquery.min.js"></script>
<script src="../../js/popper.js"></script>
<script src="../../js/main.js"></script>
<script src="../../js/script.js"></script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/signature_pad@2.3.2/dist/signature_pad.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/2.9.2/umd/popper.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.1.0/js/bootstrap.min.js"></script>

</html>