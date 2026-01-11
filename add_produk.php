<?php
include 'koneksi.php';

header('Content-Type: application/json');

$nama = $_POST['nama_produk'] ?? '';
$harga = $_POST['harga'] ?? '';
$stock = $_POST['stock'] ?? '';
$gambar = '';

// Upload gambar jika ada
if(isset($_FILES['gambar']) && $_FILES['gambar']['error'] === 0){
    $ext = pathinfo($_FILES['gambar']['name'], PATHINFO_EXTENSION);
    $gambar = uniqid() . '.' . $ext;
    move_uploaded_file($_FILES['gambar']['tmp_name'], 'uploads/' . $gambar);
}

if(!$nama || !$harga || !$stock){
    echo json_encode(['success'=>false,'error'=>'Semua field harus diisi']);
    exit;
}

// Insert ke database
$stmt = $koneksi->prepare("INSERT INTO produk (nama_produk, harga, stock, gambar) VALUES (?, ?, ?, ?)");
$stmt->bind_param("siis", $nama, $harga, $stock, $gambar);

if($stmt->execute()){
    echo json_encode(['success'=>true]);
} else {
    echo json_encode(['success'=>false,'error'=>$stmt->error]);
}
