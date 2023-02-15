<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <title>User Area - IMR Entertainment</title>
  <meta content="width=device-width, initial-scale=1.0" name="viewport">
  <meta content="" name="keywords">
  <meta content="" name="description">

  <!-- Favicon -->
  <link href="<?= $baseUrl ?>assets/img/favicon.ico" rel="icon">

  <!-- Google Web Fonts -->
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Open+Sans:wght@400;600&family=Roboto:wght@500;700&display=swap" rel="stylesheet">

  <!-- Icon Font Stylesheet -->
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.10.0/css/all.min.css" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.4.1/font/bootstrap-icons.css" rel="stylesheet">

  <!-- Libraries Stylesheet -->
  <link href="<?= $baseUrl ?>assets/lib/owlcarousel/assets/owl.carousel.min.css" rel="stylesheet">
  <link href="<?= $baseUrl ?>assets/lib/tempusdominus/css/tempusdominus-bootstrap-4.min.css" rel="stylesheet" />

  <!-- Customized Bootstrap Stylesheet -->
  <link href="<?= $baseUrl ?>assets/css/bootstrap.min.css" rel="stylesheet">

  <!-- Template Stylesheet -->
  <link href="<?= $baseUrl ?>assets/css/style.css" rel="stylesheet">
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

    <!-- Sidebar Start -->
    <div class="sidebar pe-4 pb-3">
      <nav class="navbar bg-secondary navbar-dark">
        <a href="<?=$baseUrl?>index.php" class="navbar-brand mx-2 mb-1">
          <h3 class="text-primary">IMR Entertainment</h3>
        </a>
        <div class="d-flex align-items-center ms-4 mb-4">
          <div class="position-relative">
          </div>
        </div>
        <div class="navbar-nav w-100">
          <a href="<?=$baseUrl?>index.php" class="nav-item nav-link active"><i class="fa fa-home me-2"></i>Menu Utama</a>
          <div class="nav-item dropdown">
            <div class="dropdown-menu bg-transparent border-0">
            </div>
          </div>
          <a href="<?=$baseUrl?>album/index.php" class="nav-item nav-link"><i class="fa fa-headphones me-2"></i>Data Album</a>
          <a href="form_single.html" class="nav-item nav-link"><i class="fa fa-music me-2"></i>Submit Single</a>
          <!-- <a href="request.html" class="nav-item nav-link"><i class="fa fa-history me-2"></i>Requests</a> -->
          <!-- <a href="contact.html" class="nav-item nav-link"><i class="fa fa-phone me-2"></i>Contact Admin</a> -->

          <?php if (isset($loginCheck['level']) && $loginCheck['level'] == 1) { ?> 
            <a href="<?=$baseUrl?>users/upgrade_akun.php" class="nav-item nav-link"><i class="fa fa-coins me-2"></i>Upgrade Akun</a>
          <?php } ?>
        </div>
      </nav>
    </div>
  </div>
  <!-- Sidebar End -->


  <!-- Content Start -->
  <div class="content">
    <!-- Navbar Start -->
    <nav class="navbar navbar-expand bg-secondary navbar-dark sticky-top px-4 py-0">
      <a href="<?=$baseUrl?>index.php" class="navbar-brand d-flex d-lg-none me-4">
        <h2 class="text-primary mb-0"><i class="fa fa-user-edit"></i></h2>
      </a>
      <a href="#" class="sidebar-toggler flex-shrink-0">
        <i class="fa fa-bars"></i>
      </a>

      <div class="navbar-nav align-items-center ms-auto">
        <div class="nav-item dropdown">
          <div class="nav-item dropdown">
            <a href="#" class="nav-link dropdown-toggle" data-bs-toggle="dropdown">
              <img class="rounded-circle me-lg-2" src="<?= $baseUrl ?>assets/img/profil.png" alt="" style="width: 30px; height: 30px;">
              <span class="d-none d-lg-inline-flex"></span>
            </a>
            <div class="dropdown-menu dropdown-menu-end bg-secondary border-0 rounded-0 rounded-bottom m-0">
              <a href="logout.php" class="dropdown-item">Log Out</a>
            </div>
          </div>
        </div>
      </div>
    </nav>
    <!-- Navbar End -->


    <!-- Single & Album Start -->
    <div class="container-fluid pt-4 px-4">
      <div class="row g-6">
        <?php if (isset($_SESSION['flash_error'])) { ?>
          <div class="col-12">
            <div class="alert alert-danger" role="alert">
              <h4 class="alert-heading">Peringatan !</h4>
              <p style="font-size: 12px !important;">
                <?=$_SESSION['flash_error']?>
              </p>
            </div>
          </div>
        <?php unset($_SESSION['flash_error']); } ?>

        <?php if (isset($_SESSION['flash_success'])) { ?>
          <div class="col-12">
            <div class="alert alert-success" role="alert">
              <h4 class="alert-heading">Berhasil !</h4>
              <p style="font-size: 12px !important;">
                <?=$_SESSION['flash_success']?>
              </p>
            </div>
          </div>
        <?php unset($_SESSION['flash_success']); } ?>