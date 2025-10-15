<?php
session_start();

$koneksi = mysqli_connect("localhost", "root", "", "sekolah");

if (!$koneksi) {
    die("Koneksi gagal: " . mysqli_connect_error());
}

function check_login() {
    if (!isset($_SESSION['login']) || !isset($_SESSION['user_id'])) {
        header("Location: login.php");
        exit();
    }
}

function check_login_from_folder() {
    if (!isset($_SESSION['login']) || !isset($_SESSION['user_id'])) {
        header("Location: ../login.php");
        exit();
    }
}
?>