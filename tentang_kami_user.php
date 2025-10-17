<?php
include 'koneksi.php';
session_start();

if($_SESSION['status'] == ""){
    header("location:index.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Toko Baju - Tentang Kami</title>
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
            padding: 10px 10px;
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
                flex-direction: column;
                gap: 10px;
            }
        }
        .content {
            padding: 40px 20px;
            background: linear-gradient(135deg, #f5f5f5 0%, #e0e0e0 100%);
            min-height: 100vh;
        }
        .about-container {
            max-width: 1200px;
            margin: 0 auto;
            background: white;
            border-radius: 15px;
            box-shadow: 0 10px 30px rgba(0,0,0,0.1);
            overflow: hidden;
        }
        .about-header {
            background: #2c3e50;
            color: white;
            padding: 40px 30px;
            text-align: center;
        }
        .about-header h1 {
            font-size: 36px;
            margin: 0;
            font-weight: bold;
            text-transform: uppercase;
            letter-spacing: 2px;
        }
        .about-header p {
            font-size: 18px;
            margin: 10px 0 0 0;
            font-style: italic;
            color: #1abc9c;
        }
        .about-content {
            padding: 50px 40px;
        }
        .about-section {
            margin-bottom: 40px;
        }
        .about-section h2 {
            font-size: 28px;
            color: #2c3e50;
            margin-bottom: 20px;
            border-bottom: 3px solid #1abc9c;
            padding-bottom: 10px;
        }
        .about-section p {
            font-size: 16px;
            line-height: 1.6;
            color: #555;
            margin-bottom: 15px;
        }
        .social-explore {
            background: #f8f9fa;
            padding: 30px;
            border-radius: 10px;
            margin-top: 30px;
        }
        .social-explore h3 {
            color: #2c3e50;
            margin-bottom: 20px;
            text-align: center;
        }
        .social-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 20px;
            margin-top: 20px;
        }
        .social-card {
            background: white;
            padding: 20px;
            border-radius: 10px;
            text-align: center;
            box-shadow: 0 4px 15px rgba(0,0,0,0.1);
            transition: transform 0.3s ease;
        }
        .social-card:hover {
            transform: translateY(-5px);
        }
        .social-card i {
            font-size: 40px;
            margin-bottom: 15px;
        }
        .social-card .fa-instagram { color: #E4405F; }
        .social-card .fa-whatsapp { color: #25D366; }
        .social-card .fa-tiktok { color: #000000; }
        .social-card .fa-youtube { color: #FF0000; }
        .social-card h4 {
            margin: 10px 0;
            color: #2c3e50;
        }
        .social-card p {
            color: #777;
            font-size: 14px;
        }
        .social-card a {
            display: inline-block;
            margin-top: 15px;
            padding: 10px 20px;
            background: #1abc9c;
            color: white;
            text-decoration: none;
            border-radius: 25px;
            transition: background 0.3s ease;
        }
        .social-card a:hover {
            background: #16a085;
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
        @media (max-width: 768px) {
            .about-content {
                padding: 30px 20px;
            }
            .about-header h1 {
                font-size: 28px;
            }
            .social-grid {
                grid-template-columns: 1fr;
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
<div id="overlay" onclick="toggleMenu()"></div>
<div class="content">
    <div class="about-container">
        <div class="about-header">
            <h1>Tentang Kami</h1>
            <p>NERRO SUPPLY - Believe in Miracle</p>
        </div>
        <div class="about-content">
            <div class="about-section">
                <h2>Siapa Kami?</h2>
                <p>NERRO SUPPLY adalah brand fashion yang berkomitmen untuk menghadirkan produk berkualitas tinggi dengan desain yang unik dan stylish. Kami percaya bahwa fashion bukan hanya tentang penampilan, tetapi juga tentang ekspresi diri dan kepercayaan diri.</p>
                <p>Dengan tagline "Believe in Miracle", kami ingin menginspirasi setiap orang untuk percaya pada kemungkinan-kemungkinan baru dalam hidup mereka melalui fashion yang kami hadirkan.</p>
            </div>

            <div class="about-section">
                <h2>Visi Kami</h2>
                <p>Menjadi brand fashion terdepan yang menginspirasi generasi muda untuk berani berkreasi dan mengekspresikan diri melalui pakaian yang berkualitas dan terjangkau.</p>
            </div>

            <div class="about-section">
                <h2>Misi Kami</h2>
                <ul>
                    <li>Menyediakan produk fashion berkualitas dengan harga terjangkau</li>
                    <li>Mengikuti tren fashion terkini dengan sentuhan kreativitas</li>
                    <li>Membangun komunitas fashion yang positif dan inspiratif</li>
                    <li>Menjaga kepuasan pelanggan sebagai prioritas utama</li>
                </ul>
            </div>

            <div class="about-section">
                <h2>Koleksi Produk Kami</h2>
                <p>Kami menawarkan berbagai macam produk fashion mulai dari kaos, hoodie, jaket, hingga aksesoris lainnya. Setiap produk dirancang dengan detail dan menggunakan bahan berkualitas untuk kenyamanan maksimal.</p>
            </div>

            <div class="social-explore">
                <h3>Jelajahi Dunia NERRO SUPPLY</h3>
                <p>Untuk mendapatkan informasi terbaru tentang produk, promo, dan kegiatan kami, kunjungi media sosial kami. Temukan konten eksklusif, behind the scenes, dan inspirasi fashion terbaru!</p>

                <div class="social-grid">
                    <div class="social-card">
                        <i class="fab fa-instagram"></i>
                        <h4>Instagram</h4>
                        <p>Lihat koleksi terbaru, tips fashion, dan cerita di balik layar NERRO SUPPLY</p>
                        <a href="https://www.instagram.com/nerrosupplyco?utm_source=ig_web_button_share_sheet&igsh=ZDNlZDc0MzIxNw==" target="_blank">Kunjungi Instagram</a>
                    </div>

                    <div class="social-card">
                        <i class="fab fa-whatsapp"></i>
                        <h4>WhatsApp</h4>
                        <p>Hubungi kami untuk informasi produk, pesanan, dan layanan pelanggan</p>
                        <a href="https://wa.me/0897-9791-596" target="_blank">Chat WhatsApp</a>
                    </div>

                    <div class="social-card">
                        <i class="fab fa-tiktok"></i>
                        <h4>TikTok</h4>
                        <p>Tonton video fashion terbaru, tutorial style, dan konten menarik lainnya</p>
                        <a href="https://www.tiktok.com/@nerrosupplyco" target="_blank">Kunjungi TikTok</a>
                    </div>

                    <div class="social-card">
                        <i class="fab fa-youtube"></i>
                        <h4>YouTube</h4>
                        <p>Tonton review produk, unboxing, dan konten fashion edukatif</p>
                        <a href="https://youtube.com/@nsco.apparel?si=zLbMGDniCOlUVqQa" target="_blank">Kunjungi YouTube</a>
                    </div>
                </div>
            </div>
        </div>
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
        const nav = document.querySelector('.nav-menu');
        nav.classList.toggle('active');
    }
</script>
</body>
</html>
