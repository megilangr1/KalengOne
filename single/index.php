<?php
require_once('../config/koneksi.php');
require_once('../config/helper.php');

$loginCheck = loginCheck($koneksi, $baseUrl);
if (isset($loginCheck['level']) && $loginCheck['level'] < 1) {
  header('location: ' . $baseUrl . 'admin/admin.php');
}

$dataSingle = $koneksi->query("SELECT singles.*, albums.nama_album FROM singles INNER JOIN albums ON albums.id=singles.id_album WHERE singles.user_id='".$_SESSION['user']['id']."' ");
$jumlahSingle = count($dataSingle->fetch_all());

$dataAlbum = $koneksi->query("SELECT * FROM albums WHERE user_id='".$_SESSION['user']['id']."' ");
$jumlahAlbum = count($dataAlbum->fetch_all());

$errorMessage = [];
$successMessage = null;
if (isset($_POST['buatSingle'])) {
  // File Var Cover
  $namaFileCover = $_FILES['cover_single']['name'];
  $ukuranFileCover  = $_FILES['cover_single']['size'];
  $tmpFileCover = $_FILES['cover_single']['tmp_name'];

  // Validasi File Cover
  $allowedExtCover  = array('png', 'jpg', 'jpeg');
  $xCover = explode('.', $namaFileCover);
  $extFileCover = strtolower(end($xCover));

  if (in_array($extFileCover, $allowedExtCover) === false) {
    $errorMessage[] = [
      'name' => 'cover_single',
      'alias' => 'Foto Cover Single',
      'success' => false,
      'error_msg' => 'Jenis File Harus Berupa .jpg / .jpeg / .png',
    ];
  }

  if ($ukuranFileCover > 1044070) {
    $errorMessage[] = [
      'name' => 'cover_single',
      'alias' => 'Foto Cover Single',
      'success' => false,
      'error_msg' => 'Ukuran File Terlalu Besar !',
    ];
  }

  // File Var Single
  $namaFileSingle = $_FILES['file_single']['name'];
  $ukuranFileSingle  = $_FILES['file_single']['size'];
  $tmpFileSingle = $_FILES['file_single']['tmp_name'];

  // Validasi File Single
  $allowedExtSingle  = array('mp3', 'wav');
  $xSingle = explode('.', $namaFileSingle);
  $extFileSingle = strtolower(end($xSingle));

  if (in_array($extFileSingle, $allowedExtSingle) === false) {
    $errorMessage[] = [
      'name' => 'file_single',
      'alias' => 'File Single',
      'success' => false,
      'error_msg' => 'Jenis File Harus Berupa .mp3 / .wav',
    ];
  }

  if ($ukuranFileSingle > 10440700) {
    $errorMessage[] = [
      'name' => 'file_single',
      'alias' => 'File Single',
      'success' => false,
      'error_msg' => 'Ukuran File Terlalu Besar !',
    ];
  }

  $verifyData = [
    'nama_single' => htmlspecialchars(trim($_POST['nama_single'])),
    'tanggal_rilis' => htmlspecialchars(trim($_POST['tanggal_rilis'])),
    'id_album' => htmlspecialchars(trim($_POST['id_album'])),
    'genre_single' => htmlspecialchars(trim($_POST['genre_single'])),
  ];

  $validateArray = [
    [
      'name' => 'nama_single',
      'alias' => 'Nama Single',
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
      'name' => 'id_album',
      'alias' => 'Album',
      'success' => false,
      'error_msg' => null,
    ],
    [
      'name' => 'genre_single',
      'alias' => 'Genre Single',
      'success' => false,
      'error_msg' => null,
    ],
  ];

  $validate = validateArray($verifyData, $validateArray);
  if ($validate['code'] == false) {
    $errorMessage = array_merge($errorMessage, $validate['res']);
  }

  if ($errorMessage == null) {
    $namaBaru = str_replace(' ', '-', preg_replace('/[^a-zA-Z0-9\']/', '', strtolower($verifyData['nama_single']))) . '-' . rand(1000, 9999);
    $lokasiFileCover = 'single_cover/' . $namaBaru . '.' . $extFileCover;
    $uploadFileCover = move_uploaded_file($tmpFileCover, '../single_cover/' . $namaBaru . '.' . $extFileCover);

    $lokasiFileSingle = 'single_file/' . $namaBaru . '.' . $extFileSingle;
    $uploadFileSingle = move_uploaded_file($tmpFileSingle, '../single_file/' . $namaBaru . '.' . $extFileSingle);

    if (!$uploadFileCover || !$uploadFileSingle) {
      $errorMessage[] = [
        'name' => 'file_single',
        'alias' => 'Cover Single / File Single',
        'success' => false,
        'error_msg' => 'Gagal di-Upload Silahkan Coba Lagi Dalam Beberapa Saat !',
      ];
    } else {
      $createData = $koneksi->query("INSERT INTO singles VALUES (
        NULL, 
        '". $verifyData['id_album'] ."',
        '". $verifyData['nama_single'] ."',
        '". $verifyData['tanggal_rilis'] ."',
        '". $verifyData['genre_single'] ."',
        '". $namaBaru ."',
        '". $lokasiFileCover ."',
        '". $namaBaru ."',
        '". $lokasiFileSingle ."',
        '". $_SESSION['user']['id'] ."',
        null,
        null
      )");

      if (!$createData) {
        $errorMessage[] = [
          'name' => 'insert',
          'alias' => 'Terjadi Kesalahan !',
          'success' => false,
          'error_msg' => 'Gagal Menyimpan Data Single !',
        ]; 
      } else {
        $_SESSION['flash_success'] = "Data Single di-Tambahkan !"; 
        echo "<script>window.location='". $baseUrl ."single/index.php';</script>";
        exit();
      }
    }
  }
}

