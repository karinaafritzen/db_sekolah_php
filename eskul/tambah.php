<?php 
require '../koneksi.php'; 
check_login_from_folder();

if(isset($_POST['simpan'])){
    $nama_ekstra = mysqli_real_escape_string($koneksi, $_POST['nama_ekstra']);
    $jadwal = mysqli_real_escape_string($koneksi, $_POST['jadwal']);
    $guru_ekstra = mysqli_real_escape_string($koneksi, $_POST['guru_ekstra']);
    
    mysqli_query($koneksi, "INSERT INTO ekstrakurikuler (nama_ekstra, jadwal, guru_ekstra) VALUES ('$nama_ekstra', '$jadwal', '$guru_ekstra')");
    
    echo "<script>alert('Data berhasil disimpan');window.location='index.php';</script>";
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <title>Tambah Ekstrakurikuler</title>
    <link rel="stylesheet" href="../style.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
</head>
<body>
<div class="container">
    <header><h2>Tambah Data Ekstrakurikuler</h2></header>
    <main>
        <div class="form-container">
            <form method="post">
                <div class="form-group">
                    <label for="nama_ekstra">Nama Ekstrakurikuler</label>
                    <input type="text" id="nama_ekstra" name="nama_ekstra" required>
                </div>
                <div class="form-group">
                    <label for="jadwal">Jadwal</label>
                    <input type="text" id="jadwal" name="jadwal" placeholder="Contoh: Setiap Sabtu, 10:00" required>
                </div>
                <div class="form-group">
                    <label for="guru_ekstra">Guru Pembina</label>
                    <input type="text" id="guru_ekstra" name="guru_ekstra" required>
                </div>
                <div class="form-buttons">
                    <button type="submit" name="simpan" class="btn"><i class="fas fa-save"></i> Simpan</button>
                    <a href="index.php" class="btn btn-secondary"><i class="fas fa-arrow-left"></i> Kembali</a>
                </div>
            </form>
        </div>
    </main>
</div>
</body>
</html>

