<?php
session_start();

if($_SESSION['status'] == "") {
    header("location:index.php");
    exit();
}

include 'koneksi.php';

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
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Toko Baju - Kontak Admin</title>
    <link rel="icon" href="foto/logo.jpg">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="style.css">
    <style>
        *{
            scroll-behavior: smooth;
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
        footer {
            background-color: #000;
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

        .container {
            max-width: 800px;
            margin: 30px auto;
            background: white;
            border-radius: 15px;
            box-shadow: 0 10px 30px rgba(0,0,0,0.1);
            overflow: hidden;
        }

        .page-header {
            background: #2c3e50;
            color: white;
            padding: 20px;
            text-align: center;
            font-size: 24px;
            font-weight: bold;
            text-transform: uppercase;
            letter-spacing: 1px;
        }

        .contact-content {
            padding: 30px;
        }

        .contact-info {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 20px;
            margin-bottom: 30px;
        }

        .info-item {
            text-align: center;
            padding: 20px;
            background: #f8f9fa;
            border-radius: 10px;
        }

        .info-icon {
            font-size: 40px;
            color: #007bff;
            margin-bottom: 10px;
        }

        .info-title {
            font-weight: bold;
            margin-bottom: 5px;
            color: #333;
        }

        .info-text {
            color: #666;
            font-size: 14px;
        }

        .contact-form {
            background: #f8f9fa;
            padding: 30px;
            border-radius: 10px;
        }

        .form-group {
            margin-bottom: 20px;
        }

        .form-group label {
            display: block;
            margin-bottom: 5px;
            font-weight: bold;
            color: #333;
        }

        .form-group input,
        .form-group textarea {
            width: 100%;
            padding: 12px;
            border: 2px solid #ddd;
            border-radius: 5px;
            font-size: 16px;
            box-sizing: border-box;
        }

        .form-group textarea {
            height: 120px;
            resize: vertical;
        }

        .submit-btn {
            background: #007bff;
            color: white;
            padding: 15px 30px;
            border: none;
            border-radius: 25px;
            font-size: 16px;
            font-weight: bold;
            text-transform: uppercase;
            cursor: pointer;
            transition: all 0.3s ease;
            display: block;
            margin: 0 auto;
        }

        .submit-btn:hover {
            background: #0056b3;
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(0, 123, 255, 0.3);
        }

        @media (max-width: 768px) {
            body {
                padding: 10px;
            }

            .contact-content {
                padding: 20px;
            }

            .contact-info {
                grid-template-columns: 1fr;
            }

            .contact-form {
                padding: 20px;
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
    <div class="container">
        <div class="page-header">Hubungi Admin</div>
        <div class="contact-content">

            <!-- Message History -->
            <div class="message-history" style="margin-bottom: 30px;">
                <h3 style="color: #333; margin-bottom: 20px;">Riwayat Pesan</h3>
                <?php
                $id_user = $_SESSION['id_user'];
                $query_pesan = "SELECT k.*, b.balasan, b.tanggal_balasan
                               FROM kontak k
                               LEFT JOIN balasan_kontak b ON k.id_kontak = b.id_kontak
                               WHERE k.id_user = '$id_user'
                               ORDER BY k.tanggal_kirim DESC";
                $result_pesan = mysqli_query($host, $query_pesan);

                if(mysqli_num_rows($result_pesan) > 0) {
                    while($pesan = mysqli_fetch_assoc($result_pesan)) {
                        $status_color = $pesan['status'] == 'belum_dibaca' ? '#ffc107' :
                                       ($pesan['status'] == 'sudah_dibaca' ? '#17a2b8' : '#28a745');
                        ?>
                        <div class="message-item" style="background: #f8f9fa; padding: 20px; margin-bottom: 15px; border-radius: 10px; border-left: 5px solid <?php echo $status_color; ?>">
                            <div class="message-header" style="display: flex; justify-content: space-between; margin-bottom: 10px;">
                                <strong><?php echo htmlspecialchars($pesan['subjek']); ?></strong>
                                <span style="color: #666; font-size: 12px;"><?php echo date('d-m-Y H:i', strtotime($pesan['tanggal_kirim'])); ?></span>
                            </div>
                            <div class="message-content" style="margin-bottom: 10px;">
                                <p><strong>Pesan Anda:</strong> <?php echo nl2br(htmlspecialchars($pesan['pesan'])); ?></p>
                            </div>
                            <?php if($pesan['balasan']) { ?>
                                <div class="admin-reply" style="background: #e9ecef; padding: 15px; border-radius: 5px; margin-top: 10px;">
                                    <p><strong>Balasan Admin (<?php echo date('d-m-Y H:i', strtotime($pesan['tanggal_balasan'])); ?>):</strong></p>
                                    <p><?php echo nl2br(htmlspecialchars($pesan['balasan'])); ?></p>
                                </div>
                            <?php } else { ?>
                                <div class="no-reply" style="color: #666; font-style: italic;">
                                    Belum ada balasan dari admin
                                </div>
                            <?php } ?>
                        </div>
                        <?php
                    }
                } else {
                    echo '<p style="text-align: center; color: #666; font-style: italic;">Belum ada pesan yang dikirim</p>';
                }
                ?>
            </div>

            <!-- Contact Form -->
            <div class="contact-form">
                <h3 style="text-align: center; margin-bottom: 20px; color: #333;">Kirim Pesan Baru</h3>
                <form action="kirim_pesan.php" method="post">
                    <div class="form-group">
                        <label for="nama">Nama Lengkap</label>
                        <input type="text" id="nama" name="nama" value="<?php echo $data_akun['nama'] ?? ''; ?>" required>
                    </div>
                    <div class="form-group">
                        <label for="subjek">Subjek</label>
                        <input type="text" id="subjek" name="subjek" required>
                    </div>
                    <div class="form-group">
                        <label for="pesan">Pesan</label>
                        <textarea id="pesan" name="pesan" required placeholder="Tuliskan pesan Anda di sini..."></textarea>
                    </div>
                    <button type="submit" name="kirim" class="submit-btn">Kirim Pesan</button>
                </form>
            </div>
        </div>
    </div>
<div id="overlay" onclick="toggleMenu()"></div>
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
    const menu = document.querySelector('.nav-menu');
    const overlay = document.getElementById('overlay');
    menu.classList.toggle('show');
    overlay.classList.toggle('show');
}
    </script>
</body>
</html>
