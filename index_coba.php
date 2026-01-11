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
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css" rel="stylesheet">

  <style>
/* ================= RESET ================= */
* {
  margin: 0;
  padding: 0;
  box-sizing: border-box;
}

body {
  font-family: 'Poppins', sans-serif;
  overflow-x: hidden;
  background: linear-gradient(135deg, #FFE5EC 0%, #FFF0F5 50%, #FFC9D9 100%);
}

/* ================= NAVBAR ================= */
.navbar {
  background: rgba(255, 240, 245, 0.95) !important;
  backdrop-filter: blur(10px);
  padding: 1rem 0;
  transition: all 0.3s ease;
  box-shadow: 0 2px 10px rgba(0,0,0,0.08);
}

.navbar.scrolled {
  background: rgba(255, 228, 236, 0.98) !important;
  box-shadow: 0 4px 20px rgba(255,192,203,0.2);
}

.navbar-brand img {
  transition: transform 0.3s ease;
}

.navbar-brand:hover img {
  transform: scale(1.1) rotate(5deg);
}

.nav-link {
  position: relative;
  font-weight: 600;
  color: #444 !important;
  padding: 8px 16px !important;
  transition: all 0.3s ease;
  font-size: 0.95rem;
}

.nav-link::before {
  content: '';
  position: absolute;
  bottom: 0;
  left: 50%;
  width: 0;
  height: 3px;
  background: linear-gradient(90deg, #d97706, #ff69b4);
  transform: translateX(-50%);
  transition: width 0.3s ease;
  border-radius: 10px;
}

.nav-link.active::before,
.nav-link:hover::before {
  width: 70%;
}

.nav-link:hover {
  color: #d97706 !important;
}

.btn-order {
  background: linear-gradient(135deg, #e74c3c 0%, #c0392b 100%);
  color: white !important;
  padding: 10px 25px;
  border-radius: 50px;
  font-weight: 700;
  box-shadow: 0 6px 20px rgba(231, 76, 60, 0.3);
  transition: all 0.3s ease;
}

.btn-order:hover {
  transform: translateY(-3px);
  box-shadow: 0 8px 25px rgba(231, 76, 60, 0.4);
}

/* ================= HERO ================= */
.hero-slider {
  margin-top: 70px;
  position: relative;
  width: 100%;
  height: 600px;
  overflow: hidden;
}

.slide {
  position: absolute;
  inset: 0;
  opacity: 0;
  transition: opacity 1s ease-in-out;
}

.slide.active {
  opacity: 1;
}

.slide img {
  width: 100%;
  height: 100%;
  object-fit: cover;
}

.slide-content {
  position: absolute;
  top: 50%;
  left: 5%;
  transform: translateY(-50%);
  color: white;
  max-width: 600px;
  z-index: 10;
}

.slide-content h1 {
  font-size: 3.5rem;
  margin-bottom: 1rem;
  text-shadow: 2px 2px 4px rgba(0,0,0,.7);
}

.slide-content p {
  font-size: 1.3rem;
  margin-bottom: 2rem;
  text-shadow: 1px 1px 2px rgba(0,0,0,.7);
}

/* ================= CONTENT ================= */
.content {
  padding: 5rem 5%;
  max-width: 1400px;
  margin: auto;
}

.content h2 {
  text-align: center;
  font-size: 2.5rem;
  margin-bottom: 3rem;
}

/* ================= GALERI ================= */
#galeri {
  background: linear-gradient(135deg, #FFE5EC 0%, #FFC9D9 50%, #FFB3C6 100%);
}

/* === PERBAIKAN TINGGI CARD MENU ===*/

#menu .card {
  border: none;
  border-radius: 25px;
  overflow: hidden;
  transition: all 0.4s ease;
  background: linear-gradient(135deg, #ffffff 0%, #fff5f7 100%);
  height: auto;
  min-height: 450px;
  display: flex;
  flex-direction: column;
  box-shadow: 0 8px 20px rgba(255, 105, 180, 0.15);
  border: 3px solid transparent;
  background-clip: padding-box;
  position: relative;
}

#menu .card::before {
  content: '';
  position: absolute;
  top: 0; left: 0; right: 0; bottom: 0;
  border-radius: 25px;
  padding: 3px;
  background: linear-gradient(135deg, #ff69b4, #ff85a2, #ffa07a, #d97706);
  -webkit-mask: linear-gradient(#fff 0 0) content-box, linear-gradient(#fff 0 0);
  -webkit-mask-composite: xor;
  mask-composite: exclude;
  opacity: 0;
  transition: opacity 0.4s ease;
}

#menu .card:hover::before {
  opacity: 1;
}

#menu .card:hover {
  transform: translateY(-12px) scale(1.02);
  box-shadow: 0 20px 40px rgba(255, 105, 180, 0.3);
}

#menu .card .img-wrapper {
  position: relative;
  overflow: hidden;
  height: 180px;
}

@media (min-width: 768px) {
  #menu .card .img-wrapper {
    height: 220px;
  }
}

#menu .card img {
  height: 100%;
  width: 100%;
  object-fit: cover;
  transition: transform 0.6s ease;
}

#menu .card:hover img {
  transform: scale(1.15) rotate(2deg);
}

#menu .card .product-label {
  position: absolute;
  top: 15px;
  left: 15px;
  background: linear-gradient(135deg, rgba(255, 105, 180, 0.95), rgba(255, 182, 193, 0.95));
  color: white;
  padding: 8px 18px;
  border-radius: 25px;
  font-weight: 700;
  font-size: 0.85rem;
  box-shadow: 0 4px 15px rgba(255, 105, 180, 0.4);
  backdrop-filter: blur(10px);
  border: 2px solid rgba(255, 255, 255, 0.5);
  text-transform: uppercase;
  letter-spacing: 0.5px;
  z-index: 10;
  animation: fadeInDown 0.6s ease;
}

@keyframes fadeInDown {
  from {
    opacity: 0;
    transform: translateY(-20px);
  }
  to {
    opacity: 1;
    transform: translateY(0);
  }
}

#menu .card .deco-icon {
  position: absolute;
  top: 15px;
  right: 15px;
  background: rgba(255, 255, 255, 0.9);
  width: 40px;
  height: 40px;
  border-radius: 50%;
  display: flex;
  align-items: center;
  justify-content: center;
  font-size: 1.2rem;
  box-shadow: 0 4px 10px rgba(0,0,0,0.1);
  z-index: 10;
}

#menu .card-body {
  padding: 15px;
  display: flex;
  flex-direction: column;
  flex-grow: 1;
  background: linear-gradient(to bottom, #ffffff, #fff5f7);
}

@media (min-width: 768px) {
  #menu .card-body {
    padding: 20px 18px;
  }
}

