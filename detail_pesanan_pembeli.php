<?php
include 'koneksi.php';
session_start();

if($_SESSION['status']==""){
    header("location:index.php");
}

if(!isset($_GET['id_pembayaran']) || empty($_GET['id_pembayaran'])){
    header("location:pesanan_pembeli.php");
}

if(isset($_POST['terima'])){
    $id_pembayaran = mysqli_real_escape_string($host, $_GET['id_pembayaran']);
    $update_status = mysqli_query($host, "UPDATE pembayaran SET status_pesanan = 'pesanan telah diterima' WHERE id_pembayaran='$id_pembayaran'");

    if($update_status){
        echo "<script>alert('Pesanan telah diterima'); window.location='pesanan_pembeli.php';</script>";
    }else{
        echo "<script>alert('Pesanan gagal terupdate');</script>";
    }
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Toko Baju - Detail Pesanan</title>
    <link rel="icon" href="foto/logo.jpg">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="style.css">
    <style>
        .top-navbar {
            background-color: #2c3e50;
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 10px 30px;
            color: white;
            position: sticky;
            top: 0;
            z-index: 1100;
            box-shadow: 0 4px 6px rgba(0,0,0,0.3);
        }
        .top-navbar .left-section {
            display: flex;
            align-items: center;
            gap: 15px;
        }
        .top-navbar .left-section img.logo {
            height: 40px;
            width: auto;
        }
        .top-navbar .site-info {
            display: flex;
            flex-direction: column;
            line-height: 1.1;
        }
        .top-navbar .site-info .site-name {
            font-size: 22px;
            font-weight: bold;
            letter-spacing: 1.5px;
        }
        .top-navbar .site-info .tagline {
            font-size: 12px;
            font-style: italic;
            color: #1abc9c;
        }
        .top-navbar .right-section {
            display: flex;
            align-items: center;
            gap: 20px;
            font-size: 20px;
        }
        .top-navbar .right-section a {
            color: white;
            text-decoration: none;
            transition: color 0.3s ease;
        }
        .top-navbar .right-section a:hover {
            color: #1abc9c;
        }
        .navigasi {
            background-color: white;
            padding: 10px 0;
            position: sticky;
            top: 60px;
            z-index: 1000;
            box-shadow: 0 4px 10px rgba(0,0,0,0.1);
            border-radius: 0 0 15px 15px;
            display: flex;
            justify-content: center;
            align-items: center;
        }
        .navigasi .hamburger {
            display: none;
            flex-direction: column;
            cursor: pointer;
            padding: 10px;
        }
        .navigasi .hamburger div {
            width: 25px;
            height: 3px;
            background-color: #2c3e50;
            margin: 3px 0;
            transition: 0.3s;
        }
        .navigasi ul {
            list-style: none;
            display: flex;
            justify-content: center;
            align-items: center;
            margin: 0;
            padding: 0;
            gap: 25px;
        }
        .navigasi li {
            margin: 0;
        }
        .navigasi a {
            text-decoration: none;
            color: #bac4ceff;
            padding: 10px 20px;
            border-radius: 22px;
            transition: background-color 0.3s, color 0.3s;
            font-weight: 600;
            display: flex;
            align-items: center;
            gap: 8px;
            font-size: 16px;
        }
        .navigasi a:hover, .navigasi a.active {
            background-color: #1abc9c;
            color: white;
            box-shadow: 0 0 8px #16a085;
        }
        .nav-menu.show {
            display: flex !important;
        }
        #overlay {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0,0,0,0.5);
            display: none;
            z-index: 999;
        }
        #overlay.show {
            display: block;
        }
        @media (max-width: 768px) {
            .navigasi ul {
                position: absolute;
                top: 100%;
                left: 0;
                width: 100%;
                flex-direction: column;
                background: rgba(0,0,0,0.3);
                backdrop-filter: blur(10px);
                padding: 10px 0;
                border-radius: 0 0 15px 15px;
                display: none;
                gap: 10px;
            }
            .navigasi .hamburger {
                display: flex;
            }
        }
        .content {
            padding: 20px;
            background: #f4f4f4;
            min-height: 100vh;
        }

        h3 {
            text-align: center;
            margin-bottom: 30px;
            color: #2c3e50;
            font-size: 28px;
            text-transform: uppercase;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            background: white;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
            border-radius: 8px;
            overflow: hidden;
            margin-bottom: 30px;
        }

        th, td {
            padding: 12px;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }

        th {
            background: #2c3e50;
            color: white;
            text-transform: uppercase;
            font-size: 12px;
        }

        tr:hover {
            background: #f8f9fa;
        }

        .product-image {
            max-width: 100px;
            height: auto;
            border-radius: 4px;
        }

        tfoot th {
            background: #1abc9c;
            color: white;
            font-size: 16px;
            font-weight: bold;
        }

        .action-buttons {
            display: flex;
            justify-content: center;
            gap: 15px;
            flex-wrap: wrap;
        }

        .btn {
            padding: 12px 30px;
            border: none;
            border-radius: 25px;
            font-size: 16px;
            font-weight: bold;
            text-transform: uppercase;
            cursor: pointer;
            text-decoration: none;
            display: inline-block;
            transition: all 0.3s ease;
        }

        .btn-secondary {
            background: #95a5a6;
            color: white;
        }

        .btn-secondary:hover {
            background: #7f8c8d;
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(127, 140, 141, 0.3);
        }

        .btn-success {
            background: #27ae60;
            color: white;
        }

        .btn-success:hover:not(.disabled) {
            background: #229954;
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(39, 174, 96, 0.3);
        }

        .btn-success.disabled {
            background: #bdc3c7;
            color: #7f8c8d;
            cursor: not-allowed;
            opacity: 0.6;
        }

        .summary-section {
            background: white;
            border-radius: 15px;
            box-shadow: 0 10px 30px rgba(0,0,0,0.1);
            padding: 30px;
            margin-bottom: 30px;
        }

        .summary-title {
            text-align: center;
            margin-bottom: 30px;
            font-size: 24px;
            font-weight: bold;
            color: #333;
            text-transform: uppercase;
            letter-spacing: 1px;
            position: relative;
        }

        .summary-title::after {
            content: '';
            position: absolute;
            bottom: -10px;
            left: 50%;
            transform: translateX(-50%);
            width: 60px;
            height: 3px;
            background: #007bff;
        }

        .summary-details {
            display: flex;
            flex-direction: column;
            gap: 15px;
        }

        .summary-row {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 10px 0;
            border-bottom: 1px solid #dee2e6;
            font-size: 16px;
        }

        .summary-row.total {
            border-bottom: none;
            font-weight: bold;
            font-size: 18px;
            color: #007bff;
        }

        @media (max-width: 768px) {
            .content {
                padding: 10px;
            }

            table {
                font-size: 12px;
            }

            th, td {
                padding: 8px;
            }

            h3 {
                font-size: 24px;
            }

            .action-buttons {
                flex-direction: column;
                align-items: center;
            }

            .btn {
                width: 100%;
                max-width: 250px;
            }
        }
        footer {
            background-color: #000;
            color: #fff;
            padding: 30px 0;
            font-family: 'Arial', sans-serif;
            width: 99.4vw;
            position: relative;
            left: 50%;
            right: 50%;
            margin-left: -50vw;
            margin-right: -50vw;
        }
        .footer-container {
            display: flex;
            justify-content: space-around;
            flex-wrap: wrap;
            max-width: 1200px;
            margin: auto;
            padding: 0 60px;
        }
        .footer-column {
            flex: 1;
            min-width: 200px;
            margin: 15px;
        }
        .footer-column h4 {
            font-size: 18px;
            margin-bottom: 15px;
            border-bottom: 2px solid #1abc9c;
            padding-bottom: 5px;
        }
        .footer-column ul {
            list-style: none;
            padding: 0;
        }
        .footer-column li {
            margin-bottom: 10px;
        }
        .footer-column a {
            color: #bdc3c7;
            text-decoration: none;
        }
        .footer-column a:hover {
            color: #fff;
        }
        .social-icons {
            margin-top: 10px;
        }
        .social-icons a {
            color: #ccc;
            font-size: 20px;
            margin-right: 15px;
        }
        .social-icons a:hover {
            color: #fff;
        }
    </style>
