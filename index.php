<?php
require 'koneksi.php';
check_login();

$user_id = $_SESSION['user_id'];
$username = $_SESSION['username'];
$nama_lengkap = $_SESSION['nama_lengkap'];
$foto_profil = $_SESSION['foto_profil'];
$email = $_SESSION['email'];
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Admin</title>
    <link rel="stylesheet" href="style.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
</head>
<body>
    <div class="container">
        <header>
            <h1>SMK TI Bali Global Denpasar</h1>
            <p>Website Manajemen Data Sekolah</p>
        </header>

        <nav>
            <div class="user-info">
                <img src="uploads/<?= htmlspecialchars($foto_profil); ?>" alt="Profile" class="profile-thumb">
                <span>Selamat datang, <?= htmlspecialchars($nama_lengkap); ?></span>
                <a href="profile.php" class="btn btn-profile"><i class="fas fa-user-cog"></i> Profil Saya</a>
            </div>
            <a href="logout.php" class="btn btn-danger"><i class="fas fa-sign-out-alt"></i> Logout</a>
        </nav>

        <main>
            <h2>Selamat Datang di Sistem Informasi Sekolah</h2>
            <div class="dashboard-grid">
                <a href="siswa/index.php" class="dashboard-card">
                    <i class="fas fa-graduation-cap"></i>
                    <h3>Data Siswa</h3>
                    <p>Kelola data siswa</p>
                </a>
                <a href="guru/index.php" class="dashboard-card">
                    <i class="fas fa-chalkboard-teacher"></i>
                    <h3>Data Guru</h3>
                    <p>Kelola data guru</p>
                </a>
                <a href="jurusan/index.php" class="dashboard-card">
                    <i class="fas fa-building"></i>
                    <h3>Data Jurusan</h3>
                    <p>Kelola data jurusan</p>
                </a>
                <a href="mapel/index.php" class="dashboard-card">
                    <i class="fas fa-book"></i>
                    <h3>Mata Pelajaran</h3>
                    <p>Kelola data mapel</p>
                </a>
                <a href="ekskul/index.php" class="dashboard-card">
                    <i class="fas fa-futbol"></i>
                    <h3>Ekstrakurikuler</h3>
                    <p>Kelola data ekskul</p>
                </a>
            </div>
        </main>
    </div>
</body>
</html>