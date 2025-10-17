<?php
include 'koneksi.php';

    if(isset($_POST['edit'])){
        $id_produk  = mysqli_real_escape_string($host, $_POST['id_produk']);
        $nama_produk = mysqli_real_escape_string($host, $_POST['nama_produk']);
        $ukuran = mysqli_real_escape_string($host, $_POST['ukuran']);
        $jenis_baju = mysqli_real_escape_string($host, $_POST['jenis_baju']);
        $kategori = mysqli_real_escape_string($host, $_POST['kategori']);
        $deskripsi = mysqli_real_escape_string($host, $_POST['deskripsi']);

        $stok = filter_var($_POST['stok'], FILTER_VALIDATE_INT);
        $harga_produk = filter_var($_POST['harga_produk'], FILTER_VALIDATE_INT);

    if ($stok === false || $harga_produk === false) {
        echo "<script>
                alert('Stok dan Harga harus berupa angka yang valid!');
                window.location='editdata_produk.php?id_produk=$id_produk';
              </script>";
        exit;
    }

    $update_fields = "nama_produk='$nama_produk', ukuran='$ukuran', jenis_baju='$jenis_baju', kategori='$kategori', deskripsi='$deskripsi', stok=$stok, harga_produk=$harga_produk";

    if(!empty($_FILES['gambar']['name'])){
        $gambar = $_FILES['gambar']['name'];
        $source = $_FILES['gambar']['tmp_name'];
        $folder = './foto/';
        if(move_uploaded_file($source, $folder . $gambar)){
            $update_fields .= ", gambar='$gambar'";
        } else {
            echo "<script>alert('Upload gambar gagal!');</script>";
            exit;
        }
    }

    if(!empty($_FILES['gambar_hover']['name'])){
        $gambar_hover = $_FILES['gambar_hover']['name'];
        $source_hover = $_FILES['gambar_hover']['tmp_name'];
        $folder = './foto/';
        if(move_uploaded_file($source_hover, $folder . $gambar_hover)){
            $update_fields .= ", gambar_hover='$gambar_hover'";
        } else {
            echo "<script>alert('Upload gambar hover gagal!');</script>";
            exit;
        }
    }

    $query = "UPDATE tb_produk SET $update_fields WHERE id_produk='$id_produk'";
    $hasil = mysqli_query($host,$query);

    if($hasil){
        echo "<script>alert('data berhasil diubah');
        window.location='dashboard_admin.php';
        </script>";
    } else {
        $error = mysqli_error($host);
        echo "<script>
                alert('Data gagal diubah! Error: $error');
                window.location='editdata_produk.php?id_produk=$id_produk';
              </script>";
    }
}
?>
