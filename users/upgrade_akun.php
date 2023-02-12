<?php
require_once('../config/koneksi.php');
require_once('../config/helper.php');

$loginCheck = loginCheck();
if (isset($loginCheck['level']) && $loginCheck['level'] < 1) {
  header('location: ' . $baseUrl . 'admin/admin.php');
}


$errorMessage = [];
$successMessage = null;
if (isset($_POST['uploadData'])) {

  // File Var
  $namaFile = $_FILES['file_bukti']['name'];
  $namaBaru = $loginCheck['username'] . '-' . rand(100, 999);

  $ukuranFile  = $_FILES['file_bukti']['size'];
  $tmpFile = $_FILES['file_bukti']['tmp_name'];

  // Validasi File
  $allowedExt  = array('png', 'jpg', 'jpeg');
  $x = explode('.', $namaFile);
  $extFile = strtolower(end($x));

  if (in_array($extFile, $allowedExt) === false) {
    $errorMessage[] = [
      'name' => 'file_bukti',
      'alias' => 'File Foto Bukti Pembayaran',
      'success' => false,
      'error_msg' => 'Jenis File Harus Berupa .jpg / .jpeg / .png',
    ];
  }

  if ($ukuranFile > 1044070) {
    $errorMessage[] = [
      'name' => 'file_bukti',
      'alias' => 'File Foto Bukti Pembayaran',
      'success' => false,
      'error_msg' => 'Ukuran File Terlalu Besar !',
    ];
  }

  $verifyData = [
    'nama_pengirim' => htmlspecialchars(trim($_POST['nama_pengirim'])),
    'bank_pengirim' => htmlspecialchars(trim($_POST['bank_pengirim'])),
  ];

  $validateArray = [
    [
      'name' => 'nama_pengirim',
      'alias' => 'Nama Pemilik Rekening',
      'success' => false,
      'error_msg' => null,
    ],
    [
      'name' => 'bank_pengirim',
      'alias' => 'Nama Bank Rekening',
      'success' => false,
      'error_msg' => null,
    ]
  ];

  $validate = validateArray($verifyData, $validateArray);
  if ($validate['code'] == false) {
    $errorMessage = array_merge($errorMessage, $validate['res']);
  }

  if ($errorMessage == null) {
    $uploadFile = move_uploaded_file($tmpFile, '../upload/' . $namaBaru . '.' . $extFile);
    if (!$uploadFile) {
      $errorMessage[] = [
        'name' => 'file_bukti',
        'alias' => 'File Foto Bukti Pembayaran',
        'success' => false,
        'error_msg' => 'Gagal di-Upload Silahkan Coba Lagi Dalam Beberapa Saat !',
      ];
    } else {
      $lokasiFile = 'upload/' . $namaBaru . '.' . $extFile;
      $updateData = $koneksi->query("UPDATE users SET nama_rekening_pengirim='". $verifyData['nama_pengirim'] ."', nama_bank_pengirim='". $verifyData['bank_pengirim'] ."', nama_file='". $namaBaru ."', lokasi_file='". $lokasiFile ."' WHERE id='". $loginCheck['id'] ."' ");
      if (!$updateDatas) {
        $errorMessage[] = [
          'name' => 'insert',
          'alias' => 'Terjadi Kesalahan !',
          'success' => false,
          'error_msg' => 'Gagal Melakukan Upload Bukti Bayar <br> Silahkan Coba Lagi Dalam Beberapa Saat !',
        ];
      } else {
        $successMessage = 'Upload Bukti Berhasil, Silahkan Tunggu Beberapa Saat Hingga IMR Memverifikasi Bukti Pembayaran Anda !';
      }
    }
  }
}
?>

<?php include_once('../layouts/head.php') ?>
<!-- Main Content -->
<div class="col-12">
  <div class="bg-secondary rounded p-4 my-1">
    <div class="row bg-secondary rounded">
      <div class="col-sm-12 col-md-2">
        <i class="fa fa-user fa-3x text-primary"></i>
      </div>
      <div class="col-sm-12 col-md-10">
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
        <form action="upgrade_akun.php" method="post" enctype="multipart/form-data">
          <div class="row">
            <div class="col-12">
              <h6 class="mb-2 text-center">
                <span class="fa fa-circle"></span> &ensp;
                Silahkan Upload Bukti Pembayaran / Bukti Transfer
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
            <div class="col-md-6">
              <div class="form-group mb-3">
                <label for="nama_pengirim" class="mb-2" style="font-weight: 600 !important;">Nama Pemilik Rekening :</label>
                <input type="text" name="nama_pengirim" id="nama_pengirim" class="form-control" placeholder="Masukan Nama Pemilik Rekening..." required autofocus>
              </div>
            </div>
            <div class="col-md-6">
              <div class="form-group mb-3">
                <label for="bank_pengirim" class="mb-2" style="font-weight: 600 !important;">Nama Bank Rekening :</label>
                <input type="text" name="bank_pengirim" id="bank_pengirim" class="form-control" placeholder="Masukan Nama Bank Rekening..." required>
              </div>
            </div>
            <div class="col-md-8">
              <div class="form-group mb-3">
                <label for="file_bukti" class="mb-2" style="font-weight: 600 !important;">Upload Foto Bukti Pembayaran :</label>
                <input type="file" name="file_bukti" id="file_bukti" class="form-control" accept="image/jpg, image/jpeg, image/png" required>
              </div>
            </div>
            <div class="col-md-4">
              <div class="form-group mb-3">
                <label for="bank_pengirim" class="mb-2" style="font-weight: 600 !important;">&ensp;</label>
                <button type="submit" class="btn btn-success" style="width: 100% !important;" name="uploadData">
                  <span class="fa fa-check"></span> &ensp; Upload Data
                </button>
              </div>
            </div>
          </div>
        </form>
      </div>
    </div>
  </div>
  <!-- <div class="bg-secondary rounded d-flex align-items-center justify-content-between p-4 my-1">
    <i class="fa fa-music fa-3x text-primary"></i>
    <div class="ms-8">
      <p class="mb-2">Total Single</p>
      <h6 class="mb-0">0</h6>
    </div>
  </div> -->
</div>
<!-- End Main Content -->

<?php include_once('../layouts/foot.php') ?>