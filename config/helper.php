<?php 
  function validateArray($data, $arrayKey)
  {
    $res = [];
    for ($i=0; $i < count($arrayKey); $i++) { 
      $validate = validasiKey($data, $arrayKey[$i]);
      $res[$arrayKey[$i]] = $validate;
    }

    $code = true;
    foreach ($res as $key => $value) {
      if ($value == false) {
        $code = false;
      }
    }

    return [
      'code' => $code,
      'res' => $res
    ];
  }

  function validasiKey($data, $key)
  {
    if (isset($data[$key]) && $data[$key] != null) {
      return true;
    }
    return false;
  }
?>