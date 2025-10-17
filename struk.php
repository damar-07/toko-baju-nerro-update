<?php
include 'koneksi.php';
session_start();

if($_SESSION['status'] == ""){
    header("location:index.php");
    exit;
}

if(!isset($_GET['id_pembayaran']) || empty($_GET['id_pembayaran'])){
    header("location:data_pesanan_masuk.php");
    exit;
}

$id_pembayaran = mysqli_real_escape_string($host, $_GET['id_pembayaran']);

$query_pembayaran = "SELECT pembayaran.*, tb_user.nama, tb_user.alamat FROM pembayaran JOIN tb_user ON pembayaran.id_user = tb_user.id_user WHERE id_pembayaran='$id_pembayaran'";
$result_pembayaran = mysqli_query($host, $query_pembayaran);

if(mysqli_num_rows($result_pembayaran) == 0){
    header("location:data_pesanan_masuk.php");
    exit;
}

$data_pembayaran = mysqli_fetch_assoc($result_pembayaran);


$query_items = "SELECT pembelian.*, tb_produk.nama_produk, tb_produk.kategori, tb_produk.harga_produk
                FROM pembelian
                JOIN tb_produk ON pembelian.id_produk = tb_produk.id_produk
                WHERE pembelian.id_pembayaran='$id_pembayaran'";
$result_items = mysqli_query($host, $query_items);

$total_belanja = $data_pembayaran['total_belanja'];
$jumlah_produk_unik = mysqli_num_rows($result_items);
$ongkir = $jumlah_produk_unik * 10000;
$total_akhir = $total_belanja;
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Struk Pembelian - NERRO SUPPLY</title>
    <link rel="icon" href="foto/logo.jpg">
    <style>
        body {
            font-family: 'Courier New', monospace;
            margin: 0;
            padding: 20px;
            background: white;
        }
        .receipt {
            max-width: 400px;
            margin: 0 auto;
            border: 1px solid #000;
            padding: 20px;
            background: white;
        }
        .header {
            text-align: center;
            border-bottom: 1px dashed #000;
            padding-bottom: 10px;
            margin-bottom: 10px;
        }
        .header h1 {
            margin: 0;
            font-size: 24px;
        }
        .header p {
            margin: 5px 0;
            font-size: 12px;
        }
        .info {
            margin-bottom: 10px;
        }
        .info p {
            margin: 5px 0;
            font-size: 12px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 10px;
        }
        th, td {
            text-align: left;
            padding: 5px 0;
            font-size: 12px;
        }
        th {
            border-bottom: 1px solid #000;
        }
        .total {
            border-top: 1px solid #000;
            font-weight: bold;
        }
        .footer {
            text-align: center;
            border-top: 1px dashed #000;
            padding-top: 10px;
            margin-top: 10px;
            font-size: 12px;
        }
        @media print {
            body {
                padding: 0;
            }
            .receipt {
                border: none;
                max-width: none;
                width: 100%;
            }
            .no-print {
                display: none;
            }
        }
        .no-print {
            text-align: center;
            margin-top: 20px;
        }
        .no-print button {
            padding: 10px 20px;
            background: #1abc9c;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }
        .no-print button:hover {
            background: #16a085;
        }
    </style>
</head>
<body>
    <div class="receipt">
        <div class="header">
            <h1>NERRO SUPPLY</h1>
            <p>Desa/Kelurahan: Pakan Sari</p>
            <p>Alamat Perusahaan: Jalan Raya Kol. Edy Yoso Martadipura</p>
            <p>Kecamatan: Cibinong, Kab/Kota: Bogor, Kode Pos: 16195</p>
        </div>
        <div class="info">
            <p><strong>Tanggal Transaksi:</strong> <?php echo date('d-m-Y H:i:s', strtotime($data_pembayaran['tanggal_pembayaran'])); ?></p>
            <p><strong>Nomor Transaksi:</strong> <?php echo $id_pembayaran; ?></p>
            <p><strong>Nama Pembeli:</strong> <?php echo $data_pembayaran['nama']; ?></p>
            <p><strong>Alamat:</strong> <?php echo $data_pembayaran['alamat']; ?></p>
            <p><strong>Metode Pembayaran:</strong> <?php echo $data_pembayaran['metode_pembayaran']; ?></p>
        </div>
        <table>
            <thead>
                <tr>
                    <th>Nama</th>
                    <th>Kat</th>
                    <th>Uk</th>
                    <th>Harga</th>
                    <th>Jml</th>
                    <th>Subtotal</th>
                </tr>
            </thead>
            <tbody>
                <?php while($item = mysqli_fetch_assoc($result_items)): ?>
                <tr>
                    <td><?php echo $item['nama_produk']; ?></td>
                    <td><?php echo $item['kategori']; ?></td>
                    <td><?php echo $item['ukuran']; ?></td>
                    <td>Rp <?php echo number_format($item['harga_produk']); ?></td>
                    <td><?php echo $item['jumlah']; ?></td>
                    <td>Rp <?php echo number_format($item['harga_produk'] * $item['jumlah']); ?></td>
                </tr>
                <?php endwhile; ?>
            </tbody>
            <tfoot>
                <tr>
                    <td colspan="4">Ongkos Kirim (<?php echo $jumlah_produk_unik; ?> produk)</td>
                    <td colspan="2">Rp <?php echo number_format($ongkir); ?></td>
                </tr>
                <tr>
                    <td colspan="4">Subtotal</td>
                    <td colspan="2">Rp <?php echo number_format($total_belanja); ?></td>
                </tr>
                <tr class="total">
                    <td colspan="4">Total Akhir</td>
                    <td colspan="2">Rp <?php echo number_format($total_akhir); ?></td>
                </tr>
            </tfoot>
        </table>
        <div class="footer">
            <p>Terima Kasih Atas Pembelian Anda</p>
            <p>Barang yang sudah dibeli tidak dapat dikembalikan</p>
        </div>
    </div>
    <div class="no-print">
        <button onclick="window.print()">Cetak Struk</button>
        <br><br>
        <a href="data_pesanan_masuk.php">Kembali ke Pesanan Masuk</a>
    </div>
</body>
</html>
