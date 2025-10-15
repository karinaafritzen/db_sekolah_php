<?php 
include '../koneksi.php';
$id = $_GET['id'];
if(isset($_POST['update'])){
    $kode = mysqli_real_escape_string($koneksi, $_POST['kode']);
    $nama_jurusan = mysqli_real_escape_string($koneksi, $_POST['nama_jurusan']);
    mysqli_query($koneksi, "UPDATE jurusan SET kode='$kode', nama_jurusan='$nama_jurusan' WHERE id='$id'");
    echo "<script>alert('Data jurusan berhasil diperbarui');window.location='index.php';</script>";
}
$data = mysqli_query($koneksi, "SELECT * FROM jurusan WHERE id='$id'");
$d = mysqli_fetch_array($data);
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Jurusan</title>
    <link rel="stylesheet" href="../style.css?v=<?php echo filemtime('../style.css'); ?>">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
</head>
<body>
<div class="container">
    <header>
        <h2>Edit Data Jurusan</h2>
    </header>
    <main>
        <div class="form-container">
            <form method="post">
                <div class="form-group">
                    <label for="kode">Kode Jurusan</label>
                    <input type="text" id="kode" name="kode" value="<?= htmlspecialchars($d['kode']) ?>" required>
                </div>
                <div class="form-group">
                    <label for="nama_jurusan">Nama Jurusan</label>
                    <input type="text" id="nama_jurusan" name="nama_jurusan" value="<?= htmlspecialchars($d['nama_jurusan']) ?>" required>
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
