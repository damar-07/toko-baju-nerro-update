<?php
session_start();
include 'koneksi.php';

if($_SESSION['status'] == "") {
    header("location:index.php");
    exit();
}

if(isset($_POST['kirim'])) {
    $id_user = $_SESSION['id_user'];
    $nama = mysqli_real_escape_string($host, $_POST['nama']);
    $subjek = mysqli_real_escape_string($host, $_POST['subjek']);
    $pesan = mysqli_real_escape_string($host, $_POST['pesan']);

    $query = "INSERT INTO kontak (id_user, nama, subjek, pesan, tanggal_kirim)
              VALUES ('$id_user', '$nama', '$subjek', '$pesan', NOW())";

    if(mysqli_query($host, $query)) {
        echo "<script>alert('Pesan berhasil dikirim! Kami akan segera merespons.'); window.location='kontak_pembeli.php';</script>";
    } else {
        echo "<script>alert('Gagal mengirim pesan. Silakan coba lagi.'); window.location='kontak_pembeli.php';</script>";
    }
} else {
    header("location:kontak_pembeli.php");
}
?>
