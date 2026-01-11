<?php
// ============================================
// FILE: api_admin.php
// Backend API untuk Admin Dashboard
// Dengan sistem PROFIT OTOMATIS
// ============================================

include 'koneksi.php';
header('Content-Type: application/json; charset=utf-8');

$action = $_GET['action'] ?? '';

// ============================================
// GET STATISTICS - PROFIT OTOMATIS DARI DB
// ============================================
if ($action === 'get_stats') {
    // 🔥 HITUNG TOTAL PROFIT DARI SEMUA PESANAN
    $query_profit = "SELECT SUM(total) as total_profit FROM order_dashboard 
                     WHERE status IN ('PENDING', 'PROCESS', 'DIKIRIM', 'SELESAI')";
    $result_profit = mysqli_query($koneksi, $query_profit);
    $row_profit = mysqli_fetch_assoc($result_profit);
    $total_profit = $row_profit['total_profit'] ?? 0;

    // Hitung jumlah per status
    $query_count = "SELECT 
                    SUM(CASE WHEN status = 'PENDING' THEN 1 ELSE 0 END) as pending,
                    SUM(CASE WHEN status = 'PROCESS' THEN 1 ELSE 0 END) as process,
                    SUM(CASE WHEN status = 'DIKIRIM' THEN 1 ELSE 0 END) as dikirim,
                    SUM(CASE WHEN status = 'SELESAI' THEN 1 ELSE 0 END) as selesai,
                    COUNT(*) as total_pesanan
                    FROM order_dashboard";
    $result_count = mysqli_query($koneksi, $query_count);
    $row_count = mysqli_fetch_assoc($result_count);

    echo json_encode([
        'status' => 'success',
        'data' => [
            'total_profit' => intval($total_profit),
            'pending' => intval($row_count['pending'] ?? 0),
            'process' => intval($row_count['process'] ?? 0),
            'dikirim' => intval($row_count['dikirim'] ?? 0),
            'selesai' => intval($row_count['selesai'] ?? 0),
            'total_pesanan' => intval($row_count['total_pesanan'] ?? 0)
        ]
    ]);
    exit;
}

// ============================================
// GET PESANAN
// ============================================
if ($action === 'get_pesanan') {
    $query = "SELECT * FROM order_dashboard ORDER BY waktu DESC";
    $result = mysqli_query($koneksi, $query);
    $data = [];
    
    while ($row = mysqli_fetch_assoc($result)) {
        $items_array = json_decode($row['items'], true);
        $row['items_array'] = is_array($items_array) ? $items_array : [];
        $data[] = $row;
    }
    
    echo json_encode(['status' => 'success', 'data' => $data]);
    exit;
}

// ============================================
// ADD PESANAN
// ============================================
if ($action === 'add_pesanan') {
    $input = json_decode(file_get_contents('php://input'), true);
    
    $nama = mysqli_real_escape_string($koneksi, $input['nama']);
    $telepon = mysqli_real_escape_string($koneksi, $input['telepon'] ?? '');
    $items = mysqli_real_escape_string($koneksi, $input['items']);
    $total = intval($input['total']);
    $status = mysqli_real_escape_string($koneksi, $input['status']);
    
    $query = "INSERT INTO order_dashboard (nama, telepon, items, total, status, waktu) 
              VALUES ('$nama', '$telepon', '$items', $total, '$status', NOW())";
    
    if (mysqli_query($koneksi, $query)) {
        echo json_encode(['status' => 'success', 'msg' => 'Pesanan berhasil ditambahkan']);
    } else {
        echo json_encode(['status' => 'error', 'msg' => mysqli_error($koneksi)]);
    }
    exit;
}

