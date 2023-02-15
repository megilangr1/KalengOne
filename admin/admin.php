<?php
require_once('../config/koneksi.php');
require_once('../config/helper.php');

$loginCheck = loginCheck($koneksi, $baseUrl);
if (isset($loginCheck['level']) && $loginCheck['level'] > 0) {
  header('location: '. $baseUrl . 'index.php');
}
?>

<?php include_once('layouts/head.php') ?>

<!-- Main Content -->
<div class="col-12">
  <div class="bg-secondary rounded p-4 my-1">
    <div class="row bg-secondary rounded">
      <div class="col-sm-12 col-md-2">
        <i class="fa fa-user fa-3x text-primary"></i>
      </div>
      <div class="col-12">
        <div class="row">
          <div class="col-md-4">
            <div class="ms-8">
              <p class="mb-2">Nama Depan : </p>
              <h6 class="mb-0"><?= $loginCheck['nama_depan'] ?? '-' ?></h6>
            </div>
          </div>
          <div class="col-md-4">
            <div class="ms-8">
              <p class="mb-2">Nama Belakang : </p>
              <h6 class="mb-0"><?= $loginCheck['nama_belakang'] ?? '-' ?></h6>
            </div>
          </div>
          <div class="col-md-4">
            <div class="ms-8">
              <p class="mb-2">E-Mail : </p>
              <h6 class="mb-0"><?= $loginCheck['email'] ?? '-' ?></h6>
            </div>
          </div>
          <div class="col-12 pt-4">
            <button type="button" class="btn btn-sm btn-success" style="width:100% !important;">
              <marquee behavior="" direction="right">
                Status Akun :
                <?php
                  $stat = $loginCheck['level'];
                  switch ($stat) {
                    case 0:
                      echo 'Administrator';
                      break;
                    case 1:
                      echo 'Akun Gratis';
                      break;
                    case 2:
                      echo 'Akun Berbayar';
                      break;
                    default:
                      echo "-";
                      break;
                  }
                ?>
              </marquee>
            </button>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

<div class="col-sm-12 col-xl-6">
  <div class="bg-secondary rounded d-flex align-items-center justify-content-between p-4 my-1">
    <i class="fa fa-music fa-3x text-primary"></i>
    <div class="ms-8">
      <p class="mb-2">Total Single</p>
      <h6 class="mb-0">0</h6>
    </div>
  </div>
</div>
<div class="col-sm-12 col-xl-6">
  <div class="bg-secondary rounded d-flex align-items-center justify-content-between p-4 my-1">
    <i class="fa fa-headphones fa-3x text-primary"></i>
    <div class="ms-8">
      <p class="mb-2">Total Album</p>
      <h6 class="mb-0">0</h6>
    </div>
  </div>
</div>
<!-- End Main Content -->

<?php include_once('layouts/foot.php') ?>