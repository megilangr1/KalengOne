<?php
require_once('../config/koneksi.php');
require_once('../config/helper.php');

$loginCheck = loginCheck($koneksi, $baseUrl);
if (isset($loginCheck['level']) && $loginCheck['level'] > 0) {
  header('location: '. $baseUrl . 'index.php');
}


// State
$dataUser = $koneksi->query("SELECT * FROM users");
$jumlahUser = count($dataUser->fetch_all());
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

<div class="col-12" style="padding: 12px !important;">
  <div class="card card-secondary">
    <div class="card-header">
      <h6 class="card-title text-dark">
        <span class="fa fa-users"></span> &ensp; Daftar User
        <div style="float: right;">
          <a href="#" class="btn btn-sm btn-success px-3">
            <span class="fa fa-plus"></span> &ensp; Tambah Data
          </a>
        </div>
      </h6>
    </div>
    <div class="card-body p-0">
      <table class="table table-bordered table-hover">
        <thead>
          <tr>
            <th class="text-center align-middle" style="font-size: 14px !important;">No.</th>
            <th class="text-center align-middle" style="font-size: 14px !important;">Nama Depan</th>
            <th class="text-center align-middle" style="font-size: 14px !important;">Nama Belakang</th>
            <th class="text-center align-middle" style="font-size: 14px !important;">Email</th>
            <th class="text-center align-middle" style="font-size: 14px !important;">Status</th>
            <th class="text-center align-middle" style="font-size: 14px !important;">Bukti Pembayaran</th>
            <th class="text-center align-middle" style="font-size: 14px !important;">#</th>
          </tr>
        </thead>
        <tbody>
          <?php if ($jumlahUser > 0) { ?>
            <?php $no = 1;?>
            <?php foreach ($dataUser as $key => $value) { ?>
              <tr>
                <td class="text-center align-middle" style="font-size: 12px !important;"><?=$no++?></td>
                <td class="text-center align-middle" style="font-size: 12px !important;"><?=$value['nama_depan']?></td>
                <td class="text-center align-middle" style="font-size: 12px !important;"><?=$value['nama_belakang']?></td>
                <td class="text-center align-middle" style="font-size: 12px !important;"><?=$value['email']?></td>
                <td class="text-center align-middle" style="font-size: 12px !important;">
                  <?php
                    $level = $value['level'];
                    switch ($level) {
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
                </td>
                <td class="text-center align-middle" style="font-size: 12px !important;">
                  <?php if ($value['lokasi_file'] != null) { ?>
                    <a href="<?=$baseUrl . $value['lokasi_file']?>" target="_blank">
                      <?=$value['nama_rekening_pengirim']?> - <?=$value['nama_rekening_pengirim']?>
                    </a>
                  <?php } else { echo "-"; } ?>
                </td>
                <td class="text-center align-middle" style="font-size: 12px !important;">
                  <div class="btn-group">
                    <?php if (!$value['status_verifikasi']) { ?> 
                      <form action="<?=$baseUrl?>admin/confirm_user.php" method="post">
                        <input type="hidden" name="email" value="<?=$value['email']?>" readonly>
                        <button type="submit" class="btn btn-success btn-sm" name="confirm_user">
                          <span class="fa fa-check"></span> 
                        </button>
                      </form>
                    <?php } ?>
                    <a href="#" class="btn btn-warning btn-sm">
                      <span class="fa fa-edit"></span> 
                    </a>
                    <a href="#" class="btn btn-danger btn-sm">
                      <span class="fa fa-trash"></span>
                    </a>
                  </div>
                </td>
              </tr>
            <?php } ?>
          <?php } else { ?>
            <tr>
              <td class="text-center align-middle" colspan="6">Belum Ada Data</td>
            </tr>
          <?php } ?>
        </tbody>
      </table>
    </div>
  </div>
</div>
<!-- End Main Content -->
<?php include_once('layouts/foot.php') ?>