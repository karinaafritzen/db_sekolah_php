<?php
require 'koneksi.php';

// Jika pengguna sudah login, arahkan ke dashboard
if (isset($_SESSION['login'])) {
    header('Location: index.php');
    exit();
}

$error = '';

if (isset($_POST['register'])) {
    $username = mysqli_real_escape_string($koneksi, $_POST['username']);
    $nama_lengkap = mysqli_real_escape_string($koneksi, $_POST['nama_lengkap']);
    $email = mysqli_real_escape_string($koneksi, $_POST['email']);
    $password = $_POST['password'];
    $confirm_password = $_POST['confirm_password'];

    // Validasi input
    if (empty($username) || empty($nama_lengkap) || empty($email) || empty($password) || empty($confirm_password)) {
        $error = "Semua kolom harus diisi.";
    } elseif ($password !== $confirm_password) {
        $error = "Konfirmasi password tidak cocok.";
    } elseif (strlen($password) < 6) {
        $error = "Password minimal 6 karakter.";
    } else {
        // Cek apakah username atau email sudah ada
        $check_user = mysqli_query($koneksi, "SELECT * FROM users WHERE username = '$username' OR email = '$email'");
        if (mysqli_num_rows($check_user) > 0) {
            $error = "Username atau Email sudah terdaftar.";
        } else {
            // Menggunakan teks biasa sesuai permintaan, TAPI TIDAK AMAN
            $query = "INSERT INTO users (username, password, nama_lengkap, email) VALUES ('$username', '$password', '$nama_lengkap', '$email')";
            
            if (mysqli_query($koneksi, $query)) {
                // Jika berhasil, tampilkan alert dan redirect menggunakan JavaScript
                echo "<script>
                        alert('Registrasi berhasil! Anda akan diarahkan ke halaman login.');
                        window.location.href = 'login.php';
                      </script>";
                exit(); // Hentikan eksekusi script setelah redirect
            } else {
                $error = "Registrasi gagal, silakan coba lagi.";
            }
        }
    }
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar Akun Baru</title>
    <link rel="stylesheet" href="style.css?v=<?php echo filemtime('style.css'); ?>">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
</head>
<body class="login-page">
<div class="login-container">
    <form method="post" class="login-form">
        <div class="login-form-header">
            <h2>Buat Akun Baru</h2>
            <p>Daftarkan diri Anda untuk mengakses sistem</p>
        </div>
        
        <?php if(!empty($error)): ?>
            <div class="error-message"><?= htmlspecialchars($error); ?></div>
        <?php endif; ?>

        <div class="form-group">
            <i class="fas fa-user"></i>
            <input type="text" name="nama_lengkap" placeholder="Nama Lengkap" required>
        </div>
        <div class="form-group">
            <i class="fas fa-user-circle"></i>
            <input type="text" name="username" placeholder="Username" required>
        </div>
        <div class="form-group">
            <i class="fas fa-envelope"></i>
            <input type="email" name="email" placeholder="Email" required>
        </div>
        <div class="form-group">
            <i class="fas fa-lock"></i>
            <input type="password" name="password" id="password" placeholder="Password" required>
            <i class="fas fa-eye" id="togglePassword"></i>
        </div>
        <div class="form-group">
            <i class="fas fa-lock"></i>
            <input type="password" name="confirm_password" id="confirm_password" placeholder="Konfirmasi Password" required>
            <i class="fas fa-eye" id="toggleConfirmPassword"></i>
        </div>
        
        <div class="form-buttons">
            <button type="submit" name="register" class="btn">Daftar</button>
        </div>
        <p class="login-link">Sudah punya akun? <a href="login.php">Login di sini</a></p>
    </form>
</div>

<script>
    // Fungsi untuk mengaktifkan toggle password
    function setupPasswordToggle(toggleId, passwordId) {
        const toggleButton = document.getElementById(toggleId);
        const passwordInput = document.getElementById(passwordId);

        if (toggleButton && passwordInput) {
            toggleButton.addEventListener('click', function() {
                const type = passwordInput.getAttribute('type') === 'password' ? 'text' : 'password';
                passwordInput.setAttribute('type', type);
                this.classList.toggle('fa-eye-slash');
            });
        }
    }

    // Terapkan fungsi pada kedua input password
    setupPasswordToggle('togglePassword', 'password');
    setupPasswordToggle('toggleConfirmPassword', 'confirm_password');
</script>

</body>
</html>