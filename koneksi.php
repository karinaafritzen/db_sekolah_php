<?php
$koneksi = mysqli_connect("localhost", "root", "", "sekolah");

if (!$koneksi) {
    die("Koneksi gagal: " . mysqli_connect_error());
}
?>
