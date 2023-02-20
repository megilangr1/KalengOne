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


$errorMessage = [];
$successMessage = null;
if (isset($_POST['buatUser'])) {

  $verifyData = [
    'nama_depan' => htmlspecialchars(trim($_POST['nama_depan'])),
    'nama_belakang' => htmlspecialchars(trim($_POST['nama_belakang'])),
    'email' => htmlspecialchars(trim($_POST['email'])),
    'password' => htmlspecialchars(trim($_POST['password'])),
    'level' => htmlspecialchars(trim($_POST['level'])),
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
      'alias' => 'E-Mail',
      'success' => false,
      'error_msg' => null,
    ],
    [
      'name' => 'password',
      'alias' => 'Password',
      'success' => false,
      'error_msg' => null,
    ],
    [
      'name' => 'level',
      'alias' => 'Level',
      'success' => false,
      'error_msg' => null,
    ],
  ];

  $validate = validateArray($verifyData, $validateArray);
  if ($validate['code'] == false) {
    $errorMessage = array_merge($errorMessage, $validate['res']);
  }

  if ($errorMessage == null) {
    $validateUnique = $koneksi->query("SELECT * FROM users WHERE email='". $verifyData['email'] ."' ");
    $valid = $validateUnique->fetch_object();
    if ($valid != null) {
      $errorMessage[] = [
        'name' => 'unique',
        'alias' => 'E-Mail',
        'success' => false,
        'error_msg' => 'Sudah di-Gunakan !',
      ]; 
    } else {
      $createData = $koneksi->query("INSERT INTO users (nama_depan, nama_belakang, email, username, password, level, status_verifikasi) VALUES (
        '". $verifyData['nama_depan'] ."',
        '". $verifyData['nama_belakang'] ."',
        '". $verifyData['email'] ."',
        '" .rand(1000000, 9999999) ."',
        '". $verifyData['password'] ."',
        '". $verifyData['level'] ."',
        1
      )");
  
      if (!$createData) {
        $errorMessage[] = [
          'name' => 'insert',
          'alias' => 'Terjadi Kesalahan !',
          'success' => false,
          'error_msg' => 'Gagal Menyimpan Data User !',
        ]; 
      } else {
        $_SESSION['flash_success'] = "Data User di-Tambahkan !"; 
        echo "<script>window.location='". $baseUrl ."admin/user.php';</script>";
        exit();
      }
    }
  }


}

$editData = null;
if (isset($_GET['edit'])) {
  $checkData = $koneksi->query("SELECT * FROM users WHERE id='". $_GET['edit'] ."' ");
  $editData = $checkData->fetch_object();
  if ($editData == null) {
    echo "<script>window.location='". $baseUrl ."album';</script>";
    exit();
  }

  if (isset($_POST['updateUser'])) {
    $verifyData = [
      'nama_depan' => htmlspecialchars(trim($_POST['nama_depan'])),
      'nama_belakang' => htmlspecialchars(trim($_POST['nama_belakang'])),
      'email' => htmlspecialchars(trim($_POST['email'])),
      'password' => htmlspecialchars(trim($_POST['password'])),
      'level' => htmlspecialchars(trim($_POST['level'])),
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
        'alias' => 'E-Mail',
        'success' => false,
        'error_msg' => null,
      ],
      [
        'name' => 'password',
        'alias' => 'Password',
        'success' => false,
        'error_msg' => null,
      ],
      [
        'name' => 'level',
        'alias' => 'Level',
        'success' => false,
        'error_msg' => null,
      ],
    ];

    $validate = validateArray($verifyData, $validateArray);
    if ($validate['code'] == false) {
      $errorMessage = array_merge($errorMessage, $validate['res']);
    }

    if ($errorMessage == null) {
      $createData = $koneksi->query("UPDATE users SET
        nama_depan='". $verifyData['nama_depan'] ."',
        nama_belakang='". $verifyData['nama_belakang'] ."',
        email='". $verifyData['email'] ."',
        password='". $verifyData['password'] ."',
        level='". $verifyData['level'] ."'
        WHERE id='". $editData->id ."'
      ");

      if (!$createData) {
        $errorMessage[] = [
          'name' => 'insert',
          'alias' => 'Terjadi Kesalahan !',
          'success' => false,
          'error_msg' => 'Gagal Menyimpan Data User !',
        ]; 
      } else {
        $_SESSION['flash_success'] = "Data User di-Ubah !"; 
        echo "<script>window.location='". $baseUrl ."admin/user.php';</script>";
        exit();
      }
    }
  }
}

