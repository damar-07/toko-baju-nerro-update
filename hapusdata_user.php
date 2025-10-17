<?php
include 'koneksi.php';
if(isset($_GET['id_user'])){
    $id_user = $_GET['id_user'];
    $delete_query = "DELETE FROM tb_user WHERE id_user='$id_user'";

    if(mysqli_query($host,$delete_query)){
        echo "data berhasil dihapus";
        header("location:data_user.php");
    }else{
        echo "gagal menghapus data";
    }
}
?>
