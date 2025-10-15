<?php 
include '../koneksi.php'; 
check_login_from_folder();
$id = $_GET['id'];

if(isset($_POST['update'])){
    $nama_mapel = mysqli_real_escape_string($koneksi, $_POST['nama_mapel']);
    $kelas = mysqli_real_escape_string($koneksi, $_POST['kelas']);
    $guru_pengajar = mysqli_real_escape_string($koneksi, $_POST['guru_pengajar']);
    mysqli_query($koneksi, "UPDATE mata_pelajaran SET nama_mapel='$nama_mapel', kelas='$kelas', guru_pengajar='$guru_pengajar' WHERE id='$id'");
    echo "<script>alert('Data berhasil diperbarui');window.location='index.php';</script>";
}

$data = mysqli_query($koneksi, "SELECT * FROM mata_pelajaran WHERE id='$id'");
$d = mysqli_fetch_array($data);
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <title>Edit Mata Pelajaran</title>
    <link rel="stylesheet" href="../style.css?v=<?php echo filemtime('../style.css'); ?>">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
</head>
<body>
<div class="container">
    <header><h2>Edit Data Mata Pelajaran</h2></header>
    <main>
        <div class="form-container">
            <form method="post">
                <div class="form-group">
                    <label for="nama_mapel">Nama Mata Pelajaran</label>
                    <input type="text" id="nama_mapel" name="nama_mapel" value="<?= htmlspecialchars($d['nama_mapel']) ?>" required>
                </div>
                <div class="form-group">
                    <label for="kelas">Kelas</label>
                    <input type="text" id="kelas" name="kelas" value="<?= htmlspecialchars($d['kelas']) ?>" required>
                </div>
                <div class="form-group">
                    <label for="guru_pengajar">Guru Pengajar</label>
                    <input type="text" id="guru_pengajar" name="guru_pengajar" value="<?= htmlspecialchars($d['guru_pengajar']) ?>" required>
                </div>
                <div class="form-buttons">
                    <button type="submit" name="update" class="btn"><i class="fas fa-save"></i> Simpan Perubahan</button>
                    <a href="index.php" class="btn btn-secondary"><i class="fas fa-arrow-left"></i> Kembali</a>
                </div>
            </form>
        </div>
    </main>
</div>
</body>
</html>
