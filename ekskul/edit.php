<?php 
require '../koneksi.php'; 
check_login_from_folder();
$id = $_GET['id'];

// Pastikan ID valid
if (!filter_var($id, FILTER_VALIDATE_INT)) {
    header("Location: index.php");
    exit();
}

if(isset($_POST['update'])){
    $nama_ekstra = mysqli_real_escape_string($koneksi, $_POST['nama_ekstra']);
    $jadwal = mysqli_real_escape_string($koneksi, $_POST['jadwal']);
    $guru_ekstra = mysqli_real_escape_string($koneksi, $_POST['guru_ekstra']);
    
    mysqli_query($koneksi, "UPDATE ekstrakurikuler SET nama_ekstra='$nama_ekstra', jadwal='$jadwal', guru_ekstra='$guru_ekstra' WHERE id='$id'");
    
    echo "<script>alert('Data berhasil diperbarui');window.location='index.php';</script>";
}

$data = mysqli_query($koneksi, "SELECT * FROM ekstrakurikuler WHERE id='$id'");
$d = mysqli_fetch_array($data);

// Jika data tidak ditemukan, kembali ke index
if (!$d) {
    header("Location: index.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <title>Edit Ekstrakurikuler</title>
    <link rel="stylesheet" href="../style.css?v=<?php echo filemtime('../style.css'); ?>">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
</head>
<body>
<div class="container">
    <header><h2>Edit Data Ekstrakurikuler</h2></header>
    <main>
        <div class="form-container">
            <form method="post">
                <div class="form-group">
                    <label for="nama_ekstra">Nama Ekstrakurikuler</label>
                    <input type="text" id="nama_ekstra" name="nama_ekstra" value="<?= htmlspecialchars($d['nama_ekstra']) ?>" required>
                </div>
                <div class="form-group">
                    <label for="jadwal">Jadwal</label>
                    <input type="text" id="jadwal" name="jadwal" value="<?= htmlspecialchars($d['jadwal']) ?>" placeholder="Contoh: Setiap Sabtu, 10:00" required>
                </div>
                <div class="form-group">
                    <label for="guru_ekstra">Guru Pembina</label>
                    <input type="text" id="guru_ekstra" name="guru_ekstra" value="<?= htmlspecialchars($d['guru_ekstra']) ?>" required>
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

