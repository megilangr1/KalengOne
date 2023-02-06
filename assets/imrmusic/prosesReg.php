<?php
include '../config/koneksi.php';

if(isset($_POST["submit"])){
    $nama_lengkap = htmlspecialchars($_POST["nama_lengkap"]);
    $email = htmlspecialchars($_POST["email"]);
    $password = htmlspecialchars($_POST["password"]);
    $bukti_pembayaran = upload_bukti();

    if(!$bukti_pembayaran){
        return false;
    }
    
    
    $query = "INSERT INTO tb_user VALUES('','$nama_lengkap','$email','$password','$bukti_pembayaran','')";

    mysqli_query($conn,$query);

    if(mysqli_affected_rows($conn) > 0){
        echo "<script>alert('Data Berhasil Dimasukan'); document.location = 'index.html'</script>";
    }else{
        echo "<script>alert('Data Gagal Dimasukan'); document.location = 'signup.php'</script>";
    }
    
    return mysqli_affected_rows($conn);




}


function upload_bukti(){
    $nameFile = $_FILES['bukti_pembayaran']['name'];
    $ukuran = $_FILES['bukti_pembayaran']['size'];
    $error = $_FILES['bukti_pembayaran']['error'];
    $tmpName = $_FILES['bukti_pembayaran']['tmp_name'];
    if($error === 4){
        echo "<script>alert('Masukan Cover Terlebih Dahulu')</script>";
        return false;
    }

    $ekstensiGambarValidasi = ['jpg','jpeg','png'];
    $ekstensiGambar = explode('.', $nameFile);
    $ekstensiGambar = strtolower(end($ekstensiGambar));
    if(!in_array($ekstensiGambar,$ekstensiGambarValidasi)){
        echo "<script>alert('Bukan Gambar'); document.location = 'signup.php'</script>";
        return false;

    }

    if($ukuran > 1000000){
        echo "<script>alert('Gamabar Terlau Besar'); document.location = 'signup.php'</script>";
        return false;

    }

    $namafilebaru = uniqid();
    $namafilebaru .= '.';
    $namafilebaru .= $ekstensiGambar;

    move_uploaded_file($tmpName,'../img/tf/'.$namafilebaru);
    echo "<script>alert('berhasil'); document.location = 'form_single.php'</script>";
    
}


?>