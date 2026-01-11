<?php
include 'koneksi.php';
header('Content-Type: application/json');

$sql = "SELECT id, nama, items, total, status, waktu, tracking 
        FROM order_dashboard 
        ORDER BY waktu DESC";

$result = $koneksi->query($sql);

$data = [];

while ($row = $result->fetch_assoc()) {

  // Jika bukan JSON, tampilkan sebagai string biasa
$decoded = json_decode($row['items'], true);
if ($decoded) {
    $items = $decoded;
} else {
    $items = [
        ["name" => $row['items'], "qty" => ""]
    ];
}


    $data[] = [
        "order_code" => $row['id'],        // menyesuaikan dengan JS
        "created"    => $row['waktu'],     // JS pakai "created"
        "customer"   => $row['nama'],      // JS pakai "customer"
        "items"      => $items,            // HARUS array
        "total"      => intval($row['total']), // HARUS number
        "status"     => $row['status'],
    ];
}

echo json_encode($data);
?>
