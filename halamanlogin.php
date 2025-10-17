<?php
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Toko Baju - Login</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
    <link rel="icon" href="foto/logo.jpg">
    <link rel="stylesheet" href="form.css">
    <style>
        body {
            background: linear-gradient(to right, #d7d7d7ff, #c8c8c8ff) !important;
            padding: 20px;
            box-sizing: border-box;
        }
        .toggle {
            background: linear-gradient(to right, #000, #333);
        }
        .toggle-panel h1, .toggle-panel p {
            color: #fff !important;
        }
        .container button.hidden {
            color: #fff !important;
        }
        .login-header {
            text-align: center;
            padding: 20px;
            background: rgba(255,255,255,0.9);
            margin-bottom: 20px;
            border-radius: 15px;
            box-shadow: 0 4px 10px rgba(0,0,0,0.1);
        }
        .login-header img {
            max-width: 150px;
            height: auto;
        }
        .login-header .site-name {
            font-size: 24px;
            font-weight: bold;
            color: #2c3e50;
            margin-top: 10px;
        }
        .login-header .tagline {
            color: #1abc9c;
            font-style: italic;
        }
        @media (max-width: 768px) {
            body {
                padding: 10px;
            }
            .login-header {
                padding: 15px;
                margin-bottom: 15px;
            }
            .login-header img {
                max-width: 120px;
            }
            .login-header .site-name {
                font-size: 20px;
            }
        }
        @media (max-width: 480px) {
            .login-header {
                padding: 10px;
            }
            .login-header img {
                max-width: 100px;
            }
            .login-header .site-name {
                font-size: 18px;
            }
            .login-header .tagline {
                font-size: 14px;
            }
        }
    </style>
</head>
<body>
    <div class="container" id="container">
        <div class="form-container sign-up">
            <form action="proses-register.php" method="post" enctype="multipart/form-data">
                <h1>buat akun</h1>
            <div class="social-icon">
                <a href="" class="icon"><i class="fa-brands fa-instagram"></i></a>
                <a href="" class="icon"><i class="fa-solid fa-location-dot"></i></a>
                <a href="https://github.com/damar-07" class="icon"><i class="fa-brands fa-github"></i></a>
                <a href="#" class="icon"><i class="fa-brands fa-youtube"></i></a>
            </div>
                <span>sign-up dengan</span>
                <input type="text" name="nama" id="" placeholder="nama lengkap kamu" required>
                <input type="text" name="username" id="" placeholder="username kamu" required>
                <input type="password" name="password" id="" placeholder="password kamu" required>
                <input type="text" name="alamat" id="alamat" placeholder="masukan alamat">
                <input type="text" name="nomor_telepon" placeholder="masukan nomor telepon" required>
                <label for="file" style="text-align: left; justify-items:left;">foto profil:</label>
                <input type="file" name="foto_profil" id="foto_profil" accept="image/*" required>
                <button type="submit" name="submit">sign-up</button>
            </form>
        </div>
        <div class="form-container sign-in">
        <form action="cek_login.php" method="post">
                <h1>Log-in</h1>
                <div class="social-icon">
                <a href="" class="icon"><i class="fa-brands fa-instagram"></i></a>
                <a href="" class="icon"><i class="fa-solid fa-location-dot"></i></a>
                <a href="https://github.com/damar-07" class="icon"><i class="fa-brands fa-github"></i></a>
                <a href="#" class="icon"><i class="fa-brands fa-youtube"></i></a>
            </div>
                <span>sign-in dengan</span>
                <input type="text" name="username" placeholder="username" required>
                <input type="password" name="password" placeholder="password" required>
                <a href="javascript:void(0)" id="belum" onclick="toggleForm('sign-up')">belum punya akun?</a>
                <button type="submit">sign-in</button>
            </form>
    </div>
    <div class="toggle-container">
        <div class="toggle">
            <div class="toggle-panel toggle-left">
                <h1>selamat datang</h1>
                <p>masukan data pribadi kamu</p>
                <button class="hidden" id="sign-in" type="submit">sign-in</button>
            </div>
            <div class="toggle-panel toggle-right">
                <h1>selamat datang kembali</h1>
                <p>masukan data pribadi kamu</p>
                <button class="hidden" id="sign-up" type="submit">sign-up</button>
            </div>
        </div>
    </div>
    <script src="script.js"></script>
</body>
</html>