$editData = null;
if (isset($_GET['edit'])) {
  $checkData = $koneksi->query("SELECT * FROM singles WHERE id='". $_GET['edit'] ."' ");
  $editData = $checkData->fetch_object();
  if ($editData == null) {
    echo "<script>window.location='". $baseUrl ."single';</script>";
    exit();
  }

  if (isset($_POST['updateAlbum'])) {
    $ubahFileCover = false;
    $ubahFileSingle = false;
    if (isset($_FILES['cover_single']) && $_FILES['cover_single']['name'] != null) {
      $ubahFileCover = true;

      // File Var Cover
      $namaFileCover = $_FILES['cover_single']['name'];
      $ukuranFileCover  = $_FILES['cover_single']['size'];
      $tmpFileCover = $_FILES['cover_single']['tmp_name'];

      // Validasi File Cover
      $allowedExtCover  = array('png', 'jpg', 'jpeg');
      $xCover = explode('.', $namaFileCover);
      $extFileCover = strtolower(end($xCover));

      if (in_array($extFileCover, $allowedExtCover) === false) {
        $errorMessage[] = [
          'name' => 'cover_single',
          'alias' => 'Foto Cover Single',
          'success' => false,
          'error_msg' => 'Jenis File Harus Berupa .jpg / .jpeg / .png',
        ];
      }

      if ($ukuranFileCover > 1044070) {
        $errorMessage[] = [
          'name' => 'cover_single',
          'alias' => 'Foto Cover Single',
          'success' => false,
          'error_msg' => 'Ukuran File Terlalu Besar !',
        ];
      }

    }

    if (isset($_FILES['file_single']) && $_FILES['file_single']['name'] != null) {
      $ubahFileSingle = true;
      // File Var Single
      $namaFileSingle = $_FILES['file_single']['name'];
      $ukuranFileSingle  = $_FILES['file_single']['size'];
      $tmpFileSingle = $_FILES['file_single']['tmp_name'];

      // Validasi File Single
      $allowedExtSingle  = array('mp3', 'wav');
      $xSingle = explode('.', $namaFileSingle);
      $extFileSingle = strtolower(end($xSingle));

      if (in_array($extFileSingle, $allowedExtSingle) === false) {
        $errorMessage[] = [
          'name' => 'file_single',
          'alias' => 'File Single',
          'success' => false,
          'error_msg' => 'Jenis File Harus Berupa .mp3 / .wav',
        ];
      }

      if ($ukuranFileSingle > 10440700) {
        $errorMessage[] = [
          'name' => 'file_single',
          'alias' => 'File Single',
          'success' => false,
          'error_msg' => 'Ukuran File Terlalu Besar !',
        ];
      }
    }

    $verifyData = [
      'nama_single' => htmlspecialchars(trim($_POST['nama_single'])),
      'tanggal_rilis' => htmlspecialchars(trim($_POST['tanggal_rilis'])),
      'id_album' => htmlspecialchars(trim($_POST['id_album'])),
      'genre_single' => htmlspecialchars(trim($_POST['genre_single'])),
    ];
  
    $validateArray = [
      [
        'name' => 'nama_single',
        'alias' => 'Nama Single',
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
        'name' => 'id_album',
        'alias' => 'Album',
        'success' => false,
        'error_msg' => null,
      ],
      [
        'name' => 'genre_single',
        'alias' => 'Genre Single',
        'success' => false,
        'error_msg' => null,
      ],
    ];
  
    $validate = validateArray($verifyData, $validateArray);
    if ($validate['code'] == false) {
      $errorMessage = array_merge($errorMessage, $validate['res']);
    }

    if ($errorMessage == null) {
      $namaBaru = $editData->cover_single;
      $lokasiFileCover = $editData->lokasi_file_cover;
      $lokasiFileSingle = $editData->lokasi_file_single;

      if ($ubahFileCover == true) {
        $namaBaru = $editData->cover_single;
        $lokasiFileCover = 'single_cover/' . $namaBaru . '.' . $extFileCover;
        $uploadFileCover = move_uploaded_file($tmpFileCover, '../single_cover/' . $namaBaru . '.' . $extFileCover);
        if (!$uploadFileCover) {
          $errorMessage[] = [
            'name' => 'cover_single',
            'alias' => 'Foto Album',
            'success' => false,
            'error_msg' => 'Gagal di-Upload Silahkan Coba Lagi Dalam Beberapa Saat !',
          ];
        } 
      }

      if ($ubahFileSingle == true) {
        $namaBaru = $editData->file_single;
        $lokasiFileSingle = 'single_file/' . $namaBaru . '.' . $extFileSingle;
        $uploadFileSingle = move_uploaded_file($tmpFileSingle, '../single_file/' . $namaBaru . '.' . $extFileSingle);
        if (!$uploadFileSingle) {
          $errorMessage[] = [
            'name' => 'cover_single',
            'alias' => 'Foto Album',
            'success' => false,
            'error_msg' => 'Gagal di-Upload Silahkan Coba Lagi Dalam Beberapa Saat !',
          ];
        } 
      }

      $updateData = $koneksi->query("UPDATE singles SET
        id_album='". $verifyData['id_album'] ."',
        nama_single='". $verifyData['nama_single'] ."',
        tanggal_rilis='". $verifyData['tanggal_rilis'] ."',
        genre_single='". $verifyData['genre_single'] ."',
        cover_single='". $namaBaru ."',
        lokasi_file_cover='". $lokasiFileCover ."',
        file_single='". $namaBaru ."',
        lokasi_file_single='". $lokasiFileSingle ."'
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
        $_SESSION['flash_success'] = "Data Single di-Ubah !"; 
        echo "<script>window.location='". $baseUrl ."single/index.php';</script>";
        exit();
      }
    }
  }
}

