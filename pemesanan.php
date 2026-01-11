<?php include 'koneksi.php'; ?>

<!doctype html>
<html lang="id">
<head>
  <meta charset="utf-8"/>
  <meta name="viewport" content="width=device-width, initial-scale=1"/>
  <title>UMKM PUDDINGKU - Pemesanan</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600;700&display=swap" rel="stylesheet">

  <style>
    /* ==========================================
       📦 BAGIAN 1: RESET & DASAR HALAMAN
       Fungsi: Reset default browser & setup dasar
       ========================================== */
    * {
      margin: 0;
      padding: 0;
      box-sizing: border-box;
    }

    /* Background halaman dengan gradient pink */
    body {
      font-family: 'Poppins', sans-serif;
      background: linear-gradient(135deg, #FFB6D9 0%, #FFC8E3 25%, #FFD4EC 50%, #FFE0F5 75%, #FFF0FA 100%);
      min-height: 100vh;
      position: relative;
      overflow-x: hidden;
    }

    /* Efek cahaya radial di background */
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


    /* ==========================================
       🎈 BAGIAN 2: DEKORASI MENGAMBANG (FLOATING ICONS)
       Fungsi: Icon emoji yang melayang-layang di background
       ========================================== */
    .floating-icon {
      position: fixed;
      font-size: 40px;
      opacity: 0.15;
      pointer-events: none;
      z-index: 1;
      animation: float 25s infinite ease-in-out;
    }

    /* Posisi setiap icon dengan delay berbeda */
    .floating-icon:nth-child(1) { top: 10%; left: 5%; animation-delay: 0s; }
    .floating-icon:nth-child(2) { top: 20%; right: 10%; animation-delay: 3s; }
    .floating-icon:nth-child(3) { top: 50%; left: 8%; animation-delay: 6s; }
    .floating-icon:nth-child(4) { top: 70%; right: 12%; animation-delay: 9s; }
    .floating-icon:nth-child(5) { bottom: 15%; left: 15%; animation-delay: 12s; }
    .floating-icon:nth-child(6) { bottom: 25%; right: 8%; animation-delay: 15s; }

    /* Animasi melayang naik-turun */
    @keyframes float {
      0%, 100% { transform: translateY(0) rotate(0deg); }
      25% { transform: translateY(-30px) rotate(5deg); }
      50% { transform: translateY(-60px) rotate(-5deg); }
      75% { transform: translateY(-30px) rotate(3deg); }
    }


    /* ==========================================
       🧭 BAGIAN 3: NAVBAR (MENU ATAS)
       Fungsi: Menu navigasi di bagian atas halaman
       ========================================== */
    nav.navbar {
      background: rgba(255, 255, 255, 0.95) !important;
      backdrop-filter: blur(15px);
      box-shadow: 0 4px 20px rgba(255, 105, 180, 0.15);
      position: sticky;
      top: 0;
      z-index: 1000;
      border-bottom: 2px solid rgba(255, 182, 217, 0.3);
      animation: slideDown 0.6s ease-out;
    }

    /* Animasi navbar muncul dari atas */
    @keyframes slideDown {
      from {
        opacity: 0;
        transform: translateY(-20px);
      }
      to {
        opacity: 1;
        transform: translateY(0);
      }
    }

    /* Logo/Brand di navbar */
    .navbar-brand {
      color: #FF69B4 !important;
      font-weight: 700;
      font-size: 24px;
      display: flex;
      align-items: center;
      gap: 0.5rem;
      transition: all 0.3s ease;
    }

    /* Efek hover pada logo */
    .navbar-brand:hover {
      transform: scale(1.05);
      color: #FF1493 !important;
    }


    /* ==========================================
       ⬅️ BAGIAN 4: TOMBOL KEMBALI
       Fungsi: Tombol bulat untuk kembali ke halaman sebelumnya
       ========================================== */
    .back-button {
      position: fixed;
      top: 80px;
      left: 20px;
      background: linear-gradient(135deg, #FFB6D9, #FF99CC);
      backdrop-filter: blur(10px);
      border-radius: 50%;
      width: 50px;
      height: 50px;
      display: flex;
      justify-content: center;
      align-items: center;
      color: white;
      font-size: 24px;
      text-decoration: none;
      box-shadow: 0 8px 20px rgba(255, 105, 180, 0.4);
      transition: all 0.4s cubic-bezier(0.68, -0.55, 0.265, 1.55);
      z-index: 1000;
      border: 3px solid white;
    }

    /* Efek hover tombol kembali (membesar & berputar) */
    .back-button:hover {
      background: linear-gradient(135deg, #FF99CC, #FF77B7);
      transform: scale(1.15) rotate(-10deg);
      box-shadow: 0 12px 30px rgba(255, 105, 180, 0.6);
    }


    /* ==========================================
       🎯 BAGIAN 5: HERO SECTION (BAGIAN JUDUL BESAR)
       Fungsi: Banner utama dengan judul dan deskripsi
       ========================================== */
    .hero {
      background: linear-gradient(135deg, rgba(255, 240, 250, 0.9), rgba(255, 225, 240, 0.9));
      backdrop-filter: blur(10px);
      padding: 60px 0;
      text-align: center;
      border-bottom: 3px solid rgba(255, 182, 217, 0.3);
      position: relative;
      z-index: 2;
      animation: fadeIn 0.8s ease-out;
    }

    /* Animasi hero muncul dari bawah */
    @keyframes fadeIn {
      from {
        opacity: 0;
        transform: translateY(20px);
      }
      to {
        opacity: 1;
        transform: translateY(0);
      }
    }

    /* Judul besar di hero */
    .hero h1 {
      color: #FF69B4;
      font-weight: 700;
      font-size: 2.5rem;
      text-shadow: 2px 2px 4px rgba(255, 105, 180, 0.2);
      margin-bottom: 1rem;
    }

    /* Paragraf di hero */
    .hero p {
      color: #FF1493;
      font-size: 1.2rem;
    }


    /* ==========================================
       🔘 BAGIAN 6: TOMBOL (BUTTONS)
       Fungsi: Styling untuk semua tombol
       ========================================== */
    .btn-outline-success,
    .btn-outline-primary {
      border: 2px solid #FF69B4;
      color: #FF69B4;
      border-radius: 12px;
      padding: 8px 16px;
      font-weight: 600;
      transition: all 0.3s ease;
      background: rgba(255, 255, 255, 0.8);
      backdrop-filter: blur(5px);
    }

    /* Efek hover tombol outline */
    .btn-outline-success:hover,
    .btn-outline-primary:hover {
      background: linear-gradient(135deg, #FF69B4, #FF1493);
      color: white;
      border-color: #FF1493;
      transform: translateY(-2px);
      box-shadow: 0 6px 15px rgba(255, 105, 180, 0.4);
    }

    /* Tombol toggle kategori (icon menu) */
    .category-toggle {
      font-size: 24px;
      cursor: pointer;
      color: #FF69B4;
      background: rgba(255, 255, 255, 0.8);
      border: 2px solid #FF69B4;
      border-radius: 12px;
      width: 45px;
      height: 45px;
      display: flex;
      align-items: center;
      justify-content: center;
      transition: all 0.3s ease;
    }

    /* Hover toggle kategori */
    .category-toggle:hover {
      background: #FF69B4;
      color: white;
      transform: scale(1.1);
    }


    /* ==========================================
       📋 BAGIAN 7: DROPDOWN MENU KATEGORI
       Fungsi: Menu dropdown untuk filter kategori produk
       ========================================== */
    .dropdown-menu-custom {
      display: none;
      position: absolute;
      right: 0;
      background: rgba(255, 255, 255, 0.98);
      backdrop-filter: blur(15px);
      border-radius: 15px;
      padding: 10px;
      box-shadow: 0 8px 25px rgba(255, 105, 180, 0.3);
      z-index: 100;
      border: 2px solid rgba(255, 182, 217, 0.5);
      animation: dropdownSlide 0.3s ease-out;
    }

    /* Animasi dropdown muncul */
    @keyframes dropdownSlide {
      from {
        opacity: 0;
        transform: translateY(-10px);
      }
      to {
        opacity: 1;
        transform: translateY(0);
      }
    }

    /* Tombol di dalam dropdown */
    .dropdown-menu-custom button {
      display: block;
      width: 100%;
      border: none;
      background: none;
      text-align: left;
      padding: 10px 15px;
      border-radius: 10px;
      color: #FF69B4;
      font-weight: 500;
      transition: all 0.3s ease;
    }

    /* Tombol aktif & hover dalam dropdown */
    .dropdown-menu-custom button.active,
    .dropdown-menu-custom button:hover {
      background: linear-gradient(135deg, #FFE0F5, #FFD4EC);
      color: #FF1493;
      transform: translateX(5px);
    }


    /* ==========================================
       🛍️ BAGIAN 8: KARTU PRODUK
       Fungsi: Styling untuk kotak produk (card)
       ========================================== */
    main {
      position: relative;
      z-index: 2;
    }

    /* Kartu produk */
    .card {
      border: none;
      border-radius: 20px;
      overflow: hidden;
      background: rgba(255, 255, 255, 0.95);
      backdrop-filter: blur(10px);
      box-shadow: 0 8px 25px rgba(255, 105, 180, 0.15);
      transition: all 0.4s cubic-bezier(0.68, -0.55, 0.265, 1.55);
      border: 2px solid rgba(255, 182, 217, 0.3);
      animation: cardFadeIn 0.6s ease-out backwards;
    }

    /* Efek hover kartu (naik & membesar) */
    .card:hover {
      transform: translateY(-10px) scale(1.02);
      box-shadow: 0 15px 40px rgba(255, 105, 180, 0.3);
      border-color: #FF99CC;
    }

    /* Animasi kartu muncul */
    @keyframes cardFadeIn {
      from {
        opacity: 0;
        transform: translateY(30px);
      }
      to {
        opacity: 1;
        transform: translateY(0);
      }
    }

    /* Gambar produk di kartu */
    .card-img-top {
      height: 200px;
      object-fit: cover;
      transition: transform 0.3s ease;
    }

    /* Efek zoom gambar saat hover kartu */
    .card:hover .card-img-top {
      transform: scale(1.1);
    }

    /* Judul produk */
    .card-body h6 {
      color: #FF69B4;
      font-weight: 600;
      min-height: 40px;
    }

    /* Harga produk */
    .card-body strong {
      color: #FF1493;
      font-size: 1.1rem;
    }

    /* Tombol primary (tambah ke keranjang) */
    .btn-primary {
      background: linear-gradient(135deg, #FF69B4, #FF1493);
      border: none;
      border-radius: 10px;
      padding: 8px 15px;
      transition: all 0.3s ease;
      box-shadow: 0 4px 12px rgba(255, 20, 147, 0.3);
    }

    /* Hover tombol primary */
    .btn-primary:hover {
      background: linear-gradient(135deg, #FF1493, #FF69B4);
      transform: scale(1.1);
      box-shadow: 0 6px 18px rgba(255, 20, 147, 0.5);
    }

    /* Placeholder jika tidak ada gambar produk */
    .product-placeholder {
      width: 100%;
      height: 200px;
      background: linear-gradient(135deg, #FF69B4, #FF1493);
      display: flex;
      align-items: center;
      justify-content: center;
      color: white;
      font-size: 48px;
    }


    /* ==========================================
       🦶 BAGIAN 9: FOOTER
       Fungsi: Bagian bawah halaman
       ========================================== */
    footer {
      background: linear-gradient(135deg, rgba(255, 240, 250, 0.95), rgba(255, 225, 240, 0.95));
      backdrop-filter: blur(10px);
      color: #FF69B4;
      padding: 30px 0;
      border-top: 3px solid rgba(255, 182, 217, 0.3);
      position: relative;
      z-index: 2;
      margin-top: 50px;
    }


    /* ==========================================
       💬 BAGIAN 10: MODAL (POP-UP)
       Fungsi: Kotak dialog untuk checkout/form
       ========================================== */
    .modal-content {
      border-radius: 25px;
      border: 3px solid rgba(255, 182, 217, 0.5);
      box-shadow: 0 15px 50px rgba(255, 105, 180, 0.3);
      background: rgba(255, 255, 255, 0.98);
      backdrop-filter: blur(15px);
    }

    /* Header modal (bagian atas) */
    .modal-header {
      background: linear-gradient(135deg, #FF69B4, #FF1493);
      color: white;
      border-top-left-radius: 22px;
      border-top-right-radius: 22px;
      padding: 20px 25px;
      border-bottom: none;
    }

    /* Judul modal */
    .modal-title {
      font-weight: 700;
      font-size: 22px;
    }

    /* Body modal */
    .modal-body {
      padding: 25px;
    }


    /* ==========================================
       ✏️ BAGIAN 11: INPUT FORM
       Fungsi: Styling untuk input field (text, select, textarea)
       ========================================== */
    .input-group-custom {
      position: relative;
      margin-bottom: 15px;
    }

    /* Icon di dalam input */
    .input-group-custom i {
      position: absolute;
      left: 15px;
      top: 50%;
      transform: translateY(-50%);
      font-size: 18px;
      color: #FF69B4;
      z-index: 10;
    }

    /* Input dengan icon */
    .input-with-icon {
      padding-left: 45px !important;
      border-radius: 15px;
      border: 2px solid #FFD4EC;
      transition: all 0.3s ease;
      background: rgba(255, 245, 250, 0.5);
    }

    /* Focus pada input */
    .input-with-icon:focus {
      border-color: #FF69B4;
      box-shadow: 0 0 15px rgba(255, 105, 180, 0.3);
      background: white;
      transform: scale(1.02);
    }

    /* Select dropdown */
    .form-select {
      border-radius: 15px;
      border: 2px solid #FFD4EC;
      padding-left: 45px;
      background: rgba(255, 245, 250, 0.5);
    }

    /* Focus pada select */
    .form-select:focus {
      border-color: #FF69B4;
      box-shadow: 0 0 15px rgba(255, 105, 180, 0.3);
    }

    /* Textarea (catatan) */
    textarea.input-with-icon {
      min-height: 80px;
      padding-top: 12px !important;
    }


    /* ==========================================
       💳 BAGIAN 12: INFO PEMBAYARAN
       Fungsi: Section untuk metode pembayaran (bank/QRIS)
       ========================================== */
    #bankSection, #qrisSection {
      animation: slideInUp 0.4s ease-out;
    }

    /* Animasi muncul dari bawah */
    @keyframes slideInUp {
      from {
        opacity: 0;
        transform: translateY(20px);
      }
      to {
        opacity: 1;
        transform: translateY(0);
      }
    }

    /* Kotak info bank & QRIS */
    #bankSection .bg-white,
    #qrisSection .bg-light {
      border: 2px solid #FFD4EC !important;
      border-radius: 15px !important;
    }


    /* ==========================================
       ✅ BAGIAN 13: TOMBOL SUBMIT
       Fungsi: Tombol kirim pesanan
       ========================================== */
    #submitBtn {
      background: linear-gradient(135deg, #FF69B4, #FF1493);
      border: none;
      padding: 12px 30px;
      border-radius: 15px;
      font-weight: 600;
      font-size: 16px;
      transition: all 0.3s ease;
      box-shadow: 0 8px 20px rgba(255, 20, 147, 0.4);
      color: white;
    }

    /* Hover tombol submit */
    #submitBtn:hover {
      background: linear-gradient(135deg, #FF1493, #FF69B4);
      transform: translateY(-3px);
      box-shadow: 0 12px 30px rgba(255, 20, 147, 0.5);
    }


    /* ==========================================
       🛒 BAGIAN 14: BADGE KERANJANG
       Fungsi: Badge angka di icon keranjang
       ========================================== */
    #cartCount {
      background: linear-gradient(135deg, #FF1493, #FF69B4);
      box-shadow: 0 2px 8px rgba(255, 20, 147, 0.4);
    }


    /* ==========================================
       📦 BAGIAN 15: ITEM DI KERANJANG
       Fungsi: Styling untuk daftar produk di keranjang
       ========================================== */
    #cartItems .border {
      border: 2px solid #FFD4EC !important;
      border-radius: 15px !important;
      background: linear-gradient(135deg, rgba(255, 240, 250, 0.5), rgba(255, 255, 255, 0.5)) !important;
      transition: all 0.3s ease;
    }

    /* Hover item keranjang */
    #cartItems .border:hover {
      border-color: #FF99CC !important;
      transform: translateX(5px);
    }


    /* ==========================================
       🔔 BAGIAN 16: TOAST NOTIFICATION
       Fungsi: Notifikasi sukses/error yang muncul di pojok
       ========================================== */
    .toast {
      border-radius: 15px;
      box-shadow: 0 8px 25px rgba(0, 0, 0, 0.2);
      border: 2px solid rgba(255, 255, 255, 0.3);
    }


    /* ==========================================
       📱 BAGIAN 17: RESPONSIVE (MOBILE)
       Fungsi: Penyesuaian tampilan untuk layar kecil
       ========================================== */
    @media (max-width: 768px) {
      .hero h1 {
        font-size: 2rem;
      }

      .hero p {
        font-size: 1rem;
      }

      .floating-icon {
        font-size: 30px;
      }

      .card-img-top {
        height: 160px;
      }
    }


    /* ==========================================
       ⏳ BAGIAN 18: LOADING SPINNER
       Fungsi: Animasi loading berputar
       ========================================== */
    @keyframes spin {
      to { transform: rotate(360deg); }
    }

    .loading-spinner {
      display: inline-block;
      width: 16px;
      height: 16px;
      border: 2px solid rgba(255, 255, 255, 0.3);
      border-top-color: white;
      border-radius: 50%;
      animation: spin 0.6s linear infinite;
    }


    /* ==========================================
       ✔️ BAGIAN 19: ANIMASI CHECKMARK
       Fungsi: Animasi centang sukses
       ========================================== */
    @keyframes checkmarkScale {
      0% { transform: scale(0) rotate(0deg); }
      50% { transform: scale(1.2) rotate(10deg); }
      100% { transform: scale(1) rotate(0deg); }
    }
  </style>
</head>
<body>

<!-- ==========================================
     🎨 BAGIAN 1: DEKORASI MENGAMBANG
     Fungsi: Emoji lucu yang melayang di layar
     Cara kerja: Akan dianimasikan dengan CSS
========================================== -->
<div class="floating-icon">🍮</div>
<div class="floating-icon">💕</div>
<div class="floating-icon">🍰</div>
<div class="floating-icon">🌸</div>
<div class="floating-icon">✨</div>
<div class="floating-icon">🎂</div>


<!-- ==========================================
     📱 BAGIAN 2: NAVBAR (MENU NAVIGASI ATAS)
     Fungsi: Menu yang nempel di atas halaman
     Isi: Logo, Tombol Cek Pesanan, Kategori, Keranjang
========================================== -->
<nav class="navbar navbar-enhanced navbar-expand-lg fixed-top">
  <div class="container">
    
    <!-- 🏷️ LOGO & NAMA BRAND -->
    <a class="navbar-brand d-flex align-items-center" href="#hero">
      <img src="img/bg/logo_alfin.png" alt="Logo Puddingku" width="55" height="55" class="me-2 rounded-circle">
      <strong style="background: linear-gradient(135deg, #d97706, #ff69b4); -webkit-background-clip: text; -webkit-text-fill-color: transparent;">
        PUDDINGKU
      </strong>
    </a>

    <!-- 🔘 TOMBOL-TOMBOL KANAN -->
    <div class="d-flex align-items-center gap-2">
      
      <!-- ✅ Tombol CEK PESANAN -->
      <a href="cek_pesanan.php" class="btn btn-outline-success btn-sm d-flex align-items-center gap-1" title="Cek Status Pesanan">
        <i class="bi bi-search"></i> <!-- Icon kaca pembesar -->
        <span class="d-none d-md-inline">Cek Pesanan</span> <!-- Teks disembunyikan di HP -->
      </a>

      <!-- 📋 Tombol KATEGORI dengan Dropdown -->
      <div class="position-relative">
        <button class="category-toggle" id="categoryToggle" aria-label="Kategori">
          <i class="bi bi-list"></i> <!-- Icon 3 garis -->
        </button>
        
        <!-- Menu Dropdown Kategori (muncul saat tombol diklik) -->
        <div class="dropdown-menu-custom" id="categoryMenu">
          <button data-category="all" class="active">✨ Semua</button>
          <button data-category="Brownies">🍫 Brownies</button>
          <button data-category="Cake">🎂 Cake</button>
          <button data-category="Cookies">🍪 Cookies</button>
          <button data-category="Dessert">🍰 Dessert</button>
          <button data-category="Pudding">🍮 Pudding</button>
        </div>
      </div>

      <!-- 🛒 Tombol KERANJANG dengan Badge Jumlah -->
      <button id="openCartBtn" class="btn btn-outline-primary position-relative">
        <i class="bi bi-cart3"></i> <!-- Icon keranjang -->
        <!-- Badge merah untuk jumlah item di keranjang -->
        <span id="cartCount" class="badge bg-danger rounded-pill" 
              style="position:absolute; top:-6px; right:-6px; font-size:.7rem;">
          0
        </span>
      </button>
      
    </div>
  </div>
</nav>


<!-- ==========================================
     ⬅️ BAGIAN 3: TOMBOL KEMBALI
     Fungsi: Tombol untuk balik ke halaman utama
========================================== -->
<a href="index.php" class="back-button" title="Kembali ke halaman utama">⟵</a>


<!-- ==========================================
     🎯 BAGIAN 4: HEADER / HERO
     Fungsi: Judul besar di bagian atas halaman
========================================== -->
<header class="hero">
  <div class="container">
    <h1 class="fw-bold">💖 Pemesanan Online - Mudah & Cepat</h1>
    <p class="lead">Pilih produk favoritmu, tambahkan ke keranjang, lalu checkout 🎂✨</p>
  </div>
</header>


<!-- ==========================================
     🛍️ BAGIAN 5: DAFTAR PRODUK
     Fungsi: Tempat produk-produk ditampilkan
     Catatan: Isinya diisi otomatis pakai JavaScript
========================================== -->
<main class="container my-5">
  <div class="row" id="productList">
    <!-- Produk akan muncul di sini otomatis -->
  </div>
</main>


<!-- ==========================================
     📄 BAGIAN 6: FOOTER (BAGIAN BAWAH)
     Fungsi: Info copyright di bawah halaman
========================================== -->
<footer class="text-center">
  <strong>
    &copy; <span id="year"></span> UMKM PUDDINGKU – Semua Hak Dilindungi 🍮💕
  </strong>
</footer>


<!-- ==========================================
     🛒 BAGIAN 7: MODAL KERANJANG
     Fungsi: Pop-up yang muncul saat klik tombol keranjang
     Isi: Daftar produk di keranjang + Total Harga
========================================== -->
<div class="modal fade" id="cartModal" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-lg modal-dialog-scrollable">
    <div class="modal-content">
      
      <!-- HEADER MODAL (Judul & Tombol Close) -->
      <div class="modal-header">
        <h5 class="modal-title">KERANJANG ANDA</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      
      <!-- ISI MODAL -->
      <div class="modal-body">
        <!-- Tempat daftar produk di keranjang muncul -->
        <div id="cartItems"></div>
        
        <hr>
        
        <!-- Total Harga -->
        <div class="d-flex justify-content-between">
          <strong>Total:</strong>
          <h5 id="cartTotal">Rp0</h5>
        </div>
      </div>
      
      <!-- TOMBOL-TOMBOL BAWAH -->
      <div class="modal-footer">
        <button id="clearCartBtn" class="btn btn-outline-danger">Kosongkan</button>
        <button id="checkoutBtn" class="btn btn-primary">Checkout</button>
      </div>
      
    </div>
  </div>
</div>

</body>

<!-- ==========================================
     💳 BAGIAN 8: MODAL CHECKOUT
     Fungsi: Pop-up formulir pemesanan
     Muncul saat: User klik tombol "Checkout" di keranjang
========================================== -->
<div class="modal fade" id="checkoutModal" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      
      <!-- HEADER MODAL (Judul & Tombol Close) -->
      <div class="modal-header">
        <h5 class="modal-title">FORMULIR PEMESANAN </h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>

      <!-- ==========================================
           📝 FORMULIR PEMESANAN
           Fungsi: Form untuk isi data pembeli
      ========================================== -->
      <form id="checkoutForm" class="modal-body">

        <!-- 👤 INPUT NAMA LENGKAP -->
        <div class="mb-3">
          <label class="form-label">Nama</label>
          <div class="input-group-custom">
            <i class="bi bi-person-fill"></i> <!-- Icon orang -->
            <input required type="text" id="customerName" class="form-control input-with-icon" placeholder="Nama Lengkap">
          </div>
        </div>

        <!-- 🏠 INPUT ALAMAT -->
        <div class="mb-3">
          <label class="form-label">Alamat </label>
          <div class="input-group-custom">
            <i class="bi bi-house-door-fill"></i> <!-- Icon rumah -->
            <textarea required id="address" class="form-control input-with-icon" rows="2" placeholder="Alamat Penerima"></textarea>
          </div>
        </div>

        <!-- 📞 INPUT NOMOR TELEPON -->
        <div class="mb-3">
          <label class="form-label">Nomor Telepon </label>
          <div class="input-group-custom">
            <i class="bi bi-telephone-fill"></i> <!-- Icon telepon -->
            <input required type="tel" id="phone" class="form-control input-with-icon" placeholder="08xxxxxxxx">
          </div>
        </div>

        <!-- ==========================================
             💰 PILIHAN METODE PEMBAYARAN
             Fungsi: User pilih cara bayar
             Pilihan: Cash, Transfer Bank, QRIS
        ========================================== -->
        <div class="mb-3">
          <label class="form-label">Metode Pembayaran </label>
          <div class="input-group-custom">
            <i class="bi bi-wallet-fill"></i> <!-- Icon dompet -->
            <select id="paymentMethod" class="form-select input-with-icon">
              <option value="cash">Bayar di tempat (Cash)</option>
              <option value="bank">Transfer Bank</option>
              <option value="Qris">QRIS</option>
            </select>
          </div>
        </div>

        <!-- ==========================================
             🏦 SECTION INFO TRANSFER BANK
             Fungsi: Muncul HANYA jika pilih "Transfer Bank"
             Isi: Nomor rekening BCA & Mandiri
             Default: DISEMBUNYIKAN (display: none)
        ========================================== -->
        <div class="mb-3" id="bankSection" style="display: none;">
          <div class="p-3 bg-light rounded border">
            <p class="mb-3"><strong>Informasi Rekening:</strong></p>
            
            <!-- 💳 REKENING BCA -->
            <div class="mb-3 p-2 bg-white rounded border d-flex align-items-center">
              <i class="bi bi-bank2 text-primary fs-3 me-3"></i> <!-- Icon bank biru -->
              <div>
                <small class="text-muted">Bank BCA</small><br>
                <strong>1234567890</strong><br> <!-- Nomor rekening -->
                <small>a.n. Nama Pemilik Rekening</small>
              </div>
            </div>
            
            <!-- 💳 REKENING MANDIRI -->
            <div class="mb-2 p-2 bg-white rounded border d-flex align-items-center">
              <i class="bi bi-bank text-warning fs-3 me-3"></i> <!-- Icon bank kuning -->
              <div>
                <small class="text-muted">Bank Mandiri</small><br>
                <strong>0987654321</strong><br> <!-- Nomor rekening -->
                <small>a.n. Nama Pemilik Rekening</small>
              </div>
            </div>
            
            <!-- ℹ️ CATATAN INSTRUKSI -->
            <p class="mt-3 mb-0 text-muted small">
              <i class="bi bi-info-circle"></i> Silakan transfer sesuai total pesanan dan upload bukti pembayaran
            </p>
          </div>
        </div>

        <!-- ==========================================
             📱 SECTION QR CODE QRIS
             Fungsi: Muncul HANYA jika pilih "QRIS"
             Isi: QR Code untuk scan pembayaran
             Default: DISEMBUNYIKAN (display: none)
        ========================================== -->
        <div class="mb-3" id="qrisSection" style="display: none;">
          <div class="text-center p-3 bg-light rounded border">
            <p class="mb-2"><strong>Scan QR Code untuk pembayaran QRIS:</strong></p>
            
            <!-- 🖼️ GAMBAR QR CODE -->
            <img src="img/bg/qris.jpg" alt="QR Code QRIS" style="max-width: 250px; width: 100%;">
            
            <p class="mt-2 text-muted small">
              Silakan scan QR code di atas menggunakan aplikasi pembayaran digital Anda
            </p>
          </div>
        </div>

        <!-- ==========================================
             📸 UPLOAD BUKTI PEMBAYARAN
             Fungsi: User upload foto bukti transfer/pembayaran
             File yang diterima: JPG, PNG (max 2MB)
        ========================================== -->
        <div class="mb-3">
          <label class="form-label">Upload Bukti Pembayaran </label>
          <div class="input-group-custom">
            <i class="bi bi-image-fill"></i> <!-- Icon gambar -->
            <input type="file" id="paymentProof" accept="image/*" class="form-control input-with-icon">
          </div>
          <small class="text-muted">Format: JPG, PNG. Max 2MB.</small>
        </div>

        <!-- ==========================================
             ✅ TOMBOL SUBMIT
             Fungsi: Kirim pesanan ke server
             Action: Submit form saat diklik
        ========================================== -->
        <div class="text-end mt-3">
          <button type="submit" class="btn btn-submit" id="submitBtn">
            Kirim Pesanan & Bayar
          </button>
        </div>

      </form>

    </div>
  </div>
</div>

<script>
// Event listener saat user memilih metode pembayaran
document.getElementById('paymentMethod').addEventListener('change', function() {
  // Ambil elemen section QRIS dan Bank Transfer
  const qrisSection = document.getElementById('qrisSection');
  const bankSection = document.getElementById('bankSection');
  
  // Sembunyikan semua section pembayaran terlebih dahulu
  qrisSection.style.display = 'none';
  bankSection.style.display = 'none';
  
  // Tampilkan section yang sesuai dengan pilihan user
  if (this.value === 'Qris') {
    qrisSection.style.display = 'block';  // Tampilkan QR Code QRIS
  } else if (this.value === 'bank') {
    bankSection.style.display = 'block';  // Tampilkan info Bank Transfer
  }
});
</script>
<!-- Modal Konfirmasi Pesanan Berhasil -->
<div class="modal fade" id="successModal" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <!-- Kotak modal dengan border hijau -->
    <div class="modal-content" style="border-radius: 25px; border: 3px solid #28a745; overflow: hidden;">
      
      <!-- Header Modal (bagian atas) - background hijau -->
      <div class="modal-header border-0" style="background: linear-gradient(135deg, #28a745, #20c997);">
        <h5 class="modal-title text-white">✅ Pesanan Berhasil</h5>
        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      
      <!-- Body Modal (isi konten) -->
      <div class="modal-body text-center p-5" style="background: linear-gradient(135deg, rgba(40, 167, 69, 0.1), rgba(255, 255, 255, 0.95));">
        
        <!-- Icon Checkmark besar dengan animasi -->
        <div class="mb-4" style="font-size: 80px; animation: checkmarkScale 0.6s ease-out;">
          ✅
        </div>
        
        <!-- Judul konfirmasi -->
        <h3 class="fw-bold mb-3" style="color: #28a745;">Pesanan Berhasil Disimpan!</h3>
        
        <!-- Label nomor pesanan -->
        <p class="text-muted mb-2">Nomor Pesanan Anda:</p>
        
        <!-- Nomor pesanan (akan diisi oleh JavaScript) -->
        <h4 class="fw-bold mb-4" style="color: #FF69B4;" id="orderNumber">#ORDER-XXXX</h4>
        
        <!-- Alert box info -->
        <div class="alert alert-success mb-4" role="alert" style="border-radius: 15px; background: rgba(40, 167, 69, 0.1); border: 2px solid #28a745;">
          <i class="bi bi-info-circle-fill me-2"></i>
          <strong>Pesanan Anda telah tersimpan!</strong><br>
          <small>Silakan tunggu konfirmasi dari admin. Anda dapat mengecek status pesanan melalui menu "Cek Pesanan"</small>
        </div>
        
        <!-- Tombol untuk cek status pesanan -->
        <button type="button" class="btn btn-success btn-lg w-100 mb-2" onclick="location.href='cek_pesanan.php'" style="border-radius: 15px; padding: 12px;">
          <i class="bi bi-search me-2"></i>Cek Status Pesanan
        </button>
      </div>
    </div>
  </div>
</div>
<!-- Toast untuk notifikasi tambah ke keranjang -->
<div class="toast-container position-fixed bottom-0 end-0 p-3">
  <!--                               ^^^^^^^^ INI YANG DIUBAH -->
  
  <div id="addToast" class="toast" role="alert">
    <!-- Header toast (background hijau) -->
    <div class="toast-header bg-success text-white">
      <strong class="me-auto">✅ Berhasil!</strong>
      <button type="button" class="btn-close btn-close-white" data-bs-dismiss="toast"></button>
    </div>
    <!-- Body toast (isi pesan) -->
    <div class="toast-body">
      Produk ditambahkan ke keranjang
    </div>
  </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
keranjang
<script>
// Array kosong untuk menyimpan produk dari database
let products = []; 

// Fungsi async untuk load produk dari server
async function loadProducts() {
  const container = document.getElementById('productList');
  
  // Tampilkan loading spinner saat mengambil data
  container.innerHTML = `
    <div class="col-12 text-center py-5">
      <div class="spinner-border text-pink mb-3" role="status" style="width: 3rem; height: 3rem;">
        <span class="visually-hidden">Loading...</span>
      </div>
      <p class="text-muted">Memuat produk dari database...</p>
    </div>
  `;
  
  try {
    // Kirim request ke get_products.php untuk ambil data
    const response = await fetch('get_products.php');
    
    // Cek apakah response berhasil
    if (!response.ok) {
      throw new Error('Network response was not ok');
    }
    
    // Convert response ke JSON
    const data = await response.json();
    console.log('Data received:', data);
    
    // Jika ada data produk
    if (data && data.length > 0) {
      products = data;  // Simpan ke array products
      renderProducts(); // Tampilkan produk ke halaman
      console.log('✅ Products loaded successfully:', products.length);
    } else {
      // Jika tidak ada produk di database
      container.innerHTML = `
        <div class="col-12">
          <div class="alert alert-warning text-center py-4">
            <i class="bi bi-exclamation-triangle" style="font-size: 3rem;"></i>
            <h5 class="mt-3">Belum Ada Produk</h5>
            <p>Silakan tambahkan produk dari halaman admin terlebih dahulu.</p>
            <a href="admin.php?page=produk" class="btn btn-primary mt-2">
              <i class="bi bi-plus-circle"></i> Tambah Produk di Admin
            </a>
          </div>
        </div>
      `;
    }
    
  } catch (error) {
    // Jika terjadi error saat mengambil data
    console.error('❌ Error loading products:', error);
    
    // Tampilkan pesan error yang informatif
    container.innerHTML = `
      <div class="col-12">
        <div class="alert alert-danger text-center py-4">
          <i class="bi bi-x-circle" style="font-size: 3rem;"></i>
          <h5 class="mt-3">Gagal Memuat Produk</h5>
          <p class="mb-3">Terjadi kesalahan saat mengambil data produk dari server.</p>
          <div class="d-flex gap-2 justify-content-center">
            <button class="btn btn-primary" onclick="location.reload()">
              <i class="bi bi-arrow-clockwise"></i> Muat Ulang Halaman
            </button>
            <a href="get_products.php" target="_blank" class="btn btn-outline-secondary">
              <i class="bi bi-bug"></i> Test API
            </a>
          </div>
          <small class="text-muted d-block mt-3">Error: ${error.message}</small>
        </div>
      </div>
    `;
  }
}


// ========================================
// BAGIAN 6: HELPER FUNCTIONS (Fungsi Pembantu)
// ========================================

// Fungsi untuk format angka menjadi Rupiah
// Contoh: 15000 → Rp15.000
const formatRupiah = n => 'Rp' + n.toString().replace(/\B(?=(\d{3})+(?!\d))/g, '.');

// Ambil data keranjang dari localStorage (penyimpanan browser)
// Format: {id_produk: quantity}
// Contoh: {"1": 2, "5": 1} artinya produk ID 1 beli 2, produk ID 5 beli 1
let cart = JSON.parse(localStorage.getItem('umkm_cart') || '{}');


// ========================================
// BAGIAN 7: CART MANAGEMENT FUNCTIONS
// Fungsi untuk mengelola keranjang belanja
// ========================================

// Fungsi untuk menyimpan keranjang ke localStorage
function saveCart(){ 
  localStorage.setItem('umkm_cart', JSON.stringify(cart)); // Simpan ke browser
  renderCartCount();  // Update badge jumlah item
  renderCartModal();  // Update isi modal keranjang
}

// Fungsi untuk menambah produk ke keranjang
function addToCart(id){
  // Cari produk berdasarkan ID
  const product = products.find(p => p.id == id);
  if (!product) {
    alert('Produk tidak ditemukan!');
    return;
  }
  
  // Cek apakah stok masih cukup
  const currentQty = cart[id] || 0;  // Jumlah yang sudah ada di keranjang
  if (currentQty >= product.stock) {
    alert(`Maaf, stok ${product.name} hanya tersedia ${product.stock} unit`);
    return;
  }
  
  // Tambahkan ke keranjang
  if(!cart[id]) cart[id]=0;  // Jika belum ada, set ke 0 dulu
  cart[id]++;  // Tambah 1
  saveCart();  // Simpan
  
  // Tampilkan toast notification (pojok kanan atas)
  const toastEl = document.getElementById('addToast');
  if (toastEl) {
    bootstrap.Toast.getOrCreateInstance(toastEl).show();
  }
}

// Fungsi untuk hapus produk dari keranjang
function removeFromCart(id){ 
  delete cart[id];  // Hapus dari object cart
  saveCart();       // Simpan perubahan
}

// Fungsi untuk ubah jumlah produk di keranjang
function changeQty(id, q){ 
  // Cek stok saat mengubah quantity
  const product = products.find(p => p.id == id);
  if (product && q > product.stock) {
    alert(`Maaf, stok ${product.name} hanya tersedia ${product.stock} unit`);
    return;
  }
  
  // Jika quantity 0 atau kurang, hapus dari keranjang
  if(q<=0) removeFromCart(id); 
  else cart[id]=q;  // Jika tidak, update quantity
  saveCart();       // Simpan
}

// Fungsi untuk mengosongkan seluruh keranjang
function clearCart(){ 
  cart={};   // Reset jadi object kosong
  saveCart(); // Simpan
}

// Fungsi untuk mendapatkan detail item di keranjang
// Return: Array berisi object produk + quantity
function cartItemsDetailed(){ 
  return Object.keys(cart).map(id=>{  // Loop semua ID di cart
    const p=products.find(x=>x.id==id);  // Cari detail produk
    if(!p) return null;  // Jika produk tidak ditemukan, skip
    return {...p, qty:cart[id]};  // Gabungkan data produk + quantity
  }).filter(Boolean);  // Buang yang null
}


function renderProducts(filter='all'){
  const container=document.getElementById('productList');
  container.innerHTML='';
  
  // Tampilkan loading jika produk belum dimuat
  if (products.length === 0) {
    container.innerHTML = `
      <div class="col-12 text-center py-5">
        <div class="spinner-border text-pink" role="status">
          <span class="visually-hidden">Loading...</span>
        </div>
        <p class="mt-3">Memuat produk...</p>
      </div>
    `;
    return;
  }
  
  const list = products.filter(p => filter==='all' || p.category===filter);
  
  if (list.length === 0) {
    container.innerHTML = '<div class="col-12 text-center"><p class="text-muted">Tidak ada produk dalam kategori ini</p></div>';
    return;
  }
  
  list.forEach((p, index)=>{
    const col=document.createElement('div'); 
    col.className='col-6 col-md-4 col-lg-3 mb-4';
    col.style.animationDelay = `${index * 0.05}s`;
    
    // Tampilkan badge stok rendah
    const stockBadge = p.stock < 10 ? `<span class="badge bg-warning text-dark position-absolute top-0 end-0 m-2">Stok: ${p.stock}</span>` : '';
    
    col.innerHTML=`
      <div class="card h-100 shadow-sm text-center">
        ${stockBadge}
        <img src="${p.img}" class="card-img-top" alt="${p.name}" style="height: 200px; object-fit: cover;" onerror="this.style.display='none'; this.nextElementSibling.style.display='flex';">
        <div class="product-placeholder" style="display: none;">🍮</div>
        <div class="card-body d-flex flex-column justify-content-between">
          <h6 class="fw-semibold">${p.name}</h6>
          <div>
            <div class="text-muted small mb-2">Stok: ${p.stock} unit</div>
            <div class="d-flex justify-content-between align-items-center">
              <strong>${formatRupiah(p.price)}</strong>
              <button class="btn btn-sm btn-primary" onclick="addToCart('${p.id}')" ${p.stock <= 0 ? 'disabled' : ''}>
                <i class="bi bi-cart-plus"></i>
              </button>
            </div>
          </div>
        </div>
      </div>
    `;
    container.appendChild(col);
  });
}

function renderCartModal(){
  const container=document.getElementById('cartItems');
  const totalEl=document.getElementById('cartTotal');
  const items=cartItemsDetailed();
  
  if(items.length===0){ 
    container.innerHTML='<p class="text-muted">Keranjang kosong.</p>'; 
    totalEl.innerText='Rp0'; 
    return; 
  }
  
  container.innerHTML='';
  let total=0;
  
  items.forEach(it=>{
    const subtotal = it.price * it.qty; 
    total += subtotal;
    const row=document.createElement('div'); 
    row.className='mb-3 p-3 border rounded bg-light';
    row.innerHTML=`
      <div class="row align-items-center g-2">
        <div class="col-3">
          <img src="${it.img}" alt="${it.name}" class="rounded w-100" style="height:70px;object-fit:cover;" onerror="this.style.display='none'; this.nextElementSibling.style.display='flex';">
          <div class="rounded w-100" style="height:70px;background:linear-gradient(135deg, #FF69B4 0%, #FF1493 100%);display:none;align-items:center;justify-content:center;font-size:32px;">🍮</div>
        </div>
        <div class="col-5">
          <div class="fw-semibold mb-1" style="font-size:14px;">${it.name}</div>
          <div class="small text-muted">${formatRupiah(it.price)}</div>
          <div class="small text-info">Stok: ${it.stock}</div>
        </div>
        <div class="col-4 text-end">
          <div class="d-flex align-items-center justify-content-end gap-2 mb-2">
            <button class="btn btn-sm btn-outline-secondary d-flex align-items-center justify-content-center" style="width:32px;height:32px;padding:0;" onclick="changeQty('${it.id}', ${it.qty-1})">-</button>
            <span class="fw-semibold" style="min-width:30px;text-align:center;">${it.qty}</span>
            <button class="btn btn-sm btn-outline-secondary d-flex align-items-center justify-content-center" style="width:32px;height:32px;padding:0;" onclick="changeQty('${it.id}', ${it.qty+1})" ${it.qty >= it.stock ? 'disabled' : ''}>+</button>
          </div>
          <div class="fw-bold text-primary">${formatRupiah(subtotal)}</div>
        </div>
      </div>
    `;
    container.appendChild(row);
  });
  totalEl.innerText = formatRupiah(total);
}

function renderCartCount(){
  const count = Object.values(cart).reduce((a,b)=>a+b,0);
  document.getElementById('cartCount').innerText = count;
}

// Jalankan saat halaman selesai dimuat
document.addEventListener('DOMContentLoaded', async ()=>{
  document.getElementById('year').innerText = new Date().getFullYear();
  
  // Load products dari database
  await loadProducts();
  
  renderCartCount();

  const cartModal = new bootstrap.Modal(document.getElementById('cartModal'));
  const checkoutModal = new bootstrap.Modal(document.getElementById('checkoutModal'));

  document.getElementById('openCartBtn').addEventListener('click', ()=>{ 
    renderCartModal(); 
    cartModal.show(); 
  });
  
  document.getElementById('clearCartBtn').addEventListener('click', ()=>{ 
    if(confirm('Kosongkan keranjang?')) clearCart(); 
  });

  document.getElementById('checkoutBtn').addEventListener('click', ()=>{
    if(Object.keys(cart).length===0) return alert('Keranjang masih kosong!');
    cartModal.hide(); 
    setTimeout(()=> checkoutModal.show(), 200);
  });

  const catToggle = document.getElementById('categoryToggle');
  const catMenu = document.getElementById('categoryMenu');
  
  if (catToggle && catMenu) {
    catToggle.addEventListener('click', ()=> catMenu.style.display = catMenu.style.display==='block' ? 'none' : 'block');
    
    catMenu.querySelectorAll('button').forEach(btn=>{
      btn.addEventListener('click',(e)=>{
        catMenu.querySelectorAll('button').forEach(b=>b.classList.remove('active'));
        e.target.classList.add('active');
        renderProducts(e.target.getAttribute('data-category'));
        catMenu.style.display='none';
      });
    });
  }

  // Event listener untuk payment method
  const paymentMethodEl = document.getElementById('paymentMethod');
  if (paymentMethodEl) {
    paymentMethodEl.addEventListener('change', function() {
      const qrisSection = document.getElementById('qrisSection');
      const bankSection = document.getElementById('bankSection');
      
      if (qrisSection) qrisSection.style.display = 'none';
      if (bankSection) bankSection.style.display = 'none';
      
      if (this.value === 'Qris' && qrisSection) {
        qrisSection.style.display = 'block';
      } else if (this.value === 'bank' && bankSection) {
        bankSection.style.display = 'block';
      }
    });
  }

  // Event listener untuk form checkout
  const checkoutForm = document.getElementById('checkoutForm');
  if (checkoutForm) {
    checkoutForm.addEventListener('submit', async (e) => {
      e.preventDefault();

      const customer = document.getElementById('customerName').value.trim();
      const address  = document.getElementById('address').value.trim();
      const phone    = document.getElementById('phone').value.trim();
      const payment  = document.getElementById('paymentMethod').value;
      const items    = cartItemsDetailed();
      const fileInput = document.getElementById('paymentProof');

      if (!customer || !phone) { 
        alert("Nama & Telepon wajib diisi!"); 
        return; 
      }
      if (items.length === 0) { 
        alert("Keranjang masih kosong!"); 
        return; 
      }

      // Validasi stok sebelum checkout
      let stockError = false;
      items.forEach(item => {
        const product = products.find(p => p.id == item.id);
        if (product && item.qty > product.stock) {
          alert(`Stok ${product.name} tidak mencukupi. Tersedia: ${product.stock}`);
          stockError = true;
        }
      });
      
      if (stockError) return;

      // Validasi file jika bukan cash
      if (payment !== 'cash' && fileInput.files.length === 0) {
        alert("Harap upload bukti pembayaran!");
        return;
      }

      const formData = new FormData();
      formData.append('customer', customer);
      formData.append('address', address);
      formData.append('phone', phone);
      formData.append('payment', payment);
      formData.append('items', JSON.stringify(items));
      
      if (fileInput.files.length > 0) {
        formData.append('paymentProof', fileInput.files[0]);
      }

      const submitBtn = document.getElementById('submitBtn');
      submitBtn.disabled = true;
      submitBtn.innerHTML = '<span class="spinner-border spinner-border-sm me-2"></span>Mengirim...';

      try {
        const response = await fetch("proses_pesanan.php", {
          method: "POST",
          body: formData
        });

        const result = await response.json();
        console.log("RESPONSE:", result);

        if (result.status === "success") {
          const successModal = new bootstrap.Modal(document.getElementById('successModal'));
          document.getElementById('orderNumber').innerText = result.order_id || '#ORDER-' + Date.now();
          
          clearCart();
          checkoutModal.hide();
          
          setTimeout(() => {
            successModal.show();
          }, 300);
          
          // Reload products untuk update stok
          await loadProducts();
        } else {
          alert(result.message || 'Terjadi kesalahan saat memproses pesanan');
        }

      } catch (err) {
        console.error(err);
        alert('Gagal mengirim data ke server!');
      } finally {
        submitBtn.disabled = false;
        submitBtn.innerHTML = 'Kirim Pesanan & Bayar';
      }
    });
  }
});
</script>
</body>
</html>