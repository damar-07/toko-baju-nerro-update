<?php
session_start();
include 'koneksi.php';

if($_SESSION['status'] == ""){
    header("location:indek.php?pesan='gagal'");
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Toko Baju - Detail Pesanan</title>
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
            padding: 80px 20px 40px;
            background: linear-gradient(135deg, #f5f5f5 0%, #e0e0e0 100%);
            min-height: 100vh;
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
        /* Table styles */
        .container {
            max-width: 1200px;
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
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }
        th, td {
            padding: 12px;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }
        th {
            background-color: #2c3e50;
            color: white;
            font-weight: bold;
        }
        tr:hover {
            background-color: #f5f5f5;
        }
        img {
            max-width: 100px;
            height: auto;
        }
        .button-container {
            display: flex;
            justify-content: flex-end;
            gap: 10px;
            margin-top: 20px;
        }
        .button {
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
            text-decoration: none;
            display: inline-block;
        }
        .button:hover {
            background-color: #16a085;
        }
        .primary-button {
            background-color: #3498db;
        }
        .primary-button:hover {
            background-color: #2980b9;
        }
        .button_sukses {
            background-color: #27ae60;
        }
        .button_sukses:hover {
            background-color: #229954;
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
        <li><a href="kontak.php" class="<?php echo ($currentPage == 'kontak.php') ? 'active' : ''; ?>"><i class="fas fa-envelope"></i> KONTAK</a></li>
    </ul>
</div>
<div id="overlay" onclick="toggleMenu()"></div>
<div class="content">
    <div class="container">
        <h3>Detail Pesanan</h3>
        <table>
        <thead>
            <tr>
                <th>No</th>
                <th>Gambar Baju</th>
                <th>Nama Baju</th>
                <th>Ukuran</th>
                <th>Harga</th>
                <th>Jumlah</th>
                <th>Subtotal</th>
            </tr>
        </thead>
        <tbody>
            <?php
            $nomor = 1;
            $total_belanja = 0;
            if(!isset($_GET['id_pembayaran']) || empty($_GET['id_pembayaran'])){
                header("location:data_pesanan_masuk.php");
                exit();
            }
            $id_pembayaran = mysqli_real_escape_string($host, $_GET['id_pembayaran']);
            $ambil = $host->query("SELECT pembelian.*, tb_produk.nama_produk, tb_produk.harga_produk, tb_produk.gambar FROM pembelian JOIN tb_produk ON pembelian.id_produk=tb_produk.id_produk WHERE pembelian.id_pembayaran='$id_pembayaran'");
            while($pecah = $ambil->fetch_assoc()){
                $subharga1 = $pecah['harga_produk'] * $pecah['jumlah'];
                ?>
                <tr>
                    <td><?php echo $nomor; ?></td>
                    <td><img src="foto/<?php echo $pecah['gambar']; ?>" alt="Gambar Baju"></td>
                    <td><?php echo $pecah['nama_produk']; ?></td>
                    <td><?php echo $pecah['ukuran']; ?></td>
                    <td>Rp. <?php echo number_format($pecah['harga_produk']); ?></td>
                    <td><?php echo $pecah['jumlah']; ?></td>
                    <td>Rp. <?php echo number_format($subharga1); ?></td>
                </tr>
                <?php $nomor++; $total_belanja += $subharga1;
            }
            ?>
        </tbody>
        <tfoot>
            <tr>
                <td colspan="6" style="text-align: right; font-weight: bold;">Total Bayar</td>
                <td>Rp. <?php echo number_format($total_belanja); ?></td>
            </tr>
        </tfoot>
        </table>

        <?php
        $jumlah_produk_unik = mysqli_num_rows($ambil); // Number of unique products
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

        <!-- Upload Resi Section -->
        <?php
        $id_pembayaran = mysqli_real_escape_string($host, $_GET['id_pembayaran']);
        $query_check_resi = "SELECT gambar_resi FROM pembayaran WHERE id_pembayaran='$id_pembayaran'";
        $result_check_resi = mysqli_query($host, $query_check_resi);
        $data_check_resi = mysqli_fetch_assoc($result_check_resi);
        if (empty($data_check_resi['gambar_resi'])) {
        ?>
        <div class="summary-section">
            <div class="summary-title">Upload Gambar Resi</div>
            <form method="post" action="" enctype="multipart/form-data">
                <div style="margin-bottom: 15px;">
                    <label for="gambar_resi" style="display: block; margin-bottom: 5px; font-weight: bold;">Pilih Gambar Resi:</label>
                    <input type="file" id="gambar_resi" name="gambar_resi" accept="image/*" required>
                </div>
                <button type="submit" name="upload_resi" class="button button_sukses">Upload Resi</button>
            </form>
        </div>
        <?php } else { ?>
        <div class="summary-section">
            <div class="summary-title">Upload Gambar Resi</div>
            <p style="text-align: center; color: green; font-weight: bold;">Gambar Resi Sudah Diupload</p>
        </div>
        <?php } ?>

        <!-- Display Resi Image -->
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

        <form method="post" action="">
            <div class="button-container">
                <a href="data_pesanan_masuk.php" class="button primary-button">Kembali</a>
                <?php if (!empty($data_check_resi['gambar_resi'])) { ?>
                    <button type="submit" name="bayar" class="button button_sukses">Konfirmasi Pesanan</button>
                <?php } else { ?>
                    <p style="color: red; font-weight: bold;">Harap upload gambar resi terlebih dahulu sebelum konfirmasi pesanan.</p>
                <?php } ?>
            </div>
            <?php
            if(isset($_POST['upload_resi'])){
                if(!isset($_GET['id_pembayaran']) || empty($_GET['id_pembayaran'])){
                    header("location:data_pesanan_masuk.php");
                    exit();
                }
                $id_pembayaran = mysqli_real_escape_string($host, $_GET['id_pembayaran']);

                if(isset($_FILES['gambar_resi']) && $_FILES['gambar_resi']['error'] == 0){
                    $gambar_resi = $_FILES['gambar_resi']['name'];
                    $target_dir = "bukti_bayar/";
                    $target_file = $target_dir . basename($gambar_resi);

                    if(move_uploaded_file($_FILES['gambar_resi']['tmp_name'], $target_file)){
                        $query_update_resi = "UPDATE pembayaran SET gambar_resi='$gambar_resi' WHERE id_pembayaran='$id_pembayaran'";
                        if(mysqli_query($host, $query_update_resi)){
                            echo "<script>alert('Gambar resi berhasil diupload');</script>";
                            echo "<script>window.location.href = 'detail_pesanan.php?id_pembayaran=$id_pembayaran';</script>";
                        } else {
                            echo "<script>alert('Gagal menyimpan gambar resi ke database');</script>";
                        }
                    } else {
                        echo "<script>alert('Gagal mengupload gambar resi');</script>";
                    }
                } else {
                    echo "<script>alert('Pilih gambar resi terlebih dahulu');</script>";
                }
            }

            if(isset($_POST['bayar'])){
                if(!isset($_GET['id_pembayaran']) || empty($_GET['id_pembayaran'])){
                    header("location:data_pesanan_masuk.php");
                    exit();
                }
                $id_pembayaran = mysqli_real_escape_string($host, $_GET['id_pembayaran']);
                $ambil_produk = $host->query("SELECT * FROM pembelian JOIN tb_produk ON pembelian.id_produk=tb_produk.id_produk WHERE pembelian.id_pembayaran='$id_pembayaran'");

                while($pecah_produk = $ambil_produk->fetch_assoc()){
                    $id_produk = $pecah_produk['id_produk'];
                    $jumlah = $pecah_produk['jumlah'];

                    $cek_stok = $host->query("SELECT stok FROM tb_produk WHERE id_produk='$id_produk'");
                    $stok_produk = $cek_stok->fetch_assoc()['stok'];

                    if($stok_produk >= $jumlah){
                        $query_kurangi_stok = "UPDATE tb_produk SET stok = stok - $jumlah WHERE id_produk='$id_produk'";
                        $host->query($query_kurangi_stok);
                    }else{
                        echo "<script>alert('Stok habis untuk barang " . $pecah_produk['nama_produk'] . "');</script>";
                        echo "<script>location='data_pesanan_masuk.php';</script>";
                        exit();
                    }
                }
                $query = "UPDATE pembayaran SET status_pesanan='pesanan dikirim' WHERE id_pembayaran='$id_pembayaran'";
                $host->query($query);

                echo "<script>location='data_pesanan_masuk.php';</script>";
            }
            ?>
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
    const menu = document.querySelector('.nav-menu');
    const overlay = document.getElementById('overlay');
    menu.classList.toggle('show');
    overlay.classList.toggle('show');
}
</script>
</body>
</html>