#menu .card-title {
  font-weight: 700;
  color: #333;
  font-size: 0.95rem;
  margin-bottom: 10px;
  height: auto;
  display: -webkit-box;
  -webkit-line-clamp: 2;
  -webkit-box-orient: vertical;
  overflow: hidden;
}

@media (min-width: 768px) {
  #menu .card-title {
    font-size: 1.05rem;
  }
}

#menu .card-text {
  color: #666;
  font-size: 0.8rem;
  line-height: 1.5;
  margin-bottom: 12px;
  display: -webkit-box;
  -webkit-line-clamp: 3;
  -webkit-box-orient: vertical;
  overflow: hidden;
}

@media (min-width: 768px) {
  #menu .card-text {
    font-size: 0.85rem;
  }
}

#menu .fw-bold {
  margin-top: auto;
  padding: 12px 0;
  font-size: 1.1rem;
  font-weight: 800;
  background: linear-gradient(135deg, #ff69b4, #d97706);
  -webkit-background-clip: text;
  -webkit-text-fill-color: transparent;
  border-top: 3px solid;
  border-image: linear-gradient(90deg, transparent, #ff69b4, #d97706, transparent) 1;
  text-align: center;
}

/* === STYLE FILTER PILLS MENU ===*/

.nav-pills .nav-link {
  background-color: #ffffff;
  color: #444;
  border-radius: 30px;
  margin: 5px;
  padding: 12px 28px;
  font-weight: 600;
  transition: all 0.3s ease;
  border: 2px solid #ddd;
  box-shadow: 0 2px 6px rgba(0,0,0,0.06);
}

.nav-pills .nav-link:hover {
  background: #fff5f0;
  color: #e67e22;
  transform: translateY(-2px);
  box-shadow: 0 4px 10px rgba(230, 126, 34, 0.15);
  border: 2px solid #ffddcc;
}

.nav-pills .nav-link.active {
  background: linear-gradient(135deg, #ff9966 0%, #ff8855 100%);
  color: #ffffff;
  transform: translateY(-2px);
  box-shadow: 0 4px 15px rgba(255, 136, 85, 0.3);
  border: 2px solid #ffffff;
  font-weight: 700;
}

    body {
      font-family: 'Poppins', sans-serif;
      margin: 0;
      background-color: #f8eeeb;
      color: #4a2b0f;
    }

/* ===== RESPONSIVE ABOUT CONTAINER ===== */
    .about-container {
      padding: 50px 1rem;
      text-align: center;
    }

    @media (min-width: 768px) {
      .about-container {
        padding: 60px 2rem;
      }
    }

    @media (min-width: 1200px) {
      .about-container {
        padding: 60px 80px;
      }
    }

    .about-container h2 {
      color: #d46a00;
      font-size: clamp(1.8rem, 6vw, 2.2rem);
      margin-bottom: 10px;
    }

    .about-content {
      display: flex;
      align-items: center;
      justify-content: center;
      gap: 20px;
      flex-wrap: wrap;
    }

/* RESPONSIVE */
@media (max-width: 768px) {
  .card.h-100 img {
    height: 190px;
  } 
}

/* ===== FIX MOBILE ===== */
@media (max-width: 576px) {

  /* samakan tinggi card */
  .card.h-100 {
    height: 100%;
  }

  /* kunci tinggi gambar */
  .card.h-100 img {
    height: 180px;
  }

  /* kunci area teks */
  .card.h-100 .card-body {
    min-height: 190px;
    padding: 1rem;
  }

  /* kunci deskripsi */
  .card-text {
    -webkit-line-clamp: 2;
  }

  /* divider konsisten */
  .card .divider {
    margin: 8px auto;
  }

  /* kurangi animasi berlebih */
  .card.h-100:hover {
    transform: none;
  }
}

/* ================= RESPONSIVE ================= */
@media (max-width: 768px) {
  .hero-slider { height: 400px; }
  .galeri-item img { height: 190px; }
}

@media (max-width: 480px) {
  .hero-slider { height: 300px; }
}

/* BEST SELLER MOBILE FIX */
@media (max-width: 576px) {

  .best-seller-wrapper {
    display: flex;
    flex-direction: row;
    gap: 16px;
    overflow-x: auto;
    padding-bottom: 10px;
  }

  .best-seller-card {
    flex: 0 0 80%;   /* ini kunci 1 baris */
  }

  .best-seller-card .card {
    width: 100%;
  }

  .best-seller-wrapper::-webkit-scrollbar {
    display: none;
  }
}

</style>
</head>

<body>
    <section class="hero-slider" id="home">
        <div class="slide active">
            <img id="heroImage1" src="img/bg/1.png" alt="Pudding">
        </div>
        <div class="slide">
            <img id="heroImage2" src="img/bg/2.png" alt="Pudding">
        </div>
        <div class="slide">
            <img id="heroImage3" src="img/bg/3.png" alt="Pudding">
        </div>
        <div class="slide">
            <img id="heroImage4" src="img/bg/4.png" alt="Pudding">
        </div>
    </section>
    <!-- Tambahkan Bootstrap JS di bagian bawah sebelum </body> jika belum ada -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

<nav class="navbar navbar-enhanced navbar-expand-lg fixed-top" style="padding: 0; margin: 0; width: 100%;">
  <div class="container-fluid px-4">
    <!-- Logo -->
    <a class="navbar-brand d-flex align-items-center" href="#hero">
      <img src="img/bg/logo_alfin.png" alt="Logo Puddingku" width="55" height="55" class="me-2 rounded-circle">
      <strong style="background: linear-gradient(135deg, #d97706, #ff69b4); -webkit-background-clip: text; -webkit-text-fill-color: transparent;">PUDDINGKU</strong>
    </a>

    <!-- Tombol Hamburger -->
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navMenu" aria-controls="navMenu" aria-expanded="false" aria-label="Toggle navigation" style="border: 2px solid #d97706; padding: 8px 12px;">
      <span class="navbar-toggler-icon"></span>
    </button>

    <!-- Menu Items -->
    <div class="collapse navbar-collapse justify-content-end" id="navMenu">
      <ul class="navbar-nav mb-2 mb-lg-0 align-items-center">
        <li class="nav-item"><a class="nav-link active" href="#hero">🏠 Home</a></li>
        <li class="nav-item"><a class="nav-link" href="#about">ℹ️ About</a></li>
        <li class="nav-item"><a class="nav-link" href="#menu">🍰 Menu</a></li>
        <li class="nav-item"><a class="nav-link" href="#galeri">📸 Gallery</a></li>
        <li class="nav-item"><a class="nav-link" href="#ulasan">⭐ Reviews</a></li>
        <li class="nav-item"><a class="nav-link" href="#kontak">📞 Contact</a></li>
        
        <!-- Tombol Order Now -->
        <li class="nav-item ms-3">
          <a href="pemesanan.php" class="btn btn-order-now">
            <i class="bi bi-cart-fill me-2"></i>Order Now
          </a>
        </li>
      </ul>
    </div>
  </div>
</nav>

<script>
// Pastikan navbar collapse berfungsi
document.addEventListener('DOMContentLoaded', function() {
  // Auto close navbar saat link diklik (untuk mobile)
  const navLinks = document.querySelectorAll('.nav-link');
  const navCollapse = document.getElementById('navMenu');
  
  navLinks.forEach(link => {
    link.addEventListener('click', function() {
      if (window.innerWidth < 992) { // Hanya untuk mobile
        const bsCollapse = new bootstrap.Collapse(navCollapse, {
          toggle: false
        });
        bsCollapse.hide();
      }
    });
  });
});
</script>

<section id="galeri" class="py-5" style="padding-top: 120px !important; margin: 0; width: 100%;">
  <div class="container-fluid px-5">
    <div class="text-center mb-5" data-aos="fade-up">
      <h2 class="display-5 fw-bold mb-2" style="color: #d97706;">Gallery</h2>
      <p class="text-muted">Momen Manis & Kegiatan Kami 📸</p>
    </div>

    <div class="row g-3">
      <!-- Gallery Item 1 -->
      <div class="col-6 col-sm-6 col-md-4" data-aos="zoom-in">
        <div class="gallery-item" style="border-radius: 15px; overflow: hidden; box-shadow: 0 6px 20px rgba(0,0,0,0.1); transition: transform 0.3s;">
          <img src="img/bg/galerry 1.jpeg" alt="Galeri 1" style="width: 100%; height: 150px; object-fit: cover;">
        </div>
      </div>
      
      <div class="col-6 col-sm-6 col-md-4" data-aos="zoom-in" data-aos-delay="100">
        <div class="gallery-item" style="border-radius: 15px; overflow: hidden; box-shadow: 0 6px 20px rgba(0,0,0,0.1); transition: transform 0.3s;">
          <img src="img/bg/gallery 2.jpeg" alt="Galeri 2" style="width: 100%; height: 150px; object-fit: cover;">
        </div>
      </div>

      <div class="col-6 col-sm-6 col-md-4" data-aos="zoom-in" data-aos-delay="200">
        <div class="gallery-item" style="border-radius: 15px; overflow: hidden; box-shadow: 0 6px 20px rgba(0,0,0,0.1); transition: transform 0.3s;">
          <img src="img/bg/gallery 3.jpeg" alt="Galeri 3" style="width: 100%; height: 150px; object-fit: cover;">
        </div>
      </div>

      <div class="col-6 col-sm-6 col-md-4" data-aos="zoom-in" data-aos-delay="300">
        <div class="gallery-item" style="border-radius: 15px; overflow: hidden; box-shadow: 0 6px 20px rgba(0,0,0,0.1); transition: transform 0.3s;">
          <img src="img/bg/gallery  4.jpeg" alt="Galeri 4" style="width: 100%; height: 150px; object-fit: cover;">
        </div>
      </div>

      <div class="col-6 col-sm-6 col-md-4" data-aos="zoom-in" data-aos-delay="400">
        <div class="gallery-item" style="border-radius: 15px; overflow: hidden; box-shadow: 0 6px 20px rgba(0,0,0,0.1); transition: transform 0.3s;">
          <img src="img/bg/gallery 5.jpeg" alt="Galeri 5" style="width: 100%; height: 150px; object-fit: cover;">
        </div>
      </div>

      <div class="col-6 col-sm-6 col-md-4" data-aos="zoom-in" data-aos-delay="500">
        <div class="gallery-item" style="border-radius: 15px; overflow: hidden; box-shadow: 0 6px 20px rgba(0,0,0,0.1); transition: transform 0.3s;">
          <img src="img/bg/gallery 6.jpeg" alt="Galeri 6" style="width: 100%; height: 150px; object-fit: cover;">
        </div>
      </div>
    </div>
</section>

<section class="py-5" style="background: #fff; margin: 0; padding: 40px 20px; width: 100%;">
  <div class="container-fluid why-choose-container">
    <!-- RESPONSIVE FIX -->
    <style>
      .why-choose-container {
        max-width: 500px;
        margin: 0 auto;
      }
      
      @media (min-width: 992px) {
        .why-choose-container { 
          max-width: 1200px !important; 
        }
        .why-grid { 
          display: grid; 
          grid-template-columns: repeat(4, 1fr); 
          gap: 30px; 
        }
        .why-grid > div { 
          width: 100% !important; 
          max-width: none !important; 
        }
        .why-feature-card {
          padding: 40px 25px !important;
        }
        .why-feature-icon {
          width: 90px !important;
          height: 90px !important;
          font-size: 2.5rem !important;
        }
        .why-feature-title {
          font-size: 1.3rem !important;
        }
        .why-feature-desc {
          font-size: 0.95rem !important;
        }
      }
    </style>

    <div class="text-center mb-4">
      <h2 class="fw-bold mb-2" style="color: #d97706; font-size: 1.8rem;">Why Choose Us?</h2>
      <p class="text-muted" style="font-size: 0.9rem;">Alasan Kenapa Harus Pilih Puddingku 💝</p>
    </div>

    <!-- Grid 2 kolom mobile, 4 kolom desktop -->
    <div class="row g-3 why-grid">
      <!-- Feature 1: 100% Halal -->
      <div class="col-6">
        <div class="text-center p-3 why-feature-card" style="background: linear-gradient(135deg, #fff5f5, #ffe8e8); border-radius: 15px; height: 100%;">
          <div class="why-feature-icon" style="width: 70px; height: 70px; background: linear-gradient(135deg, #ff69b4, #ff85a2); border-radius: 50%; margin: 0 auto 15px; display: flex; align-items: center; justify-content: center;">
            <i class="bi bi-check-circle-fill" style="font-size: 2rem; color: white;"></i>
          </div>
          <h5 class="fw-bold mb-2 why-feature-title" style="font-size: 1rem;">100% Halal</h5>
          <p class="text-muted mb-0 why-feature-desc" style="font-size: 0.75rem; line-height: 1.3;">Bahan berkualitas dan terjamin halal</p>
        </div>
      </div>

      <!-- Feature 2: Homemade -->
      <div class="col-6">
        <div class="text-center p-3 why-feature-card" style="background: linear-gradient(135deg, #fff5f5, #ffe8e8); border-radius: 15px; height: 100%;">
          <div class="why-feature-icon" style="width: 70px; height: 70px; background: linear-gradient(135deg, #d97706, #f59e0b); border-radius: 50%; margin: 0 auto 15px; display: flex; align-items: center; justify-content: center;">
            <i class="bi bi-heart-fill" style="font-size: 2rem; color: white;"></i>
          </div>
          <h5 class="fw-bold mb-2 why-feature-title" style="font-size: 1rem;">Homemade</h5>
          <p class="text-muted mb-0 why-feature-desc" style="font-size: 0.75rem; line-height: 1.3;">Dibuat dengan cinta & resep rumahan</p>
        </div>
      </div>

      <!-- Feature 3: Fast Delivery -->
      <div class="col-6">
        <div class="text-center p-3 why-feature-card" style="background: linear-gradient(135deg, #fff5f5, #ffe8e8); border-radius: 15px; height: 100%;">
          <div class="why-feature-icon" style="width: 70px; height: 70px; background: linear-gradient(135deg, #10b981, #059669); border-radius: 50%; margin: 0 auto 15px; display: flex; align-items: center; justify-content: center;">
            <i class="bi bi-truck" style="font-size: 2rem; color: white;"></i>
          </div>
          <h5 class="fw-bold mb-2 why-feature-title" style="font-size: 1rem;">Fast Delivery</h5>
          <p class="text-muted mb-0 why-feature-desc" style="font-size: 0.75rem; line-height: 1.3;">Pengiriman cepat & aman</p>
        </div>
      </div>

      <!-- Feature 4: Best Quality -->
      <div class="col-6">
        <div class="text-center p-3 why-feature-card" style="background: linear-gradient(135deg, #fff5f5, #ffe8e8); border-radius: 15px; height: 100%;">
          <div class="why-feature-icon" style="width: 70px; height: 70px; background: linear-gradient(135deg, #3b82f6, #2563eb); border-radius: 50%; margin: 0 auto 15px; display: flex; align-items: center; justify-content: center;">
            <i class="bi bi-star-fill" style="font-size: 2rem; color: white;"></i>
          </div>
          <h5 class="fw-bold mb-2 why-feature-title" style="font-size: 1rem;">Best Quality</h5>
          <p class="text-muted mb-0 why-feature-desc" style="font-size: 0.75rem; line-height: 1.3;">Kualitas terbaik & rasa premium</p>
        </div>
      </div>
    </div>
  </div>
</section>

  <section id="about" style="background: linear-gradient(135deg, #FFE5EC 0%, #FFF0F5 50%, #FFC9D9 100%); padding: 80px 0; margin: 0; width: 100%;">
  <div class="container-fluid px-5">
    <div class="text-center mb-5" data-aos="fade-down">
      <h2 class="display-5 fw-bold" style="color: #d97706;">About PUDDINGKU</h2>
      <p class="text-muted">Cerita Manis di Balik Setiap Gigitan 🍮</p>
    </div>

    <!-- FOTO DI TENGAH -->
    <div class="text-center mb-5" data-aos="zoom-in">
      <img src="img/bg/ABOUT.jpg" alt="Tentang Puddingku" 
           class="img-fluid rounded-4 shadow-lg" 
           style="border: 5px solid #fff; max-width: 600px; width: 100%;">
    </div>

    <!-- DESKRIPSI ABOUT -->
    <div class="row justify-content-center">
      <div class="col-lg-10" data-aos="fade-up">
        <div class="about-text-new">
          <h3 class="fw-bold mb-4 text-center" style="color: #d97706;">
            <i class="bi bi-heart-fill text-danger me-2"></i>
            Kelezatan Homemade untuk Setiap Momen Spesial
          </h3>
          <p class="lead mb-4 text-center" style="line-height: 1.8;">
            <strong>PUDDINGKU</strong> adalah UMKM yang bergerak di bidang kuliner dengan spesialisasi pada berbagai macam <strong>cake dan dessert</strong>. 
            Kami menawarkan aneka puding, kue lembut, dan hidangan manis lainnya yang dibuat dari <span class="text-danger fw-bold">bahan-bahan berkualitas</span> 
            dan rasa rumahan yang otentik.
          </p>

          <div class="row g-3 mb-4 justify-content-center">
            <div class="col-md-3 col-6">
              <div class="text-center p-3 bg-white rounded-3 shadow-sm h-100">
                <div class="bg-warning bg-opacity-25 rounded-circle p-3 d-inline-block mb-2">
                  <i class="bi bi-check-circle-fill text-warning fs-3"></i>
                </div>
                <h6 class="fw-bold mb-1">Bahan Berkualitas</h6>
                <small class="text-muted">100% Fresh & Halal</small>
              </div>
            </div>
            <div class="col-md-3 col-6">
              <div class="text-center p-3 bg-white rounded-3 shadow-sm h-100">
                <div class="bg-danger bg-opacity-25 rounded-circle p-3 d-inline-block mb-2">
                  <i class="bi bi-award-fill text-danger fs-3"></i>
                </div>
                <h6 class="fw-bold mb-1">Rasa Otentik</h6>
                <small class="text-muted">Homemade Recipe</small>
              </div>
            </div>
            <div class="col-md-3 col-6">
              <div class="text-center p-3 bg-white rounded-3 shadow-sm h-100">
                <div class="bg-success bg-opacity-25 rounded-circle p-3 d-inline-block mb-2">
                  <i class="bi bi-gift-fill text-success fs-3"></i>
                </div>
                <h6 class="fw-bold mb-1">Perfect Gift</h6>
                <small class="text-muted">Hampers & Events</small>
              </div>
            </div>
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

<!--bagian menu-->
<section id="menu" class="py-5" style="background: linear-gradient(135deg, #FFF0F5 0%, #FFE5EC 50%, #FFC9D9 100%); margin: 0; width: 100%;">
  <div class="container-fluid px-5">

    <!-- Header Menu -->
<div class="text-center mb-5" data-aos="fade-up">
  <h2 class="display-4 fw-bold mb-2" style="color: #d97706; font-size: 2.5rem;">MENU BEST SELLER</h2>
  <p class="text-muted" style="font-size: 1.1rem;">Pilihan Lezat untuk Setiap Selera 🍰</p>
</div>

<div class="best-seller-wrapper">

  <div class="best-seller-card">
    <div class="card">
      <img src="img/dessert/banafe 2.jpg" alt="Desert Box Banafe">
    <div class="card-body text-center">
      <h5 class="card-title">Desert Box Banafe</h5>
      <p class="card-text">Perpaduan sempurna antara pisang manis, karamel lembut, dan cream cheese yang creamy.</p>
      <div class="divider"></div>
    </div>
    </div>
  </div>

  <div class="best-seller-card">
    <div class="card">
      <img src="img/cake/chocolate mouse cake.jpg" class="card-img-top" alt="Brownies Classic">
          <div class="card-body text-center">
            <h5 class="card-title">chocolate mouse cake</h5>
            <p class="card-text">Brownies panggang lembut dengan rasa cokelat pekat.</p>
            <div class="divider"></div>
          </div>
    </div>
  </div>

  <div class="best-seller-card">
    <div class="card">
      <img src="img/dessert/milk bun.jpg" class="card-img-top" alt="Brownies Classic">
          <div class="card-body text-center">
            <h5 class="card-title">milk bun</h5>
            <p class="card-text">Brownies panggang lembut dengan rasa cokelat pekat.</p>
            <div class="divider"></div>
          </div>
    </div>
  </div>

  <div class="best-seller-card">
    <div class="card">
      <img src="img/pudding/silky pudding_mango.jpg" class="card-img-top" alt="Brownies Classic">
          <div class="card-body text-center">
            <h5 class="card-title">mango silky pudding</h5>
            <p class="card-text">Brownies panggang lembut dengan rasa cokelat pekat.</p>
            <div class="divider"></div>
          </div>
    </div>
  </div>

</div>

<!-- SCRIPT FILTER MENU YANG BENAR -->
<script>
document.addEventListener('DOMContentLoaded', function() {
  // Ambil semua tombol filter
  const filterButtons = document.querySelectorAll('#menuTabs .nav-link');
  // Ambil semua item produk
  const menuItems = document.querySelectorAll('#menuList > div[data-category]');

  console.log('Filter Buttons:', filterButtons.length);
  console.log('Menu Items:', menuItems.length);

  // Tambahkan event listener ke setiap tombol
  filterButtons.forEach(button => {
    button.addEventListener('click', function(e) {
      e.preventDefault();
      
      // Hapus class active dari semua tombol
      filterButtons.forEach(btn => btn.classList.remove('active'));
      
      // Tambah class active ke tombol yang diklik
      this.classList.add('active');
      
      // Ambil kategori yang dipilih
      const selectedCategory = this.getAttribute('data-category');
      console.log('Selected Category:', selectedCategory);
      
      // Filter produk
      menuItems.forEach(item => {
        const itemCategory = item.getAttribute('data-category');
        
        if (selectedCategory === 'all') {
          // Tampilkan semua
          item.style.display = 'block';
          item.classList.add('fade-in');
        } else if (itemCategory === selectedCategory) {
          // Tampilkan yang sesuai kategori
          item.style.display = 'block';
          item.classList.add('fade-in');
        } else {
          // Sembunyikan yang tidak sesuai
          item.style.display = 'none';
          item.classList.remove('fade-in');
        }
      });
    });
  });
});

// Animasi fadeIn
const styleSheet = document.createElement('style');
styleSheet.textContent = `
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
  
  .fade-in {
    animation: fadeIn 0.5s ease;
  }
  
  #menuList > div {
    transition: all 0.3s ease;
  }
`;
document.head.appendChild(styleSheet);
</script>


<style>
  #menuList .col-md-3 {
    transition: all 0.4s ease;
  }
</style>
</section>

<!--ulasan-->

<!-- SwiperJS -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css"/>
<script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>
<style>
/* === ULASAN PELANGGAN STYLE === */
#ulasan {
  background-color: #f8dcdc;
}

