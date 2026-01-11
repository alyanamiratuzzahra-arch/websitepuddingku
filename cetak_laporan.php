<?php
// ========================================
// CETAK LAPORAN BULANAN
// File: cetak_laporan.php
// ========================================

session_start();

// Cek login
if (!isset($_SESSION['id_karyawan'])) {
    header("Location: login.php");
    exit;
}

include 'koneksi.php';

// Ambil parameter bulan dari URL (format: 2025-12)
$bulan = isset($_GET['bulan']) ? $_GET['bulan'] : date('Y-m');

// Query data transaksi bulan tersebut - DIPERBAIKI
$query = "SELECT 
            t.*,
            c.nama_customer,
            c.no_telp
          FROM transaksi t
          LEFT JOIN customer c ON t.id_customer = c.id_customer
          WHERE DATE_FORMAT(t.tgl_transaksi, '%Y-%m') = '$bulan'
          ORDER BY t.tgl_transaksi DESC";

$result = mysqli_query($koneksi, $query);

// Cek apakah query berhasil
if (!$result) {
    die("Query Error: " . mysqli_error($koneksi));
}

// Hitung total
$query_total = "SELECT 
                  COUNT(*) as total_pesanan,
                  SUM(CAST(total_harga AS UNSIGNED)) as total_penjualan
                FROM transaksi
                WHERE DATE_FORMAT(tgl_transaksi, '%Y-%m') = '$bulan'";
$result_total = mysqli_query($koneksi, $query_total);
$total = mysqli_fetch_assoc($result_total);

// Format bulan untuk tampilan
$bulan_nama = date('F Y', strtotime($bulan . '-01'));
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laporan Penjualan - <?= $bulan_nama ?></title>
    <style>
        /* Reset */
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        
        body {
            font-family: Arial, sans-serif;
            padding: 20px;
            background: white;
        }
        
        /* Header Laporan */
        .header {
            text-align: center;
            margin-bottom: 30px;
            border-bottom: 3px solid #FF69B4;
            padding-bottom: 20px;
        }
        
        .header h1 {
            color: #FF1493;
            font-size: 28px;
            margin-bottom: 5px;
        }
        
        .header h2 {
            color: #666;
            font-size: 18px;
            font-weight: normal;
        }
        
        /* Info Summary */
        .summary {
            display: flex;
            justify-content: space-around;
            margin: 30px 0;
            padding: 20px;
            background: linear-gradient(135deg, #FFE4F0, #FFD4EC);
            border-radius: 10px;
        }
        
        .summary-item {
            text-align: center;
        }
        
        .summary-label {
            font-size: 14px;
            color: #666;
            margin-bottom: 10px;
        }
        
        .summary-value {
            font-size: 24px;
            font-weight: bold;
            color: #FF1493;
        }
        
        /* Tabel */
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }
        
        thead {
            background: linear-gradient(135deg, #FF69B4, #FF1493);
            color: white;
        }
        
        th, td {
            padding: 12px;
            text-align: left;
            border: 1px solid #FFE4F0;
        }
        
        th {
            font-weight: bold;
            font-size: 12px;
            text-transform: uppercase;
        }
        
        tbody tr:nth-child(even) {
            background: #FFFAFC;
        }
        
        tbody tr:hover {
            background: #FFE4F0;
        }
        
        td {
            font-size: 13px;
        }
        
        /* Footer */
        .footer {
            margin-top: 50px;
            padding-top: 20px;
            border-top: 2px solid #FFE4F0;
            text-align: right;
        }
        
        .signature {
            margin-top: 80px;
            display: inline-block;
            text-align: center;
        }
        
        .signature-line {
            border-top: 2px solid #333;
            width: 200px;
            margin-top: 10px;
            padding-top: 5px;
        }
        
        /* Tombol Print */
        .btn-print {
            position: fixed;
            top: 20px;
            right: 20px;
            background: linear-gradient(135deg, #4CAF50, #45a049);
            color: white;
            padding: 12px 24px;
            border: none;
            border-radius: 8px;
            cursor: pointer;
            font-weight: bold;
            box-shadow: 0 4px 15px rgba(76, 175, 80, 0.3);
        }
        
        .btn-print:hover {
            background: linear-gradient(135deg, #45a049, #3d8b40);
        }
        
        /* Print Styles */
        @media print {
            .btn-print {
                display: none;
            }
            
            body {
                padding: 0;
            }
            
            .header, .summary, table {
                page-break-inside: avoid;
            }
        }
    </style>
</head>
<body>

<!-- Tombol Print -->
<button class="btn-print" onclick="window.print()">
    🖨️ Print Laporan
</button>

<!-- Header -->
<div class="header">
    <h1>UMKM PUDDINGKU</h1>
    <h2>Laporan Penjualan Bulan <?= $bulan_nama ?></h2>
</div>

<!-- Summary -->
<div class="summary">
    <div class="summary-item">
        <div class="summary-label">Total Pesanan</div>
        <div class="summary-value"><?= $total['total_pesanan'] ?? 0 ?></div>
    </div>
    <div class="summary-item">
        <div class="summary-label">Total Penjualan</div>
        <div class="summary-value">Rp<?= number_format($total['total_penjualan'] ?? 0, 0, ',', '.') ?></div>
    </div>
</div>

<!-- Tabel Detail Transaksi -->
<table>
    <thead>
        <tr>
            <th>No</th>
            <th>Tanggal</th>
            <th>Nama Customer</th>
            <th>No. Telepon</th>
            <th>Total</th>
            <th>Metode</th>
        </tr>
    </thead>
    <tbody>
        <?php 
        if(mysqli_num_rows($result) > 0):
            $no = 1;
            while($row = mysqli_fetch_assoc($result)): 
                // Ambil nama dari tabel transaksi atau customer
                $nama_tampil = !empty($row['nama']) ? $row['nama'] : (!empty($row['nama_customer']) ? $row['nama_customer'] : '-');
                $telp_tampil = !empty($row['no_telp']) ? $row['no_telp'] : '-';
        ?>
            <tr>
                <td><?= $no++ ?></td>
                <td><?= date('d/m/Y H:i', strtotime($row['tgl_transaksi'])) ?></td>
                <td><?= htmlspecialchars($nama_tampil) ?></td>
                <td><?= htmlspecialchars($telp_tampil) ?></td>
                <td>Rp<?= number_format($row['total_harga'], 0, ',', '.') ?></td>
                <td><?= htmlspecialchars($row['metode_transaksi']) ?></td>
            </tr>
        <?php 
            endwhile;
        else:
        ?>
            <tr>
                <td colspan="6" style="text-align: center; color: #999;">
                    Tidak ada transaksi pada bulan ini
                </td>
            </tr>
        <?php endif; ?>
    </tbody>
</table>

<!-- Footer & Tanda Tangan -->
<div class="footer">
    <p>Dicetak pada: <?= date('d F Y, H:i') ?> WIB</p>
    
    <div class="signature">
        <p>Mengetahui,</p>
        <div class="signature-line">
            ( _________________ )
        </div>
        <p style="margin-top: 5px;">Pemilik UMKM</p>
    </div>
</div>

</body>
</html>