<?php
include 'koneksi.php';
$id = intval($_GET['id']);
$q = mysqli_query($koneksi, "SELECT * FROM order_dashboard WHERE id=$id");
if(mysqli_num_rows($q)==0){ echo 'Data tidak ditemukan'; exit; }
$o = mysqli_fetch_assoc($q);
?>
<h3>Detail Pesanan</h3>
<p><b>Nama:</b> <?= htmlspecialchars($o['nama']) ?></p>
<p><b>Telepon:</b> <?= htmlspecialchars($o['telepon']) ?></p>
<p><b>Waktu:</b> <?= htmlspecialchars($o['waktu']) ?></p>
<p><b>Status:</b> <?= htmlspecialchars($o['status']) ?></p>
<p><b>Total:</b> Rp<?= number_format($o['total'],0,',','.') ?></p>
<h4>Items:</h4>
<pre><?= htmlspecialchars($o['items']) ?></pre>
<p><b>Tracking:</b><br><?= nl2br(htmlspecialchars($o['tracking'])) ?></p>
