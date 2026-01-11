<?php
session_start();
include 'koneksi.php';

$id = $_POST['id_karyawan'];
$pass = $_POST['password'];

$query = "SELECT * FROM akun WHERE id_karyawan = '$id' AND password = '$pass'";
$cek = mysqli_query($koneksi, $query);

if (mysqli_num_rows($cek) > 0) {
    $data = mysqli_fetch_assoc($cek);

    $_SESSION['id_karyawan'] = $data['id_karyawan'];
    $_SESSION['nama'] = $data['nama'];

    header("Location: admin.php");
    exit;
} else {
    echo "<script>alert('Login gagal! Username atau password salah'); window.location='login.php';</script>";
}
