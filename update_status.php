<?php
include 'koneksi.php';
header('Content-Type: application/json');

$id = intval($_POST['id']);
$status = $_POST['status'] ?? '';

$allowed = ['PENDING','PROCESS','DIKIRIM','SELESAI'];
if(!in_array($status,$allowed)){
echo json_encode(['success'=>false,'error'=>'Status tidak valid']);
exit;
}

$u = mysqli_query($koneksi,"UPDATE order_dashboard SET status='$status' WHERE id=$id");

echo json_encode(['success'=>$u?true:false]);
