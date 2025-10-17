<?php
include 'koneksi.php';
session_start();

if($_SESSION['status'] == ""){
    header("location:index.php");
    exit;
}

$username = $_SESSION['username'];
$query = "SELECT * FROM tb_user WHERE username='$username'";
$result = mysqli_query($host,$query);

if(mysqli_num_rows($result)>0){
    $data_akun = mysqli_fetch_array($result);
    $_SESSION['id_user'] = $data_akun['id_user'];
    $_SESSION['status'] = $data_akun['status'];
    $_SESSION['nama'] = $data_akun['nama'];
    $_SESSION['alamat'] = $data_akun['alamat'];
    $_SESSION['foto_profil'] = $data_akun['foto_profil'];
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Pesanan Pembeli - NERRO SUPPLY</title>
    <link rel="icon" href="foto/logo.jpg">
    <link rel="stylesheet" href="style.css" />
    <link
      rel="stylesheet"
      href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css"
    />
    <style>
        /* Navbar and navigation styles */
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
        .content{
            padding: 20px;
            margin: 10px 0 10px 0;
            background: linear-gradient(135deg, #f5f5f5, #e0e0e0 100%);
            min-height: 100vh;
            justify-content: center;
            align-items: center;

        }
        .profile-card {
            width: 90%;
            max-width: 1200px;
            margin: 20px auto;
            background: white;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0,0,0,0.1);
        }
        h2 {
            font-size: 28px;
            font-weight: bold;
            color: #333;
            text-transform: uppercase;
            letter-spacing: 2px;
            margin-bottom: 30px;
            border-bottom: 3px solid #333;
            padding-bottom: 10px;
            position: relative;
        }
        h2::after {
            content: '';
            position: absolute;
            bottom: -3px;
            left: 50%;
            transform: translateX(-50%);
            width: 50px;
            height: 3px;
            background: #333;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin: 0 auto;
            font-size: 16px;
            color: #333;
        }
        th, td {
            padding: 15px 20px;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }
        th {
            background-color: #2c3e50;
            color: white;
            font-weight: bold;
            text-transform: uppercase;
            font-size: 14px;
        }
        tr:hover {
            background-color: #f9f9f9;
        }
        th[colspan="3"] {
            text-align: center;
            background-color: transparent;
            border: none;
            padding: 20px 0 0 0;
        }
        th[colspan="3"] a {
            display: inline-block;
            padding: 10px 25px;
            background-color: #1abc9c;
            color: white;
            font-weight: bold;
            text-transform: uppercase;
            border-radius: 25px;
            text-decoration: none;
            transition: background-color 0.3s ease;
        }
        th[colspan="3"] a:hover {
            background-color: #16a085;
        }
        th[colspan="3"] a i {
            margin-right: 8px;
        }
        .badge {
            display: inline-block;
            padding: 5px 12px;
            font-size: 14px;
            font-weight: 600;
            border-radius: 15px;
            cursor: pointer;
            user-select: none;
            transition: background-color 0.3s ease;
            text-decoration: none;
            color: white;
        }
        .badge-primary {
            background-color: #1abc9c;
        }
        .badge-primary:hover {
            background-color: #16a085;
        }
        .badge-danger {
            background-color: #e74c3c;
        }
        .badge-danger:hover {
            background-color: #c0392b;
        }
        .badge-container {
            display: flex;
            flex-direction: column;
            gap: 5px;
        }
        @media (max-width: 1200px) {
            .content {
                padding: 40px 20px;
                margin: 60px auto 30px auto;
            }
            th, td {
                padding: 12px 15px;
            }
            img {
                max-width: 150px;
                margin-bottom: 25px;
            }
        }
        @media (max-width: 768px) {
            body {
                padding: 10px;
            }
            .content {
                padding: 30px 15px;
                margin: 50px auto 25px auto;
            }
            h2 {
                font-size: 24px;
                margin-bottom: 25px;
            }
            /* Convert table to card layout on mobile */
            .table-responsive {
                display: block;
                width: 100%;
            }
            table {
                display: block;
                width: 100%;
            }
            thead {
                display: none;
            }
            tbody {
                display: block;
            }
            tr {
                display: block;
                background: white;
                border: 1px solid #ddd;
                border-radius: 10px;
                margin-bottom: 15px;
                padding: 15px;
                box-shadow: 0 2px 8px rgba(0,0,0,0.1);
            }
            td {
                display: block;
                padding: 8px 0;
                border: none;
                text-align: left;
                position: relative;
            }
            td:before {
                content: attr(data-label) ": ";
                font-weight: bold;
                color: #333;
                display: inline-block;
                min-width: 120px;
            }
            .bukti_pembayaran img {
                max-width: 100px;
                margin-top: 5px;
            }
            .badge-container {
                flex-direction: row;
                gap: 10px;
                flex-wrap: wrap;
                margin-top: 10px;
            }
            .badge {
                padding: 6px 12px;
                font-size: 12px;
            }
        }
        @media (max-width: 480px) {
            .content {
                padding: 20px 10px;
                margin: 40px auto 20px auto;
            }
            h2 {
                font-size: 20px;
                margin-bottom: 20px;
            }
            table {
                font-size: 13px;
            }
            th, td {
                padding: 8px 10px;
            }
            img {
                max-width: 100px;
                margin-bottom: 15px;
            }
        }
        /* Footer styles */
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
            <img src="foto/logo.jpg" alt="NERRO SUPPLY Logo" class="logo" />
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
        <div class="profile-card">
            <h2>Pesanan Pembeli</h2>
            <table>
                <thead>
                    <tr>
                        <th>No</th>
                        <th>tanggal pesan</th>
                        <th>total bayar</th>
                        <th>metode pembayaran</th>
                        <th>Metode Pengiriman</th>
                        <th>alamat</th>
                        <th>bukti pembayaran</th>
                        <th>status pembayaran</th>
                        <th>opsi</th>
                    </tr>
                </thead>
                <tbody>
                    <!-- if it works do not touch this-->
                    <?php $nomor = 1; ?>
                    <?php
                    $ambil =  mysqli_query($host,"SELECT * FROM pembayaran WHERE id_user='$_SESSION[id_user]'");
                    ?>
                    <?php while($row = mysqli_fetch_assoc($ambil)) :  ?>
                    <tr>
                        <td data-label="No"><?php echo $nomor++; ?> </td>
                        <td data-label="Tanggal Pesan"><?php echo $row['tanggal_pembayaran']; ?></td>
                        <td data-label="Total Bayar">Rp. <?php echo number_format($row['total_belanja']); ?></td>
                        <td data-label="Metode Pembayaran"><?php echo $row['metode_pembayaran']; ?></td>
                        <td data-label="Metode Pengiriman"><?php
                            $metode = $row['metode_pengiriman'];
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
                        ?></td>
                        <td data-label="Alamat"><?php echo $row['alamat']; ?></td>
                        <td class="bukti_pembayaran" data-label="Bukti Pembayaran">
                            <?php
                            $bukti_pembayaran = $row['bukti_pembayaran'];
                            if (!empty($bukti_pembayaran) && file_exists('bukti_pembayaran/' . $bukti_pembayaran)) {
                                $ext = pathinfo($bukti_pembayaran, PATHINFO_EXTENSION);
                                if(in_array(strtolower($ext), ['jpg','jpeg','png','gif'])) : ?>
                                    <img src="bukti_pembayaran/<?php echo $bukti_pembayaran; ?>" alt="Bukti Pembayaran" style="max-width: 100px;">
                                <?php else : ?>
                                    File bukan gambar
                                <?php endif; ?>
                            <?php } else { ?>
                                Tidak ada gambar
                            <?php } ?>
                        </td>
                        <td data-label="Status Pembayaran"><?php echo $row['status_pesanan']; ?></td>
                        <td data-label="Opsi">
                            <div class="badge-container">
                                <a href="detail_pesanan_pembeli.php?id_pembayaran=<?php echo $row['id_pembayaran']; ?>" class="badge badge-primary">Detail</a>
                                <?php if ($row['status_pesanan'] === "pesanan telah diterima"): ?>
                                 <a href="struk_pembeli.php?id_pembayaran=<?php echo $row['id_pembayaran']; ?>" class="badge badge-primary">Cetak Struk</a>
                                 <?php else : ?>
                                    <span class="badge badge-primary" style="opacity: 0.5; cursor: not-allowed;" onclick="alert('Struk hanya bisa dicetak saat pesanan telah diterima'); return false;">Cetak Struk</span>
                                 <?php endif; ?>
                                <?php if($row['status_pesanan'] === "pesanan dikirim" || $row['status_pesanan'] === "pesanan telah diterima" ): ?>
                                 <span class="badge badge-danger" style="opacity: 0.5; cursor:not-allowed;" onclick="alert('Tidak dapat menghapus pada status ini'); return false;">Hapus</span>
                                 <?php else : ?>
                                 <a href="hapuspesanan_pembeli.php?id_pembayaran=<?php echo $row['id_pembayaran']; ?>" class="badge badge-danger" onclick="return confirm('Apakah Anda yakin ingin menghapus pesanan ini?')">Hapus</a>
                                <?php endif; ?>
                            </div>
                        </td>
                    </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
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
            const overlay = document.getElementById('overlay');
            nav.classList.toggle('show');
            overlay.classList.toggle('active');
        }
    </script>
</body>
</html>
