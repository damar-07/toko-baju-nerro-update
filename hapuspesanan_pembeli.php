<?php 
include 'koneksi.php';

$id_pembayaran = $_GET['id_pembayaran'];

$hapus = "DELETE FROM pembayaran WHERE id_pembayaran='$id_pembayaran'";

if(mysqli_query($host,$hapus)){
    echo "<script>alert('produk berhasil dihapus');
    window.location='pesanan_pembeli.php';
    </script>";
}else{
    echo "<script>alert('gagal menghapus produk');
    window.location='pesanan_pembeli.php';
    </script>";
}

?>