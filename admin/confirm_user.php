<?php 
  require_once('../config/koneksi.php');

  if (isset($_POST['confirm_user'])) {
    $getUser = $koneksi->query("SELECT * FROM users WHERE email='". $_POST['email'] ."' ");
    $data = $getUser->fetch_object();
    if ($data == null) {
      $_SESSION['flash_error'] = "Terjadi Kesalahan ! <br> Silahkan Coba Lagi Nanti !"; 
      echo "<script>window.location='". $baseUrl ."admin/user.php';</script>";
    } else {
      $level = $data->level == 1 ? '2': $data->level;
      $updateUser = $koneksi->query("UPDATE users SET level='$level', status_verifikasi='1' WHERE id='$data->id' ");
      if (!$updateUser) {
        $_SESSION['flash_error'] = "Terjadi Kesalahan ! <br> Silahkan Coba Lagi Nanti !"; 
        echo "<script>window.location='". $baseUrl ."admin/user.php';</script>";
      } else {
        $_SESSION['flash_success'] = "User berhasil di-Verifikasi !"; 
        echo "<script>window.location='". $baseUrl ."admin/user.php';</script>";
      }
    }
  }
?>