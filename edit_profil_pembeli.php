<?php  
include 'koneksi.php';
session_start();

if($_SESSION['status'] == ""){
    header("location:index.php");
    exit();
}
$id_user = $_GET['id_user'];

$query = "SELECT * FROM tb_user WHERE id_user='$id_user'";
$result = mysqli_query($host,$query);

if(mysqli_num_rows($result) > 0 ){
    $data_akun = mysqli_fetch_array($result);
}else{
    echo "user tidak ditemukan";
}

if(isset($_POST['update'])){
    $nama = mysqli_real_escape_string($host, $_POST['nama']);
    $alamat = mysqli_real_escape_string($host, $_POST['alamat']);
    $nomor_telepon = mysqli_real_escape_string($host, $_POST['nomor_telepon']);
    $foto_profil = $data_akun['foto_profil']; // default to current

    if(!empty($_FILES['foto_profil']['name'])){
        $target_dir = "foto_profil/";
        $target_file = $target_dir . basename($_FILES['foto_profil']['name']);
        $uploadok = 1;
        $imagefiletype = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

        $check = getimagesize($_FILES['foto_profil']['tmp_name']);
        if($check !== false){
            $uploadok = 1;
        }else{
            echo "<script>alert('File ini bukan gambar');</script>";
            $uploadok = 0;
        }
        if($_FILES['foto_profil']['size'] > 2000000){
            echo "<script>alert('Ukuran file terlalu besar');</script>";
            $uploadok = 0;
        }

        if($imagefiletype != "jpg" && $imagefiletype != "png" && $imagefiletype != "jpeg" && $imagefiletype != "gif"){
            echo "<script>alert('Hanya JPG, PNG, JPEG, dan GIF yang diperbolehkan');</script>";
            $uploadok = 0;
        }

        if($uploadok == 1){
            if(move_uploaded_file($_FILES['foto_profil']['tmp_name'], $target_file)){
                $foto_profil = basename($_FILES['foto_profil']['name']);
            }else{
                echo "<script>alert('Gagal mengunggah gambar');</script>";
            }
        }
    }

    $update_query = "UPDATE tb_user SET nama='$nama', alamat='$alamat', nomor_telepon='$nomor_telepon', foto_profil='$foto_profil' WHERE id_user='$id_user'";
    if(mysqli_query($host, $update_query)){
        echo "<script>alert('Data berhasil diperbarui'); window.location='profil_pembeli.php';</script>";
    }else{
        echo "<script>alert('Data gagal diperbarui');</script>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Toko Baju - Edit Profil</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="icon" href="foto/logo.jpg">
    <link rel="stylesheet" href="style.css">
    <style>
        .content {
            padding: 20px;
            background: #f4f4f4;
            min-height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
        }

        .edit-form {
            background: white;
            border-radius: 15px;
            box-shadow: 0 10px 30px rgba(0,0,0,0.1);
            max-width: 600px;
            width: 100%;
            padding: 30px;
        }

        .form-header {
            text-align: center;
            margin-bottom: 30px;
            color: #2c3e50;
            font-size: 28px;
            font-weight: bold;
            text-transform: uppercase;
        }

        .form-group {
            margin-bottom: 20px;
        }

        label {
            display: block;
            margin-bottom: 5px;
            font-weight: bold;
            color: #333;
            text-transform: uppercase;
            font-size: 14px;
        }

        input[type="text"],
        textarea {
            width: 100%;
            padding: 12px;
            border: 2px solid #ddd;
            border-radius: 8px;
            font-size: 16px;
            transition: border-color 0.3s ease;
            box-sizing: border-box;
        }

        input[type="text"]:focus,
        textarea:focus {
            outline: none;
            border-color: #1abc9c;
        }

        textarea {
            resize: vertical;
            min-height: 80px;
        }

        .current-image {
            max-width: 150px;
            height: auto;
            border-radius: 8px;
            margin-bottom: 10px;
            border: 2px solid #ddd;
        }

        input[type="file"] {
            margin-bottom: 20px;
        }

        .button-group {
            display: flex;
            gap: 15px;
            justify-content: center;
            margin-top: 30px;
        }

        .btn {
            padding: 12px 30px;
            border: none;
            border-radius: 25px;
            font-size: 16px;
            font-weight: bold;
            text-transform: uppercase;
            cursor: pointer;
            transition: all 0.3s ease;
            text-decoration: none;
            display: inline-block;
        }

        .btn-primary {
            background: #1abc9c;
            color: white;
        }

        .btn-primary:hover {
            background: #16a085;
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(26, 188, 156, 0.3);
        }

        .btn-secondary {
            background: #95a5a6;
            color: white;
        }

        .btn-secondary:hover {
            background: #7f8c8d;
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(127, 140, 141, 0.3);
        }

        @media (max-width: 768px) {
            .content {
                padding: 10px;
            }

            .edit-form {
                padding: 20px;
            }

            .form-header {
                font-size: 24px;
            }

            .button-group {
                flex-direction: column;
                align-items: center;
            }

            .btn {
                width: 100%;
                max-width: 200px;
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
<div id="overlay" onclick="toggleMenu()"></div>
<div class="content">
    <div class="edit-form">
        <div class="form-header">Edit Profil</div>
        <form action="" method="post" enctype="multipart/form-data">
            <div class="form-group">
                <label for="nama">Nama Lengkap</label>
                <input type="text" name="nama" id="nama" value="<?php echo htmlspecialchars($data_akun['nama']); ?>" required>
            </div>

            <div class="form-group">
                <label for="alamat">Alamat</label>
                <textarea name="alamat" id="alamat" required><?php echo htmlspecialchars($data_akun['alamat']); ?></textarea>
            </div>

            <div class="form-group">
                <label for="nomor_telepon">Nomor Telepon</label>
                <input type="text" name="nomor_telepon" id="nomor_telepon" value="<?php echo htmlspecialchars($data_akun['nomor_telepon']); ?>" required>
            </div>

            <div class="form-group">
                <label for="foto_profil">Foto Profil Saat Ini</label>
                <img src="foto_profil/<?php echo htmlspecialchars($data_akun['foto_profil']); ?>" alt="Foto Profil" class="current-image">
                <input type="file" name="foto_profil" id="foto_profil" accept="image/*">
                <small style="color: #666;">Biarkan kosong jika tidak ingin mengubah foto profil. Format: JPG, PNG, JPEG, GIF. Maksimal 2MB.</small>
            </div>

            <div class="button-group">
                <button type="submit" name="update" class="btn btn-primary">Update Data</button>
                <a href="profil_pembeli.php" class="btn btn-secondary">Kembali</a>
            </div>
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
        const nav = document.querySelector('.navigasi ul');
        nav.classList.toggle('active');
    }
</script>
</body>
</html>