#ulasan .judul-section {
  font-weight: 700;
  font-family: 'Poppins', sans-serif;
}

/* Swiper container */
.mySwiper {
  width: 100%;
  padding: 40px 0 60px; /* tambah bawah agar titik tidak mepet */
}

/* Setiap slide */
.swiper-slide {
  display: flex;
  justify-content: center;
  transition: transform 0.4s ease;
}

/* Kartu ulasan */
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

/* Efek zoom besar saat hover */
.card-ulasan:hover img {
  transform: scale(1.25);
}

/* Efek zoom besar pada slide tengah */
.swiper-slide-active .card-ulasan {
  transform: scale(1.25);
  box-shadow: 0 10px 35px rgba(0,0,0,0.25);
  z-index: 2;
}

/* Efek halus pada slide di samping */
.swiper-slide-next .card-ulasan,
.swiper-slide-prev .card-ulasan {
  transform: scale(1.05);
  opacity: 0.9;
}

/* Tombol pojok kanan atas */
.btn-ulasan {
  background-color: #e60000;
  color: white;
  padding: 8px 14px;
  border-radius: 30px;
  font-weight: 500;
  text-decoration: none;
  transition: background-color 0.3s;
}

.btn-ulasan:hover {
  background-color: rgba(255, 0, 0, 0.12);
  color: #fff;
}

