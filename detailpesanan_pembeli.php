<?php 
include 'koneksi.php';
session_start();

if($_SESSION['status'] == ""){
    header("location:index.php");
}

$username = $_SESSION['username'];
$query = "SELECT * FROM tb_user WHERE username='$username'";
$result = mysqli_query($host, $query);

if(mysqli_num_rows($result) > 0) {
    $data_akun = mysqli_fetch_array($result);
    $_SESSION['id_user'] = $data_akun['id_user'];
    $_SESSION['status'] = $data_akun['status'];
    $_SESSION['nama'] = $data_akun['nama'];
    $_SESSION['alamat'] = $data_akun['alamat'];
    $_SESSION['foto_profil'] = $data_akun['foto_profil'] ?? '';
}

if(isset($_POST['terima'])){
    $id_pembayaran = $_POST['id_pembayaran'];
    $update_status = mysqli_query($host,"UPDATE pembayaran SET status_pesanan='dikonfirmasi' WHERE id_pembayaran='$id_pembayaran");

    if($update_status){
        echo "<script>alert('Pesanan berhasil diterima');</script>";

    }else{
        echo "<script>alert('Gagal menerima pesanan. Silahkan coba lagi.');</script>";
    }
}


?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>detail pesanan</title>
    <link rel="icon" href="foto/logo.jpg">
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body>
    <div class="content">
        <h2>detail pesanan</h2>
        <table>
            <thead>
                <tr>
                    <th>No</th>
                    <th>gambar produk</th>
                    <th>nama produk</th>
                    <th>ukuran</th>
                    <th>harga</th>
                    <th>jumlah</th>
                    <th>total</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $nomor = 1;
                $total_belanja = 0;
                $id_pembayaran = mysqli_real_escape_string($host, $_GET['id_pembayaran']);
                $ambil = $host->query("SELECT * FROM pembelian JOIN tb_produk ON pembelian.id_produk=tb_produk.id_produk WHERE pembelian.id_pembayaran='$id_pembayaran'");
                while($pecah = $ambil->fetch_assoc()){
                    $subtotal1 = $pecah['harga_produk'] * $pecah['jumlah'];
                    $total_belanja += $subtotal1;
                    ?>
                    <tr>
                        <td><?php echo $nomor; ?></td>
                        <td><img src="foto/<?php echo $pecah['gambar']; ?>" alt="gambar produk"></td>
                        <td><?php echo $pecah['nama_produk']; ?></td>
                        <td><?php echo $pecah['ukuran']; ?></td>
                        <td><?php echo number_format($pecah['harga_produk']); ?></td>
                        <td><?php echo $pecah['jumlah']; ?></td>
                        <td>Rp.<?php echo number_format($subtotal1); ?></td>
                    </tr>
                    <?php
                    $nomor++;
                }
                ?>
                <tr>
                    <th colspan="6">total bayar</th>
                    <th>Rp.<?php echo number_format($total_belanja); ?></th>
                </tr>
                ?>
            </tbody>
        </table>
        <?php
        $id_pembayaran = $_GET['id_pembayaran'];
        $ambil_status = $host->query("SELECT * FROM pembayaran WHERE id_pembayaran='$id_pembayaran'");
        $status_pembayaran = $ambil_status->fetch_assoc()['status_pesanan'];
        ?>

        <form action="" method="post">
            <input type="hidden" name="id_pembayaran" value="<?php echo $id_pembayaran; ?>">
            <a href="pesanan_pembeli.php" class="btn btn-primary">kembali</a>
            <?php if($status_pembayaran === 'pesanan telah dikirim'):?>
                <button type="submit" name="terima" value="terima" class="btn btn-success">pesanan telah diterima</button>
                <?php else: ?>
                    <button type="submit" name="terima" value="terima" onclick="alert('tombol hanya bisa digunakan ketika status pesanan anda telah dikirim')" class="btn btn-success" disabled>pesanan telah diterima</button>
                <?php endif; ?>
        </form>
    </div>
</body>
</html>