<?php
session_start();
$baseUrl = "http://localhost/Other/music/";
date_default_timezone_set("Asia/Jakarta");

$koneksi = new mysqli('localhost', 'root', '', 'imr');
if ($koneksi->connect_errno) {
  echo "Koneksi Database Gagal ! <br>";
  echo $koneksi->connect_error;
  die();
}

?>