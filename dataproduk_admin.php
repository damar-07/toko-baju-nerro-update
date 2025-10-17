<?php
include 'koneksi.php';
session_start();

if($_SESSION['status'] == ""){
    header("location:index.php");
}

// Ambil nilai pencarian dan filter
$search = isset($_GET['search']) ? $_GET['search'] : '';
$kategori = isset($_GET['kategori']) ? $_GET['kategori'] : '';
$sort = isset($_GET['sort']) ? $_GET['sort'] : '';

// Query dasar
$query = "SELECT * FROM tb_produk WHERE 1=1";

// Tambahkan pencarian berdasarkan nama produk
if (!empty($search)) {
    $query .= " AND nama_produk LIKE '%" . mysqli_real_escape_string($host, $search) . "%'";
}

// Filter berdasarkan kategori pakaian
if (!empty($kategori)) {
    $query .= " AND kategori = '" . mysqli_real_escape_string($host, $kategori) . "'";
}

// Sorting
if ($sort == 'harga_asc') {
    $query .= " ORDER BY harga_produk ASC";
} elseif ($sort == 'harga_desc') {
    $query .= " ORDER BY harga_produk DESC";
} elseif ($sort == 'nama_asc') {
    $query .= " ORDER BY nama_produk ASC";
} elseif ($sort == 'nama_desc') {
    $query .= " ORDER BY nama_produk DESC";
}

