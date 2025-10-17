<?php
session_start();

if($_SESSION['status'] != "admin") {
    header("location:index.php");
    exit();
}

include 'koneksi.php';

// Handle reply submission
if(isset($_POST['balas'])) {
    $id_kontak = mysqli_real_escape_string($host, $_POST['id_kontak']);
    $balasan = mysqli_real_escape_string($host, $_POST['balasan']);

    // Insert reply
    $query_balas = "INSERT INTO balasan_kontak (id_kontak, balasan, tanggal_balasan)
                   VALUES ('$id_kontak', '$balasan', NOW())";

    // Update message status
    $query_update = "UPDATE kontak SET status = 'sudah_dibalas' WHERE id_kontak = '$id_kontak'";

    if(mysqli_query($host, $query_balas) && mysqli_query($host, $query_update)) {
        echo "<script>alert('Balasan berhasil dikirim!'); window.location='pesan_masuk.php';</script>";
    } else {
        echo "<script>alert('Gagal mengirim balasan.');</script>";
    }
}

// Handle mark as read
if(isset($_GET['mark_read'])) {
    $id_kontak = mysqli_real_escape_string($host, $_GET['mark_read']);
    $query = "UPDATE kontak SET status = 'sudah_dibaca' WHERE id_kontak = '$id_kontak'";
    mysqli_query($host, $query);
    header("location:pesan_masuk.php");
    exit();
}

