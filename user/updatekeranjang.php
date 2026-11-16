<?php
session_start();

// Beritahu browser bahwa balasan berupa format JSON
header('Content-Type: application/json');

if (!isset($_SESSION['keranjang'])) {
    echo json_encode(['status' => 'error', 'message' => 'Keranjang kosong']);
    exit;
}

$response = ['status' => 'success'];

// AKSI HAPUS SATU ITEM
if (isset($_POST['hapus'])) {
    $id_hapus = $_POST['hapus'];
    unset($_SESSION['keranjang'][$id_hapus]);
    $response['message'] = 'Barang dihapus';
}

// AKSI UPDATE JUMLAH (TAMBAH/KURANG)
if (isset($_POST['update_qty'])) {
    $id_produk = $_POST['id_produk'];
    $jumlah_baru = (int)$_POST['jumlah'];
    
    if ($jumlah_baru > 0) {
        $_SESSION['keranjang'][$id_produk] = $jumlah_baru;
        $response['message'] = 'Jumlah diupdate';
    } else {
        // Jika user mengurangi sampai 0, hapus dari keranjang
        unset($_SESSION['keranjang'][$id_produk]);
        $response['message'] = 'Barang dihapus';
    }
}

// Kembalikan respon
echo json_encode($response);
?>