/* Tombol panah kiri kanan */
.swiper-button-prev,
.swiper-button-next {
  color: #ff7676;
  transition: color 0.3s;
}

.swiper-button-prev:hover,
.swiper-button-next:hover {
  color: #ff5c5c;
}
/* === TITIK PAGINATION (indikator slide) === */
.swiper-pagination {
  position: relative;
  margin-top: 75px; /* jarak dari gambar ke titik (sebelumnya 0) */
}

.swiper-pagination-bullet {
  background: #ff7676;
  opacity: 0.4;
  width: 10px;
  height: 10px;
  transition: all 0.3s ease;
  margin: 0 6px !important; /* jarak antar titik */
}

.swiper-pagination-bullet-active {
  opacity: 1;
  transform: scale(1.4);
  background: #ff5c5c;
}
.mySwiper {
  width: 100%;
  padding: 10px 0 10px; /* sebelumnya 60px, sekarang tambah lebih ke bawah */
}
</style>

 <section id="ulasan" class="py-5 position-relative" style="background: linear-gradient(135deg, #FFE5EC 0%, #FFC9D9 50%, #FFB3C6 100%); margin: 0; width: 100%; padding: 40px 20px;">
  <div class="container-fluid position-relative" style="max-width: 500px;">
    <!-- Tombol pojok kanan atas -->
      <a href="ulasan.php" class="btn-ulasan position-absolute end-0" style="top: -35px; right: 20px; background: linear-gradient(135deg, #d97706, #f59e0b); color: white; padding: 8px 15px; border-radius: 20px; text-decoration: none; font-size: 0.85rem; font-weight: 600; box-shadow: 0 4px 12px rgba(217, 119, 6, 0.3); z-index: 100;">
        <i class="bi bi-plus-circle me-1"></i> Rating
      </a>

    <!-- Header -->
    <div class="text-center mb-4">
      <h2 class="fw-bold mb-2" style="color: #d97706; font-size: 1.8rem;">Ulasan Pelanggan</h2>
      <p class="text-muted" style="font-size: 0.9rem;">Review Jujur Oleh Pelanggan ☕</p>
    </div>

    <!-- Swiper Container dengan navigasi di luar -->
    <div class="position-relative" style="padding: 0 50px;">
      <!-- Tombol Prev - Di luar card -->
      <div class="swiper-button-prev-custom" style="position: absolute; left: 0; top: 50%; transform: translateY(-50%); z-index: 10; cursor: pointer; width: 40px; height: 40px; background: linear-gradient(135deg, #d97706, #f59e0b); border-radius: 50%; display: flex; align-items: center; justify-content: center; box-shadow: 0 4px 12px rgba(217, 119, 6, 0.3); transition: transform 0.3s;">
        <i class="bi bi-chevron-left" style="font-size: 1.5rem; color: white;"></i>
      </div>

      <!-- Swiper -->
      <div class="swiper mySwiper" style="border-radius: 15px; overflow: hidden;">
        <div class="swiper-wrapper">
          <div class="swiper-slide">
            <div class="card-ulasan" style="background: white; border-radius: 15px; overflow: hidden; box-shadow: 0 8px 20px rgba(0,0,0,0.1);">
              <img src="img/ulasan/ulasan1.png" alt="Ulasan 1" style="width: 100%; height: auto; display: block;">
            </div>
          </div>
          <div class="swiper-slide">
            <div class="card-ulasan" style="background: white; border-radius: 15px; overflow: hidden; box-shadow: 0 8px 20px rgba(0,0,0,0.1);">
              <img src="img/ulasan/ulasan2.png" alt="Ulasan 2" style="width: 100%; height: auto; display: block;">
            </div>
          </div>
          <div class="swiper-slide">
            <div class="card-ulasan" style="background: white; border-radius: 15px; overflow: hidden; box-shadow: 0 8px 20px rgba(0,0,0,0.1);">
              <img src="img/ulasan/ulasan3.png" alt="Ulasan 3" style="width: 100%; height: auto; display: block;">
            </div>
          </div>
          <div class="swiper-slide">
            <div class="card-ulasan" style="background: white; border-radius: 15px; overflow: hidden; box-shadow: 0 8px 20px rgba(0,0,0,0.1);">
              <img src="img/ulasan/ulasan4.png" alt="Ulasan 4" style="width: 100%; height: auto; display: block;">
            </div>
          </div>
          <div class="swiper-slide">
            <div class="card-ulasan" style="background: white; border-radius: 15px; overflow: hidden; box-shadow: 0 8px 20px rgba(0,0,0,0.1);">
              <img src="img/ulasan/ulasan5.png" alt="Ulasan 5" style="width: 100%; height: auto; display: block;">
            </div>
          </div>
          <div class="swiper-slide">
            <div class="card-ulasan" style="background: white; border-radius: 15px; overflow: hidden; box-shadow: 0 8px 20px rgba(0,0,0,0.1);">
              <img src="img/ulasan/ulasan6.png" alt="Ulasan 6" style="width: 100%; height: auto; display: block;">
            </div>
          </div>
          <div class="swiper-slide">
            <div class="card-ulasan" style="background: white; border-radius: 15px; overflow: hidden; box-shadow: 0 8px 20px rgba(0,0,0,0.1);">
              <img src="img/ulasan/ulasan7.png" alt="Ulasan 7" style="width: 100%; height: auto; display: block;">
            </div>
          </div>
          <div class="swiper-slide">
            <div class="card-ulasan" style="background: white; border-radius: 15px; overflow: hidden; box-shadow: 0 8px 20px rgba(0,0,0,0.1);">
              <img src="img/ulasan/ulasan8.png" alt="Ulasan 8" style="width: 100%; height: auto; display: block;">
            </div>
          </div>
          <div class="swiper-slide">
            <div class="card-ulasan" style="background: white; border-radius: 15px; overflow: hidden; box-shadow: 0 8px 20px rgba(0,0,0,0.1);">
              <img src="img/ulasan/ulasan9.png" alt="Ulasan 9" style="width: 100%; height: auto; display: block;">
            </div>
          </div>
          <div class="swiper-slide">
            <div class="card-ulasan" style="background: white; border-radius: 15px; overflow: hidden; box-shadow: 0 8px 20px rgba(0,0,0,0.1);">
              <img src="img/ulasan/ulasan10.png" alt="Ulasan 10" style="width: 100%; height: auto; display: block;">
            </div>
          </div>
          <div class="swiper-slide">
            <div class="card-ulasan" style="background: white; border-radius: 15px; overflow: hidden; box-shadow: 0 8px 20px rgba(0,0,0,0.1);">
              <img src="img/ulasan/ulasan11.png" alt="Ulasan 11" style="width: 100%; height: auto; display: block;">
            </div>
          </div>
        </div>

        <!-- Titik pagination -->
        <div class="swiper-pagination" style="bottom: 10px;"></div>
      </div>

      <!-- Tombol Next - Di luar card -->
      <div class="swiper-button-next-custom" style="position: absolute; right: 0; top: 50%; transform: translateY(-50%); z-index: 10; cursor: pointer; width: 40px; height: 40px; background: linear-gradient(135deg, #d97706, #f59e0b); border-radius: 50%; display: flex; align-items: center; justify-content: center; box-shadow: 0 4px 12px rgba(217, 119, 6, 0.3); transition: transform 0.3s;">
        <i class="bi bi-chevron-right" style="font-size: 1.5rem; color: white;"></i>
      </div>
    </div>
  </div>
