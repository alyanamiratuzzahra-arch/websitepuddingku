<?php
include 'koneksi.php';

header('Content-Type: application/json');

// Ambil data dari FormData
$customer = isset($_POST['customer']) ? mysqli_real_escape_string($koneksi, $_POST['customer']) : '';
$address = isset($_POST['address']) ? mysqli_real_escape_string($koneksi, $_POST['address']) : '';
$phone = isset($_POST['phone']) ? mysqli_real_escape_string($koneksi, $_POST['phone']) : '';
$payment = isset($_POST['payment']) ? mysqli_real_escape_string($koneksi, $_POST['payment']) : '';
$items_json = isset($_POST['items']) ? $_POST['items'] : '';

// Validasi data wajib
if (empty($customer) || empty($phone) || empty($items_json)) {
    echo json_encode([
        'status' => 'error',
        'msg' => 'Data tidak lengkap!'
    ]);
    exit;
}

// Decode items
$items = json_decode($items_json, true);
if (!is_array($items) || count($items) === 0) {
    echo json_encode([
        'status' => 'error',
        'msg' => 'Keranjang kosong!'
    ]);
    exit;
}

// ========== CEK STOK HABIS (0) ==========
$stok_habis = false;
$produk_habis = [];

foreach ($items as $item) {
    $id_produk = intval($item['id']);
    
    // Cek stok di database
    $check_stok = mysqli_query($koneksi, "SELECT nama_produk, stock FROM produk WHERE id_produk = $id_produk");
    
    if ($check_stok && mysqli_num_rows($check_stok) > 0) {
        $produk = mysqli_fetch_assoc($check_stok);
        
        // Hanya tolak jika stok = 0 (habis)
        if ($produk['stock'] <= 0) {
            $stok_habis = true;
            $produk_habis[] = $produk['nama_produk'];
        }
    }
}

// Jika ada produk yang stoknya 0, batalkan order
if ($stok_habis) {
    echo json_encode([
        'status' => 'error',
        'msg' => 'Maaf, stok sedang habis untuk: ' . implode(', ', $produk_habis) . ' 😔'
    ]);
    exit;
}
// =========================================

// Hitung total
$total = 0;
foreach ($items as $item) {
    $total += $item['price'] * $item['qty'];
}

// Format items untuk disimpan
$items_text_array = [];
foreach ($items as $item) {
    $nama = $item['name'] ?? 'Unknown';
    $qty = $item['qty'] ?? 1;
    $items_text_array[] = "$nama x$qty";
}
$items_text = implode("\n", $items_text_array);
$items_encoded = mysqli_real_escape_string($koneksi, $items_text);

// Handle upload gambar bukti pembayaran
$gambar_name = '';
if (isset($_FILES['paymentProof']) && $_FILES['paymentProof']['error'] === 0) {
    $allowed_ext = ['jpg', 'jpeg', 'png', 'gif', 'webp'];
    $file_name = $_FILES['paymentProof']['name'];
    $file_size = $_FILES['paymentProof']['size'];
    $file_tmp = $_FILES['paymentProof']['tmp_name'];
    $file_ext = strtolower(pathinfo($file_name, PATHINFO_EXTENSION));
    
    if (!in_array($file_ext, $allowed_ext)) {
        echo json_encode([
            'status' => 'error',
            'msg' => 'Format file tidak valid! Gunakan JPG, PNG, atau GIF.'
        ]);
        exit;
    }
    
    if ($file_size > 2097152) {
        echo json_encode([
            'status' => 'error',
            'msg' => 'Ukuran file terlalu besar! Maksimal 2MB.'
        ]);
        exit;
    }
    
    $gambar_name = 'bukti_' . uniqid() . '_' . time() . '.' . $file_ext;
    $upload_dir = 'uploads/';
    
    if (!is_dir($upload_dir)) {
        mkdir($upload_dir, 0777, true);
    }
    
    if (!move_uploaded_file($file_tmp, $upload_dir . $gambar_name)) {
        echo json_encode([
            'status' => 'error',
            'msg' => 'Gagal upload gambar!'
        ]);
        exit;
    }
}

// Insert ke database
$status = 'PENDING';

$query = "INSERT INTO order_dashboard 
          (nama, telepon, items, total, status, payment_method, gambar, waktu) 
          VALUES 
          ('$customer', '$phone', '$items_encoded', $total, '$status', '$payment', '$gambar_name', NOW())";

if (mysqli_query($koneksi, $query)) {
    $order_id = mysqli_insert_id($koneksi);
    
    // ========== KURANGI STOK PRODUK OTOMATIS ==========
    foreach ($items as $item) {
        $id_produk = intval($item['id']);
        $qty_order = intval($item['qty']);
        
        // Update stok dengan mengurangi qty yang dipesan
        // Tidak ada kondisi AND stock >= $qty_order lagi
        $update_stok = "UPDATE produk 
                       SET stock = stock - $qty_order 
                       WHERE id_produk = $id_produk";
        
        mysqli_query($koneksi, $update_stok);
    }
    // ==================================================
    
    // Simpan/update data customer
    $check_customer = mysqli_query($koneksi, "SELECT id_customer FROM customer WHERE no_telp = '$phone'");
    
    if(mysqli_num_rows($check_customer) == 0) {
        $insert_customer = "INSERT INTO customer (nama_customer, no_telp) 
                           VALUES ('$customer', '$phone')";
        mysqli_query($koneksi, $insert_customer);
    } else {
        $update_customer = "UPDATE customer SET nama_customer = '$customer' 
                           WHERE no_telp = '$phone'";
        mysqli_query($koneksi, $update_customer);
    }
    
    echo json_encode([
        'status' => 'success',
        'msg' => 'Pesanan berhasil dikirim! 🎉',
        'order_id' => '#ORDER-' . $order_id
    ]);
} else {
    if (!empty($gambar_name) && file_exists('uploads/' . $gambar_name)) {
        unlink('uploads/' . $gambar_name);
    }
    
    echo json_encode([
        'status' => 'error',
        'msg' => 'Gagal menyimpan pesanan: ' . mysqli_error($koneksi)
    ]);
}
?>