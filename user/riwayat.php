<?php
session_start();
// 1. TAMBAHKAN KONEKSI DATABASE
include __DIR__ . '/../koneksi.php';

if (!isset($_SESSION['username']) || $_SESSION['id_role'] != "1") {
    header("location:../index.php?pesan=akses_ditolak");
    exit();
}

$username = $_SESSION['username'];
$id_user  = $_SESSION['id_user']; 

// ==========================================
// 2. QUERY UNTUK RINGKASAN STATISTIK (KOTAK ATAS)
// ==========================================
// A. Hitung Total Belanja & Total Transaksi
$query_stat = "SELECT COUNT(id_order) AS total_transaksi, SUM(total_price) AS total_belanja 
               FROM orders WHERE id_user = '$id_user'";
$result_stat = mysqli_query($koneksi, $query_stat);
$stat = mysqli_fetch_assoc($result_stat);

$total_transaksi = $stat['total_transaksi'] ?? 0;
$total_belanja   = $stat['total_belanja'] ?? 0;

// B. Hitung Total Galon & Gas
$query_galon = "SELECT SUM(od.quantity_item) AS total_galon 
                FROM order_detail od 
                JOIN orders o ON od.id_order = o.id_order 
                JOIN product p ON od.id_product = p.id_product 
                WHERE o.id_user = '$id_user' AND p.name_product LIKE '%Galon%'";
$result_galon = mysqli_query($koneksi, $query_galon);
$galon = mysqli_fetch_assoc($result_galon);
$total_galon = $galon['total_galon'] ?? 0;

$query_gas = "SELECT SUM(od.quantity_item) AS total_gas 
              FROM order_detail od 
              JOIN orders o ON od.id_order = o.id_order 
              JOIN product p ON od.id_product = p.id_product 
              WHERE o.id_user = '$id_user' AND p.name_product LIKE '%Gas%'";
$result_gas = mysqli_query($koneksi, $query_gas);
$gas = mysqli_fetch_assoc($result_gas);
$total_gas = $gas['total_gas'] ?? 0;
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Riwayat - GalonKu</title>
    <?php include '../layout/assets.php'; ?>
