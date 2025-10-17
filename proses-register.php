<?php 
include 'koneksi.php';

if(isset($_POST['submit'])){
    $username = $_POST['username'];
    $password = $_POST['password'];
    $nama = $_POST['nama'];
    $alamat = $_POST['alamat'];
    $nomor_telepon = $_POST['nomor_telepon'];
    $status = 'pembeli';

    $foto = $_FILES['foto_profil']['name'];
    $tmp = $_FILES['foto_profil']['tmp_name'];
    $folder = 'foto_profil/';

    if(move_uploaded_file($tmp,$folder.$foto)){
        $query = "INSERT INTO tb_user (nama,username,password,alamat,nomor_telepon,foto_profil,status) VALUES ('$nama','$username','$password','$alamat','$nomor_telepon','$foto','pembeli')";

        if(mysqli_query($koneksi,$query)){
            echo "<script>alert('register berhasil! Silakan login.');</script>";
            echo "<script>location='halamanlogin.php';</script>";
        }else{
            echo "<script>alert('Pendaftaran gagal, silakan coba lagi.');</script>";
        }
    }else{
        echo "<script>alert('Upload foto gagal, silakan coba lagi.');</script>";
    }
}



?>
