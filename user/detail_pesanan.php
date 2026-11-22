<?php
session_start();
include __DIR__ . '/../koneksi.php';

if (!isset($_SESSION['username']) || $_SESSION['id_role'] != "1") {
    header("location:../index.php?pesan=akses_ditolak");
    exit();
}

$id_user = $_SESSION['id_user'];
$id_order = $_GET['id'] ?? 0;

// Ambil data pesanan
$query_order = "SELECT o.*, u.username AS agent_name, u.depot, u.no_hp AS agent_hp 
                FROM orders o 
                JOIN users u ON o.id_agent = u.id_user 
                WHERE o.id_order = '$id_order' AND o.id_user = '$id_user'";
$result_order = mysqli_query($koneksi, $query_order);
$order = mysqli_fetch_assoc($result_order);

if (!$order) {
    echo "<script>alert('Pesanan tidak ditemukan!'); window.location='riwayat.php';</script>";
    exit();
}

// Ambil data alamat pembeli
$query_user = mysqli_query($koneksi, "SELECT * FROM users WHERE id_user = '$id_user'");
$user = mysqli_fetch_assoc($query_user);

// LOGIKA STATUS HEADER
$q_status = mysqli_query($koneksi, "SELECT status FROM order_detail WHERE id_order = '$id_order' ORDER BY FIELD(status, 'SELESAI', 'DIPROSES', 'PENGANTARAN', 'MENUNGGU KONFIRMASI AGENT') DESC LIMIT 1");
$d_status = mysqli_fetch_assoc($q_status);
$status_teratas = $d_status['status'] ?? 'MENUNGGU KONFIRMASI AGENT';

