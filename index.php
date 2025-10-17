<?php 
session_start();
if(!isset($_SESSION['login_user'])){
    header("location: halamanlogin.php");
}else{header('location: halamanlogin.php');}

?>