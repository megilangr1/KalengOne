<?php
require_once('../config/koneksi.php');
require_once('../config/helper.php');

$loginCheck = loginCheck($koneksi, $baseUrl);
if (isset($loginCheck['level']) && $loginCheck['level'] > 0) {
  header('location: '. $baseUrl . 'index.php');
}
?>
