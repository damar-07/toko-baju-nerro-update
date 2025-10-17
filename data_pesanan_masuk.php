<?php
include 'koneksi.php';
session_start();

if($_SESSION['status'] == ""){
    header("location:index.php");
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Data Pesanan Masuk Admin</title>
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
        .section-title {
            text-align: center;
            margin: 40px 0 30px 0;
            font-size: 28px;
            font-weight: bold;
            color: #333;
            text-transform: uppercase;
            letter-spacing: 2px;
            border-bottom: 3px solid #333;
            padding-bottom: 10px;
            position: relative;
        }

        .section-title::after {
            content: '';
            position: absolute;
            bottom: -3px;
            left: 50%;
            transform: translateX(-50%);
            width: 50px;
            height: 3px;
            background: #333;
        }

        .table-container {
            background: white;
            border-radius: 15px;
            box-shadow: 0 8px 25px rgba(0,0,0,0.1);
            overflow: hidden;
            margin: 20px 0;
            overflow-x: auto;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        thead {
            background: #2c3e50;
            color: white;
        }

        th, td {
            padding: 15px;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }

        th {
            font-weight: bold;
            text-transform: uppercase;
            font-size: 14px;
        }

        tbody tr:hover {
            background: #f9f9f9;
        }

        .bukti-bayar img {
            max-width: 80px;
            max-height: 80px;
            object-fit: cover;
            border-radius: 5px;
        }

        .badge {
            display: inline-block;
            padding: 5px 10px;
            border-radius: 20px;
            text-decoration: none;
            font-size: 12px;
            font-weight: bold;
            text-transform: uppercase;
            margin: 2px;
            transition: all 0.3s ease;
        }

        .badge-primary {
            background: #007bff;
            color: white;
        }

        .badge-primary:hover {
            background: #0056b3;
        }

        .badge-success {
            background: #28a745;
            color: white;
        }

        .badge-success:hover {
            background: #218838;
        }

        .badge-danger {
            background: #dc3545;
            color: white;
        }

        .badge-danger:hover {
            background: #c82333;
        }

        /* Card layout for mobile */
        .card-container {
            display: none;
            grid-template-columns: repeat(auto-fill, minmax(320px, 1fr));
            gap: 20px;
            margin: 20px 0;
        }

        .card {
            background: white;
            border-radius: 15px;
            box-shadow: 0 8px 25px rgba(0,0,0,0.1);
            padding: 20px;
            transition: transform 0.3s ease;
            border: 1px solid #e1e8ed;
        }

        .card:hover {
            transform: translateY(-5px);
            box-shadow: 0 12px 35px rgba(0,0,0,0.15);
        }

        .card-item {
            margin-bottom: 12px;
            padding: 8px 12px;
            border-bottom: 1px solid #f0f0f0;
            border-radius: 6px;
            background: #fafbfc;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .card-item:last-child {
            border-bottom: none;
            margin-bottom: 0;
        }

        .card-label {
            font-weight: bold;
            color: #2c3e50;
            font-size: 13px;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .card-value {
            color: #333;
            font-size: 14px;
            text-align: right;
            flex: 1;
            margin-left: 10px;
        }

        .card-img {
            max-width: 100%;
            max-height: 120px;
            object-fit: cover;
            border-radius: 8px;
            margin-top: 10px;
            border: 2px solid #e1e8ed;
        }

        .card-actions {
            margin-top: 20px;
            display: flex;
            gap: 8px;
            flex-wrap: wrap;
            padding-top: 15px;
            border-top: 2px solid #e1e8ed;
        }

        /* Responsive Design */
        @media (max-width: 1200px) {
            .content {
                padding: 80px 10px 40px;
            }
            th, td {
                padding: 10px;
            }
            .bukti-bayar img {
                max-width: 60px;
                max-height: 60px;
            }
        }

        @media (max-width: 768px) {
            body {
                padding: 10px;
            }
            .content {
                padding: 80px 5px 40px;
            }
            .section-title {
                font-size: 24px;
                margin: 30px 0 20px 0;
            }
            table {
                font-size: 14px;
            }
            th, td {
                padding: 8px;
            }
            .bukti-bayar img {
                max-width: 50px;
                max-height: 50px;
            }
            .badge {
                padding: 4px 8px;
                font-size: 11px;
            }
        }

        @media (max-width: 480px) {
            .section-title {
                font-size: 20px;
                margin: 25px 0 15px 0;
            }
            .table-container {
                display: none;
            }
            .card-container {
                display: grid;
            }
            .top-navbar {
                padding: 10px 15px;
            }
            .top-navbar .site-info .site-name {
                font-size: 18px;
            }
            .top-navbar .site-info .tagline {
                font-size: 10px;
            }
            .navigasi ul {
                gap: 15px;
            }
            .navigasi a {
                padding: 8px 15px;
                font-size: 14px;
            }
            .content {
                padding: 80px 10px 40px;
            }
            .footer-container {
                padding: 0 20px;
            }
            .footer-column {
                min-width: 150px;
            }
        }
        footer {
            background-color: #000;
            color: #fff;
            padding: 30px 0;
            font-family: 'Arial', sans-serif;
            width: 100vw;
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
    <div class="section-title">Data Pesanan Masuk</div>
    <div style="text-align: center; margin-bottom: 20px;">
        <a href="export_laporan.php?export=excel" class="badge" style="background-color: #28a745; color: white; padding: 10px 20px; text-decoration: none; border-radius: 5px;">Export ke Excel</a>
    </div>
    <div class="table-container">
        <table>
            <thead>
                <tr>
                    <th>No.</th>
                    <th>Nama Pembeli</th>
                    <th>Nomor Telepon</th>
                    <th>Tanggal Pemesanan</th>
                    <th>Harga Produk</th>
                    <th>Alamat</th>
                    <th>Bukti Pembayaran</th>
                    <th>Metode Pengiriman</th>
                    <th>Status Pesanan</th>
                    <th>Opsi</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $nomor = 1;
                $ambil = mysqli_query($host, "SELECT * FROM pembayaran");
                $result = mysqli_fetch_all($ambil, MYSQLI_ASSOC);
                ?>
                <?php foreach($result as $row) : ?>
                <tr>
                    <td><?php echo $nomor; ?></td>
                    <td><?php echo $row['nama']; ?></td>
                    <td><?php echo $row['nomor_telepon']; ?></td>
                    <td><?php echo $row['tanggal_pembayaran']; ?></td>
                    <td>Rp <?php echo number_format($row['total_belanja'], 0, ',', '.'); ?></td>
                    <td><?php echo $row['alamat']; ?></td>
                    <td class="bukti-bayar">
                        <img src="bukti_pembayaran/<?php echo $row['bukti_pembayaran']; ?>" alt="bukti transaksi">
                    </td>
                    <td><?php
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
                    <td><?php echo $row['status_pesanan']; ?></td>
                    <td>
                        <a href="detail_pesanan.php?id_pembayaran=<?php echo $row['id_pembayaran']; ?>" class="badge badge-primary">detail</a>
                        <a href="struk.php?id_pembayaran=<?php echo $row['id_pembayaran']; ?>" class="badge">struk</a>
                        <a href="hapus_pesanan.php?id_pembayaran=<?php echo $row['id_pembayaran']; ?>" class="badge badge-danger">hapus</a>
                    </td>
                </tr>
                <?php $nomor++; ?>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>

    <!-- Card layout for mobile -->
    <div class="card-container">
        <?php
        $nomor = 1;
        foreach($result as $row) :
        ?>
        <div class="card">
            <div class="card-item">
                <span class="card-label">No:</span>
                <span class="card-value"><?php echo $nomor; ?></span>
            </div>
            <div class="card-item">
                <span class="card-label">Nama Produk:</span>
                <span class="card-value"><?php echo $row['nama']; ?></span>
            </div>
            <div class="card-item">
                <span class="card-label">Nomor Telepon:</span>
                <span class="card-value"><?php echo $row['nomor_telepon']; ?></span>
            </div>
            <div class="card-item">
                <span class="card-label">Tanggal Pemesanan:</span>
                <span class="card-value"><?php echo $row['tanggal_pembayaran']; ?></span>
            </div>
            <div class="card-item">
                <span class="card-label">Harga Produk:</span>
                <span class="card-value">Rp <?php echo number_format($row['total_belanja'], 0, ',', '.'); ?></span>
            </div>
            <div class="card-item">
                <span class="card-label">Alamat:</span>
                <span class="card-value"><?php echo $row['alamat']; ?></span>
            </div>
            <div class="card-item">
                <span class="card-label">Bukti Pembayaran:</span>
                <img src="bukti_pembayaran/<?php echo $row['bukti_pembayaran']; ?>" alt="bukti transaksi" class="card-img">
            </div>
            <div class="card-item">
                <span class="card-label">Metode Pengiriman:</span>
                <span class="card-value"><?php
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
                ?></span>
            </div>
            <div class="card-item">
                <span class="card-label">Status Pesanan:</span>
                <span class="card-value"><?php echo $row['status_pesanan']; ?></span>
            </div>
            <div class="card-actions">
                <a href="detail_pesanan.php?id_pembayaran=<?php echo $row['id_pembayaran']; ?>" class="badge badge-primary">detail</a>
                <a href="struk.php?id_pembayaran=<?php echo $row['id_pembayaran']; ?>" class="badge badge-success">struk</a>
                <a href="hapus_pesanan.php?id_pembayaran=<?php echo $row['id_pembayaran']; ?>" class="badge badge-danger">hapus</a>
            </div>
        </div>
        <?php $nomor++; ?>
        <?php endforeach; ?>
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
        const nav = document.querySelector('.navigasi ul');
        const overlay = document.getElementById('overlay');
        nav.classList.toggle('show');
        overlay.classList.toggle('show');
    }
</script>
</body>
</html>