</section>

<script>
  // Inisialisasi Swiper
  document.addEventListener('DOMContentLoaded', function() {
    const swiper = new Swiper('.mySwiper', {
      slidesPerView: 1,
      spaceBetween: 20,
      loop: true,
      autoplay: {
        delay: 3000,
        disableOnInteraction: false,
      },
      pagination: {
        el: '.swiper-pagination',
        clickable: true,
      },
      navigation: {
        nextEl: '.swiper-button-next-custom',
        prevEl: '.swiper-button-prev-custom',
      },
    });

    // Hover effect untuk tombol navigasi
    const navButtons = document.querySelectorAll('.swiper-button-prev-custom, .swiper-button-next-custom');
    navButtons.forEach(btn => {
      btn.addEventListener('mouseenter', () => {
        btn.style.transform = 'translateY(-50%) scale(1.1)';
      });
      btn.addEventListener('mouseleave', () => {
        btn.style.transform = 'translateY(-50%) scale(1)';
      });
    });
  });
</script>

<section class="py-5" style="background: #fff; padding: 40px 20px;">
 <div class="container-fluid why-choose-container" style="max-width: 500px;">
    <div class="text-center mb-4">
      <h2 class="fw-bold mb-2" style="color: #d97706; font-size: 1.8rem;">Video PUDDINGKU</h2>
      <p class="text-muted" style="font-size: 0.9rem;">Lihat keseruan pembuatan dan kolaborasi kami dalam bentuk video!</p>
    </div>

    <!-- Grid 2 kolom video -->
    <div class="row g-3">
      <!-- Video 1 -->
      <div class="col-6">
        <div style="background: linear-gradient(135deg, #fff5f5, #ffe8e8); border-radius: 15px; padding: 10px; height: 100%;">
          <div class="video-container" style="position: relative; width: 100%; padding-top: 177.78%; overflow: hidden; border-radius: 10px; background: #000;">
            <video controls muted loop playsinline style="position: absolute; top: 0; left: 0; width: 100%; height: 100%; object-fit: cover;">
              <source src="img/video/video_produk.mp4" type="video/mp4">
            </video>
          </div>
          <h6 class="mt-2 text-center fw-bold mb-0" style="font-size: 0.85rem; color: #333;">Varian Menu Puddingku 🍮</h6>
        </div>
      </div>

      <!-- Video 2 -->
      <div class="col-6">
        <div style="background: linear-gradient(135deg, #fff5f5, #ffe8e8); border-radius: 15px; padding: 10px; height: 100%;">
          <div class="video-container" style="position: relative; width: 100%; padding-top: 177.78%; overflow: hidden; border-radius: 10px; background: #000;">
            <video controls muted loop playsinline style="position: absolute; top: 0; left: 0; width: 100%; height: 100%; object-fit: cover;">
              <source src="img/video/ulasan colab.mp4" type="video/mp4">
            </video>
          </div>
          <h6 class="mt-2 text-center fw-bold mb-0" style="font-size: 0.85rem; color: #333;">Kolaborasi & Kegiatan 📸</h6>
        </div>
      </div>
    </div>
  </div>
