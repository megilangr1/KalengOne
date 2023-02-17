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

$editData = null;
if (isset($_GET['edit'])) {
  $checkData = $koneksi->query("SELECT * FROM albums WHERE id='". $_GET['edit'] ."' ");
  $editData = $checkData->fetch_object();
  if ($editData == null) {
    echo "<script>window.location='". $baseUrl ."album';</script>";
    exit();
  }

  if (isset($_POST['updateAlbum'])) {

    $ubahFile = false;
    if (isset($_FILES['file_album']) && $_FILES['file_album']['name'] != null) {
      $ubahFile = true;
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
      if ($ubahFile == true) {
        $namaBaru = $editData->file_album;
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
          $updateData = $koneksi->query("UPDATE albums SET
            nama_album='". $verifyData['nama_album'] ."',
            tanggal_rilis='". $verifyData['tanggal_rilis'] ."',
            studio='". $verifyData['studio'] ."',
            genre_album='". $verifyData['genre_album'] ."',
            file_album='". $namaBaru ."',
            lokasi_file='". $lokasiFile ."'
            WHERE id='". $editData->id ."'
          ");
      
          if (!$updateData) {
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
      } else {
        $updateData = $koneksi->query("UPDATE albums SET
          nama_album='". $verifyData['nama_album'] ."',
          tanggal_rilis='". $verifyData['tanggal_rilis'] ."',
          studio='". $verifyData['studio'] ."',
          genre_album='". $verifyData['genre_album'] ."'
          WHERE id='". $editData->id ."'
        ");
    
        if (!$updateData) {
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

    // var_dump($_POST);
  }
}

if (isset($_GET['delete'])) {
  $checkData = $koneksi->query("SELECT * FROM albums WHERE id='". $_GET['delete'] ."' ");
  $searchedData = $checkData->fetch_object();
  if ($searchedData == null) {
    echo "<script>window.location='". $baseUrl ."album';</script>";
    exit();
  } else {
    $deleteData = $koneksi->query("DELETE FROM albums WHERE id='". $_GET['delete'] ."' ");
    if (!$deleteData) {
      $_SESSION['flash_error'] = "Gagal Melakukan Penghapusan Data !"; 
      echo "<script>window.location='". $baseUrl ."album/index.php';</script>";
      exit();
    } else {
      if ($searchedData->lokasi_file != null) {
        if (file_exists('../'. $searchedData->lokasi_file)) {
          $removeFile = unlink('../'. $searchedData->lokasi_file);
          if (!$removeFile) {
            var_dump($removeFile);
            exit();
          }
        }
      }
      
      $_SESSION['flash_error'] = "Data Album di-Hapus !"; 
      echo "<script>window.location='". $baseUrl ."album/index.php';</script>";
      exit();
    }
  }
}

?>

<?php include_once('../layouts/head.php') ?>
<div class="col-12">
  <div class="row py-2">
    <div class="col-12">
      <div class="bg-secondary rounded p-4">
        <form <?php if ($editData != null) { ?> action="<?=$baseUrl?>album/index.php?edit=<?=$editData->id?>" <?php } else { ?> action="<?=$baseUrl?>album/index.php" <?php } ?> method="post" enctype="multipart/form-data">
          <?php if ($editData != null) { ?>
            <input type="hidden" name="id" value="<?=$editData->id?>" readonly>
          <?php } ?>

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
                    <input type="text" name="nama_album" id="nama_album" class="form-control" placeholder="Masukan Nama Album..." <?php if ($editData != null) { ?> value="<?=$editData->nama_album?>" <?php } ?> required autofocus>
                  </div>
                </div>
                <div class="col-md-4">
                  <div class="form-group mb-3">
                    <label for="tanggal_rilis" class="mb-2" style="font-weight: 600 !important;">Tanggal Rilis :</label>
                    <input type="date" name="tanggal_rilis" id="tanggal_rilis" class="form-control" placeholder="Masukan Tanggal Rilis..." <?php if ($editData != null) { ?> value="<?=date('Y-m-d', strtotime($editData->tanggal_rilis))?>" <?php } ?> required>
                  </div>
                </div>
                <div class="col-md-6">
                  <div class="form-group mb-3">
                    <label for="studio" class="mb-2" style="font-weight: 600 !important;">Studio Album :</label>
                    <textarea name="studio" id="studio" cols="1" rows="1" class="form-control" placeholder="Masukan Studio Album..." required><?php if ($editData != null) { echo $editData->nama_album; } ?></textarea>
                  </div>
                </div>
                <div class="col-md-6">
                  <div class="form-group mb-3">
                    <label for="studio" class="mb-2" style="font-weight: 600 !important;">Genre Album :</label>
                    <select class="form-select mb-3" name="genre_album" id="genre_album" aria-label="Silahkan Pilih Genre" required>
                      <option value="" selected disabled>-- Pilih Genre Musik --</option>
                      <option <?php if ($editData != null && $editData->genre_album == "Pop" ) { echo "selected"; } ?> value="Pop">Pop</option>
                      <option <?php if ($editData != null && $editData->genre_album == "Rock" ) { echo "selected"; } ?> value="Rock">Rock</option>
                      <option <?php if ($editData != null && $editData->genre_album == "Alternative" ) { echo "selected"; } ?> value="Alternative">Alternative</option>
                      <option <?php if ($editData != null && $editData->genre_album == "Blues" ) { echo "selected"; } ?> value="Blues">Blues</option>
                      <option <?php if ($editData != null && $editData->genre_album == "Dance" ) { echo "selected"; } ?> value="Dance">Dance</option>
                      <option <?php if ($editData != null && $editData->genre_album == "Hiphop/Rap" ) { echo "selected"; } ?> value="Hiphop/Rap">Hiphop/Rap</option>
                      <option <?php if ($editData != null && $editData->genre_album == "Jazz" ) { echo "selected"; } ?> value="Jazz">Jazz</option>
                      <option <?php if ($editData != null && $editData->genre_album == "RnB" ) { echo "selected"; } ?> value="RnB">RnB</option>
                      <option <?php if ($editData != null && $editData->genre_album == "Reggae" ) { echo "selected"; } ?> value="Reggae">Reggae</option>
                      <option <?php if ($editData != null && $editData->genre_album == "Heavy Metal" ) { echo "selected"; } ?> value="Heavy Metal">Heavy Metal</option>
                      <option <?php if ($editData != null && $editData->genre_album == "Ska" ) { echo "selected"; } ?> value="Ska">Ska</option>
                      <option <?php if ($editData != null && $editData->genre_album == "Punk" ) { echo "selected"; } ?> value="Punk">Punk</option>
                      <option <?php if ($editData != null && $editData->genre_album == "Dangdut" ) { echo "selected"; } ?> value="Dangdut">Dangdut</option>
                      <option <?php if ($editData != null && $editData->genre_album == "Instrumental" ) { echo "selected"; } ?> value="Instrumental">Instrumental</option>
                      <option <?php if ($editData != null && $editData->genre_album == "Acapella" ) { echo "selected"; } ?> value="Acapella">Acapella</option>
                      <option <?php if ($editData != null && $editData->genre_album == "Folk" ) { echo "selected"; } ?> value="Folk">Folk</option>
                      <option <?php if ($editData != null && $editData->genre_album == "Gospel" ) { echo "selected"; } ?> value="Gospel">Gospel</option>
                      <option <?php if ($editData != null && $editData->genre_album == "EDM" ) { echo "selected"; } ?> value="EDM">EDM</option>
                      <option <?php if ($editData != null && $editData->genre_album == "Koplo" ) { echo "selected"; } ?> value="Koplo">Koplo</option>
                      <option <?php if ($editData != null && $editData->genre_album == "New Wave" ) { echo "selected"; } ?> value="New Wave">New Wave</option>
                      <option <?php if ($editData != null && $editData->genre_album == "Ethnic" ) { echo "selected"; } ?> value="Ethnic">Ethnic</option>
                      <option <?php if ($editData != null && $editData->genre_album == "World Music" ) { echo "selected"; } ?> value="World Music">World Music</option>
                      <option <?php if ($editData != null && $editData->genre_album == "House Music" ) { echo "selected"; } ?> value="House Music">House Music</option>
                      <option <?php if ($editData != null && $editData->genre_album == "Religi" ) { echo "selected"; } ?> value="Religi">Religi</option>
                    </select>
                  </div>
                </div>
                <div class="col-md-8">
                  <div class="form-group mb-3">
                    <label for="file_album" class="mb-2" style="font-weight: 600 !important;">Upload Foto Album :</label>
                    <input type="file" name="file_album" id="file_album" class="form-control" accept="image/jpg, image/jpeg, image/png" <?php if ($editData == null) { echo 'required'; } ?>>
                    <?php if ($editData != null && $editData->lokasi_file != null) { ?>
                      <a href="<?=$baseUrl . $editData->lokasi_file?>" target="_blank">
                        Lihat Foto Saat Ini
                      </a>
                    <?php } ?>
                  </div>
                </div>
                <div class="col-md-4">
                  <div class="form-group mb-3">
                    <label for="bank_pengirim" class="mb-2" style="font-weight: 600 !important;">&ensp;</label>
                    <?php if ($editData != null) { ?>
                      <button type="submit" class="btn btn-success" style="width: 100% !important;" name="updateAlbum">
                        <span class="fa fa-edit"></span> &ensp; Simpan Perubahan Data
                      </button>
                    <?php } else { ?>
                      <button type="submit" class="btn btn-success" style="width: 100% !important;" name="buatAlbum">
                        <span class="fa fa-check"></span> &ensp; Buat Album
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
                            <a href="?edit=<?=$value['id']?>" class="btn btn-warning btn-sm">
                              <span class="fa fa-edit"></span> 
                            </a>
                            <a href="?delete=<?=$value['id']?>" class="btn btn-danger btn-sm">
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