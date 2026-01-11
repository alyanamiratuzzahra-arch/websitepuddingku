<!-- ============================================ -->
<!-- BAGIAN 1: KONEKSI DATABASE -->
<!-- Fungsi: Menghubungkan ke database MySQL -->
<!-- ============================================ -->
<?php include 'koneksi.php'; ?>

<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Ulasan Puddingku</title>

<style>
/* ============================================ */
/* BAGIAN 2: STYLING BODY (TAMPILAN UTAMA) */
/* Fungsi: Mengatur font, background, warna */
/* ============================================ */
 body {
  font-family: 'Poppins', sans-serif;  /* Font modern */
  background: linear-gradient(rgba(255, 214, 214, 0.65), rgba(255, 214, 214, 0.65)),
              url("img/bg/bg_2 slide.jpg") center/cover no-repeat fixed;  /* Gradien pink + gambar */
  padding: 30px;  /* Jarak dari tepi layar */
  color: #333;  /* Warna teks abu gelap */
}

/* ============================================ */
/* BAGIAN 3: TOMBOL KEMBALI */
/* Fungsi: Tombol bulat di kiri atas untuk kembali */
/* ============================================ */
.back-button {
  position: fixed;  /* Nempel terus meski di-scroll */
  top: 20px;
  left: 20px;
  background: rgba(255, 255, 255, 0.8);  /* Putih transparan */
  backdrop-filter: blur(6px);  /* Efek blur */
  border-radius: 50%;  /* Bulat sempurna */
  width: 45px;
  height: 45px;
  display: flex;
  justify-content: center;
  align-items: center;
  color: #b16b33;  /* Warna coklat */
  font-size: 24px;
  text-decoration: none;
  box-shadow: 0 2px 8px rgba(0,0,0,0.2);  /* Bayangan */
  transition: all 0.3s ease;  /* Animasi smooth */
  z-index: 1000;  /* Di atas semua elemen */
}

.back-button:hover {
  background: #b16b33;  /* Hover: jadi coklat */
  color: white;  /* Teks jadi putih */
  transform: scale(1.1);  /* Membesar 10% */
}

/* ============================================ */
/* BAGIAN 4: CONTAINER UTAMA */
/* Fungsi: Wadah untuk semua konten */
/* ============================================ */
.rating-container {
  max-width: 850px;  /* Lebar maksimal */
  margin: 80px auto 30px auto;  /* Posisi tengah, margin atas 80px */
  display: flex;
  flex-direction: column;  /* Susunan vertikal */
  gap: 25px;  /* Jarak antar elemen */
}

/* ============================================ */
/* BAGIAN 5: CARD LIST ULASAN */
/* Fungsi: Styling untuk area daftar ulasan */
/* ============================================ */
.review-list {
  flex: 2;
  background: rgba(255,255,255,0.70);  /* Putih transparan 70% */
  backdrop-filter: blur(10px);  /* Efek kaca blur */
  border-radius: 15px;  /* Sudut melengkung */
  padding: 25px;
  box-shadow: 0 4px 15px rgba(0,0,0,0.2);  /* Bayangan untuk efek mengambang */
}

/* ============================================ */
/* BAGIAN 6: CARD FORM TAMBAH ULASAN */
/* Fungsi: Styling untuk form input ulasan */
/* ============================================ */
.add-review {
  flex: 1;
  background: rgba(255,255,255,0.80);  /* Putih transparan 80% */
  backdrop-filter: blur(8px);
  border-radius: 15px;
  padding: 20px;
  box-shadow: 0 4px 15px rgba(0,0,0,0.2);
  height: fit-content;  /* Tinggi menyesuaikan isi */
}

/* ============================================ */
/* BAGIAN 7: GRID LAYOUT 2 KOLOM */
/* Fungsi: Ulasan ditampilkan 2 kolom sejajar */
/* ============================================ */
#reviews {
  display: grid;
  grid-template-columns: 1fr 1fr;  /* 2 kolom sama lebar */
  gap: 20px;  /* Jarak antar card */
}

/* ============================================ */
/* BAGIAN 8: RESPONSIVE MOBILE */
/* Fungsi: Di HP jadi 1 kolom */
/* ============================================ */
@media (max-width: 768px) {
  .rating-container {
    flex-direction: column;  /* Susunan vertikal di HP */
  }
}

