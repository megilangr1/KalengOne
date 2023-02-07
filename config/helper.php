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
?>