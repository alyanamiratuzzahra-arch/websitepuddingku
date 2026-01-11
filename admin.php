<?php
// ========================================
// BAGIAN 1: KEAMANAN & KONEKSI DATABASE
// ========================================
// Memulai session untuk menyimpan data login
session_start();

// Cek apakah user sudah login atau belum
// Kalau belum login, langsung diarahkan ke halaman login
if (!isset($_SESSION['id_karyawan'])) {
    header("Location: login.php");
    exit;
}

// Menghubungkan ke database
include 'koneksi.php';

// ========================================
// BAGIAN 2A: PROSES TAMBAH PRODUK BARU ✅
// ========================================
if(isset($_POST['add_produk'])) {
    // Ambil data dari form
    $nama_produk = mysqli_real_escape_string($koneksi, $_POST['nama_produk']);
    $kategori = mysqli_real_escape_string($koneksi, $_POST['kategori']);
    $harga = intval($_POST['harga']);
    $stock = intval($_POST['stock']);
    $gambar = null;
    
    // Proses upload gambar jika ada
    if(isset($_FILES['gambar']) && $_FILES['gambar']['error'] === 0){
        $allowed = ['jpg', 'jpeg', 'png', 'gif', 'webp'];
        $filename = $_FILES['gambar']['name'];
        $ext = strtolower(pathinfo($filename, PATHINFO_EXTENSION));
        
        if(in_array($ext, $allowed)){
            // Buat nama file unik
            $gambar = uniqid() . '.' . $ext;
            
            // Upload ke folder uploads
            move_uploaded_file($_FILES['gambar']['tmp_name'], 'uploads/' . $gambar);
        } else {
            echo "<script>alert('❌ Format file tidak valid! Hanya JPG, PNG, GIF, WEBP');</script>";
        }
    }
    
    // Insert data produk ke database
    $query_insert = "INSERT INTO produk (nama_produk, kategori, harga, stock, gambar) 
                     VALUES ('$nama_produk', '$kategori', $harga, $stock, " . ($gambar ? "'$gambar'" : "NULL") . ")";
    
    $insert = mysqli_query($koneksi, $query_insert);
    
    if($insert) {
        echo "<script>
            alert('✅ Produk \"$nama_produk\" berhasil ditambahkan!');
            window.location.href='admin.php?page=produk';
        </script>";
    } else {
        echo "<script>
            alert('❌ Gagal menambahkan produk!\\nError: " . addslashes(mysqli_error($koneksi)) . "');
        </script>";
    }
    exit;
}

// ========================================
// BAGIAN 2: PROSES UPDATE PRODUK (EDIT)
// ========================================
if(isset($_POST['update_produk'])) {
    // Ambil data dari form edit produk
    $id_produk = intval($_POST['id_produk']);
    $nama_produk = mysqli_real_escape_string($koneksi, $_POST['nama_produk']);
    $kategori = mysqli_real_escape_string($koneksi, $_POST['kategori']);
    $harga = intval($_POST['harga']);
    $stock = intval($_POST['stock']);
    
    // Ambil gambar lama dari database
    $query_old = mysqli_query($koneksi, "SELECT gambar FROM produk WHERE id_produk=$id_produk");
    $old_data = mysqli_fetch_assoc($query_old);
    $gambar = $old_data['gambar'];
    
    // Proses upload gambar baru jika ada yang diupload
    if(isset($_FILES['gambar']) && $_FILES['gambar']['error'] === 0){
        // Tipe file yang diperbolehkan
        $allowed = ['jpg', 'jpeg', 'png', 'gif', 'webp'];
        $filename = $_FILES['gambar']['name'];
        $ext = strtolower(pathinfo($filename, PATHINFO_EXTENSION));
        
        // Cek apakah tipe file diperbolehkan
        if(in_array($ext, $allowed)){
            // Hapus gambar lama jika ada
            if($gambar && file_exists('uploads/' . $gambar)){
                unlink('uploads/' . $gambar);
            }
            
            // Buat nama file baru yang unik
            $gambar = uniqid() . '.' . $ext;
            
            // Pindahkan file yang diupload ke folder uploads
            move_uploaded_file($_FILES['gambar']['tmp_name'], 'uploads/' . $gambar);
        }
    }
    
    // Update data produk ke database
    mysqli_query($koneksi, "UPDATE produk SET nama_produk='$nama_produk', kategori='$kategori', harga=$harga, stock=$stock, gambar='$gambar' WHERE id_produk=$id_produk");
    
    // Tampilkan pesan sukses dan kembali ke halaman produk
    echo "<script>alert('Produk berhasil diupdate!'); window.location.href='admin.php?page=produk';</script>";
    exit;
}


// ========================================
// BAGIAN 3: PROSES HAPUS PRODUK (DELETE)
// ========================================
if(isset($_GET['delete_produk'])) {
    $id_produk = intval($_GET['delete_produk']);
    
    // Ambil data gambar produk yang akan dihapus
    $query = mysqli_query($koneksi, "SELECT gambar FROM produk WHERE id_produk=$id_produk");
    $data = mysqli_fetch_assoc($query);
    
    // Hapus file gambar dari folder jika ada
    if($data['gambar'] && file_exists('uploads/' . $data['gambar'])){
        unlink('uploads/' . $data['gambar']);
    }
    
    // Hapus data produk dari database
    mysqli_query($koneksi, "DELETE FROM produk WHERE id_produk=$id_produk");
    
    // Tampilkan pesan sukses dan kembali ke halaman produk
    echo "<script>alert('Produk berhasil dihapus!'); window.location.href='admin.php?page=produk';</script>";
    exit;
}


// ========================================
// BAGIAN 4: PROSES TAMBAH/KURANG STOCK
// ========================================
if(isset($_POST['update_stock'])) {
    $id_produk = intval($_POST['id_produk']);
    $action = $_POST['action']; // tambah atau kurang
    $jumlah = intval($_POST['jumlah']);
    
    // Jika aksi = tambah, stock ditambah
    if($action == 'tambah') {
        mysqli_query($koneksi, "UPDATE produk SET stock = stock + $jumlah WHERE id_produk=$id_produk");
        echo "<script>alert('Stock berhasil ditambahkan!'); window.location.href='admin.php?page=produk';</script>";
    } 
    // Jika aksi = kurang, stock dikurangi (tidak boleh minus)
    elseif($action == 'kurang') {
        mysqli_query($koneksi, "UPDATE produk SET stock = GREATEST(stock - $jumlah, 0) WHERE id_produk=$id_produk");
        echo "<script>alert('Stock berhasil dikurangi!'); window.location.href='admin.php?page=produk';</script>";
    }
    exit;
}