</section>

 <section id="kontak" class="py-5" style="background: linear-gradient(135deg, #FFB3C6 0%, #FFC9D9 50%, #FFE5EC 100%); position: relative; overflow: hidden; margin: 0; width: 100%;">
  <!-- Dekorasi Background -->
  <div style="position: absolute; top: -50px; right: -50px; width: 200px; height: 200px; background: rgba(255,255,255,0.1); border-radius: 50%; z-index: 0;"></div>
  <div style="position: absolute; bottom: -80px; left: -80px; width: 300px; height: 300px; background: rgba(255,255,255,0.08); border-radius: 50%; z-index: 0;"></div>

  <!-- RESPONSIVE CSS -->
<style>
  .contact-container {
    max-width: 500px;
    margin: 0 auto;
  }
  
  @media (min-width: 992px) {
    .contact-container {
      max-width: 1000px !important;
    }
    .contact-header h2 {
      font-size: 2.2rem !important;
    }
    .contact-header p {
      font-size: 1rem !important;
    }
    .contact-cards {
      display: flex;
      justify-content: center;
      gap: 40px;
      max-width: 900px;
      margin: 0 auto 40px;
    }
    .contact-cards > div {
      flex: 0 0 250px;
    }
    .contact-card-item {
      padding: 30px 20px !important;
      height: 100%;
    }
    .contact-icon {
      width: 70px !important;
      height: 70px !important;
      margin-bottom: 15px !important;
    }
    .contact-icon i {
      font-size: 2rem !important;
    }
    .contact-card-title {
      font-size: 1.1rem !important;
      margin-bottom: 8px !important;
    }
    .contact-card-username {
      font-size: 0.95rem !important;
    }
    .contact-card-desc {
      font-size: 0.8rem !important;
    }
    .maps-title {
      font-size: 1.5rem !important;
    }
    .maps-container {
      max-width: 900px;
      margin: 0 auto;
    }
    .maps-container iframe {
      height: 350px !important;
    }
  }
