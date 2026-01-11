<?php
include 'koneksi.php';

// Ambil data dari JavaScript (POST)
$nama_produk = $_POST['product'] ?? '';
$username = $_POST['username'] ?? '';
$isi_pesan = $_POST['text'] ?? '';

// Cek apakah semua data ada
if ($nama_produk && $username && $isi_pesan) {
    // Query simpan data ke tabel ulasan
    $sql = "INSERT INTO ulasan (nama_produk, username, isi_pesan) VALUES (?, ?, ?)";
    $stmt = mysqli_prepare($koneksi, $sql);
    mysqli_stmt_bind_param($stmt, "sss", $nama_produk, $username, $isi_pesan);

    if (mysqli_stmt_execute($stmt)) {
        echo "✅ Ulasan berhasil disimpan!";
    } else {
        echo "❌ Gagal menyimpan ke database: " . mysqli_error($koneksi);
    }
} else {
    echo "⚠️ Data tidak lengkap. Pastikan semua kolom diisi.";
}
?>