<?php
session_start();
include __DIR__ . '/../koneksi.php'; 

if (!isset($_SESSION['username']) || $_SESSION['id_role'] != "1") {
    header("location:../index.php?pesan=akses_ditolak");
    exit();
}

$username = $_SESSION['username'];
$id_user  = $_SESSION['id_user']; 
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pesanan - GalonKu</title>
    <?php include '../layout/assets.php'; ?>
</head>
<body class="font-sans antialiased bg-surface">

    <?php include '../layout/navbar.php'; ?>

    <main class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-6 md:py-8">

        <div class="mb-6">
            <h1 class="text-2xl md:text-3xl font-extrabold text-primary mb-2">Pesanan Saya</h1>
            <p class="text-sm text-gray-500">Pantau status pengiriman pesananmu di sini.</p>
        </div>

        <div class="bg-white rounded-2xl p-2 mb-6 shadow-soft flex gap-1 overflow-x-auto scrollbar-hide border border-gray-400">
            <button class="px-4 md:px-6 py-2.5 rounded-xl bg-primary text-white text-xs md:text-sm font-semibold whitespace-nowrap border border-gray-400">Semua</button>
            <!-- Tombol filter lainnya bisa disesuaikan nanti -->
        </div>

        <div class="space-y-4">

            <?php
            // 1. QUERY UTAMA: Ambil data dari tabel orders milik user yang login
            $query_order = "SELECT * FROM orders WHERE id_user = '$id_user' ORDER BY order_date DESC";
            $result_order = mysqli_query($koneksi, $query_order);

            if (mysqli_num_rows($result_order) == 0) {
                echo '<div class="bg-white p-8 rounded-2xl shadow-soft text-center border border-gray-400">
                        <i class="fa-solid fa-box-open text-4xl text-gray-300 mb-3"></i>
                        <p class="text-gray-500 text-sm">Belum ada pesanan saat ini.</p>
                      </div>';
            }

            // 2. LOOPING UTAMA (Per Pesanan)
            while ($order = mysqli_fetch_array($result_order)) { 
                
                // Karena di tabel orders tidak ada kolom status, kita buat status dummy/default "Diproses"
                // (Kecuali Anda punya tabel history yang mencatat status, ini bisa disesuaikan)
                $status = "Diproses"; 
                $badgeClass = "bg-blue-100 text-blue-600";
                $iconClass = "fa-spinner";
            ?>

            <div class="bg-white rounded-2xl p-4 md:p-6 shadow-soft border border-gray-400">
                <!-- Header Pesanan -->
                <div class="flex flex-wrap justify-between items-start gap-3 pb-4 border-b border-gray-100">
                    <div>
                        <p class="text-xs text-accent mb-1">No. Pesanan</p>
                        <p class="font-bold text-primary text-sm">#ORD-<?= $order['id_order']; ?></p>
                    </div>
                    <div class="text-right">
                        <span class="inline-flex items-center gap-1 <?= $badgeClass; ?> text-xs font-semibold px-3 py-1.5 rounded-full">
                            <i class="fa-solid <?= $iconClass; ?>"></i> <?= $status; ?>
                        </span>
                        <p class="text-xs text-accent mt-1"><?= date('d M Y, H:i', strtotime($order['order_date'])); ?></p>
                    </div>
                </div>

                <!-- 3. QUERY DETAIL: Ambil barang-barang di pesanan ini -->
                <?php
                $id_order = $order['id_order'];
                $query_detail = "SELECT od.*, p.name_product, p.img 
                                 FROM order_detail od 
                                 JOIN product p ON od.id_product = p.id_product 
                                 WHERE od.id_order = '$id_order'";
                $result_detail = mysqli_query($koneksi, $query_detail);
                
                // LOOPING KEDUA (Per Barang dalam Pesanan)
                while ($detail = mysqli_fetch_array($result_detail)) {
                ?>
                <div class="flex items-center gap-4 py-4 border-b border-gray-50 last:border-0">
                    <div class="w-16 h-16 bg-gray-50 rounded-xl flex items-center justify-center flex-shrink-0 overflow-hidden border border-gray-200">
                        <?php if (!empty($detail['img']) && strpos($detail['img'], 'dummy') === false) { ?>
                            <img src="<?= $detail['img']; ?>" class="w-full h-full object-cover" alt="<?= $detail['name_product']; ?>">
                        <?php } else { ?>
                            <i class="fa-solid fa-droplet text-secondary text-2xl"></i>
                        <?php } ?>
                    </div>
                    <div class="flex-1 min-w-0">
                        <h3 class="font-semibold text-primary text-sm truncate"><?= htmlspecialchars($detail['name_product']); ?></h3>
                        <p class="text-xs text-accent"><?= $detail['quantity_item']; ?> item x Rp <?= number_format($detail['subtotal'] / $detail['quantity_item'], 0, ',', '.'); ?></p>
                    </div>
                    <p class="font-bold text-primary text-sm">Rp <?= number_format($detail['subtotal'], 0, ',', '.'); ?></p>
                </div>
                <?php } // Akhir looping detail ?>

                <!-- Total Harga -->
                <div class="flex justify-between items-center py-4 border-t border-gray-100 mt-2">
                    <span class="text-sm font-semibold text-accent">Total Belanja</span>
                    <span class="text-lg font-extrabold text-primary">Rp <?= number_format($order['total_price'], 0, ',', '.'); ?></span>
                </div>

                <!-- Tombol Aksi -->
                <div class="flex flex-col sm:flex-row gap-2 pt-2">
                    <button class="flex-1 text-center bg-primary text-white py-2.5 rounded-xl text-sm font-semibold hover:bg-secondary transition">
                        Lacak Pesanan
                    </button>
                    <button class="flex-1 text-center border border-gray-200 text-accent py-2.5 rounded-xl text-sm font-semibold hover:bg-surface transition">
                        Hubungi Kurir
                    </button>
                </div>
            </div>

            <?php } // Akhir looping order ?>
            
        </div>
    </main>

    <?php include '../layout/footer.php'; ?>
</body>
</html>