<?php include 'koneksi.php'; ?>

<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>UMKM PUDDINGKU</title>

  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600;700&display=swap" rel="stylesheet">
  <link href="https://unpkg.com/aos@2.3.4/dist/aos.css" rel="stylesheet">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css"/>

  <style>
  /* ===================================================
   💌 BAGIAN KONTAK (Contact Section)
   - Untuk kotak kontak WhatsApp, Instagram, TikTok
   - Efek hover yang keren
   =================================================== */
.contact-box-modern {
  background: linear-gradient(135deg, #ffd4d4 0%, #ffb8b8 100%);
  padding: 40px 30px;
  border-radius: 25px;
  text-align: center;
  transition: all 0.4s ease;
  box-shadow: 0 5px 20px rgba(0,0,0,0.1);
  height: 100%;
  position: relative;
  overflow: hidden;
}

.contact-box-modern::before {
  content: '';
  position: absolute;
  top: -50%;
  left: -50%;
  width: 200%;
  height: 200%;
  background: radial-gradient(circle, rgba(255,255,255,0.3) 0%, transparent 70%);
  opacity: 0;
  transition: opacity 0.5s ease;
}

.contact-box-modern:hover::before {
  opacity: 1;
}

.contact-box-modern:hover {
  transform: translateY(-10px) scale(1.02);
  box-shadow: 0 15px 40px rgba(217, 119, 6, 0.3);
  background: linear-gradient(135deg, #ffb8b8 0%, #ff9d9d 100%);
}

/* Icon bulat di dalam kotak kontak */
.contact-box-modern .icon-wrapper {
  width: 80px;
  height: 80px;
  background: white;
  border-radius: 50%;
  display: flex;
  align-items: center;
  justify-content: center;
  margin: 0 auto;
  box-shadow: 0 5px 15px rgba(0,0,0,0.15);
  transition: all 0.4s ease;
}

.contact-box-modern:hover .icon-wrapper {
  transform: rotate(360deg) scale(1.1);
  box-shadow: 0 8px 25px rgba(217, 119, 6, 0.4);
}

.contact-box-modern .icon-wrapper i {
  font-size: 2.5rem;
  color: #d97706;
}

/* Judul kontak (WhatsApp, Instagram, dll) */
.contact-box-modern h4 {
  font-size: 1.4rem;
  font-weight: 600;
  color: #5a2e0c;
  margin-bottom: 10px;
}

/* Link kontak (nomor HP, username) */
.contact-box-modern .contact-link {
  font-size: 1.3rem;
  font-weight: 600;
  color: #8d4949;
  text-decoration: none;
  display: inline-block;
  padding: 8px 20px;
  background: rgba(255,255,255,0.6);
  border-radius: 25px;
  transition: all 0.3s ease;
}

.contact-box-modern .contact-link:hover {
  background: white;
  color: #d97706;
  transform: scale(1.05);
  box-shadow: 0 5px 15px rgba(0,0,0,0.15);
}

/* Google Maps */
.map-container {
  margin-top: 20px;
  transition: transform 0.3s ease;
}

.map-container:hover {
  transform: scale(1.01);
}


/* ===================================================
   🧭 NAVBAR (Menu Navigasi Atas)
   - Menu Home, About, Menu, Contact
   - Efek saat di-scroll
   =================================================== */
.navbar {
  background-color: #fffaf3 !important;
  transition: all 0.4s ease;
  background: #fcecdc;
  backdrop-filter: blur(10px);
  border-bottom: 3px solid #e2c3a3;
}

/* Navbar saat di-scroll kebawah */
.navbar.scrolled {
  background-color: #fcecdc !important;
  box-shadow: 0 4px 12px rgba(0,0,0,0.1);
  background: #fffaf3;
  box-shadow: 0 2px 10px rgba(0,0,0,0.1);
}

/* Link menu saat aktif atau di-hover */
.nav-link.active, 
.nav-link:hover {
  color: #d97706 !important;
}

/* Logo brand PUDDINGKU */
.navbar-brand strong {
  color: #d97706;
  font-size: 1.3rem;
}

/* Link menu default */
.nav-link {
  font-weight: 500;
  color: #444 !important;
}

.nav-link:hover {
  color:#d97706 !important;
  transition: 0.3s;
}

.nav-content {
  display: flex;
  justify-content: space-between;
  align-items: center;
  padding: 10px 40px;
}

.menu {
  display: flex;
  list-style: none;
  padding: 0;
}

.menu li {
  margin: 0 10px;
}

.menu a {
  text-decoration: none;
  color: #5a2e0c;
  font-weight: bold;
}


/* ===================================================
   🪟 MODAL (Pop-up)
   - Untuk popup/modal yang muncul
   =================================================== */
.modal-content {
  border-radius: 15px;
  overflow: hidden;
}


/* ===================================================
   📄 BODY (Dasar Halaman)
   - Background, font, warna dasar
   =================================================== */
body {
  margin: 0;
  font-family: 'Poppins', sans-serif;
  background: #fffaf5;
  color: #4b2e16;
  line-height: 1.6;
  scroll-behavior: smooth;
  background: linear-gradient(to bottom right, #fff7e6, #ffe8c2);
  background-attachment: fixed;
}

section {
  padding: 70px 0;
}

section h2 {
  color: #d97706;
  font-weight: 700;
  margin-bottom: 25px;
}

h1 {
  color: #d97706;
  font-weight: 700;
  margin-top: 40px;
}

.container {
  width: 90%;
  max-width: 1200px;
}

img {
  max-width: 100%;
  height: auto;
}


/* ===================================================
   📞 TOP BAR (Header Kontak Atas)
   - Bar kecil di paling atas halaman
   =================================================== */
.top-bar {
  background-color: #5a2e0c;
  color: #fff;
  padding: 5px 0;
  font-size: 14px;
}

.top-bar .container {
  display: flex;
  justify-content: center;
}

.contact-info span {
  margin: 0 10px;
}


/* ===================================================
   🖼️ LOGO
   - Logo PUDDINGKU
   =================================================== */
.logo {
  text-align: center;
}

.logo img {
  width: 40px;
  vertical-align: middle;
}

.logo h2 {
  margin: 0;
  font-size: 20px;
  color: #5a2e0c;
}

.logo span {
  color: #b16b33;
}


/* ===================================================
   🎠 SLIDER HOME (Slideshow Gambar)
   - Gambar bergerak di bagian Home
   - Tombol prev/next
   - Titik indicator
   =================================================== */
.slider {
  position: relative;
  max-width: 100%;
  overflow: hidden;
}

.slides {
  display: flex;
  transition: transform 0.1s;
}

.slide {
  min-width: 100%;
  position: relative;
  text-align: left;
  color: #4b2e16;
}

.slide img {
  width: 100%;
  height: 480px;
  object-fit: cover;
  filter: brightness(90%);
}

/* Text di atas slider */
.text {
  position: absolute;
  top: 40%;
  left: 10%;
  background: rgba(255, 255, 255, 0.7);
  padding: 20px 30px;
  border-radius: 10px;
}

.text h1 {
  font-size: 40px;
  margin-bottom: 10px;
}

.text p {
  font-size: 18px;
}

/* Tombol panah kiri-kanan slider */
.prev, .next {
  cursor: pointer;
  position: absolute;
  top: 50%;
  transform: translateY(-50%);
  background-color: rgba(255,255,255,0.6);
  border: none;
  font-size: 30px;
  font-weight: bold;
  color: #4b2e16;
  padding: 10px;
  border-radius: 50%;
}

.prev:hover, .next:hover {
  background-color: #b16b33;
  color: white;
}

.prev { left: 20px; }
.next { right: 20px; }

/* Titik-titik indicator slider */
.dots {
  text-align: center;
  position: absolute;
  bottom: 15px;
  width: 100%;
}

.dot {
  cursor: pointer;
  height: 12px;
  width: 12px;
  margin: 0 5px;
  background-color: #ddd;
  border-radius: 50%;
  display: inline-block;
}

.dot.active {
  background-color: #b16b33;
}


/* ===================================================
   🏠 HERO SECTION (Banner Besar)
   - Banner besar di halaman Home
   - Dengan animasi fade in
   =================================================== */
.hero {
  position: relative;
  height: 100vh;
  display: flex;
  justify-content: center;
  align-items: center;
  text-align: center;
  color: white;
  overflow: hidden;
}

/* Layer gelap di atas gambar */
.hero::before {
  content: "";
  position: absolute;
  top: 0; left: 0;
  width: 100%; height: 100%;
  background: rgba(0, 0, 0, 0.55);
  z-index: 1;
}

.hero .container {
  position: relative;
  z-index: 2;
  animation: fadeIn 2s ease;
}

.hero h1 {
  font-size: 3.5rem;
  font-weight: 700;
  background: rgba(0, 0, 0, 0.6);
  display: inline-block;
  padding: 15px 35px;
  border-radius: 15px;
  text-shadow: 2px 2px 10px rgba(0,0,0,0.8);
}

.hero p {
  font-size: 1.2rem;
  color: #fef9c3;
  margin-top: 15px;
}

/* Animasi muncul pelan-pelan */
@keyframes fadeIn {
  from {opacity: 0;}
  to {opacity: 1;}
}

/* Untuk gambar yang fade in/out */
.fade-video {
  opacity: 0;
  transition: opacity 5s ease-in-out;
}

.fade-video.active {
  opacity: 1;
}


/* ===================================================
   ℹ️ ABOUT SECTION (Tentang Kami)
   - Foto dan deskripsi PUDDINGKU
   =================================================== */
#about {
  text-align: center;
  padding-top: 100px;
}

.about-container {
  padding: 60px 80px;
  text-align: center;
}

.about-container h2 {
  color: #d46a00;
  font-size: 36px;
  margin-bottom: 10px;
}

.about-content {
  display: flex;
  align-items: center;
  justify-content: center;
  gap: 5px;
  flex-wrap: wrap;
}

/* Gambar di About */
.about-image {
  flex: 1 1 400px;
  display: flex;
  justify-content: center;
}

.about-image img {
  width: 400px;
  border-radius: 20px;
  box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
}

/* Text di About */
.about-text {
  flex: 1 1 500px;
  text-align: left;
  margin-left: -10px;
}

.about-text p {
  gap: 40px;
  font-size: 16px;
  line-height: 1.8;
  text-align: center;
}


/* ===================================================
   🍰 MENU SECTION (Daftar Produk)
   - Card produk brownies, cake, cookies, dll
   - Semua card sama tinggi
   =================================================== */

/* Background section menu */
#galeri {
  background:#FCD5CE;
}

/* Grid system */
.grid {
  display: grid;
  grid-template-columns: repeat(auto-fit, minmin(250px, 1fr));
}

/* Kolom card produk */
#menuList .col-md-3 {
  margin-bottom: 1.5rem;
  display: flex;
  transition: all 0.4s ease;
}

