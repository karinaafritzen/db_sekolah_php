<?php
include 'koneksi.php';
check_login(); // Panggil fungsi untuk memeriksa apakah pengguna sudah login
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SMK TI Bali Global Denpasar</title>
    <link rel="stylesheet" href="style.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
</head>
<body>
<div class="container">
    <header>
        <h1>SMK TI Bali Global Denpasar</h1>
        <p>Website Manajemen Data Sekolah</p>
        <div class="header-extra">
            <span>Selamat datang, <strong><?= htmlspecialchars($_SESSION['username']); ?></strong>!</span>
            <a href="logout.php" class="btn btn-hapus"><i class="fas fa-sign-out-alt"></i> Logout</a>
        </div>
    </header>

    <main>
        <h2 class="welcome-text">Selamat Datang di Sistem Informasi Sekolah</h2>
        <div class="dashboard">
            <a href="siswa/" class="dashboard-card">
                <i class="fas fa-user-graduate card-icon"></i>
                <h3>Data Siswa</h3>
                <p>Kelola data siswa</p>
            </a>
            <a href="guru/" class="dashboard-card">
                <i class="fas fa-chalkboard-teacher card-icon"></i>
                <h3>Data Guru</h3>
                <p>Kelola data guru</p>
            </a>
            <a href="jurusan/" class="dashboard-card">
                <i class="fas fa-building card-icon"></i>
                <h3>Data Jurusan</h3>
                <p>Kelola data jurusan</p>
            </a>
            <a href="mapel/" class="dashboard-card">
                <i class="fas fa-book card-icon"></i>
                <h3>Mata Pelajaran</h3>
                <p>Kelola data mapel</p>
            </a>
            <a href="ekskul/" class="dashboard-card">
                <i class="fas fa-futbol card-icon"></i>
                <h3>Ekstrakurikuler</h3>
                <p>Kelola data ekskul</p>
            </a>
        </div>
    </main>
</div>
</body>
</html>