</head>
<body>
    <div class="top-navbar">
        <div class="left-section">
            <img src="foto/logo.jpg" alt="NERRO SUPPLY Logo" class="logo">
            <div class="site-info">
                <div class="site-name">NERRO SUPPLY</div>
                <div class="tagline">believe in miracle</div>
            </div>
        </div>
        <div class="right-section">
            <a href="keranjang_pembeli.php"><i class="fas fa-cart-plus"></i></a>
            <a href="profil_pembeli.php"><i class="fas fa-user"></i></a>
            <a href="logout.php"><i class="fas fa-sign-out-alt"></i></a>
        </div>
    </div>
    <?php $currentPage = basename($_SERVER['PHP_SELF']); ?>
    <div class="navigasi">
        <div class="hamburger" onclick="toggleMenu()">
            <div></div>
            <div></div>
            <div></div>
        </div>
        <ul class="nav-menu">
            <li><a href="dashboard_user.php" class="<?php echo ($currentPage == 'dashboard_user.php') ? 'active' : ''; ?>"><i class="fa fa-home"></i> HOME</a></li>
            <li><a href="dataproduk_user.php" class="<?php echo ($currentPage == 'dataproduk_user.php') ? 'active' : ''; ?>"><i class="fa fa-tshirt"></i> PRODUK KAMI</a></li>
            <li><a href="keranjang_pembeli.php" class="<?php echo ($currentPage == 'keranjang_pembeli.php') ? 'active' : ''; ?>"><i class="fa fa-shopping-basket"></i> KERANJANG SAYA</a></li>
            <li><a href="pesanan_pembeli.php" class="<?php echo ($currentPage == 'pesanan_pembeli.php') ? 'active' : ''; ?>"><i class="fa fa-box"></i> PESANAN SAYA</a></li>
            <li><a href="kontak_pembeli.php" class="<?php echo ($currentPage == 'kontak_pembeli.php') ? 'active' : ''; ?>"><i class="fa fa-envelope"></i> KONTAK ADMIN</a></li>
        </ul>
    </div>
