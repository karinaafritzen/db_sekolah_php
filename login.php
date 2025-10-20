<?php
require 'koneksi.php';

// Jika pengguna sudah login, langsung arahkan ke halaman utama
if (isset($_SESSION['login'])) {
    header('Location: index.php');
    exit();
}

$error = ''; // Variabel untuk menyimpan pesan error

// Cek ketika form disubmit
if (isset($_POST['login'])) {
    // Amankan input dari SQL Injection
    $username = mysqli_real_escape_string($koneksi, $_POST['username']);
    $password = $_POST['password']; // Tidak perlu di-hash

    $result = mysqli_query($koneksi, "SELECT * FROM users WHERE username = '$username'");

    // Cek apakah username ditemukan
    if (mysqli_num_rows($result) === 1) {
        $row = mysqli_fetch_assoc($result);
        
        // Langsung bandingkan password dari form dengan yang ada di database
        if($password === $row['password']){
            // Jika berhasil, simpan semua data pengguna ke session
            $_SESSION['login'] = true;
            $_SESSION['user_id'] = $row['id']; // PENTING!
            $_SESSION['username'] = $row['username'];
            $_SESSION['nama_lengkap'] = $row['nama_lengkap'];
            $_SESSION['email'] = $row['email'];
            $_SESSION['foto_profil'] = $row['foto_profil'];
            
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
    <link rel="stylesheet" href="style.css?v=<?php echo filemtime('style.css'); ?>">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
</head>

<body class="login-page">
    <div class="login-container">
        <form method="post" class="login-form">
            <div class="login-form-header">
                <h2>Selamat Datang</h2>
                <p>Login untuk melanjutkan ke sistem</p>
            </div>

            <?php
            if (isset($_GET['status']) && $_GET['status'] == 'deleted') {
                echo '<div class="success-message">Akun Anda telah berhasil dihapus.</div>';
            }
            ?>

            <?php if (!empty($error)): ?>
                <div class="error-message"><?= htmlspecialchars($error); ?></div>
            <?php endif; ?>

            <div class="form-group">
                <i class="fas fa-user"></i>
                <input type="text" name="username" id="username" placeholder="Username" required>
            </div>
            <div class="form-group">
                <i class="fas fa-lock"></i>
                <input type="password" name="password" id="password" placeholder="Password" required>
                <i class="fas fa-eye" id="togglePassword"></i>
            </div>
            <div class="form-buttons">
                <button type="submit" name="login" class="btn">Login</button>
            </div>
            <p class="register-link">Belum punya akun? <a href="register.php">Daftar sekarang</a></p>
        </form>
    </div>
    <script src="script.js"></script>
    </div>
</body>

</html>