if (isset($_GET['delete'])) {
  $checkData = $koneksi->query("SELECT * FROM users WHERE id='". $_GET['delete'] ."' ");
  $searchedData = $checkData->fetch_object();
  if ($searchedData == null) {
    echo "<script>window.location='". $baseUrl ."admin/user.php';</script>";
    exit();
  } else {
    $deleteData = $koneksi->query("DELETE FROM users WHERE id='". $_GET['delete'] ."' ");
    if (!$deleteData) {
      $_SESSION['flash_error'] = "Gagal Melakukan Penghapusan Data !"; 
      echo "<script>window.location='". $baseUrl ."admin/user.php';</script>";
      exit();
    } else {
      if ($searchedData->lokasi_file != null) {
        if (file_exists('../'. $searchedData->lokasi_file)) {
          $removeFile = unlink('../'. $searchedData->lokasi_file);
        }
      }
      
      $_SESSION['flash_error'] = "Data User di-Hapus !"; 
      echo "<script>window.location='". $baseUrl ."admin/user.php';</script>";
      exit();
    }
  }
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

<div class="col-12">
  <div class="row py-2">
    <div class="col-12">
      <div class="bg-secondary rounded p-4">
        <form <?php if ($editData != null) { ?> action="<?=$baseUrl?>admin/user.php?edit=<?=$editData->id?>" <?php } else { ?> action="<?=$baseUrl?>admin/user.php" <?php } ?> method="post" enctype="multipart/form-data">
          <?php if ($editData != null) { ?>
            <input type="hidden" name="id" value="<?=$editData->id?>" readonly>
          <?php } ?>

          <div class="row">
            <div class="col-12">
              <h6 class="mb-2 text-center">
                <span class="fa fa-circle"></span> &ensp;
                <span class="fa fa-users"></span> &ensp; Data User
                &ensp; <span class="fa fa-circle"></span>
              </h6>
              <hr>
              <?php if ($errorMessage != null) { ?>
                <div class="form-floating mb-4">
                  <div class="alert alert-danger px-1 py-3" role="alert" style="font-size: 12px !important;">
                    <ul class="mb-0">
                      <?php
                      foreach ($errorMessage as $key => $value) {
                        if ($value['success'] == false) {
                          echo "<li>" . $value['alias'] . ' - ' . $value['error_msg'] . "</li>";
                        }
                      }
                      ?>
                    </ul>
                  </div>
                </div>
              <?php } ?>

              <?php if ($successMessage != null) { ?>
                <div class="form-floating mb-4">
                  <div class="alert alert-success px-1 py-3 text-center" role="alert" style="font-size: 15px !important;">
                    <?= $successMessage ?>
                  </div>
                </div>
              <?php } ?>
            </div>

            <div class="col-12">
              <div class="row">
                <div class="col-md-6">
                  <div class="form-group mb-3">
                    <label for="nama_depan" class="mb-2" style="font-weight: 600 !important;">Nama Depan :</label>
                    <input type="text" name="nama_depan" id="nama_depan" class="form-control" placeholder="Masukan Nama Depan..." <?php if ($editData != null) { ?> value="<?=$editData->nama_depan?>" <?php } ?> required autofocus>
                  </div>
                </div>
                <div class="col-md-6">
                  <div class="form-group mb-3">
                    <label for="nama_belakang" class="mb-2" style="font-weight: 600 !important;">Nama Belakang :</label>
                    <input type="text" name="nama_belakang" id="nama_belakang" class="form-control" placeholder="Masukan Nama Belakang..." <?php if ($editData != null) { ?> value="<?=$editData->nama_belakang?>" <?php } ?> required>
                  </div>
                </div>
                <div class="col-md-6">
                  <div class="form-group mb-3">
                    <label for="email" class="mb-2" style="font-weight: 600 !important;">E-Mail User :</label>
                    <input type="email" name="email" id="email" class="form-control" placeholder="Masukan Email..." <?php if ($editData != null) { ?> value="<?=$editData->email?>" <?php } ?> required>
                  </div>
                </div>
                <div class="col-md-6">
                  <div class="form-group mb-3">
                    <label for="password" class="mb-2" style="font-weight: 600 !important;">Password :</label>
                    <input type="password" name="password" id="password" class="form-control" placeholder="Masukan Password..." <?php if ($editData != null) { ?> value="<?=$editData->password?>" <?php } ?> required>
                  </div>
                </div>
                
                <div class="col-md-6">
                  <div class="form-group mb-3">
                    <label for="level" class="mb-2" style="font-weight: 600 !important;">Level User :</label>
                    <select class="form-select mb-3" name="level" id="level" aria-label="Silahkan Pilih Level" required>
                      <option value="" selected disabled>-- Pilih Level --</option>
                      <option <?php if ($editData != null && $editData->level == 0 ) { echo "selected"; } ?> value="0">Administrator</option>
                      <option <?php if ($editData != null && $editData->level == 1 ) { echo "selected"; } ?> value="1">Akun Gratis</option>
                      <option <?php if ($editData != null && $editData->level == 2 ) { echo "selected"; } ?> value="2">Akun Berbayar</option>
                    </select>
                  </div>
                </div>
                <div class="col-md-6">
                  <div class="form-group mb-3">
                    <label for="bank_pengirim" class="mb-2" style="font-weight: 600 !important;">&ensp;</label>
                    <?php if ($editData != null) { ?>
                      <button type="submit" class="btn btn-success" style="width: 100% !important;" name="updateUser">
                        <span class="fa fa-edit"></span> &ensp; Simpan Perubahan Data
                      </button>
                    <?php } else { ?>
                      <button type="submit" class="btn btn-success" style="width: 100% !important;" name="buatUser">
                        <span class="fa fa-check"></span> &ensp; Buat Data User
                      </button>
                    <?php } ?>
                  </div>
                </div>
              </div>
            </div>
            <div class="col-12">
              <hr>
            </div>
            <div class="col-12">
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
                          <?php if ($loginCheck['id'] != $value['id']) { ?> 
                            <div class="btn-group">
                              <?php if (!$value['status_verifikasi']) { ?> 
                                <form action="<?=$baseUrl?>admin/confirm_user.php" method="post">
                                  <input type="hidden" name="email" value="<?=$value['email']?>" readonly>
                                  <button type="submit" class="btn btn-success btn-sm" name="confirm_user">
                                    <span class="fa fa-check"></span> 
                                  </button>
                                </form>
                              <?php } ?>
                              <a href="?edit=<?=$value['id']?>" class="btn btn-warning btn-sm">
                                <span class="fa fa-edit"></span> 
                              </a>
                              <a href="?delete=<?=$value['id']?>" class="btn btn-danger btn-sm">
                                <span class="fa fa-trash"></span>
                              </a>
                            </div>
                          <?php } else { echo "-"; } ?>
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
        </form>
      </div>
    </div>
  </div>
</div>

<!-- End Main Content -->
<?php include_once('layouts/foot.php') ?>