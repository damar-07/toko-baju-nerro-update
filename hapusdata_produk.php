<?php 
include 'koneksi.php';
$id_produk = $_GET['id_produk'];
$query = "DELETE FROM tb_produk WHERE id_produk='$id_produk'";
mysqli_query($host,$query);
echo "<script>alert('data berhasil dihapus');</script>";
echo "<script>window.location = 'dataproduk_admin.php';</script>";
?>
