<?php
$host = "127.0.0.1"; 
$user = "root";
$pass = "";
$db   = "umkm_terbaru";
$port = 3306;

$koneksi = mysqli_connect($host, $user, $pass, $db, $port);

// Cek koneksi
if (!$koneksi) {
    die("Koneksi gagal: " . mysqli_connect_error());
}


// echo "Koneksi ke database <b>umkm_terbaru</b> BERHASIL!";
?>