// ============================================
// UPDATE PESANAN
// ============================================
if ($action === 'update_pesanan') {
    $input = json_decode(file_get_contents('php://input'), true);
    
    $id = intval($input['id']);
    $nama = mysqli_real_escape_string($koneksi, $input['nama']);
    $telepon = mysqli_real_escape_string($koneksi, $input['telepon'] ?? '');
    $items = mysqli_real_escape_string($koneksi, $input['items']);
    $total = intval($input['total']);
    $status = mysqli_real_escape_string($koneksi, $input['status']);
    
    $query = "UPDATE order_dashboard 
              SET nama='$nama', telepon='$telepon', items='$items', 
                  total=$total, status='$status' 
              WHERE id=$id";
    
    if (mysqli_query($koneksi, $query)) {
        echo json_encode(['status' => 'success', 'msg' => 'Pesanan berhasil diupdate']);
    } else {
        echo json_encode(['status' => 'error', 'msg' => mysqli_error($koneksi)]);
    }
    exit;
}

// ============================================
// DELETE PESANAN
// ============================================
if ($action === 'delete_pesanan') {
    $input = json_decode(file_get_contents('php://input'), true);
    $id = intval($input['id']);
    
    $query = "DELETE FROM order_dashboard WHERE id=$id";
    
    if (mysqli_query($koneksi, $query)) {
        echo json_encode(['status' => 'success', 'msg' => 'Pesanan berhasil dihapus']);
    } else {
        echo json_encode(['status' => 'error', 'msg' => mysqli_error($koneksi)]);
    }
    exit;
}

// ============================================
// GET PRODUK
// ============================================
if ($action === 'get_produk') {
    // Cek apakah tabel produk ada
    $check_table = mysqli_query($koneksi, "SHOW TABLES LIKE 'produk'");
    if (mysqli_num_rows($check_table) == 0) {
        // Buat tabel jika belum ada
        mysqli_query($koneksi, "CREATE TABLE IF NOT EXISTS `produk` (
            `id` int(11) NOT NULL AUTO_INCREMENT,
            `nama` varchar(255) NOT NULL,
            `kategori` varchar(100) DEFAULT NULL,
            `harga` int(11) NOT NULL,
            `stok` int(11) DEFAULT 0,
            `deskripsi` text,
            PRIMARY KEY (`id`)
        )");
    }
    
    $query = "SELECT * FROM produk ORDER BY nama ASC";
    $result = mysqli_query($koneksi, $query);
    $data = [];
    
    while ($row = mysqli_fetch_assoc($result)) {
        $data[] = $row;
    }
    
    echo json_encode(['status' => 'success', 'data' => $data]);
    exit;
}

// ============================================
// ADD PRODUK
// ============================================
if ($action === 'add_produk') {
    $input = json_decode(file_get_contents('php://input'), true);
    
    $nama = mysqli_real_escape_string($koneksi, $input['nama']);
    $kategori = mysqli_real_escape_string($koneksi, $input['kategori']);
    $harga = intval($input['harga']);
    $stok = intval($input['stok']);
    $deskripsi = mysqli_real_escape_string($koneksi, $input['deskripsi'] ?? '');
    
    $query = "INSERT INTO produk (nama, kategori, harga, stok, deskripsi) 
              VALUES ('$nama', '$kategori', $harga, $stok, '$deskripsi')";
    
    if (mysqli_query($koneksi, $query)) {
        echo json_encode(['status' => 'success', 'msg' => 'Produk berhasil ditambahkan']);
    } else {
        echo json_encode(['status' => 'error', 'msg' => mysqli_error($koneksi)]);
    }
    exit;
}

// ============================================
// UPDATE PRODUK
// ============================================
if ($action === 'update_produk') {
    $input = json_decode(file_get_contents('php://input'), true);
    
    $id = intval($input['id']);
    $nama = mysqli_real_escape_string($koneksi, $input['nama']);
    $kategori = mysqli_real_escape_string($koneksi, $input['kategori']);
    $harga = intval($input['harga']);
    $stok = intval($input['stok']);
    $deskripsi = mysqli_real_escape_string($koneksi, $input['deskripsi'] ?? '');
    
    $query = "UPDATE produk 
              SET nama='$nama', kategori='$kategori', harga=$harga, 
                  stok=$stok, deskripsi='$deskripsi' 
              WHERE id=$id";
    
    if (mysqli_query($koneksi, $query)) {
        echo json_encode(['status' => 'success', 'msg' => 'Produk berhasil diupdate']);
    } else {
        echo json_encode(['status' => 'error', 'msg' => mysqli_error($koneksi)]);
    }
    exit;
}

