<?php
session_start();
include __DIR__ . '/../koneksi.php';

if (!isset($_SESSION['username']) || $_SESSION['id_role'] != "1") {
    header("location:../index.php?pesan=akses_ditolak");
    exit();
}

$id_user = $_SESSION['id_user'];
$username = $_SESSION['username'];

// Cek jika keranjang kosong
if (empty($_SESSION['keranjang'])) {
    header("location:keranjang.php");
    exit();
}

$pesan_sukses = false;
$id_order_baru = 0;
$total_bayar = 0;

// ==========================================
// PROSES CHECKOUT (Jika tombol Konfirmasi diklik)
// ==========================================
if (isset($_POST['proses_checkout'])) {
    
    // 1. Hitung total belanja dari session keranjang
    foreach ($_SESSION['keranjang'] as $id_produk => $qty) {
        $q_prod = mysqli_query($koneksi, "SELECT price FROM product WHERE id_product = '$id_produk'");
        $d_prod = mysqli_fetch_assoc($q_prod);
        $total_bayar += ($d_prod['price'] * $qty);
    }

    // Ambil id_agent dari produk pertama di keranjang (asumsi 1 keranjang dari 1 agent)
    $first_id = array_key_first($_SESSION['keranjang']);
    $q_agent = mysqli_query($koneksi, "SELECT id_agent FROM product WHERE id_product = '$first_id'");
    $d_agent = mysqli_fetch_assoc($q_agent);
    $id_agent = $d_agent['id_agent'];

    // 2. Insert ke tabel `orders`
    $tgl_order = date('Y-m-d H:i:s');
    $query_order = "INSERT INTO orders (order_date, total_price, id_user, id_agent) 
                    VALUES ('$tgl_order', '$total_bayar', '$id_user', '$id_agent')";
    mysqli_query($koneksi, $query_order);
    
    $id_order_baru = mysqli_insert_id($koneksi);

    // 3. Loop isi keranjang: Insert ke `order_detail` & Kurangi Stok `product`
    foreach ($_SESSION['keranjang'] as $id_produk => $qty) {
        $q_prod = mysqli_query($koneksi, "SELECT price FROM product WHERE id_product = '$id_produk'");
        $d_prod = mysqli_fetch_assoc($q_prod);
        $subtotal = $d_prod['price'] * $qty;

        // Insert detail
        $query_detail = "INSERT INTO order_detail (id_order, id_product, quantity_item, subtotal, status) 
                         VALUES ('$id_order_baru', '$id_produk', '$qty', '$subtotal', 'MENUNGGU KONFIRMASI AGENT')";
        mysqli_query($koneksi, $query_detail);

        // Kurangi stok produk
        $query_stok = "UPDATE product SET stock = stock - '$qty' WHERE id_product = '$id_produk'";
        mysqli_query($koneksi, $query_stok);
    }

    // 4. Kosongkan keranjang
    unset($_SESSION['keranjang']);
    $pesan_sukses = true;
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Checkout - GalonKu</title>
    <?php include '../layout/assets.php'; ?>
</head>
<body class="font-sans antialiased bg-surface">

    <?php include '../layout/navbar.php'; ?>

    <main class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-6 md:py-8">

        <?php if (!$pesan_sukses): ?>
            <!-- ========================================== -->
            <!-- TAMPILAN SEBELUM CHECKOUT (RINGKASAN)      -->
            <!-- ========================================== -->
            <div class="mb-6">
                <h1 class="text-2xl md:text-3xl font-extrabold text-primary mb-2">Konfirmasi Pesanan</h1>
                <p class="text-sm text-gray-500">Periksa kembali pesanan Anda sebelum melakukan pembayaran.</p>
            </div>

            <div class="bg-white rounded-2xl shadow-sm border-2 border-gray-200 overflow-hidden mb-6">
                <div class="p-6">
                    <h3 class="font-bold text-primary mb-4 border-b pb-2">Rincian Belanja</h3>
                    <div class="space-y-3">
                        <?php
                        $total_belanja = 0;
                        foreach ($_SESSION['keranjang'] as $id_produk => $qty) {
                            $query = mysqli_query($koneksi, "SELECT * FROM product WHERE id_product = '$id_produk'");
                            $p = mysqli_fetch_assoc($query);
                            if (!$p) continue;
                            $subtotal = $p['price'] * $qty;
                            $total_belanja += $subtotal;
                        ?>
                        <div class="flex justify-between items-center text-sm">
                            <div>
                                <p class="font-bold text-primary"><?= htmlspecialchars($p['name_product']); ?></p>
                                <p class="text-gray-500"><?= $qty; ?> x Rp <?= number_format($p['price'], 0, ',', '.'); ?></p>
                            </div>
                            <p class="font-bold text-primary">Rp <?= number_format($subtotal, 0, ',', '.'); ?></p>
                        </div>
                        <?php } ?>
                    </div>
                </div>
                
                <div class="bg-gray-50 p-6 border-t-2 border-gray-200 flex justify-between items-center">
                    <div>
                        <p class="text-sm text-gray-500 font-medium">Total Pembayaran</p>
                        <p class="text-2xl font-extrabold text-primary">Rp <?= number_format($total_belanja, 0, ',', '.'); ?></p>
                    </div>
                    <form action="" method="POST">
                        <button type="submit" name="proses_checkout" class="bg-primary text-white px-8 py-3 rounded-xl font-bold hover:bg-secondary transition shadow-md">
                            Konfirmasi & Bayar <i class="fa-solid fa-arrow-right ml-1"></i>
                        </button>
                    </form>
                </div>
            </div>

        <?php else: ?>
            <!-- ========================================== -->
            <!-- TAMPILAN SETELAH CHECKOUT (QRIS DUMMY)     -->
            <!-- ========================================== -->
            <div class="bg-white rounded-2xl shadow-soft border-2 border-gray-200 overflow-hidden max-w-lg mx-auto text-center">
                <div class="bg-green-50 p-6 border-b-2 border-green-100">
                    <div class="w-16 h-16 bg-green-100 text-green-600 rounded-full flex items-center justify-center mx-auto mb-3">
                        <i class="fa-solid fa-check text-3xl"></i>
                    </div>
                    <h2 class="text-xl font-bold text-green-800">Pesanan Berhasil Dibuat!</h2>
                    <p class="text-sm text-green-600 mt-1">Silakan selesaikan pembayaran Anda.</p>
                </div>

                <div class="p-8">
                    <p class="text-sm text-gray-500 mb-1">Total Tagihan</p>
                    <p class="text-3xl font-extrabold text-primary mb-6">Rp <?= number_format($total_bayar, 0, ',', '.'); ?></p>

                    <div class="bg-gray-50 p-4 rounded-xl border border-gray-200 inline-block mb-4">
                        <!-- Gambar QRIS Dummy menggunakan API generate QR -->
                        <img src="https://api.qrserver.com/v1/create-qr-code/?size=200x200&data=QRIS_DUMMY_GALONKU_<?= $id_order_baru; ?>_<?= $total_bayar; ?>" 
                             alt="QRIS Pembayaran" class="w-48 h-48 mix-blend-multiply">
                    </div>
                    
                    <p class="text-xs text-gray-500 mb-6">Scan QRIS ini dengan aplikasi Mobile Banking atau E-Wallet Anda (DANA, OVO, Gopay).</p>

                    <div class="border-t border-dashed border-gray-300 pt-6 flex flex-col gap-3">
                        <a href="detail_pesanan.php?id=<?= $id_order_baru; ?>" class="w-full bg-primary text-white py-3 rounded-xl font-bold hover:bg-secondary transition shadow-md">
                            Lihat Detail Pesanan
                        </a>
                        <a href="dashboard.php" class="w-full bg-gray-100 text-gray-600 py-3 rounded-xl font-bold hover:bg-gray-200 transition">
                            Kembali ke Dashboard
                        </a>
                    </div>
                </div>
            </div>
        <?php endif; ?>

    </main>

    <?php include '../layout/footer.php'; ?>
</body>
</html>