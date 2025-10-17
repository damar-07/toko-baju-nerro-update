<?php
session_start();

include "koneksi.php";

$username = $_POST['username'];
$password = $_POST['password'];

$login = mysqli_query($host,"SELECT * FROM tb_user WHERE username='$username' AND password='$password'");
$cek = mysqli_num_rows($login);

if($cek>0){

    $data=mysqli_fetch_assoc($login);

    if($data['status'] == "admin"){

        $_SESSION['username'] = $username;
        $_SESSION['status'] = "admin"; 
        header("location: dashboard_admin.php");

    }elseif($data['status'] == "pembeli"){

        $_SESSION['username'] = $username;
        $_SESSION['status'] = "pembeli";
        header("location: dashboard_user.php");
    }else{
        header("location: index.php?pesan=gagal");
    }
}else{
    echo "<script> alert('username atau password salah');
    window.location.href='halamanlogin.php'</script>";
}
?>