/* Card produk - tinggi sama semua */
#menuList .card {
  height: 480px !important;
  display: flex !important;
  flex-direction: column !important;
  width: 100%;
}

/* Gambar produk - tinggi sama semua */
#menuList .card img,
#menuList .card-img-top,
#menuList img.card-img-top {
  height: 200px !important;
  max-height: 200px !important;
  min-height: 200px !important;
  width: 100% !important;
  object-fit: cover !important;
  flex-shrink: 0 !important;
}

/* Body card (isi teks) */
#menuList .card-body {
  flex: 1 !important;
  display: flex !important;
  flex-direction: column !important;
  padding: 1rem !important;
}

/* Judul produk (max 2 baris) */
#menuList .card-title {
  min-height: 50px !important;
  max-height: 50px !important;
  font-size: 1rem !important;
  margin-bottom: 10px !important;
  overflow: hidden !important;
  display: -webkit-box !important;
  -webkit-line-clamp: 2 !important;
  -webkit-box-orient: vertical !important;
}

/* Deskripsi produk (max 3 baris) */
#menuList .card-text {
  flex: 1 !important;
  font-size: 0.875rem !important;
  margin-bottom: 12px !important;
  overflow: hidden !important;
  display: -webkit-box !important;
  -webkit-line-clamp: 3 !important;
  -webkit-box-orient: vertical !important;
}

/* Harga produk - di tengah */
#menuList .fw-bold,
#menuList p.fw-bold.text-primary {
  margin-top: auto !important;
  font-size: 1.15rem !important;
  height: 32px !important;
  display: flex !important;
  align-items: center !important;
  justify-content: center !important;
  padding-top: 0 !important;
  margin-bottom: 0 !important;
}

/* Card lainnya */
.card-wrapper {
  display: flex;
  flex-wrap: wrap;
  gap: 16px;
}

.menu-card img {
  background-color: #D9C3A1;
  height: 200px;
  width: 200px;
  object-fit: cover;
  border-radius: 10px;
}

.menu-card {
  transition: transform 0.3s ease;
}

.menu-card:hover {
  transform: translateY(-5px);
  transform: translatex(-5px);
}


/* ===================================================
   ⭐ ULASAN SECTION (Review Pelanggan)
   - Slider swiper untuk foto ulasan
   - Efek zoom saat aktif
   =================================================== */
#ulasan {
  background-color: #f8dcdc;
}

#ulasan .judul-section {
  font-weight: 700;
  font-family: 'Poppins', sans-serif;
}

/* Container swiper */
.mySwiper {
  width: 100%;
  padding: 10px 0 10px;
}

/* Setiap slide */
.swiper-slide {
  display: flex;
  justify-content: center;
  transition: transform 0.4s ease;
}

/* Card ulasan */
.card-ulasan {
  background-color: #fff;
  border-radius: 20px;
  overflow: hidden;
  box-shadow: 0 4px 15px rgba(0,0,0,0.1);
  transition: transform 0.4s ease, box-shadow 0.4s ease;
  width: 250px;
  height: 280px;
}

.card-ulasan img {
  width: 100%;
  height: 100%;
  object-fit: cover;
  border-radius: 20px;
  transition: transform 0.6s ease;
}

/* Zoom saat hover */
.card-ulasan:hover img {
  transform: scale(1.25);
}

/* Slide yang aktif (tengah) jadi besar */
.swiper-slide-active .card-ulasan {
  transform: scale(1.25);
  box-shadow: 0 10px 35px rgba(0,0,0,0.25);
  z-index: 2;
}

/* Slide di samping kiri-kanan */
.swiper-slide-next .card-ulasan,
.swiper-slide-prev .card-ulasan {
  transform: scale(1.05);
  opacity: 0.9;
}

/* Tombol panah swiper */
.swiper-button-prev,
.swiper-button-next {
  color: #ff7676;
  transition: color 0.3s;
}

.swiper-button-prev:hover,
.swiper-button-next:hover {
  color: #ff5c5c;
}

/* Titik pagination swiper */
.swiper-pagination {
  position: relative;
  margin-top: 75px;
}

.swiper-pagination-bullet {
  background: #ff7676;
  opacity: 0.4;
  width: 10px;
  height: 10px;
  transition: all 0.3s ease;
  margin: 0 6px !important;
}

.swiper-pagination-bullet-active {
  opacity: 1;
  transform: scale(1.4);
  background: #ff5c5c;
}

/* Tombol rating pojok kanan */
.btn-ulasan {
  position: absolute;
  top: 20px;
  right: 30px;
  background: #e60000;
  color: white;
  padding: 10px 18px;
  border-radius: 30px;
  font-weight: 600;
  text-decoration: none;
  transition: 0.3s;
}

.btn-ulasan:hover {
  background: #b80000;
  color: #fff;
}


/* ===================================================
   🎥 VIDEO SECTION
   - Video produk & kolaborasi
   =================================================== */

/* Video portrait (9:16) */
.video-container-portrait {
  position: relative;
  width: 100%;
  max-width: 350px;
  aspect-ratio: 9 / 16;
  overflow: hidden;
  border-radius: 15px;
  box-shadow: 0 4px 15px rgba(0,0,0,0.3);
}

.video-container-portrait video {
  width: 100%;
  height: 100%;
  object-fit: cover;
  border-radius: 15px;
}

/* ===================================================
   🖼️ GALERI
   - Item galeri dengan efek hover
   =================================================== */
.galeri-item {
  overflow: hidden;
  border-radius: 15px;
  box-shadow: 0 4px 10px rgba(0,0,0,0.15);
  transition: transform 0.4s ease, box-shadow 0.4s ease;
}

.galeri-item img {
  width: 100%;
  height: 220px;
  object-fit: cover;
  transition: transform 0.4s ease;
}

.galeri-item:hover img {
  transform: scale(1.1);
}

.galeri-item:hover {
  transform: translateY(-5px);
  box-shadow: 0 8px 18px rgba(0,0,0,0.25);
}

/* ===================================================
   📍 KONTAK SECTION
   - Background dan styling umum
   =================================================== */
#kontak {
  background: #FCD5CE;
  color: white;
}

#kontak h3 {
  color:#d97706;
  margin-bottom: 20px;
}

#iframe {
  width: 100%;
  height: 500px;
  border: 0;
}

/* ===================================================
   📱 NAV PILLS (Tab Filter Menu)
   - Button filter kategori produk
   =================================================== */
.nav-pills .nav-link {
  background-color: #fff;
  color: #f7dece;
  border-radius: 30px;
  margin: 3px;
  font-weight: 500;
  transition: 0.3s;
}

.nav-pills .nav-link.active,
.nav-pills .nav-link:hover {
  background-color: #f9c9ab;
  color: #fff;
}

/* ===================================================
   🛒 CART ICON (Icon Keranjang)
   - Icon keranjang belanja
   =================================================== */
.cart-icon {
  color: #e60000;
  text-decoration: none;
  padding: 8px 12px;
  border-radius: 50px;
  background: rgba(255, 0, 0, 0.12);
  transition: background 0.3s;
}

.cart-icon:hover {
  background: rgba(255, 0, 0, 0.25);
}

.badge-cart {
  position: absolute;
  top: -6px;
  right: -6px;
  font-size: 0.7rem;
}

/* ===================================================
   🔙 BUTTON (Tombol)
   - Tombol back dan lainnya
   =================================================== */
.button {
  padding: 10px 16px;
}

.btn-back {
  position: fixed;
  top: 20px;
  left: 20px;
}

/* ===================================================
   📄 FOOTER
   - Footer bagian bawah halaman
   =================================================== */
footer {
  text-align: center;
  padding: 20px;
  background-color:  #FCD5CE;
  color: #8d4949;
  margin-top: 40px;
}

/* ===================================================
   📱 RESPONSIVE (Tablet & Mobile)
   - Styling untuk layar kecil
   =================================================== */
@media (max-width: 768px) {
  .sidebar {
    display: none;
  }
  .content {
    width: 100%;
  }
}

/* Tablet */
@media (min-width: 768px) {
  .button {
    padding: 12px 20px;
  }
}
</style>
</head>

<body>

<!-- bagian home -->
<!-- ========================================
     BAGIAN 1: HERO SECTION (Halaman Utama)
     ======================================== -->
<section id="hero" class="position-relative" style="height:100vh; overflow:visible;">
  <!-- Container untuk gambar slideshow -->
  <div class="position-absolute w-100 h-100" style="z-index:0;">
    
    <!-- Slide 1 - Gambar pertama (aktif) -->
    <img id="heroImage1" src="img/bg/bg home 1.png" 
         class="position-absolute w-100 h-100 fade-video active"
         style="object-fit: cover;" alt="Slide 1">
    
    <!-- Slide 2 - Gambar kedua -->
    <img id="heroImage2" src="img/bg/bg home 2.png"
         class="position-absolute w-100 h-100 fade-video"
         style="object-fit: cover;" alt="Slide 2">
    
    <!-- Slide 3 - Gambar ketiga -->
    <img id="heroImage3" src="img/bg/bg home 3.png"
         class="position-absolute w-100 h-100 fade-video"
         style="object-fit: cover;" alt="Slide 3">
    
    <!-- Slide 4 - Gambar keempat -->
    <img id="heroImage3" src="img/bg/bg home 4.png"
         class="position-absolute w-100 h-100 fade-video"
         style="object-fit: cover;" alt="Slide 3">
  </div>
