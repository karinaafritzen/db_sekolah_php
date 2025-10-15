<?php
require 'koneksi.php';
check_login();

$user_id = $_SESSION['user_id'];
$success = '';
$error = '';

// Ambil data user dari database
$query_user = mysqli_query($koneksi, "SELECT id, username, nama_lengkap, email, foto_profil FROM users WHERE id = '$user_id'");
$user_data = mysqli_fetch_assoc($query_user);

if (isset($_POST['update_profile'])) {
    $new_nama_lengkap = mysqli_real_escape_string($koneksi, $_POST['nama_lengkap']);
    $new_email = mysqli_real_escape_string($koneksi, $_POST['email']);

    // Validasi email unik (kecuali email user sendiri)
    $check_email = mysqli_query($koneksi, "SELECT id FROM users WHERE email = '$new_email' AND id != '$user_id'");
    if (mysqli_num_rows($check_email) > 0) {
        $error = "Email sudah digunakan oleh akun lain.";
    } else {
        $update_query = "UPDATE users SET nama_lengkap = '$new_nama_lengkap', email = '$new_email' WHERE id = '$user_id'";
        if (mysqli_query($koneksi, $update_query)) {
            $success = "Profil berhasil diperbarui.";
            // Perbarui sesi dengan data baru
            $_SESSION['nama_lengkap'] = $new_nama_lengkap;
            $_SESSION['email'] = $new_email;
            // Refresh data pengguna setelah update
            $query_user = mysqli_query($koneksi, "SELECT id, username, nama_lengkap, email, foto_profil FROM users WHERE id = '$user_id'");
            $user_data = mysqli_fetch_assoc($query_user);
        } else {
            $error = "Gagal memperbarui profil: " . mysqli_error($koneksi);
        }
    }
}

// Handler untuk upload foto profil
if (isset($_POST['upload_photo'])) {
    if (isset($_FILES['foto_profil']) && $_FILES['foto_profil']['error'] == 0) {
        $target_dir = "uploads/";
        $file_extension = pathinfo($_FILES["foto_profil"]["name"], PATHINFO_EXTENSION);
        $new_file_name = "profile_" . $user_id . "_" . time() . "." . $file_extension;
        $target_file = $target_dir . $new_file_name;
        $uploadOk = 1;
        $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

        // Cek apakah file adalah gambar asli atau fake
        $check = getimagesize($_FILES["foto_profil"]["tmp_name"]);
        if ($check !== false) {
            $uploadOk = 1;
        } else {
            $error = "File bukan gambar.";
            $uploadOk = 0;
        }

        // Cek ukuran file
        if ($_FILES["foto_profil"]["size"] > 500000) { // 500KB
            $error = "Ukuran file terlalu besar. Maksimal 500KB.";
            $uploadOk = 0;
        }

        // Izinkan format file tertentu
        if ($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg" && $imageFileType != "gif") {
            $error = "Hanya JPG, JPEG, PNG & GIF yang diizinkan.";
            $uploadOk = 0;
        }

        // Cek jika $uploadOk adalah 0 karena error
        if ($uploadOk == 0) {
            // Error sudah di-set
        } else {
            // Jika semuanya OK, coba upload file
            if (move_uploaded_file($_FILES["foto_profil"]["tmp_name"], $target_file)) {
                // Hapus foto lama jika bukan default
                if ($user_data['foto_profil'] != 'default_profile.png' && file_exists($target_dir . $user_data['foto_profil'])) {
                    unlink($target_dir . $user_data['foto_profil']);
                }

                $update_photo_query = "UPDATE users SET foto_profil = '$new_file_name' WHERE id = '$user_id'";
                if (mysqli_query($koneksi, $update_photo_query)) {
                    $success = "Foto profil berhasil diunggah.";
                    $_SESSION['foto_profil'] = $new_file_name; // Perbarui sesi
                    // Refresh data pengguna setelah update
                    $query_user = mysqli_query($koneksi, "SELECT id, username, nama_lengkap, email, foto_profil FROM users WHERE id = '$user_id'");
                    $user_data = mysqli_fetch_assoc($query_user);
                } else {
                    $error = "Gagal memperbarui database foto: " . mysqli_error($koneksi);
                }
            } else {
                $error = "Gagal mengunggah file.";
            }
        }
    } else if (isset($_FILES['foto_profil']) && $_FILES['foto_profil']['error'] == UPLOAD_ERR_NO_FILE) {
        $error = "Pilih file gambar untuk diunggah.";
    } else {
        $error = "Terjadi kesalahan saat mengunggah file.";
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profil Pengguna</title>
    <link rel="stylesheet" href="style.css?v=<?php echo filemtime('style.css'); ?>">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
</head>
<body>
    <div class="container">
        <header>
            <h1>Profil Pengguna</h1>
            <p>Kelola informasi akun Anda</p>
        </header>

        <nav>
            <a href="index.php" class="btn btn-secondary"><i class="fas fa-arrow-left"></i> Kembali ke Dashboard</a>
        </nav>

        <main class="profile-page-content">
            <?php if(!empty($error)): ?>
                <div class="error-message"><?= htmlspecialchars($error); ?></div>
            <?php endif; ?>
            <?php if(!empty($success)): ?>
                <div class="success-message"><?= htmlspecialchars($success); ?></div>
            <?php endif; ?>

            <div class="profile-card">
                <div class="profile-photo-section">
                    <img src="uploads/<?= htmlspecialchars($user_data['foto_profil']); ?>" alt="Foto Profil" class="profile-large-img">
                    <form action="" method="post" enctype="multipart/form-data" class="upload-photo-form">
                        <label for="foto_profil" class="custom-file-upload">
                            <i class="fas fa-camera"></i> Ganti Foto
                        </label>
                        <input type="file" name="foto_profil" id="foto_profil" accept="image/*" style="display: none;">
                        <button type="submit" name="upload_photo" class="btn btn-primary btn-sm">Unggah</button>
                    </form>
                </div>
                
                <div class="profile-details-section">
                    <form action="" method="post" class="profile-form">
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
                            <button type="submit" name="update_profile" class="btn btn-primary"><i class="fas fa-save"></i> Simpan Perubahan</button>
                        </div>
                    </form>
                </div>
            </div>
        </main>
    </div>
</body>
</html>