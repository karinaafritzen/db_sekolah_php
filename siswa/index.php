<?php
include '../koneksi.php';
check_login_from_folder();

$modal_message = '';
// Cek status dari URL untuk menampilkan pesan
if (isset($_GET['status'])) {
    if ($_GET['status'] == 'tambah_sukses') {
        $modal_message = "Data siswa baru berhasil ditambahkan!";
    } elseif ($_GET['status'] == 'edit_sukses') {
        $modal_message = "Data siswa berhasil diperbarui!";
    } elseif ($_GET['status'] == 'hapus_sukses') {
        $modal_message = "Data siswa berhasil dihapus!";
    }
}
?>
<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Data Siswa</title>
    <link rel="stylesheet" href="../style.css?v=<?php echo filemtime('../style.css'); ?>">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
</head>

<body>
    <div class="container">
        <header>
            <h2>Data Siswa</h2>
        </header>
        <nav>
            <a href="../index.php" class="btn btn-secondary"><i class="fas fa-home"></i> Home</a>
            <a href="tambah.php" class="btn"><i class="fas fa-plus"></i> Tambah Siswa</a>
        </nav>
        <main>
            <div class="table-container">
                <table>
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>NIS</th>
                            <th>Nama</th>
                            <th>Kelas</th>
                            <th>Jurusan</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $no = 1;
                        $data = mysqli_query($koneksi, "SELECT * FROM siswa");
                        while ($d = mysqli_fetch_array($data)) {
                            ?>
                            <tr>
                                <td><?= $no++; ?></td>
                                <td><?= htmlspecialchars($d['nis']); ?></td>
                                <td><?= htmlspecialchars($d['nama']); ?></td>
                                <td><?= htmlspecialchars($d['kelas']); ?></td>
                                <td><?= htmlspecialchars($d['jurusan']); ?></td>
                                <td class="action-buttons">
                                    <a href="edit.php?id=<?= $d['id']; ?>" class="btn btn-edit"><i class="fas fa-edit"></i>
                                        Edit</a>
                                    <a href="hapus.php?id=<?= $d['id']; ?>" class="btn btn-hapus"
                                        onclick="event.preventDefault(); showConfirmModal('Apakah Anda yakin ingin menghapus data ini?', () => { window.location.href = this.href; }, 'Konfirmasi Hapus');">
                                        <i class="fas fa-trash"></i> Hapus
                                    </a>
                                </td>
                            </tr>
                        <?php } ?>
                    </tbody>
                </table>
            </div>
        </main>
    </div>

    <!-- Modal HTML Structure -->
    <div id="customModal" class="modal-overlay">
        <div class="modal-content">
            <div class="modal-header">
                <h3 id="modalTitle" class="modal-title"></h3>
                <button class="modal-close"></button>
            </div>
            <div class="modal-body">
                <p id="modalMessage"></p>
            </div>
            <div class="modal-footer">
                <button id="modalCancelBtn" class="btn btn-secondary">Batal</button>
                <button id="modalConfirmBtn" class="btn btn-hapus">Ya, Lanjutkan</button>
            </div>
        </div>
    </div>

    <script src="../script.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const message = "<?php echo $modal_message; ?>";
            if (message) {
                showModal(message, "Sukses");
            }
        });
    </script>

</body>

</html>