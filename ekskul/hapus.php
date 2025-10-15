<?php
require '../koneksi.php';
check_login_from_folder();

$id = $_GET['id'];
// Pastikan ID adalah integer untuk keamanan tambahan
$id = intval($id);

if ($id > 0) {
    mysqli_query($koneksi, "DELETE FROM ekstrakurikuler WHERE id='$id'");
}

header("location:index.php");
exit();
?>