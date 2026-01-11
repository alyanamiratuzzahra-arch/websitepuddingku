<?php
include 'koneksi.php';

header('Content-Type: application/json');

// Ambil data dari request
$input = json_decode(file_get_contents('php://input'), true);
$order_id = isset($input['order_id']) ? intval($input['order_id']) : 0;

if($order_id <= 0) {
    echo json_encode([
        'status' => 'error',
        'msg' => 'ID pesanan tidak valid!'
    ]);
    exit;
}

// Cek apakah pesanan masih PENDING
$check_query = "SELECT status FROM order_dashboard WHERE id = $order_id";
$check_result = mysqli_query($koneksi, $check_query);

if(!$check_result || mysqli_num_rows($check_result) == 0) {
    echo json_encode([
        'status' => 'error',
        'msg' => 'Pesanan tidak ditemukan!'
    ]);
    exit;
}

$order = mysqli_fetch_assoc($check_result);

if($order['status'] != 'PENDING') {
    echo json_encode([
        'status' => 'error',
        'msg' => 'Hanya pesanan dengan status PENDING yang dapat dibatalkan!'
    ]);
    exit;
}

// Update status menjadi DIBATALKAN
$update_query = "UPDATE order_dashboard SET status = 'DIBATALKAN' WHERE id = $order_id";

if(mysqli_query($koneksi, $update_query)) {
    echo json_encode([
        'status' => 'success',
        'msg' => 'Pesanan berhasil dibatalkan!'
    ]);
} else {
    echo json_encode([
        'status' => 'error',
        'msg' => 'Gagal membatalkan pesanan: ' . mysqli_error($koneksi)
    ]);
}
?>