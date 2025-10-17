<?php
include 'koneksi.php';
session_start();

if($_SESSION['status'] == ""){
    header("location:index.php");
}

if(empty($_SESSION['pesanan']) OR !isset($_SESSION['pesanan'])){
    echo "<script>alert('pesanan kosong silahkan memesan dulu');</script>";
    echo "<script>window.location='dashboard_user.php';</script>";
}

$username = $_SESSION['username'];
$query = "SELECT * FROM tb_user WHERE username ='$username'";
$result = mysqli_query($host,$query);
?>

<?php
if(mysqli_num_rows($result)>0){
    $data_akun = mysqli_fetch_array($result);
$_SESSION['id_user'] = $data_akun['id_user'];
$_SESSION['status'] = $data_akun['status'];
$_SESSION['nama'] = $data_akun['nama'];
$_SESSION['alamat'] = $data_akun['alamat'];
$_SESSION['foto_profil'] = isset($data_akun['foto_profil']) ? $data_akun['foto_profil'] : '';
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Toko Baju - Keranjang Belanja</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="icon" href="foto/logo.jpg">
    <link rel="stylesheet" href="style.css">
    <style>
        body {
            font-family: 'Arial', sans-serif;
            background: linear-gradient(135deg, #f5f5f5 0%, #e0e0e0 100%);
            margin: 0;
            padding: 0;
            min-height: 100vh;
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

        .container {
            max-width: 1400px;
            margin: 0 auto;
            padding: 80px 20px 40px;
        }

        .page-title {
            text-align: center;
            margin: 30px 0 40px 0;
            font-size: 32px;
            font-weight: bold;
            color: #333;
            text-transform: uppercase;
            letter-spacing: 2px;
            position: relative;
        }

        .page-title::after {
            content: '';
            position: absolute;
            bottom: -10px;
            left: 50%;
            transform: translateX(-50%);
            width: 80px;
            height: 3px;
            background: #007bff;
        }

        .cart-section {
            background: white;
            border-radius: 15px;
            box-shadow: 0 10px 30px rgba(0,0,0,0.1);
            overflow: hidden;
            margin-bottom: 30px;
        }

        .cart-header {
            background: #2c3e50;
            color: white;
            padding: 20px;
            text-align: center;
            font-size: 24px;
            font-weight: bold;
            text-transform: uppercase;
            letter-spacing: 1px;
        }

        .cart-table {
            width: 100%;
            border-collapse: collapse;
        }

        .cart-table th {
            background: #f8f9fa;
            color: #333;
            padding: 15px;
            text-align: left;
            font-weight: bold;
            text-transform: uppercase;
            font-size: 12px;
            letter-spacing: 1px;
            border-bottom: 2px solid #dee2e6;
        }

        .cart-table td {
            padding: 15px;
            border-bottom: 1px solid #dee2e6;
            vertical-align: middle;
        }

        .cart-table tr:hover {
            background: #f8f9fa;
        }

        .product-image {
            width: 80px;
            height: 80px;
            object-fit: cover;
            border-radius: 8px;
            border: 2px solid #dee2e6;
        }

        .product-name {
            font-weight: bold;
            color: #333;
            margin-bottom: 5px;
        }

        .product-price {
            color: #007bff;
            font-weight: bold;
            font-size: 16px;
        }

        .quantity-badge {
            background: #007bff;
            color: white;
            padding: 5px 10px;
            border-radius: 20px;
            font-weight: bold;
            display: inline-block;
        }

        .subtotal {
            font-weight: bold;
            color: #28a745;
            font-size: 16px;
        }

        .delete-btn {
            background: #dc3545;
            color: white;
            padding: 8px 15px;
            text-decoration: none;
            border-radius: 20px;
            font-size: 12px;
            font-weight: bold;
            text-transform: uppercase;
            letter-spacing: 1px;
            transition: all 0.3s ease;
        }

        .delete-btn:hover {
            background: #c82333;
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(220, 53, 69, 0.3);
        }

        .total-row {
            background: #f8f9fa !important;
            color: #333;
            border-top: 2px solid #dee2e6;
            margin-left: 35px;
        }

        .total-row th,
        .total-row td {
            padding: 20px 15px;
            font-size: 18px;
            font-weight: bold;
            text-transform: uppercase;
            letter-spacing: 1px;
        }

        .total-amount {
            color: #007bff !important;
            font-size: 24px !important;
        }

        .checkout-section {
            background: white;
            border-radius: 15px;
            box-shadow: 0 10px 30px rgba(0,0,0,0.1);
            padding: 30px;
        }

        .checkout-title {
            text-align: center;
            margin-bottom: 30px;
            font-size: 24px;
            font-weight: bold;
            color: #333;
            text-transform: uppercase;
            letter-spacing: 1px;
            position: relative;
        }

        .checkout-title::after {
            content: '';
            position: absolute;
            bottom: -10px;
            left: 50%;
            transform: translateX(-50%);
            width: 60px;
            height: 3px;
            background: #007bff;
        }

        .form-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
            gap: 20px;
            margin-bottom: 30px;
        }

        .form-group {
            margin-bottom: 20px;
        }

        .form-group label {
            display: block;
            margin-bottom: 8px;
            font-weight: bold;
            color: #333;
            text-transform: uppercase;
            font-size: 12px;
            letter-spacing: 1px;
        }

        .form-group input,
        .form-group select {
            width: 100%;
            padding: 12px 15px;
            border: 2px solid #dee2e6;
            border-radius: 8px;
            font-size: 14px;
            transition: all 0.3s ease;
            background: white;
        }

        .form-group input:focus,
        .form-group select:focus {
            outline: none;
            border-color: #007bff;
            box-shadow: 0 0 0 3px rgba(0, 123, 255, 0.1);
        }

        .form-group input[readonly] {
            background: #f8f9fa;
            cursor: not-allowed;
        }

        .checkout-btn {
            background: linear-gradient(135deg, #007bff 0%, #0056b3 100%);
            color: white;
            padding: 15px 30px;
            border: none;
            border-radius: 25px;
            font-size: 16px;
            font-weight: bold;
            text-transform: uppercase;
            letter-spacing: 1px;
            cursor: pointer;
            transition: all 0.3s ease;
            display: block;
            margin: 0 auto;
            box-shadow: 0 5px 15px rgba(0, 123, 255, 0.3);
        }

        .checkout-btn:hover {
            transform: translateY(-3px);
            box-shadow: 0 8px 25px rgba(0, 123, 255, 0.4);
        }

        .empty-cart {
            text-align: center;
            color: #666;
            font-style: italic;
            padding: 60px 20px;
            background: white;
            border-radius: 15px;
            border: 2px solid #ddd;
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
            .container {
                padding: 80px 15px 40px;
            }

            .page-title {
                font-size: 28px;
                margin: 20px 0 30px 0;
                text-align: center;
            }

            .cart-section {
                padding: 0;
                border-radius: 15px;
                overflow: hidden;
            }

            .cart-header {
                font-size: 20px;
                padding: 20px;
                text-align: center;
            }

            /* Convert table to card layout on mobile */
            .cart-table {
                display: block;
                width: 100%;
            }

            .cart-table thead {
                display: none;
            }

            .cart-table tbody {
                display: block;
            }

            .cart-table tr {
                display: block;
                background: white;
                border: 1px solid #dee2e6;
                border-radius: 10px;
                margin-bottom: 15px;
                padding: 15px;
                box-shadow: 0 2px 8px rgba(0,0,0,0.1);
            }

            .cart-table td {
                display: block;
                padding: 8px 0;
                border: none;
                text-align: center;
                position: relative;
            }

            .cart-table td:first-child {
                display: none; /* Hide number */
            }

            .cart-table td:nth-child(2) {
                padding: 0;
                margin-bottom: 10px;
                order: -1; /* Move image to top */
            }

            .cart-table td:nth-child(2) .product-image {
                width: 80px;
                height: 80px;
                border-radius: 8px;
                margin: 0 auto;
                display: block;
            }

            .cart-table td:nth-child(3) {
                font-weight: bold;
                font-size: 16px;
                color: #333;
                margin-bottom: 8px;
                order: 0; /* Keep name after image */
            }

            .cart-table td:nth-child(4)::before {
                content: "Ukuran: ";
                font-weight: bold;
                color: #666;
            }

            .cart-table td:nth-child(5)::before {
                content: "Harga: ";
                font-weight: bold;
                color: #666;
            }

            .cart-table td:nth-child(6)::before {
                content: "Jumlah: ";
                font-weight: bold;
                color: #666;
            }

            .cart-table td:nth-child(7)::before {
                content: "Subtotal: ";
                font-weight: bold;
                color: #666;
            }

            .cart-table td:nth-child(8) {
                text-align: center;
                margin-top: 10px;
            }

            .cart-table td:nth-child(8) .delete-btn {
                width: 100%;
                padding: 10px;
                font-size: 14px;
            }

            .total-row {
                background: #f8f9fa !important;
                color: #333;
                text-align: center;
                padding: 15px;
                font-size: 18px;
                font-weight: bold;
                margin-top: 20px;
                border-top: 2px solid #dee2e6;
            }

            .form-grid {
                grid-template-columns: 1fr;
                gap: 15px;
            }

            .checkout-section,
            .summary-section {
                padding: 20px;
                margin-bottom: 20px;
            }

            .summary-title,
            .checkout-title {
                font-size: 22px;
                margin-bottom: 20px;
            }

            .summary-row {
                font-size: 16px;
                padding: 12px 0;
            }

            .checkout-btn {
                width: 100%;
                padding: 15px;
                font-size: 16px;
            }
        }

        @media (max-width: 480px) {
            .container {
                padding: 80px 10px 40px;
            }

            .page-title {
                font-size: 24px;
                margin: 15px 0 20px 0;
            }

            .cart-header {
                font-size: 18px;
                padding: 15px;
            }

            .cart-table tr {
                padding: 12px;
                margin-bottom: 12px;
            }

            .cart-table td:nth-child(2) {
                width: 50px;
                height: 50px;
                top: 12px;
                left: 12px;
            }

            .cart-table td:nth-child(2) .product-image {
                border-radius: 6px;
            }

            .cart-table td:nth-child(3) {
                font-size: 14px;
            }

            .cart-table td:nth-child(8) .delete-btn {
                padding: 8px;
                font-size: 12px;
            }

            .form-group input,
            .form-group select {
                padding: 12px;
                font-size: 14px;
            }

            .checkout-btn {
                padding: 12px;
                font-size: 14px;
            }

            .summary-title,
            .checkout-title {
                font-size: 18px;
            }

            .summary-row {
                font-size: 14px;
                padding: 10px 0;
            }

            .total-row {
                font-size: 16px;
                padding: 12px;
            }

            .total-amount {
                font-size: 18px !important;
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
    <div id="overlay" onclick="toggleMenu()"></div>
    <div class="container">
        <div class="page-title">Keranjang Belanja</div>
        <div class="cart-section">
            <div class="cart-header">Daftar Produk</div>
            <table class="cart-table">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Gambar</th>
                        <th>Nama Produk</th>
                        <th>Ukuran</th>
                        <th>Harga</th>
                        <th>Jumlah</th>
                        <th>Subtotal</th>
                        <th>Opsi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $nomor=1;
                    $total_belanja=0;

                    if(!empty($_SESSION['pesanan']) && is_array($_SESSION['pesanan'])) {
                        foreach($_SESSION['pesanan'] as $key => $item) {
                            if (!is_array($item)) continue;
                            $id_produk = $item['id_produk'];
                            $ukuran = $item['ukuran'];
                            $jumlah = $item['jumlah'];

                            $ambil = mysqli_query($host,"SELECT * FROM tb_produk WHERE id_produk='$id_produk'");

                        if(!$ambil){
                            die('query error:' . mysqli_error($host));
                        }

                        $pecah = mysqli_fetch_assoc($ambil);

                        if($pecah) {
                            $subtotal = $pecah['harga_produk'] * $jumlah;
                            ?>

                            <tr>
                                <td><?php echo $nomor; ?></td>
                                <td><img src="foto/<?php echo $pecah['gambar']; ?>" alt="gambar produk" class="product-image"></td>
                                <td>
                                    <div class="product-name"><?php echo $pecah['nama_produk']; ?></div>
                                </td>
                                <td><?php echo $ukuran; ?></td>
                                <td><span class="product-price">Rp. <?php echo number_format($pecah['harga_produk']); ?></span></td>
                                <td><span class="quantity-badge"><?php echo $jumlah; ?></span></td>
                                <td><span class="subtotal">Rp. <?php echo number_format($subtotal); ?></span></td>
                                <td><a href="hapus_keranjang.php?id_key=<?php echo $key; ?>" class="delete-btn">Hapus</a></td>
                            </tr>
                            <?php
                            $nomor++;
                            $total_belanja += $subtotal;
                            }
                        }
                    } else {
                        echo '<tr><td colspan="8"><div class="empty-cart">Keranjang belanja kosong</div></td></tr>';
                    }
                    ?>
                </tbody>
                <?php if(!empty($_SESSION['pesanan']) && is_array($_SESSION['pesanan'])) { ?>
                <tfoot>
                    <tr class="total-row">
                        <th colspan="6">Total Belanja</th>
                        <th colspan="2" class="total-amount">Rp. <?php echo number_format($total_belanja); ?></th>
                    </tr>
                </tfoot>
                <?php } ?>
            </table>
</div>

        <?php
        $jumlah_produk_unik = count($_SESSION['pesanan']);
        $ongkir = $jumlah_produk_unik * 10000;
        $total_akhir = $total_belanja + $ongkir;
        ?>

        <?php if(!empty($_SESSION['pesanan']) && is_array($_SESSION['pesanan'])) { ?>
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
        <?php } ?>

        <?php if(!empty($_SESSION['pesanan']) && is_array($_SESSION['pesanan'])) { ?>
        <div class="checkout-section">
            <div class="checkout-title">Informasi Pembayaran</div>
            <form action="" method="post" enctype="multipart/form-data">
                <div class="form-grid">
                    <div class="form-group">
                        <label for="nama">Nama Pelanggan</label>
                        <input type="text" name="nama" value="<?php echo $data_akun['nama']; ?>" readonly required>
                    </div>
                    <div class="form-group">
                        <label for="nomor_telepon">Nomor Telepon</label>
                        <input type="number" name="nomor_telepon" id="nomor_telepon" required placeholder="Masukkan nomor telepon">
                    </div>
                    <div class="form-group">
                        <label for="alamat">Alamat</label>
                        <input type="text" name="alamat" id="alamat" value="<?php echo $data_akun['alamat']; ?>" required>
                    </div>
                    <div class="form-group">
                        <label for="metode_pembayaran">Metode Pembayaran</label>
                        <select name="metode_pembayaran" id="metode_pembayaran">
                            <option value="bank bri">Bank BRI (*nomor bri nerro) Nerro Supply</option>
                            <option value="bank mandiri">Bank Mandiri (*nomor bank nerro) Nerro Supply</option>
                            <option value="dana">Dana (*nomor dana nerro) Nerro Supply</option>
                            <option value="gopay">GoPay (*nomor gopay nerro) Nerro Supply</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="metode_pengiriman">Metode Pengiriman</label>
                        <select name="metode_pengiriman" id="metode_pengiriman" required>
                            <option value="jne">JNE</option>
                            <option value="tiki">JNT</option>
                            <option value="pos">SI CEPAT</option>
                        </select>
                    </div>
                    <div class="form-group" style="grid-column: 1 / -1;">
                        <label for="bukti">Upload Bukti Pembayaran</label>
                        <input type="file" name="bukti_pembayaran" id="bukti" required>
                    </div>
                </div>
                <input type="hidden" name="total_belanja" value="<?php echo $total_belanja; ?>">
                <input type="hidden" name="ongkir" value="<?php echo $ongkir; ?>">
                <input type="hidden" name="total_akhir" value="<?php echo $total_akhir; ?>">
                <input type="hidden" name="id_user" value="<?php echo $data_akun['id_user']; ?>">
                <button type="submit" name="konfirm" class="checkout-btn">Konfirmasi Pesanan</button>
            </form>
        </div>
        <?php } ?>

        <?php
        if(isset($_POST['konfirm'])){
            $id_user = $_POST['id_user'];
            $nama = $_POST['nama'];
            $nomor_telepon = $_POST['nomor_telepon'];
            $alamat = $_POST['alamat'];
            $metode_pembayaran = $_POST['metode_pembayaran'];
            $metode_pengiriman = $_POST['metode_pengiriman'];
            $total_belanja = $_POST['total_belanja'];


            // Upload bukti pembayaran
            $bukti = $_FILES['bukti_pembayaran']['name'];
            $tmp = $_FILES['bukti_pembayaran']['tmp_name'];
            move_uploaded_file($tmp, "bukti_pembayaran/".$bukti);

            // Insert into pembayaran
            $insert = "INSERT INTO pembayaran (id_user, nama, nomor_telepon, alamat, metode_pembayaran, metode_pengiriman, gambar_resi, bukti_pembayaran, total_belanja, status_pesanan, tanggal_pembayaran, bank)
            VALUES ('$id_user', '$nama', '$nomor_telepon', '$alamat', '$metode_pembayaran', '$metode_pengiriman', '', '$bukti', '$total_belanja', 'menunggu konfirmasi', NOW(), '$metode_pembayaran')";
            $insert_pembayaran = mysqli_query($host, $insert);

            if($insert_pembayaran){
                $id_pembayaran = mysqli_insert_id($host);

                // Insert details into pembelian
                foreach($_SESSION['pesanan'] as $item){
                    if (!is_array($item)) continue;
                    $id_produk = $item['id_produk'];
                    $jumlah = $item['jumlah'];
                    $ukuran = $item['ukuran'];

                    $ambil_produk = mysqli_query($host, "SELECT * FROM tb_produk WHERE id_produk='$id_produk'");
                    $pecah_produk = mysqli_fetch_assoc($ambil_produk);
                    mysqli_query($host, "INSERT INTO pembelian (id_pembayaran, id_produk, jumlah, ukuran) VALUES ('$id_pembayaran', '$id_produk', '$jumlah', '$ukuran')");

                    $stok_baru = $pecah_produk['stok'] - $jumlah;
                    mysqli_query($host, "UPDATE tb_produk SET stok='$stok_baru' WHERE id_produk='$id_produk'");

                }

                // Clear session
                unset($_SESSION['pesanan']);

                echo "<script>alert('Pesanan berhasil dikirim! Silahkan tunggu konfirmasi dari admin.');</script>";
                echo "<script>location='dashboard_user.php';</script>";
            }else{
                echo "<script>alert('Gagal mengirim pesanan. Silahkan coba lagi.'" . mysqli_error($host) . "</script>;";
            }
        }
        ?>
    </div>
    <footer>
        <div class="footer-container">
            <div class="footer-column">
                <h4>Toko Kami</h4>
                <ul>
                    <li><a href="dashboard_user.php">Home</a></li>
                    <li><a href="dataproduk_user.php">Produk Kami</a></li>
                    <li><a href="keranjang_pembeli.php">Keranjang Saya</a></li>
                    <li><a href="pesanan_pembeli.php">Pesanan Saya</a></li>
                </ul>
            </div>
            <div class="footer-column">
                <h4>Bantuan</h4>
                <ul>
                    <li><a href="kontak_pembeli.php">Kontak Admin</a></li>
                    <li><a href="profil_pembeli.php">Profil Saya</a></li>
                    <li><a href="logout.php">Logout</a></li>
                </ul>
            </div>
            <div class="footer-column">
                <h4>Ikuti Kami</h4>
                <p>Dapatkan Info Produk terbaru Dari Kami</p>
                <div class="social-icons">
                <a href="https://www.instagram.com/nerrosupplyco?utm_source=ig_web_button_share_sheet&igsh=ZDNlZDc0MzIxNw=="><i class="fab fa-instagram"></i></a>
                <a href="https://wa.me/628979791596"><i class="fab fa-whatsapp"></i></a>
                <a href="https://www.tiktok.com/@nerrosupplyco"><i class="fab fa-tiktok"></i></a>
                <a href="https://youtube.com/@nsco.apparel?si=zLbMGDniCOlUVqQa"><i class="fab fa-youtube"></i></a>
            </div>
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