</section>

<!-- ========================================
     BAGIAN 2: NAVIGATION BAR (Menu Navigasi)
     ======================================== -->
<nav class="navbar navbar-expand-lg fixed-top shadow-sm">
  <div class="container">
    
    <!-- Logo dan Nama Brand -->
    <a class="navbar-brand d-flex align-items-center" href="#hero">
      <img src="img/bg/logo_alfin.png" alt="Logo Puddingku" width="55" height="55" class="me-2 rounded-circle">
      <strong>PUDDINGKU</strong>
    </a>
    <!-- Tombol Toggle untuk Mobile -->
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navMenu">
      <span class="navbar-toggler-icon"></span>
    </button>
    <!-- Menu Navigasi -->
    <div class="collapse navbar-collapse justify-content-end" id="navMenu">
      <ul class="navbar-nav mb-2 mb-lg-0 fw-semibold">
        <li class="nav-item"><a class="nav-link" href="#hero">Home</a></li>
        <li class="nav-item"><a class="nav-link" href="#about">About</a></li>
        <li class="nav-item"><a class="nav-link" href="#menu">Menu</a></li>
        <li class="nav-item"><a class="nav-link" href="#ulasan">Ulasan</a></li>
        <li class="nav-item"><a class="nav-link" href="#kontak">Contact</a></li>
          <!-- Link Admin -->
    <li class="nav-item d-flex align-items-center me-3">
      <a href="login.php" class="btn btn-outline-secondary rounded-pill px-3 fw-semibold d-flex align-items-center" style="border: 2px solid #6c757d; color: #6c757d; transition: all 0.3s;">
        <i class="bi bi-person-circle me-2"></i>Admin
      </a>
    </li>
        <!-- Tombol Order Now -->
        <li class="nav-item d-flex align-items-center me-2">
          <a href="pemesanan.php" class="btn btn-danger rounded-pill px-3 fw-semibold">
            Order Now
          </a>
        </li>
      </ul>
    </div>
  </div>
</nav>

<!-- ========================================
     BAGIAN 3: ABOUT SECTION (Tentang Kami)
     ======================================== -->
<section id="about" style="background: linear-gradient(135deg, #fff7ed 0%, #ffe8d6 100%); padding: 80px 0;">
  <div class="container">
    
    <!-- Judul Section -->
    <div class="text-center mb-5" data-aos="fade-down">
      <h2 class="display-5 fw-bold" style="color: #d97706;">About PUDDINGKU</h2>
      <p class="text-muted">Cerita Manis di Balik Setiap Gigitan 🍮</p>
    </div>

    <!-- Foto Utama About -->
    <div class="text-center mb-5" data-aos="zoom-in">
      <img src="img/bg/gambar d-umkm.jpg" alt="Tentang Puddingku" 
           class="img-fluid rounded-4 shadow-lg" 
           style="border: 5px solid #fff; max-width: 600px; width: 100%;">
    </div>

    <!-- Deskripsi About -->
    <div class="row justify-content-center">
      <div class="col-lg-10" data-aos="fade-up">
        <div class="about-text-new">
          
          <!-- Judul Deskripsi -->
          <h3 class="fw-bold mb-4 text-center" style="color: #d97706;">
            <i class="bi bi-heart-fill text-danger me-2"></i>
            Kelezatan Homemade untuk Setiap Momen Spesial
          </h3>
          
          <!-- Paragraf Penjelasan -->
          <p class="lead mb-4 text-center" style="line-height: 1.8;">
            <strong>PUDDINGKU</strong> adalah UMKM yang bergerak di bidang kuliner dengan spesialisasi pada berbagai macam <strong>cake dan dessert</strong>. 
            Kami menawarkan aneka puding, kue lembut, dan hidangan manis lainnya yang dibuat dari <span class="text-danger fw-bold">bahan-bahan berkualitas</span> 
            dan rasa rumahan yang otentik.
          </p>

          <!-- Keunggulan (4 Box) -->
          <div class="row g-3 mb-4 justify-content-center">
            
            <!-- Box 1: Bahan Berkualitas -->
            <div class="col-md-3 col-6">
              <div class="text-center p-3 bg-white rounded-3 shadow-sm h-100">
                <div class="bg-warning bg-opacity-25 rounded-circle p-3 d-inline-block mb-2">
                  <i class="bi bi-check-circle-fill text-warning fs-3"></i>
                </div>
                <h6 class="fw-bold mb-1">Bahan Berkualitas</h6>
                <small class="text-muted">100% Fresh & Halal</small>
              </div>
            </div>
            
            <!-- Box 2: Rasa Otentik -->
            <div class="col-md-3 col-6">
              <div class="text-center p-3 bg-white rounded-3 shadow-sm h-100">
                <div class="bg-danger bg-opacity-25 rounded-circle p-3 d-inline-block mb-2">
                  <i class="bi bi-award-fill text-danger fs-3"></i>
                </div>
                <h6 class="fw-bold mb-1">Rasa Otentik</h6>
                <small class="text-muted">Homemade Recipe</small>
              </div>
            </div>
            
            <!-- Box 3: Perfect Gift -->
            <div class="col-md-3 col-6">
              <div class="text-center p-3 bg-white rounded-3 shadow-sm h-100">
                <div class="bg-success bg-opacity-25 rounded-circle p-3 d-inline-block mb-2">
                  <i class="bi bi-gift-fill text-success fs-3"></i>
                </div>
                <h6 class="fw-bold mb-1">Perfect Gift</h6>
                <small class="text-muted">Hampers & Events</small>
              </div>
            </div>
            
            <!-- Box 4: Tampilan Menarik -->
            <div class="col-md-3 col-6">
              <div class="text-center p-3 bg-white rounded-3 shadow-sm h-100">
                <div class="bg-info bg-opacity-25 rounded-circle p-3 d-inline-block mb-2">
                  <i class="bi bi-emoji-smile-fill text-info fs-3"></i>
                </div>
                <h6 class="fw-bold mb-1">Tampilan Menarik</h6>
                <small class="text-muted">Instagram-worthy</small>
              </div>
            </div>
          </div>

          <!-- Quote Penutup -->
          <p class="fst-italic text-muted text-center border-start border-warning border-4 ps-3 mx-auto" style="max-width: 800px;">
            "Dengan tampilan yang menarik dan cita rasa yang memanjakan lidah, 
            Puddingku menjadi pilihan tepat untuk camilan harian, hampers, 
            maupun hidangan spesial di berbagai acara."
          </p>
        </div>
      </div>
    </div>
  </div>
</section>

<!-- ========================================
     BAGIAN 4: MENU SECTION (Daftar Produk)
     ======================================== -->
