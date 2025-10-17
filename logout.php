<?php 
session_start();

$_SESSION = array();

session_destroy();

echo "<script> alert('berhasil logout cuy');
    window.location.href='halamanlogin.php'</script>";
?>