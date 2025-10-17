<?php 
include 'koneksi.php';
session_start();

if($_SESSION['status'] == ""){
    header("location:index.php");
    exit;
}

$nama_produk = isset($_POST['nama_produk']) ? $_POST['nama_produk'] : '';
$jenis_baju = isset($_POST['jenis_baju']) ? $_POST['jenis_baju'] : '';
$kategori = isset($_POST['kategori']) ? $_POST['kategori'] : '';
$deskripsi = isset($_POST['deskripsi']) ? $_POST['deskripsi'] : '';
$ukuran = isset($_POST['ukuran']) ? $_POST['ukuran'] : '';

$stok = filter_var($_POST['stok'], FILTER_VALIDATE_INT);
$harga_produk = filter_var($_POST['harga_produk'], FILTER_VALIDATE_INT);

if ($stok === false || $harga_produk === false) {
    echo "<script>
            alert('Stok dan Harga harus berupa angka yang valid!');
            window.location='tambahproduk.php';
          </script>";
    exit;
}

$gambar = $_FILES['gambar']['name'];
$gambar_hover = $_FILES['gambar_hover']['name'];

$target_dir = "foto/";
$target_file = $target_dir . basename($gambar);
$target_file_hover = $target_dir . basename($gambar_hover);

if(move_uploaded_file($_FILES['gambar']['tmp_name'], $target_file) && move_uploaded_file($_FILES['gambar_hover']['tmp_name'], $target_file_hover)){
    $query = "INSERT INTO tb_produk (nama_produk, jenis_baju, kategori, deskripsi, ukuran, stok, harga_produk, gambar, gambar_hover) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)";

    if($stmt = mysqli_prepare($host, $query)){
        mysqli_stmt_bind_param($stmt, "sssssiiss", $nama_produk, $jenis_baju, $kategori, $deskripsi, $ukuran, $stok, $harga_produk, $gambar, $gambar_hover);

        if(mysqli_stmt_execute($stmt)){
            echo "<script>alert('data berhasil disimpan'); window.location.href='dashboard_admin.php';</script>";
        }else{
            echo "error: " . mysqli_error($host);
        }
    }else{
        echo "ada kesalahan saat menyiapkan query";
    }
} else {
    echo "ada kesalahan saat mengupload gambar";
}

mysqli_close($host);
?>