<section id="menu" class="py-5" style="background-color: #f5e1de;">
  <div class="container">
    
    <!-- Judul Menu -->
    <h2 class="text-center mb-4">Menu</h2>

    <!-- Tab Kategori Menu -->
    <ul class="nav nav-pills justify-content-center mb-4" id="menuTabs">
      <li class="nav-item">
        <button class="nav-link active" data-category="all">All Menu</button>
      </li>
      <li class="nav-item">
        <button class="nav-link" data-category="best seller">Best Seller</button>
      </li>
      <li class="nav-item">
        <button class="nav-link" data-category="brownies">Brownies</button>
      </li>
      <li class="nav-item">
        <button class="nav-link" data-category="cake">Cake</button>
      </li>
      <li class="nav-item">
        <button class="nav-link" data-category="cookies">Cookies</button>
      </li>
      <li class="nav-item">
        <button class="nav-link" data-category="dessert">Dessert</button>
      </li>
      <li class="nav-item">
        <button class="nav-link" data-category="pudding">Pudding</button>
      </li>
    </ul>

    <!-- Container Daftar Produk -->
    <div class="row g-4" id="menuList">

      <!-- =====================================
           KATEGORI: BEST SELLER
           ===================================== -->
      
      <!-- Produk Best Seller 1 -->
      <div class="col-md-3 col-sm-6" data-category="best seller" data-aos="zoom-in" data-aos-delay="50">
        <div class="card h-100 shadow-sm">
          <img src="img/dessert/banafe 2.jpg" alt="Brownies Classic">
          <div class="card-body text-center">
            <h5 class="card-title">Desert box banafe</h5>
            <p class="card-text">Brownies panggang lembut dengan rasa cokelat pekat.</p>
            <p class="fw-bold text-primary">Rp20.000</p>
          </div>
        </div>
      </div>
      
      <!-- Produk Best Seller 2 -->
      <div class="col-md-3 col-sm-6" data-category="best seller" data-aos="zoom-in" data-aos-delay="60">
        <div class="card h-100 shadow-sm">
          <img src="img/cake/chocolate mouse cake.jpg" class="card-img-top" alt="Brownies Classic">
          <div class="card-body text-center">
            <h5 class="card-title">chocolate mouse cake</h5>
            <p class="card-text">Brownies panggang lembut dengan rasa cokelat pekat.</p>
            <p class="fw-bold text-primary">Rp15.000</p>
          </div>
        </div>
      </div>

      <!-- Produk Best Seller 3 -->
      <div class="col-md-3 col-sm-6" data-category="best seller" data-aos="zoom-in" data-aos-delay="70">
        <div class="card h-100 shadow-sm">
          <img src="img/dessert/milk bun.jpg" class="card-img-top" alt="Brownies Classic">
          <div class="card-body text-center">
            <h5 class="card-title">milk bun</h5>
            <p class="card-text">Brownies panggang lembut dengan rasa cokelat pekat.</p>
            <p class="fw-bold text-primary">Rp15.000</p>
          </div>
        </div>
      </div>

      <!-- Produk Best Seller 4 -->
      <div class="col-md-3 col-sm-6" data-category="best seller" data-aos="zoom-in" data-aos-delay="80">
        <div class="card h-100 shadow-sm">
          <img src="img/pudding/silky pudding_mango.jpg" class="card-img-top" alt="Brownies Classic">
          <div class="card-body text-center">
            <h5 class="card-title">mango silky pudding</h5>
            <p class="card-text">Brownies panggang lembut dengan rasa cokelat pekat.</p>
            <p class="fw-bold text-primary">Rp15.000</p>
          </div>
        </div>
      </div>

      <!-- =====================================
           KATEGORI: BROWNIES
           ===================================== -->
      
      <!-- Produk Brownies 1 -->
      <div class="col-md-3 col-sm-6" data-category="brownies">
        <div class="card h-100 shadow-sm">
          <img src="img/brownies/brownie burnt cheese cake.jpg" class="card-img-top" alt="Brownies">
          <div class="card-body text-center">
            <h5 class="card-title">Brownie Burnt Cheese Cake</h5>
            <p class="card-text">Brownies cokelat dengan lapisan burnt cheesecake yang creamy dan sedikit gurih. Teksturnya lembut di dalam dengan aroma kkeju panggang yang menggoda.</p>
            <p class="fw-bold text-primary">Rp15.000</p>
          </div>
        </div>
      </div>

      <!-- Produk Brownies 2 -->
      <div class="col-md-3 col-sm-6" data-category="brownies">
        <div class="card h-100 shadow-sm">
          <img src="img/brownies/browkies.jpg" class="card-img-top" alt="Brownies">
          <div class="card-body text-center">
            <h5 class="card-title">Browkies</h5>
            <p class="card-text">Kombinasi sempurna antara brownie fudgy dan cookies renyah, menghasilkan camilan manis yang rich, chewy, dan penuh cita rasa cokelat.</p>
            <p class="fw-bold text-primary">Rp12.000</p>
          </div>
        </div>
      </div>

      <!-- Produk Brownies 3 -->
      <div class="col-md-3 col-sm-6" data-category="brownies">
        <div class="card h-100 shadow-sm">
          <img src="img/brownies/brownies bites.jpg" class="card-img-top" alt="Brownies">
          <div class="card-body text-center">
            <h5 class="card-title">Brownies Bites</h5>
            <p class="card-text">Potongan kecil brownies panggang dengan rasa cokelat yang pekat dan tekstur fudgy.</p>
            <p class="fw-bold text-primary">Rp15.000</p>
          </div>
        </div>
      </div>

      <!-- =====================================
           KATEGORI: CAKE (12 Produk)
           ===================================== -->
      
      <!-- Produk Cake 1: Blueberry Mouse -->
      <div class="col-md-3 col-sm-6" data-category="cake">
        <div class="card h-100 shadow-sm">
          <img src="img/cake/blueberry mouse.jpg" class="card-img-top" alt="Cake">
          <div class="card-body text-center">
            <h5 class="card-title">Blueberry Mouse</h5>
            <p class="card-text">Kue lembut dengan lapisan mousse blueberry yang manis dan sedikit asam, berpadu  dengan base brownies cokelat yang rich.</p>
            <p class="fw-bold text-primary">Rp15.000</p>
          </div>
        </div>
      </div>

      <!-- Produk Cake 2: Chocolate Mouse Cake -->
      <div class="col-md-3 col-sm-6" data-category="cake">
        <div class="card h-100 shadow-sm">
          <img src="img/cake/chocolate mouse cake.jpg" class="card-img-top" alt="Cake">
          <div class="card-body text-center">
            <h5 class="card-title">Chocolate Mouse Cake</h5>
            <p class="card-text">Kue lembut dengan lapisan mouse cokelat yang manis dan berpadu dengan base cokelat yang rich.</p>
            <p class="fw-bold text-primary">Rp15.000</p>
          </div>
        </div>
      </div>

      <!-- Produk Cake 3: Cookies and Cream Mouse -->
      <div class="col-md-3 col-sm-6" data-category="cake">
        <div class="card h-100 shadow-sm">
          <img src="img/cake/cookies&cream mouse.jpg" class="card-img-top" alt="Cake">
          <div class="card-body text-center">
            <h5 class="card-title">Cookies and Cream Mouse</h5>
            <p class="card-text">Perpaduan mouse vanilla lembut dengan remahan biskuit cokelat yang renyah, disajikan diatas base brownies yang rich.</p>
            <p class="fw-bold text-primary">Rp15.000</p>
          </div>
        </div>
      </div>

      <!-- Produk Cake 4: Mango Mouse Cake -->
      <div class="col-md-3 col-sm-6" data-category="cake">
        <div class="card h-100 shadow-sm">
          <img src="img/cake/mouse cake manggo.jpg" class="card-img-top" alt="Cake">
          <div class="card-body text-center">
            <h5 class="card-title">Mango Mouse Cake</h5>
            <p class="card-text">Kue lembut dengan lapisan mouse mango yang manis, berpadu dengan base brownies cokelat yang rich.</p>
            <p class="fw-bold text-primary">Rp15.000</p>
          </div>
        </div>
      </div>

      <!-- Produk Cake 5: Matcha Mouse Cake -->
      <div class="col-md-3 col-sm-6" data-category="cake">
        <div class="card h-100 shadow-sm">
          <img src="img/cake/matcha mouse cake.jpg" class="card-img-top" alt="Cake">
          <div class="card-body text-center">
            <h5 class="card-title">Matcha Mouse Cake</h5>
            <p class="card-text">Mouse lembut dengan aroma khas matcha premium, berpadu dengan base brownies cokelat yang rich. Perpaduan rasa manis, pahit, dan creamy.</p>
            <p class="fw-bold text-primary">Rp15.000</p>
          </div>
        </div>
      </div>

      <!-- Produk Cake 6: Peach Mouse Cake -->
      <div class="col-md-3 col-sm-6" data-category="cake">
        <div class="card h-100 shadow-sm">
          <img src="img/cake/peach mouse cake.jpg" class="card-img-top" alt="Cake">
          <div class="card-body text-center">
            <h5 class="card-title">Peach Mouse Cake</h5>
            <p class="card-text">Mouse lembut dengan rasa peach yang manis dan segar, berpadu dengan base brownies cokelat yang rich.</p>
            <p class="fw-bold text-primary">Rp15.000</p>
          </div>
        </div>
      </div>

      <!-- Produk Cake 7: Choco Short Cake 10 cm -->
      <div class="col-md-3 col-sm-6" data-category="cake">
        <div class="card h-100 shadow-sm">
          <img src="img/cake/choco short cake.jpg" class="card-img-top" alt="Cake">
          <div class="card-body text-center">
            <h5 class="card-title">Choco Short Cake 10 cm</h5>
            <p class="card-text">Kue lembut berlapis krim cokelat yang manis dan legit, dihiasi potongan cokelat di atasnya, cocok untuk pecinta rasa cokelat klasik.</p>
            <p class="fw-bold text-primary">Rp50.000</p>
          </div>
        </div>
      </div>

      <!-- Produk Cake 8: Strawberry Mouse Cake (dari strawberri mpuse cake.jpg) -->
      <div class="col-md-3 col-sm-6" data-category="cake">
        <div class="card h-100 shadow-sm">
          <img src="img/cake/strawberri mpuse cake.jpg" class="card-img-top" alt="Cake">
          <div class="card-body text-center">
            <h5 class="card-title">Strawberry Short Cake</h5>
            <p class="card-text">Kue ringan dengan lapisan mouse strawberry yang lembut dan creamy, berpadu dengan aroma buah strawberry segar yang menyegarkan.</p>
            <p class="fw-bold text-primary">Rp15.000</p>
          </div>
        </div>
      </div>

      <!-- Produk Cake 9: Strawberry Petite Cake -->
      <div class="col-md-3 col-sm-6" data-category="cake">
        <div class="card h-100 shadow-sm">
          <img src="img/cake/strawberry petite cake.jpg" class="card-img-top" alt="Cake">
          <div class="card-body text-center">
            <h5 class="card-title">Strawberry Mouse Cake</h5>
            <p class="card-text">Kue mini bertekstur lembut dengan topping krim dan potongan strawberry segar, tampil canitk dan manis dalam ukuran mungil.</p>
            <p class="fw-bold text-primary">Rp15.000</p>
          </div>
        </div>
      </div>

      <!-- Produk Cake 10: Strawberry Short Cake 10 cm -->
      <div class="col-md-3 col-sm-6" data-category="cake">
        <div class="card h-100 shadow-sm">
          <img src="img/cake/strawberry short cake.jpg" class="card-img-top" alt="Cake">
          <div class="card-body text-center">
            <h5 class="card-title">Strawberry Short Cake 10 cm</h5>
            <p class="card-text">Kue sponge lembut berlapis krim vanilla dan potongan strawberry  segar, menghadirkan cita rasa manis dan segar yang seimbang.</p>
            <p class="fw-bold text-primary">Rp50.000</p>
          </div>
        </div>
      </div>

      <!-- Produk Cake 11: Taro Mouse Cake -->
      <div class="col-md-3 col-sm-6" data-category="cake">
        <div class="card h-100 shadow-sm">
          <img src="img/cake/taro mouse cake.jpg" class="card-img-top" alt="Cake">
          <div class="card-body text-center">
            <h5 class="card-title">Taro Mouse Cake</h5>
            <p class="card-text">Kue mouse berwarna ungu lembut dengan rasa talas yang khas, creamy, dan wangi, memberikan sensasi lembut di setiap gigitan.</p>
            <p class="fw-bold text-primary">Rp15.000</p>
          </div>
        </div>
      </div>

      <!-- Produk Cake 12: Tiramisu Mouse Cake -->
      <div class="col-md-3 col-sm-6" data-category="cake">
        <div class="card h-100 shadow-sm">
          <img src="img/cake/tiramisu mouse cake.jpg" class="card-img-top" alt="Cake">
          <div class="card-body text-center">
            <h5 class="card-title">Tiramisu Mouse Cake</h5>
            <p class="card-text">Perpaduan mouse kopi dan krim keju mascarpone yang lembut, berpadu dengan taburan bubuk kakao diatasnya untuk rasa torasmisu yang elegan.</p>
            <p class="fw-bold text-primary">Rp15.000</p>
          </div>
        </div>
      </div>

      <!-- =====================================
           KATEGORI: COOKIES (5 Produk)
           ===================================== -->
      
      <!-- Produk Cookies 1: Choco Chips Cookies -->
      <div class="col-md-3 col-sm-6" data-category="cookies">
        <div class="card h-100 shadow-sm">
          <img src="img/cookies/cookies_chococips.jpg" class="card-img-top" alt="Choco Chips Cookies">
          <div class="card-body text-center">
            <h5 class="card-title">Choco Chips Cookies</h5>
            <p class="card-text">Kue kering klasik yang renyahdi luar dan lembut di dalam, dipenuhi potongan cokelat chips yang manis dan lumer di mulut.</p>
            <p class="fw-bold text-primary">Rp5.000</p>
          </div>
        </div>
      </div>

      <!-- Produk Cookies 2: Cookies Oatmilk -->
      <div class="col-md-3 col-sm-6" data-category="cookies">
        <div class="card h-100 shadow-sm">
          <img src="img/cookies/cookies_oatmilk.jpg" class="card-img-top" alt="Cookies">
          <div class="card-body text-center">
            <h5 class="card-title">Cookies Oatmilk</h5>
            <p class="card-text">Cookies sehat berbahan oat dan susu, bertekstur lembut dengan rasa gurih dan manis yang seimbang, cocok untuk camilan ringan.</p>
            <p class="fw-bold text-primary">Rp5.000</p>
          </div>
        </div>
      </div>

      <!-- Produk Cookies 3: Cookies Oreo -->
      <div class="col-md-3 col-sm-6" data-category="cookies">
        <div class="card h-100 shadow-sm">
          <img src="img/cookies/cookies_oreo.jpg" class="card-img-top" alt="Cookies">
          <div class="card-body text-center">
            <h5 class="card-title">Cookies Oreo</h5>
            <p class="card-text">Perpaduan adonan cookies lembut dengan remahan oreo didalamanya, memberikam rasa cokelat khas dan tekstur yang unik.</p>
            <p class="fw-bold text-primary">Rp5.000</p>
          </div>
        </div>
      </div>

      <!-- Produk Cookies 4: Cookies Chocolate -->
      <div class="col-md-3 col-sm-6" data-category="cookies">
        <div class="card h-100 shadow-sm">
          <img src="img/cookies/coookies_chocolate.jpg" class="card-img-top" alt="Cookies">
          <div class="card-body text-center">
            <h5 class="card-title">Cookies chocolate</h5>
            <p class="card-text">Cookies vokelat penuh cita rasa, dibuat dengan adonan cokelat pekat yang manis dan sedikit pahit, sempurna untuk pecinta cokelat sejati.</p>
            <p class="fw-bold text-primary">Rp5.000</p>
          </div>
        </div>
      </div>

      <!-- Produk Cookies 5: Cookies Redvelvet -->
      <div class="col-md-3 col-sm-6" data-category="cookies">
        <div class="card h-100 shadow-sm">
          <img src="img/cookies/redvelvet.jpg" class="card-img-top" alt="Cookies">
          <div class="card-body text-center">
            <h5 class="card-title">Cookies Redvelvet</h5>
            <p class="card-text">Cookies berwarna merah lembut dengan cita rasa khas red velvet, berpadu dengan potongan white chocolate yang menambah kelezatan.</p>
            <p class="fw-bold text-primary">Rp5.000</p>
          </div>
        </div>
      </div>

      <!-- =====================================
           KATEGORI: DESSERT (9 Produk)
           ===================================== -->
      
      <!-- Produk Dessert 1: Desert box banafe (sudah ada di Best Seller, tapi tetap ditampilkan di Dessert) -->
      <div class="col-md-3 col-sm-6" data-category="dessert">
        <div class="card h-100 shadow-sm">
          <img src="img/dessert/banafe 2.jpg" class="card-img-top" alt="dessert">
          <div class="card-body text-center">
            <h5 class="card-title">Desert box banafe</h5>
            <p class="card-text">Brownies panggang lembut dengan rasa cokelat pekat.</p>
            <p class="fw-bold text-primary">Rp20.000</p>
          </div>
        </div>
      </div>

      <!-- Produk Dessert 2: Death by Chocolate -->
      <div class="col-md-3 col-sm-6" data-category="dessert">
        <div class="card h-100 shadow-sm">
          <img src="img/dessert/death by chocolate.jpg" class="card-img-top" alt="dessert">
          <div class="card-body text-center">
            <h5 class="card-title">Death by Chocolate</h5>
            <p class="card-text">Dessert cokelat premium dengan lapisan mousse lembut, brownie rich, dan saus cokelat pekat yang memanjakan lidah. Cocok untuk pecinta cokelat sejati.</p>
            <p class="fw-bold text-primary">Rp18.000</p>
          </div>
        </div>
      </div>

      <!-- Produk Dessert 3: Cheese Cuit Strawberry -->
      <div class="col-md-3 col-sm-6" data-category="dessert">
        <div class="card h-100 shadow-sm">
          <img src="img/dessert/cheese cuit strawberry.jpg" class="card-img-top" alt="dessert">
          <div class="card-body text-center">
            <h5 class="card-title">Cheese Cuit Strawberry</h5>
            <p class="card-text">Lapisan crepes tipis berpadu cream vanilla dan potongan strawberry, menghasilkan rasa manis segar yang ringan dan elegan.</p>
            <p class="fw-bold text-primary">Rp18.000</p>
          </div>
        </div>
      </div>

      <!-- Produk Dessert 4: Dessert Box Keju -->
      <div class="col-md-3 col-sm-6" data-category="dessert">
        <div class="card h-100 shadow-sm">
          <img src="img/dessert/dessert box keju.jpg" class="card-img-top" alt="dessert">
          <div class="card-body text-center">
            <h5 class="card-title">Dessert Box Keju</h5>
            <p class="card-text">Lapisan crepes tipis berpadu cream vanilla dan potongan strawberry, menghasilkan rasa manis segar yang ringan dan elegan.</p>
            <p class="fw-bold text-primary">Rp20.000</p>
          </div>
        </div>
      </div>

      <!-- Produk Dessert 5: Milk Bath Chocolate -->
      <div class="col-md-3 col-sm-6" data-category="dessert">
        <div class="card h-100 shadow-sm">
          <img src="img/dessert/milk bath dessert box chocolate.jpg" class="card-img-top" alt="dessert">
          <div class="card-body text-center">
            <h5 class="card-title">Milk Bath Chocolate</h5>
            <p class="card-text">Dessert lembut berbalut saus susu cokelat yang creamy, manis, dan meleleh di mulut, ideal untuk pencinta cokelat.</p>
            <p class="fw-bold text-primary">Rp20.000</p>
          </div>
        </div>
      </div>

      <!-- Produk Dessert 6: Milk Bath Keju -->
      <div class="col-md-3 col-sm-6" data-category="dessert">
        <div class="card h-100 shadow-sm">
          <img src="img/dessert/milk bath dessert box.jpg" class="card-img-top" alt="dessert">
          <div class="card-body text-center">
            <h5 class="card-title">Milk Bath Keju</h5>
            <p class="card-text">Cake lembut yang direndam saus susu keju creamy, memberikan sensasi manis–gurih yang lembut dan menyegarkan.</p>
            <p class="fw-bold text-primary">Rp20.000</p>
          </div>
        </div>
      </div>

      <!-- Produk Dessert 7: Milk Bun (sudah ada di Best Seller) -->
      <div class="col-md-3 col-sm-6" data-category="dessert">
        <div class="card h-100 shadow-sm">
          <img src="img/dessert/milk bun.jpg" class="card-img-top" alt="dessert">
          <div class="card-body text-center">
            <h5 class="card-title">Milk Bun</h5>
            <p class="card-text">Roti lembut berisi cream susu manis yang creamy dan ringan, cocok untuk camilan praktis sepanjang hari.</p>
            <p class="fw-bold text-primary">Rp20.000</p>
          </div>
        </div>
      </div>

      <!-- Produk Dessert 8: Mille Crepes Chocolate -->
      <div class="col-md-3 col-sm-6" data-category="dessert">
        <div class="card h-100 shadow-sm">
          <img src="img/dessert/mille crepes chocolate.jpg" class="card-img-top" alt="dessert">
          <div class="card-body text-center">
            <h5 class="card-title">Mille Crepes Chocolate</h5>
            <p class="card-text">Tumpukan crepes tipis dengan lapisan cream cokelat lembut, menghasilkan tekstur halus dan rasa cokelat yang premium.</p>
            <p class="fw-bold text-primary">Rp20.000</p>
          </div>
        </div>
      </div>

      <!-- Produk Dessert 9: Mille Crepes Strawberry -->
      <div class="col-md-3 col-sm-6" data-category="dessert">
        <div class="card h-100 shadow-sm">
          <img src="img/dessert/mille crepes strawberry.jpg" class="card-img-top" alt="dessert">
          <div class="card-body text-center">
            <h5 class="card-title">Mille Crepes Strawberry</h5>
            <p class="card-text">Lapisan crepes tipis berpadu cream vanilla dan potongan strawberry, menghasilkan rasa manis segar yang ringan dan elegan.</p>
            <p class="fw-bold text-primary">Rp20.000</p>
          </div>
        </div>
      </div>

      <!-- =====================================
           KATEGORI: PUDDING (14 Produk)
           ===================================== -->
      
      <!-- Produk Pudding 1: Mango Vla Cheese -->
      <div class="col-md-3 col-sm-6" data-category="pudding">
        <div class="card h-100 shadow-sm">
          <img src="img/pudding/Manggo Vla Cheese.jpg" class="card-img-top" alt="pudding">
          <div class="card-body text-center">
            <h5 class="card-title">Mango Vla Cheese</h5>
            <p class="card-text">Dessert segar dengan kombinasi mangga manis, vla lembut, dan cream cheese creamy yang menghadirkan perpaduan rasa manis–asam yang harmonis.</p>
            <p class="fw-bold text-primary">Rp10.000</p>
          </div>
        </div>
      </div>

      <!-- Produk Pudding 2: Jerry Cheese Pudding -->
      <div class="col-md-3 col-sm-6" data-category="pudding">
        <div class="card h-100 shadow-sm">
          <img src="img/pudding/jerry cheese pudding.jpg" class="card-img-top" alt="pudding">
          <div class="card-body text-center">
            <h5 class="card-title">Jerry  Cheese Pudding</h5>
            <p class="card-text">Pudding lembut dengan rasa keju creamy yang gurih manis, terinspirasi dari keju favorit si Jerry! </p>
            <p class="fw-bold text-primary">Rp10.000</p>
          </div>
        </div>
      </div>

      <!-- Produk Pudding 3: Jiggly Pudding Rabbit -->
      <div class="col-md-3 col-sm-6" data-category="pudding">
        <div class="card h-100 shadow-sm">
          <img src="img/pudding/jiggly pudding rabbit.jpg" class="card-img-top" alt="pudding">
          <div class="card-body text-center">
            <h5 class="card-title">Jiggly Pudding Rabbit</h5>
            <p class="card-text">Pudding kenyal dan bergetar lucu berbentuk kelinci, manis dan lembut setiap gigitannya. </p>
            <p class="fw-bold text-primary">Rp10.000</p>
          </div>
        </div>
      </div>

      <!-- Produk Pudding 4: Rainbow Petite Pudding -->
      <div class="col-md-3 col-sm-6" data-category="pudding">
        <div class="card h-100 shadow-sm">
          <img src="img/pudding/rainbow petite pudding.jpg" class="card-img-top" alt="pudding">
          <div class="card-body text-center">
            <h5 class="card-title">Rainbow Petite Pudding</h5>
            <p class="card-text">Pudding mini berlapis warna-warni ceria dengan rasa manis lembut yang menyenangkan. </p>
            <p class="fw-bold text-primary">Rp12.000</p>
          </div>
        </div>
      </div>

      <!-- Produk Pudding 5: Silky Pudding Banana -->
      <div class="col-md-3 col-sm-6" data-category="pudding">
        <div class="card h-100 shadow-sm">
          <img src="img/pudding/silky pudding banana.jpg" class="card-img-top" alt="pudding">
          <div class="card-body text-center">
            <h5 class="card-title">Silky Pudding Banana</h5>
            <p class="card-text">Pudding halus dengan aroma pisang manis dan tekstur lembut yang memanjakan lidah. </p>
            <p class="fw-bold text-primary">Rp4.000</p>
          </div>
        </div>
      </div>

      <!-- Produk Pudding 6: Silky Pudding Leci -->
      <div class="col-md-3 col-sm-6" data-category="pudding">
        <div class="card h-100 shadow-sm">
          <img src="img/pudding/silky pudding leci.jpg" class="card-img-top" alt="Pudding">
          <div class="card-body text-center">
            <h5 class="card-title">Silky Pudding Leci</h5>
            <p class="card-text">Pudding lembut berpadu rasa leci segar yang manis dan wangi alami.</p>
            <p class="fw-bold text-primary">Rp4.000</p>
          </div>
        </div>
      </div>

      <!-- Produk Pudding 7: Silky Pudding Matcha -->
      <div class="col-md-3 col-sm-6" data-category="pudding">
        <div class="card h-100 shadow-sm">
          <img src="img/pudding/silky pudding matcha.jpg" class="card-img-top" alt="Pudding">
          <div class="card-body text-center">
            <h5 class="card-title">Silky Pudding Matcha</h5>
            <p class="card-text">Pudding halus beraroma matcha premium dengan rasa manis sedikit pahit yang menenangkan.</p>
            <p class="fw-bold text-primary">Rp4.000</p>
          </div>
        </div>
      </div>

      <!-- Produk Pudding 8: Silky Pudding Strawberry -->
      <div class="col-md-3 col-sm-6" data-category="pudding">
        <div class="card h-100 shadow-sm">
          <img src="img/pudding/silky pudding strawberry.jpg" class="card-img-top" alt="Pudding">
          <div class="card-body text-center">
            <h5 class="card-title">Silky Pudding Strawberry</h5>
            <p class="card-text">Pudding lembut berkrim dengan rasa stroberi manis dan segar di setiap suapan. </p>
            <p class="fw-bold text-primary">Rp4.000</p>
          </div>
        </div>
      </div>

      <!-- Produk Pudding 9: Silky Pudding Taro -->
      <div class="col-md-3 col-sm-6" data-category="pudding">
        <div class="card h-100 shadow-sm">
          <img src="img/pudding/silky pudding taro.jpg" class="card-img-top" alt="Pudding">
          <div class="card-body text-center">
            <h5 class="card-title">Silky Pudding Taro</h5>
            <p class="card-text">Pudding halus rasa taro yang creamy dan lembut dengan warna ungu cantik. </p>
            <p class="fw-bold text-primary">Rp4.000</p>
          </div>
        </div>
      </div>

      <!-- Produk Pudding 10: Silky Pudding Chocolate -->
      <div class="col-md-3 col-sm-6" data-category="pudding">
        <div class="card h-100 shadow-sm">
          <img src="img/pudding/silky pudding_chocolate.jpg" class="card-img-top" alt="Pudding">
          <div class="card-body text-center">
            <h5 class="card-title">Silky Pudding Chocolate</h5>
            <p class="card-text">Pudding lembut penuh cita rasa cokelat pekat yang manis dan memanjakan. </p>
            <p class="fw-bold text-primary">Rp4.000</p>
          </div>
        </div>
      </div>

      <!-- Produk Pudding 11: Silky Pudding Mango (sudah ada di Best Seller) -->
      <div class="col-md-3 col-sm-6" data-category="pudding">
        <div class="card h-100 shadow-sm">
          <img src="img/pudding/silky pudding_mango.jpg" class="card-img-top" alt="Pudding">
          <div class="card-body text-center">
            <h5 class="card-title">Silky Pudding Mango</h5>
            <p class="card-text">Pudding halus dengan rasa mangga tropis yang manis segar dan lembut di mulut. </p>
            <p class="fw-bold text-primary">Rp4.000</p>
          </div>
        </div>
      </div>

      <!-- Produk Pudding 11: Silky Pudding bubble gum (sudah ada di Best Seller) -->
      <div class="col-md-3 col-sm-6" data-category="pudding">
        <div class="card h-100 shadow-sm">
          <img src="img/pudding/silky pudiing_bubble gum.jpg" class="card-img-top" alt="Pudding">
          <div class="card-body text-center">
            <h5 class="card-title">Silky Pudding Bubble Gum</h5>
            <p class="card-text">Pudding halus dengan rasa mangga tropis yang manis segar dan lembut di mulut. </p>
            <p class="fw-bold text-primary">Rp4.000</p>
          </div>
        </div>
      </div>div>

      <!-- Produk Pudding 13: Tosuni Jiggly Pudding -->
      <div class="col-md-3 col-sm-6" data-category="pudding">
        <div class="card h-100 shadow-sm">
          <img src="img/pudding/tosuni jiggly  pudding.jpg" class="card-img-top" alt="Pudding">
          <div class="card-body text-center">
            <h5 class="card-title">Tosuni Jiggly Pudding</h5>
            <p class="card-text">Pudding kenyal dan menggemaskan ala Tosuni, bergetar lembut dengan rasa manis yang pas.</p>
            <p class="fw-bold text-primary">Rp13.000</p>
          </div>
        </div>
      </div>

      <!-- Produk Pudding 14: Tripple Choco Pudding -->
      <div class="col-md-3 col-sm-6" data-category="pudding">
        <div class="card h-100 shadow-sm">
          <img src="img/pudding/tripple choco pudding cup.jpg" class="card-img-top" alt="Pudding">
          <div class="card-body text-center">
            <h5 class="card-title">Tripple Choco Pudding</h5>
            <p class="card-text">Pudding cokelat tiga lapis — dark, milk, dan white chocolate — dalam satu dessert mewah yang super cokelat!</p>
            <p class="fw-bold text-primary">Rp8.000</p>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>

