<?php
include '../config/koneksi.php';

if(isset($_POST["submit"])){
    $judul_lagu = htmlspecialchars($_POST["judul_lagu"]);
    $artis = htmlspecialchars($_POST["artis"]);
    $featuring_artis = htmlspecialchars($_POST["featuring_artis"]);
    $bahasa = htmlspecialchars($_POST["bahasa"]);
    $genre = htmlspecialchars($_POST["genre"]);
    $sub_genre = htmlspecialchars($_POST["sub_genre"]);
    $tanggal_rilis = htmlspecialchars($_POST["tanggal_rilis"]);
    $link_spotify = htmlspecialchars($_POST["link_spotify"]);
    $link_itunes = htmlspecialchars($_POST["link_itunes"]);
    $link_youtube = htmlspecialchars($_POST["link_youtube"]);
    $contact_person = htmlspecialchars($_POST["contact_person"]);
    $pencipta_lagu = htmlspecialchars($_POST["pencipta_lagu"]);
    $komposer = htmlspecialchars($_POST["komposer"]);
    $arranger = htmlspecialchars($_POST["arranger"]);
    $produser = htmlspecialchars($_POST["produser"]);
    $tahun_produksi = htmlspecialchars($_POST["tahun_produksi"]);
    $cover_lagu = upload_cover();
    $upload_lagu = htmlspecialchars($_POST["upload_lagu"]);
    $upload_ktp = htmlspecialchars($_POST["upload_ktp"]);

    if(!$cover_lagu){
        return false;
    }
    
    
    $query = "INSERT INTO add_single VALUE('$judul_lagu','','$artis','$featuring_artis','$bahasa','$genre','$sub_genre','$tanggal_rilis',
    '$link_spotify','$link_itunes','$link_youtube','$contact_person','$pencipta_lagu','$komposer','$arranger','$produser','$tahun_produksi','$cover_lagu','$upload_lagu',' $upload_ktp')";

    mysqli_query($conn,$query);

    if(mysqli_affected_rows($conn) > 0){
        echo "<script>alert('Data Berhasil Dimasukan'); document.location = 'index.html'</script>";
    }else{
        echo "<script>alert('Data Gagal Dimasukan'); document.location = 'form-single.php'</script>";
    }
    
    return mysqli_affected_rows($conn);




}


function upload_cover(){
    $nameFile = $_FILES['cover_lagu']['name'];
    $ukuran = $_FILES['cover_lagu']['size'];
    $error = $_FILES['cover_lagu']['error'];
    $tmpName = $_FILES['cover_lagu']['tmp_name'];
    if($error === 4){
        echo "<script>alert('Masukan Cover Terlebih Dahulu')</script>";
        return false;
    }

    $ekstensiGambarValidasi = ['jpg','jpeg','png'];
    $ekstensiGambar = explode('.', $nameFile);
    $ekstensiGambar = strtolower(end($ekstensiGambar));
    if(!in_array($ekstensiGambar,$ekstensiGambarValidasi)){
        echo "<script>alert('Bukan Gambar'); document.location = 'form_single.php'</script>";
        return false;

    }

    if($ukuran > 1000000){
        echo "<script>alert('Gamabar Terlau Besar'); document.location = 'form_single.php'</script>";
        return false;

    }

    $namafilebaru = uniqid();
    $namafilebaru .= '.';
    $namafilebaru .= $ekstensiGambar;

    move_uploaded_file($tmpName,'../img/'.$namafilebaru);
    echo "<script>alert('berhasil'); document.location = 'form_single.php'</script>";
    
}
function upload_ktp(){
    $nameFile = $_FILES['cover_lagu']['name'];
    $ukuran = $_FILES['cover_lagu']['size'];
    $error = $_FILES['cover_lagu']['error'];
    $tmpName = $_FILES['cover_lagu']['tmp_name'];
    if($error === 4){
        echo "<script>alert('Masukan Cover Terlebih Dahulu')</script>";
        return false;
    }

    $ekstensiGambarValidasi = ['jpg','jpeg','png'];
    $ekstensiGambar = explode('.', $nameFile);
    $ekstensiGambar = strtolower(end($ekstensiGambar));
    if(!in_array($ekstensiGambar,$ekstensiGambarValidasi)){
        echo "<script>alert('Bukan Gambar'); document.location = 'form_single.php'</script>";
        return false;

    }

    if($ukuran > 1000000){
        echo "<script>alert('Gamabar Terlau Besar'); document.location = 'form_single.php'</script>";
        return false;

    }

    $namafilebaru = uniqid();
    $namafilebaru .= '.';
    $namafilebaru .= $ekstensiGambar;

    move_uploaded_file($tmpName,'../img/'.$namafilebaru);
    echo "<script>alert('berhasil'); document.location = 'form_single.php'</script>";
    
}


?>