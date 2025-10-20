<?php 
include '../koneksi.php';
check_login_from_folder();

if(isset($_POST['simpan'])){
    $nis = mysqli_real_escape_string($koneksi, $_POST['nis']);
    $nama = mysqli_real_escape_string($koneksi, $_POST['nama']);
    $kelas = mysqli_real_escape_string($koneksi, $_POST['kelas']);
    $jurusan = mysqli_real_escape_string($koneksi, $_POST['jurusan']);
    
    $query = "INSERT INTO siswa (nis,nama,kelas,jurusan) VALUES ('$nis','$nama','$kelas','$jurusan')";
    
    if(mysqli_query($koneksi, $query)) {
        header("Location: index.php?status=tambah_sukses");
        exit();
    } else {
        // Opsi: redirect dengan status gagal jika perlu
        header("Location: tambah.php?status=gagal");
        exit();
    }
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tambah Siswa</title>
    <link rel="stylesheet" href="../style.css?v=<?php echo filemtime('../style.css'); ?>">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
</head>
<body>
<div class="container">
    <header><h2>Tambah Data Siswa</h2></header>
    <main>
        <div class="form-container">
            <form method="post">
                <div class="form-group">
                    <label for="nis">NIS</label>
                    <input type="text" id="nis" name="nis" required>
                </div>
                <div class="form-group">
                    <label for="nama">Nama</label>
                    <input type="text" id="nama" name="nama" required>
                </div>
                <div class="form-group">
                    <label for="kelas">Kelas</label>
                    <input type="text" id="kelas" name="kelas" required>
                </div>
                <div class="form-group">
                    <label for="jurusan">Jurusan</label>
                    <input type="text" id="jurusan" name="jurusan" required>
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
