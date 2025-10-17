<?php
include 'koneksi.php';
session_start();

if($_SESSION['status'] == ""){
    header("location:index.php?pesan=gagal");
}

$id_produk = $_GET['id_produk'];
$query = "SELECT * FROM tb_produk WHERE id_produk = '$id_produk'";
$result = mysqli_query($host, $query);
$data = mysqli_fetch_array($result);

if(!$data){
    echo "<script>alert('Produk tidak ditemukan'); location='dataproduk_user.php';</script>";
    exit;
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Detail Produk - <?php echo $data['nama_produk']; ?></title>
    <link rel="stylesheet" href="style.css" />
    <link rel="icon" href="foto/logo.jpg">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        body {
            font-family: 'Arial', sans-serif;
            background: #f8f9fa;
            margin: 0;
            padding: 0;
            color: #333;
        }
        /* Updated header and navigation styles */
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
        @media (max-width: 768px) {
            .navigasi ul {
                flex-direction: column;
                gap: 10px;
            }
        }
        footer {
            background-color: #000000ff;
            color: #fff;
            padding: 40px 60px;
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

        .breadcrumb {
            max-width: 1200px;
            margin: 20px auto 20px;
            padding: 0 20px;
            font-size: 14px;
            color: #666;
        }

        .breadcrumb a {
            color: #007bff;
            text-decoration: none;
        }

        .main-container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 0 20px;
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 50px;
            background: white;
            border-radius: 10px;
            overflow: hidden;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
        }

        .product-gallery {
            padding: 40px;
        }

        .main-image {
            width: 100%;
            height: 500px;
            object-fit: cover;
            border-radius: 10px;
            margin-bottom: 20px;
        }

        .product-info-section {
            padding: 40px;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
        }

        .product-title {
            font-size: 32px;
            font-weight: bold;
            color: #333;
            margin-bottom: 10px;
            line-height: 1.2;
        }

        .product-price {
            font-size: 28px;
            font-weight: bold;
            color: #007bff;
            margin-bottom: 30px;
        }

        .size-section {
            margin-bottom: 30px;
        }

        .size-section label {
            display: block;
            font-weight: bold;
            margin-bottom: 10px;
            color: #333;
            font-size: 16px;
        }

        .size-selector {
            display: flex;
            gap: 10px;
            margin-bottom: 20px;
        }

        .size-btn {
            padding: 12px 20px;
            border: 2px solid #ddd;
            background: white;
            border-radius: 5px;
            cursor: pointer;
            transition: all 0.3s ease;
            font-weight: 500;
        }

        .size-btn:hover,
        .size-btn.active {
            border-color: #007bff;
            background: #007bff;
            color: white;
        }

        .add-to-cart-section {
            margin-bottom: 40px;
        }

        .add-to-cart-btn {
            background: #000;
            color: white;
            padding: 18px 40px;
            border: none;
            border-radius: 5px;
            font-size: 16px;
            font-weight: bold;
            text-transform: uppercase;
            letter-spacing: 1px;
            cursor: pointer;
            transition: all 0.3s ease;
            width: 100%;
            margin-bottom: 20px;
        }

        .add-to-cart-btn:hover {
            background: #333;
        }

        .stock-info {
            display: flex;
            align-items: center;
            gap: 10px;
            margin-bottom: 20px;
            color: #28a745;
            font-weight: 500;
        }

        .shipping-info {
            background: #f8f9fa;
            padding: 20px;
            border-radius: 5px;
            margin-bottom: 30px;
        }

        .shipping-title {
            font-weight: bold;
            margin-bottom: 10px;
            color: #333;
        }

        .description-section {
            grid-column: 1 / -1;
            padding: 40px;
            border-top: 1px solid #eee;
        }

        .description-title {
            font-size: 24px;
            font-weight: bold;
            margin-bottom: 20px;
            color: #333;
        }

        .description-text {
            line-height: 1.6;
            color: #555;
            font-size: 16px;
        }

        .footer-info {
            grid-column: 1 / -1;
            padding: 20px 40px;
            background: #f8f9fa;
            text-align: center;
            color: #666;
            font-size: 14px;
        }

        .back-btn {
            background: #6c757d;
            color: white;
            padding: 12px 24px;
            border: none;
            border-radius: 5px;
            font-weight: bold;
            cursor: pointer;
            transition: background-color 0.3s ease;
            margin-top: 20px;
        }

        .back-btn:hover {
            background: #5a6268;
        }

        @media (max-width: 768px) {
            .main-container {
                grid-template-columns: 1fr;
                gap: 20px;
                padding: 10px;
            }

            .product-gallery,
            .product-info-section,
            .description-section {
                padding: 20px;
            }

            .product-title {
                font-size: 24px;
            }

            .product-price {
                font-size: 22px;
            }

            .size-selector {
                flex-wrap: wrap;
            }

            .add-to-cart-btn {
                padding: 15px 30px;
            }
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
        <ul class="nav-menu">
            <li><a href="dashboard_user.php" class="<?php echo ($currentPage == 'dashboard_user.php') ? 'active' : ''; ?>"><i class="fa fa-home"></i> HOME</a></li>
            <li><a href="dataproduk_user.php" class="<?php echo ($currentPage == 'dataproduk_user.php') ? 'active' : ''; ?>"><i class="fa fa-tshirt"></i> PRODUK KAMI</a></li>
            <li><a href="keranjang_pembeli.php" class="<?php echo ($currentPage == 'keranjang_pembeli.php') ? 'active' : ''; ?>"><i class="fa fa-shopping-basket"></i> KERANJANG SAYA</a></li>
            <li><a href="pesanan_pembeli.php" class="<?php echo ($currentPage == 'pesanan_pembeli.php') ? 'active' : ''; ?>"><i class="fa fa-box"></i> PESANAN SAYA</a></li>
            <li><a href="kontak_pembeli.php" class="<?php echo ($currentPage == 'kontak_pembeli.php') ? 'active' : ''; ?>"><i class="fa fa-envelope"></i> KONTAK ADMIN</a></li>
        </ul>
    </div>
    <div class="breadcrumb">
        <a href="dataproduk_user.php">Produk</a> > <span><?php echo $data['kategori']; ?></span>
    </div>

    <div class="main-container">
        <div class="product-gallery">
            <img src="foto/<?php echo $data['gambar']; ?>" alt="<?php echo $data['nama_produk']; ?>" class="main-image" />
        </div>

        <div class="product-info-section">
            <div>
                <h1 class="product-title"><?php echo $data['nama_produk']; ?></h1>
                <div class="product-price">Rp <?php echo number_format($data['harga_produk'], 0, ',', '.'); ?></div>

                <?php if(!empty($data['ukuran'])): ?>
                <div class="size-section">
                    <label>Pilih Ukuran:</label>
                    <div class="size-selector">
                        <?php
                        $sizes = explode(',', $data['ukuran']);
                        foreach($sizes as $size) {
                            $size = trim($size);
                            echo "<button type='button' class='size-btn' onclick='selectSize(\"$size\")'>$size</button>";
                        }
                        ?>
                    </div>
                    <input type="hidden" id="selected_ukuran" name="ukuran" value="" />
                </div>
                <?php endif; ?>

                <div class="add-to-cart-section">
                    <button type="submit" class="add-to-cart-btn" onclick="addToCart()">Tambah ke Keranjang</button>
                </div>

                <div class="stock-info">
                    <i class="fas fa-check-circle"></i>
                    <span>Stok Tersedia: <?php echo $data['stok']; ?> pcs</span>
                </div>

                <div class="shipping-info">
                    <div class="shipping-title">Pengiriman & Pengembalian</div>
                    <p>Pengiriman seluruh Indonesia. Pengembalian dalam 7 hari jika produk tidak sesuai.</p>
                </div>

                <div style="margin-top: 20px;">
                    <span style="font-weight: bold; color: #333;">Jenis Baju:</span> <?php echo ucfirst($data['jenis_baju']); ?><br>
                    <span style="font-weight: bold; color: #333;">Kategori:</span> <?php echo $data['kategori']; ?>
                </div>
            </div>

            <form id="cartForm" action="pembelian.php" method="get" style="display: none;">
                <input type="hidden" name="id_produk" value="<?php echo $data['id_produk']; ?>" />
                <input type="hidden" name="ukuran" id="form_ukuran" value="" />
            </form>
        </div>

        <div class="description-section">
            <h2 class="description-title">Deskripsi Produk</h2>
            <div class="description-text">
                <?php echo $data['deskripsi']; ?>
            </div>
        </div>

        <div class="footer-info">
            <button class="back-btn" onclick="window.history.back()">Kembali</button>
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
        let selectedSize = '';

        function selectSize(size) {
            document.querySelectorAll('.size-btn').forEach(btn => btn.classList.remove('active'));
            event.target.classList.add('active');
            selectedSize = size;
            document.getElementById('selected_ukuran').value = size;
            document.getElementById('form_ukuran').value = size;
        }

        function addToCart() {
            <?php if(!empty($data['ukuran'])): ?>
            if (!selectedSize) {
                alert('Silakan pilih ukuran terlebih dahulu');
                return false;
            }
            <?php endif; ?>
            document.getElementById('cartForm').submit();
        }

        // Set default if no sizes
        <?php if(empty($data['ukuran'])): ?>
        document.getElementById('cartForm').submit();
        <?php endif; ?>
    </script>
</body>
</html>
