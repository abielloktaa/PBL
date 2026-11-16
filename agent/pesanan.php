<?php
session_start();
include __DIR__ . '/../koneksi.php';

if (!isset($_SESSION['username']) || $_SESSION['id_role'] != "2") {
    header("location:../index.php?pesan=akses_ditolak");
    exit();
}

$id_user = $_SESSION['id_user'];
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Pesanan Masuk - Agent</title>
    <?php include '../layout/assets.php'; ?>
</head>
<body class="font-sans antialiased bg-surface">
    <?php include '../layout/navbar.php'; ?>

    <main class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-6 md:py-8">
        
        <div class="mb-6">
            <h1 class="text-2xl font-extrabold text-primary">Pesanan Masuk</h1>
            <p class="text-sm text-gray-500">Daftar pesanan dari konsumen yang perlu Anda proses.</p>
        </div>

        <div class="space-y-4">
            <?php
            // Mengambil data pesanan beserta data pembeli (users)
            $query = "SELECT o.*, u.username AS pembeli, u.no_hp, u.address 
                      FROM orders o 
                      JOIN users u ON o.id_user = u.id_user 
                      WHERE o.id_agent = '$id_user' 
                      ORDER BY o.order_date DESC";
            
            $result = mysqli_query($koneksi, $query);

            if (mysqli_num_rows($result) == 0) {
                echo '<div class="bg-white p-8 rounded-2xl shadow-soft text-center border border-gray-400">
                        <p class="text-gray-500">Belum ada pesanan masuk saat ini.</p>
                      </div>';
            }

            while ($row = mysqli_fetch_assoc($result)) {
                // Mengambil detail barang yang dipesan
                $id_order = $row['id_order'];
                $q_detail = "SELECT od.*, p.name_product 
                             FROM order_detail od 
                             JOIN product p ON od.id_product = p.id_product 
                             WHERE od.id_order = '$id_order'";
                $res_detail = mysqli_query($koneksi, $q_detail);
            ?>
            
            <div class="bg-white rounded-2xl p-5 shadow-soft border border-gray-400">
                <div class="flex justify-between items-start border-b border-gray-100 pb-4 mb-4">
                    <div>
                        <span class="bg-blue-100 text-blue-700 text-xs font-bold px-3 py-1 rounded-full mb-2 inline-block">Baru</span>
                        <p class="font-bold text-primary text-lg">#ORD-<?= $row['id_order']; ?></p>
                        <p class="text-xs text-accent"><?= date('d M Y, H:i', strtotime($row['order_date'])); ?></p>
                    </div>
                    <div class="text-right">
                        <p class="text-xs text-gray-500">Total Pendapatan</p>
                        <p class="font-extrabold text-primary text-xl">Rp <?= number_format($row['total_price'], 0, ',', '.'); ?></p>
                    </div>
                </div>

                <!-- Rincian Barang -->
                <div class="mb-4 space-y-2">
                    <?php while($d = mysqli_fetch_assoc($res_detail)): ?>
                    <div class="flex justify-between text-sm">
                        <span class="text-gray-700"><?= htmlspecialchars($d['name_product']); ?> <span class="text-gray-400 text-xs">x<?= $d['quantity_item']; ?></span></span>
                        <span class="font-semibold">Rp <?= number_format($d['subtotal'], 0, ',', '.'); ?></span>
                    </div>
                    <?php endwhile; ?>
                </div>

                <!-- Info Pembeli & Aksi -->
                <div class="bg-gray-50 rounded-xl p-4 flex flex-col sm:flex-row justify-between items-center gap-4 border border-gray-100">
                    <div class="text-sm">
                        <p class="font-semibold text-gray-800"><i class="fa-solid fa-user text-gray-400 mr-2"></i><?= htmlspecialchars($row['pembeli']); ?></p>
                        <p class="text-gray-600 mt-1"><i class="fa-solid fa-location-dot text-gray-400 mr-2"></i><?= htmlspecialchars($row['address'] ?? 'Alamat tidak tersedia'); ?></p>
                    </div>
                    <div class="flex gap-2">
                        <?php if (!empty($row['no_hp'])): ?>
                        <a href="https://wa.me/62<?= preg_replace('/^0/', '', $row['no_hp']); ?>?text=Halo%20<?= urlencode($row['pembeli']); ?>,%20pesanan%20Anda%20sedang%20kami%20proses." target="_blank" class="bg-green-500 text-white px-4 py-2 rounded-xl text-sm font-semibold hover:bg-green-600 transition">
                            <i class="fa-brands fa-whatsapp mr-1"></i> Chat
                        </a>
                        <?php endif; ?>
                        <button class="bg-primary text-white px-4 py-2 rounded-xl text-sm font-semibold hover:bg-secondary transition">
                            Selesaikan
                        </button>
                    </div>
                </div>
            </div>
            
            <?php } ?>
        </div>

    </main>

    <?php include '../layout/footer.php'; ?>
</body>
</html>