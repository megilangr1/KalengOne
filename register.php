<?php require_once('config/koneksi.php'); ?>

<?php 
  $errorMessage = [];
  if (isset($_POST['registerUser'])) {
    require_once('config/helper.php');

    $userData = [
      'nama_depan' => htmlspecialchars(trim($_POST['nama_depan'])),
      'nama_belakang' => htmlspecialchars(trim($_POST['nama_belakang'])),
      'email' => htmlspecialchars(trim($_POST['email'])),
      'password' => htmlspecialchars(trim($_POST['password'])),
    ];

    $validateArray = [
      [
        'name' => 'nama_depan',
        'alias' => 'Nama Depan',
        'success' => false,
        'error_msg' => null,
      ],
      [
        'name' => 'nama_belakang',
        'alias' => 'Nama Belakang',
        'success' => false,
        'error_msg' => null,
      ],
      [
        'name' => 'email',
        'alias' => 'Alamat Email',
        'success' => false,
        'error_msg' => null,
      ],
      [
        'name' => 'password',
        'alias' => 'Password',
        'success' => false,
        'error_msg' => null,
      ]
    ];    

    $validate = validateArray($userData, $validateArray);
    if ($validate['code'] == false) {
      $validateArray = $validate['res'];
      $errorMessage = $validate['res'];
    } else {
      $checkEmail = $koneksi->query("SELECT * FROM users WHERE email='". $userData['email'] ."' ");
      if ($checkEmail->fetch_array() != null) {
        $errorMessage[] = [
          'name' => 'email',
          'alias' => 'Alamat Email',
          'success' => false,
          'error_msg' => 'Sudah di-Gunakan !',
        ];
      } else {
        $createUser = $koneksi->query("INSERT INTO users (nama_depan, nama_belakang, username, email, password, level) VALUES ('" .$userData['nama_depan'] ."', '" .$userData['nama_belakang'] ."', '" .rand(1000000, 9999999) ."', '" .$userData['email'] ."', '" .$userData['password'] ."', '1')");
        if (!$createUser) {
          $errorMessage[] = [
            'name' => 'fail-insert',
            'alias' => 'Registrasi',
            'success' => false,
            'error_msg' => 'Gagal, Silahkan coba lagi dalam beberapa saat !',
          ];
        } else {
          // Login Session 
          $getUser = $koneksi->query("SELECT * FROM users WHERE email='". $userData['email'] ."'");
          $data = $getUser->fetch_object();
          if ($data != null) {
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

            echo "<script>window.location='". $baseUrl ."';</script>";
          }
        }
      }
    }
  }
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <title>Registrasi - IMR Entertainment</title>
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


        <!-- Sign Up Start -->
        <div class="container-fluid">
          <form action="register.php" method="post">
            <div class="row h-100 align-items-center justify-content-center" style="min-height: 100vh;">
                <div class="col-12 col-sm-8 col-md-6 col-lg-5 col-xl-4">
                    <div class="bg-secondary rounded p-4 p-sm-5 my-4 mx-3">
                        <div class="align-items-center mb-3">
                            <a href="index.php" class="text-center">
                                <h4 class="text-primary"><i class="fa fa-user-edit me-2"></i>IMR Entertainment</h4>
                            </a>
                            <br>
                            <h3 class="text-center">Registrasi Akun</h3>
                        </div>
                        <div class="form-floating mb-3">
                            <input type="text" name="nama_depan" class="form-control" id="floatingText" placeholder="Silahkan Masukan Nama Depan..." required autofocus>
                            <label for="floatingText">Nama Depan</label>
                        </div>
                        <div class="form-floating mb-3">
                            <input type="text" name="nama_belakang" class="form-control" id="floatingText" placeholder="Silahkan Masukan Nama Belakang..." required>
                            <label for="floatingText">Nama Belakang</label>
                        </div>
                        <div class="form-floating mb-3">
                            <input type="email" name="email" class="form-control" id="floatingInput" placeholder="Silahkan Masukan Alamat Email..." required>
                            <label for="floatingInput">Alamat Email</label>
                        </div>
                        <div class="form-floating mb-4">
                            <input type="password" name="password" class="form-control" id="floatingPassword" placeholder="Silahkan Masukan Password..." required>
                            <label for="floatingPassword">Password</label>
                        </div>
                        <?php if ($errorMessage != null) { ?>
                          <div class="form-floating mb-4">
                              <div class="alert alert-danger px-1 py-3" role="alert" style="font-size: 12px !important;">
                                  <ul class="mb-0">
                                    <?php 
                                      foreach ($errorMessage as $key => $value) {
                                        if ($value['success'] == false) {
                                          echo "<li>". $value['alias'] . ' - ' . $value['error_msg'] ."</li>";
                                        }
                                      }
                                    ?>
                                  </ul>
                              </div>
                          </div>
                        <?php } ?>
                        <!-- <div class="form-floating mb-4">
                            <input type="file" class="form-control" id="floatingPassword" placeholder="silahkan masukkan kata sandi">
                            <label for="floatingPassword">Upload Bukti Pembayaran</label>
                            <small>Total Rp. 3.500.000 trasfer ke No rekening BCA 0380957213 an Irfan Maulana R</small>
                            <br>
                            <small>Note : Pembayaran Cukup 1 Kali dan Tidak ada lagi pembayaran untuk Upload/Rilis Lagu dan Album Sepuasnya</small>
                        </div> -->
                        <!-- <div class="d-flex align-items-center justify-content-between mb-4">
                            <div class="form-check">
                                <input type="checkbox" class="form-check-input" id="remember me">
                                <label class="form-check-label" for="exampleCheck1">Ingatkan Saya!</label>
                            </div>
                        </div> -->
                        <button type="submit" class="btn btn-primary py-3 w-100 mb-4" name="registerUser">Registrasi</button>
                        <p class="text-center mb-0">Sudah Mempunyai Akun? <a href="http://localhost/imr/index.php">Login</a></p>
                    </div>
                </div>
            </div>
          </form>
        </div>
        <!-- Sign Up End -->
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

<?php 
?>