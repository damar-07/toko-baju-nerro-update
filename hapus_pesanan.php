<?php 
include 'koneksi.php';

$id_pembayaran = $_GET['id_pembayaran'];

$hapus = "DELETE FROM pembayaran WHERE id_pembayaran = '$id_pembayaran'";

if(mysqli_query($host,$hapus)){
    echo "<script>alert('produk pesanan anda berhasil dihapus');
    window.location='data_pesanan_masuk.php';
    </script>";
}else{
     echo "<script>alert('gagal menghapus penanan anda');
    window.location='data_pesanan_masuk.php';
    </script>";
}
?>