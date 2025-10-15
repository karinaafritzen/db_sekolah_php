<?php 
include '../koneksi.php';
$id = $_GET['id'];
if(isset($_POST['update'])){
    $nip = mysqli_real_escape_string($koneksi, $_POST['nip']);
    $nama = mysqli_real_escape_string($koneksi, $_POST['nama']);
    $mapel = mysqli_real_escape_string($koneksi, $_POST['mapel']);
    mysqli_query($koneksi, "UPDATE guru SET nip='$nip', nama='$nama', mapel='$mapel' WHERE id='$id'");
    echo "<script>alert('Data guru berhasil diperbarui');window.location='index.php';</script>";
}
$data = mysqli_query($koneksi, "SELECT * FROM guru WHERE id='$id'");
$d = mysqli_fetch_array($data);
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Guru</title>
    <link rel="stylesheet" href="../style.css?v=<?php echo filemtime('../style.css'); ?>">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
</head>
<body>
<div class="container">
    <header>
        <h2>Edit Data Guru</h2>
    </header>
    <main>
        <div class="form-container">
            <form method="post">
                <div class="form-group">
                    <label for="nip">NIP</label>
                    <input type="text" id="nip" name="nip" value="<?= htmlspecialchars($d['nip']) ?>" required>
                </div>
                <div class="form-group">
                    <label for="nama">Nama</label>
                    <input type="text" id="nama" name="nama" value="<?= htmlspecialchars($d['nama']) ?>" required>
                </div>
                <div class="form-group">
                    <label for="mapel">Mata Pelajaran</label>
                    <input type="text" id="mapel" name="mapel" value="<?= htmlspecialchars($d['mapel']) ?>" required>
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
