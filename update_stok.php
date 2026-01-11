<?php
include 'koneksi.php';
header('Content-Type: application/json');

// Ambil data POST
$id_produk = isset($_POST['id_produk']) ? (int)$_POST['id_produk'] : 0;
$delta     = isset($_POST['delta']) ? (int)$_POST['delta'] : 0;

if($id_produk <= 0 || $delta === 0){
    echo json_encode([
        "success" => false,
        "error" => "Data tidak valid"
    ]);
    exit;
}

// Ambil stok sekarang
$stmt = mysqli_prepare($koneksi, "SELECT stock FROM produk WHERE id_produk = ?");
mysqli_stmt_bind_param($stmt, "i", $id_produk);
mysqli_stmt_execute($stmt);
mysqli_stmt_bind_result($stmt, $current_stock);
mysqli_stmt_fetch($stmt);
mysqli_stmt_close($stmt);

if($current_stock === null){
    echo json_encode([
        "success" => false,
        "error" => "Produk tidak ditemukan"
    ]);
    exit;
}

// Hitung stok baru
$new_stock = $current_stock + $delta;
if($new_stock < 0) $new_stock = 0;

// Update stok
$stmt = mysqli_prepare($koneksi, "UPDATE produk SET stock = ? WHERE id_produk = ?");
mysqli_stmt_bind_param($stmt, "ii", $new_stock, $id_produk);
$ok = mysqli_stmt_execute($stmt);
mysqli_stmt_close($stmt);

if($ok){
    echo json_encode([
        "success" => true,
        "new_stock" => $new_stock
    ]);
} else {
    echo json_encode([
        "success" => false,
        "error" => "Gagal update stok"
    ]);
}
?>
