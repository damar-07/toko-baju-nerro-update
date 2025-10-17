<?php
session_start();

$id_produk = $_GET['id_produk'];
$ukuran = isset($_GET['ukuran']) ? $_GET['ukuran'] : '';

$key = $id_produk . '_' . $ukuran;

if(isset($_SESSION['pesanan'][$key])){
    $_SESSION['pesanan'][$key]['jumlah'] += 1;
}else{
    $_SESSION['pesanan'][$key] = [
        'id_produk' => $id_produk,
        'ukuran' => $ukuran,
        'jumlah' => 1
    ];
}

echo "<script>alert('Produk telah masuk ke pesanan anda');</script>";
echo "<script>location= 'keranjang_pembeli.php'</script>";
?>
