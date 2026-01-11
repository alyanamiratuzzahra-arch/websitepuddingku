<?php
header('Content-Type: application/json');
include 'koneksi.php';

// Query untuk mengambil semua produk dengan kategori
$query = "SELECT id_produk, nama_produk, kategori, harga, stock, gambar 
          FROM produk 
          ORDER BY kategori, nama_produk ASC";
$result = mysqli_query($koneksi, $query);

$products = [];

if ($result) {
    while ($row = mysqli_fetch_assoc($result)) {
        $products[] = [
            'id' => (string)$row['id_produk'],
            'name' => $row['nama_produk'],
            'price' => (int)$row['harga'],
            'stock' => (int)$row['stock'],
            'category' => $row['kategori'] ?: 'Produk', // Ambil kategori dari database
            'img' => $row['gambar'] ? 'uploads/' . $row['gambar'] : 'img/placeholder.jpg'
        ];
    }
}

echo json_encode($products);
mysqli_close($koneksi);
?>