<!-- ========================================
     BAGIAN 1: SCRIPT FILTER MENU
     Fungsi: Untuk memfilter produk berdasarkan kategori yang dipilih
     ======================================== -->
<script>
  // Ambil semua tombol kategori (All Menu, Best Seller, Brownies, dll)
  const buttons = document.querySelectorAll('#menuTabs .nav-link');
  
  // Ambil semua card produk
  const menuItems = document.querySelectorAll('#menuList > div.col-md-3');

  // Loop untuk setiap tombol
  buttons.forEach(btn => {
    // Saat tombol diklik
    btn.addEventListener('click', () => {
      // Hapus class 'active' dari semua tombol
      buttons.forEach(b => b.classList.remove('active'));
      
      // Tambah class 'active' ke tombol yang diklik
      btn.classList.add('active');

      // Ambil kategori dari tombol yang diklik (misal: 'cake', 'brownies')
      const category = btn.getAttribute('data-category');
      
      // Loop untuk setiap produk
      menuItems.forEach(item => {
        const itemCategory = item.getAttribute('data-category');
        
        // Jika kategori 'all' atau kategori cocok, tampilkan produk
        if (category === 'all' || category === itemCategory) {
          item.style.display = 'block';
        } else {
          // Jika tidak cocok, sembunyikan produk
          item.style.display = 'none';
        }
      });
    });
  });