</style>

  <div class="container-fluid position-relative contact-container" style="z-index: 1; padding: 40px 20px;">
    <!-- Header Section -->
    <div class="text-center mb-4 contact-header">
      <p class="text-uppercase mb-2" style="font-size: 0.75rem; color: #8d4949; letter-spacing: 2px; font-weight: 600;">
        <i class="bi bi-geo-alt-fill me-1"></i>CONTACT
      </p>
      <h2 class="fw-bold mb-3" style="color: #d97706; font-size: 1.8rem;">Get In Touch</h2>
      <div style="width: 60px; height: 3px; background: linear-gradient(90deg, #d97706, #ff69b4); margin: 0 auto 15px; border-radius: 10px;"></div>
      <p class="mb-2" style="font-size: 0.85rem; color: #6b4444; line-height: 1.6;">
        <i class="bi bi-map me-1"></i>Jl. Wilis No. 19, Nganjuk, Ganung Kidul, Kec. Nganjuk, Kabupaten Nganjuk, Jawa Timur 64419
      </p>
      <p style="color: #8d4949; font-size: 0.8rem; margin-top: 8px;">atau hubungi kami melalui:</p>
    </div>

    <!-- Contact Cards - 3 kolom compact -->
    <div class="row g-2 mb-4 contact-cards">
      <!-- TikTok -->
      <div class="col-4">
        <a href="https://www.tiktok.com/@puddingku_id?_r=1&_t=ZS-916mG3911OP" target="_blank" style="text-decoration: none;">
          <div class="contact-card-item" style="background: linear-gradient(135deg, #ffffff 0%, #fff5f5 100%); padding: 15px 10px; border-radius: 15px; text-align: center; box-shadow: 0 4px 15px rgba(0,0,0,0.1); transition: transform 0.3s;">
            <div class="contact-icon" style="width: 50px; height: 50px; background: linear-gradient(135deg, #000000, #333333); border-radius: 50%; margin: 0 auto 10px; display: flex; align-items: center; justify-content: center; box-shadow: 0 4px 12px rgba(0,0,0,0.15);">
              <i class="bi bi-tiktok" style="font-size: 1.5rem; color: white;"></i>
            </div>
            <h6 class="contact-card-title" style="color: #333; font-weight: 700; margin-bottom: 5px; font-size: 0.85rem;">TikTok</h6>
            <p class="contact-card-username" style="font-size: 0.7rem; font-weight: 600; color: #d97706; margin: 0;">@puddingku_id</p>
            <p class="contact-card-desc" style="color: #999; font-size: 0.6rem; margin-top: 3px;">Follow kami!</p>
          </div>
        </a>
      </div>

      <!-- Instagram -->
      <div class="col-4">
        <a href="https://www.instagram.com/puddingku_id?utm_source=ig_web_button_share_sheet&igsh=ZDNlZDc0MzIxNw==" target="_blank" style="text-decoration: none;">
          <div class="contact-card-item" style="background: linear-gradient(135deg, #ffffff 0%, #fff5f5 100%); padding: 15px 10px; border-radius: 15px; text-align: center; box-shadow: 0 4px 15px rgba(0,0,0,0.1); transition: transform 0.3s;">
            <div class="contact-icon" style="width: 50px; height: 50px; background: linear-gradient(135deg, #f58529, #dd2a7b, #8134af); border-radius: 50%; margin: 0 auto 10px; display: flex; align-items: center; justify-content: center; box-shadow: 0 4px 12px rgba(221, 42, 123, 0.3);">
              <i class="bi bi-instagram" style="font-size: 1.5rem; color: white;"></i>
            </div>
            <h6 class="contact-card-title" style="color: #333; font-weight: 700; margin-bottom: 5px; font-size: 0.85rem;">Instagram</h6>
            <p class="contact-card-username" style="font-size: 0.7rem; font-weight: 600; color: #d97706; margin: 0;">@puddingku_id</p>
            <p class="contact-card-desc" style="color: #999; font-size: 0.6rem; margin-top: 3px;">Lihat katalog!</p>
          </div>
        </a>
      </div>

      <!-- WhatsApp -->
      <div class="col-4">
        <a href="https://wa.me/628157765777" target="_blank" style="text-decoration: none;">
          <div class="contact-card-item" style="background: linear-gradient(135deg, #ffffff 0%, #fff5f5 100%); padding: 15px 10px; border-radius: 15px; text-align: center; box-shadow: 0 4px 15px rgba(0,0,0,0.1); transition: transform 0.3s;">
            <div class="contact-icon" style="width: 50px; height: 50px; background: linear-gradient(135deg, #25D366, #128C7E); border-radius: 50%; margin: 0 auto 10px; display: flex; align-items: center; justify-content: center; box-shadow: 0 4px 12px rgba(37, 211, 102, 0.3);">
              <i class="bi bi-whatsapp" style="font-size: 1.5rem; color: white;"></i>
            </div>
            <h6 class="contact-card-title" style="color: #333; font-weight: 700; margin-bottom: 5px; font-size: 0.85rem;">WhatsApp</h6>
            <p class="contact-card-username" style="font-size: 0.65rem; font-weight: 600; color: #d97706; margin: 0;">0815-7765-777</p>
            <p class="contact-card-desc" style="color: #999; font-size: 0.6rem; margin-top: 3px;">Chat order!</p>
          </div>
        </a>
      </div>
    </div>

    <!-- Google Maps -->
    <div class="text-center mb-3">
      <h5 class="fw-bold mb-3 maps-title" style="color: #d97706; font-size: 1.2rem;">
        <i class="bi bi-pin-map-fill me-2"></i>Lokasi Kami
      </h5>
    </div>
    <div class="maps-container" style="border-radius: 15px; overflow: hidden; box-shadow: 0 8px 20px rgba(0,0,0,0.15);">
      <iframe
        src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3954.6904820811205!2d111.90505247443035!3d-7.608620775208614!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x2e784b0029ea6d53%3A0xd3f37a9ee10f047b!2sPUDDINGKU%20DESSERT%20BAR!5e0!3m2!1sid!2sid!4v1760835777982!5m2!1sid!2sid"
        width="100%"
        height="250"
        style="border:0;"
        allowfullscreen=""
        loading="lazy"
        referrerpolicy="no-referrer-when-downgrade">
      </iframe>
    </div>
  </div>
