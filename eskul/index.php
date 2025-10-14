<?php 
require '../koneksi.php'; 
check_login_from_folder();
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Data Ekstrakurikuler</title>
    <link rel="stylesheet" href="../style.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
</head>
<body>
<div class="container">
    <header><h2>Data Ekstrakurikuler</h2></header>
    <nav>
        <a href="../index.php" class="btn btn-secondary"><i class="fas fa-home"></i> Home</a>
        <a href="tambah.php" class="btn"><i class="fas fa-plus"></i> Tambah Ekskul</a>
    </nav>
    <main>
        <div class="table-container">
            <table>
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Nama Ekstrakurikuler</th>
                        <th>Jadwal</th>
                        <th>Guru Pembina</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $no = 1;
                    $data = mysqli_query($koneksi, "SELECT * FROM ekstrakurikuler");
                    if(mysqli_num_rows($data) > 0) {
                        while($d = mysqli_fetch_array($data)){
                    ?>
                    <tr>
                        <td><?= $no++; ?></td>
                        <td><?= htmlspecialchars($d['nama_ekstra']); ?></td>
                        <td><?= htmlspecialchars($d['jadwal']); ?></td>
                        <td><?= htmlspecialchars($d['guru_ekstra']); ?></td>
                        <td class="action-buttons">
                            <a href="edit.php?id=<?= $d['id']; ?>" class="btn btn-edit"><i class="fas fa-edit"></i> Edit</a>
                            <a href="hapus.php?id=<?= $d['id']; ?>" class="btn btn-hapus" onclick="return confirm('Yakin ingin menghapus data ini?')"><i class="fas fa-trash"></i> Hapus</a>
                        </td>
                    </tr>
                    <?php 
                        }
                    } else { ?>
                    <tr>
                        <td colspan="5" style="text-align: center;">Tidak ada data.</td>
                    </tr>
                    <?php } ?>
                </tbody>
            </table>
        </div>
    </main>
</div>
</body>
</html>

