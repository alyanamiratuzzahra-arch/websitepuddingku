<?php
// ========================================
// AUTO RESET BULANAN (SEDERHANA)
// File: auto_reset_simple.php
// ========================================

// Jangan tampilkan error ke user
error_reporting(0);

// Cek apakah sudah ada koneksi
if(!isset($koneksi)) {
    include 'koneksi.php';
}

// ========================================
// FUNGSI 1: CEK APAKAH PERLU RESET
// ========================================
function needsReset($koneksi) {
    // Cek apakah ini tanggal 1 dan belum reset bulan ini
    if(date('d') != '01') {
        return false; // Bukan tanggal 1, skip
    }
    
    $bulan_ini = date('Y-m');
    
    // Cek di tabel laporan_bulanan apakah sudah ada data bulan ini
    $query = "SELECT * FROM laporan_bulanan WHERE bulan = '$bulan_ini' LIMIT 1";
    $result = mysqli_query($koneksi, $query);
    
    // Jika belum ada, berarti perlu reset
    return mysqli_num_rows($result) == 0;
}

// ========================================
// FUNGSI 2: SIMPAN LAPORAN BULAN LALU
// ========================================
function saveLaporanBulanLalu($koneksi) {
    // Ambil bulan lalu (bulan sebelum sekarang)
    $bulan_lalu = date('Y-m', strtotime('-1 month'));
    $bulan_label = date('F Y', strtotime($bulan_lalu . '-01'));
    
    // Hitung total penjualan & pesanan dari order_dashboard
    $query = "SELECT 
                COUNT(*) as total_pesanan,
                SUM(CAST(total AS UNSIGNED)) as total_penjualan
              FROM order_dashboard
              WHERE DATE_FORMAT(waktu, '%Y-%m') = '$bulan_lalu'
              AND status IN ('SELESAI', 'DIBATALKAN')";
    
    $result = mysqli_query($koneksi, $query);
    $data = mysqli_fetch_assoc($result);
    
    $total_pesanan = $data['total_pesanan'] ?? 0;
    $total_penjualan = $data['total_penjualan'] ?? 0;
    
    // Simpan ke tabel laporan_bulanan
    if($total_pesanan > 0) {
        $insert = "INSERT INTO laporan_bulanan (bulan, bulan_label, total_pesanan, total_penjualan, created_at) 
                   VALUES ('$bulan_lalu', '$bulan_label', $total_pesanan, $total_penjualan, NOW())
                   ON DUPLICATE KEY UPDATE 
                   total_pesanan = $total_pesanan,
                   total_penjualan = $total_penjualan";
        
        mysqli_query($koneksi, $insert);
        
        return [
            'success' => true,
            'bulan' => $bulan_label,
            'pesanan' => $total_pesanan,
            'penjualan' => $total_penjualan
        ];
    }
    
    return ['success' => false, 'message' => 'Tidak ada data bulan lalu'];
}

// ========================================
// FUNGSI 3: BUAT TABEL JIKA BELUM ADA
// ========================================
function createLaporanTable($koneksi) {
    $query = "CREATE TABLE IF NOT EXISTS laporan_bulanan (
        id INT AUTO_INCREMENT PRIMARY KEY,
        bulan VARCHAR(7) NOT NULL,
        bulan_label VARCHAR(20) NOT NULL,
        total_pesanan INT DEFAULT 0,
        total_penjualan BIGINT DEFAULT 0,
        created_at DATETIME NOT NULL,
        UNIQUE KEY unique_bulan (bulan)
    )";
    
    mysqli_query($koneksi, $query);
}

// ========================================
// EKSEKUSI UTAMA
// ========================================

// 1. Pastikan tabel laporan_bulanan ada
createLaporanTable($koneksi);

// 2. Cek apakah perlu reset
if(needsReset($koneksi)) {
    // Simpan laporan bulan lalu
    $result = saveLaporanBulanLalu($koneksi);
    
    // Simpan info ke session untuk notifikasi
    if($result['success']) {
        $_SESSION['reset_success'] = [
            'bulan' => $result['bulan'],
            'pesanan' => $result['pesanan'],
            'penjualan' => $result['penjualan'],
            'time' => date('Y-m-d H:i:s')
        ];
    }
}
?>