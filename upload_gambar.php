<?php
include 'koneksi.php';
header('Content-Type: application/json');

if(!isset($_POST['id_produk']) || !isset($_FILES['gambar'])){
    echo json_encode(['success'=>false,'error'=>'Data produk atau file gambar tidak ditemukan']);
    exit;
}

$id_produk = $_POST['id_produk'];
$file = $_FILES['gambar'];

// Folder uploads
$folder = 'uploads/';
if(!is_dir($folder)) mkdir($folder, 0777, true);

$filename = basename($file['name']);
$target = $folder . $filename;

// Upload file
if(move_uploaded_file($file['tmp_name'], $target)){
    // Update nama file di database
    $stmt = $koneksi->prepare("UPDATE produk SET gambar=? WHERE id_produk=?");
    $stmt->bind_param("si", $filename, $id_produk);
    if($stmt->execute()){
        echo json_encode(['success'=>true,'message'=>'Gambar berhasil diupload']);
    } else {
        echo json_encode(['success'=>false,'error'=>'Gagal update database']);
    }
} else {
    echo json_encode(['success'=>false,'error'=>'Gagal upload file']);
}
?>
