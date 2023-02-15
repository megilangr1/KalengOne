<?php
require_once('../config/koneksi.php');
require_once('../config/helper.php');

$loginCheck = loginCheck($koneksi, $baseUrl);
if (isset($loginCheck['level']) && $loginCheck['level'] < 1) {
  header('location: ' . $baseUrl . 'admin/admin.php');
}

$dataAlbum = $koneksi->query("SELECT * FROM albums WHERE user_id='".$_SESSION['user']['id']."' ");
$jumlahAlbum = count($dataAlbum->fetch_all());

$errorMessage = [];
$successMessage = null;
if (isset($_POST['buatAlbum'])) {

  // File Var
  $namaFile = $_FILES['file_album']['name'];
  $ukuranFile  = $_FILES['file_album']['size'];
  $tmpFile = $_FILES['file_album']['tmp_name'];

  // Validasi File
  $allowedExt  = array('png', 'jpg', 'jpeg');
  $x = explode('.', $namaFile);
  $extFile = strtolower(end($x));

  if (in_array($extFile, $allowedExt) === false) {
    $errorMessage[] = [
      'name' => 'file_album',
      'alias' => 'Foto Album',
      'success' => false,
      'error_msg' => 'Jenis File Harus Berupa .jpg / .jpeg / .png',
    ];
  }

  if ($ukuranFile > 1044070) {
    $errorMessage[] = [
      'name' => 'file_album',
      'alias' => 'Foto Album',
      'success' => false,
      'error_msg' => 'Ukuran File Terlalu Besar !',
    ];
  }

  $verifyData = [
    'nama_album' => htmlspecialchars(trim($_POST['nama_album'])),
    'tanggal_rilis' => htmlspecialchars(trim($_POST['tanggal_rilis'])),
    'studio' => htmlspecialchars(trim($_POST['studio'])),
    'genre_album' => htmlspecialchars(trim($_POST['genre_album'])),
  ];

  $validateArray = [
    [
      'name' => 'nama_album',
      'alias' => 'Nama Album',
      'success' => false,
      'error_msg' => null,
    ],
    [
      'name' => 'tanggal_rilis',
      'alias' => 'Tanggal Rilis',
      'success' => false,
      'error_msg' => null,
    ],
    [
      'name' => 'studio',
      'alias' => 'Studio',
      'success' => false,
      'error_msg' => null,
    ],
    [
      'name' => 'genre_album',
      'alias' => 'Genre Album',
      'success' => false,
      'error_msg' => null,
    ],
  ];

  $validate = validateArray($verifyData, $validateArray);
  if ($validate['code'] == false) {
    $errorMessage = array_merge($errorMessage, $validate['res']);
  }

  if ($errorMessage == null) {
    $namaBaru = str_replace(' ', '-', preg_replace('/[^a-zA-Z0-9\']/', '', strtolower($verifyData['nama_album']))) . '-' . rand(1000, 9999);
    $lokasiFile = 'album_foto/' . $namaBaru . '.' . $extFile;
    $uploadFile = move_uploaded_file($tmpFile, '../album_foto/' . $namaBaru . '.' . $extFile);
    if (!$uploadFile) {
      $errorMessage[] = [
        'name' => 'file_album',
        'alias' => 'Foto Album',
        'success' => false,
        'error_msg' => 'Gagal di-Upload Silahkan Coba Lagi Dalam Beberapa Saat !',
      ];
    } else {
      $createData = $koneksi->query("INSERT INTO albums VALUES (
        NULL, 
        '". $verifyData['nama_album'] ."',
        '". $verifyData['tanggal_rilis'] ."',
        '". $verifyData['studio'] ."',
        '". $verifyData['genre_album'] ."',
        '". $namaBaru ."',
        '". $lokasiFile ."',
        '". $_SESSION['user']['id'] ."',
        null,
        null
      )");
  
      if (!$createData) {
        $errorMessage[] = [
          'name' => 'insert',
          'alias' => 'Terjadi Kesalahan !',
          'success' => false,
          'error_msg' => 'Gagal Menyimpan Data Album !',
        ]; 
      } else {
        $_SESSION['flash_success'] = "Data Album di-Tambahkan !"; 
        echo "<script>window.location='". $baseUrl ."album/index.php';</script>";
        exit();
      }
    }
  }
}
?>