/* ============================================ */
/* BAGIAN 9: CARD BOX ULASAN */
/* Fungsi: Styling card dengan efek hover */
/* ============================================ */
.card-box {
  background: rgba(255,255,255,0.75);
  backdrop-filter: blur(12px);
  padding: 25px;
  border-radius: 18px;
  box-shadow: 0 4px 18px rgba(0,0,0,0.2);
  transition: transform .3s ease, box-shadow .3s ease;  /* Animasi smooth */
}

.card-box:hover {
  transform: translateY(-4px);  /* Naik 4px saat di-hover */
  box-shadow: 0 6px 20px rgba(0,0,0,0.25);  /* Bayangan lebih gelap */
}

/* ============================================ */
/* BAGIAN 10: CARD ULASAN INDIVIDUAL */
/* Fungsi: Styling setiap ulasan */
/* ============================================ */
.review {
  background: rgba(255,255,255,0.6);
  backdrop-filter: blur(6px);
  border-radius: 10px;
  padding: 15px;
  margin-top: 15px;
  transition: 0.3s;
}

.review:hover { 
  transform: translateY(-3px);  /* Naik 3px saat di-hover */
}

/* ============================================ */
/* BAGIAN 11: GAMBAR ULASAN */
/* Fungsi: Styling gambar yang di-upload user */
/* ============================================ */
.review-image {
  width: 100px;
  height: 100px;
  object-fit: cover;  /* Potong gambar sesuai ukuran */
  border-radius: 12px;  /* Sudut melengkung */
  margin-top: 8px;
}

/* ============================================ */
/* BAGIAN 12: WRAPPER DOUBLE BOX */
/* Fungsi: Box luar untuk setiap ulasan */
/* ============================================ */
.review-wrapper {
  background: rgba(255, 255, 255, 0.85);
  border-radius: 15px;
  box-shadow: 0 4px 12px rgba(0,0,0,0.15);
  padding: 20px;
  margin-bottom: 25px;
}

.review {
  background: rgba(255, 255, 255, 0.6);
  border: 1px solid #ddd;  /* Border abu-abu tipis */
  border-radius: 10px;
  padding: 15px;
  margin-top: 10px;
  transition: 0.3s;
}

.review:hover { 
  transform: translateY(-3px); 
}

/* ============================================ */
/* BAGIAN 13: HEADER ULASAN (NAMA & RATING) */
/* Fungsi: Bagian atas ulasan (user & bintang) */
/* ============================================ */
.review-header {
  display: flex;
  justify-content: space-between;  /* Nama kiri, rating kanan */
  align-items: center;
}

.review-header h4 {
  color: #b16b33;  /* Nama user warna coklat */
  margin: 0;
}

.review-rating {
  color: gold;  /* Bintang warna emas */
  font-size: 18px;
}

/* ============================================ */
/* BAGIAN 14: INPUT FORM */
/* Fungsi: Styling input & textarea */
/* ============================================ */
.add-review input,
.add-review textarea {
  width: 100%;
  padding: 12px;
  border-radius: 8px;
  border: 1px solid #ddd;
  margin-bottom: 10px;
}

/* ============================================ */
/* BAGIAN 15: TOMBOL KIRIM */
/* Fungsi: Styling tombol submit ulasan */
/* ============================================ */
.add-review button {
  width: 100%;
  padding: 12px;
  margin-top: 5px;
  background: #b16b33;  /* Warna coklat */
  color: white;
  border: none;
  border-radius: 8px;
  cursor: pointer;  /* Kursor jadi tangan saat hover */
}

/* ============================================ */
/* BAGIAN 16: BINTANG RATING */
/* Fungsi: Styling bintang untuk pilih rating */
/* ============================================ */
#star-input span {
  font-size: 32px;  /* Bintang besar */
  cursor: pointer;  /* Bisa diklik */
  color: #ccc;  /* Abu-abu (belum dipilih) */
}
#star-input { margin-bottom: 10px; }
</style>
</head>
<body>

<!-- ============================================ -->
<!-- BAGIAN 17: TOMBOL KEMBALI HTML -->
<!-- Fungsi: Link kembali ke halaman kelompok.php -->
<!-- ============================================ -->
<a href="index.php" class="back-button" title="Kembali ke halaman utama">⟵</a>

