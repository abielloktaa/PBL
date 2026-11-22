<?php
session_start();
include __DIR__ . '/../koneksi.php'; 

if (!isset($_SESSION['username']) || $_SESSION['id_role'] != "1") {
    header("location:../index.php?pesan=akses_ditolak");
    exit();
}

$username = $_SESSION['username'];
$id_user  = $_SESSION['id_user']; 

// ==========================================
// KONFIGURASI PAGINATION
// ==========================================
$limit = 4; // Tampilkan 4 pesanan per halaman
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$offset = ($page - 1) * $limit;
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

        <!-- Filter Pesanan -->
        <div class="bg-white rounded-2xl p-2 mb-6 shadow-sm flex gap-1 overflow-x-auto scrollbar-hide border-2 border-gray-200">
            <button class="px-6 py-2.5 rounded-xl bg-primary text-white text-sm font-bold whitespace-nowrap shadow-sm">Semua Pesanan</button>
        </div>

        <!-- Daftar Pesanan -->
        <div class="space-y-4">
            <?php
            // Hitung total pesanan untuk Pagination
            $query_count = "SELECT COUNT(id_order) AS total FROM orders WHERE id_user = '$id_user'";
            $result_count = mysqli_query($koneksi, $query_count);
            $total_data = mysqli_fetch_assoc($result_count)['total'] ?? 0;
            $total_pages = ceil($total_data / $limit);

            // Ambil data pesanan dengan LIMIT & OFFSET
            $query_order = "SELECT * FROM orders WHERE id_user = '$id_user' ORDER BY order_date DESC LIMIT $limit OFFSET $offset";
            $result_order = mysqli_query($koneksi, $query_order);

            if (mysqli_num_rows($result_order) == 0) {
                echo '<div class="bg-white p-8 rounded-2xl shadow-sm text-center border-2 border-gray-200">
                        <i class="fa-solid fa-box-open text-5xl text-gray-300 mb-3"></i>
                        <p class="text-gray-500 text-sm font-medium">Belum ada pesanan saat ini.</p>
                      </div>';
            }

            while ($order = mysqli_fetch_array($result_order)) { 
                $id_order = $order['id_order'];
                
                // LOGIKA PENENTUAN STATUS PESANAN (HEADER)
                $q_status = mysqli_query($koneksi, "SELECT status FROM order_detail WHERE id_order = '$id_order' ORDER BY FIELD(status, 'SELESAI', 'DIPROSES', 'PENGANTARAN', 'MENUNGGU KONFIRMASI AGENT') DESC LIMIT 1");
                $d_status = mysqli_fetch_assoc($q_status);
                $status_teratas = $d_status['status'] ?? 'MENUNGGU KONFIRMASI AGENT';

                // Menentukan Warna dan Ikon Badge berdasarkan Status
                $badgeClass = "bg-gray-100 text-gray-700 border-gray-300"; // Default
                $iconClass = "fa-clock";

                if ($status_teratas == 'SELESAI') {
                    $badgeClass = "bg-green-50 text-green-600 border border-green-200";
                    $iconClass = "fa-circle-check";
                } elseif ($status_teratas == 'DIPROSES') {
                    $badgeClass = "bg-blue-50 text-blue-600 border border-blue-200";
                    $iconClass = "fa-spinner fa-spin";
                } elseif ($status_teratas == 'PENGANTARAN') {
                    $badgeClass = "bg-orange-50 text-orange-600 border border-orange-200";
                    $iconClass = "fa-truck-fast";
                } elseif ($status_teratas == 'MENUNGGU KONFIRMASI AGENT') {
                    $badgeClass = "bg-gray-100 text-gray-600 border border-gray-300";
                    $iconClass = "fa-hourglass-half";
                }
            ?>

            <!-- Card Pesanan -->
            <div class="bg-white rounded-2xl shadow-sm border-2 border-gray-200 overflow-hidden hover:shadow-md transition-shadow">
                <!-- Header Card -->
                <div class="bg-gray-50 p-4 md:p-5 flex flex-wrap justify-between items-center border-b-2 border-gray-200 gap-3">
                    <div>
                        <p class="text-xs text-gray-500 font-medium mb-1">No. Pesanan</p>
                        <p class="font-bold text-primary text-base">#ORD-<?= $order['id_order']; ?></p>
                    </div>
                    <div class="text-right">
                        <span class="inline-flex items-center gap-1.5 <?= $badgeClass; ?> text-xs font-bold px-3 py-1 rounded-full mb-1">
                            <i class="fa-solid <?= $iconClass; ?>"></i> <?= $status_teratas; ?>
                        </span>
                        <p class="text-xs text-gray-500 font-medium"><?= date('d M Y, H:i', strtotime($order['order_date'])); ?></p>
                    </div>
                </div>

                <!-- Body Card (Rincian Barang) -->
                <div class="p-4 md:p-6">
                    <?php
                    $query_detail = "SELECT od.*, p.name_product, p.img 
                                     FROM order_detail od 
                                     JOIN product p ON od.id_product = p.id_product 
                                     WHERE od.id_order = '$id_order'";
                    $result_detail = mysqli_query($koneksi, $query_detail);
                    
                    while ($detail = mysqli_fetch_array($result_detail)) {
                    ?>
                    <div class="flex items-center gap-4 py-4 border-b border-gray-100 last:border-0">
                        <div class="w-16 h-16 bg-gray-50 rounded-xl flex items-center justify-center flex-shrink-0 overflow-hidden border border-gray-200">
                            <!-- Panggil gambar dari folder ../poto/ -->
                            <?php if (!empty($detail['img']) && is_string($detail['img']) && strpos($detail['img'], 'dummy') === false) { ?>
                                <img src="../poto/<?= $detail['img']; ?>" class="w-full h-full object-cover">
                            <?php } else { ?>
                                <i class="fa-solid fa-droplet text-secondary text-2xl"></i>
                            <?php } ?>
                        </div>
                        <div class="flex-1 min-w-0">
                            <h3 class="font-bold text-primary text-base truncate"><?= htmlspecialchars($detail['name_product']); ?></h3>
                            <div class="flex flex-wrap items-center gap-2 mt-1">
                                <p class="text-sm text-gray-500"><?= $detail['quantity_item']; ?> barang x Rp <?= number_format($detail['subtotal'] / $detail['quantity_item'], 0, ',', '.'); ?></p>
                                
                                <!-- Menampilkan Status Spesifik per Barang -->
                                <span class="text-[10px] font-semibold text-gray-400 bg-gray-100 px-2 py-0.5 rounded">
                                    Status: <?= $detail['status']; ?>
                                </span>
                            </div>
                        </div>
                        <p class="font-extrabold text-primary text-base text-right">Rp <?= number_format($detail['subtotal'], 0, ',', '.'); ?></p>
                    </div>
                    <?php } ?>
                </div>

                <!-- Footer Card (Total & Aksi) -->
                <div class="bg-gray-50 p-4 md:p-5 border-t-2 border-gray-200 flex flex-col sm:flex-row justify-between items-center gap-4">
                    <div class="text-center sm:text-left">
                        <span class="text-sm text-gray-500 font-medium">Total Belanja</span>
                        <p class="text-xl font-extrabold text-primary">Rp <?= number_format($order['total_price'], 0, ',', '.'); ?></p>
                    </div>
                    <div class="flex gap-3 w-full sm:w-auto">
                        <a href="detail_pesanan.php?id=<?= $order['id_order']; ?>" class="flex-1 sm:flex-none text-center bg-primary text-white px-6 py-2.5 rounded-xl text-sm font-bold hover:bg-secondary transition shadow-sm">
                            Detail Pesanan
                        </a>
                        <button class="flex-1 sm:flex-none text-center border-2 border-gray-300 bg-white text-gray-600 px-6 py-2.5 rounded-xl text-sm font-bold hover:bg-gray-100 transition">
                            Hubungi Kurir
                        </button>
                    </div>
                </div>
            </div>
            <?php } ?>
        </div>

        <!-- PAGINATION -->
        <?php if ($total_pages > 1): ?>
        <div class="flex justify-center items-center gap-2 mt-8">
            <!-- Tombol Previous -->
            <?php if ($page > 1): ?>
                <a href="?page=<?= $page - 1; ?>" class="w-10 h-10 rounded-xl border-2 border-gray-300 bg-white flex items-center justify-center text-gray-500 hover:bg-gray-50 hover:text-primary transition">
                    <i class="fa-solid fa-chevron-left text-xs"></i>
                </a>
            <?php else: ?>
                <button disabled class="w-10 h-10 rounded-xl border-2 border-gray-200 bg-gray-50 flex items-center justify-center text-gray-300 cursor-not-allowed">
                    <i class="fa-solid fa-chevron-left text-xs"></i>
                </button>
            <?php endif; ?>

            <!-- Nomor Halaman -->
            <?php for ($i = 1; $i <= $total_pages; $i++): ?>
                <?php if ($i == $page): ?>
                    <span class="w-10 h-10 rounded-xl bg-primary text-white flex items-center justify-center text-sm font-bold shadow-md">
                        <?= $i; ?>
                    </span>
                <?php else: ?>
                    <a href="?page=<?= $i; ?>" class="w-10 h-10 rounded-xl border-2 border-gray-300 bg-white flex items-center justify-center text-gray-600 text-sm font-bold hover:bg-gray-50 hover:text-primary transition">
                        <?= $i; ?>
                    </a>
                <?php endif; ?>
            <?php endfor; ?>

            <!-- Tombol Next -->
            <?php if ($page < $total_pages): ?>
                <a href="?page=<?= $page + 1; ?>" class="w-10 h-10 rounded-xl border-2 border-gray-300 bg-white flex items-center justify-center text-gray-500 hover:bg-gray-50 hover:text-primary transition">
                    <i class="fa-solid fa-chevron-right text-xs"></i>
                </a>
            <?php else: ?>
                <button disabled class="w-10 h-10 rounded-xl border-2 border-gray-200 bg-gray-50 flex items-center justify-center text-gray-300 cursor-not-allowed">
                    <i class="fa-solid fa-chevron-right text-xs"></i>
                </button>
            <?php endif; ?>
        </div>
        <?php endif; ?>

    </main>

    <?php include '../layout/footer.php'; ?>
</body>
</html>