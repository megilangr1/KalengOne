<?php 
  require_once('config/koneksi.php');
  require_once('config/helper.php');

  $loginCheck = loginCheck();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <title>IMR Entertainment</title>
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


        <!-- Sidebar Start -->
        <div class="sidebar pe-4 pb-3">
            <nav class="navbar bg-secondary navbar-dark">
                <a href="index.html" class="navbar-brand mx-2 mb-1">
                    <h3 class="text-primary">IMR Entertainment</h3>
                </a>
                <div class="d-flex align-items-center ms-4 mb-4">
                    <div class="position-relative">
                    </div>
                    
                </div>
                <div class="navbar-nav w-100">
                    <a href="index.html" class="nav-item nav-link active"><i class="fa fa-tachometer-alt me-2"></i>Dashboard</a>
                    <div class="nav-item dropdown">
                        <div class="dropdown-menu bg-transparent border-0">
                        </div>
                    </div>
                    <a href="form_single.html" class="nav-item nav-link"><i class="fa fa-music me-2"></i>Submit Single</a>
                    <a href="form_album.html" class="nav-item nav-link"><i class="fa fa-headphones me-2"></i>Submit Album</a>
                    <a href="request.html" class="nav-item nav-link"><i class="fa fa-history me-2"></i>Requests</a>
                    <a href="contact.html" class="nav-item nav-link"><i class="fa fa-phone me-2"></i>Contact Admin</a>

                        </div>
                    </div>
                </div>
            </nav>
        </div>
        <!-- Sidebar End -->


        <!-- Content Start -->
        <div class="content">
            <!-- Navbar Start -->
            <nav class="navbar navbar-expand bg-secondary navbar-dark sticky-top px-4 py-0">
                <a href="index.html" class="navbar-brand d-flex d-lg-none me-4">
                    <h2 class="text-primary mb-0"><i class="fa fa-user-edit"></i></h2>
                </a>
                <a href="#" class="sidebar-toggler flex-shrink-0">
                    <i class="fa fa-bars"></i>
                </a>
               
                <div class="navbar-nav align-items-center ms-auto">
                    <div class="nav-item dropdown">
                       
                        </a>
                        <div class="dropdown-menu dropdown-menu-end bg-secondary border-0 rounded-0 rounded-bottom m-0">
                            <a href="#" class="dropdown-item">
                                <div class="d-flex align-items-center">
                                    
                                </div>
                            </a>
                            <hr class="dropdown-divider">
                            <a href="#" class="dropdown-item">
                                <div class="d-flex align-items-center">
                                   
                                </div>
                            </a>
                            <hr class="dropdown-divider">
                            <a href="#" class="dropdown-item">
                                <div class="d-flex align-items-center">
                                   
                                </div>
                       
                    </div>
                    <div class="nav-item dropdown">
                        <a href="#" class="nav-link dropdown-toggle" data-bs-toggle="dropdown">
                            <img class="rounded-circle me-lg-2" src="assets/img/profil.png" alt="" style="width: 30px; height: 30px;">
                            <span class="d-none d-lg-inline-flex"></span>
                        </a>
                        <div class="dropdown-menu dropdown-menu-end bg-secondary border-0 rounded-0 rounded-bottom m-0">
                            <a href="profil.html" class="dropdown-item">My Profile</a>
                            <a href="logout.php" class="dropdown-item">Log Out</a>
                </div>
            </nav>
            <!-- Navbar End -->


            <!-- Single & Album Start -->
            <div class="container-fluid pt-4 px-4">
                <div class="row g-6">
                    <div class="col-sm-12 col-xl-6">
                        <div class="bg-secondary rounded d-flex align-items-center justify-content-between p-4">
                            <i class="fa fa-music fa-3x text-primary"></i>
                            <div class="ms-8">
                                <p class="mb-2">Total Single</p>
                                <h6 class="mb-0">0</h6>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-12 col-xl-6">
                        <div class="bg-secondary rounded d-flex align-items-center justify-content-between p-4">
                            <i class="fa fa-headphones fa-3x text-primary"></i>
                            <div class="ms-8">
                                <p class="mb-2">Total Album</p>
                                <h6 class="mb-0">0</h6>
                            </div>
                        </div>
                    </div>
                    
            <!-- Single & Album End -->


            <!-- Release -->
            <div class="row g-4">
                <h3 class="text-center">Your Releases</h3>
              </div>
            
              <div class="row animate-order-3">
                <div class="col-lg-12">
                  <section class="panel">
                    <header class="panel-heading">
                      Latest Single Release
                    </header>
                    <div class="panel-body">
                      <div class="discography scroller">
            
                        
                        
                        <div class="discography-item">
                          <div class="discography-plus">
                            <a href="form_single.html"><span style="display: inline-block; font-size: 6em; color: #fff; line-height: 150px;">+</span></a>
                          </div>
                          <div class="text-left" style="padding: 10px 0 20px 0"><small>Tambah Single Baru</small></div>
                        </div>
            
                      </div> 
            
                    </div>
                  </section>
                </div>
              </div>
            
              <div class="row animate-order-4">
                <div class="col-lg-12">
                  <section class="panel">
                    <header class="panel-heading">
                      Latest Album Release
                    </header>
                    <div class="panel-body">
            
                      <div class="discography scroller">
            
                        
                        
                        <div class="discography-item">
                          <div class="discography-plus">
                            <a href="form_album.html"><span style="display: inline-block; font-size: 6em; color: #fff; line-height: 150px;">+</span></a>
                          </div>
                          <div class="text-left" style="padding: 10px 0 20px 0"><small>Tambah Album Baru</small></div>
                        </div>
            
                      </div> 
            
                    </div>
                  </section>
                </div>
              </div>
            <!-- Release -->

            <!-- Footer Start -->
            <div class="container-fluid pt-4 px-4">
                <div class="bg-secondary rounded-top p-4">
                    <div class="row">
                      <div class="col-24 col-sm-12 text-center text-center">
                        &copy; <a href="https://imrentertainment.com">PT. IMR Entertainment</a>. All Right Reserved. 
                    </div>
                    <div class="col-12 col-sm-6 text-center text-sm-end">
            </div>
            <!-- Footer End -->
        </div>
        <!-- Content End -->


        <!-- Back to Top -->
        <a href="#" class="btn btn-lg btn-primary btn-lg-square back-to-top"><i class="bi bi-arrow-up"></i></a>
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