<div class="rating-container">

  <!-- ============================================ -->
  <!-- BAGIAN 18: FORM TAMBAH ULASAN -->
  <!-- Fungsi: Form untuk user input ulasan baru -->
  <!-- ============================================ -->
  <div class="card-box add-review">
    <h3>Tambah Ulasan Produk 🍮</h3>
    <!-- Input nama produk -->
    <input type="text" id="review-product" placeholder="Nama produk (contoh: Dessert Banoffee)">
    <!-- Input username -->
    <input type="text" id="review-username" placeholder="Username">
    <!-- Bintang rating (klik untuk pilih) -->
    <div id="star-input">
      <span data-value="1">★</span>
      <span data-value="2">★</span>
      <span data-value="3">★</span>
      <span data-value="4">★</span>
      <span data-value="5">★</span>
    </div>
    <!-- Textarea untuk tulis ulasan -->
    <textarea id="review-text" placeholder="Tulis ulasan kamu di sini..."></textarea>
    <!-- Upload gambar -->
    <input type="file" id="review-image" accept="image/*">
    <!-- Tombol kirim -->
    <button id="submit-review">KIRIM ULASAN</button>
  </div>

  <!-- ============================================ -->
  <!-- BAGIAN 19: TAMPILAN DAFTAR ULASAN -->
  <!-- Fungsi: Menampilkan rating rata-rata & semua ulasan -->
  <!-- ============================================ -->
  <div class="card-box">
    <h2>Ulasan Pelanggan 🍮</h2>
    <!-- Rating rata-rata (angka) -->
    <div id="avg-rating" style="font-size: 30px; font-weight: bold;">0.0</div>
    <!-- Rating rata-rata (bintang) -->
    <div id="avg-stars" style="color:#ffb400; font-size: 22px;">☆☆☆☆☆</div>
    <!-- Total jumlah ulasan -->
    <div id="total-reviews">Belum ada ulasan</div>
    <hr>
    <!-- Container untuk semua ulasan -->
    <div id="reviews" class="reviews-grid"></div>
</div>

</div>

<script>
/* ============================================ */
/* BAGIAN 20: VARIABEL GLOBAL JAVASCRIPT */
/* Fungsi: Menyimpan data ulasan & rating yang dipilih */
/* ============================================ */
let reviews = JSON.parse(localStorage.getItem("puddingReviews")) || [];  // Ambil data dari browser
let selectedRating = 0;  // Rating yang dipilih user (default 0)

/* ============================================ */
/* BAGIAN 21: FUNGSI SIMPAN KE LOCALSTORAGE */
/* Fungsi: Menyimpan data ulasan ke browser */
/* ============================================ */
function saveToLocalStorage() {
  localStorage.setItem("puddingReviews", JSON.stringify(reviews));
  // Data tetap ada meski browser ditutup
}

/* ============================================ */
/* BAGIAN 22: CSS GRID DINAMIS */
/* Fungsi: Tambahkan CSS grid 2 kolom via JavaScript */
/* ============================================ */
document.head.insertAdjacentHTML("beforeend", `
<style>
.reviews-grid {
  display: grid;
  grid-template-columns: repeat(2, 1fr);  /* 2 kolom sama lebar */
  gap: 25px;
}
@media (max-width: 768px) {
  .reviews-grid {
    grid-template-columns: 1fr;  /* 1 kolom di HP */
  }
}
</style>
`);

/* ============================================ */
/* BAGIAN 23: FUNGSI TAMPILKAN ULASAN */
/* Fungsi: Render semua ulasan ke halaman */
/* ============================================ */
function renderReviews() {
  const container = document.getElementById("reviews");
  container.innerHTML = "";  // Kosongkan dulu

  // Loop setiap ulasan
  reviews.forEach(r => {
    const card = document.createElement("div");  // Buat element div baru
    card.classList.add("review-wrapper");  // Tambah class
    card.innerHTML = `
      <div class="review">
        <div class="review-header">
          <h4>${r.user}</h4>  <!-- Nama user -->
          <!-- Bintang rating (★ penuh, ☆ kosong) -->
          <div class="review-rating">${"★".repeat(r.rating)}${"☆".repeat(5 - r.rating)}</div>
        </div>
        <div><b>Produk:</b> ${r.product}</div>  <!-- Nama produk -->
        <div style="margin:6px 0;">${r.text}</div>  <!-- Teks ulasan -->
        <!-- Gambar (jika ada) -->
        ${r.image ? `<img src="${r.image}" class="review-image">` : ""}
        <!-- Tombol hapus -->
        <button onclick="deleteReview(${r.id})"
          style="float:right;border:none;background:none;cursor:pointer;font-size:18px;">🗑</button>
      </div>
    `;
    container.appendChild(card);  // Tambahkan ke halaman
  });
}

