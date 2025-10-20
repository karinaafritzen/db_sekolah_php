<?php
require 'koneksi.php';
check_login();

$user_id = $_SESSION['user_id'];
$modal_message = '';
$modal_title = '';

// --- LOGIKA UPDATE PROFIL (NAMA & EMAIL) ---
if (isset($_POST['update_profile'])) {
    $new_nama_lengkap = mysqli_real_escape_string($koneksi, $_POST['nama_lengkap']);
    $new_email = mysqli_real_escape_string($koneksi, $_POST['email']);
    
    // Validasi email unik (kecuali email user sendiri)
    $check_email = mysqli_query($koneksi, "SELECT id FROM users WHERE email = '$new_email' AND id != '$user_id'");
    if (mysqli_num_rows($check_email) > 0) {
        $modal_message = "Email sudah digunakan oleh akun lain.";
        $modal_title = "Error";
    } else {
        // Query untuk update data
        $update_query = "UPDATE users SET nama_lengkap = '$new_nama_lengkap', email = '$new_email' WHERE id = '$user_id'";
        if (mysqli_query($koneksi, $update_query)) {
            // Perbarui sesi dengan data baru agar langsung terlihat
            $_SESSION['nama_lengkap'] = $new_nama_lengkap;
            $_SESSION['email'] = $new_email;
            header("Location: profile.php?status=updated");
            exit();
        } else {
            $modal_message = "Gagal memperbarui profil. Silakan coba lagi.";
            $modal_title = "Error";
        }
    }
}

// --- LOGIKA HAPUS AKUN DENGAN VERIFIKASI PASSWORD ---
if (isset($_POST['delete_account']) && isset($_POST['password_verification'])) {
    $password_verification = $_POST['password_verification'];

    // Ambil password asli dari database untuk perbandingan
    $result = mysqli_query($koneksi, "SELECT password, foto_profil FROM users WHERE id = '$user_id'");
    $user = mysqli_fetch_assoc($result);

    if ($user && $password_verification === $user['password']) {
        // Password cocok, lanjutkan proses hapus
        $target_dir = "uploads/";
        $foto_profil = $user['foto_profil'];
        if ($foto_profil != 'default_profile.png' && file_exists($target_dir . $foto_profil)) {
            @unlink($target_dir . $foto_profil);
        }
        
        $delete_query = "DELETE FROM users WHERE id = '$user_id'";
        if (mysqli_query($koneksi, $delete_query)) {
            session_unset();
            session_destroy();
            header("Location: login.php?status=deleted");
            exit();
        } else {
            $modal_message = "Gagal menghapus akun setelah verifikasi.";
            $modal_title = "Error";
        }
    } else {
        // Password tidak cocok
        $modal_message = "Password yang Anda masukkan salah. Hapus akun dibatalkan.";
        $modal_title = "Verifikasi Gagal";
    }
}

// Logika upload foto (tidak berubah dari versi sebelumnya)
if (isset($_FILES['foto_profil']) && $_FILES['foto_profil']['error'] == 0) {
    $target_dir = "uploads/";
    if (!is_dir($target_dir)) { mkdir($target_dir, 0755, true); }

    $file_extension = pathinfo($_FILES["foto_profil"]["name"], PATHINFO_EXTENSION);
    $new_file_name = "profile_" . $user_id . "_" . time() . "." . $file_extension;
    $target_file = $target_dir . $new_file_name;
    $imageFileType = strtolower($file_extension);

    $check = getimagesize($_FILES["foto_profil"]["tmp_name"]);
    if ($check !== false && $_FILES["foto_profil"]["size"] <= 2000000 && in_array($imageFileType, ['jpg', 'png', 'jpeg', 'gif'])) {
        $old_photo_query = mysqli_query($koneksi, "SELECT foto_profil FROM users WHERE id = '$user_id'");
        $old_photo_data = mysqli_fetch_assoc($old_photo_query);
        $old_photo_file = $old_photo_data['foto_profil'];
        if ($old_photo_file != 'default_profile.png' && file_exists($target_dir . $old_photo_file)) {
            @unlink($target_dir . $old_photo_file);
        }

        if (move_uploaded_file($_FILES["foto_profil"]["tmp_name"], $target_file)) {
            $update_photo_query = "UPDATE users SET foto_profil = '$new_file_name' WHERE id = '$user_id'";
            if (mysqli_query($koneksi, $update_photo_query)) {
                $_SESSION['foto_profil'] = $new_file_name;
                header("Location: profile.php?status=photo_updated");
                exit();
            }
        }
    } else {
        $modal_message = "Upload gagal. Pastikan file adalah gambar (JPG, PNG, JPEG, GIF) dan ukurannya di bawah 2MB.";
        $modal_title = "Error Upload";
    }
}