</script>

<!-- Styling untuk animasi smooth saat filter -->
<style>
  #menuList .col-md-3 {
    transition: all 0.4s ease; /* Animasi halus 0.4 detik */
  }
</style>

<!-- ========================================
     BAGIAN 2: SECTION ULASAN PELANGGAN
     Menggunakan Swiper JS untuk slider/carousel
     ======================================== -->

<!-- Link CSS dan JS Swiper dari CDN -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css"/>
<script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>

<!-- STYLING UNTUK ULASAN -->
<style>
/* === STYLE SECTION ULASAN === */
#ulasan {
  background-color: #f8dcdc; /* Warna background pink muda */
}

#ulasan .judul-section {
  font-weight: 700; /* Tebal */
  font-family: 'Poppins', sans-serif;
}

/* Container Swiper */
.mySwiper {
  width: 100%;
  padding: 40px 0 60px; /* Padding atas 40px, bawah 60px */
}

/* Setiap slide dalam Swiper */
.swiper-slide {
  display: flex;
  justify-content: center; /* Tengahkan konten */
  transition: transform 0.4s ease; /* Animasi smooth */
}

/* Kartu ulasan (card) */
.card-ulasan {
  background-color: #fff; /* Background putih */
  border-radius: 20px; /* Sudut melengkung */
  overflow: hidden; /* Gambar tidak keluar dari card */
  box-shadow: 0 4px 15px rgba(0,0,0,0.1); /* Bayangan lembut */
  transition: transform 0.4s ease, box-shadow 0.4s ease;
  width: 250px; /* Lebar card */
  height: 280px; /* Tinggi card */
}

