<?php
$baseUrl = "http://localhost/Other/music/";

$koneksi = mysqli_connect('localhost', 'root', '', 'imr');
if ($koneksi->connect_errno) {
  echo "Koneksi Database Gagal ! <br>";
  echo $koneksi->connect_error;
  die();
}

?>