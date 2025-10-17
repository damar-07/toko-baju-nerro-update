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
	<title>nerro supply admin</title>
	<link rel="icon" href="foto/logo.jpg">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<link rel="stylesheet" href="style.css">
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
	<style>
		*{
			margin: 0;
			padding: 0;
			font-family: 'Times New Roman', Times, serif;
			box-sizing: border-box;
			scroll-behavior: smooth;
		}
		body{
			min-height: 100vh;
			background-color: #f4f4f4;
			color: #333;
		}
		.title{
			background: linear-gradient(to right, #333, #fff);
			color: white;
			padding: 25px;
			text-align: center;
			border-bottom: 2px solid #000;
			box-shadow: 0 4px 6px rgba(0,0,0,0.3);
		}
		.title a{
			position: relative;
		}
		.profil-logout{
			float: right;
			margin:0 0 5px 0;
			top: 0;
		}
		input[type="submit"]{
			border: none;
			background-color: brown;
			color: black;
		}
		.top-navbar{
			background: linear-gradient(to right, #000, #333);
			display: flex;
			justify-content: space-between;
			align-items: center;
			padding: 10px 15px;
			position: relative;
			color: white;
			width: 100%;
			top: 0;
			left: 0;
			z-index: 1100;
			box-shadow: 0 4px 6px rgba(0,0,0,0.3);
		}
		.side-top{
			padding: 5px 20px;
		}
		.side-top a{
			background: none;
			text-decoration: none;
			color: white;
			font-family: 'Times New Roman';
			gap:20px;
			display: flex;
			align-items: center;
			transition: color 0.3s ease;
		}
		.side-top img{
			width: 30px;
			height: 30px;
			border-radius: 50%;
			object-fit: cover;
			border: 1px solid white;
		}
		.side-top a:hover{
			color: #d1d1d1;
		}
		.navigasi{
			background: linear-gradient(to right, #000, #333);
			padding: 10px 0;
			position: sticky;
			top: 60px;
			border: none;
			z-index: 1000;
			box-shadow: 0 4px 10px rgba(0,0,0,0.3);
			border-radius: 0 0 15px 15px;
		}
		.navigasi ul{
			list-style: none;
			display: flex;
			justify-content: center;
			align-items: center;
			margin: 0;
			padding: 0;
		}
		.navigasi li{
			margin: 0 15px;
		}
		.navigasi a{
			text-decoration: none;
			color: white;
			padding: 10px 15px;
			border-radius: 22px;
			transition: background-color 0.3s, color 0.3s;
			font-weight: 550;
			display: flex;
			align-items: center;
			gap: 8px;
			font-size: 16px;
		}
		.navigasi a:hover, .navigasi a.active{
			background-color: #d1d1d1;
			color: #000;
			box-shadow: 0 0 8px #000;
		}
		@media (max-width: 768px){
			.navigasi ul{
				flex-direction: column;
			}
			.navigasi li{
				margin: 5px 0;
			}
		}
     
	.product-section h2 {
		margin-bottom: 20px;
		padding: 15px 0 0 0 ;
		border-bottom: 2px solid #333;
		padding-bottom: 5px;
		font-size: 24px;
	}
	*{
		scroll-behavior: smooth;
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
	</style>
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

		.right-section {
			display: flex;
			align-items: center;
			gap: 20px;
		}
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
	<h1>JUST CHECK THAT</h1>
<div class="benner">
	<video id="benner-video" autoplay muted loop>
		<source src="foto/back.mp4" type="video/mp4">
	</video>
	<div class="benner-content">
		<h1>BELI SEKARANG!</h1>
		<p>Baju yang berkualitas dan stylish</p>
	</div>
</div>
	<div class="product-section">
		<h2>Baju Pria</h2>
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
						<button class="btn btn-edit" onclick="location.href='editdata_produk.php?id=<?php echo $produk_pria['id_produk']; ?>'">Edit</button>
						<button class="btn btn-delete" onclick="location.href='hapusdata_produk.php?id=<?php echo $produk_pria['id_produk']; ?>'">Hapus</button>
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