$header_bg = "bg-gray-100 border-gray-200 text-gray-800";
$icon_class = "fa-hourglass-half text-gray-500";
if ($status_teratas == 'SELESAI') {
    $header_bg = "bg-green-100 border-green-200 text-green-800";
    $icon_class = "fa-circle-check text-green-500";
} elseif ($status_teratas == 'DIPROSES') {
    $header_bg = "bg-blue-100 border-blue-200 text-blue-800";
    $icon_class = "fa-spinner fa-spin text-blue-500";
} elseif ($status_teratas == 'PENGANTARAN') {
    $header_bg = "bg-orange-100 border-orange-200 text-orange-800";
    $icon_class = "fa-truck-fast text-orange-500";
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Detail Pesanan #ORD-<?= $order['id_order']; ?> - GalonKu</title>
    <?php include '../layout/assets.php'; ?>
</head>
<body class="font-sans antialiased bg-surface">

    <?php include '../layout/navbar.php'; ?>

    <main class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8 py-6 md:py-8">
        
        <div class="mb-5 text-sm flex justify-between items-center">
            <a href="riwayat.php" class="text-accent hover:text-primary transition">
                <i class="fa-solid fa-arrow-left mr-1"></i> Kembali ke Riwayat
            </a>
            <span class="text-gray-400">Detail Pesanan</span>
        </div>

        <div class="bg-white rounded-2xl shadow-soft border border-gray-200 overflow-hidden">
            
            <!-- Header Status Dinamis -->
            <div class="<?= $header_bg; ?> p-5 flex items-center justify-between border-b">
                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 rounded-full bg-white flex items-center justify-center shadow-sm">
                        <i class="fa-solid <?= $icon_class; ?> text-xl"></i>
                    </div>
                    <div>
                        <h2 class="text-lg font-bold">Status: <?= $status_teratas; ?></h2>
                        <p class="text-xs opacity-80">Dibuat pada <?= date('d M Y, H:i', strtotime($order['order_date'])); ?></p>
                    </div>
                </div>
                <div class="text-right">
                    <p class="text-xs opacity-80">Kode Pesanan</p>
                    <p class="font-bold">#ORD-<?= $order['id_order']; ?></p>
                </div>
            </div>

            <div class="p-6">
                <!-- Info Pengiriman -->
                <h3 class="font-bold text-primary mb-3">Informasi Pengiriman</h3>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-6">
                    <div>
                        <p class="text-xs text-gray-500 mb-1">Alamat Pengiriman</p>
                        <p class="text-sm font-semibold text-primary"><?= htmlspecialchars($user['username']); ?></p>
                        <p class="text-sm text-accent"><?= htmlspecialchars($user['no_hp']); ?></p>
                        <p class="text-sm text-accent leading-tight mt-1"><?= htmlspecialchars($user['address']); ?></p>
                    </div>
                    <div>
                        <p class="text-xs text-gray-500 mb-1">Metode Pembayaran</p>
                        <p class="text-sm font-medium text-primary"><i class="fa-solid fa-money-bill-wave text-secondary mr-1"></i> Bayar di Tempat</p>
                    </div>
                </div>

                <hr class="border-dashed border-gray-200 my-6">

                <!-- Informasi Produk -->
                <div class="flex justify-between items-center mb-4">
                    <h3 class="font-bold text-primary">Rincian Barang</h3>
                    <a href="portofolio_depot.php?id=<?= $order['id_agent']; ?>" class="text-xs text-secondary font-semibold hover:underline">
                        Depot <?= htmlspecialchars($order['agent_name']); ?> <i class="fa-solid fa-chevron-right text-[10px]"></i>
                    </a>
                </div>

                <div class="space-y-4">
                    <?php 
                    $query_detail = "SELECT od.*, p.name_product, p.img, p.price 
                                     FROM order_detail od 
                                     JOIN product p ON od.id_product = p.id_product 
                                     WHERE od.id_order = '$id_order'";
                    $result_detail = mysqli_query($koneksi, $query_detail);
                    $hitung_total_ulang = 0; // Variabel untuk hitung ulang total
                    
                    while($row = mysqli_fetch_assoc($result_detail)): 
                        $hitung_total_ulang += $row['subtotal']; // Menambahkan subtotal ke total
                        
                        // Warna status per barang
                        $status_item = $row['status'];
                        $badge_item = "bg-gray-100 text-gray-600";
                        if ($status_item == 'SELESAI') $badge_item = "bg-green-100 text-green-700";
                        elseif ($status_item == 'DIPROSES') $badge_item = "bg-blue-100 text-blue-700";
                        elseif ($status_item == 'PENGANTARAN') $badge_item = "bg-orange-100 text-orange-700";
                    ?>
                    <div class="flex items-center justify-between border-b border-gray-50 pb-3 last:border-0 last:pb-0">
                        <div class="flex items-center gap-3">
                            <div class="w-12 h-12 bg-gray-50 rounded-lg flex items-center justify-center overflow-hidden border border-gray-200">
                                <!-- PERBAIKAN: Mengarah ke folder ../poto/ -->
                                <?php if (!empty($row['img']) && is_string($row['img']) && strpos($row['img'], 'dummy') === false) { ?>
                                    <img src="../poto/<?= $row['img']; ?>" class="w-full h-full object-cover">
                                <?php } else { ?>
                                    <i class="fa-solid fa-droplet text-secondary"></i>
                                <?php } ?>
                            </div>
                            <div>
                                <p class="font-semibold text-primary text-sm"><?= htmlspecialchars($row['name_product']); ?></p>
                                <div class="flex items-center gap-2 mt-1">
                                    <p class="text-xs text-accent"><?= $row['quantity_item']; ?> x Rp <?= number_format($row['price'], 0, ',', '.'); ?></p>
                                    <span class="text-[10px] font-bold px-2 py-0.5 rounded-full <?= $badge_item; ?>"><?= $status_item; ?></span>
                                </div>
                            </div>
                        </div>
                        <div class="font-bold text-primary text-sm">
                            Rp <?= number_format($row['subtotal'], 0, ',', '.'); ?>
                        </div>
                    </div>
                    <?php endwhile; ?>
                </div>

                <hr class="border-dashed border-gray-200 my-6">

                <!-- Total -->
                <div class="flex justify-between items-center">
                    <p class="font-bold text-gray-500">Total Bayar</p>
                    <!-- Menampilkan total yang dihitung ulang dari subtotal -->
                    <p class="text-2xl font-extrabold text-primary">Rp <?= number_format($hitung_total_ulang, 0, ',', '.'); ?></p>
                </div>
            </div>
        </div>

        <!-- Tombol Aksi -->
        <div class="mt-6 flex justify-center">
            <a href="invoice.php?id=<?= $order['id_order']; ?>" class="w-full md:w-auto text-center bg-primary text-white px-8 py-3 rounded-xl font-bold hover:bg-secondary transition shadow-lg">
                Lihat Invoice
            </a>
        </div>

    </main>

    <?php include '../layout/footer.php'; ?>
</body>
</html>