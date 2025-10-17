<?php 
session_start();
include 'koneksi.php';

if($_SESSION['status'] == ""){
    header("location:index.php");
    exit();
}

if(isset($_GET['id_key'])){
    $id_key = $_GET['id_key'];

    if(isset($_SESSION['pesanan'][$id_key])){
        unset($_SESSION['pesanan'][$id_key]);

        if(empty($_SESSION['pesanan'])){
            echo "<script>alert('pesanan berhasil dihapus');</script>";
            echo "<script>location='keranjang_pembeli.php';</script>";
        }else{
            echo  "<script>location='keranjang_pembeli.php';</script>";
        }
    }
}
?>