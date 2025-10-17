<?php 
include 'koneksi.php';
session_start();
if($_SESSION['status'] == ""){
	header("location:index.php");
exit;
}
$query_pria = "SELECT * FROM tb_produk WHERE jenis_baju = 'pria'";
$result_pria = mysqli_query($host,$query_pria);
$query_wanita = "SELECT * FROM tb_produk WHERE jenis_baju = 'wanita'";
$result_wanita = mysqli_query($host,$query_wanita);

$username = $_SESSION['username'];
$query = "SELECT * FROM tb_user WHERE username='$username'";
$result = mysqli_query($host,$query);

if(mysqli_num_rows($result) > 0){
	$data_akun = mysqli_fetch_array($result);
	$_SESSION['id_user'] = $data_akun['id_user'];
	$_SESSION['status'] = $data_akun['status'];
	$_SESSION['nama'] = $data_akun['nama'];
	$_SESSION['alamat'] = $data_akun['alamat'];
	if(!empty($data_akun['foto_profil'])){
		$_SESSION['foto_profil'] = $data_akun['foto_profil'];
	}else{
		$_SESSION['foto_profil'] = 'default.jpg';
	}
}

?>


<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>NERRO SUPPLY</title>
	<link rel="icon" href="foto/logo.jpg">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<link rel="stylesheet" href="style.css">
	 <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
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
		
		
	.benner{
		position: relative;
		height: 400px;
		text-align: center;
		align-items: center;
		color: white;
		overflow: hidden;
	}
	#benner-video{
		top:0;
		left: 0;
		width: 100%;
		height: 100%;
		object-fit: cover;
		z-index: -1000;
	}
	.benner-content{
		position:absolute;
		top: 50%;
		left: 50%;
		transform: translate(-50%, -50%);
		z-index: 1;
		width:90%;
	}
	.benner-content button{
		width: auto;
		height: 30px;

	}
	.benner-content a{
		text-decoration: none;
		color: black;
		padding: 15px 12px;
	}
	.benner-content h1, .benner-content p{
		text-shadow: 2px 2px 8px rgba(0,0,0,0.9);
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
		.btn-buy a{
			text-decoration: none;
			color: white;
		}
	</style>
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
	<h1>JUST CHECK THAT</h1>
<div class="benner">
	<video id="benner-video" autoplay muted loop>
		<source src="foto/back.mp4" type="video/mp4">
	</video>
	<div class="benner-content">
		<h1>DISCOVER YOUR <br>NEW STYLE</h1>
		<button style="background-color: cyan; border-radius:5px; box-shadow:0 2px 4px 0;"><a href="dataproduk_user.php">SHOP NOW</a></button>
	</div>
</div>
	<div class="showcase-container">
    <style>
        /* CSS untuk styling kartu kategori */
        .showcase-section {
            width: 100%;
            max-width: 1200px; /* Lebar maksimal container */
            margin: 50px 20px; /* Jarak atas/bawah dan kiri/kanan */
            text-align: center;
        }

        .showcase-section h2 {
            font-size: 1.2rem; /* Ukuran font judul */
            color: #555; /* Warna abu-abu gelap untuk judul */
            margin-bottom: 25px;
            letter-spacing: 1.5px; /* Jarak antar huruf */
            font-weight: 400; /* Font tidak terlalu tebal */
        }

        .category-grid {
            display: grid;
            /* Membuat kolom responsif */
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 20px; /* Jarak antar kotak */
        }

        .category-card {
            position: relative; /* Diperlukan agar teks bisa menempel di bawah */
            overflow: hidden; /* INI KUNCI EFEK ZOOM, agar gambar tidak keluar dari kotak */
            height: 380px; /* Tinggi setiap kotak */
            display: block;
            text-decoration: none; /* Menghilangkan garis bawah pada link */
            border: 1px solid #e0e0e0; /* Garis tepi tipis */
        }

        .category-card .card-image {
            width: 100%;
            height: 100%;
            object-fit: cover; /* Membuat gambar mengisi seluruh area tanpa distorsi */

            /* INI KUNCI ANIMASI ZOOM */
            transition: transform 0.4s cubic-bezier(0.25, 0.46, 0.45, 0.94);
        }

        /* EFEK HOVER: Saat kursor di atas kartu */
        .category-card:hover .card-image {
            transform: scale(1.1); /* Gambar akan membesar 10% */
        }

        .category-card .card-title {
            /* Posisi teks menempel di bawah */
            position: absolute;
            bottom: 20px; /* Jarak dari bawah */
            left: 20px;   /* Jarak dari kiri */

            color: #111; /* Warna teks hitam */
            background-color: #ffffff; /* Latar belakang putih untuk teks */
            padding: 5px 10px; /* Jarak di dalam kotak teks */
            font-size: 0.9rem;
            font-weight: 700; /* Teks tebal */
            text-transform: uppercase; /* Membuat teks jadi huruf besar */
        }
    </style>
	<div class="show-container">
        <div class="showcase-grid">
            <section class="showcase-section">
        <h2>LOOKING FOR THIS</h2>
        <div class="category-grid">
            <a href="dataproduk_user.php?jenis_pakaian=KAOS" class="category-card">
                <img src="foto/pria.jpg" alt="Pria Clothing" class="card-image">
                <div class="card-title">KAOS</div>
            </a>
            <a href="dataproduk_user.php?jenis_pakaian=HOODIE" class="category-card">
                <img src="foto/Pullover Hoodie New Hope Sky Blue - Available size M L XL - IDR. 320.000- Material Cotton Fleec (1).jpg" alt="" class="card-image">
                <div class="card-title">HOODIE</div>
            </a>
        </div>
    </section>
	</div>
	<div class="product-section">
		<h2>LOOKING FOR THIS</h2>
		<div class="product-grid">
			<?php
			$tampil_pria = mysqli_query($host, "SELECT * FROM tb_produk WHERE jenis_baju = 'pria' AND stok > 0");
			while($produk_pria = mysqli_fetch_assoc($tampil_pria)){
				?>
				<div class="product-card">
					<img src="foto/<?php echo $produk_pria['gambar']; ?>" alt="<?php echo $produk_pria['nama_produk']; ?>">
					<div class="product-info">
						<h3><?php echo $produk_pria['nama_produk']; ?></h3>
						<p>Ukuran: <?php echo $produk_pria['ukuran']; ?></p>
						<p>Stok: <?php echo $produk_pria['stok']; ?></p>
						<div class="price">Rp <?php echo number_format($produk_pria['harga_produk'], 0, ',', '.'); ?></div>
						<button class="btn btn-buy"><a href="detail_produk_user.php?id_produk=<?php echo $produk_pria['id_produk']; ?>">Beli</a></button>
					</div>
				</div>
				<?php
			}
			?>
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
