<?php
include '../koneksi.php';

$result = mysqli_query($koneksi, "SELECT * FROM produk ORDER BY id ASC");
$produk = [];

while ($row = mysqli_fetch_assoc($result)) {
    $produk[] = $row;
}

echo json_encode(['status' => 'success', 'data' => $produk]);
?>