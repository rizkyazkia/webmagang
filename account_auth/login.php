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
    <section>
        <div class="background center" style="padding-top: 90px; padding-bottom:50px;">
            <span></span>
            <span></span>
            <span></span>
            <span></span>
            <span></span>
            <span></span>
            <span></span>
            <div class="box-login">
                <h3>Login</h3>
                <h6 class="mb-4">Welcome Back Please Login To Your Account</h6>

                <!-- STATUS ACCOUNT AUTH -->
                <?php
                if (isset($_GET['State'])) {
                    if ($_GET['State'] == "False") { ?>
                        <div style="color:#ED1D24">
                            <strong>Error : </strong>Oops, your email and password is invalid!
                        </div>
                <?php }
                } ?>
                <!-- END STATUS ACCOUNT AUTH -->

                <form action="auth_login.php" method="POST" id="form-login">
                    <div class="mb-3 mt-3">
                        <label for="InputEmail" class="form-label">Email</label>
                        <input type="email" class="form-control form-transparent" name="usernameinput" required>
                    </div>
                    <div class="mb-3">
                        <label for="InputPassword" class="form-label">Password</label>
                        <input type="password" class="form-control form-transparent" name="passwordinput" autocomplete="off" required>
                    </div>
                    <!-- FIX THE REMEMBER ME -->
                    <div class="row">
                        <div class="col-12">
                            <div class="mb-3 form-check">
                                <input type="checkbox" class="form-check-input" id="Check" name="RememberLogin" checked autocomplete="off">
                                <label for="Check" class="form-check-label">Remember me</label>
                            </div>
                        </div>
                    </div>
                    <input type="hidden" name="btnlogin" value="clicked">
                    <button type="submit" class="btn btn-danger button-login" id="loadinglogin">Login</button>
                </form>
                <div class="row mt-4">
                    <div class="col-7 p-0" style="text-align: right;">
                        <h6>Don't have account? </h6>
                    </div>
                    <div class="col-5 pl-1" style="text-align: left;">
                        <h6>
                            <a href="https://wa.me/6281324874436?text=Halo,%20Bapak/Ibu%20Admin%20Unit%20Logistik%20&%20Aset%20Telkom%20University" target="_blank">Contact Us</a>
                        </h6>
                    </div>
                </div>
            </div>
        </div>
    </section>
</body>
<script src="../js/bootstrap.min.js"></script>
<script src="../js/jquery.min.js"></script>
<script src="../js/popper.js"></script>
<script src="../js/main.js"></script>
<script src="../js/script.js"></script>

</html>