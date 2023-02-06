<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <title>Tambah Single - IMR Entertainment</title>
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <meta content="" name="keywords">
    <meta content="" name="description">

    <!-- Favicon -->
    <link href="img/favicon.ico" rel="icon">

    <!-- Google Web Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Open+Sans:wght@400;600&family=Roboto:wght@500;700&display=swap" rel="stylesheet"> 
    
    <!-- Icon Font Stylesheet -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.10.0/css/all.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.4.1/font/bootstrap-icons.css" rel="stylesheet">

    <!-- Libraries Stylesheet -->
    <link href="lib/owlcarousel/assets/owl.carousel.min.css" rel="stylesheet">
    <link href="lib/tempusdominus/css/tempusdominus-bootstrap-4.min.css" rel="stylesheet" />

    <!-- Customized Bootstrap Stylesheet -->
    <link href="css/bootstrap.min.css" rel="stylesheet">

    <!-- Template Stylesheet -->
    <link href="css/style.css" rel="stylesheet">
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
                    <a href="index.html" class="nav-item nav-link"><i class="fa fa-tachometer-alt me-2"></i>Dashboard</a>
                    <div class="nav-item dropdown">
                        <div class="dropdown-menu bg-transparent border-0">
                        </div>
                    </div>
                    <a href="form_single.html" class="nav-item nav-link active"><i class="fa fa-music me-2"></i>Submit Single</a>
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
                            <img class="rounded-circle me-lg-2" src="img/profil.png" alt="" style="width: 30px; height: 30px;">
                            <span class="d-none d-lg-inline-flex"></span>
                        </a>
                        <div class="dropdown-menu dropdown-menu-end bg-secondary border-0 rounded-0 rounded-bottom m-0">
                            <a href="profil.html" class="dropdown-item">My Profile</a>
                            <a href="logout.php" class="dropdown-item">Log Out</a>
                </div>
            </nav>
            <!-- Navbar End -->


            <!-- Form Start -->
            <div class="container-fluid pt-4 px-4 center">
                <div class="row g-4 center">
                    <div class="col-sm-24 col-xl-12">
                        <div class="bg-secondary rounded h-100 p-4">
                            <h2 class="mb-4 text-center">TAMBAH SINGLE BARU</h2>
                            <form  action="proses-single.php" method="post" enctype="multipart/form-data">
                                <div class="mb-3">
                                    <label for="name" class="form-label">Judul Lagu<span class="required">*</span></label>
                                    <input type="text" class="form-control" id="title" name="judul_lagu" required />
                                </div>
                                <div class="mb-3">
                                    <label for="cname" class="form-label">Artis<span class="required">*</span></label>
                                    <input type="text" class="form-control" id="artis" name="artis" required />
                                    <div id="artis" class="form-text"><small>Nama artis tidak mengandung kata general seperti (Music/Musik, Remix, Studio, Official, dll.)</small>
                                    </div>
                                </div>
                                <div class="mb-3">
                                    <label for="cname" class="form-label">Featuring Artis</label>
                                    <input type="text" class="form-control" id="featuring_artis" name="featuring_artis"/>
                                </div>
                                <div class="mb-3">
                                    <label for="cname" class="form-label">Bahasa<span class="required">*</span></label>
                                    <input type="text" class="form-control" id="bahasa" name="bahasa" minlength="5" required />
                                </div>
                                <div class="mb-3">
                                    <label for="cname" class="form-label">Genre<span class="required">*</span></label>
                                </div>
                                <select class="form-select mb-3" aria-label="Default select example" name="genre">
                                    <option value="" selected disabled>-- Pilih Genre Musik --</option>
                                    <option value="Pop">Pop</option>
                                    <option value="Rock">Rock</option>
                                    <option value="Alternative">Alternative</option>
                                    <option value="Blues">Blues</option>
                                    <option value="Dance">Dance</option>
                                    <option value="Hiphop/Rap">Hiphop/Rap</option>
                                    <option value="Jazz">Jazz</option>
                                    <option value="RnB">RnB</option>
                                    <option value="Reggae">Reggae</option>
                                    <option value="Heavy Metal">Heavy Metal</option>
                                    <option value="Ska">Ska</option>
                                    <option value="Punk">Punk</option>
                                    <option value="Dangdut">Dangdut</option>
                                    <option value="Instrumental">Instrumental</option>
                                    <option value="Acapella">Acapella</option>
                                    <option value="Folk">Folk</option>
                                    <option value="Gospel">Gospel</option>
                                    <option value="EDM">EDM</option>
                                    <option value="Koplo">Koplo</option>
                                    <option value="New Wave">New Wave</option>
                                    <option value="Ethnic">Ethnic</option>
                                    <option value="World Music">World Music</option>
                                    <option value="House Music">House Music</option>
                                    <option value="Religi">Religi</option>
                                </select>
                                <div class="mb-3">
                                    <label for="cname" class="form-label">Sub Genre</label>
                                    <input type="text" class="form-control" id="sub_genre" name="sub_genre"/>
                                </div>
                                <div class="mb-3">
                                    <label for="date" class="form-label">Tanggal Rilis<span class="required">*</span></label>
                                    <input type="date" class="form-control" id="tanggal_rilis" name="tanggal_rilis" required/>
                                    <div id="tgl_release" class="form-text"><small>Isi dengan tanggal perilisan yang diinginkan (minimal 7 Hari dari pengisian formulir ini)</small>
                                </div>
                                <div class="mb-3">
                                    <label for="curl" class="form-label">Link Spotify</label>
                                    <input type="url" class="form-control" id="link_spotify" name="link_spotify"/>
                                    <div id="spotify" class="form-text"><small>Isi jika sudah memiliki akun artis spotify</small>
                                </div>
                                <div class="mb-3">
                                    <label for="curl" class="form-label">Link iTunes</label>
                                    <input type="url" class="form-control" id="link_itunes" name="link_itunes"/>
                                    <div id="itunes" class="form-text"><small>Isi jika sudah memiliki akun artis iTunes</small>
                                </div>
                                <div class="mb-3">
                                    <label for="curl" class="form-label">Link Channel Youtube</label>
                                    <input type="url" class="form-control" id="link_youtube" name="link_youtube"/>
                                    <div id="youtube" class="form-text"><small>Isi jika sudah memiliki Channel Youtube</small>
                                </div>
                                <div class="mb-3">
                                    <label for="cname" class="form-label">Contact Person<span class="required">*</span></label>
                                    <input type="text" class="form-control" id="contact_person" name="contact_person" required/>
                                </div>
                                <div class="mb-3">
                                    <label for="cname" class="form-label">Pencipta Lagu<span class="required">*</span></label>
                                    <input type="text" class="form-control" id="pencipta_lagu" name="pencipta_lagu" required/>
                                </div>
                                <div class="mb-3">
                                    <label for="cname" class="form-label">Komposer<span class="required">*</span></label>
                                    <input type="text" class="form-control" id="komposer" name="komposer" required/>
                                </div>
                                <div class="mb-3">
                                    <label for="cname" class="form-label">Arranger<span class="required">*</span></label>
                                    <input type="text" class="form-control" id="arranger" name="arranger" required/>
                                </div>
                                <div class="mb-3">
                                    <label for="cname" class="form-label">Produser<span class="required">*</span></label>
                                    <input type="text" class="form-control" id="produser" name="produser" required/>
                                </div>
                                <div class="mb-3">
                                    <label for="cname" class="form-label">Tahun Produksi<span class="required">*</span></label>
                                    <input type="text" class="form-control" id="tahun_produksi" name="tahun_produksi" required/>
                                </div>
                                <div class="mb-3">
                                    <label for="cname" class="form-label">Gambar Cover Lagu<span class="required">*</span></label>
                                    <input type="file" class="form-control" id="cover_lagu" name="cover_lagu" accept="image/jpg, image/jpeg" required/>
                                    <small>Silahkan masukkan gambar dengan resolusi 1440x1440 Piksel dengan Format JPG, High Resolution/Tidak Blur. Pastikan dalam cover hanya ada tulisan judul lagu dan nama artist </small>
                                </div>
                                <div class="mb-3">
                                    <label for="cname" class="form-label">Upload Lagu<span class="required">*</span></label>
                                    <input type="file" class="form-control" id="upload_lagu" name="upload_lagu" accept="audio/x-wav" required/>
                                    <small>Silahkan Masukan Lagu Dengan Format  WAV</small>
                                </div>
                                <div class="mb-3">
                                    <label for="cname" class="form-label">Upload KTP<span class="required">*</span></label>
                                    <input type="file" class="form-control" id="upload_ktp" name="upload_ktp" accept="image/jpg, image/jpeg, image/png" required/>
                                    <small>MOHON NAMA FILE KTP YANG DIUPLOAD SESUAI DENGAN NAMA LENGKAP YANG TERTERA DI KTP</small>
                                </div>
                                <button type="submit" class="btn btn-primary" name="submit">Submit</button>
                            </form>
                        </div>
                    </div>
                   
            </div>
            <!-- Form End -->


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
    <script src="lib/chart/chart.min.js"></script>
    <script src="lib/easing/easing.min.js"></script>
    <script src="lib/waypoints/waypoints.min.js"></script>
    <script src="lib/owlcarousel/owl.carousel.min.js"></script>
    <script src="lib/tempusdominus/js/moment.min.js"></script>
    <script src="lib/tempusdominus/js/moment-timezone.min.js"></script>
    <script src="lib/tempusdominus/js/tempusdominus-bootstrap-4.min.js"></script>

    <!-- Template Javascript -->
    <script src="js/main.js"></script>
</body>

</html>