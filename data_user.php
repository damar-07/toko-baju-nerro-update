<?php 
session_start();
if($_SESSION['status'] == ""){
    header("location:index.php");
    exit();
}

include 'koneksi.php';

$query_all = "SELECT * FROM tb_user";
$result_all = mysqli_query($host,$query_all);

if(isset($_GET['hapus'])){
    $id_user = $_GET['hapus'];
    $delete_query = "DELETE FROM tb_user WHERE id_user = '$id_user'";
    if(mysqli_query($host,$delete_query)){
        echo "data berhasil dihapus";
        header("location: data_user.php");
    } else{
        echo "data gagal dihapus";
    }
}

$username = $_SESSION['username'];
$query_admin = "SELECT * FROM tb_user WHERE username='$username'";
$result_admin = mysqli_query($host,$query_admin);

if(mysqli_num_rows($result_admin) > 0){
	$data_akun = mysqli_fetch_array($result_admin);
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
<html>
<head>
	<title>Toko Baju - Data User</title>
	<link rel="icon" href="foto/logo.jpg">
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
		/* Responsive Design */
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
			.navigasi ul {
				gap: 15px;
			}
			.navigasi a {
				padding: 8px 15px;
				font-size: 14px;
			}
			.table-container {
				display: none !important;
			}
			.card-container {
				display: flex !important;
				flex-direction: column !important;
			}
			.card {
				margin-bottom: 20px;
			}
			.content {
				padding: 80px 15px 40px;
			}
			.footer-container {
				padding: 0 30px;
			}
			.footer-column {
				min-width: 150px;
			}
		}

		@media (max-width: 480px) {
			.table-container {
				display: none;
			}
			.card-container {
				display: flex;
				flex-direction: column;
			}
			.card {
				margin-bottom: 20px;
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
			.content {
				padding: 80px 10px 40px;
			}
			.footer-container {
				padding: 0 20px;
			}
		}
		input[type="submit"]{
			border: none;
			background-color: brown;
			color: black;
		}
		.content{
			padding: 80px 20px 40px;
			text-align: center;
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
	/* User Data Table Styling */
	table {
	  width: 100%;
	  border-collapse: collapse;
	  margin-top: 20px;
	  font-family: 'Times New Roman', Times, serif;
	}
	table thead tr {
	  background-color: #0072ff;
	  color: white;
	  text-align: left;
	}
	table th, table td {
	  padding: 12px 15px;
	  border: 1px solid #ddd;
	}
	table tbody tr:nth-child(even) {
	  background-color: #f9f9f9;
	}
	table tbody tr:hover {
	  background-color: #e6f0ff;
	}
	table img {
	  width: 50px;
	  height: 50px;
	  object-fit: cover;
	  border-radius: 50%;
	}
	.action a {
	  margin-right: 10px;
	  padding: 6px 12px;
	  border-radius: 20px;
	  text-decoration: none;
	  font-weight: 600;
	  color: white;
	  transition: background-color 0.3s ease;
	}
	.action a.edit {
	  background-color: #00c6ff;
	}
	.action a.edit:hover {
	  background-color: #0072ff;
	}
	.action a.hapus {
	  background-color: #ff4d4d;
	}
	.action a.hapus:hover {
	  background-color: #cc0000;
	}

	/* Card layout for mobile */
	.card-container {
		display: none;
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
		max-width: 80px;
		max-height: 80px;
		object-fit: cover;
		border-radius: 50%;
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
			justify-content: center;
		}

		.card-actions a {
			padding: 8px 16px;
			border-radius: 20px;
			text-decoration: none;
			font-weight: 600;
			color: white;
			transition: all 0.3s ease;
			font-size: 14px;
		}

		.card-actions a.badge-primary {
			background-color: #0072ff;
		}

		.card-actions a.badge-primary:hover {
			background-color: #0056cc;
			transform: translateY(-2px);
		}

		.card-actions a.badge-danger {
			background-color: #ff4d4d;
		}

		.card-actions a.badge-danger:hover {
			background-color: #cc0000;
			transform: translateY(-2px);
		}
	.button {
		background-color: #0072ff;
		justify-content: center;
		color: white;
		text-align: center;
		display: inline-block;
		max-width: 300px;
		margin: 10px auto;
		padding: 10px 20px;
		border-radius: 20px;
		text-decoration: none;
		font-weight: 600;
		transition: background-color 0.3s ease;
	}
	.button a{
		color: white;
		font-weight: 600;
		transition: background-color 0.3s ease;
	}
	.button:hover{
		background-color:  #234c57ff;
		text-decoration: none;
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
<div class="table-container">
<table>
	<thead>
		<th>NO</th>
		<th>username</th>
		<th>password</th>
		<th>nama lengkap</th>
		<th>alamat</th>
		<th>status</th>
		<th>foto profil</th>
		<th>action</th>
	</thead>
	<tbody>
		<?php
		if(mysqli_num_rows($result_all) > 0){
			$no=1;
			while($rows = mysqli_fetch_assoc($result_all)){
			$photo = !empty($rows['foto_profil']) ? $rows['foto_profil'] : 'default.jpg';
			echo "<tr>";
			echo "<td>" . $no++ . "</td>";
			echo "<td>" . $rows['username'] . "</td>";
			echo "<td>" . $rows['password'] . "</td>";
			echo "<td>" . $rows['nama'] . "</td>";
			echo "<td>" . $rows['alamat'] . "</td>";
			echo "<td>" . $rows['status'] . "</td>";
			echo "<td> <img src='foto_profil/" . $photo . "' alt='foto_profil'></td>";
			echo "<td class='action'>
					<a href='editdata_user.php?id_user=" . $rows['id_user'] . "' class='edit'> Edit </a>
					<a href='hapusdata_user.php?id_user=" . $rows['id_user'] . "' class='hapus' onclick='return confirm(\"Apakah Anda yakin ingin menghapus data ini?\")'>Hapus</a>
					</td>";
			echo "</tr>";
		}
	}
		?>
	</tbody>
</table>
</div>

<div class="card-container">
	<?php
	if(mysqli_num_rows($result_all) > 0){
		mysqli_data_seek($result_all, 0); // Reset pointer
		while($rows = mysqli_fetch_assoc($result_all)){
		$photo = !empty($rows['foto_profil']) ? $rows['foto_profil'] : 'default.jpg';
		echo "<div class='card'>";
		echo "<div class='card-item'><span class='card-label'>NO:</span> <span class='card-value'>" . $rows['id_user'] . "</span></div>";
		echo "<div class='card-item'><span class='card-label'>Username:</span> <span class='card-value'>" . $rows['username'] . "</span></div>";
		echo "<div class='card-item'><span class='card-label'>Password:</span> <span class='card-value'>" . $rows['password'] . "</span></div>";
		echo "<div class='card-item'><span class='card-label'>Nama Lengkap:</span> <span class='card-value'>" . $rows['nama'] . "</span></div>";
		echo "<div class='card-item'><span class='card-label'>Alamat:</span> <span class='card-value'>" . $rows['alamat'] . "</span></div>";
		echo "<div class='card-item'><span class='card-label'>Status:</span> <span class='card-value'>" . $rows['status'] . "</span></div>";
		echo "<div class='card-img'><img src='foto_profil/" . $photo . "' alt='foto_profil' style='width: 80px; height: 80px; object-fit: cover; border-radius: 50%; border: 2px solid #e1e8ed;'></div>";
		echo "<div class='card-actions'>";
		echo "<a href='editdata_user.php?id_user=" . $rows['id_user'] . "' class='badge-primary'>Edit</a>";
		echo "<a href='hapusdata_user.php?id_user=" . $rows['id_user'] . "' class='badge-danger' onclick='return confirm(\"Apakah Anda yakin ingin menghapus data ini?\")'>Hapus</a>";
		echo "</div>";
		echo "</div>";
		}
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