<div id="overlay" onclick="toggleMenu()"></div>
<div class="content">
    <h3>Detail Pesanan</h3>
    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>Gambar Produk</th>
                <th>Nama Produk</th>
                <th>Ukuran</th>
                <th>Jumlah</th>
                <th>Subtotal</th>
            </tr>
        </thead>
        <tbody>
            <?php
            $nomor = 1;
            $total_belanja = 0;
            $id_pembayaran = mysqli_real_escape_string($host, $_GET['id_pembayaran']);
            $ambil = mysqli_query($host, "SELECT pembelian.*, tb_produk.nama_produk, tb_produk.gambar, tb_produk.harga_produk FROM pembelian JOIN tb_produk ON pembelian.id_produk=tb_produk.id_produk WHERE pembelian.id_pembayaran='$id_pembayaran'");
            while($pecah = mysqli_fetch_assoc($ambil)){
                $subharga = $pecah['harga_produk'] * $pecah['jumlah'];
                $total_belanja += $subharga;
            ?>
            <tr>
                <td><?php echo $nomor; ?></td>
                <td><img src="foto/<?php echo $pecah['gambar']; ?>" alt="Gambar Produk" class="product-image"></td>
                <td><?php echo $pecah['nama_produk']; ?></td>
                <td><?php echo $pecah['ukuran']; ?></td>
                <td><?php echo $pecah['jumlah']; ?></td>
                <td>Rp. <?php echo number_format($subharga); ?></td>
            </tr>
            <?php $nomor++; ?>
            <?php } ?>
        </tbody>
        <tfoot>
            <tr>
                <th colspan="5">Total Bayar</th>
                <th>Rp. <?php echo number_format($total_belanja); ?></th>
            </tr>
        </tfoot>
    </table>

    <?php
    $jumlah_produk_unik = mysqli_num_rows($ambil); 
    $ongkir = $jumlah_produk_unik * 10000;
    $total_akhir = $total_belanja + $ongkir;
    ?>

    <div class="summary-section">
        <div class="summary-title">Ringkasan Pembayaran</div>
        <div class="summary-details">
            <div class="summary-row">
                <span>Total Belanja:</span>
                <span>Rp. <?php echo number_format($total_belanja); ?></span>
            </div>
            <div class="summary-row">
                <span>Ongkos Kirim (<?php echo $jumlah_produk_unik; ?> produk):</span>
                <span>Rp. <?php echo number_format($ongkir); ?></span>
            </div>
            <div class="summary-row total">
                <span>Total Akhir:</span>
                <span>Rp. <?php echo number_format($total_akhir); ?></span>
            </div>
        </div>
    </div>

    <?php
    $id_pembayaran = mysqli_real_escape_string($host, $_GET['id_pembayaran']);
    $query_resi = "SELECT gambar_resi FROM pembayaran WHERE id_pembayaran='$id_pembayaran'";
    $result_resi = mysqli_query($host, $query_resi);
    $data_resi = mysqli_fetch_assoc($result_resi);
    if (!empty($data_resi['gambar_resi'])) {
        echo '<div class="summary-section">';
        echo '<div class="summary-title">Gambar Resi Pengiriman</div>';
        echo '<div style="text-align: center;">';
        echo '<img src="bukti_bayar/' . htmlspecialchars($data_resi['gambar_resi']) . '" alt="Gambar Resi" style="max-width: 300px; height: auto; border: 1px solid #ddd; border-radius: 5px;">';
        echo '</div>';
        echo '</div>';
    }
    ?>
    <?php
    $id_pembayaran = mysqli_real_escape_string($host, $_GET['id_pembayaran']);
    $ambil_status = mysqli_query($host, "SELECT * FROM pembayaran WHERE id_pembayaran = '$id_pembayaran'");
    $status_pembayaran = mysqli_fetch_assoc($ambil_status)['status_pesanan'];
    ?>

    <div class="action-buttons">
        <a href="pesanan_pembeli.php" class="btn btn-secondary">Kembali</a>
        <?php if($status_pembayaran === "pesanan dikirim"): ?>
        <form action="" method="post" style="display: inline;">
            <button type="submit" name="terima" class="btn btn-success">Konfirmasi Penerimaan Pesanan</button>
        </form>
        <?php else: ?>
        <button type="button" class="btn btn-success disabled" onclick="alert('Tombol dapat digunakan ketika pesanan telah dikirim')">Konfirmasi Penerimaan Pesanan</button>
        <?php endif ?>
    </div>