if (isset($_GET['status']) && empty($modal_message)) {
    if ($_GET['status'] == 'updated') {
        $modal_message = "Profil Anda telah berhasil diperbarui.";
        $modal_title = "Sukses";
    } elseif ($_GET['status'] == 'photo_updated') {
        $modal_message = "Foto profil Anda berhasil diperbarui.";
        $modal_title = "Sukses";
    }
}

$query_user = mysqli_query($koneksi, "SELECT * FROM users WHERE id = '$user_id'");
$user_data = mysqli_fetch_assoc($query_user);
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profil Pengguna</title>
    <link rel="stylesheet" href="style.css?v=<?php echo filemtime('style.css'); ?>">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
</head>
<body>
<div class="container">
    <header><h1>Profil Pengguna</h1></header>
    <nav>
        <a href="index.php" class="btn btn-secondary"><i class="fas fa-arrow-left"></i> Kembali ke Dashboard</a>
    </nav>
    <main class="profile-page-content">
        <div class="profile-card">
             <div class="profile-photo-section">
                <img src="uploads/<?= htmlspecialchars($user_data['foto_profil']); ?>" alt="Foto Profil" class="profile-large-img">
                <form action="profile.php" method="post" enctype="multipart/form-data" id="upload-photo-form">
                    <label for="foto_profil" class="custom-file-upload"><i class="fas fa-camera"></i> Ganti Foto</label>
                    <input type="file" name="foto_profil" id="foto_profil" accept="image/*" style="display: none;">
                </form>
            </div>
            <div class="profile-details-section">
                <form action="profile.php" method="post" class="profile-form">
                    <div class="form-group">
                        <label for="username">Username</label>
                        <input type="text" id="username" value="<?= htmlspecialchars($user_data['username']); ?>" disabled>
                    </div>
                    <div class="form-group">
                        <label for="nama_lengkap">Nama Lengkap</label>
                        <input type="text" name="nama_lengkap" id="nama_lengkap" value="<?= htmlspecialchars($user_data['nama_lengkap']); ?>" required>
                    </div>
                    <div class="form-group">
                        <label for="email">Email</label>
                        <input type="email" name="email" id="email" value="<?= htmlspecialchars($user_data['email']); ?>" required>
                    </div>
                    <div class="form-buttons">
                        <button type="submit" name="update_profile" class="btn"><i class="fas fa-save"></i> Simpan Perubahan</button>
                    </div>
                </form>
            </div>
            <div class="delete-account-section">
                <h3>Hapus Akun</h3>
                <p>Tindakan ini tidak dapat diurungkan. Semua data Anda akan dihapus secara permanen.</p>
                <form id="deleteAccountForm" action="profile.php" method="post">
                    <input type="hidden" name="delete_account" value="1">
                    <button type="button" class="btn btn-hapus"
                            onclick="showConfirmModal('Apakah Anda yakin ingin menghapus akun Anda secara permanen?', () => { document.getElementById('deleteAccountForm').submit(); }, 'Hapus Akun');">
                        <i class="fas fa-trash-alt"></i> Hapus Akun Saya
                    </button>
                </form>
            </div>
        </div>
    </main>
</div>

<!-- Modal HTML Structure -->
<div id="customModal" class="modal-overlay">
    <div class="modal-content">
        <div class="modal-header">
            <h3 id="modalTitle" class="modal-title"></h3>
            <button type="button" class="modal-close">&times;</button>
        </div>
        <div class="modal-body">
            <p id="modalMessage"></p>
        </div>
        <div class="modal-footer">
            <button type="button" id="modalCancelBtn" class="btn btn-secondary">Batal</button>
            <button type="button" id="modalConfirmBtn" class="btn btn-hapus">Ya, Lanjutkan</button>
        </div>
    </div>
</div>

<script src="script.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    const message = "<?php echo $modal_message; ?>";
    const title = "<?php echo $modal_title; ?>";
    if (message) {
        showModal(message, title || "Informasi");
    }
});
</script>

</body>
</html>