</head>
<body class="font-sans antialiased bg-surface">

    <?php include '../layout/navbar.php'; ?>

    <main class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-6 md:py-8">

        <div class="mb-6">
            <h1 class="text-2xl md:text-3xl font-extrabold text-primary mb-2">Riwayat Transaksi</h1>
            <p class="text-sm text-gray-500">Lihat semua riwayat belanja air dan gasmu di sini.</p>
        </div>

        <!-- Ringkasan Statistik (Dinamis) -->
        <div class="grid grid-cols-2 lg:grid-cols-4 gap-3 md:gap-4 mb-6">
            <div class="bg-gradient-to-br from-primary to-secondary rounded-2xl p-4 md:p-5 text-white shadow-pop relative overflow-hidden">
                <i class="fa-solid fa-wallet absolute -right-2 -bottom-2 text-6xl opacity-10"></i>
                <p class="text-white/70 text-xs mb-1">Total Belanja</p>
                <p class="font-extrabold text-lg md:text-2xl">Rp <?= number_format($total_belanja, 0, ',', '.'); ?></p>
            </div>

            <div class="bg-white rounded-2xl p-4 md:p-5 shadow-soft relative overflow-hidden">
                <i class="fa-solid fa-receipt absolute -right-2 -bottom-2 text-6xl text-primary opacity-5"></i>
                <p class="text-accent text-xs mb-1">Total Transaksi</p>
                <p class="font-extrabold text-primary text-lg md:text-2xl"><?= $total_transaksi; ?></p>
                <p class="text-xs text-accent mt-1">Sepanjang waktu</p>
            </div>

            <div class="bg-white rounded-2xl p-4 md:p-5 shadow-soft relative overflow-hidden">
                <i class="fa-solid fa-droplet absolute -right-2 -bottom-2 text-6xl text-secondary opacity-5"></i>
                <p class="text-accent text-xs mb-1">Galon Terbeli</p>
                <p class="font-extrabold text-primary text-lg md:text-2xl"><?= $total_galon; ?></p>
                <p class="text-xs text-accent mt-1">Total galon</p>
            </div>

            <div class="bg-white rounded-2xl p-4 md:p-5 shadow-soft relative overflow-hidden">
                <i class="fa-solid fa-fire absolute -right-2 -bottom-2 text-6xl text-orange-500 opacity-5"></i>
                <p class="text-accent text-xs mb-1">Gas Terbeli</p>
                <p class="font-extrabold text-primary text-lg md:text-2xl"><?= $total_gas; ?></p>
                <p class="text-xs text-accent mt-1">Total tabung</p>
            </div>
        </div>

        <!-- Pencarian & Filter -->
        <div class="bg-white rounded-2xl p-4 mb-6 shadow-soft flex flex-col md:flex-row gap-3">
            <div class="flex-1 relative">
                <i class="fa-solid fa-magnifying-glass absolute left-4 top-1/2 -translate-y-1/2 text-accent"></i>
                <input type="text" placeholder="Cari transaksi..." 
                    class="w-full pl-11 pr-4 py-3 rounded-xl border border-gray-200 focus:border-support focus:ring-2 focus:ring-support/30 outline-none transition text-sm">
            </div>
            <input type="month" 
                class="px-4 py-3 rounded-xl border border-gray-200 focus:border-support focus:ring-2 focus:ring-support/30 outline-none transition text-sm bg-white text-gray-600">
            <button class="px-6 py-3 rounded-xl bg-primary text-white text-sm font-semibold hover:bg-secondary transition">
                <i class="fa-solid fa-filter mr-2"></i>Filter
            </button>
        </div>

        <!-- Daftar Riwayat (Dinamis) -->
        <div class="space-y-3">

            <?php
            // 3. QUERY DAFTAR RIWAYAT (DITAMBAHKAN JOIN KE TABEL USERS UNTUK AGENT)
            $query_riwayat = "SELECT o.id_order, o.order_date, o.total_price, 
                                     p.name_product, p.img, od.quantity_item, od.id_product,
                                     u.username AS agent_name
                              FROM orders o
                              JOIN order_detail od ON o.id_order = od.id_order
                              JOIN product p ON od.id_product = p.id_product
                              LEFT JOIN users u ON p.id_agent = u.id_user
                              WHERE o.id_user = '$id_user'
                              ORDER BY o.order_date DESC";
            
            $result_riwayat = mysqli_query($koneksi, $query_riwayat);

            if (mysqli_num_rows($result_riwayat) == 0) {
                echo '<div class="bg-white p-8 rounded-2xl shadow-soft text-center border border-gray-400">
                        <p class="text-gray-500 text-sm">Belum ada riwayat transaksi.</p>
                      </div>';
            }

            // Looping data riwayat
            while ($row = mysqli_fetch_array($result_riwayat)) {
            ?>
            
            <div class="bg-white rounded-2xl p-4 md:p-5 shadow-soft hover:shadow-pop transition-all">
                <div class="flex items-center gap-4">
                    <div class="w-12 h-12 md:w-14 md:h-14 rounded-xl bg-support/20 flex items-center justify-center flex-shrink-0 overflow-hidden border border-gray-200">
                        <?php if (!empty($row['img']) && strpos($row['img'], 'dummy') === false) { ?>
                            <img src="<?= $row['img']; ?>" class="w-full h-full object-cover" alt="<?= $row['name_product']; ?>">
                        <?php } else { ?>
                            <i class="fa-solid fa-droplet text-secondary text-lg md:text-xl"></i>
                        <?php } ?>
                    </div>
                    
                    <div class="flex-1 min-w-0">
                        <div class="flex flex-wrap items-center gap-2 mb-1">
                            <h3 class="font-semibold text-primary text-sm truncate"><?= htmlspecialchars($row['name_product']); ?></h3>
                            <span class="text-[11px] bg-green-100 text-green-700 font-semibold px-2 py-0.5 rounded-full">Selesai</span>
                        </div>
                        <p class="text-xs text-accent">
                            #ORD-<?= $row['id_order']; ?> • <?= date('d M Y', strtotime($row['order_date'])); ?> • 
                            <!-- MENAMPILKAN NAMA AGENT DARI DATABASE -->
                            <span class="font-medium text-primary"><i class="fa-solid fa-store text-[10px]"></i> <?= htmlspecialchars($row['agent_name'] ?? 'GalonKu'); ?></span>
                        </p>
                    </div>
                    
                    <div class="text-right flex-shrink-0">
                        <p class="font-bold text-primary text-sm">Rp <?= number_format($row['total_price'], 0, ',', '.'); ?></p>
                        <p class="text-xs text-accent"><?= $row['quantity_item']; ?> item</p>
                    </div>
                </div>
                
                <!-- Tombol Aksi -->
                <div class="flex gap-2 mt-3 pt-3 border-t border-gray-100">
                    <button class="text-xs text-secondary font-semibold hover:text-primary transition">Detail</button>
                    <span class="text-gray-300">•</span>
                    <form action="proses_beli_lagi.php" method="POST" class="inline">
                        <input type="hidden" name="id_product" value="<?= $row['id_product']; ?>">
                        <button type="submit" class="text-xs text-secondary font-semibold hover:text-primary transition">Beli Lagi</button>
                    </form>
                    <span class="text-gray-300">•</span>
                    <button class="text-xs text-secondary font-semibold hover:text-primary transition">Invoice</button>
                </div>
            </div>

            <?php } // Akhir looping ?>

        </div>

        <!-- Pagination (Sederhana) -->
        <div class="flex justify-center items-center gap-2 mt-8">
            <button class="w-9 h-9 rounded-lg border border-gray-200 bg-white flex items-center justify-center text-accent hover:bg-surface transition">
                <i class="fa-solid fa-chevron-left text-xs"></i>
            </button>
            <button class="w-9 h-9 rounded-lg bg-primary text-white flex items-center justify-center text-sm font-semibold">1</button>
            <button class="w-9 h-9 rounded-lg border border-gray-200 bg-white flex items-center justify-center text-accent hover:bg-surface transition">
                <i class="fa-solid fa-chevron-right text-xs"></i>
            </button>
        </div>

    </main>

    <?php include '../layout/footer.php'; ?>

</body>
</html>