// ============================================
// DELETE PRODUK
// ============================================
if ($action === 'delete_produk') {
    $input = json_decode(file_get_contents('php://input'), true);
    $id = intval($input['id']);
    
    $query = "DELETE FROM produk WHERE id=$id";
    
    if (mysqli_query($koneksi, $query)) {
        echo json_encode(['status' => 'success', 'msg' => 'Produk berhasil dihapus']);
    } else {
        echo json_encode(['status' => 'error', 'msg' => mysqli_error($koneksi)]);
    }
    exit;
}

// ============================================
// GET PENGATURAN
// ============================================
if ($action === 'get_pengaturan') {
    // Cek apakah tabel pengaturan ada
    $check_table = mysqli_query($koneksi, "SHOW TABLES LIKE 'pengaturan'");
    if (mysqli_num_rows($check_table) == 0) {
        // Buat tabel jika belum ada
        mysqli_query($koneksi, "CREATE TABLE IF NOT EXISTS `pengaturan` (
            `id` int(11) NOT NULL AUTO_INCREMENT,
            `nama_toko` varchar(255) DEFAULT NULL,
            `email` varchar(255) DEFAULT NULL,
            `telepon` varchar(50) DEFAULT NULL,
            `alamat` text,
            `jam_operasional` varchar(255) DEFAULT NULL,
            PRIMARY KEY (`id`)
        )");
    }
    
    $query = "SELECT * FROM pengaturan WHERE id=1";
    $result = mysqli_query($koneksi, $query);
    $data = mysqli_fetch_assoc($result);
    
    if (!$data) {
        $data = [
            'nama_toko' => 'UMKM PUDDINGKU',
            'email' => '',
            'telepon' => '',
            'alamat' => '',
            'jam_operasional' => ''
        ];
    }
    
    echo json_encode(['status' => 'success', 'data' => $data]);
    exit;
}

// ============================================
// SAVE PENGATURAN
// ============================================
if ($action === 'save_pengaturan') {
    $input = json_decode(file_get_contents('php://input'), true);
    
    $nama_toko = mysqli_real_escape_string($koneksi, $input['nama_toko']);
    $email = mysqli_real_escape_string($koneksi, $input['email']);
    $telepon = mysqli_real_escape_string($koneksi, $input['telepon']);
    $alamat = mysqli_real_escape_string($koneksi, $input['alamat']);
    $jam = mysqli_real_escape_string($koneksi, $input['jam_operasional']);
    
    // Cek apakah sudah ada data
    $check = mysqli_query($koneksi, "SELECT id FROM pengaturan WHERE id=1");
    
    if (mysqli_num_rows($check) > 0) {
        $query = "UPDATE pengaturan 
                  SET nama_toko='$nama_toko', email='$email', telepon='$telepon', 
                      alamat='$alamat', jam_operasional='$jam' 
                  WHERE id=1";
    } else {
        $query = "INSERT INTO pengaturan (id, nama_toko, email, telepon, alamat, jam_operasional) 
                  VALUES (1, '$nama_toko', '$email', '$telepon', '$alamat', '$jam')";
    }
    
    if (mysqli_query($koneksi, $query)) {
        echo json_encode(['status' => 'success', 'msg' => 'Pengaturan berhasil disimpan']);
    } else {
        echo json_encode(['status' => 'error', 'msg' => mysqli_error($koneksi)]);
    }
    exit;
}

// ============================================
// DEFAULT RESPONSE
// ============================================
echo json_encode(['status' => 'error', 'msg' => 'Invalid action']);
mysqli_close($koneksi);
?>