<?php include_once('../layouts/head.php') ?>
<div class="col-12">
  <div class="row py-2">
    <div class="col-12">
      <div class="bg-secondary rounded p-4">
        <form action="<?=$baseUrl?>album/index.php" method="post" enctype="multipart/form-data">
          <div class="row">
            <div class="col-12">
              <h6 class="mb-2 text-center">
                <span class="fa fa-circle"></span> &ensp;
                <span class="fa fa-headphones"></span> &ensp; Data Album
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
                <div class="col-md-8">
                  <div class="form-group mb-3">
                    <label for="nama_album" class="mb-2" style="font-weight: 600 !important;">Nama Album :</label>
                    <input type="text" name="nama_album" id="nama_album" class="form-control" placeholder="Masukan Nama Album..." required autofocus>
                  </div>
                </div>
                <div class="col-md-4">
                  <div class="form-group mb-3">
                    <label for="tanggal_rilis" class="mb-2" style="font-weight: 600 !important;">Tanggal Rilis :</label>
                    <input type="date" name="tanggal_rilis" id="tanggal_rilis" class="form-control" placeholder="Masukan Tanggal Rilis..." required>
                  </div>
                </div>
                <div class="col-md-6">
                  <div class="form-group mb-3">
                    <label for="studio" class="mb-2" style="font-weight: 600 !important;">Studio Album :</label>
                    <textarea name="studio" id="studio" cols="1" rows="1" class="form-control" placeholder="Masukan Studio Album..." required></textarea>
                  </div>
                </div>
                <div class="col-md-6">
                  <div class="form-group mb-3">
                    <label for="studio" class="mb-2" style="font-weight: 600 !important;">Genre Album :</label>
                    <select class="form-select mb-3" name="genre_album" id="genre_album" aria-label="Silahkan Pilih Genre" required>
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
                  </div>
                </div>
                <div class="col-md-8">
                  <div class="form-group mb-3">
                    <label for="file_album" class="mb-2" style="font-weight: 600 !important;">Upload Foto Album :</label>
                    <input type="file" name="file_album" id="file_album" class="form-control" accept="image/jpg, image/jpeg, image/png" required>
                  </div>
                </div>
                <div class="col-md-4">
                  <div class="form-group mb-3">
                    <label for="bank_pengirim" class="mb-2" style="font-weight: 600 !important;">&ensp;</label>
                    <button type="submit" class="btn btn-success" style="width: 100% !important;" name="buatAlbum">
                      <span class="fa fa-check"></span> &ensp; Buat Album
                    </button>
                  </div>
                </div>
              </div>
            </div>
            <div class="col-12">
              <hr>
            </div>
            <div class="col-12">
              <table class="table table-bordered">
                <thead>
                  <th>#</th>
                  <th>Nama Album</th>
                  <th>Tanggal Rilis</th>
                  <th>Studio</th>
                  <th>Genre</th>
                  <th>Foto Album</th>
                  <th>Aksi</th>
                </thead>
                <tbody>
                  <?php if ($jumlahAlbum > 0) { ?>
                    <?php $no = 1;?>
                    <?php foreach ($dataAlbum as $key => $value) { ?>
                      <tr>
                        <td class="text-center align-middle" style="font-size: 12px !important;"><?=$no++?></td>
                        <td class="text-center align-middle" style="font-size: 12px !important;"><?=$value['nama_album']?></td>
                        <td class="text-center align-middle" style="font-size: 12px !important;"><?=$value['tanggal_rilis']?></td>
                        <td class="text-center align-middle" style="font-size: 12px !important;"><?=$value['studio']?></td>
                        <td class="text-center align-middle" style="font-size: 12px !important;"><?=$value['genre_album']?></td> 
                        <td class="text-center align-middle" style="font-size: 12px !important;">
                          <?php if ($value['lokasi_file'] != null) { ?>
                            <a href="<?=$baseUrl . $value['lokasi_file']?>" target="_blank">
                              Lihat Foto
                            </a>
                          <?php } else { echo "-"; } ?>
                        </td>
                        <td class="text-center align-middle" style="font-size: 12px !important;">
                          <div class="btn-group">
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
                      <td class="text-center align-middle" colspan="7">Belum Ada Data</td>
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

<?php include_once('../layouts/foot.php') ?>