/* Gambar dalam card */
.card-ulasan img {
  width: 100%;
  height: 100%;
  object-fit: cover; /* Gambar memenuhi card */
  border-radius: 20px;
  transition: transform 0.6s ease;
}

/* Efek ZOOM saat hover (arahkan mouse) */
.card-ulasan:hover img {
  transform: scale(1.25); /* Perbesar 125% */
}

/* Efek ZOOM BESAR pada slide yang AKTIF (di tengah) */
.swiper-slide-active .card-ulasan {
  transform: scale(1.25); /* Perbesar slide tengah */
  box-shadow: 0 10px 35px rgba(0,0,0,0.25); /* Bayangan lebih gelap */
  z-index: 2; /* Tampil di depan slide lain */
}

/* Efek pada slide SAMPING kiri/kanan */
.swiper-slide-next .card-ulasan,
.swiper-slide-prev .card-ulasan {
  transform: scale(1.05); /* Perbesar sedikit */
  opacity: 0.9; /* Sedikit transparan */
}

/* Tombol "Rating" pojok kanan atas */
.btn-ulasan {
  background-color: #e60000; /* Merah */
  color: white;
  padding: 8px 14px;
  border-radius: 30px; /* Bulat penuh */
  font-weight: 500;
  text-decoration: none; /* Hilangkan garis bawah */
  transition: background-color 0.3s;
}

.btn-ulasan:hover {
  background-color: rgba(255, 0, 0, 0.12); /* Merah lebih terang saat hover */
  color: #fff;
}

/* Tombol panah navigasi (kiri/kanan) */
.swiper-button-prev,
.swiper-button-next {
  color: #ff7676; /* Warna pink */
  transition: color 0.3s;
}

.swiper-button-prev:hover,
.swiper-button-next:hover {
  color: #ff5c5c; /* Lebih gelap saat hover */
}

/* === TITIK PAGINATION (indikator slide di bawah) === */
.swiper-pagination {
  position: relative;
  margin-top: 75px; /* Jarak dari gambar ke titik */
}

/* Setiap titik bulat */
.swiper-pagination-bullet {
  background: #ff7676; /* Warna pink */
  opacity: 0.4; /* Transparan untuk titik tidak aktif */
  width: 10px;
  height: 10px;
  transition: all 0.3s ease;
  margin: 0 6px !important; /* Jarak antar titik */
}

/* Titik yang AKTIF (slide saat ini) */
.swiper-pagination-bullet-active {
  opacity: 1; /* Tidak transparan */
  transform: scale(1.4); /* Perbesar 140% */
  background: #ff5c5c; /* Warna lebih gelap */
}

/* Update padding Swiper */
.mySwiper {
  width: 100%;
  padding: 10px 0 10px; /* Padding lebih kecil */
}
</style>

<!-- HTML SECTION ULASAN -->
<section id="ulasan" class="py-5 position-relative" style="background-color:#FDD5CF;">
  
  <!-- Tombol Rating pojok kanan atas -->
  <a href="ulasan.php" class="btn-ulasan position-absolute top-0 end-0 m-3">
    <i class="bi bi-plus-circle me-1"></i> Rating
  </a>

  <div class="container text-center">
    <!-- Judul Section -->
    <h2 class="judul-section mb-2">Ulasan Pelanggan</h2>
    <p class="mb-5">Review Jujur Oleh Pelanggan ☕</p>

    <!-- Swiper Container -->
    <div class="swiper mySwiper">
      <div class="swiper-wrapper">

        <!-- Slide 1 -->
        <div class="swiper-slide">
          <div class="card-ulasan">
            <img src="img/ulasan/ulasan1.png" alt="Ulasan 1">
          </div>
        </div>

        <!-- Slide 2 -->
        <div class="swiper-slide">
          <div class="card-ulasan">
            <img src="img/ulasan/ulasan2.png" alt="Ulasan 2">
          </div>
        </div>

        <!-- Slide 3 -->
        <div class="swiper-slide">
          <div class="card-ulasan">
            <img src="img/ulasan/ulasan3.png" alt="Ulasan 3">
          </div>
        </div>

        <!-- Slide 4 -->
        <div class="swiper-slide">
          <div class="card-ulasan">
            <img src="img/ulasan/ulasan4.png" alt="Ulasan 4">
          </div>
        </div>

        <!-- Slide 5 -->
        <div class="swiper-slide">
          <div class="card-ulasan">
            <img src="img/ulasan/ulasan5.png" alt="Ulasan 5">
          </div>
        </div>

        <!-- Slide 6 -->
        <div class="swiper-slide">
          <div class="card-ulasan">
            <img src="img/ulasan/ulasan6.png" alt="Ulasan 6">
          </div>
        </div>

        <!-- Slide 7 -->
        <div class="swiper-slide">
          <div class="card-ulasan">
            <img src="img/ulasan/ulasan7.png" alt="Ulasan 7">
          </div>
        </div>

        <!-- Slide 8 -->
        <div class="swiper-slide">
          <div class="card-ulasan">
            <img src="img/ulasan/ulasan8.png" alt="Ulasan 8">
          </div>
        </div>

        <!-- Slide 9 -->
        <div class="swiper-slide">
          <div class="card-ulasan">
            <img src="img/ulasan/ulasan9.png" alt="Ulasan 9">
          </div>
        </div>

        <!-- Slide 10 -->
        <div class="swiper-slide">
          <div class="card-ulasan">
            <img src="img/ulasan/ulasan10.png" alt="Ulasan 10">
          </div>
        </div>

        <!-- Slide 11 -->
        <div class="swiper-slide">
          <div class="card-ulasan">
            <img src="img/ulasan/ulasan11.png" alt="Ulasan 11">
          </div>
        </div>

      </div>

      <!-- Tombol Navigasi Kiri/Kanan -->
      <div class="swiper-button-prev"></div>
      <div class="swiper-button-next"></div>

      <!-- Titik Pagination -->
      <div class="swiper-pagination"></div>
    </div>
  </div>
</section>

<!-- SCRIPT INISIALISASI SWIPER -->
<script>
  var swiper = new Swiper(".mySwiper", {
    slidesPerView: 3,        // Tampilkan 3 slide sekaligus (desktop)
    spaceBetween: 30,        // Jarak antar slide 30px
    centeredSlides: true,    // Slide aktif di tengah
    loop: true,              // Loop terus menerus
    speed: 900,              // Kecepatan transisi 900ms
    grabCursor: true,        // Cursor jadi "grab" saat hover
    
    // Tombol navigasi
    navigation: {
      nextEl: ".swiper-button-next",  // Tombol next
      prevEl: ".swiper-button-prev",  // Tombol prev
    },
    
    // Pagination (titik indikator)
    pagination: {
      el: ".swiper-pagination",
      clickable: true,   // Titik bisa diklik untuk pindah slide
    },
    
    // Responsive: ubah jumlah slide per view berdasarkan ukuran layar
    breakpoints: {
      0: { slidesPerView: 1 },      // Mobile: 1 slide
      768: { slidesPerView: 2 },    // Tablet: 2 slide
      992: { slidesPerView: 3 }     // Desktop: 3 slide
    }
  });
</script>

<!-- ========================================
     BAGIAN 3: VIDEO SECTION
     Menampilkan 2 video dalam format portrait
     ======================================== -->
<section class="container my-5">
  <!-- Judul Section -->
  <h2 class="text-center mb-4 text-warning">Video PUDDINGKU</h2>
  <p class="text-center mb-5">Lihat keseruan pembuatan dan kolaborasi kami dalam bentuk video!</p>

  <div class="row justify-content-center g-4">
    
    <!-- Video 1: Varian Menu -->
    <div class="col-md-5 col-sm-6">
      <div class="video-container-portrait mx-auto">
        <video controls autoplay muted loop playsinline>
          <!-- controls: tombol play/pause muncul -->
          <!-- autoplay: auto play saat load -->
          <!-- muted: tanpa suara (biar bisa autoplay) -->
          <!-- loop: ulang terus -->
          <!-- playsinline: main di tempat (tidak fullscreen di mobile) -->
          <source src="img/video/video_produk.mp4" type="video/mp4">
        </video>
      </div>
      <h5 class="mt-3 text-center text-dark">Varian Menu Puddingku 🍮</h5>
    </div>
    
    <!-- Video 2: Kolaborasi -->
    <div class="col-md-5 col-sm-6">
      <div class="video-container-portrait mx-auto">
        <video controls autoplay muted loop playsinline>
          <source src="img/video/ulasan colab.mp4" type="video/mp4">
        </video>
      </div>
      <h5 class="mt-3 text-center text-dark">Kolaborasi & Kegiatan 📸</h5>
    </div>
    
  </div>
</section>

<!-- ========================================
     BAGIAN 4: SECTION KONTAK
     Berisi TikTok, Instagram, WhatsApp, dan Google Maps
     ======================================== -->