if (isset($_GET['delete'])) {
  $checkData = $koneksi->query("SELECT * FROM singles WHERE id='". $_GET['delete'] ."' ");
  $searchedData = $checkData->fetch_object();
  if ($searchedData == null) {
    echo "<script>window.location='". $baseUrl ."single';</script>";
    exit();
  } else {
    $deleteData = $koneksi->query("DELETE FROM singles WHERE id='". $_GET['delete'] ."' ");
    if (!$deleteData) {
      $_SESSION['flash_error'] = "Gagal Melakukan Penghapusan Data !"; 
      echo "<script>window.location='". $baseUrl ."single/index.php';</script>";
      exit();
    } else {
      if ($searchedData->lokasi_file_cover != null) {
        if (file_exists('../'. $searchedData->lokasi_file_cover)) {
          $removeFileCover = unlink('../'. $searchedData->lokasi_file_cover);
        }
      }

      if ($searchedData->lokasi_file_single != null) {
        if (file_exists('../'. $searchedData->lokasi_file_single)) {
          $removeFileSingle = unlink('../'. $searchedData->lokasi_file_single);
        }
      }
      
      $_SESSION['flash_error'] = "Data Single di-Hapus !"; 
      echo "<script>window.location='". $baseUrl ."single/index.php';</script>";
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
        <form <?php if ($editData != null) { ?> action="<?=$baseUrl?>single/index.php?edit=<?=$editData->id?>" <?php } else { ?> action="<?=$baseUrl?>single/index.php" <?php } ?> method="post" enctype="multipart/form-data">
          <?php if ($editData != null) { ?>
            <input type="hidden" name="id" value="<?=$editData->id?>" readonly>
          <?php } ?>

          <div class="row">
            <div class="col-12">
              <h6 class="mb-2 text-center">
                <span class="fa fa-circle"></span> &ensp;
                <span class="fa fa-music"></span> &ensp; Data Single
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
                    <label for="nama_single" class="mb-2" style="font-weight: 600 !important;">Nama Single / Judul Lagu :</label>
                    <input type="text" name="nama_single" id="nama_single" class="form-control" placeholder="Masukan Nama Single / Judul Lagu..." <?php if ($editData != null) { ?> value="<?=$editData->nama_single?>" <?php } ?> required autofocus>
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
                    <label for="id_album" class="mb-2" style="font-weight: 600 !important;">Album Single :</label>
                    <select class="form-select mb-3" name="id_album" id="id_album" aria-label="Silahkan Pilih Album" required>
                      <option value="">- Pilih Album -</option>
                      <?php foreach ($dataAlbum as $key => $value) { ?>
                        <option value="<?=$value['id']?>" <?php if ($editData != null && $editData->id_album == $value['id'] ) { echo "selected"; } ?>><?=$value['nama_album']?></option>
                      <?php } ?>
                    </select>
                  </div>
                </div>
                <div class="col-md-6">
                  <div class="form-group mb-3">
                    <label for="genre_single" class="mb-2" style="font-weight: 600 !important;">Genre Single :</label>
                    <select class="form-select mb-3" name="genre_single" id="genre_single" aria-label="Silahkan Pilih Genre" required>
                      <option value="" selected disabled>-- Pilih Genre Musik --</option>
                      <option <?php if ($editData != null && $editData->genre_single == "Pop" ) { echo "selected"; } ?> value="Pop">Pop</option>
                      <option <?php if ($editData != null && $editData->genre_single == "Rock" ) { echo "selected"; } ?> value="Rock">Rock</option>
                      <option <?php if ($editData != null && $editData->genre_single == "Alternative" ) { echo "selected"; } ?> value="Alternative">Alternative</option>
                      <option <?php if ($editData != null && $editData->genre_single == "Blues" ) { echo "selected"; } ?> value="Blues">Blues</option>
                      <option <?php if ($editData != null && $editData->genre_single == "Dance" ) { echo "selected"; } ?> value="Dance">Dance</option>
                      <option <?php if ($editData != null && $editData->genre_single == "Hiphop/Rap" ) { echo "selected"; } ?> value="Hiphop/Rap">Hiphop/Rap</option>
                      <option <?php if ($editData != null && $editData->genre_single == "Jazz" ) { echo "selected"; } ?> value="Jazz">Jazz</option>
                      <option <?php if ($editData != null && $editData->genre_single == "RnB" ) { echo "selected"; } ?> value="RnB">RnB</option>
                      <option <?php if ($editData != null && $editData->genre_single == "Reggae" ) { echo "selected"; } ?> value="Reggae">Reggae</option>
                      <option <?php if ($editData != null && $editData->genre_single == "Heavy Metal" ) { echo "selected"; } ?> value="Heavy Metal">Heavy Metal</option>
                      <option <?php if ($editData != null && $editData->genre_single == "Ska" ) { echo "selected"; } ?> value="Ska">Ska</option>
                      <option <?php if ($editData != null && $editData->genre_single == "Punk" ) { echo "selected"; } ?> value="Punk">Punk</option>
                      <option <?php if ($editData != null && $editData->genre_single == "Dangdut" ) { echo "selected"; } ?> value="Dangdut">Dangdut</option>
                      <option <?php if ($editData != null && $editData->genre_single == "Instrumental" ) { echo "selected"; } ?> value="Instrumental">Instrumental</option>
                      <option <?php if ($editData != null && $editData->genre_single == "Acapella" ) { echo "selected"; } ?> value="Acapella">Acapella</option>
                      <option <?php if ($editData != null && $editData->genre_single == "Folk" ) { echo "selected"; } ?> value="Folk">Folk</option>
                      <option <?php if ($editData != null && $editData->genre_single == "Gospel" ) { echo "selected"; } ?> value="Gospel">Gospel</option>
                      <option <?php if ($editData != null && $editData->genre_single == "EDM" ) { echo "selected"; } ?> value="EDM">EDM</option>
                      <option <?php if ($editData != null && $editData->genre_single == "Koplo" ) { echo "selected"; } ?> value="Koplo">Koplo</option>
                      <option <?php if ($editData != null && $editData->genre_single == "New Wave" ) { echo "selected"; } ?> value="New Wave">New Wave</option>
                      <option <?php if ($editData != null && $editData->genre_single == "Ethnic" ) { echo "selected"; } ?> value="Ethnic">Ethnic</option>
                      <option <?php if ($editData != null && $editData->genre_single == "World Music" ) { echo "selected"; } ?> value="World Music">World Music</option>
                      <option <?php if ($editData != null && $editData->genre_single == "House Music" ) { echo "selected"; } ?> value="House Music">House Music</option>
                      <option <?php if ($editData != null && $editData->genre_single == "Religi" ) { echo "selected"; } ?> value="Religi">Religi</option>
                    </select>
                  </div>
                </div>
                <div class="col-md-12">
                  <div class="form-group mb-3">
                    <label for="cover_single" class="mb-2" style="font-weight: 600 !important;">Upload Cover Single :</label>
                    <input type="file" name="cover_single" id="cover_single" class="form-control" accept="image/jpg, image/jpeg, image/png" <?php if ($editData == null) { echo 'required'; } ?>>
                    <?php if ($editData != null && $editData->lokasi_file_cover != null) { ?>
                      <a href="<?=$baseUrl . $editData->lokasi_file_cover?>" target="_blank">
                        Lihat Cover Single Saat Ini
                      </a>
                    <?php } ?>
                  </div>
                </div>
                <div class="col-md-8">
                  <div class="form-group mb-3">
                    <label for="file_single" class="mb-2" style="font-weight: 600 !important;">Upload File Single :</label>
                    <input type="file" name="file_single" id="file_single" class="form-control" accept=".mp3,audio/*" <?php if ($editData == null) { echo 'required'; } ?>>
                    <?php if ($editData != null && $editData->lokasi_file_single != null) { ?>
                      <a href="<?=$baseUrl . $editData->lokasi_file_single?>" target="_blank">
                        Lihat File Single Saat Ini
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
                      <button type="submit" class="btn btn-success" style="width: 100% !important;" name="buatSingle">
                        <span class="fa fa-check"></span> &ensp; Buat Single
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
                  <th>Nama Single</th>
                  <th>Nama Album</th>
                  <th>Tanggal Rilis</th>
                  <th>Genre</th>
                  <th>Cover Single</th>
                  <th>Aksi</th>
                </thead>
                <tbody>
                  <?php if ($jumlahSingle > 0) { ?>
                    <?php $no = 1;?>
                    <?php foreach ($dataSingle as $key => $value) { ?>
                      <tr>
                        <td class="text-center align-middle" style="font-size: 12px !important;"><?=$no++?></td>
                        <td class="text-center align-middle" style="font-size: 12px !important;"><?=$value['nama_single']?></td>
                        <td class="text-center align-middle" style="font-size: 12px !important;"><?=$value['nama_album']?></td>
                        <td class="text-center align-middle" style="font-size: 12px !important;"><?=$value['tanggal_rilis']?></td>
                        <td class="text-center align-middle" style="font-size: 12px !important;"><?=$value['genre_single']?></td> 
                        <td class="text-center align-middle" style="font-size: 12px !important;">
                          <?php if ($value['lokasi_file_cover'] != null) { ?>
                            <a href="<?=$baseUrl . $value['lokasi_file_cover']?>" target="_blank">
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
                      <?php if ($value['lokasi_file_single'] != null) { ?>
                        <tr>
                          <td class="aling-middle text-center" colspan="7">
                            <audio controls>
                              <source src="<?=$baseUrl?>/<?=$value['lokasi_file_single']?>" type="audio/mpeg">
                              Your browser does not support the audio element.
                            </audio>
                          </td>
                        </tr>
                      <?php } else { echo "-"; } ?>
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