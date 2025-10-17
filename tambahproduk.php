<?php
include 'koneksi.php';
session_start();

if($_SESSION['status'] ==""){
    header("location:index.php");
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Toko Baju - Tambah Produk</title>
    <link rel="stylesheet" href="style.css">
    <link rel="icon" href="foto/logo.jpg">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
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
            background-color: #2c3e50;
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
            background-color: white;
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
            color: white;
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
                position: absolute;
                top: 100%;
                left: 0;
                width: 100%;
                flex-direction: column;
                background-color: #2c3e50;
                padding: 10px 0;
                border-radius: 0 0 15px 15px;
                display: none;
                gap: 10px;
            }
            .navigasi .hamburger {
                display: flex;
            }
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
        .content {
            padding: 0;
            margin:40px 0 10px 0;
            background: linear-gradient(135deg, #f5f5f5 0%, #e0e0e0 100%);
            min-height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
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
        /* Form styles */
        .container {
            max-width: 600px;
            margin: 0 auto;
            background: white;
            border: 1px solid #ddd;
            padding: 30px;
            border-radius: 15px;
            box-shadow: 0 8px 25px rgba(0,0,0,0.1);
            width: 100%;
        }
        h3 {
            text-align: center;
            margin-bottom: 20px;
            font-weight: bold;
            text-transform: uppercase;
            letter-spacing: 2px;
            color: #2c3e50;
        }
        form {
            display: flex;
            flex-direction: column;
            gap: 15px;
        }
        label {
            font-weight: bold;
            margin-bottom: 5px;
            display: block;
            color: #2c3e50;
        }
        input[type="text"],
        input[type="number"],
        select,
        input[type="file"] {
            width: 100%;
            padding: 10px;
            border: 1px solid #ddd;
            border-radius: 5px;
            background: #fff;
            color: #000;
            font-size: 16px;
            box-sizing: border-box;
        }
        input[type="file"] {
            padding: 5px 10px;
        }
        .button-container {
            display: flex;
            justify-content: flex-end;
            gap: 10px;
            margin-top: 20px;
        }
        input[type="submit"],
        input[type="reset"],
        input[type="button"] {
            background-color: #1abc9c;
            color: white;
            border: none;
            padding: 12px 20px;
            border-radius: 5px;
            cursor: pointer;
            font-weight: bold;
            text-transform: uppercase;
            letter-spacing: 1px;
            transition: background-color 0.3s ease;
        }
        input[type="submit"]:hover,
        input[type="reset"]:hover,
        input[type="button"]:hover {
            background-color: #16a085;
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
        <a href="profil-admin.php"><i class="fas fa-user"></i></a>
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
        <li><a href="dashboard_admin.php" class="<?php echo ($currentPage == 'dashboard_admin.php') ? 'active' : ''; ?>"><i class="fas fa-home"></i> HOME</a></li>
        <li><a href="tambahproduk.php" class="<?php echo ($currentPage == 'tambahproduk.php') ? 'active' : ''; ?>"><i class="fas fa-plus"></i> TAMBAH PRODUK</a></li>
        <li><a href="dataproduk_admin.php" class="<?php echo ($currentPage == 'dataproduk_admin.php') ? 'active' : ''; ?>"><i class="fas fa-box"></i> EDIT PRODUK</a></li>
        <li><a href="data_pesanan_masuk.php" class="<?php echo ($currentPage == 'data_pesanan_masuk.php') ? 'active' : ''; ?>"><i class="fas fa-list"></i> PESANAN MASUK</a></li>
        <li><a href="pesan_masuk.php" class="<?php echo ($currentPage == 'pesan_masuk.php') ? 'active' : ''; ?>"><i class="fas fa-envelope"></i> PESAN MASUK</a></li>
    </ul>
</div>
<div id="overlay" onclick="toggleMenu()"></div>
<div class="content">
    <div class="container">
        <h3>Tambah Produk</h3>
        <form action="simpandata_produk.php" method="post" enctype="multipart/form-data">
            <label for="nama_produk">Nama Produk</label>
            <input type="text" id="nama_produk" name="nama_produk" placeholder="Masukkan nama baju" required>

            <label for="jenis_baju">Jenis Baju</label>
            <select id="jenis_baju" name="jenis_baju" required>
                <option value="">Pilih Jenis Baju</option>
                <option value="pria">Pria</option>
                <option value="wanita">Wanita</option>
            </select>

            <label for="kategori">Kategori</label>
            <select id="kategori" name="kategori" required>
                <option value="">Pilih Kategori</option>
                <option value="KAOS">KAOS</option>
                <option value="HOODIE">HOODIE</option>
                <option value="JAKET">JAKET</option>
                <option value="TOPI">TOPI</option>
                <option value="CELANA">CELANA</option>
                <option value="KAOS_KAKI">KAOS_KAKI</option>
            </select>

            <label for="deskripsi">Deskripsi</label>
            <input type="text" id="deskripsi" name="deskripsi" placeholder="Masukkan deskripsi baju" required>

            <label for="ukuran">Ukuran</label>
            <input type="text" id="ukuran" name="ukuran" placeholder="Ukuran tersedia, pisahkan dengan koma (contoh: S,M,L,XL)" required>

            <label for="stok">Stok</label>
            <input type="number" id="stok" name="stok" placeholder="Masukkan jumlah stok" required>

            <label for="harga_produk">Harga</label>
            <input type="number" id="harga_produk" name="harga_produk" placeholder="Masukkan harga baju" required>

            <label for="gambar">Gambar</label>
            <input type="file" id="gambar" name="gambar" required>

            <label for="gambar_hover">Gambar Hover</label>
            <input type="file" id="gambar_hover" name="gambar_hover" required>

            <div class="button-container">
                <input type="submit" name="tambah" value="Tambah">
                <input type="reset" value="Reset">
                <a href="dashboard_admin.php"><input type="button" value="Kembali"></a>
            </div>
        </form>
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
        overlay.classList.toggle('active');
    }
</script>
</body>
</html>
