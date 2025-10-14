<?php
include '../koneksi.php';
check_login_from_folder();

$id = $_GET['id'];
mysqli_query($koneksi, "DELETE FROM mata_pelajaran WHERE id='$id'");
header("location:index.php");
?>