// ========================================
// BAGIAN 5: PROSES UPDATE STATUS PESANAN
// ========================================
if(isset($_POST['update_status'])) {
    $id = intval($_POST['update_status']);
    $new_status = mysqli_real_escape_string($koneksi, $_POST['new_status']);
    
    // Ambil id karyawan yang sedang login
    $id_karyawan = $_SESSION['id_karyawan'] ?? null;
    
    // Ambil data pesanan dari database
    $query_order = mysqli_query($koneksi, "SELECT * FROM order_dashboard WHERE id=$id");
    $order = mysqli_fetch_assoc($query_order);
    
    if($order) {
        // Update status pesanan
        $update = mysqli_query($koneksi, "UPDATE order_dashboard SET status='$new_status' WHERE id=$id");
        
        // Jika gagal update, tampilkan error
        if(!$update) {
            echo "<script>alert('Error: " . addslashes(mysqli_error($koneksi)) . "'); window.location.href='admin.php';</script>";
            exit;
        }
        
        // ========================================
        // BAGIAN 5.1: CATAT TRANSAKSI JIKA SELESAI
        // ========================================
        // Jika status diubah menjadi SELESAI, catat ke tabel transaksi
        if($new_status == 'SELESAI' && $order['status'] != 'SELESAI') {
            
            // Cari data customer berdasarkan nomor telepon
            $telepon = mysqli_real_escape_string($koneksi, $order['telepon']);
            $query_customer = mysqli_query($koneksi, "SELECT id_customer FROM customer WHERE no_telp='$telepon' LIMIT 1");
            
            // Jika customer ditemukan
            if($query_customer && mysqli_num_rows($query_customer) > 0) {
                $customer = mysqli_fetch_assoc($query_customer);
                $id_customer = $customer['id_customer'];
                
                // Siapkan data transaksi
                $nama = mysqli_real_escape_string($koneksi, $order['nama']);
                $total = intval($order['total']);
                $metode = mysqli_real_escape_string($koneksi, $order['payment_method']);
                
                // Simpan data transaksi ke database
                $insert_transaksi = mysqli_query($koneksi, "
                    INSERT INTO transaksi (
                        tgl_transaksi,
                        nama,
                        total_harga,
                        metode_transaksi,
                        id_customer,
                        id_karyawan
                    ) VALUES (
                        NOW(),
                        '$nama',
                        $total,
                        '$metode',
                        $id_customer,
                        " . ($id_karyawan ? "'$id_karyawan'" : "NULL") . "
                    )
                ");
                
                // Jika berhasil simpan transaksi
                if($insert_transaksi) {
                    // Ambil ID transaksi yang baru disimpan
                    $id_transaksi = mysqli_insert_id($koneksi);
                    
                    // Update order dengan ID transaksi
                    mysqli_query($koneksi, "UPDATE order_dashboard SET id_transaksi=$id_transaksi WHERE id=$id");
                    
                    echo "<script>alert('Status berhasil diupdate dan transaksi dicatat!'); window.location.href='admin.php';</script>";
                } else {
                    echo "<script>alert('Status diupdate tapi gagal catat transaksi: " . addslashes(mysqli_error($koneksi)) . "'); window.location.href='admin.php';</script>";
                }
            } else {
                // Jika customer tidak ditemukan
                echo "<script>alert('Status diupdate tapi customer tidak ditemukan!'); window.location.href='admin.php';</script>";
            }
        } else {
            // Jika status bukan SELESAI, hanya update status saja
            echo "<script>alert('Status berhasil diupdate!'); window.location.href='admin.php';</script>";
        }
    }
    exit;
}


// ========================================
// BAGIAN 6: CEK & TAMBAH KOLOM GAMBAR
// ========================================
// Cek apakah kolom gambar sudah ada di tabel order_dashboard
$check_gambar = mysqli_query($koneksi, "SHOW COLUMNS FROM order_dashboard LIKE 'gambar'");

// Jika belum ada, tambahkan kolom gambar
if(mysqli_num_rows($check_gambar) == 0) {
    mysqli_query($koneksi, "ALTER TABLE order_dashboard ADD COLUMN gambar varchar(255) DEFAULT NULL");
}


// ========================================
// BAGIAN 7: HITUNG TOTAL PROFIT/PENDAPATAN
// ========================================
// Hitung total pendapatan dari semua pesanan (kecuali yang dibatalkan)
$query_profit = "SELECT SUM(total) as total_profit FROM order_dashboard 
                 WHERE status IN ('PENDING', 'PROCESS', 'DIKIRIM', 'SELESAI')";
$result_profit = mysqli_query($koneksi, $query_profit);
$row_profit = mysqli_fetch_assoc($result_profit);
$total_profit = $row_profit['total_profit'] ?? 0;


// ========================================
// BAGIAN 8: HITUNG STATISTIK PESANAN
// ========================================
// Hitung jumlah pesanan berdasarkan status
$query_stats = "SELECT 
                SUM(CASE WHEN status = 'PENDING' THEN 1 ELSE 0 END) as pending,
                SUM(CASE WHEN status = 'PROCESS' THEN 1 ELSE 0 END) as process,
                SUM(CASE WHEN status = 'DIKIRIM' THEN 1 ELSE 0 END) as dikirim,
                SUM(CASE WHEN status = 'SELESAI' THEN 1 ELSE 0 END) as selesai,
                SUM(CASE WHEN status = 'DIBATALKAN' THEN 1 ELSE 0 END) as dibatalkan,
                COUNT(*) as total_pesanan
                FROM order_dashboard";
$result_stats = mysqli_query($koneksi, $query_stats);
$stats = mysqli_fetch_assoc($result_stats);
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>UMKM PUDDINGKU - Admin Dashboard</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

   <style>
    /* ==========================================
   BAGIAN 1: RESET & DASAR STYLING
   ========================================== */
/* Reset semua margin, padding dan box-sizing untuk konsistensi */
* { 
    margin: 0; 
    padding: 0; 
    box-sizing: border-box; 
}

/* Styling dasar untuk seluruh halaman */
body { 
    font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif; 
    background: url("img/bg/gambar d-umkm.jpg") center / cover fixed no-repeat;
    background-size: 100% 100%;
    display: flex; 
    min-height: 100vh; 
}

/* Animasi untuk gradient background yang bergerak */
@keyframes gradientShift {
    0% { background-position: 0% 50%; }
    50% { background-position: 100% 50%; }
    100% { background-position: 0% 50%; }
}


/* ==========================================
   BAGIAN 2: SIDEBAR (MENU SAMPING KIRI)
   ========================================== */
/* Container sidebar dengan background pink gradient */
.sidebar { 
    width: 280px; 
    background: linear-gradient(180deg, #fff5f9 0%, #ffe4f0 100%); 
    padding: 30px 20px; 
    border-right: 1px solid #ffe4f0; 
    height: 100vh; 
    position: fixed; 
    left: 0; 
    top: 0; 
    overflow-y: auto; 
    box-shadow: 4px 0 20px rgba(255, 105, 180, 0.08);
}

/* Efek dekorasi pattern di belakang sidebar */
.sidebar::before {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background-image: 
        radial-gradient(circle at 20% 30%, rgba(255, 105, 180, 0.05) 0%, transparent 50%),
        radial-gradient(circle at 80% 70%, rgba(255, 20, 147, 0.05) 0%, transparent 50%);
    pointer-events: none;
    z-index: 0;
}

/* Pastikan konten sidebar di atas pattern dekorasi */
.logo-section, .sidebar-menu {
    position: relative;
    z-index: 1;
}

/* Bagian logo di sidebar */
.logo-section { 
    display: flex; 
    align-items: center; 
    margin-bottom: 30px; 
    gap: 10px;
}

/* Icon/gambar logo berbentuk lingkaran */
.logo-icon { 
    width: 40px; 
    height: 40px; 
    background: linear-gradient(135deg, #ff69b4 0%, #ff1493 100%); 
    border-radius: 50%; /* Lingkaran sempurna */
    display: flex; 
    align-items: center; 
    justify-content: center; 
    color: white; 
    font-size: 24px; 
    box-shadow: 0 4px 20px rgba(255, 105, 180, 0.4);
    transition: transform 0.3s ease;
    overflow: hidden;
}

/* Styling untuk gambar di dalam logo */
.logo-icon img {
    width: 100%;
    height: 100%;
    object-fit: cover;
    border-radius: 50%;
}

/* Efek hover pada logo (sedikit berputar dan membesar) */
.logo-icon:hover {
    transform: rotate(5deg) scale(1.05);
}

/* Teks nama brand */
.logo-text h2 { 
    font-size: 16px; 
    color: #333; 
    font-weight: 700; 
}

/* Sub-teks brand (tagline) */
.logo-text p { 
    font-size: 12px; 
    color: #ff69b4; 
}

/* Container menu sidebar */
.sidebar-menu { 
    list-style: none; 
}

/* Jarak antar item menu */
.sidebar-menu li { 
    margin-bottom: 10px; 
}

/* Styling link menu */
.sidebar-menu a { 
    text-decoration: none; 
    color: #666; 
    font-size: 14px; 
    padding: 12px 15px; 
    border-radius: 8px; 
    display: block; 
    transition: all 0.3s ease;
}

/* Efek hover pada icon menu (berubah warna dan membesar) */
.sidebar-menu a:hover i {
    background: linear-gradient(135deg, #ff69b4 0%, #ff1493 100%);
    color: white;
    transform: scale(1.1);
}

/* Icon menu yang sedang aktif */
.sidebar-menu a.active i {
    background: linear-gradient(135deg, #ff69b4 0%, #ff1493 100%);
    color: white;
}

/* Icon di setiap menu */
.sidebar-menu a i { 
    margin-right: 10px; 
    display: inline-flex;
    align-items: center;
    justify-content: center;
    width: 32px;
    height: 32px;
    border-radius: 8px;
    background: linear-gradient(135deg, #ffe4f0 0%, #ffc0e0 100%);
    color: #ff1493;
    transition: all 0.3s ease;
}


/* ==========================================
   BAGIAN 3: KONTEN UTAMA (MAIN CONTENT)
   ========================================== */
/* Container konten utama di sebelah kanan sidebar */
.main-content { 
    margin-left: 280px; 
    flex: 1; 
    padding: 30px; 
}

/* Header bagian atas halaman */
.header { 
    display: flex; 
    justify-content: space-between; 
    align-items: center; 
    margin-bottom: 30px;
}

/* Judul halaman dengan efek gradient */
.header h1 { 
    font-size: 28px; 
    font-weight: 700; 
    background: linear-gradient(135deg, #f3eaeeff 0%, #e9e7e8ff 100%); 
    -webkit-background-clip: text; 
    -webkit-text-fill-color: transparent;
}


/* ==========================================
   BAGIAN 4: KARTU TOTAL PROFIT
   ========================================== */
/* Kartu info di header (Total Profit) */
.header-info {
    background: linear-gradient(135deg, #fff 0%, #fffafc 100%);
    padding: 20px 30px;
    border-radius: 12px;
    box-shadow: 0 4px 15px rgba(255, 105, 180, 0.2);
    border: 2px solid #ffe4f0;
    text-align: center;
    min-width: 200px;
}

/* Label "Total Profit" */
.header-info p {
    font-size: 12px;
    color: #666;
    font-weight: 600;
    text-transform: uppercase;
    letter-spacing: 0.5px;
    margin-bottom: 8px;
}

/* Nilai nominal profit dengan gradient */
.header-info .value { 
    font-size: 28px; 
    font-weight: 700;
    background: linear-gradient(135deg, #ff69b4 0%, #ff1493 100%);
    -webkit-background-clip: text;
    -webkit-text-fill-color: transparent;
}


/* ==========================================
   BAGIAN 5: GRID STATUS PESANAN
   ========================================== */
/* Layout grid untuk kartu status (4 kolom) */
.status-grid { 
    display: grid; 
    grid-template-columns: repeat(4, 1fr); 
    gap: 20px; 
    margin-bottom: 30px;
}

/* Kartu individual status pesanan */
.status-item { 
    background: linear-gradient(135deg, #fff 0%, #fffafc 100%); 
    padding: 25px; 
    border-radius: 12px; 
    text-align: center; 
    box-shadow: 0 4px 15px rgba(255, 105, 180, 0.1); 
    border: 1px solid #ffe4f0; 
    transition: all 0.3s ease;
}

/* Efek hover kartu status (naik sedikit) */
.status-item:hover { 
    transform: translateY(-5px); 
    box-shadow: 0 8px 25px rgba(255, 105, 180, 0.2);
}

/* Icon di kartu status */
.status-icon { 
    width: 60px; 
    height: 60px; 
    background: linear-gradient(135deg, #ff69b4 0%, #ff1493 100%); 
    border-radius: 12px; 
    display: flex; 
    align-items: center; 
    justify-content: center; 
    margin: 0 auto 15px; 
    font-size: 28px; 
    box-shadow: 0 4px 15px rgba(255, 105, 180, 0.3);
    transition: transform 0.3s ease;
    overflow: hidden;
}

/* Warna khusus untuk icon DIBATALKAN */
.status-item:nth-child(3) .status-icon {
    background: linear-gradient(135deg, #c62828 0%, #b71c1c 100%);
    box-shadow: 0 4px 15px rgba(198, 40, 40, 0.4);
}

/* Efek hover icon (membesar dan berputar 3D) */
.status-item:hover .status-icon {
    transform: scale(1.1) rotateY(360deg);
}

/* Label status (PENDING, PROCESS, dll) */
.status-label { 
    font-size: 13px; 
    color: #999; 
    margin-bottom: 8px; 
    text-transform: uppercase; 
    letter-spacing: 0.5px;
}

/* Angka jumlah pesanan dengan gradient */
.status-count { 
    font-size: 32px; 
    font-weight: 700; 
    background: linear-gradient(135deg, #ff69b4 0%, #ff1493 100%); 
    -webkit-background-clip: text; 
    -webkit-text-fill-color: transparent;
}


/* ==========================================
   BAGIAN 6: TABEL DATA
   ========================================== */
/* Container bagian tabel */
.table-section {
    background: linear-gradient(135deg, #fff 0%, #fffafc 100%);
    padding: 30px;
    border-radius: 16px;
    box-shadow: 0 8px 30px rgba(255, 105, 180, 0.15);
    margin-bottom: 30px;
    border: 2px solid #ffe4f0;
    overflow: hidden;
}

/* Judul tabel dengan icon */
.table-section h2 {
    font-size: 24px;
    margin-bottom: 25px;
    color: #333;
    font-weight: 700;
    display: flex;
    align-items: center;
    gap: 12px;
    padding-bottom: 15px;
    border-bottom: 3px solid #ff69b4;
}

/* Icon emoji di judul */
.table-section h2::before {
    content: '📋';
    font-size: 28px;
}

/* Wrapper tabel dengan scroll horizontal jika perlu */
.table-wrapper {
    overflow-x: auto;
    border-radius: 12px;
    box-shadow: 0 4px 15px rgba(255, 105, 180, 0.1);
}

/* ==========================================
   BAGIAN 6: TABEL DATA - DENGAN GARIS
   ========================================== */
/* Styling dasar tabel */
table {
    width: 100%;
    border-collapse: collapse;
    background: white;
    border-radius: 12px;
    overflow: hidden;
    border: 3px solid #ff69b4;
}

/* Header tabel yang sticky */
thead {
    background: linear-gradient(135deg, #ff69b4 0%, #ff1493 100%);
    position: sticky;
    top: 0;
    z-index: 10;
}

/* Sel header tabel */
th {
    padding: 18px 15px;
    text-align: left;
    font-size: 13px;
    color: white;
    font-weight: 700;
    text-transform: uppercase;
    letter-spacing: 0.8px;
    border: 2px solid rgba(255, 255, 255, 0.3);
    white-space: nowrap;
}

/* Baris tabel dengan efek hover */
tbody tr {
    transition: all 0.3s ease;
    background: white;
    border-bottom: 2px solid #ffe4f0;
}

/* Efek hover baris tabel */
tbody tr:hover {
    background: linear-gradient(135deg, #fff5f9 0%, #ffe4f0 100%);
    transform: translateX(5px);
    box-shadow: 0 4px 15px rgba(255, 105, 180, 0.15);
}

/* Sel data tabel */
td {
    padding: 18px 15px;
    font-size: 14px;
    color: #333;
    border: 2px solid #ffe4f0;
    vertical-align: middle;
}

/* Zebra striping - baris genap */
tbody tr:nth-child(even) {
    background: linear-gradient(135deg, #fffafc 0%, #fff5f9 100%);
}

/* Hover untuk baris genap */
tbody tr:nth-child(even):hover {
    background: linear-gradient(135deg, #fff0f6 0%, #ffe4f0 100%);
}

/* Kolom nomor urut dengan warna pink bold */
td:first-child {
    font-weight: 700;
    color: #ff1493;
    font-size: 15px;
}


/* ==========================================
   BAGIAN 7: BADGE STATUS PESANAN
   ========================================== */
/* Badge status umum */
.status-badge {
    padding: 8px 16px;
    border-radius: 25px;
    font-size: 11px;
    font-weight: 700;
    text-transform: uppercase;
    letter-spacing: 0.5px;
    display: inline-block;
    box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
    transition: all 0.3s ease;
}

/* Efek hover badge (naik sedikit) */
.status-badge:hover {
    transform: translateY(-2px);
    box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
}

/* Badge untuk status PENDING (kuning) */
.status-PENDING {
    background: linear-gradient(135deg, #fff3cd 0%, #ffd93d 100%);
    color: #856404;
    border: 2px solid #ffc107;
}

/* Badge untuk status PROCESS (biru) */
.status-PROCESS {
    background: linear-gradient(135deg, #cce5ff 0%, #66b3ff 100%);
    color: #004085;
    border: 2px solid #007bff;
}

/* Badge untuk status DIKIRIM (hijau) */
.status-DIKIRIM {
    background: linear-gradient(135deg, #d4edda 0%, #7dcc8d 100%);
    color: #155724;
    border: 2px solid #28a745;
}

/* Badge untuk status SELESAI (cyan) */
.status-SELESAI {
    background: linear-gradient(135deg, #d1ecf1 0%, #73c9db 100%);
    color: #0c5460;
    border: 2px solid #17a2b8;
}

/* Badge untuk status DIBATALKAN (merah tua - DIPERBAIKI) */
.status-DIBATALKAN {
    background: linear-gradient(135deg, #c62828 0%, #b71c1c 100%);
    color: white;
    border: 2px solid #8b0000;
}

/* ==========================================
   BAGIAN 8: STYLING METODE PEMBAYARAN
   ========================================== */
/* Styling untuk label metode pembayaran dalam tabel */
td span[style*="color"] {
    padding: 6px 14px;
    border-radius: 20px;
    font-weight: 700;
    font-size: 12px;
    display: inline-block;
    box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
    transition: all 0.3s ease;
}

/* Efek hover metode pembayaran */
td span[style*="color"]:hover {
    transform: scale(1.05);
    box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
}


/* ==========================================
   BAGIAN 9: GAMBAR DALAM TABEL
   ========================================== */
/* Styling untuk bukti pembayaran dan gambar produk */
.payment-proof,
.product-image {
    border-radius: 10px;
    border: 3px solid #ffe4f0;
    transition: all 0.3s ease;
    box-shadow: 0 2px 8px rgba(255, 105, 180, 0.2);
}

/* Efek hover gambar (membesar) */
.payment-proof:hover,
.product-image:hover {
    transform: scale(1.15);
    border-color: #ff69b4;
    box-shadow: 0 6px 20px rgba(255, 105, 180, 0.4);
    z-index: 10;
}

/* Gambar produk dengan ukuran fixed */
.product-image { 
    width: 60px; 
    height: 60px; 
    object-fit: cover; 
    border-radius: 8px; 
    border: 2px solid #ffe4f0;
    transition: transform 0.3s ease;
}

/* Bukti pembayaran dengan ukuran lebih besar */
.payment-proof { 
    width: 80px; 
    height: 80px; 
    object-fit: cover; 
    border-radius: 8px; 
    border: 2px solid #ffe4f0; 
    cursor: pointer; 
    transition: all 0.3s ease;
}


/* ==========================================
   BAGIAN 10: TOMBOL AKSI (EDIT, DELETE, VIEW)
   ========================================== */
/* Tombol Edit, Delete, View */
.btn-edit,
.btn-delete,
.btn-view {
    padding: 9px 16px;
    border-radius: 8px;
    font-size: 12px;
    font-weight: 600;
    text-decoration: none;
    display: inline-block;
    transition: all 0.3s ease;
    border: 2px solid transparent;
    cursor: pointer;
    text-transform: uppercase;
    letter-spacing: 0.5px;
}

/* Tombol Edit (hijau) */
.btn-edit {
    background: linear-gradient(135deg, #4CAF50 0%, #45a049 100%);
    color: white;
    box-shadow: 0 3px 10px rgba(76, 175, 80, 0.3);
}

/* Hover tombol Edit */
.btn-edit:hover {
    transform: translateY(-3px);
    box-shadow: 0 6px 20px rgba(76, 175, 80, 0.5);
    border-color: #45a049;
}

/* Tombol Delete (merah) */
.btn-delete {
    background: linear-gradient(135deg, #f44336 0%, #e53935 100%);
    color: white;
    box-shadow: 0 3px 10px rgba(244, 67, 54, 0.3);
}

/* Hover tombol Delete */
.btn-delete:hover {
    transform: translateY(-3px);
    box-shadow: 0 6px 20px rgba(244, 67, 54, 0.5);
    border-color: #e53935;
}

/* Tombol View (ungu) */
.btn-view {
    background: linear-gradient(135deg, #9C27B0 0%, #7B1FA2 100%);
    color: white;
    box-shadow: 0 3px 10px rgba(156, 39, 176, 0.3);
}

/* Hover tombol View */
.btn-view:hover {
    transform: translateY(-3px);
    box-shadow: 0 6px 20px rgba(156, 39, 176, 0.5);
    border-color: #7B1FA2;
}

/* Dropdown select dalam tabel */
td select {
    padding: 8px 12px;
    border: 2px solid #ffe4f0;
    border-radius: 8px;
    font-size: 12px;
    font-weight: 600;
    color: #ff1493;
    background: linear-gradient(135deg, #fff 0%, #fffafc 100%);
    cursor: pointer;
    transition: all 0.3s ease;
}

/* Hover dropdown select */
td select:hover {
    border-color: #ff69b4;
    box-shadow: 0 2px 8px rgba(255, 105, 180, 0.2);
}

/* Focus dropdown select */
td select:focus {
    outline: none;
    border-color: #ff1493;
    box-shadow: 0 0 0 3px rgba(255, 105, 180, 0.2);
}


/* ==========================================
   BAGIAN 11: EMPTY STATE & RESPONSIVE
   ========================================== */
/* Pesan ketika tabel kosong */
td[colspan] {
    text-align: center;
    padding: 40px 20px;
    color: #999;
    font-style: italic;
    font-size: 15px;
}

/* Responsive untuk layar kecil */
@media (max-width: 1200px) {
    .table-wrapper {
        overflow-x: auto;
    }
    
    table {
        min-width: 1000px;
    }
}

/* Animasi loading untuk skeleton screen */
@keyframes shimmer {
    0% {
        background-position: -1000px 0;
    }
    100% {
        background-position: 1000px 0;
    }
}

.table-loading {
    animation: shimmer 2s infinite;
    background: linear-gradient(to right, #f6f7f8 0%, #edeef1 20%, #f6f7f8 40%, #f6f7f8 100%);
    background-size: 1000px 100%;
}


/* ==========================================
   BAGIAN 12: MODAL (POP-UP)
   ========================================== */
/* Container modal (overlay gelap) */
.modal { 
    display: none; 
    position: fixed; 
    z-index: 1000; 
    left: 0; 
    top: 0; 
    width: 100%; 
    height: 100%; 
    background-color: rgba(255, 105, 180, 0.3); 
    backdrop-filter: blur(5px);
}

/* Konten modal (kotak putih di tengah) */
.modal-content { 
    background: linear-gradient(135deg, #fff 0%, #fffafc 100%); 
    margin: 5% auto; 
    padding: 35px; 
    border-radius: 12px; 
    width: 90%; 
    max-width: 600px; 
    box-shadow: 0 8px 30px rgba(255, 105, 180, 0.3); 
    border: 1px solid #ffe4f0;
}

/* Header modal */
.modal-header { 
    display: flex; 
    justify-content: space-between; 
    align-items: center; 
    margin-bottom: 20px;
}

/* Judul modal */
.modal-header h3 { 
    font-size: 20px; 
    color: #ff1493; 
    font-weight: 700;
}

/* Tombol close (X) */
.close { 
    color: #ff69b4; 
    font-size: 28px; 
    font-weight: bold; 
    cursor: pointer; 
    transition: all 0.3s ease;
}

/* Hover tombol close (berputar) */
.close:hover { 
    color: #ff1493; 
    transform: rotate(90deg);
}

/* Gambar di dalam modal */
.modal-image { 
    max-width: 100%; 
    height: auto; 
    border-radius: 12px; 
    margin-top: 15px; 
    border: 2px solid #ffe4f0;
}


/* ==========================================
   BAGIAN 13: FORM (TAMBAH/EDIT DATA)
   ========================================== */
/* Container form */
.form-container { 
    background: linear-gradient(135deg, #fff 0%, #fffafc 100%); 
    padding: 40px; 
    border-radius: 16px; 
    box-shadow: 0 8px 30px rgba(255, 105, 180, 0.2); 
    max-width: 650px; 
    border: 2px solid #ffe4f0;
    margin: 0 auto;
    position: relative;
    overflow: hidden;
}

/* Efek dekorasi di belakang form */
.form-container::before {
    content: '';
    position: absolute;
    top: -50%;
    right: -50%;
    width: 200%;
    height: 200%;
    background: radial-gradient(circle, rgba(255, 105, 180, 0.05) 0%, transparent 70%);
    pointer-events: none;
}

/* Grup input form */
.form-group { 
    margin-bottom: 25px; 
    position: relative;
    z-index: 1;
}

/* Label form dengan icon */
.form-group label { 
    display: flex;
    align-items: center;
    gap: 8px;
    font-size: 14px; 
    font-weight: 700; 
    margin-bottom: 10px; 
    color: #ff1493;
    text-transform: uppercase;
    letter-spacing: 0.5px;
}

/* Icon camera untuk label gambar */
.form-group label[for*="gambar"]::before {
    font-family: "Font Awesome 6 Free";
    font-weight: 900;
    content: '\f03e';
    font-size: 16px;
}

/* Icon tag untuk label nama */
.form-group label[for*="nama"]::before {
    font-family: "Font Awesome 6 Free";
    font-weight: 900;
    content: '\f02b';
    font-size: 16px;
}

/* Icon money untuk label harga */
.form-group label[for*="harga"]::before {
    font-family: "Font Awesome 6 Free";
    font-weight: 900;
    content: '\f155';
    font-size: 16px;
}

/* Icon box untuk label stock */
.form-group label[for*="stock"]::before {
    font-family: "Font Awesome 6 Free";
    font-weight: 900;
    content: '\f49e';
    font-size: 16px;
}

/* Input, textarea, dan select */
.form-group input, .form-group textarea, .form-group select { 
    width: 100%; 
    padding: 14px 18px; 
    border: 2px solid #ffe4f0; 
    border-radius: 10px; 
    font-size: 14px; 
    transition: all 0.3s ease;
    background: white;
    font-family: inherit;
}

/* Focus state untuk input */
.form-group input:focus, .form-group textarea:focus, .form-group select:focus { 
    border-color: #ff69b4; 
    outline: none; 
    box-shadow: 0 0 0 4px rgba(255, 105, 180, 0.1);
    transform: translateY(-2px);
}

/* Textarea khusus */
.form-group textarea { 
    min-height: 100px; 
    resize: vertical;
}

/* Input file */
.form-group input[type="file"] {
    padding: 12px;
    cursor: pointer;
    border-style: dashed;
}

/* Hover input file */
.form-group input[type="file"]:hover {
    border-color: #ff69b4;
    background: linear-gradient(135deg, #fffafc 0%, #fff0f6 100%);
}

/* Container tombol form */
.form-actions { 
    display: flex; 
    gap: 15px; 
    margin-top: 30px;
    position: relative;
    z-index: 1;
}

/* Tombol Simpan (pink) */
.btn-save { 
    background: linear-gradient(135deg, #ff69b4 0%, #ff1493 100%); 
    color: white; 
    border: none; 
    padding: 14px 32px; 
    border-radius: 10px; 
    cursor: pointer; 
    font-size: 14px; 
    font-weight: 700; 
    transition: all 0.3s ease; 
    box-shadow: 0 4px 15px rgba(255, 105, 180, 0.3);
    text-transform: uppercase;
    letter-spacing: 0.5px;
    display: flex;
    align-items: center;
    gap: 8px;
}

/* Icon check di tombol simpan */
.btn-save::before {
    font-family: "Font Awesome 6 Free";
    font-weight: 900;
    content: '\f00c';
    font-size: 14px;
}

/* Hover tombol simpan */
.btn-save:hover { 
    transform: translateY(-3px); 
    box-shadow: 0 6px 20px rgba(255, 105, 180, 0.4);
}

/* ========================================
   🔴 TOMBOL CANCEL (BATAL)
   ======================================== */
/* Styling untuk tombol pembatalan */
.btn-cancel { 
    background: linear-gradient(135deg, #e0e0e0 0%, #bdbdbd 100%); /* Warna background gradasi abu-abu */
    color: #333; /* Warna teks gelap */
    border: none; /* Tanpa border */
    padding: 14px 32px; /* Jarak dalam tombol (atas-bawah 14px, kiri-kanan 32px) */
    border-radius: 10px; /* Sudut membulat */
    cursor: pointer; /* Kursor jadi tangan saat diarahkan */
    font-size: 14px; /* Ukuran huruf */
    text-decoration: none; /* Hilangkan garis bawah */
    display: inline-flex; /* Tampilan flexbox inline */
    align-items: center; /* Item di tengah secara vertikal */
    gap: 8px; /* Jarak antar item (icon dan teks) */
    text-align: center; /* Teks di tengah */
    transition: all 0.3s ease; /* Animasi halus 0.3 detik */
    font-weight: 700; /* Tebal huruf */
    text-transform: uppercase; /* Huruf kapital semua */
    letter-spacing: 0.5px; /* Jarak antar huruf */
}

/* Icon "X" di depan teks tombol cancel */
.btn-cancel::before {
    font-family: "Font Awesome 6 Free"; /* Pakai font icon Font Awesome */
    font-weight: 900; /* Tebal icon */
    content: '\f00d'; /* Kode icon "times" (X) */
    font-size: 14px; /* Ukuran icon */
}

/* Efek saat kursor hover di tombol cancel */
.btn-cancel:hover { 
    transform: translateY(-3px); /* Tombol naik ke atas 3px */
    box-shadow: 0 4px 12px rgba(0, 0, 0, 0.2); /* Bayangan hitam */
    background: linear-gradient(135deg, #bdbdbd 0%, #9e9e9e 100%); /* Warna jadi lebih gelap */
}


/* ========================================
   🖼️ PREVIEW GAMBAR
   ======================================== */
/* Kotak untuk preview gambar produk */
.image-preview { 
    max-width: 250px; /* Lebar maksimal 250px */
    margin-top: 15px; /* Jarak dari atas 15px */
    border-radius: 12px; /* Sudut membulat */
    display: none; /* Disembunyikan dulu (nanti dimunculkan pakai JavaScript) */
    border: 3px solid #ffe4f0; /* Border pink 3px */
    box-shadow: 0 4px 15px rgba(255, 105, 180, 0.2); /* Bayangan pink lembut */
}


/* ========================================
   📊 BAGIAN LAPORAN (REPORT)
   ======================================== */

/* --- Header Laporan --- */
.report-header { 
    margin-bottom: 30px; /* Jarak bawah 30px */
}

/* --- Grid untuk Statistik (2 kolom) --- */
.report-stats-grid { 
    display: grid; /* Pakai sistem grid */
    grid-template-columns: repeat(2, 1fr); /* 2 kolom dengan lebar sama */
    gap: 20px; /* Jarak antar kolom 20px */
    margin-bottom: 30px; /* Jarak bawah 30px */
}

/* --- Kartu Laporan (untuk menampilkan statistik) --- */
.report-card { 
    background: linear-gradient(135deg, #fff 0%, #fffafc 100%); /* Background putih ke pink muda */
    padding: 30px; /* Jarak dalam kartu 30px */
    border-radius: 12px; /* Sudut membulat */
    box-shadow: 0 4px 15px rgba(255, 105, 180, 0.1); /* Bayangan pink lembut */
    border-left: 4px solid #ff69b4; /* Border kiri pink tebal */
    transition: all 0.3s ease; /* Animasi halus */
    position: relative; /* Posisi relatif (untuk ::before) */
    overflow: hidden; /* Sembunyikan yang keluar dari kotak */
}

/* Dekorasi lingkaran pink di pojok kanan atas kartu */
.report-card::before { 
    content: ''; /* Konten kosong */
    position: absolute; /* Posisi absolut */
    top: 0; /* Di atas */
    right: 0; /* Di kanan */
    width: 100px; /* Lebar 100px */
    height: 100px; /* Tinggi 100px */
    background: linear-gradient(135deg, #ff69b4 0%, #ff1493 100%); /* Gradasi pink */
    opacity: 0.05; /* Transparansi 95% (hampir tidak terlihat) */
    border-radius: 0 0 0 100%; /* Bentuk seperempat lingkaran */
}

/* Efek saat hover di kartu laporan */
.report-card:hover { 
    transform: translateY(-5px); /* Kartu naik ke atas 5px */
    box-shadow: 0 8px 25px rgba(255, 105, 180, 0.2); /* Bayangan lebih jelas */
}

/* --- Icon dalam Kartu --- */
.report-card-icon { 
    width: 50px; /* Lebar 50px */
    height: 50px; /* Tinggi 50px */
    background: linear-gradient(135deg, #ff69b4 0%, #ff1493 100%); /* Gradasi pink */
    border-radius: 10px; /* Sudut membulat */
    display: flex; /* Flexbox */
    align-items: center; /* Icon di tengah vertikal */
    justify-content: center; /* Icon di tengah horizontal */
    font-size: 24px; /* Ukuran icon/emoji */
    margin-bottom: 15px; /* Jarak bawah 15px */
    box-shadow: 0 4px 15px rgba(255, 105, 180, 0.3); /* Bayangan pink */
}

/* --- Label Kartu (teks keterangan kecil) --- */
.report-card-label { 
    font-size: 13px; /* Ukuran huruf kecil */
    color: #999; /* Warna abu-abu */
    margin-bottom: 10px; /* Jarak bawah 10px */
    text-transform: uppercase; /* Huruf kapital semua */
    letter-spacing: 0.5px; /* Jarak antar huruf */
    font-weight: 600; /* Agak tebal */
}

/* --- Nilai Kartu (angka besar) --- */
.report-card-value { 
    font-size: 32px; /* Ukuran huruf besar */
    font-weight: 700; /* Tebal */
    background: linear-gradient(135deg, #ff69b4 0%, #ff1493 100%); /* Gradasi pink */
    -webkit-background-clip: text; /* Clip background ke teks */
    -webkit-text-fill-color: transparent; /* Warna teks transparan (jadi kelihatan gradasi) */
}


/* --- Detail Laporan (kotak tabel detail) --- */
.report-detail { 
    background: linear-gradient(135deg, #fff 0%, #fffafc 100%); /* Background putih ke pink muda */
    padding: 30px; /* Jarak dalam 30px */
    border-radius: 12px; /* Sudut membulat */
    box-shadow: 0 4px 15px rgba(255, 105, 180, 0.1); /* Bayangan pink */
    border: 1px solid #ffe4f0; /* Border pink tipis */
}

/* --- Judul h2 di Detail Laporan --- */
.report-detail h2 { 
    font-size: 22px; /* Ukuran huruf */
    color: #333; /* Warna gelap */
    margin-bottom: 25px; /* Jarak bawah */
    font-weight: 700; /* Tebal */
    padding-bottom: 15px; /* Jarak dalam bawah */
    border-bottom: 3px solid #ff69b4; /* Garis bawah pink */
    display: flex; /* Flexbox */
    align-items: center; /* Item di tengah */
    gap: 10px; /* Jarak antar item */
}

/* Icon emoji di depan judul h2 */
.report-detail h2::before { 
    content: '📊'; /* Emoji grafik */
    font-size: 28px; /* Ukuran emoji */
}


/* --- Tabel Laporan --- */
.report-table { 
    width: 100%; /* Lebar penuh */
    border-collapse: separate; /* Border terpisah (bukan menyatu) */
    border-spacing: 0 10px; /* Jarak antar baris 10px */
}

/* --- Baris Tabel --- */
.report-table tr { 
    background: linear-gradient(135deg, #fffafc 0%, #fff0f6 100%); /* Background pink muda gradasi */
    border-radius: 8px; /* Sudut membulat */
    transition: all 0.3s ease; /* Animasi halus */
}

/* Efek saat hover di baris tabel */
.report-table tr:hover { 
    transform: translateX(5px); /* Baris bergeser ke kanan 5px */
    box-shadow: 0 4px 12px rgba(255, 105, 180, 0.15); /* Bayangan pink */
}

/* --- Sel (td) Tabel --- */
.report-table td { 
    padding: 18px 15px; /* Jarak dalam sel */
    font-size: 14px; /* Ukuran huruf */
}

/* Kolom pertama (label) */
.report-table td:first-child { 
    color: #666; /* Warna abu-abu */
    font-weight: 600; /* Agak tebal */
    width: 50%; /* Lebar 50% */
    border-radius: 8px 0 0 8px; /* Sudut kiri membulat */
    padding-left: 20px; /* Jarak kiri dalam */
}

/* Kolom terakhir (nilai) */
.report-table td:last-child { 
    color: #ff1493; /* Warna pink */
    font-weight: 700; /* Tebal */
    text-align: right; /* Teks rata kanan */
    border-radius: 0 8px 8px 0; /* Sudut kanan membulat */
    padding-right: 20px; /* Jarak kanan dalam */
    font-size: 16px; /* Ukuran huruf lebih besar */
}


/* ========================================
   ➕ TOMBOL TAMBAH PRODUK
   ======================================== */
.btn-add-product {
    background: linear-gradient(135deg, #ff69b4 0%, #ff1493 100%); /* Gradasi pink */
    color: white; /* Warna teks putih */
    padding: 14px 28px; /* Jarak dalam tombol */
    border-radius: 12px; /* Sudut membulat */
    text-decoration: none; /* Hilangkan garis bawah */
    display: inline-flex; /* Flexbox inline */
    align-items: center; /* Item di tengah */
    gap: 10px; /* Jarak antar item (icon dan teks) */
    font-size: 14px; /* Ukuran huruf */
    font-weight: 700; /* Tebal */
    box-shadow: 0 4px 15px rgba(255, 105, 180, 0.3); /* Bayangan pink */
    transition: all 0.3s ease; /* Animasi halus */
    border: 2px solid transparent; /* Border transparan dulu */
    text-transform: uppercase; /* Huruf kapital */
    letter-spacing: 0.5px; /* Jarak antar huruf */
}

/* Efek saat hover di tombol tambah produk */
.btn-add-product:hover {
    transform: translateY(-3px); /* Tombol naik 3px */
    box-shadow: 0 8px 25px rgba(255, 105, 180, 0.5); /* Bayangan lebih jelas */
    border-color: #fff; /* Border jadi putih */
}

/* Icon dalam tombol tambah produk */
.btn-add-product i {
    font-size: 16px; /* Ukuran icon */
    animation: pulse 2s infinite; /* Animasi pulse terus-menerus */
}

/* Animasi pulse (membesar-mengecil) */
@keyframes pulse {
    0%, 100% {
        transform: scale(1); /* Ukuran normal */
    }
    50% {
        transform: scale(1.1); /* Membesar 10% */
    }
}


/* ========================================
   📜 SCROLLBAR (Bilah Gulir)
   ======================================== */
/* Lebar scrollbar */
::-webkit-scrollbar { 
    width: 10px; /* Lebar 10px */
}

/* Track (jalur) scrollbar */
::-webkit-scrollbar-track { 
    background: #fff0f6; /* Background pink muda */
}

/* Thumb (pegangan) scrollbar */
::-webkit-scrollbar-thumb { 
    background: linear-gradient(135deg, #ff69b4 0%, #ff1493 100%); /* Gradasi pink */
    border-radius: 10px; /* Sudut membulat */
}

/* Thumb saat hover */
::-webkit-scrollbar-thumb:hover { 
    background: linear-gradient(135deg, #ff1493 0%, #c71585 100%); /* Gradasi pink lebih gelap */
}


/* ========================================
   ⚠️ ALERT NOTIFICATION (Pemberitahuan)
   ======================================== */
/* Kotak alert utama */
.alert-notification {
    background: linear-gradient(135deg, #fff9e6 0%, #ffe8b3 100%); /* Gradasi kuning muda */
    border: 2px solid #ffc107; /* Border kuning */
    border-left: 6px solid #ff9800; /* Border kiri orange tebal */
    border-radius: 12px; /* Sudut membulat */
    padding: 20px 25px; /* Jarak dalam */
    margin-bottom: 25px; /* Jarak bawah */
    display: flex; /* Flexbox */
    align-items: center; /* Item di tengah vertikal */
    gap: 20px; /* Jarak antar item */
    box-shadow: 0 4px 15px rgba(255, 152, 0, 0.15); /* Bayangan orange */
    animation: slideDown 0.4s ease; /* Animasi muncul dari atas */
    position: relative; /* Posisi relatif */
    overflow: hidden; /* Sembunyikan overflow */
}

/* Efek kilau di alert */
.alert-notification::before {
    content: ''; /* Konten kosong */
    position: absolute; /* Posisi absolut */
    top: 0; 
    left: 0; 
    right: 0; 
    bottom: 0; 
    background: linear-gradient(45deg, transparent 30%, rgba(255, 255, 255, 0.3) 50%, transparent 70%); /* Gradasi putih transparan */
    pointer-events: none; /* Tidak bisa di-klik */
}

/* Animasi slide down (muncul dari atas) */
@keyframes slideDown {
    from {
        opacity: 0; /* Transparan */
        transform: translateY(-20px); /* Posisi 20px di atas */
    }
    to {
        opacity: 1; /* Terlihat penuh */
        transform: translateY(0); /* Posisi normal */
    }
}

/* --- Icon dalam Alert --- */
.alert-icon {
    width: 50px; /* Lebar 50px */
    height: 50px; /* Tinggi 50px */
    background: linear-gradient(135deg, #ff9800 0%, #f57c00 100%); /* Gradasi orange */
    border-radius: 12px; /* Sudut membulat */
    display: flex; /* Flexbox */
    align-items: center; /* Icon di tengah vertikal */
    justify-content: center; /* Icon di tengah horizontal */
    font-size: 24px; /* Ukuran icon */
    color: white; /* Warna putih */
    flex-shrink: 0; /* Tidak mengecil */
    box-shadow: 0 4px 12px rgba(255, 152, 0, 0.3); /* Bayangan orange */
    animation: pulse 2s infinite; /* Animasi pulse */
}

/* Animasi pulse untuk icon (sama seperti sebelumnya) */
@keyframes pulse {
    0%, 100% {
        transform: scale(1); /* Ukuran normal */
    }
    50% {
        transform: scale(1.05); /* Membesar 5% */
    }
}

/* --- Konten Alert (teks) --- */
.alert-content {
    flex: 1; /* Ambil sisa ruang */
    color: #856404; /* Warna coklat */
    font-size: 14px; /* Ukuran huruf */
    line-height: 1.6; /* Jarak antar baris */
    position: relative; /* Posisi relatif */
    z-index: 1; /* Di atas ::before */
}

/* Teks tebal dalam alert */
.alert-content strong {
    color: #664300; /* Warna coklat lebih gelap */
    font-weight: 700; /* Tebal */
}

/* --- Tombol Close Alert --- */
.alert-close {
    width: 36px; /* Lebar 36px */
    height: 36px; /* Tinggi 36px */
    background: rgba(133, 100, 4, 0.1); /* Background coklat transparan */
    border: 2px solid rgba(133, 100, 4, 0.2); /* Border coklat transparan */
    border-radius: 8px; /* Sudut membulat */
    display: flex; /* Flexbox */
    align-items: center; /* Icon di tengah */
    justify-content: center; /* Icon di tengah */
    cursor: pointer; /* Kursor jadi tangan */
    transition: all 0.3s ease; /* Animasi halus */
    flex-shrink: 0; /* Tidak mengecil */
    font-size: 18px; /* Ukuran icon */
    color: #856404; /* Warna coklat */
    position: relative; /* Posisi relatif */
    z-index: 1; /* Di atas ::before */
}

/* Efek hover di tombol close */
.alert-close:hover {
    background: linear-gradient(135deg, #f44336 0%, #d32f2f 100%); /* Gradasi merah */
    border-color: #d32f2f; /* Border merah */
    color: white; /* Warna putih */
    transform: rotate(90deg); /* Putar 90 derajat */
    box-shadow: 0 4px 12px rgba(244, 67, 54, 0.3); /* Bayangan merah */
}

/* Icon dalam tombol close */
.alert-close i {
    pointer-events: none; /* Tidak bisa di-klik (klik-nya di parent) */
}

/* ========================================
   🖨️ PRINT STYLES (Untuk Cetak)
   ======================================== */
@media print {
    /* Reset semua untuk print */
    * {
        -webkit-print-color-adjust: exact !important;
        print-color-adjust: exact !important;
        color-adjust: exact !important;
    }
    
    /* Sembunyikan sidebar dan tombol saat print */
    .sidebar,
    .btn-add-product,
    .btn-print,
    #resetNotif {
        display: none !important;
    }
    
    /* Main content full width saat print */
    .main-content {
        margin-left: 0 !important;
        padding: 20px !important;
        width: 100% !important;
    }
    
    /* Header untuk print */
    .header {
        margin-bottom: 20px !important;
        page-break-after: avoid !important;
    }
    
    .header h1 {
        -webkit-text-fill-color: #333 !important;
        color: #333 !important;
        background: none !important;
    }
    
    /* Card statistik untuk print */
    .report-stats-grid,
    .report-card,
    .report-detail {
        page-break-inside: avoid !important;
        break-inside: avoid !important;
    }
    
    /* Grid 2 kolom untuk grafik */
    .report-stats-grid {
        display: grid !important;
        grid-template-columns: 1fr 1fr !important;
        gap: 20px !important;
        margin-bottom: 20px !important;
    }
    
    /* Kartu laporan */
    .report-card {
        background: white !important;
        border: 2px solid #ffe4f0 !important;
        padding: 20px !important;
        border-radius: 10px !important;
    }
    
    .report-card-value {
        -webkit-text-fill-color: #ff1493 !important;
        color: #ff1493 !important;
    }
    
    /* Detail laporan */
    .report-detail {
        background: white !important;
        border: 2px solid #ffe4f0 !important;
        padding: 20px !important;
        border-radius: 10px !important;
        margin-bottom: 20px !important;
    }
    
    .report-detail h2 {
        color: #333 !important;
        border-bottom: 3px solid #ff69b4 !important;
        padding-bottom: 10px !important;
        margin-bottom: 15px !important;
    }
    
    /* Tabel untuk print */
    table {
        width: 100% !important;
        border-collapse: collapse !important;
        background: white !important;
        page-break-inside: auto !important;
    }
    
    thead {
        display: table-header-group !important;
        background: #ff69b4 !important;
    }
    
    th {
        background: #ff69b4 !important;
        color: white !important;
        padding: 10px !important;
        border: 1px solid #ff1493 !important;
    }
    
    tbody tr {
        page-break-inside: avoid !important;
        break-inside: avoid !important;
    }
    
    td {
        padding: 10px !important;
        border: 1px solid #ffe4f0 !important;
    }
    
    /* Canvas grafik */
    canvas {
        max-width: 100% !important;
        height: auto !important;
    }
    
    /* Grid untuk grafik side by side */
    div[style*="display: grid"] {
        display: grid !important;
        grid-template-columns: 1fr 1fr !important;
        gap: 20px !important;
        page-break-inside: avoid !important;
    }
    
    /* Pastikan background gradient tetap muncul */
    body {
        background: white !important;
    }
}

/* ==========================================
   📱 RESPONSIVE DESIGN - MOBILE & TABLET
   ========================================== */

/* Mobile Portrait & Landscape */
@media (max-width: 1024px) {
    /* Sidebar jadi overlay (bisa dibuka/tutup) */
    .sidebar {
        position: fixed;
        left: -280px; /* Sembunyikan di kiri */
        transition: left 0.3s ease;
        z-index: 2000;
        height: 100vh;
        box-shadow: 4px 0 20px rgba(0,0,0,0.3);
    }
    
    /* Sidebar aktif (muncul) */
    .sidebar.active {
        left: 0;
    }
    
    /* Main content full width di mobile */
    .main-content {
        margin-left: 0 !important;
        padding: 20px 15px;
        width: 100%;
    }
    
    /* Header */
    .header {
        flex-direction: column;
        gap: 15px;
        align-items: flex-start;
    }
    
    .header h1 {
        font-size: 22px;
    }
    
    .header-info {
        width: 100%;
        min-width: auto;
    }
    
    /* Grid status jadi 2 kolom */
    .status-grid {
        grid-template-columns: repeat(2, 1fr);
        gap: 15px;
    }
    
    /* Status item lebih compact */
    .status-item {
        padding: 20px 15px;
    }
    
    .status-icon {
        width: 50px;
        height: 50px;
        font-size: 24px;
    }
    
    .status-count {
        font-size: 28px;
    }
    
    /* ===== PERBAIKAN TABLE SECTION -    /* ===== PERBAIKAN TABLE SECTION - SMOOTH SCROLL ===== */
    .table-section {
        padding: 20px 15px;
        overflow: visible;
        position: relative;
    }
    
    .table-section h2 {
        font-size: 20px;
        margin-bottom: 15px;
        position: sticky;
        top: 0;
        background: white;
        z-index: 10;
        padding: 10px 0;
    }
    
    /* ✅ Wrapper untuk scroll horizontal yang smooth */
    .table-wrapper {
        overflow-x: auto;
        overflow-y: visible;
        -webkit-overflow-scrolling: touch;
        border-radius: 12px;
        position: relative;
        margin: 0 -15px;
        padding: 0 15px;
    }
    
    /* ✅ Indikator scroll - shadow di kanan */
    .table-wrapper::after {
        content: '→';
        position: sticky;
        right: 0;
        top: 50%;
        transform: translateY(-50%);
        padding: 10px 15px;
        background: linear-gradient(to left, rgba(255,105,180,0.8), transparent);
        color: white;
        font-size: 20px;
        font-weight: bold;
        pointer-events: none;
        z-index: 5;
        border-radius: 20px 0 0 20px;
    }
    
    /* ✅ Table dengan min-width untuk scroll horizontal */
    table {
        min-width: 1200px; /* Lebar minimum untuk scroll */
        font-size: 10px;
        width: 100%;
        display: block;
        overflow-x: auto;
    }
    
    thead, tbody, tr {
        display: table;
        width: 100%;
        table-layout: fixed;
    }
    
    th, td {
        padding: 10px 6px;
        font-size: 10px;
        white-space: nowrap;
        vertical-align: middle;
    }

    /* ✅ Lebar kolom spesifik untuk rapi */
    th:nth-child(1), td:nth-child(1) { width: 40px; } /* No */
    th:nth-child(2), td:nth-child(2) { width: 100px; } /* Pelanggan */
    th:nth-child(3), td:nth-child(3) { width: 110px; } /* Telepon */
    th:nth-child(4), td:nth-child(4) { width: 150px; } /* Items */
    th:nth-child(5), td:nth-child(5) { width: 80px; } /* Metode */
    th:nth-child(6), td:nth-child(6) { width: 80px; } /* Bukti Bayar */
    th:nth-child(7), td:nth-child(7) { width: 100px; } /* Status */
    th:nth-child(8), td:nth-child(8) { width: 130px; } /* Aksi */
    th:nth-child(9), td:nth-child(9) { width: 100px; } /* Total */
    th:nth-child(10), td:nth-child(10) { width: 120px; } /* Waktu */

    
    /* ✅ Kolom items boleh wrap */
    td:nth-child(4) {
        white-space: normal;
        word-break: break-word;
        line-height: 1.4;
    }
    
    /* ✅ Total & Waktu lebih rapi */
    td:nth-child(9), td:nth-child(10) {
        font-size: 10px;
        font-weight: 600;
    }
    
    /* Gambar lebih kecil */
    .payment-proof {
        width: 60px;
        height: 60px;
    }
    
    .product-image {
        width: 50px;
        height: 50px;
    }
    
    /* Form container */
    .form-container {
        padding: 25px 20px;
        max-width: 100%;
    }
    
    .form-group label {
        font-size: 13px;
    }
    
    .form-group input,
    .form-group textarea,
    .form-group select {
        padding: 12px 15px;
        font-size: 13px;
    }
    
    /* Buttons stack di mobile */
    .form-actions {
        flex-direction: column;
        gap: 10px;
    }
    
    .btn-save,
    .btn-cancel {
        width: 100%;
        justify-content: center;
        padding: 12px 20px;
    }
    
    /* Report cards jadi 1 kolom */
    .report-stats-grid {
        grid-template-columns: 1fr;
        gap: 15px;
    }
    
    /* Grafik jadi 1 kolom */
    div[style*="grid-template-columns: 1fr 1fr"] {
        display: grid !important;
        grid-template-columns: 1fr !important;
        gap: 20px !important;
    }
    
    .report-detail {
        padding: 20px 15px;
    }
    
    .report-detail h2 {
        font-size: 18px;
    }
    
    /* Alert notification */
    .alert-notification {
        flex-direction: column;
        text-align: center;
        padding: 15px;
    }
    
    .alert-icon {
        width: 40px;
        height: 40px;
        font-size: 20px;
    }
    
    .alert-content {
        font-size: 13px;
    }
    
    /* Modal lebih kecil */
    .modal-content {
        width: 95%;
        padding: 25px 20px;
        margin: 10% auto;
    }
    
    .modal-header h3 {
        font-size: 18px;
    }
}

/* Tablet Landscape */
@media (min-width: 768px) and (max-width: 1024px) {
    .sidebar {
        width: 250px;
    }
    
    .status-grid {
        grid-template-columns: repeat(2, 1fr);
    }
}

/* Mobile Small (< 480px) */
@media (max-width: 480px) {
    .header h1 {
        font-size: 18px;
    }
    
    /* ✅ YANG INI DIGANTI - DARI 1fr JADI 2 KOLOM */
    .status-grid {
        grid-template-columns: repeat(2, 1fr); /* ✅ BARU */
        gap: 8px; /* ✅ DIPERKECIL dari 10px */
    }
    
    /* ✅ PADDING DIPERKECIL */
    .status-item {
        padding: 12px 8px; /* ✅ BARU - dari 15px */
    }
    
    /* ✅ ICON DIPERKECIL */
    .status-icon {
        width: 40px; /* ✅ BARU - dari 45px */
        height: 40px;
        font-size: 18px; /* ✅ BARU - dari 20px */
        margin-bottom: 8px; /* ✅ BARU DITAMBAH */
    }
    
    /* ✅ FONT DIPERKECIL */
    .status-count {
        font-size: 22px; /* ✅ BARU - dari 24px */
    }
    
    /* ✅ LABEL DIPERKECIL */
    .status-label {
        font-size: 10px; /* ✅ BARU - dari 11px */
        margin-bottom: 6px; /* ✅ BARU DITAMBAH */
    }
    
    /* Sisanya sama */
    .table-section {
        padding: 15px 10px;
    }
    
    table {
        font-size: 11px;
    }
    
    th, td {
        padding: 10px 8px;
        font-size: 11px;
    }
    
    .btn-add-product {
        width: 100%;
        justify-content: center;
        padding: 12px 20px;
        font-size: 12px;
    }
    
    .form-container {
        padding: 20px 15px;
    }
    
    .btn-save,
    .btn-cancel {
        padding: 10px 15px;
        font-size: 12px;
    }
}

/* Hamburger Menu Button (untuk mobile) */
.menu-toggle {
    display: none;
    position: fixed;
    top: 20px;
    left: 20px;
    z-index: 2001;
    background: linear-gradient(135deg, #ff69b4 0%, #ff1493 100%);
    border: none;
    width: 45px;
    height: 45px;
    border-radius: 10px;
    color: white;
    font-size: 20px;
    cursor: pointer;
    box-shadow: 0 4px 15px rgba(255, 105, 180, 0.4);
    transition: all 0.3s ease;
}

.menu-toggle:hover {
    transform: scale(1.1);
    box-shadow: 0 6px 20px rgba(255, 105, 180, 0.6);
}

@media (max-width: 1024px) {
    .menu-toggle {
        display: flex;
        align-items: center;
        justify-content: center;
    }
    
    /* Overlay ketika sidebar terbuka */
    .sidebar-overlay {
        display: none;
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: rgba(0, 0, 0, 0.5);
        z-index: 1999;
    }
    
    .sidebar-overlay.active {
        display: block;
    }
}
</style>
</head>
<body>
  
<!-- ========================================
     📂 SIDEBAR (Menu Samping Kiri)
     ======================================== -->
<div class="sidebar">
    
    <!-- === BAGIAN LOGO & JUDUL === -->
    <div class="logo-section">
        <!-- Kotak Logo -->
        <div class="logo-icon">
            <!-- Gambar logo admin -->
            <img src="img/logo admin.jpg" alt="Logo UMKM" 
                 style="width:100%;height:100%;object-fit:cover;border-radius:10px;">
        </div>
        
        <!-- Teks Logo -->
        <div class="logo-text">
            <h2>UMKM PUDDINGKU</h2>
            <p>Admin Dashboard</p>
        </div>
    </div>
    
    <!-- === MENU NAVIGASI === -->
    <ul class="sidebar-menu">
        <!-- Menu Dashboard -->
        <li>
            <a href="admin.php?page=dashboard" 
               class="<?= !isset($_GET['page']) || $_GET['page']=='dashboard' ? 'active' : '' ?>">
               <!-- PHP: Jika tidak ada parameter 'page' atau page=dashboard, maka menu ini aktif (class="active") -->
                <i class="fa-solid fa-house"></i> Dashboard
            </a>
        </li>
        
        <!-- Menu Riwayat Pesanan -->
        <li>
            <a href="admin.php?page=pesanan" 
               class="<?= isset($_GET['page']) && $_GET['page']=='pesanan' ? 'active' : '' ?>">
               <!-- PHP: Jika page=pesanan, menu ini aktif -->
                <i class="fa-solid fa-receipt"></i> Riwayat Pesanan
            </a>
        </li>
        
        <!-- Menu Produk -->
        <li>
            <a href="admin.php?page=produk" 
               class="<?= isset($_GET['page']) && $_GET['page']=='produk' ? 'active' : '' ?>">
               <!-- PHP: Jika page=produk, menu ini aktif -->
                <i class="fa-solid fa-box"></i> Produk
            </a>
        </li>
        
        <!-- Menu Laporan -->
        <li>
            <a href="admin.php?page=laporan" 
               class="<?= isset($_GET['page']) && $_GET['page']=='laporan' ? 'active' : '' ?>">
               <!-- PHP: Jika page=laporan, menu ini aktif -->
                <i class="fa-solid fa-chart-line"></i> Laporan
            </a>
        </li>
        
        <!-- Menu Logout -->
        <li>
            <a href="logout.php">
                <i class="fa-solid fa-right-from-bracket"></i> Logout
            </a>
        </li>
    </ul>
</div>


<!-- ========================================
     📊 KONTEN UTAMA (Area Kanan)
     ======================================== -->
<div class="main-content">
    
    <!-- ========================================
         🏠 HALAMAN DASHBOARD
         ======================================== -->
    <?php if(!isset($_GET['page']) || $_GET['page']=='dashboard'): ?>
    <!-- PHP: Tampilkan jika tidak ada parameter page ATAU page=dashboard -->
    
    <!-- === HEADER DASHBOARD === -->
    <div class="header">
        <h1>PESANAN MASUK</h1>
        
        <!-- Kotak Total Profit di kanan atas -->
        <div class="header-info">
            <p style="font-size:12px;color:#000;">TOTAL TRANSAKSI</p>
            <div class="value">
                Rp<?= number_format($total_profit, 0, ',', '.') ?>
                <!-- PHP: Format angka profit dengan titik sebagai pemisah ribuan -->
            </div>
        </div>
    </div>
    
    
    <!-- === GRID STATUS (4 Kotak Status) === -->
    <div class="status-grid">
        
        <!-- Kotak 1: Pending -->
        <div class="status-item">
            <div class="status-icon">📋</div>
            <div class="status-label">Pending</div>
            <div class="status-count">
                <?= $stats['pending'] ?? 0 ?>
                <!-- PHP: Tampilkan jumlah pending, jika tidak ada data tampilkan 0 -->
            </div>
        </div>
        
        <!-- Kotak 2: Diproses -->
        <div class="status-item">
            <div class="status-icon">🔄</div>
            <div class="status-label">Diproses</div>
            <div class="status-count">
                <?= $stats['process'] ?? 0 ?>
            </div>
        </div>
        
        <!-- Kotak 3: Dibatalkan -->
        <div class="status-item">
            <div class="status-icon" style="background: linear-gradient(135deg, #c62828 0%, #b71c1c 100%); box-shadow: 0 4px 15px rgba(198, 40, 40, 0.4);">
                ❌
            </div>
            <div class="status-label">Dibatalkan</div>
            <div class="status-count">
                <?= $stats['dibatalkan'] ?? 0 ?>
            </div>
        </div>
        
        <!-- Kotak 4: Selesai -->
        <div class="status-item">
            <div class="status-icon">✅</div>
            <div class="status-label">Selesai</div>
            <div class="status-count">
                <?= $stats['selesai'] ?? 0 ?>
            </div>
        </div>
    </div>
    
    
    <!-- === ALERT NOTIFIKASI === -->
    <?php if(($stats['dibatalkan'] ?? 0) > 0): ?>
    <!-- PHP: Tampilkan alert HANYA jika ada pesanan dibatalkan (jumlah > 0) -->
    
    <div class="alert-notification" id="cancelAlert">
        <!-- Icon peringatan -->
        <div class="alert-icon">
            <i class="fa-solid fa-triangle-exclamation"></i>
        </div>
        
        <!-- Konten alert -->
        <div class="alert-content">
            <strong>Perhatian!</strong> Ada <strong><?= $stats['dibatalkan'] ?> pesanan dibatalkan</strong> oleh customer.
            <!-- PHP: Tampilkan jumlah pesanan yang dibatalkan -->
        </div>
        
        <!-- Tombol tutup alert -->
        <button class="alert-close" onclick="closeAlert()">
            <i class="fa-solid fa-xmark"></i>
        </button>
    </div>
    
    <?php endif; ?>
    <!-- PHP: Akhir kondisi if alert -->
    
    
   <!-- ========================================
     📋 TABEL PESANAN TERBARU
     ======================================== -->
<div class="table-section">
    <h2>Pesanan Terbaru</h2>
    
    <div class="table-wrapper">
    <table>
        <!-- === HEADER TABEL === -->
        <thead>
                <tr>
                    <th>No</th>
                    <th>Pelanggan</th>
                    <th>Items</th>
                    <th>Metode</th>
                    <th>Bukti Bayar</th>
                    <th>Total</th>
                </tr>
            </thead>
            
            <!-- === ISI TABEL === -->
            <tbody>
                <?php
                // --- QUERY DATABASE ---
                // Ambil 10 pesanan terbaru dari database, diurutkan dari yang terbaru
                $query = "SELECT * FROM order_dashboard ORDER BY waktu DESC LIMIT 10";
                $result = mysqli_query($koneksi, $query);
                $no = 1; // Variabel untuk nomor urut
                
                // --- LOOP UNTUK SETIAP BARIS DATA ---
                while($row = mysqli_fetch_assoc($result)):
                    
                    // === PARSING DATA ITEMS ===
                    // Items disimpan dalam format JSON, kita parse jadi array
                    $items = json_decode($row['items'], true);
                    $items_text = '';
                    
                    // Jika berhasil di-parse jadi array
                    if(is_array($items)) {
                        $item_list = [];
                        
                        // Loop setiap item
                        foreach($items as $item) {
                            $nama = $item['name'] ?? 'Unknown'; // Nama produk
                            $qty = $item['qty'] ?? 1; // Jumlah/quantity
                            $item_list[] = "$nama x$qty"; // Format: "Nama x Jumlah"
                        }
                        
                        // Gabungkan semua item dengan enter (\n)
                        $items_text = implode("\n", $item_list);
                    } else {
                        // Jika gagal parse, tampilkan apa adanya
                        $items_text = $row['items'];
                    }
                    
                    
                    // === FORMAT METODE PEMBAYARAN ===
                    $payment_method = strtolower($row['payment_method'] ?? 'cash');
                    $payment_label = ''; // Teks yang ditampilkan
                    $payment_color = ''; // Warna teks
                    
                    // Switch case untuk menentukan icon dan warna
                    switch($payment_method) {
                        case 'cash':
                            $payment_label = '💵 CASH';
                            $payment_color = '#4CAF50'; // Hijau
                            break;
                        case 'bank':
                        case 'transfer':
                            $payment_label = '🏦 TRANSFER';
                            $payment_color = '#2196F3'; // Biru
                            break;
                        case 'qris':
                        case 'gopay':
                            $payment_label = '📱 QRIS';
                            $payment_color = '#00AA13'; // Hijau Gopay
                            break;
                        default:
                            $payment_label = ucfirst($payment_method);
                            $payment_color = '#999'; // Abu-abu
                    }
                ?>
                
                <!-- === BARIS TABEL UNTUK SETIAP PESANAN === -->
                <tr>
                    <!-- Kolom 1: Nomor Urut -->
                    <td><?= $no++ ?></td>
                    
                    <!-- Kolom 2: Nama Pelanggan -->
                    <td><?= htmlspecialchars($row['nama']) ?></td>
                    
                    <!-- Kolom 3: Daftar Items -->
                    <td style="white-space: pre-line;">
                        <?= htmlspecialchars($items_text) ?>
                    </td>
                    
                    <!-- Kolom 4: Metode Pembayaran -->
                    <td>
                        <span style="color:<?= $payment_color ?>;font-weight:600;font-size:12px;">
                            <?= $payment_label ?>
                        </span>
                    </td>
                    
                    <!-- Kolom 5: Bukti Bayar -->
                    <td>
                        <?php if($row['gambar'] && file_exists('uploads/' . $row['gambar'])): ?>
                        <!-- Jika ada gambar dan file-nya ada di folder uploads -->
                        
                            <img src="uploads/<?= $row['gambar'] ?>" 
                                 class="payment-proof" 
                                 onclick="viewImage('uploads/<?= $row['gambar'] ?>')">
                            <!-- Saat diklik, panggil function viewImage untuk zoom -->
                            
                        <?php else: ?>
                        <!-- Jika tidak ada gambar -->
                        
                            <span style="color:#999;font-size:11px;">Belum upload</span>
                            
                        <?php endif; ?>
                    </td>
                    
                    <!-- Kolom 6: Total Harga -->
                    <td>Rp<?= number_format($row['total'], 0, ',', '.') ?></td>
                    
                </tr>
                
                <?php endwhile; ?>
            </tbody>
        </table>
        </div><!-- Tutup table-wrapper -->
    </div>
<?php endif; ?>

      <!-- ========================================
     SECTION 1: HALAMAN DAFTAR PESANAN
     Fungsi: Menampilkan semua pesanan pelanggan dalam bentuk tabel
========================================= -->
<?php if(isset($_GET['page']) && $_GET['page']=='pesanan'): ?>
<div class="header"><h1>DAFTAR PESANAN</h1></div>

<div class="table-section">
    <div class="table-wrapper">
    <table>
        <thead>
            <!-- Header tabel untuk kolom-kolom data -->
            <tr>
                <th>No</th>
                <th>Pelanggan</th>
                <th>Telepon</th>
                <th>Items</th>
                <th>Metode</th>
                <th>Bukti Bayar</th>
                <th>Status</th>
                <th>Aksi</th>
                <th>Total</th>
                <th>Waktu</th>
            </tr>
        </thead>
        <tbody>
            <?php
            // ===== QUERY DATABASE =====
            // Mengambil semua data pesanan, diurutkan dari yang terbaru
            $query = "SELECT * FROM order_dashboard ORDER BY waktu DESC";
            $result = mysqli_query($koneksi, $query);
            $no = 1; // Inisialisasi nomor urut
            
            // Loop untuk setiap baris data pesanan
            while($row = mysqli_fetch_assoc($result)):
                
                // ===== PARSING ITEMS (Format JSON ke Text) =====
                // Mengubah data items dari format JSON menjadi text yang mudah dibaca
                $items = json_decode($row['items'], true);
                $items_text = '';
                
                if(is_array($items)) {
                    $item_list = [];
                    foreach($items as $item) {
                        $nama = $item['name'] ?? 'Unknown'; // Nama produk
                        $qty = $item['qty'] ?? 1;           // Jumlah/kuantitas
                        $item_list[] = "$nama x$qty";       // Format: "Nama Produk x2"
                    }
                    $items_text = implode("\n", $item_list); // Gabung dengan enter/newline
                } else {
                    $items_text = $row['items']; // Jika bukan array, tampilkan apa adanya
                }
                
                // ===== FORMAT METODE PEMBAYARAN =====
                // Menentukan icon dan warna untuk setiap metode pembayaran
                $payment_method = $row['payment_method'] ?? 'cash';
                $payment_label = '';
                $payment_color = '';
                
                switch($payment_method) {
                    case 'cash':
                        $payment_label = '💵 CASH';
                        $payment_color = '#4CAF50'; // Hijau
                        break;
                    case 'bank':
                        $payment_label = '🏦 TRANSFER';
                        $payment_color = '#2196F3'; // Biru
                        break;
                    case 'Qris':
                    case 'gopay':
                        $payment_label = '📱 QRIS';
                        $payment_color = '#00AA13'; // Hijau GoPay
                        break;
                    default:
                        $payment_label = $payment_method;
                        $payment_color = '#999'; // Abu-abu
                }
            ?>
            
            <!-- ===== TAMPILAN BARIS TABEL ===== -->
            <tr>
                <!-- Nomor urut -->
                <td><?= $no++ ?></td>
                
                <!-- Nama pelanggan (di-escape untuk keamanan) -->
                <td><?= htmlspecialchars($row['nama']) ?></td>
                
                <!-- Nomor telepon -->
                <td><?= htmlspecialchars($row['telepon']) ?></td>
                
                <!-- Daftar items (dengan newline untuk baris baru) -->
                <td style="white-space: pre-line;"><?= htmlspecialchars($items_text) ?></td>
                
                <!-- Metode pembayaran dengan warna -->
                <td>
                    <span style="color:<?= $payment_color ?>;font-weight:600;font-size:12px;">
                        <?= $payment_label ?>
                    </span>
                </td>
                
                <!-- ===== BUKTI BAYAR (Gambar) ===== -->
                <td>
                    <?php if($row['gambar'] && file_exists('uploads/' . $row['gambar'])): ?>
                        <!-- Jika ada gambar, tampilkan thumbnail yang bisa diklik -->
                        <img src="uploads/<?= $row['gambar'] ?>" 
                             class="payment-proof" 
                             onclick="viewImage('uploads/<?= $row['gambar'] ?>')">
                    <?php else: ?>
                        <!-- Jika belum upload, tampilkan text -->
                        <span style="color:#999;font-size:11px;">Belum upload</span>
                    <?php endif; ?>
                </td>
                
                <!-- Status pesanan (dengan styling badge) -->
                <td>
                    <span class="status-badge status-<?= $row['status'] ?>">
                        <?= $row['status'] ?>
                    </span>
                </td>
                
                <!-- ===== KOLOM AKSI (Update Status) ===== -->
                <td>
                    <form method="POST" style="display:inline;">
                        <!-- Form untuk update status -->
                        
                        <!-- Hidden input berisi ID pesanan -->
                        <input type="hidden" name="update_status" value="<?= $row['id'] ?>">
                        
                        <!-- Dropdown untuk pilih status baru -->
                        <select name="new_status" 
                                onchange="this.form.submit()" 
                                style="padding:8px 12px;font-size:12px;border-radius:8px;border:2px solid #ffe4f0;font-weight:600;color:#ff1493;background:linear-gradient(135deg, #fff 0%, #fffafc 100%);cursor:pointer;transition:all 0.3s ease;" 
                                <?= $row['status']=='DIBATALKAN'?'disabled':'' ?>>
                                <!-- onchange: Submit form otomatis saat ganti status -->
                                <!-- Disabled jika status sudah DIBATALKAN -->
                            
                            <option value="PENDING" <?= $row['status']=='PENDING'?'selected':'' ?>>PENDING</option>
                            <option value="PROCESS" <?= $row['status']=='PROCESS'?'selected':'' ?>>PROCESS</option>
                            <option value="DIKIRIM" <?= $row['status']=='DIKIRIM'?'selected':'' ?>>DIKIRIM</option>
                            <option value="SELESAI" <?= $row['status']=='SELESAI'?'selected':'' ?>>SELESAI</option>
                            <option value="DIBATALKAN" <?= $row['status']=='DIBATALKAN'?'selected':'' ?>>DIBATALKAN</option>
                            <!-- Selected: Pilihan yang sesuai dengan status saat ini -->

                            <!-- Total harga (format: Rp10.000) -->
                <td>Rp<?= number_format($row['total'], 0, ',', '.') ?></td>

                            <!-- Waktu pesanan (format: 31/12/2024 14:30) -->
                <td><?= date('d/m/Y H:i', strtotime($row['waktu'])) ?></td>
                        </select>
                    </form>
                </td>
            </tr>
            
           <?php endwhile; ?>
        </tbody>
    </table>
    </div><!-- Tutup table-wrapper -->
</div>
<?php endif; ?>


<!-- ========================================
     SECTION 2: HALAMAN PRODUK - TAMBAH BARU
     Fungsi: Form untuk menambahkan produk baru
========================================= -->
<?php if(isset($_GET['page']) && $_GET['page']=='produk'): ?>
    <?php if(isset($_GET['action']) && $_GET['action']=='add'): ?>
    <!-- Cek URL: ?page=produk&action=add -->
    
    <div class="header"><h1>TAMBAH PRODUK BARU</h1></div>
    
    <div class="form-container">
        <!-- Form dengan upload file (enctype untuk upload gambar) -->
        <form method="POST" enctype="multipart/form-data">
            
            <!-- ===== INPUT GAMBAR ===== -->
            <div class="form-group">
                <label for="gambar">Gambar Produk</label>
                <input type="file" 
                       name="gambar" 
                       id="gambar" 
                       accept="image/*" 
                       onchange="previewImage(event)"> <!-- Preview sebelum upload -->
                <img id="preview" class="image-preview"> <!-- Tempat preview gambar -->
            </div>
            
            <!-- ===== INPUT NAMA PRODUK ===== -->
            <div class="form-group">
                <label for="nama_produk">Nama Produk *</label>
                <input type="text" name="nama_produk" id="nama_produk" required>
                <!-- required = wajib diisi -->
            </div>
            
            <!-- ===== DROPDOWN KATEGORI ===== -->
            <div class="form-group">
                <label for="kategori">Kategori *</label>
                <select name="kategori" id="kategori" required>
                    <option value="">-- Pilih Kategori --</option>
                    <option value="Brownies">🍫 Brownies</option>
                    <option value="Cake">🎂 Cake</option>
                    <option value="Cookies">🍪 Cookies</option>
                    <option value="Dessert">🍰 Dessert</option>
                    <option value="Pudding">🍮 Pudding</option>
                </select>
            </div>
            
            <!-- ===== INPUT HARGA ===== -->
            <div class="form-group">
                <label for="harga">Harga (Rp) *</label>
                <input type="number" name="harga" id="harga" required min="0">
                <!-- type="number" = hanya angka, min="0" = tidak boleh minus -->
            </div>
            
            <!-- ===== INPUT STOK ===== -->
            <div class="form-group">
                <label for="stock">Stok *</label>
                <input type="number" name="stock" id="stock" required min="0">
            </div>
            
            <!-- ===== TOMBOL AKSI ===== -->
            <div class="form-actions">
                <!-- Button submit untuk menyimpan -->
                <button type="submit" name="add_produk" class="btn-save">
                    Simpan Produk
                </button>
                <!-- Link kembali ke halaman produk -->
                <a href="admin.php?page=produk" class="btn-cancel">Batal</a>
            </div>
        </form>
    </div>
    
    
    <!-- ========================================
         SECTION 3: HALAMAN PRODUK - EDIT
         Fungsi: Form untuk mengedit produk yang sudah ada
    ========================================= -->
    <?php elseif(isset($_GET['action']) && $_GET['action']=='edit' && isset($_GET['id_produk'])): ?>
    <!-- Cek URL: ?page=produk&action=edit&id_produk=123 -->
    
    <?php
    // ===== AMBIL DATA PRODUK DARI DATABASE =====
    $id_produk = intval($_GET['id_produk']); // Konversi ke integer untuk keamanan
    $query = "SELECT * FROM produk WHERE id_produk=$id_produk";
    $result = mysqli_query($koneksi, $query);
    $produk = mysqli_fetch_assoc($result); // Ambil 1 baris data
    ?>
    
    <?php if($produk): ?> <!-- Cek apakah produk ditemukan -->
        <div class="header"><h1>EDIT PRODUK</h1></div>
        <div class="form-container">
            <form method="POST" enctype="multipart/form-data">
                <!-- Hidden input untuk ID (tidak terlihat) -->
                <input type="hidden" name="id_produk" value="<?= $produk['id_produk'] ?>">
                
                <!-- ===== INPUT GAMBAR (dengan preview gambar lama) ===== -->
                <div class="form-group">
                    <label for="gambar">Gambar Produk</label>
                    
                    <?php if($produk['gambar']): ?>
                        <!-- Tampilkan gambar yang sudah ada -->
                        <img src="uploads/<?= $produk['gambar'] ?>" 
                             class="image-preview" 
                             style="display:block;margin-bottom:10px;">
                    <?php endif; ?>
                    
                    <!-- Input untuk upload gambar baru -->
                    <input type="file" name="gambar" id="gambar" accept="image/*" onchange="previewImage(event)">
                    <img id="preview" class="image-preview">
                </div>
                
                <!-- ===== INPUT NAMA (dengan value dari database) ===== -->
                <div class="form-group">
                    <label for="nama_produk">Nama Produk *</label>
                    <input type="text" 
                           name="nama_produk" 
                           id="nama_produk" 
                           value="<?= htmlspecialchars($produk['nama_produk']) ?>" 
                           required>
                </div>
                
                <!-- ===== DROPDOWN KATEGORI (dengan selected) ===== -->
                <div class="form-group">
                    <label for="kategori">Kategori *</label>
                    <select name="kategori" id="kategori" required>
                        <option value="">-- Pilih Kategori --</option>
                        <!-- Cek kategori saat ini dan tandai dengan 'selected' -->
                        <option value="Brownies" <?= $produk['kategori']=='Brownies'?'selected':'' ?>>
                            🍫 Brownies
                        </option>
                        <option value="Cake" <?= $produk['kategori']=='Cake'?'selected':'' ?>>
                            🎂 Cake
                        </option>
                        <option value="Cookies" <?= $produk['kategori']=='Cookies'?'selected':'' ?>>
                            🍪 Cookies
                        </option>
                        <option value="Dessert" <?= $produk['kategori']=='Dessert'?'selected':'' ?>>
                            🍰 Dessert
                        </option>
                        <option value="Pudding" <?= $produk['kategori']=='Pudding'?'selected':'' ?>>
                            🍮 Pudding
                        </option>
                    </select>
                </div>
                
                <!-- ===== INPUT HARGA (dengan value dari database) ===== -->
                <div class="form-group">
                    <label for="harga">Harga (Rp) *</label>
                    <input type="number" 
                           name="harga" 
                           id="harga" 
                           value="<?= $produk['harga'] ?>" 
                           required 
                           min="0">
                </div>
                
                <!-- ===== INPUT STOK (dengan value dari database) ===== -->
                <div class="form-group">
                    <label for="stock">Stok *</label>
                    <input type="number" 
                           name="stock" 
                           id="stock" 
                           value="<?= $produk['stock'] ?>" 
                           required 
                           min="0">
                </div>
                
                <!-- ===== TOMBOL AKSI ===== -->
                <div class="form-actions">
                    <!-- Button untuk update data -->
                    <button type="submit" name="update_produk" class="btn-save">
                        Update Produk
                    </button>
                    <!-- Link kembali -->
                    <a href="admin.php?page=produk" class="btn-cancel">Batal</a>
                </div>
            </form>
        </div>
    <?php endif; ?>
            <?php else: ?>
              <!-- ========================================
     SECTION 4: HALAMAN MANAJEMEN PRODUK (LIST/TABEL)
     Fungsi: Menampilkan semua produk dalam bentuk tabel
========================================= -->
<div class="header">
    <h1>MANAJEMEN PRODUK</h1>
    <a href="admin.php?page=produk&action=add" class="btn-add-product">
        <i class="fa-solid fa-plus"></i> Tambah Produk
    </a>
</div>

<div class="table-section">
    <div class="table-wrapper">
    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>Gambar</th>
                <th>Nama</th>
                <th>Kategori</th> <!-- Kolom baru untuk kategori -->
                <th>Harga</th>
                <th>Stok</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            <?php
            // ===== QUERY DATABASE =====
            // Ambil semua produk, urutkan berdasarkan kategori lalu nama
            $query = "SELECT * FROM produk ORDER BY kategori, nama_produk ASC";
            $result = mysqli_query($koneksi, $query);
            $no = 1; // Nomor urut
            
            // ===== CEK APAKAH ADA DATA =====
            if(mysqli_num_rows($result) == 0):
            ?>
                <!-- Tampilkan pesan jika tidak ada produk -->
                <tr>
                    <td colspan="7" style="text-align:center;color:#999;">
                        Belum ada produk.
                    </td>
                </tr>
            <?php else: ?>
                <!-- Loop untuk setiap produk -->
                <?php while($row = mysqli_fetch_assoc($result)): ?>
                <tr>
                    <!-- Nomor urut -->
                    <td><?= $no++ ?></td>
                    
                    <!-- ===== KOLOM GAMBAR ===== -->
                    <td>
                        <?php if($row['gambar'] && file_exists('uploads/' . $row['gambar'])): ?>
                            <!-- Jika ada gambar, tampilkan -->
                            <img src="uploads/<?= $row['gambar'] ?>" class="product-image">
                        <?php else: ?>
                            <!-- Jika tidak ada gambar, tampilkan icon placeholder -->
                            <div style="width:60px;height:60px;background:#eee;border-radius:6px;
                                        display:flex;align-items:center;justify-content:center;
                                        font-size:24px;">
                                📦
                            </div>
                        <?php endif; ?>
                    </td>
                    
                    <!-- Nama produk -->
                    <td><?= htmlspecialchars($row['nama_produk']) ?></td>
                    
                    <!-- ===== KOLOM KATEGORI (dengan badge styling) ===== -->
                    <td>
                        <span style="background:linear-gradient(135deg, #FFE0F5, #FFD4EC);
                                     padding:4px 12px;
                                     border-radius:20px;
                                     font-size:11px;
                                     font-weight:600;
                                     color:#FF1493;">
                            <?= $row['kategori'] ?: 'Produk' ?>
                            <!-- ?: 'Produk' = jika kosong, tampilkan 'Produk' -->
                        </span>
                    </td>
                    
                    <!-- Harga (format Rupiah) -->
                    <td>Rp<?= number_format($row['harga'], 0, ',', '.') ?></td>
                    
                    <!-- ===== KOLOM STOK (dengan warning jika < 10) ===== -->
                    <td>
                        <strong><?= $row['stock'] ?></strong>
                        <?php if($row['stock'] < 10): ?>
                            <!-- Tampilkan icon warning jika stok kurang dari 10 -->
                            <span style="color:#f44336;font-size:11px;">⚠️</span>
                        <?php endif; ?>
                    </td>
                    
                    <!-- ===== KOLOM AKSI (Edit & Hapus) ===== -->
                    <td>
                        <!-- Tombol Edit -->
                        <a href="admin.php?page=produk&action=edit&id_produk=<?= $row['id_produk'] ?>" 
                           class="btn-edit">
                            Edit
                        </a>
                        
                        <!-- Tombol Hapus dengan konfirmasi -->
                        <a href="admin.php?page=produk&delete_produk=<?= $row['id_produk'] ?>" 
                           class="btn-delete" 
                           onclick="return confirm('Yakin hapus produk ini?')">
                            Hapus
                        </a>
                    </td>
                </tr>
                <?php endwhile; ?>
            <?php endif; ?>
        </tbody>
    </table>
    </div><!-- Tutup table-wrapper -->
</div>
<?php endif; ?>
<?php endif; ?>


<!-- ========================================
     SECTION 5: HALAMAN LAPORAN PENJUALAN
     Fungsi: Menampilkan statistik dan grafik penjualan
========================================= -->
<?php if(isset($_GET['page']) && $_GET['page']=='laporan'): ?>

<div class="header">
    <h1>LAPORAN PENJUALAN</h1>
    
    <!-- ✅ TOMBOL CETAK LAPORAN (BARU) -->
    <button onclick="window.print()" 
            class="btn-add-product" 
            style="background: linear-gradient(135deg, #4CAF50 0%, #45a049 100%);">
        <i class="fa-solid fa-print"></i> Cetak Laporan Grafik
    </button>
</div>

<!-- ===== KARTU STATISTIK UTAMA ===== -->
<div class="report-stats-grid">
    <!-- Card Total Penjualan -->
    <div class="report-card animated-bg">
        <div class="report-card-icon">💰</div>
        <div class="report-card-label">Total Penjualan</div>
        <div class="report-card-value">
            Rp<?= number_format($total_profit, 0, ',', '.') ?>
        </div>
    </div>
    
    <!-- Card Total Pesanan -->
    <div class="report-card animated-bg">
        <div class="report-card-icon">📦</div>
        <div class="report-card-label">Total Pesanan</div>
        <div class="report-card-value">
            <?= $stats['total_pesanan'] ?? 0 ?>
            <!-- ?? 0 = jika null, tampilkan 0 -->
        </div>
    </div>
</div>

<!-- ===== GRID 2 KOLOM: GRAFIK ===== -->
<div style="display: grid; grid-template-columns: 1fr 1fr; gap: 30px; margin-bottom: 30px;">
    
    <!-- ===== GRAFIK PIE/DONUT: Status Pesanan ===== -->
    <div class="report-detail animated-bg">
        <h2>📊 Status Pesanan</h2>
        <div style="padding: 30px 20px;">
            <!-- Canvas untuk Chart.js -->
            <canvas id="statusChart" width="300" height="300"></canvas>
        </div>
    </div>
    
    <!-- ===== GRAFIK LINE: Trend Penjualan ===== -->
    <div class="report-detail animated-bg">
        <h2>📈 Penjualan Perhari</h2>
        <div style="padding: 30px 20px;">
            <!-- Canvas untuk Chart.js -->
            <canvas id="trendChart" width="300" height="300"></canvas>
        </div>
    </div>
</div>

<!-- ===== TABEL DETAIL STATISTIK ===== -->
<div class="report-detail animated-bg">
    <h2>Detail Statistik Pesanan</h2>
    <table class="report-table">
        <tbody>
            <tr>
                <td>✅ Pesanan Selesai</td>
                <td><?= $stats['selesai'] ?? 0 ?> pesanan</td>
            </tr>
            <tr>
                <td>🚗 Pesanan Dikirim</td>
                <td><?= $stats['dikirim'] ?? 0 ?> pesanan</td>
            </tr>
            <tr>
                <td>🔄 Pesanan Diproses</td>
                <td><?= $stats['process'] ?? 0 ?> pesanan</td>
            </tr>
            <tr>
                <td>📋 Pesanan Pending</td>
                <td><?= $stats['pending'] ?? 0 ?> pesanan</td>
            </tr>
            <tr>
                <td>❌ Pesanan Dibatalkan</td>
                <td style="color: #ed0808ff;">
                    <?= $stats['dibatalkan'] ?? 0 ?> pesanan
                </td>
            </tr>
        </tbody>
    </table>
</div>

<!-- ===== TABEL RIWAYAT LAPORAN BULANAN ===== -->
<div class="report-detail animated-bg" style="margin-top: 30px;">
    <h2>📅 Riwayat Laporan Bulanan</h2>
    
    <?php
    // ===== QUERY DATABASE: Ambil Laporan Per Bulan =====
    $query_history = "SELECT 
                        DATE_FORMAT(tgl_transaksi, '%Y-%m') as bulan,
                        DATE_FORMAT(tgl_transaksi, '%M %Y') as bulan_label,
                        COUNT(*) as total_pesanan,
                        SUM(CAST(total_harga AS UNSIGNED)) as total_penjualan
                      FROM transaksi
                      GROUP BY DATE_FORMAT(tgl_transaksi, '%Y-%m')
                      ORDER BY bulan DESC
                      LIMIT 12";
    $result_history = mysqli_query($koneksi, $query_history);
    
    // Debug: Cek ada data atau tidak
    if(!$result_history) {
        echo "<!-- ERROR QUERY: " . mysqli_error($koneksi) . " -->";
    } else {
        echo "<!-- Jumlah data: " . mysqli_num_rows($result_history) . " -->";
    }
    ?>
    
    <?php if($result_history && mysqli_num_rows($result_history) > 0): ?>
        <!-- Jika ada data, tampilkan tabel -->
        <div class="table-wrapper" style="margin-top: 20px;">
            <table>
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Periode</th>
                        <th>Total Pesanan</th>
                        <th>Total Penjualan</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php 
                    $no = 1;
                    while($row = mysqli_fetch_assoc($result_history)): 
                    ?>
                        <tr>
                            <td><?= $no++ ?></td>
                            <td><?= $row['bulan_label'] ?></td>
                            <td><?= $row['total_pesanan'] ?> pesanan</td>
                            <td>Rp<?= number_format($row['total_penjualan'], 0, ',', '.') ?></td>
                            <td>
                                <!-- Tombol Cetak Per Bulan -->
                                <a href="cetak_laporan.php?bulan=<?= $row['bulan'] ?>" 
                                   class="btn-view" 
                                   target="_blank">
                                    <i class="fa-solid fa-print"></i> Cetak
                                </a>
                            </td>
                        </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
        </div>
    <?php else: ?>
        <!-- Jika belum ada data atau query error -->
        <p style="text-align: center; color: #999; padding: 40px;">
            <?php if(!$result_history): ?>
                ⚠ Error: Tidak bisa mengambil data. Cek database Anda.
            <?php else: ?>
                📭 Belum ada riwayat laporan bulanan. Ubah status pesanan menjadi SELESAI untuk mencatat transaksi.
            <?php endif; ?>
        </p>
    <?php endif;?>
</div>

<?php
// ===== AMBIL DATA 7 HARI TERAKHIR DARI DATABASE =====
$query_trend = "SELECT 
                  DATE_FORMAT(waktu, '%d/%m/%y') as tanggal,
                  SUM(CAST(total AS UNSIGNED)) as total_harian
                FROM order_dashboard
                WHERE waktu >= DATE_SUB(NOW(), INTERVAL 7 DAY)
                AND status IN ('SELESAI', 'DIBATALKAN')
                GROUP BY DATE(waktu)
                ORDER BY waktu ASC
                LIMIT 7";

$result_trend = mysqli_query($koneksi, $query_trend);

$labels_trend = [];
$data_trend = [];

// Jika ada data, ambil dari database
if($result_trend && mysqli_num_rows($result_trend) > 0) {
    while($row = mysqli_fetch_assoc($result_trend)) {
        $labels_trend[] = $row['tanggal'];
        $data_trend[] = $row['total_harian'];
    }
} else {
    // Jika belum ada data, tampilkan 7 hari terakhir dengan nilai 0
    for($i = 6; $i >= 0; $i--) {
        $labels_trend[] = date('d/m/y', strtotime("-$i days"));
        $data_trend[] = 0;
    }
}

// Convert ke format JSON untuk JavaScript
$labels_json = json_encode($labels_trend);
$data_json = json_encode($data_trend);
?>

<!-- ========================================
     JAVASCRIPT: CHART.JS - MEMBUAT GRAFIK
========================================= -->
<!-- Load library Chart.js dari CDN -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    // ===== GRAFIK DONUT: Status Pesanan =====
    const ctxPie = document.getElementById('statusChart');
    if(ctxPie) {
        new Chart(ctxPie, {
            type: 'doughnut',
            data: {
                labels: ['Selesai', 'Diproses', 'Pending', 'Dibatalkan'],
                datasets: [{
                    data: [
                        <?= $stats['selesai'] ?? 0 ?>, 
                        <?= $stats['process'] ?? 0 ?>, 
                        <?= $stats['pending'] ?? 0 ?>, 
                        <?= $stats['dibatalkan'] ?? 0 ?>
                    ],
                    backgroundColor: [
                        '#4CAF50',
                        '#FF9800',
                        '#FFC107',
                        '#f44336'
                    ]
                }]
            }
        });
    }
    

    // ===== GRAFIK LINE: Trend Penjualan Per Hari (DINAMIS) =====
const ctxLine = document.getElementById('trendChart');
if(ctxLine) {
    new Chart(ctxLine, {
        type: 'bar',
        data: {
            labels: <?= $labels_json ?>, // DATA DARI DATABASE
            datasets: [{
                label: 'Penjualan',
                data: <?= $data_json ?>, // DATA DARI DATABASE
                borderColor: '#ff69b4',
                backgroundColor: 'rgba(255, 105, 180, 0.1)',
                fill: true,
                tension: 0.4
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: true,
            plugins: {
                legend: {
                    display: true,
                    labels: {
                        color: '#333',
                        font: {
                            size: 12,
                            weight: '600'
                        }
                    }
                },
                tooltip: {
                    callbacks: {
                        label: function(context) {
                            let label = context.dataset.label || '';
                            if (label) {
                                label += ': ';
                            }
                            if (context.parsed.y !== null) {
                                label += 'Rp' + context.parsed.y.toLocaleString('id-ID');
                            }
                            return label;
                        }
                    },
                    backgroundColor: 'rgba(0, 0, 0, 0.8)',
                    titleColor: '#fff',
                    bodyColor: '#fff',
                    borderColor: '#ff69b4',
                    borderWidth: 2,
                    padding: 12,
                    displayColors: true
                }
            },
            scales: {
                y: {
                    beginAtZero: true,
                    ticks: {
                        callback: function(value) {
                            return 'Rp' + value.toLocaleString('id-ID');
                        },
                        color: '#666',
                        font: {
                            size: 11
                        }
                    },
                    grid: {
                        color: 'rgba(255, 105, 180, 0.1)',
                        drawBorder: false
                    }
                },
                x: {
                    ticks: {
                        color: '#666',
                        font: {
                            size: 11,
                            weight: '600'
                        }
                    },
                    grid: {
                        display: false
                    }
                }
            }
        }
    });
}
</script>
<?php endif; ?>
</div>


<!-- ========================================
     MODAL: POPUP UNTUK MELIHAT GAMBAR BESAR
     Fungsi: Menampilkan bukti pembayaran dalam ukuran penuh
========================================= -->
<div id="imageModal" class="modal">
    <div class="modal-content">
        <div class="modal-header">
            <h3>Bukti Pembayaran</h3>
            <!-- Tombol close (X) -->
            <span class="close" onclick="closeImageModal()">&times;</span>
        </div>
        <!-- Tempat gambar akan ditampilkan -->
        <img id="modalImage" class="modal-image">
    </div>
</div>

<!-- TAMBAHKAN DI admin.php SETELAH <div class="main-content"> -->

<?php if(isset($_SESSION['reset_success'])): 
    $reset = $_SESSION['reset_success'];
?>

<!-- Notifikasi Reset Berhasil -->
<div id="resetNotif" style="position: fixed; top: 20px; right: 20px; z-index: 9999; 
     background: linear-gradient(135deg, #e8f5e9 0%, #c8e6c9 100%); 
     border: 2px solid #4CAF50; border-left: 6px solid #2e7d32; border-radius: 12px; 
     padding: 20px 25px; box-shadow: 0 8px 30px rgba(76, 175, 80, 0.3); 
     max-width: 400px; animation: slideInRight 0.5s ease;">
    
    <div style="display: flex; align-items: center; gap: 15px;">
        <div style="width: 50px; height: 50px; background: linear-gradient(135deg, #4CAF50 0%, #2e7d32 100%); 
             border-radius: 12px; display: flex; align-items: center; justify-content: center; 
             font-size: 28px; flex-shrink: 0; animation: bounce 1s infinite;">
            ✨
        </div>
        
        <div style="flex: 1;">
            <h4 style="margin: 0 0 8px 0; color: #2e7d32; font-size: 16px; font-weight: 700;">
                Laporan Tersimpan!
            </h4>
            <p style="margin: 0; color: #558b2f; font-size: 13px; line-height: 1.6;">
                📊 Bulan: <strong><?= $reset['bulan'] ?></strong><br>
                📦 <?= $reset['pesanan'] ?> pesanan<br>
                💰 Rp<?= number_format($reset['penjualan'], 0, ',', '.') ?>
            </p>
        </div>
        
        <button onclick="document.getElementById('resetNotif').remove()" 
                style="background: rgba(46, 125, 50, 0.1); border: 2px solid rgba(46, 125, 50, 0.2); 
                       border-radius: 8px; width: 36px; height: 36px; display: flex; 
                       align-items: center; justify-content: center; cursor: pointer; 
                       font-size: 20px; color: #2e7d32; flex-shrink: 0; transition: all 0.3s ease;">
            ×
        </button>
    </div>
</div>

<style>
@keyframes slideInRight {
    from { opacity: 0; transform: translateX(100%); }
    to { opacity: 1; transform: translateX(0); }
}
@keyframes bounce {
    0%, 100% { transform: scale(1); }
    50% { transform: scale(1.1); }
}
</style>

<script>
// Auto close setelah 8 detik
setTimeout(() => {
    const notif = document.getElementById('resetNotif');
    if(notif) notif.remove();
}, 8000);
</script>

<?php 
    // Hapus session setelah ditampilkan
    unset($_SESSION['reset_success']);
endif; 
?>

<!-- ========================================
     JAVASCRIPT FUNCTIONS
========================================= -->
<script>
    // ===== FUNGSI: Preview Gambar Sebelum Upload =====
    // Dipanggil saat user memilih file di input type="file"
    function previewImage(event) {
        const preview = document.getElementById('preview'); // Element <img> untuk preview
        const file = event.target.files[0]; // File yang dipilih user
        
        if (file) {
            const reader = new FileReader(); // Baca file sebagai data URL
            reader.onload = function(e) {
                preview.src = e.target.result; // Set src img dengan data URL
                preview.style.display = 'block'; // Tampilkan img
            }
            reader.readAsDataURL(file); // Mulai membaca file
        }
    }

    // ===== FUNGSI: Tampilkan Modal dengan Gambar =====
    // Dipanggil saat user klik thumbnail bukti bayar
    function viewImage(src) {
        document.getElementById('modalImage').src = src; // Set gambar di modal
        document.getElementById('imageModal').style.display = 'block'; // Tampilkan modal
    }

    // ===== FUNGSI: Tutup Modal =====
    function closeImageModal() {
        document.getElementById('imageModal').style.display = 'none'; // Sembunyikan modal
    }

    // ===== FUNGSI: Tutup Alert Notifikasi =====
    // Digunakan untuk menutup notifikasi pesanan dibatalkan
    function closeAlert() {
        const alert = document.getElementById('cancelAlert'); // Element alert
        if(alert) {
            // Animasi fade out & slide ke kanan
            alert.style.transition = 'all 0.4s ease';
            alert.style.opacity = '0';
            alert.style.transform = 'translateX(100%)';
            
            // Setelah animasi selesai, sembunyikan element
            setTimeout(() => {
                alert.style.display = 'none';
            }, 400);
            
            // ===== SIMPAN KE LOCALSTORAGE =====
            // Agar alert tidak muncul lagi setelah ditutup
            localStorage.setItem('cancelAlertClosed_<?= $stats["dibatalkan"] ?>', 'true');
        }
    }

    // ===== EVENT: Cek LocalStorage Saat Halaman Load =====
    // Jika alert sudah pernah ditutup, langsung sembunyikan
    window.addEventListener('DOMContentLoaded', function() {
        const alert = document.getElementById('cancelAlert');
        if(alert) {
            // Key unik berdasarkan jumlah pesanan dibatalkan
            const alertKey = 'cancelAlertClosed_<?= $stats["dibatalkan"] ?>';
            
            // Cek apakah sudah pernah ditutup
            if(localStorage.getItem(alertKey) === 'true') {
                alert.style.display = 'none'; // Langsung sembunyikan
            }
        }
    });
</script>
<script>
// ===== TOGGLE SIDEBAR DI MOBILE =====
document.addEventListener('DOMContentLoaded', function() {
    // Buat button hamburger
    const menuBtn = document.createElement('button');
    menuBtn.className = 'menu-toggle';
    menuBtn.innerHTML = '<i class="fa-solid fa-bars"></i>';
    document.body.appendChild(menuBtn);
    
    // Buat overlay
    const overlay = document.createElement('div');
    overlay.className = 'sidebar-overlay';
    document.body.appendChild(overlay);
    
    const sidebar = document.querySelector('.sidebar');
    
    // Klik button = toggle sidebar
    menuBtn.addEventListener('click', function() {
        sidebar.classList.toggle('active');
        overlay.classList.toggle('active');
        
        // Ubah icon
        const icon = menuBtn.querySelector('i');
        if(sidebar.classList.contains('active')) {
            icon.className = 'fa-solid fa-times';
        } else {
            icon.className = 'fa-solid fa-bars';
        }
    });
    
    // Klik overlay = tutup sidebar
    overlay.addEventListener('click', function() {
        sidebar.classList.remove('active');
        overlay.classList.remove('active');
        menuBtn.querySelector('i').className = 'fa-solid fa-bars';
    });
    
    // Klik menu = tutup sidebar (untuk mobile)
    if(window.innerWidth <= 1024) {
        document.querySelectorAll('.sidebar-menu a').forEach(link => {
            link.addEventListener('click', function() {
                sidebar.classList.remove('active');
                overlay.classList.remove('active');
                menuBtn.querySelector('i').className = 'fa-solid fa-bars';
            });
        });
    }
});
</script>
</body>
</html>