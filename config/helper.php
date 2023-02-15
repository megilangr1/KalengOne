<?php 
  function validateArray($data, $arrayKey)
  {
    for ($i=0; $i < count($arrayKey); $i++) { 
      $validate = validasiRequired($data, $arrayKey[$i]['name']);
      $arrayKey[$i]['success'] = $validate['success'];
      $arrayKey[$i]['error_msg'] = $validate['error_msg'];
    }

    $code = true;
    foreach ($arrayKey as $key => $value) {
      if ($value['success'] == false) {
        $code = false;
      }
    }

    return [
      'code' => $code,
      'res' => $arrayKey,
    ];
  }

  function validasiRequired($data, $key)
  {
    if (isset($data[$key]) && $data[$key] != null) {
      return [
        'success' => true,
        'error_msg' => null, 
      ];
    }
    return [
      'success' => false,
      'error_msg' => 'Input Tidak Boleh Kosong !'
    ];
  }

  function loginCheck($koneksi, $baseUrl) {
    if (isset($_SESSION['user'])) {
      $check = $koneksi->query("SELECT * FROM users WHERE id='". $_SESSION['user']['id'] ."' ");
      $data = $check->fetch_object();
      if ($data != null) {
        unset($_SESSION['user']);
        
        $_SESSION['user'] = [
          'id' => $data->id,
          'nama_depan' => $data->nama_depan,
          'nama_belakang' => $data->nama_belakang,
          'username' => $data->username,
          'email' => $data->email,
          'level' => $data->level,
          'login_date' => date('Y-m-d'),
          'login_time' => date('H:i:s') 
        ];

        return $_SESSION['user'];
      } else {
        unset($_SESSION['user']);
        return header('location: '.$baseUrl.'login.php');
        exit();
      }
    } else {
      return header('location: '.$baseUrl.'login.php');
      exit();
    }
  }
?>