/* ============================================ */
/* BAGIAN 24: FUNGSI HITUNG STATISTIK */
/* Fungsi: Hitung rating rata-rata & total ulasan */
/* ============================================ */
function renderStats() {
  const total = reviews.length;  // Jumlah ulasan
  // Hitung rata-rata (jumlah semua rating dibagi total)
  const avg = total ? (reviews.reduce((a, b) => a + b.rating, 0) / total).toFixed(1) : 0;
  document.getElementById("avg-rating").textContent = avg;  // Tampilkan angka
  // Tampilkan bintang (dibulatkan)
  document.getElementById("avg-stars").textContent =
    "★".repeat(Math.round(avg)) + "☆".repeat(5 - Math.round(avg));
  // Tampilkan total ulasan
  document.getElementById("total-reviews").textContent =
    total ? `Berdasarkan ${total} ulasan` : "Belum ada ulasan";
}

/* ============================================ */
/* BAGIAN 25: JALANKAN SAAT HALAMAN LOAD */
/* Fungsi: Tampilkan ulasan & statistik saat buka halaman */
/* ============================================ */
renderReviews();
renderStats();

/* ============================================ */
/* BAGIAN 26: EVENT KLIK BINTANG RATING */
/* Fungsi: Saat bintang diklik, warnai & simpan rating */
/* ============================================ */
document.querySelectorAll("#star-input span").forEach(star => {
  star.addEventListener("click", () => {
    selectedRating = parseInt(star.getAttribute("data-value"));  // Ambil nilai 1-5
    // Warnai bintang yang diklik jadi coklat, sisanya abu
    document.querySelectorAll("#star-input span").forEach(s =>
      s.style.color = s.getAttribute("data-value") <= selectedRating ? "#b16b33" : "#ccc"
    );
  });
});

/* ============================================ */
/* BAGIAN 27: EVENT KIRIM ULASAN */
/* Fungsi: Saat tombol KIRIM ULASAN diklik */
/* ============================================ */
document.getElementById("submit-review").addEventListener("click", async () => {
  // Ambil semua data dari form
  const product = document.getElementById("review-product").value.trim();
  const username = document.getElementById("review-username").value.trim() || "Pengguna Baru";
  const text = document.getElementById("review-text").value.trim();
  const imgFile = document.getElementById("review-image").files[0];

  // Validasi: harus diisi semua
  if (!product || !selectedRating || !text) {
    alert("Semua kolom wajib diisi dan rating harus dipilih!");
    return;
  }

  // Kirim data ke PHP untuk simpan ke database
  const res = await fetch("simpan_ulasan.php", {
    method: "POST",
    headers: { "Content-Type": "application/x-www-form-urlencoded" },
    body: `product=${encodeURIComponent(product)}&username=${encodeURIComponent(username)}&text=${encodeURIComponent(text)}`
  });

  const result = await res.text();
  alert(result);  // Tampilkan pesan dari PHP

  // Jika ada gambar, convert ke base64
  if (imgFile) {
    const reader = new FileReader();
    reader.onload = function(e) {
      addReview(e.target.result, product, username, text);  // Gambar jadi base64
    };
    reader.readAsDataURL(imgFile);
  } else {
    addReview(null, product, username, text);  // Tanpa gambar
  }
});

/* ============================================ */
/* BAGIAN 28: FUNGSI TAMBAH ULASAN BARU */
/* Fungsi: Menambahkan ulasan ke array & localStorage */
/* ============================================ */
function addReview(imageBase64, product, username, text) {
  // Buat objek ulasan baru
  const newReview = {
    id: Date.now(),  // ID unik dari timestamp
    product,
    user: username,
    rating: selectedRating,
    text,
    image: imageBase64  // Gambar dalam format base64 (atau null)
  };

  reviews.unshift(newReview);  // Tambah di awal array (ulasan terbaru di atas)
  saveToLocalStorage();  // Simpan ke browser
  
  // Reset form
  document.getElementById("review-product").value = "";
  document.getElementById("review-username").value = "";
  document.getElementById("review-text").value = "";
  document.getElementById("review-image").value = "";
  selectedRating = 0;
  document.querySelectorAll("#star-input span").forEach(s => s.style.color = "#ccc");
  
  // Refresh tampilan
  renderReviews();
  renderStats();
}

/* ============================================ */
/* BAGIAN 29: FUNGSI HAPUS ULASAN */
/* Fungsi: Menghapus ulasan berdasarkan ID */
/* ============================================ */
function deleteReview(id) {
  if (confirm("Hapus ulasan ini?")) {  // Konfirmasi dulu
    reviews = reviews.filter(r => r.id !== id);  // Filter: buang yang ID-nya sama
    saveToLocalStorage();  // Simpan perubahan
    renderReviews();  // Refresh tampilan
    renderStats();  // Update statistik
  }
}
</script>