// Handle delete message
if(isset($_GET['delete'])) {
    $id_kontak = mysqli_real_escape_string($host, $_GET['delete']);

    // Delete reply first (if exists)
    $query_delete_reply = "DELETE FROM balasan_kontak WHERE id_kontak = '$id_kontak'";
    mysqli_query($host, $query_delete_reply);

    // Delete message
    $query_delete_message = "DELETE FROM kontak WHERE id_kontak = '$id_kontak'";
    if(mysqli_query($host, $query_delete_message)) {
        echo "<script>alert('Pesan berhasil dihapus!'); window.location='pesan_masuk.php';</script>";
    } else {
        echo "<script>alert('Gagal menghapus pesan.');</script>";
    }
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pesan Masuk - Admin</title>
    <link rel="icon" href="foto/logo.jpg">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="style.css">
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
            padding: 10px 10px;
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

        .content {
            padding: 20px;
            background: #f4f4f4;
        }

        .messages-container {
            max-width: 1000px;
            margin: 0 auto;
            background: white;
            border-radius: 15px;
            box-shadow: 0 10px 30px rgba(0,0,0,0.1);
            padding: 30px;
        }

        .page-header {
            text-align: center;
            margin-bottom: 30px;
            color: #2c3e50;
            font-size: 28px;
            font-weight: bold;
            text-transform: uppercase;
        }

        .message-item {
            background: #f8f9fa;
            border-radius: 10px;
            padding: 20px;
            margin-bottom: 20px;
            border-left: 5px solid #007bff;
        }

        .message-item.unread {
            border-left-color: #ffc107;
            background: #fff3cd;
        }

        .message-item.replied {
            border-left-color: #28a745;
            background: #d4edda;
        }

        .message-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 15px;
        }

        .message-info {
            display: flex;
            gap: 20px;
            align-items: center;
        }

        .message-actions {
            display: flex;
            gap: 10px;
        }

        .btn {
            padding: 8px 15px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-size: 14px;
            text-decoration: none;
            display: inline-block;
            transition: all 0.3s ease;
        }

        .btn-primary {
            background: #007bff;
            color: white;
        }

        .btn-primary:hover {
            background: #0056b3;
        }

        .btn-success {
            background: #28a745;
            color: white;
        }

        .btn-success:hover {
            background: #218838;
        }

        .btn-warning {
            background: #ffc107;
            color: #212529;
        }

        .btn-warning:hover {
            background: #e0a800;
        }

        .btn-danger {
            background: #dc3545;
            color: white;
        }

        .btn-danger:hover {
            background: #c82333;
        }

        .message-content {
            margin-bottom: 15px;
        }

        .message-content p {
            margin: 5px 0;
        }

        .reply-section {
            background: white;
            border-radius: 8px;
            padding: 20px;
            margin-top: 15px;
            border: 1px solid #dee2e6;
        }

        .reply-form textarea {
            width: 100%;
            padding: 10px;
            border: 1px solid #ddd;
            border-radius: 5px;
            resize: vertical;
            font-family: inherit;
        }

        .reply-form .btn {
            margin-top: 10px;
        }

        .status-badge {
            padding: 4px 8px;
            border-radius: 12px;
            font-size: 12px;
            font-weight: bold;
            text-transform: uppercase;
        }

        .status-unread {
            background: #ffc107;
            color: #212529;
        }

        .status-read {
            background: #17a2b8;
            color: white;
        }

        .status-replied {
            background: #28a745;
            color: white;
        }

        .no-messages {
            text-align: center;
            color: #666;
            font-style: italic;
            padding: 50px;
        }

        @media (max-width: 768px) {
            .content {
                padding: 10px;
            }

            .messages-container {
                padding: 20px;
            }

            .message-header {
                flex-direction: column;
                align-items: flex-start;
                gap: 10px;
            }

            .message-info {
                flex-direction: column;
                align-items: flex-start;
                gap: 5px;
            }

            .message-actions {
                width: 100%;
                justify-content: flex-end;
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
<div class="content">
    <div class="messages-container">
        <div class="page-header">Pesan Masuk</div>

        <?php
        $query = "SELECT k.*, u.nama as nama_user,
                         b.balasan, b.tanggal_balasan
                  FROM kontak k
                  LEFT JOIN tb_user u ON k.id_user = u.id_user
                  LEFT JOIN balasan_kontak b ON k.id_kontak = b.id_kontak
                  ORDER BY k.tanggal_kirim DESC";
        $result = mysqli_query($host, $query);

        if(mysqli_num_rows($result) > 0) {
            while($message = mysqli_fetch_assoc($result)) {
                $status_class = $message['status'] == 'belum_dibaca' ? 'unread' :
                               ($message['status'] == 'sudah_dibalas' ? 'replied' : '');
                $status_badge = $message['status'] == 'belum_dibaca' ? 'status-unread' :
                               ($message['status'] == 'sudah_dibalas' ? 'status-replied' : 'status-read');
                ?>
                <div class="message-item <?php echo $status_class; ?>">
                    <div class="message-header">
                        <div class="message-info">
                            <strong><?php echo htmlspecialchars($message['nama']); ?> (<?php echo htmlspecialchars($message['nama_user']); ?>)</strong>
                            <span><?php echo date('d-m-Y H:i', strtotime($message['tanggal_kirim'])); ?></span>
                            <span class="status-badge <?php echo $status_badge; ?>">
                                <?php echo str_replace('_', ' ', $message['status']); ?>
                            </span>
                        </div>
                        <div class="message-actions">
                            <?php if($message['status'] == 'belum_dibaca') { ?>
                                <a href="?mark_read=<?php echo $message['id_kontak']; ?>" class="btn btn-warning">Tandai Dibaca</a>
                            <?php } ?>
                            <button class="btn btn-primary" onclick="toggleReply(<?php echo $message['id_kontak']; ?>)">
                                <i class="fas fa-reply"></i> Balas
                            </button>
                            <a href="?delete=<?php echo $message['id_kontak']; ?>" class="btn btn-danger" onclick="return confirm('Apakah Anda yakin ingin menghapus pesan ini?')">
                                <i class="fas fa-trash"></i> Hapus
                            </a>
                        </div>
                    </div>

                    <div class="message-content">
                        <p><strong>Subjek:</strong> <?php echo htmlspecialchars($message['subjek']); ?></p>
                        <p><strong>Pesan:</strong></p>
                        <p><?php echo nl2br(htmlspecialchars($message['pesan'])); ?></p>
                    </div>

                    <?php if($message['balasan']) { ?>
                        <div class="admin-reply" style="background: #e9ecef; padding: 15px; border-radius: 5px; margin-top: 15px;">
                            <p><strong>Balasan Anda (<?php echo date('d-m-Y H:i', strtotime($message['tanggal_balasan'])); ?>):</strong></p>
                            <p><?php echo nl2br(htmlspecialchars($message['balasan'])); ?></p>
                        </div>
                    <?php } ?>

                    <div id="reply-form-<?php echo $message['id_kontak']; ?>" class="reply-section" style="display: none;">
                        <form method="post" class="reply-form">
                            <input type="hidden" name="id_kontak" value="<?php echo $message['id_kontak']; ?>">
                            <textarea name="balasan" rows="4" placeholder="Tulis balasan Anda di sini..." required></textarea>
                            <button type="submit" name="balas" class="btn btn-success">Kirim Balasan</button>
                        </form>
                    </div>
                </div>
                <?php
            }
        } else {
            echo '<div class="no-messages">Belum ada pesan masuk</div>';
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

function toggleReply(id) {
    const form = document.getElementById('reply-form-' + id);
    if(form.style.display === 'none' || form.style.display === '') {
        form.style.display = 'block';
    } else {
        form.style.display = 'none';
    }
}
</script>
</body>
</html>
