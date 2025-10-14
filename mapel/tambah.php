<?php 
include '../koneksi.php'; 
check_login_from_folder();

if(isset($_POST['simpan'])){
    $nama_mapel = mysqli_real_escape_string($koneksi, $_POST['nama_mapel']);
    $kelas = mysqli_real_escape_string($koneksi, $_POST['kelas']);
    $guru_pengajar = mysqli_real_escape_string($koneksi, $_POST['guru_pengajar']);
    mysqli_query($koneksi, "INSERT INTO mata_pelajaran (nama_mapel, kelas, guru_pengajar) VALUES ('$nama_mapel', '$kelas', '$guru_pengajar')");
    echo "<script>alert('Data berhasil disimpan');window.location='index.php';</script>";
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <title>Tambah Mata Pelajaran</title>
    <link rel="stylesheet" href="../style.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
</head>
<body>
<div class="container">
    <header><h2>Tambah Data Mata Pelajaran</h2></header>
    <main>
        <div class="form-container">
            <form method="post">
                <div class="form-group">
                    <label for="nama_mapel">Nama Mata Pelajaran</label>
                    <input type="text" id="nama_mapel" name="nama_mapel" required>
                </div>
                <div class="form-group">
                    <label for="kelas">Kelas</label>
                    <input type="text" id="kelas" name="kelas" required>
                </div>
                <div class="form-group">
                    <label for="guru_pengajar">Guru Pengajar</label>
                    <input type="text" id="guru_pengajar" name="guru_pengajar" required>
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
