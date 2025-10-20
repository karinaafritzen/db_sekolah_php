<?php 
include '../koneksi.php';
check_login_from_folder();
$id = $_GET['id'];

if(isset($_POST['update'])){
    $nip = mysqli_real_escape_string($koneksi, $_POST['nip']);
    $nama = mysqli_real_escape_string($koneksi, $_POST['nama']);
    $mapel = mysqli_real_escape_string($koneksi, $_POST['mapel']);

    $query = "UPDATE guru SET nip='$nip', nama='$nama', mapel='$mapel' WHERE id='$id'";
    
    if(mysqli_query($koneksi, $query)) {
        header("Location: index.php?status=edit_sukses");
        exit();
    }
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
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
</head>
<body>
<div class="container">
    <header><h2>Edit Data Guru</h2></header>
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
