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
    $_SESSION['foto_profil'] = $data_akun['foto_profil'];
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Profil Admin - NERRO SUPPLY</title>
    <link rel="stylesheet" href="style.css" />
    <link rel="icon" href="foto/logo.jpg">
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
            background-color: #ffffffff;
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
        .content {
            padding: 20px;
            background: #f4f4f4;
            min-height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
        }

        .profile-card {
            background: white;
            border-radius: 15px;
            box-shadow: 0 10px 30px rgba(0,0,0,0.1);
            max-width: 600px;
            width: 100%;
            overflow: hidden;
        }

        .profile-header {
            background: #2c3e50;
            color: white;
            padding: 20px;
            text-align: center;
            font-size: 24px;
            font-weight: bold;
            text-transform: uppercase;
        }

        .profile-body {
            padding: 30px;
            text-align: center;
        }

        .profile-image {
            width: 150px;
            height: 150px;
            border-radius: 50%;
            object-fit: cover;
            border: 4px solid #1abc9c;
            margin-bottom: 20px;
        }

        .profile-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 30px;
        }

        .profile-table th,
        .profile-table td {
            padding: 15px;
            text-align: left;
            border-bottom: 1px solid #dee2e6;
        }

        .profile-table th {
            background: #f8f9fa;
            font-weight: bold;
            color: #333;
            width: 30%;
        }

        .profile-table tr:hover {
            background: #f8f9fa;
        }

        .edit-btn {
            background: #1abc9c;
            color: white;
            padding: 12px 30px;
            border: none;
            border-radius: 25px;
            font-size: 16px;
            font-weight: bold;
            text-transform: uppercase;
            text-decoration: none;
            display: inline-block;
            transition: all 0.3s ease;
        }

        .edit-btn:hover {
            background: #16a085;
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(26, 188, 156, 0.3);
        }
         footer {
      background-color: #393939ff;
      color: #fff;
      padding: 20px 0;
      margin: 0;
      width: 99.4vw;
      position: relative;
      left: 50%;
      right: 50%;
      margin-left: -50vw;
      margin-right: -50vw;
    }

.footer-container {
      display: flex;
      justify-content: space-between;
      flex-wrap: wrap;
      padding: 0 60px;
      width: 100vw;
      position: relative;
      left: 50%;
      right: 50%;
      margin-left: -50vw;
      margin-right: -50vw;
    }

    .footer-column {
      flex: 1;
      min-width: 180px;
      margin: 10px;
    }

    .footer-column h4 {
      margin-bottom: 15px;
      font-size: 16px;
      font-weight: bold;
    }

    .footer-column ul {
      list-style: none;
      padding: 0;
      margin: 0;
    }

    .footer-column ul li {
      margin-bottom: 8px;
    }

    .footer-column ul li a {
      color: #bbb;
      text-decoration: none;
      font-size: 14px;
    }

    .footer-column ul li a:hover {
      color: #fff;
    }

    .social-icons {
      margin-top: 20px;
    }

    .social-icons a {
      display: inline-block;
      margin-right: 10px;
      color: #bbb;
      font-size: 18px;
      text-decoration: none;
    }

    .social-icons a:hover {
      color: #fff;
    }
        @media (max-width: 768px) {
            .content {
                padding: 10px;
            }

            .profile-body {
                padding: 20px;
            }

            .profile-image {
                width: 120px;
                height: 120px;
            }

            .profile-table th,
            .profile-table td {
                padding: 10px;
                font-size: 14px;
            }
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
            <li>
                <a href="dashboard_admin.php" class="<?php echo ($currentPage == 'dashboard_admin.php') ? 'active' : ''; ?>"
                    ><i class="fas fa-home"></i> HOME</a
                >
            </li>
            <li>
                <a href="tambahproduk.php" class="<?php echo ($currentPage == 'tambahproduk.php') ? 'active' : ''; ?>"
                    ><i class="fas fa-plus"></i> TAMBAH PRODUK</a
                >
            </li>
            <li>
                <a href="dataproduk_admin.php" class="<?php echo ($currentPage == 'dataproduk_admin.php') ? 'active' : ''; ?>"
                    ><i class="fas fa-box"></i> EDIT PRODUK</a
                >
            </li>
            <li>
                <a href="data_pesanan_masuk.php" class="<?php echo ($currentPage == 'data_pesanan_masuk.php') ? 'active' : ''; ?>"
                    ><i class="fas fa-list"></i> PESANAN MASUK</a
                >
            </li>
            <li>
                <a href="pesan_masuk.php" class="<?php echo ($currentPage == 'pesan_masuk.php') ? 'active' : ''; ?>"
                    ><i class="fas fa-envelope"></i> PESAN MASUK</a
                >
            </li>
        </ul>
    </div>
    <div id="overlay" onclick="toggleMenu()"></div>
    <div class="content">
        <div class="profile-card">
            <div class="profile-header">Profil Admin</div>
            <div class="profile-body">
                <img src="foto_profil/<?php echo $data_akun['foto_profil']; ?>" alt="Profile Picture" class="profile-image">

                <table class="profile-table">
                    <tbody>
                        <tr>
                            <th>ID</th>
                            <td><?php echo $data_akun['id_user']; ?></td>
                        </tr>
                        <tr>
                            <th>Nama</th>
                            <td><?php echo $data_akun['nama']; ?></td>
                        </tr>
                        <tr>
                            <th>Alamat</th>
                            <td><?php echo $data_akun['alamat']; ?></td>
                        </tr>
                        <tr>
                            <th>Status</th>
                            <td><?php echo $data_akun['status']; ?></td>
                        </tr>
                    </tbody>
                </table>

                <a href="edit_profil_admin.php?id_user=<?php echo $data_akun['id_user']; ?>" class="edit-btn">Edit Profil</a>
                <a href="data_user.php" class="edit-btn">data users</a>
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
    const menu = document.querySelector('.nav-menu');
    const overlay = document.getElementById('overlay');
    menu.classList.toggle('show');
    overlay.classList.toggle('show');
}
    </script>
</body>
</html>
