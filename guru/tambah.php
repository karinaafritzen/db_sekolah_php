<?php 
include '../koneksi.php';
check_login_from_folder();

if(isset($_POST['simpan'])){
    $nip = mysqli_real_escape_string($koneksi, $_POST['nip']);
    $nama = mysqli_real_escape_string($koneksi, $_POST['nama']);
    $mapel = mysqli_real_escape_string($koneksi, $_POST['mapel']);
    
    $query = "INSERT INTO guru (nip,nama,mapel) VALUES ('$nip','$nama','$mapel')";

    if(mysqli_query($koneksi, $query)) {
        header("Location: index.php?status=tambah_sukses");
        exit();
    }
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tambah Guru</title>
    <link rel="stylesheet" href="../style.css?v=<?php echo filemtime('../style.css'); ?>">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
</head>
<body>
<div class="container">
    <header><h2>Tambah Data Guru</h2></header>
    <main>
        <div class="form-container">
            <form method="post">
                <div class="form-group">
                    <label for="nip">NIP</label>
                    <input type="text" id="nip" name="nip" required>
                </div>
                <div class="form-group">
                    <label for="nama">Nama</label>
                    <input type="text" id="nama" name="nama" required>
                </div>
                <div class="form-group">
                    <label for="mapel">Mata Pelajaran</label>
                    <input type="text" id="mapel" name="mapel" required>
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