</section>

  <footer class="text-center py-4" style="background: linear-gradient(135deg, #FFE5EC, #FFC9D9);color: #8d4949; margin: 0; width: 100%;">
    <p class="mb-1">© 2025 PUDDINGKU | Cita Rasa Lokal, Kualitas Nasional</p>
</footer>

  <a href="https://wa.me/628157765777" target="_blank" 
     class="position-fixed bottom-0 start-0 m-4 btn btn-success rounded-circle shadow" 
     style="width:60px;height:60px;display:flex;justify-content:center;align-items:center;font-size:1.6rem;">
    <i class="bi bi-whatsapp"></i>
  </a>
   
 <!-- Tombol Back to Top (sudah ada di HTML kamu) -->
<button id="toTopBtn" class="btn btn-warning position-fixed bottom-0 end-0 m-5 rounded-circle shadow" style="width:60px;height:60px;display:flex;justify-content:center;align-items:center;font-size:1.5rem;z-index:999;">
  <i class="bi bi-arrow-up"></i>
</button>

<script>
  document.querySelectorAll('.card.h-100').forEach(card => {
    card.addEventListener('click', () => {
      document
        .querySelectorAll('.card.h-100')
        .forEach(c => c.classList.remove('active-card'));
      card.classList.add('active-card');
    });
  });
</script>

<script>
// Auto Slider
let currentSlide = 0;
const slides = document.querySelectorAll('.slide');
const totalSlides = slides.length;

function showSlide(n) {
  // Hapus class active dari semua slide
  slides.forEach(slide => {
    slide.classList.remove('active');
  });
  
  // Tambahkan class active ke slide yang dipilih
  slides[n].classList.add('active');
}

function nextSlide() {
  currentSlide = (currentSlide + 1) % totalSlides;
  showSlide(currentSlide);
}

// Auto slide setiap 3 detik (3000 ms)
setInterval(nextSlide, 3000);
</script>

<!-- JavaScript untuk fungsi Back to Top -->
<script>
// Tombol Back to Top
const toTopBtn = document.getElementById("toTopBtn");

// Sembunyikan tombol saat pertama kali load
toTopBtn.style.display = "none";

// Tampilkan tombol saat scroll ke bawah
window.addEventListener("scroll", function() {
  if (window.scrollY > 300) {
    toTopBtn.style.display = "flex";
  } else {
    toTopBtn.style.display = "none";
  }
});

// Fungsi scroll ke atas saat tombol diklik
toTopBtn.addEventListener("click", function() {
  window.scrollTo({
    top: 0,
    behavior: "smooth"
  });
});
</script>

  <script>
    // Navbar scroll effect
    window.addEventListener("scroll", function() {
      const navbar = document.querySelector(".navbar");
      navbar.classList.toggle("scrolled", window.scrollY > 50);
    });

    // Navbar active state on click
    document.addEventListener('DOMContentLoaded', function() {
      const navLinks = document.querySelectorAll('.nav-link');
      
      navLinks.forEach(link => {
        link.addEventListener('click', function() {
          // Hapus active dari semua link
          navLinks.forEach(nav => nav.classList.remove('active'));
          // Tambah active ke link yang diklik
          this.classList.add('active');
        });
      });

      // Update active state based on scroll position
      window.addEventListener('scroll', function() {
        let current = '';
        const sections = document.querySelectorAll('section[id]');
        
        sections.forEach(section => {
          const sectionTop = section.offsetTop;
          const sectionHeight = section.clientHeight;
          if (pageYOffset >= (sectionTop - 200)) {
            current = section.getAttribute('id');
          }
        });

        navLinks.forEach(link => {
          link.classList.remove('active');
          if (link.getAttribute('href') === '#' + current) {
            link.classList.add('active');
          }
        });
      });
    });
  </script>

  <script src="https://unpkg.com/aos@2.3.4/dist/aos.js"></script>
  <script>
  AOS.init({ duration: 1000, once: true });
  </script>

</body>

</html>