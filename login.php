<?php
require 'koneksi.php';

// Jika pengguna sudah login, langsung arahkan ke halaman utama
if (isset($_SESSION['login'])) {
    header('Location: index.php');
    exit();
}

$error = ''; // Variabel untuk menyimpan pesan error

// Cek ketika form disubmit
if(isset($_POST['login'])){
    // Amankan input dari SQL Injection
    $username = mysqli_real_escape_string($koneksi, $_POST['username']);
    $password = $_POST['password'];

    $result = mysqli_query($koneksi, "SELECT * FROM users WHERE username = '$username'");

    // Cek apakah username ditemukan
    if(mysqli_num_rows($result) === 1){
        $row = mysqli_fetch_assoc($result);
        // Verifikasi password
        if(password_verify($password, $row['password'])){
            // Jika berhasil, buat session
            $_SESSION['login'] = true;
            $_SESSION['username'] = $username;
            header("Location: index.php");
            exit;
        }
    }
    
    // Jika username tidak ditemukan atau password salah
    $error = "Username atau password yang Anda masukkan salah!";
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Sistem Informasi Sekolah</title>
    <link rel="stylesheet" href="style.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
</head>
<body>
<div class="login-container">
    <form method="post" class="login-form">
        <h2>Login Sistem</h2>
        <p>Silakan masuk untuk melanjutkan</p>
        
        <!-- Tampilkan pesan error jika ada -->
        <?php if(!empty($error)): ?>
            <div class="error-message"><?= htmlspecialchars($error); ?></div>
        <?php endif; ?>

        <div class="form-group">
            <label for="username"><i class="fas fa-user"></i> Username</label>
            <input type="text" name="username" id="username" required>
        </div>
        <div class="form-group">
            <label for="password"><i class="fas fa-lock"></i> Password</label>
            <input type="password" name="password" id="password" required>
        </div>
        <div class="form-buttons">
            <button type="submit" name="login" class="btn">Login</button>
        </div>
    </form>
</div>
</body>
</html>