$result = mysqli_query($host, $query);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Data Produk Admin</title>
    <link rel="icon" href="foto/logo.jpg">
    <link rel="stylesheet" href="style.css">
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

        .produk-content {
            max-width: 1400px;
            margin: 0 auto;
            padding: 80px 20px 40px;
        }

        .search-sort-container {
            background: white;
            border-radius: 15px;
            box-shadow: 0 4px 15px rgba(0,0,0,0.1);
            padding: 25px;
            margin-bottom: 30px;
            border: 2px solid #333;
            margin-left: 55%;
            width: fit-content;
            max-width: 100%;
            position: relative;
        }

        .search-toggle {
            display: none;
            font-size: 24px;
            cursor: pointer;
            color: #333;
            position: absolute;
            top: 10px;
            right: 10px;
            z-index: 10;
            transition: color 0.3s ease;
        }

        .search-toggle:hover {
            color: #1abc9c;
        }

        .search-sort-form {
            display: flex;
            flex-direction: column;
            gap: 15px;
            align-items: center;
        }

        .search-sort-form.hidden {
            display: none;
        }

        @media (max-width: 768px) {
            .search-sort-container {
                margin-left: 0;
                width: 100%;
                padding: 15px;
            }

            .search-toggle {
                display: block;
            }

            .search-sort-form {
                display: none;
            }

            .search-sort-form.show {
                display: flex;
            }
        }

        .search-sort-form input[type="text"] {
            padding: 12px 20px;
            border: 2px solid #ddd;
            border-radius: 25px;
            font-size: 16px;
            width: 100%;
            transition: all 0.3s ease;
            outline: none;
        }

        .form-row {
            display: flex;
            gap: 15px;
            align-items: center;
            justify-content: center;
            flex-wrap: wrap;
        }

        .search-sort-form input[type="text"]:focus {
            border-color: #1abc9c;
            box-shadow: 0 0 8px rgba(26, 188, 156, 0.3);
        }

        .search-sort-form select {
            padding: 12px 20px;
            border: 2px solid #ddd;
            border-radius: 25px;
            font-size: 16px;
            background: white;
            cursor: pointer;
            transition: all 0.3s ease;
            outline: none;
            min-width: 150px;
        }

        .search-sort-form select:focus {
            border-color: #1abc9c;
            box-shadow: 0 0 8px rgba(26, 188, 156, 0.3);
        }

        .search-sort-form button {
            padding: 12px 30px;
            background: #1abc9c;
            color: white;
            border: none;
            border-radius: 25px;
            font-size: 16px;
            font-weight: bold;
            cursor: pointer;
            transition: all 0.3s ease;
            text-transform: uppercase;
            letter-spacing: 1px;
        }

        .search-sort-form button:hover {
            background: #16a085;
            transform: translateY(-2px);
            box-shadow: 0 4px 15px rgba(26, 188, 156, 0.4);
        }

        .produk-grid-filtered {
            display: flex;
            flex-wrap: wrap;
            gap: 25px;
            height: 50%;
            justify-content: center;
            margin-bottom: 50px;
        }

        .section-title {
            text-align: center;
            margin: 40px 0 30px 10px;
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

        .produk-grid {
            display: flex;
            flex-direction: row;
            overflow-x: auto;
            gap: 25px;
            margin-bottom: 50px;
            margin-left: 10px;
            margin-right: 10px;
            padding-bottom: 10px;
            padding-top: 5px;
        }
        .menu-item {
            min-width: 320px;
            flex-shrink: 0;
        }

        .menu-item {
            background: white;
            border-radius: 15px;
            box-shadow: 0 8px 25px rgba(0,0,0,0.1);
            overflow: hidden;
            border: 2px solid #333;
            transition: all 0.3s ease;
            display: flex;
            flex-direction: column;
            height: 100%;
            position: relative;
        }

        .menu-item:hover {
            transform: translateY(-5px);
            box-shadow: 0 15px 35px rgba(0,0,0,0.2);
        }

        .menu-item .main-img,
        .menu-item .hover-img {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 200px;
            object-fit: cover;
            border-bottom: 2px solid #333;
            transition: opacity 0.3s ease;
        }

        .menu-item .hover-img {
            opacity: 0;
        }

        .menu-item:hover .hover-img {
            opacity: 1;
        }

        .menu-item:hover .main-img {
            opacity: 0;
        }

        .deskripsi {
            padding: 20px;
            background: white;
            flex: 1;
            display: flex;
            flex-direction: column;
            margin-top: 200px;
        }

        .deskripsi h3 {
            margin: 0 0 15px 0;
            color: #333;
            font-size: 18px;
            font-weight: bold;
            text-align: center;
            border-bottom: 2px solid #333;
            padding-bottom: 10px;
            line-height: 1.3;
        }

        .deskripsi p {
            margin: 8px 0;
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 5px 0;
            border-bottom: 1px solid #eee;
        }

        .deskripsi p:last-child {
            border-bottom: none;
            margin-bottom: 0;
        }

        .deskripsi span:first-child {
            font-weight: bold;
            color: #333;
            text-transform: capitalize;
            flex-shrink: 0;
        }

        .value {
            color: #555;
            font-weight: 500;
            text-align: right;
            word-break: break-word;
        }

        .action-button {
            padding: 15px 20px;
            background: #f8f8f8;
            border-top: 2px solid #333;
            display: flex;
            gap: 10px;
            justify-content: center;
            margin-top: auto;
        }

        .action-button a {
            padding: 8px 20px;
            text-decoration: none;
            border-radius: 20px;
            font-weight: bold;
            text-transform: uppercase;
            letter-spacing: 1px;
            transition: all 0.3s ease;
            border: 2px solid #333;
            font-size: 12px;
            white-space: nowrap;
        }

        .action-button a:first-child {
            background: #333;
            color: white;
        }

        .action-button a:first-child:hover {
            background: white;
            color: #333;
        }

        .action-button a.hapus {
            background: #dc3545;
            color: white;
            border-color: #dc3545;
        }

        .action-button a.hapus:hover {
            background: white;
            color: #dc3545;
        }

        .empty-state {
            text-align: center;
            color: #666;
            font-style: italic;
            padding: 60px 20px;
            grid-column: 1 / -1;
            background: white;
            border-radius: 15px;
            border: 2px solid #ddd;
        }

        /* Responsive Design */
        @media (max-width: 768px) {
            .produk-content {
                padding: 80px 10px 40px;
            }

            .produk-grid {
                gap: 15px;
            }

            .section-title {
                font-size: 24px;
                margin: 30px 0 20px 0;
            }

            .menu-item {
                min-width: 280px;
            }

            .menu-item .main-img,
            .menu-item .hover-img {
                height: 180px;
            }

            .deskripsi {
                padding: 15px;
                margin-top: 180px;
            }

            .deskripsi h3 {
                font-size: 16px;
            }

            .action-button {
                padding: 12px 15px;
            }

            .action-button a {
                padding: 6px 15px;
                font-size: 11px;
            }
        }

        @media (max-width: 480px) {
            .produk-grid {
                gap: 20px;
            }

            .section-title {
                font-size: 20px;
                margin: 25px 0 15px 0;
            }

            .menu-item {
                min-width: 100%;
            }

            .menu-item .main-img,
            .menu-item .hover-img {
                height: 160px;
            }

            .deskripsi {
                margin-top: 160px;
            }

            .deskripsi h3 {
                font-size: 15px;
            }

            .deskripsi p {
                font-size: 14px;
            }

            .value {
                font-size: 13px;
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
<div class="produk-content">
    <div class="search-sort-container">
        <i class="fas fa-search search-toggle" onclick="toggleSearch()"></i>
        <form method="GET" action="" class="search-sort-form">
            <input type="text" name="search" placeholder="Cari nama produk..." value="<?php echo htmlspecialchars($search); ?>">
            <div class="form-row">
                <select name="kategori">
                    <option value="">Semua Kategori</option>
                    <option value="KAOS" <?php echo ($kategori == 'KAOS') ? 'selected' : ''; ?>>KAOS</option>
                    <option value="HOODIE" <?php echo ($kategori == 'HOODIE') ? 'selected' : ''; ?>>HOODIE</option>
                    <option value="JAKET" <?php echo ($kategori == 'JAKET') ? 'selected' : ''; ?>>JAKET</option>
                    <option value="TOPI" <?php echo ($kategori == 'TOPI') ? 'selected' : ''; ?>>TOPI</option>
                    <option value="CELANA" <?php echo ($kategori == 'CELANA') ? 'selected' : ''; ?>>CELANA</option>
                    <option value="KAOS_KAKI" <?php echo ($kategori == 'KAOS_KAKI') ? 'selected' : ''; ?>>KAOS KAKI</option>
                </select>
                <select name="sort">
                    <option value="">Urutkan</option>
                    <option value="nama_asc" <?php echo ($sort == 'nama_asc') ? 'selected' : ''; ?>>Nama A-Z</option>
                    <option value="nama_desc" <?php echo ($sort == 'nama_desc') ? 'selected' : ''; ?>>Nama Z-A</option>
                    <option value="harga_asc" <?php echo ($sort == 'harga_asc') ? 'selected' : ''; ?>>Harga Terendah</option>
                    <option value="harga_desc" <?php echo ($sort == 'harga_desc') ? 'selected' : ''; ?>>Harga Tertinggi</option>
                </select>
                <button type="submit">Cari & Urutkan</button>
            </div>
        </form>
    </div>

    <?php if (!empty($search) || !empty($kategori) || !empty($sort)): ?>
        <!-- Filtered Results -->
        <div class="produk-grid-filtered">
            <?php
            $has_products = false;
            while($data = mysqli_fetch_array($result)){
                $has_products = true;
                ?>
                <div class="menu-item">
                    <img src="foto/<?php echo $data['gambar']; ?>" alt="gambar produk" class="main-img" />
                    <img src="foto/<?php echo $data['gambar_hover']; ?>" alt="gambar produk hover" class="hover-img" />
                    <div class="deskripsi">
                        <h3><?php echo $data['nama_produk']; ?></h3>
                        <p><span>kategori:</span><span class="value"><?php echo ucfirst($data['jenis_baju']); ?></span></p>
                        <p><span>ukuran:</span><span class="value"><?php echo $data['ukuran']; ?></span></p>
                        <p><span>stok:</span><span class="value"><?php echo $data['stok']; ?></span></p>
                        <p><span>harga:</span><span class="value">Rp <?php echo number_format($data['harga_produk'], 0, ',', '.'); ?></span></p>
                    </div>
                    <div class="action-button">
                        <a href="editdata_produk.php?id_produk=<?php echo $data['id_produk']; ?>">edit</a>
                        <a href="hapusdata_produk.php?id_produk=<?php echo $data['id_produk']; ?>" class="hapus" onclick="return confirm('Apakah Anda yakin ingin menghapus produk ini?')">hapus</a>
                    </div>
                </div>
                <?php
            }
            if (!$has_products) {
                echo '<div class="empty-state">Tidak ada produk yang sesuai dengan kriteria pencarian.</div>';
            }
            ?>
        </div>
    <?php else: ?>
        <!-- Default Categorized Display -->
        <?php
        $jenis_pakaian_options = ['KAOS', 'HOODIE', 'JAKET', 'TOPI', 'CELANA', 'KAOS_KAKI'];

        foreach($jenis_pakaian_options as $jenis) {
            echo "<div class='section-title'>{$jenis}</div>";
            echo "<div class='produk-grid'>";

            include 'koneksi.php';
            $query = "SELECT * FROM tb_produk WHERE kategori = '$jenis' ORDER BY jenis_baju, nama_produk";
            $result = mysqli_query($host, $query);
            $has_products = false;

            while($data = mysqli_fetch_array($result)){
                $has_products = true;
                ?>
                <div class="menu-item">
                    <img src="foto/<?php echo $data['gambar']; ?>" alt="gambar produk" class="main-img" />
                    <img src="foto/<?php echo $data['gambar_hover']; ?>" alt="gambar produk hover" class="hover-img" />
                    <div class="deskripsi">
                        <h3><?php echo $data['nama_produk']; ?></h3>
                        <p><span>kategori:</span><span class="value"><?php echo ucfirst($data['jenis_baju']); ?></span></p>
                        <p><span>ukuran:</span><span class="value"><?php echo $data['ukuran']; ?></span></p>
                        <p><span>stok:</span><span class="value"><?php echo $data['stok']; ?></span></p>
                        <p><span>harga:</span><span class="value">Rp <?php echo number_format($data['harga_produk'], 0, ',', '.'); ?></span></p>
                    </div>
                    <div class="action-button">
                        <a href="editdata_produk.php?id_produk=<?php echo $data['id_produk']; ?>">edit</a>
                        <a href="hapusdata_produk.php?id_produk=<?php echo $data['id_produk']; ?>" class="hapus" onclick="return confirm('Apakah Anda yakin ingin menghapus produk ini?')">hapus</a>
                    </div>
                </div>
                <?php
            }

            if (!$has_products) {
                echo '<div class="empty-state">Tidak ada produk ' . strtolower($jenis) . '</div>';
            }

            echo "</div>";
        }
        ?>
    <?php endif; ?>
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

function toggleSearch() {
    const form = document.querySelector('.search-sort-form');
    form.classList.toggle('show');
}
</script>
</body>
</html>