</div>
<footer>
    <div class="footer-container">
        <div class="footer-column">
            <h4>Toko Kami</h4>
            <ul>
                <li><a href="#">Tentang Kami</a></li>
                <li><a href="#">Koleksi Produk</a></li>
                <li><a href="#">Promo Spesial</a></li>
                <li><a href="#">Hubungi Kami</a></li>
            </ul>
        </div>
        <div class="footer-column">
            <h4>Bantuan</h4>
            <ul>
                <li><a href="#">Cara Pemesanan</a></li>
                <li><a href="#">Konfirmasi Pembayaran</a></li>
                <li><a href="#">Kebijakan Pengembalian</a></li>
                <li><a href="#">Syarat & Ketentuan</a></li>
            </ul>
        </div>
        <div class="footer-column">
            <h4>Ikuti Kami</h4>
            <p>Dapatkan info produk terbaru dari kami.</p>
            <div class="social-icons">
                <a href="https://www.instagram.com/nerrosupplyco?utm_source=ig_web_button_share_sheet&igsh=ZDNlZDc0MzIxNw=="><i class="fab fa-instagram"></i></a>
                <a href="https://wa.me/628979791596"><i class="fab fa-whatsapp"></i></a>
                <a href="https://www.tiktok.com/@nerrosupplyco"><i class="fab fa-tiktok"></i></a>
                <a href="https://youtube.com/@nsco.apparel?si=zLbMGDniCOlUVqQa"><i class="fab fa-youtube"></i></a>
            </div>
        </div>
    </div>
</footer>
<script>
    function toggleMenu() {
        const navMenu = document.querySelector('.nav-menu');
        navMenu.classList.toggle('show');
        const overlay = document.getElementById('overlay');
        overlay.classList.toggle('show');
    }
</script>
</body>
</html>
