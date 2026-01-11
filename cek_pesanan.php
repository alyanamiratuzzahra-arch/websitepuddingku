<?php include 'koneksi.php'; ?>
<!doctype html>
<html lang="id">
<head>
  <meta charset="utf-8"/>
  <meta name="viewport" content="width=device-width, initial-scale=1"/>
  <title>Cek Pesanan - UMKM PUDDINGKU</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600;700&display=swap" rel="stylesheet">
  <style>
    :root {
      --pudding-cream: #FFF5E6;
      --pudding-brown: #8B5E3C;
      --pudding-brown-dark: #6b462c;
    }
    
    /* Background lebih menarik */
    body {
      background: linear-gradient(135deg, #FFB6D9 0%, #FFC8E3 25%, #FFD4EC 50%, #FFE0F5 75%, #FFF0FA 100%);
      font-family: 'Poppins', sans-serif;
      min-height: 100vh;
      padding: 30px 0;
      position: relative;
    }
    
    body::before {
      content: '';
      position: fixed;
      top: 0;
      left: 0;
      width: 100%;
      height: 100%;
      background: radial-gradient(circle at 20% 50%, rgba(255, 182, 217, 0.3) 0%, transparent 50%),
                  radial-gradient(circle at 80% 80%, rgba(255, 200, 227, 0.3) 0%, transparent 50%);
      pointer-events: none;
      z-index: 0;
    }
    
    .container {
      max-width: 900px;
      position: relative;
      z-index: 2;
    }
    
    /* Card Search lebih cantik */
    .card {
      border: none;
      border-radius: 20px;
      box-shadow: 0 8px 30px rgba(255, 105, 180, 0.2);
      margin-bottom: 20px;
      background: rgba(255, 255, 255, 0.95) !important;
      backdrop-filter: blur(15px);
      border: 2px solid rgba(255, 182, 217, 0.3) !important;
    }
    
    .card-header {
      background: linear-gradient(135deg, #ff69b4 0%, #ff1493 100%);
      color: white;
      border-radius: 18px 18px 0 0 !important;
      padding: 25px;
      font-weight: 700;
      font-size: 22px;
      position: relative;
      overflow: hidden;
    }
    
    .card-header::before {
      content: '🔍';
      position: absolute;
      font-size: 100px;
      right: -10px;
      top: -20px;
      opacity: 0.2;
    }
    
    /* Tab Pencarian */
    .search-tabs {
      display: flex;
      gap: 10px;
      margin-bottom: 20px;
    }

    .search-tab {
      flex: 1;
      padding: 12px;
      border: 2px solid #FFD4EC;
      background: rgba(255, 245, 250, 0.5);
      border-radius: 12px;
      cursor: pointer;
      transition: all 0.3s ease;
      text-align: center;
      font-weight: 600;
      color: #FF69B4;
    }

    .search-tab:hover {
      background: rgba(255, 225, 240, 0.8);
      border-color: #FFB6D9;
      transform: translateY(-2px);
    }

    .search-tab.active {
      background: linear-gradient(135deg, #FF69B4, #FF1493);
      color: white;
      border-color: #FF1493;
      box-shadow: 0 4px 15px rgba(255, 20, 147, 0.3);
    }
    
    /* Status badge lebih cantik dengan gradient */
    .status-badge {
      padding: 10px 20px;
      border-radius: 12px;
      font-size: 13px;
      font-weight: 700;
      display: inline-flex;
      align-items: center;
      gap: 6px;
    }
    
    .status-PENDING { 
      background: linear-gradient(135deg, #FFF3CD, #FFE69C) !important; 
      color: #856404;
      border: 2px solid #FFDB6E !important;
      box-shadow: 0 3px 10px rgba(255, 219, 110, 0.3);
    }
    
    .status-PROCESS { 
      background: linear-gradient(135deg, #CCE5FF, #99CCFF) !important; 
      color: #004085;
      border: 2px solid #66B3FF !important;
      box-shadow: 0 3px 10px rgba(102, 179, 255, 0.3);
    }
    
    .status-DIKIRIM { 
      background: linear-gradient(135deg, #D4EDDA, #A8D5BA) !important; 
      color: #155724;
      border: 2px solid #7BC78E !important;
      box-shadow: 0 3px 10px rgba(123, 199, 142, 0.3);
    }
    
    .status-SELESAI { 
      background: linear-gradient(135deg, #D1ECF1, #A0D9E5) !important; 
      color: #0C5460;
      border: 2px solid #73C2D1 !important;
      box-shadow: 0 3px 10px rgba(115, 194, 209, 0.3);
    }
    
    .status-DIBATALKAN { 
      background: linear-gradient(135deg, #F8D7DA, #F5B9BE) !important; 
      color: #721C24;
      border: 2px solid #F19BA3 !important;
      box-shadow: 0 3px 10px rgba(241, 155, 163, 0.3);
    }
    
    .btn-cancel-order {
      background: linear-gradient(135deg, #dc3545 0%, #c82333 100%);
      border: none;
      color: white;
      padding: 10px 20px;
      border-radius: 10px;
      font-weight: 600;
      transition: all 0.3s;
      box-shadow: 0 4px 15px rgba(220, 53, 69, 0.3);
    }
    
    .btn-cancel-order:hover {
      transform: translateY(-2px);
      box-shadow: 0 6px 20px rgba(220, 53, 69, 0.5);
      color: white;
      background: linear-gradient(135deg, #c82333, #bd2130);
    }
    
    .btn-search {
      background: linear-gradient(135deg, #ff69b4 0%, #ff1493 100%);
      border: none;
      padding: 12px 30px;
      border-radius: 10px;
      font-weight: 600;
      color: white;
      transition: all 0.3s ease;
      box-shadow: 0 4px 15px rgba(255, 20, 147, 0.3);
    }
    
    .btn-search:hover {
      background: linear-gradient(135deg, #ff1493, #c71585);
      transform: translateY(-2px);
      box-shadow: 0 6px 20px rgba(255, 20, 147, 0.5);
    }
    
    /* Order card lebih menarik */
    .order-item {
      background: rgba(255, 255, 255, 0.95) !important;
      backdrop-filter: blur(10px);
      padding: 20px;
      border-radius: 15px;
      margin-bottom: 20px;
      border: 2px solid rgba(255, 182, 217, 0.3) !important;
      box-shadow: 0 6px 20px rgba(255, 105, 180, 0.15);
      transition: all 0.3s ease;
    }
    
    .order-item:hover {
      transform: translateY(-5px);
      box-shadow: 0 10px 30px rgba(255, 105, 180, 0.25);
      border-color: #FF99CC !important;
    }
    
    .back-btn {
      display: inline-flex;
      align-items: center;
      gap: 8px;
      background: rgba(255, 255, 255, 0.9);
      backdrop-filter: blur(10px);
      color: #FF1493;
      text-decoration: none;
      font-weight: 600;
      padding: 12px 24px;
      border-radius: 12px;
      margin-bottom: 25px;
      border: 2px solid rgba(255, 105, 180, 0.3);
      transition: all 0.3s ease;
      box-shadow: 0 4px 15px rgba(255, 105, 180, 0.2);
    }
    
    .back-btn:hover {
      background: linear-gradient(135deg, #FF69B4, #FF1493);
      color: white;
      transform: translateY(-2px);
      box-shadow: 0 6px 20px rgba(255, 105, 180, 0.4);
    }
    
    h5 {
      color: #FF1493;
      font-weight: 700;
      display: flex;
      align-items: center;
      gap: 10px;
    }
    
    .alert {
      border-radius: 15px;
      border: 2px solid;
    }
    
    /* Responsive */
    @media (max-width: 768px) {
      .search-tabs {
        flex-direction: column;
      }
    }
  </style>
</head>
<body>

<div class="container">
  
  <a href="pemesanan.php" class="back-btn">
    <i class="bi bi-arrow-left"></i> Kembali ke Pemesanan
  </a>

  <div class="card">
    <div class="card-header">
      <i class="bi bi-search"></i> Cek Pesanan Saya
    </div>
    <div class="card-body">
      <p class="text-muted">Cari pesanan Anda menggunakan nomor order atau nomor telepon</p>
      
      <!-- Tab Pilihan -->
      <div class="search-tabs">
        <div class="search-tab active" onclick="switchTab('phone')">
          <i class="bi bi-telephone-fill"></i> Nomor Telepon
        </div>
        <div class="search-tab" onclick="switchTab('id')">
          <i class="bi bi-person-fill"></i> Nomor order
        </div>
      </div>
      
      <form method="GET" action="">
        <input type="hidden" name="search_type" id="searchType" value="phone">
        
        <div class="input-group mb-3">
          <input type="text" name="search" id="searchInput" class="form-control" 
                 placeholder="Masukkan nomor telepon..." 
                 value="<?= htmlspecialchars($_GET['search'] ?? '') ?>" required>
          <button class="btn btn-search" type="submit">
            <i class="bi bi-search"></i> Cari Pesanan
          </button>
        </div>
      </form>
    </div>
  </div>

  <?php if(isset($_GET['search'])): 
    $search = mysqli_real_escape_string($koneksi, $_GET['search']);
    $search_type = $_GET['search_type'] ?? 'phone';
    
    // Query berdasarkan tipe pencarian
    if($search_type === 'phone') {
      $query = "SELECT * FROM order_dashboard WHERE telepon LIKE '%$search%' ORDER BY waktu DESC";
    } else {
      $query = "SELECT * FROM order_dashboard WHERE id LIKE '%$search%' ORDER BY waktu DESC";
    }
    
    $result = mysqli_query($koneksi, $query);
    
    if(mysqli_num_rows($result) > 0):
  ?>
    <h5 class="mb-3">
      <i class="bi bi-box-seam"></i> Ditemukan <?= mysqli_num_rows($result) ?> pesanan
    </h5>
    
    <?php while($order = mysqli_fetch_assoc($result)): 
  // Parse items - support JSON dan TEXT format
// Parse items - support JSON dan TEXT format
  $items_raw = $order['items'];
  $items = [];
  $total_hitung = $order['total'];
  
  // Cek apakah JSON atau TEXT
  if(substr(trim($items_raw), 0, 1) === '[') {
    // Format JSON (data lama)
    $items = json_decode($items_raw, true);
    if(!is_array($items)) {
      $items = [];
    }
  } else {
    // Format TEXT (data baru) - convert ke array
    $lines = explode("\n", trim($items_raw));
    $total_qty = 0;
    
    // Hitung total qty dulu
    foreach($lines as $line) {
      if(empty(trim($line))) continue;
      preg_match('/x(\d+)$/i', trim($line), $qty_match);
      if(count($qty_match) === 2) {
        $total_qty += intval($qty_match[1]);
      }
    }
    
    foreach($lines as $line) {
      if(empty(trim($line))) continue;
      
      // Parse format "Nama Produk x2"
      preg_match('/^(.+?)\s*x(\d+)$/i', trim($line), $matches);
      if(count($matches) === 3) {
        $product_name = trim($matches[1]);
        $qty = intval($matches[2]);
        
        // Coba ambil harga dari database dulu
        $escaped_name = mysqli_real_escape_string($koneksi, $product_name);
        $price = 0;
        $found = false;
        
        // Coba exact match dulu
        $price_query = mysqli_query($koneksi, "SELECT harga FROM produk WHERE nama_produk = '$escaped_name' LIMIT 1");
        if($price_query && mysqli_num_rows($price_query) > 0) {
          $price_row = mysqli_fetch_assoc($price_query);
          $price = $price_row['harga'];
          $found = true;
        }
        
        // Kalau belum ketemu, coba LIKE
        if(!$found) {
          $price_query = mysqli_query($koneksi, "SELECT harga FROM produk WHERE nama_produk LIKE '%$escaped_name%' LIMIT 1");
          if($price_query && mysqli_num_rows($price_query) > 0) {
            $price_row = mysqli_fetch_assoc($price_query);
            $price = $price_row['harga'];
            $found = true;
          }
        }
        
        // Kalau masih belum ketemu, coba cari dengan kata pertama
        if(!$found) {
          $words = explode(' ', $product_name);
          if(count($words) > 0) {
            $first_word = mysqli_real_escape_string($koneksi, $words[0]);
            $price_query = mysqli_query($koneksi, "SELECT harga FROM produk WHERE nama_produk LIKE '$first_word%' LIMIT 1");
            if($price_query && mysqli_num_rows($price_query) > 0) {
              $price_row = mysqli_fetch_assoc($price_query);
              $price = $price_row['harga'];
              $found = true;
            }
          }
        }
        
        // FALLBACK: Kalau tetap tidak ketemu, hitung dari total
        if(!$found && $total_qty > 0) {
          $price = round($total_hitung / $total_qty);
        }
        
        $items[] = [
          'name' => $product_name,
          'qty' => $qty,
          'price' => $price
        ];
      }
    }
  }
      
      // Format metode pembayaran
      $payment_method = $order['payment_method'] ?? 'cash';
      $payment_label = '';
      switch($payment_method) {
          case 'cash': $payment_label = '💵 Cash'; break;
          case 'bank': $payment_label = '🏦 Transfer Bank'; break;
          case 'qris': $payment_label = '📱 QRIS'; break;
          default: $payment_label = $payment_method;
      }
    ?>
    
    <div class="order-item">
      <!-- Header Order dengan ID dan Status -->
      <div class="d-flex justify-content-between align-items-center mb-3 pb-3" style="border-bottom: 2px solid #FFE4F0;">
        <h6 class="fw-bold mb-0" style="color: #FF1493; font-size: 18px;">
          <i class="bi bi-receipt"></i> Order #<?= $order['id'] ?>
        </h6>
        <span class="status-badge status-<?= $order['status'] ?>">
          <?= $order['status'] ?>
        </span>
      </div>
      
      <div class="row">
        <div class="col-md-12 mb-3">
          <!-- Info Pelanggan -->
          <div class="p-3 mb-3" style="background: linear-gradient(135deg, rgba(255, 240, 250, 0.5), rgba(255, 255, 255, 0.5)); border-radius: 12px; border: 1px solid #FFE4F0;">
            <div class="row">
              <div class="col-md-4 mb-2">
                <small class="text-muted"><i class="bi bi-person-fill" style="color: #FF69B4;"></i> Nama</small><br>
                <strong style="color: #6B3B4C;"><?= htmlspecialchars($order['nama']) ?></strong>
              </div>
              <div class="col-md-4 mb-2">
                <small class="text-muted"><i class="bi bi-clock-fill" style="color: #FF69B4;"></i> Waktu</small><br>
                <strong style="color: #6B3B4C;"><?= date('d M Y, H:i', strtotime($order['waktu'])) ?></strong>
              </div>
              <div class="col-md-4 mb-2">
                <small class="text-muted"><i class="bi bi-wallet2" style="color: #FF69B4;"></i> Metode</small><br>
                <strong style="color: #6B3B4C;"><?= $payment_label ?></strong>
              </div>
            </div>
          </div>
          
          <!-- Daftar Produk yang Dipesan -->
          <div class="p-3 mb-3" style="background: white; border-radius: 12px; border: 2px solid #FFE4F0;">
            <div class="d-flex align-items-center mb-3">
              <i class="bi bi-bag-check-fill" style="color: #FF69B4; font-size: 20px; margin-right: 8px;"></i>
              <strong style="color: #FF1493; font-size: 16px;">Daftar Pesanan</strong>
            </div>
            
            <?php if(is_array($items) && count($items) > 0): ?>
              <?php foreach($items as $item): ?>
                <div class="d-flex justify-content-between align-items-center p-2 mb-2" style="background: linear-gradient(135deg, rgba(255, 240, 250, 0.3), rgba(255, 255, 255, 0.3)); border-radius: 8px; border: 1px solid #FFE4F0;">
                  <div>
                    <strong style="color: #6B3B4C; font-size: 15px;"><?= htmlspecialchars($item['name'] ?? 'Produk') ?></strong>
                    <br>
                    <small style="color: #999;">
                      Rp<?= number_format($item['price'] ?? 0, 0, ',', '.') ?> 
                      <span style="color: #FF69B4; font-weight: 600;">× <?= $item['qty'] ?? 1 ?></span>
                    </small>
                  </div>
                  <div class="text-end">
                    <strong style="color: #FF1493; font-size: 16px;">
                      Rp<?= number_format(($item['price'] ?? 0) * ($item['qty'] ?? 1), 0, ',', '.') ?>
                    </strong>
                  </div>
                </div>
              <?php endforeach; ?>
            <?php else: ?>
              <div class="alert alert-info mb-0" style="border-radius: 10px;">
                <small><i class="bi bi-info-circle"></i> Data produk tidak tersedia</small>
              </div>
            <?php endif; ?>
          </div>
          
          <!-- Total Pembayaran -->
          <div class="p-4 text-center" style="background: linear-gradient(135deg, #FF69B4, #FF1493); border-radius: 12px; box-shadow: 0 4px 15px rgba(255, 20, 147, 0.3);">
            <div style="color: white; opacity: 0.9; font-size: 14px; margin-bottom: 5px;">
              <i class="bi bi-cash-stack"></i> Total Pembayaran
            </div>
            <strong style="color: white; font-size: 24px; font-weight: 700;">
              Rp<?= number_format($order['total'], 0, ',', '.') ?>
            </strong>
          </div>
          
          <!-- Tombol Batalkan (jika PENDING) -->
          <?php if($order['status'] == 'PENDING'): ?>
            <button class="btn btn-cancel-order mt-3 w-100" 
                    onclick="cancelOrder(<?= $order['id'] ?>, '<?= addslashes($order['nama']) ?>')">
              <i class="bi bi-x-circle"></i> Batalkan Pesanan
            </button>
          <?php elseif($order['status'] == 'DIBATALKAN'): ?>
            <div class="alert alert-danger mt-3 mb-0" role="alert" style="border-radius: 12px;">
              <i class="bi bi-x-circle-fill"></i> <strong>Pesanan ini telah dibatalkan</strong>
            </div>
          <?php endif; ?>
        </div>
      </div>
    </div>
    
    <?php endwhile; ?>
    
  <?php else: ?>
    <div class="alert alert-warning">
      <i class="bi bi-info-circle"></i> Tidak ada pesanan dengan 
      <?= $search_type === 'phone' ? 'nomor telepon' : 'nama' ?> 
      <strong><?= htmlspecialchars($search) ?></strong>
    </div>
  <?php endif; ?>
  
  <?php endif; ?>

</div>

<!-- Toast Notifikasi -->
<div class="position-fixed bottom-0 end-0 p-3" style="z-index: 11">
  <div id="successToast" class="toast align-items-center text-bg-success border-0" role="alert">
    <div class="d-flex">
      <div class="toast-body">Pesanan berhasil dibatalkan!</div>
      <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast"></button>
    </div>
  </div>
  
  <div id="errorToast" class="toast align-items-center text-bg-danger border-0" role="alert">
    <div class="d-flex">
      <div class="toast-body" id="errorMsg">Terjadi kesalahan!</div>
      <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast"></button>
    </div>
  </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script>
// Fungsi untuk switch tab pencarian
function switchTab(type) {
  // Update tabs
  document.querySelectorAll('.search-tab').forEach(tab => {
    tab.classList.remove('active');
  });
  event.target.closest('.search-tab').classList.add('active');
  
  // Update hidden input dan placeholder
  const searchInput = document.getElementById('searchInput');
  const searchType = document.getElementById('searchType');
  
  searchType.value = type;
  
  if(type === 'phone') {
    searchInput.placeholder = 'Masukkan nomor telepon...';
    searchInput.type = 'tel';
  } else {
    searchInput.placeholder = 'Masukkan nama Anda...';
    searchInput.type = 'text';
  }
  
  searchInput.value = '';
  searchInput.focus();
}

// Fungsi cancel order
async function cancelOrder(orderId, customerName) {
  if(!confirm(`Yakin ingin membatalkan pesanan atas nama "${customerName}"?\n\nPesanan yang sudah dibatalkan tidak dapat dikembalikan.`)) {
    return;
  }
  
  try {
    const response = await fetch('cancel_order.php', {
      method: 'POST',
      headers: { 'Content-Type': 'application/json' },
      body: JSON.stringify({ order_id: orderId })
    });
    
    const result = await response.json();
    
    if(result.status === 'success') {
      const toast = new bootstrap.Toast(document.getElementById('successToast'));
      toast.show();
      
      setTimeout(() => {
        location.reload();
      }, 1500);
    } else {
      document.getElementById('errorMsg').innerText = result.msg || 'Gagal membatalkan pesanan';
      const toast = new bootstrap.Toast(document.getElementById('errorToast'));
      toast.show();
    }
  } catch(err) {
    console.error(err);
    document.getElementById('errorMsg').innerText = 'Gagal menghubungi server!';
    const toast = new bootstrap.Toast(document.getElementById('errorToast'));
    toast.show();
  }
}
</script>

</body>
</html>