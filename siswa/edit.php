<?php 
include '../koneksi.php';
check_login_from_folder();
$id = $_GET['id'];

if(isset($_POST['update'])){
    $nis = mysqli_real_escape_string($koneksi, $_POST['nis']);
    $nama = mysqli_real_escape_string($koneksi, $_POST['nama']);
    $kelas = mysqli_real_escape_string($koneksi, $_POST['kelas']);
    $jurusan = mysqli_real_escape_string($koneksi, $_POST['jurusan']);
    
    $query = "UPDATE siswa SET nis='$nis', nama='$nama', kelas='$kelas', jurusan='$jurusan' WHERE id='$id'";

    if(mysqli_query($koneksi, $query)) {
        header("Location: index.php?status=edit_sukses");
        exit();
    }
}

$data = mysqli_query($koneksi, "SELECT * FROM siswa WHERE id='$id'");
$d = mysqli_fetch_array($data);
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Siswa</title>
    <link rel="stylesheet" href="../style.css?v=<?php echo filemtime('../style.css'); ?>">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
</head>
<body>
<div class="container">
    <header><h2>Edit Data Siswa</h2></header>
    <main>
        <div class="form-container">
            <form method="post">
                <div class="form-group">
                    <label for="nis">NIS</label>
                    <input type="text" id="nis" name="nis" value="<?= htmlspecialchars($d['nis']) ?>" required>
                </div>
                <div class="form-group">
                    <label for="nama">Nama</label>
                    <input type="text" id="nama" name="nama" value="<?= htmlspecialchars($d['nama']) ?>" required>
                </div>
                <div class="form-group">
                    <label for="kelas">Kelas</label>
                    <input type="text" id="kelas" name="kelas" value="<?= htmlspecialchars($d['kelas']) ?>" required>
                </div>
                <div class="form-group">
                    <label for="jurusan">Jurusan</label>
                    <input type="text" id="jurusan" name="jurusan" value="<?= htmlspecialchars($d['jurusan']) ?>" required>
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
