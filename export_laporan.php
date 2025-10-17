<?php
include 'koneksi.php';
session_start();

if($_SESSION['status'] == ""){
    header("location:index.php");
}

// Export to Excel functionality
if(isset($_GET['export']) && $_GET['export'] == 'excel'){
    $ambil = mysqli_query($host, "SELECT * FROM pembayaran");

    header('Content-Type: application/vnd.ms-excel');
    header('Content-Disposition: attachment; filename="laporan_pesanan_bulanan_' . date('Y-m') . '.xls"');

    echo "<table border='1'>";
    echo "<tr><th>No.</th><th>Nama Produk</th><th>Nomor Telepon</th><th>Tanggal Pemesanan</th><th>Harga Produk</th><th>Alamat</th><th>Metode Pengiriman</th><th>Status Pesanan</th></tr>";

    $nomor = 1;
    while($result = mysqli_fetch_assoc($ambil)){
        echo "<tr>";
        echo "<td>" . $nomor . "</td>";
        echo "<td>" . $result['nama'] . "</td>";
        echo "<td>" . $result['nomor_telepon'] . "</td>";
        echo "<td>" . $result['tanggal_pembayaran'] . "</td>";
        echo "<td>Rp " . number_format($result['total_belanja'], 0, ',', '.') . "</td>";
        echo "<td>" . $result['alamat'] . "</td>";
        echo "<td>";
        $metode = $result['metode_pengiriman'];
        switch($metode) {
            case 'jne':
                echo 'JNE';
                break;
            case 'tiki':
                echo 'JNT';
                break;
            case 'pos':
                echo 'SI CEPAT';
                break;
            default:
                echo $metode;
        }
        echo "</td>";
        echo "<td>" . $result['status_pesanan'] . "</td>";
        echo "</tr>";
        $nomor++;
    }
    echo "</table>";
    exit();
}
?>