<section id="kontak" class="py-5" style="background: linear-gradient(135deg, #FDD5CE 0%, #FEB2B2 100%); position: relative; overflow: hidden;">
  
  <!-- Dekorasi Background (lingkaran besar) -->
  <div style="position: absolute; top: -50px; right: -50px; width: 200px; height: 200px; background: rgba(255,255,255,0.1); border-radius: 50%; z-index: 0;"></div>
  <div style="position: absolute; bottom: -80px; left: -80px; width: 300px; height: 300px; background: rgba(255,255,255,0.08); border-radius: 50%; z-index: 0;"></div>

  <div class="container position-relative" style="z-index: 1;">
    
    <!-- Header Section Kontak -->
    <div class="text-center mb-5" data-aos="fade-down">
      <p class="text-uppercase" style="font-size: 0.9em; color: #8d4949; letter-spacing: 3px; font-weight: 600; margin-bottom: 10px;">
        <i class="bi bi-geo-alt-fill me-2"></i>CONTACT
      </p>
      <h2 class="display-4 fw-bold mb-3" style="color: #d97706;">Get In Touch</h2>
      
      <!-- Garis dekoratif -->
      <div style="width: 80px; height: 4px; background: linear-gradient(90deg, #d97706, #ff69b4); margin: 0 auto 20px; border-radius: 10px;"></div>
      
      <!-- Alamat Lengkap -->
      <p class="lead" style="max-width: 700px; margin: 0 auto; color: #6b4444; line-height: 1.8;">
        <i class="bi bi-map me-2"></i>Jl. Wilis No. 19, Nganjuk, Ganung Kidul, Kec. Nganjuk, Kabupaten Nganjuk, Jawa Timur 64419
      </p>
      <p style="color: #8d4949; margin-top: 10px;">atau hubungi kami melalui:</p>
    </div>

    <!-- Contact Cards (TikTok, Instagram, WhatsApp) -->
    <div class="row g-4 mb-5 justify-content-center">
      
      <!-- Card 1: TikTok -->
      <div class="col-md-4 col-sm-6" data-aos="zoom-in" data-aos-delay="100">
        <div class="contact-card" style="background: linear-gradient(135deg, #ffffff 0%, #fff5f5 100%); padding: 35px 25px; border-radius: 20px; text-align: center; box-shadow: 0 8px 25px rgba(0,0,0,0.12); transition: all 0.4s ease; border: 3px solid transparent; position: relative; overflow: hidden;">
          
          <!-- Icon Circle TikTok -->
          <div style="width: 80px; height: 80px; background: linear-gradient(135deg, #000000, #333333); border-radius: 50%; margin: 0 auto 20px; display: flex; align-items: center; justify-content: center; box-shadow: 0 6px 20px rgba(0,0,0,0.15);">
            <i class="bi bi-tiktok" style="font-size: 2.2rem; color: white;"></i>
          </div>
          
          <h5 style="color: #333; font-weight: 700; margin-bottom: 15px; font-size: 1.3rem;">TikTok</h5>
          
          <!-- Link TikTok -->
          <a href="https://www.tiktok.com/@puddingku_id?_r=1&_t=ZS-916mG3911OP" target="_blank" style="font-size: 1.2rem; font-weight: 600; color: #d97706; text-decoration: none; transition: all 0.3s;">
            @puddingku_id
          </a>
          
          <p style="color: #999; font-size: 0.85rem; margin-top: 10px;">Follow untuk konten seru!</p>
        </div>
      </div>

      <!-- Card 2: Instagram -->
      <div class="col-md-4 col-sm-6" data-aos="zoom-in" data-aos-delay="200">
        <div class="contact-card" style="background: linear-gradient(135deg, #ffffff 0%, #fff5f5 100%); padding: 35px 25px; border-radius: 20px; text-align: center; box-shadow: 0 8px 25px rgba(0,0,0,0.12); transition: all 0.4s ease; border: 3px solid transparent; position: relative; overflow: hidden;">
          
          <!-- Icon Circle Instagram (gradient warna IG) -->
          <div style="width: 80px; height: 80px; background: linear-gradient(135deg, #f58529, #dd2a7b, #8134af); border-radius: 50%; margin: 0 auto 20px; display: flex; align-items: center; justify-content: center; box-shadow: 0 6px 20px rgba(221, 42, 123, 0.3);">
            <i class="bi bi-instagram" style="font-size: 2.2rem; color: white;"></i>
          </div>
          
          <h5 style="color: #333; font-weight: 700; margin-bottom: 15px; font-size: 1.3rem;">Instagram</h5>
          
          <!-- Link Instagram -->
          <a href="https://www.instagram.com/puddingku_id?utm_source=ig_web_button_share_sheet&igsh=ZDNlZDc0MzIxNw==" target="_blank" style="font-size: 1.2rem; font-weight: 600; color: #d97706; text-decoration: none; transition: all 0.3s;">
            @puddingku_id
          </a>
          
          <p style="color: #999; font-size: 0.85rem; margin-top: 10px;">Lihat katalog produk!</p>
        </div>
      </div>

      <!-- Card 3: WhatsApp -->
      <div class="col-md-4 col-sm-6" data-aos="zoom-in" data-aos-delay="300">
        <div class="contact-card" style="background: linear-gradient(135deg, #ffffff 0%, #fff5f5 100%); padding: 35px 25px; border-radius: 20px; text-align: center; box-shadow: 0 8px 25px rgba(0,0,0,0.12); transition: all 0.4s ease; border: 3px solid transparent; position: relative; overflow: hidden;">
          
          <!-- Icon Circle WhatsApp (gradient hijau WA) -->
          <div style="width: 80px; height: 80px; background: linear-gradient(135deg, #25D366, #128C7E); border-radius: 50%; margin: 0 auto 20px; display: flex; align-items: center; justify-content: center; box-shadow: 0 6px 20px rgba(37, 211, 102, 0.3);">
            <i class="bi bi-whatsapp" style="font-size: 2.2rem; color: white;"></i>
          </div>
          
          <h5 style="color: #333; font-weight: 700; margin-bottom: 15px; font-size: 1.3rem;">WhatsApp</h5>
          
          <!-- Link WhatsApp -->
          <a href="https://wa.me/628157765777" target="_blank" style="font-size: 1.2rem; font-weight: 600; color: #d97706; text-decoration: none; transition: all 0.3s;">
            0815-7765-777
          </a>
          
          <p style="color: #999; font-size: 0.85rem; margin-top: 10px;">Chat langsung untuk order!</p>
        </div>
      </div>
      
    </div>

    <!-- Google Maps Section -->
    <div class="text-center mb-4" data-aos="fade-up">
      <h4 class="fw-bold mb-3" style="color: #d97706;">
        <i class="bi bi-pin-map-fill me-2"></i>Lokasi Kami
      </h4>
    </div>
    
    <!-- Embed Google Maps -->
    <div data-aos="fade-up" data-aos-delay="100" style="border-radius: 20px; overflow: hidden; box-shadow: 0 10px 30px rgba(0,0,0,0.15);">
      <iframe
        src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3954.6904820811205!2d111.90505247443035!3d-7.608620775208614!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x2e784b0029ea6d53%3A0xd3f37a9ee10f047b!2sPUDDINGKU%20DESSERT%20BAR!5e0!3m2!1sid!2sid!4v1760835777982!5m2!1sid!2sid"
        width="100%"
        height="400"
        style="border:0;"
        allowfullscreen=""
        loading="lazy"
        referrerpolicy="no-referrer-when-downgrade">
      </iframe>
    </div>
  </div>
</section>

<!-- ========================================
     BAGIAN 5: FOOTER
     Copyright dan informasi
     ======================================== -->
<footer class="text-center py-4" style="background: #FCD5CE;color: #8d4949;">
  © 2025 PUDDINGKU | Cita Rasa Lokal, Kualitas Nasional
</footer>

<!-- ========================================
     BAGIAN 6: TOMBOL FLOATING WhatsApp
     Tombol hijau bulat pojok kiri bawah
     ======================================== -->
<a href="https://wa.me/628157765777" target="_blank" 
   class="position-fixed bottom-0 start-0 m-4 btn btn-success rounded-circle shadow" 
   style="width:60px;height:60px;display:flex;justify-content:center;align-items:center;font-size:1.6rem;">
  <i class="bi bi-whatsapp"></i>
</a>

<!-- ========================================
     BAGIAN 7: TOMBOL SCROLL TO TOP
     Tombol kuning bulat pojok kanan bawah
     ======================================== -->
<button id="toTopBtn" class="btn btn-warning position-fixed bottom-0 end-0 m-5 rounded-circle shadow">
  <i class="bi bi-arrow-up"></i>
</button>

<!-- ========================================
     BAGIAN 8: SCRIPT SLIDESHOW HERO
     Untuk ganti gambar background otomatis di Hero Section
     ======================================== -->
<script>
let index = 0; // Index slide saat ini
const slides = document.querySelectorAll("#hero img"); // Ambil semua gambar hero

// Fungsi untuk ganti slide
function slideShow(){
  // Hapus class 'active' dari semua gambar
  slides.forEach(slide => slide.classList.remove("active"));
  
  // Tambah class 'active' ke gambar saat ini
  slides[index].classList.add("active");
  
  // Pindah ke index berikutnya (loop kembali ke 0 jika sudah habis)
  index = (index + 1) % slides.length;
}

// Jalankan slideShow setiap 5 detik (5000 ms)
setInterval(slideShow, 5000);
</script>

<!-- ========================================
     BAGIAN 9: SCRIPT SCROLL TO TOP
     Fungsi tombol untuk kembali ke atas halaman
     ======================================== -->
<script>
// Saat tombol "toTopBtn" diklik
toTopBtn.addEventListener("click", function() {
  // Scroll ke posisi paling atas (top: 0)
  window.scrollTo({
    top: 0,
    behavior: "smooth" // Scroll dengan animasi smooth
  });
});
</script>

<!-- ========================================
     BAGIAN 10: SCRIPT AOS (Animate On Scroll)
     Library untuk animasi saat scroll
     ======================================== -->
<script src="https://unpkg.com/aos@2.3.4/dist/aos.js"></script>
<script>
  // Inisialisasi AOS
  AOS.init({ 
    duration: 1000,  // Durasi animasi 1 detik
    once: true       // Animasi hanya jalan sekali
  });
</script>

</body>
</html>