<?php
session_start();
include __DIR__ . '/../koneksi.php';

// Tambah ke keranjang
if (isset($_POST['tambah_keranjang'])) {
    $id_produk = $_POST['id_produk'];
    $qty       = (int)$_POST['qty'];

    // Jika session keranjang belum ada, buat array baru
    if (!isset($_SESSION['keranjang'])) {
        $_SESSION['keranjang'] = array();
    }

    // Jika produk sudah ada di keranjang, tambahkan jumlahnya
    if (isset($_SESSION['keranjang'][$id_produk])) {
        $_SESSION['keranjang'][$id_produk] += $qty;
    } else {
        // Jika belum ada, masukkan sebagai item baru
        $_SESSION['keranjang'][$id_produk] = $qty;
    }

    // Redirect ke halaman keranjang
    header("Location:../user/keranjang.php");
    exit;
}
?>