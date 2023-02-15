<?php 
    require_once('config/koneksi.php');
    require_once('config/helper.php');
        
    if (isset($_SESSION['user'])) { header('location: index.php'); }

    $errorMessage = [];
    if (isset($_POST['loginUser'])) {
        $email = htmlspecialchars(trim($_POST['email']));
        $password = htmlspecialchars(trim($_POST['password']));

        $checkUser = $koneksi->query("SELECT * FROM users WHERE email='$email' AND password='$password' ");
        $data = $checkUser->fetch_object();
        if ($data == null) {
            $errorMessage[] = [
                'name' => 'user',
                'alias' => 'Login Gagal',
                'success' => false,
                'error_msg' => 'Email / Password yang anda masukan salah !',
            ];
        } else {
            $_SESSION['user'] = [
                'id' => $data->id,
                'nama_depan' => $data->nama_depan,
                'nama_belakang' => $data->nama_belakang,
                'username' => $data->username,
                'email' => $data->email,
                'level' => $data->level,
                'login_date' => date('Y-m-d'),
                'login_time' => date('H:i:s') 
            ];

            if ($data->level > 0) {
                echo "<script>window.location='". $baseUrl ."';</script>";
            } else {
                echo "<script>window.location='". $baseUrl ."admin/admin.php';</script>";
            }


        }
    }
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <title>Login - IMR Entertainment</title>
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <meta content="" name="keywords">
    <meta content="" name="description">

    <!-- Favicon -->
    <link href="assets/img/favicon.ico" rel="icon">

    <!-- Google Web Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Open+Sans:wght@400;600&family=Roboto:wght@500;700&display=swap" rel="stylesheet"> 
    
    <!-- Icon Font Stylesheet -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.10.0/css/all.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.4.1/font/bootstrap-icons.css" rel="stylesheet">

    <!-- Libraries Stylesheet -->
    <link href="assets/lib/owlcarousel/assets/owl.carousel.min.css" rel="stylesheet">
    <link href="assets/lib/tempusdominus/css/tempusdominus-bootstrap-4.min.css" rel="stylesheet" />

    <!-- Customized Bootstrap Stylesheet -->
    <link href="assets/css/bootstrap.min.css" rel="stylesheet">

    <!-- Template Stylesheet -->
    <link href="assets/css/style.css" rel="stylesheet">
</head>

<body>
    <div class="container-fluid position-relative d-flex p-0">
        <!-- Spinner Start -->
        <div id="spinner" class="show bg-dark position-fixed translate-middle w-100 vh-100 top-50 start-50 d-flex align-items-center justify-content-center">
            <div class="spinner-border text-primary" style="width: 3rem; height: 3rem;" role="status">
                <span class="sr-only">Loading...</span>
            </div>
        </div>
        <!-- Spinner End -->


        <!-- Sign In Start -->
        <div class="container-fluid">
            <form action="login.php" method="post">
                <div class="row h-100 align-items-center justify-content-center" style="min-height: 100vh;">
                    <div class="col-12 col-sm-8 col-md-6 col-lg-5 col-xl-4">
                        <div class="bg-secondary rounded p-4 p-sm-5 my-4 mx-3">
                            <div class="align-items-center mb-3">
                                <a href="#" class="text-center">
                                    <h4 class="text-primary">
                                        <i class="fa fa-user-edit me-2"></i> &ensp; IMR Entertainment
                                        <hr class="my-2">
                                        <div class="text-white">Login</div>
                                    </h4>
                                </a>
                            </div>
                            <div class="form-floating mb-3">
                                <input type="email" class="form-control" id="floatingInput" name="email" placeholder="name@example.com" required autofocus>
                                <label for="floatingInput">Alamat Email</label>
                            </div>
                            <div class="form-floating mb-4">
                                <input type="password" class="form-control" id="floatingPassword" name="password" placeholder="Password" required>
                                <label for="floatingPassword">Password</label>
                            </div>
                            <?php if ($errorMessage != null) { ?>
                                <div class="form-floating mb-4">
                                    <div class="alert alert-danger px-1 py-3" role="alert" style="font-size: 12px !important;">
                                        <ul class="mb-0">
                                            <?php 
                                            foreach ($errorMessage as $key => $value) {
                                                if ($value['success'] == false) {
                                                echo "<li>". $value['alias'] . ' <br> ' . $value['error_msg'] ."</li>";
                                                }
                                            }
                                            ?>
                                        </ul>
                                    </div>
                                </div>
                            <?php } ?>
                            <button type="submit" class="btn btn-primary py-3 w-100 mb-4" name="loginUser">Login</button>
                            <p class="text-center mb-0">Belum mempunyai Akun? <a href="register.php">Registrasi</a></p>
                            <p class="text-center mb-0">Lupa password ? <a href="register.php">Klik disini</a></p>
                        </div>
                    </div>
                </div>
            </form>
        </div>
        <!-- Sign In End -->
    </div>

    <!-- JavaScript Libraries -->
    <script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="assets/lib/chart/chart.min.js"></script>
    <script src="assets/lib/easing/easing.min.js"></script>
    <script src="assets/lib/waypoints/waypoints.min.js"></script>
    <script src="assets/lib/owlcarousel/owl.carousel.min.js"></script>
    <script src="assets/lib/tempusdominus/js/moment.min.js"></script>
    <script src="assets/lib/tempusdominus/js/moment-timezone.min.js"></script>
    <script src="assets/lib/tempusdominus/js/tempusdominus-bootstrap-4.min.js"></script>

    <!-- Template Javascript -->
    <script src="assets/js/main.js"></script>
</body>
</html>
