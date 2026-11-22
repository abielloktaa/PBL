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
// TANGKAP PARAMETER SEARCH, FILTER & PAGINATION
// ==========================================
$search = isset($_GET['search']) ? $_GET['search'] : '';
$bulan  = isset($_GET['bulan']) ? $_GET['bulan'] : '';

// Konfigurasi Pagination
$limit = 4; // Tampilkan 4 data per halaman
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$offset = ($page - 1) * $limit;

// ==========================================
// QUERY STATISTIK (KOTAK ATAS)
// ==========================================
$query_stat = "SELECT COUNT(id_order) AS total_transaksi, SUM(total_price) AS total_belanja 
               FROM orders WHERE id_user = '$id_user'";
$result_stat = mysqli_query($koneksi, $query_stat);
$stat = mysqli_fetch_assoc($result_stat);

$total_transaksi = $stat['total_transaksi'] ?? 0;
$total_belanja   = $stat['total_belanja'] ?? 0;

$query_galon = "SELECT SUM(od.quantity_item) AS total_galon 
                FROM order_detail od 
                JOIN orders o ON od.id_order = o.id_order 
                JOIN product p ON od.id_product = p.id_product 
                WHERE o.id_user = '$id_user' AND p.name_product LIKE '%Galon%'";
$result_galon = mysqli_query($koneksi, $query_galon);
$total_galon = mysqli_fetch_assoc($result_galon)['total_galon'] ?? 0;

$query_gas = "SELECT SUM(od.quantity_item) AS total_gas 
              FROM order_detail od 
              JOIN orders o ON od.id_order = o.id_order 
              JOIN product p ON od.id_product = p.id_product 
              WHERE o.id_user = '$id_user' AND p.name_product LIKE '%Gas%'";
$result_gas = mysqli_query($koneksi, $query_gas);
$total_gas = mysqli_fetch_assoc($result_gas)['total_gas'] ?? 0;
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
        <div class="grid grid-cols-2 lg:grid-cols-4 gap-3 md:gap-4 mb-8">
            <div class="bg-gradient-to-br from-primary to-secondary rounded-2xl p-4 md:p-5 text-white shadow-md relative overflow-hidden flex flex-col justify-between min-h-[110px]">
                <i class="fa-solid fa-wallet absolute -right-2 -bottom-2 text-6xl opacity-10"></i>
                <p class="text-white/80 text-xs font-medium mb-1">Total Belanja</p>
                <p class="font-extrabold text-lg md:text-2xl">Rp <?= number_format($total_belanja, 0, ',', '.'); ?></p>
            </div>

            <div class="bg-white rounded-2xl p-4 md:p-5 shadow-sm border-2 border-gray-200 relative overflow-hidden flex flex-col justify-between min-h-[110px]">
                <i class="fa-solid fa-receipt absolute -right-2 -bottom-2 text-6xl text-primary opacity-5"></i>
                <p class="text-accent text-xs font-medium mb-1">Total Transaksi</p>
                <div>
                    <p class="font-extrabold text-primary text-lg md:text-2xl"><?= $total_transaksi; ?></p>
                    <p class="text-[11px] text-gray-400 mt-1">Sepanjang waktu</p>
                </div>
            </div>

            <div class="bg-white rounded-2xl p-4 md:p-5 shadow-sm border-2 border-gray-200 relative overflow-hidden flex flex-col justify-between min-h-[110px]">
                <i class="fa-solid fa-droplet absolute -right-2 -bottom-2 text-6xl text-secondary opacity-5"></i>
                <p class="text-accent text-xs font-medium mb-1">Galon Terbeli</p>
                <div>
                    <p class="font-extrabold text-primary text-lg md:text-2xl"><?= $total_galon; ?></p>
                    <p class="text-[11px] text-gray-400 mt-1">Total galon</p>
                </div>
            </div>

            <div class="bg-white rounded-2xl p-4 md:p-5 shadow-sm border-2 border-gray-200 relative overflow-hidden flex flex-col justify-between min-h-[110px]">
                <i class="fa-solid fa-fire absolute -right-2 -bottom-2 text-6xl text-orange-500 opacity-5"></i>
                <p class="text-accent text-xs font-medium mb-1">Gas Terbeli</p>
                <div>
                    <p class="font-extrabold text-primary text-lg md:text-2xl"><?= $total_gas; ?></p>
                    <p class="text-[11px] text-gray-400 mt-1">Total tabung</p>
                </div>
            </div>
        </div>

        <!-- FORM PENCARIAN & FILTER -->
        <form action="" method="GET" class="bg-white rounded-2xl p-4 mb-6 shadow-sm border-2 border-gray-200 flex flex-col md:flex-row gap-3">
            <div class="flex-1 relative">
                <i class="fa-solid fa-magnifying-glass absolute left-4 top-1/2 -translate-y-1/2 text-gray-400"></i>
                <input type="text" name="search" value="<?= htmlspecialchars($search); ?>" placeholder="Cari nama produk atau ID pesanan..." 
                    class="w-full pl-11 pr-4 py-3 rounded-xl border-2 border-gray-300 focus:border-primary focus:ring-2 focus:ring-primary/20 outline-none transition text-sm">
            </div>
            <input type="month" name="bulan" value="<?= htmlspecialchars($bulan); ?>"
                class="px-4 py-3 rounded-xl border-2 border-gray-300 focus:border-primary focus:ring-2 focus:ring-primary/20 outline-none transition text-sm bg-white text-gray-600">
            
            <button type="submit" class="px-6 py-3 rounded-xl bg-primary text-white text-sm font-bold shadow-md hover:bg-secondary transition">
                <i class="fa-solid fa-filter mr-2"></i>Cari & Filter
            </button>
            
            <?php if(!empty($search) || !empty($bulan)): ?>
                <a href="riwayat.php" class="px-6 py-3 rounded-xl bg-red-100 text-red-600 text-sm font-bold shadow-sm hover:bg-red-200 transition text-center flex items-center justify-center">
                    <i class="fa-solid fa-rotate-left mr-2"></i>Reset
                </a>
            <?php endif; ?>
        </form>

        <!-- Daftar Riwayat (Dinamis) -->
        <div class="space-y-4">

            <?php
            // ==========================================
            // QUERY DAFTAR RIWAYAT DENGAN FILTER & LIMIT
            // ==========================================
            $query_riwayat = "SELECT o.id_order, o.order_date, o.total_price, 
                                     p.name_product, p.img, od.quantity_item, od.id_product, od.status,
                                     u.username AS agent_name
                              FROM orders o
                              JOIN order_detail od ON o.id_order = od.id_order
                              JOIN product p ON od.id_product = p.id_product
                              LEFT JOIN users u ON p.id_agent = u.id_user
                              WHERE o.id_user = '$id_user'";

            // Tambahkan kondisi pencarian
            if (!empty($search)) {
                $search_esc = mysqli_real_escape_string($koneksi, $search);
                $query_riwayat .= " AND (p.name_product LIKE '%$search_esc%' OR o.id_order LIKE '%$search_esc%')";
            }

            // Tambahkan kondisi filter bulan
            if (!empty($bulan)) {
                $bulan_esc = mysqli_real_escape_string($koneksi, $bulan);
                $query_riwayat .= " AND DATE_FORMAT(o.order_date, '%Y-%m') = '$bulan_esc'";
            }

            // QUERY UNTUK MENGHITUNG TOTAL DATA (Untuk Pagination)
            $query_count = $query_riwayat;
            $result_count = mysqli_query($koneksi, $query_count);
            $total_data = mysqli_num_rows($result_count);
            $total_pages = ceil($total_data / $limit);

            // Tambahkan ORDER BY dan LIMIT
            $query_riwayat .= " ORDER BY o.order_date DESC LIMIT $limit OFFSET $offset";
            
            $result_riwayat = mysqli_query($koneksi, $query_riwayat);

            if (mysqli_num_rows($result_riwayat) == 0) {
                echo '<div class="bg-white p-8 rounded-2xl shadow-sm border-2 border-gray-200 text-center">
                        <i class="fa-solid fa-box-open text-4xl text-gray-300 mb-3"></i>
                        <p class="text-gray-500 text-sm font-medium">Riwayat transaksi tidak ditemukan.</p>
                      </div>';
            }

            // Looping data riwayat
            while ($row = mysqli_fetch_array($result_riwayat)) {
                // Tentukan Warna Badge berdasarkan status database
                $status_db = $row['status'];
                $badgeClass = "bg-gray-100 text-gray-700 border-gray-200"; // Default
                if ($status_db == 'SELESAI') $badgeClass = "bg-green-100 text-green-700 border-green-200";
                elseif ($status_db == 'DIPROSES') $badgeClass = "bg-blue-100 text-blue-700 border-blue-200";
                elseif ($status_db == 'PENGANTARAN') $badgeClass = "bg-orange-100 text-orange-700 border-orange-200";
            ?>
            
            <!-- Card Riwayat -->
            <div class="bg-white rounded-2xl p-5 md:p-6 shadow-sm border-2 border-gray-200 hover:border-primary/30 hover:shadow-md transition-all">
                <div class="flex flex-col md:flex-row md:items-center gap-4">
                    
                    <!-- Gambar Produk -->
                    <div class="w-14 h-14 md:w-16 md:h-16 rounded-xl bg-gray-50 flex items-center justify-center flex-shrink-0 overflow-hidden border border-gray-200">
                        <?php if (!empty($row['img']) && is_string($row['img']) && strpos($row['img'], 'dummy') === false) { ?>
                            <img src="../poto/<?= $row['img']; ?>" class="w-full h-full object-cover" alt="<?= $row['name_product']; ?>">
                        <?php } else { ?>
                            <i class="fa-solid fa-droplet text-secondary text-2xl"></i>
                        <?php } ?>
                    </div>
                    
                    <!-- Info Produk -->
                    <div class="flex-1 min-w-0">
                        <div class="flex items-center gap-2 mb-1">
                            <h3 class="font-bold text-primary text-base md:text-lg truncate"><?= htmlspecialchars($row['name_product']); ?></h3>
                            <!-- Badge Status Dinamis -->
                            <span class="text-[11px] <?= $badgeClass; ?> font-bold px-2.5 py-0.5 rounded-full border"><?= $status_db; ?></span>
                        </div>
                        <p class="text-xs text-gray-500 font-medium">
                            #ORD-<?= $row['id_order']; ?> <span class="mx-1">•</span> <?= date('d M Y', strtotime($row['order_date'])); ?> <span class="mx-1">•</span> 
                            <span class="text-primary"><i class="fa-solid fa-store text-[10px] mr-1"></i><?= htmlspecialchars($row['agent_name'] ?? 'GalonKu'); ?></span>
                        </p>
                    </div>
                    
                    <!-- Harga & Kuantitas -->
                    <div class="text-left md:text-right flex-shrink-0 bg-gray-50 md:bg-transparent p-3 md:p-0 rounded-lg md:rounded-none mt-2 md:mt-0">
                        <p class="font-extrabold text-primary text-lg md:text-xl">Rp <?= number_format($row['total_price'], 0, ',', '.'); ?></p>
                        <p class="text-xs text-gray-500 font-medium"><?= $row['quantity_item']; ?> item</p>
                    </div>
                </div>
                
                <!-- Tombol Aksi -->
                <div class="flex items-center gap-4 mt-4 pt-4 border-t-2 border-gray-100">
                    <a href="detail_pesanan.php?id=<?= $row['id_order']; ?>" class="text-xs font-bold text-secondary hover:text-primary transition flex items-center gap-1">
                        <i class="fa-solid fa-circle-info"></i> Detail
                    </a>
                    <span class="text-gray-300">|</span>
                    
                    <!-- TOMBOL BELI LAGI -->
                    <button type="button" onclick="openBeliLagi(<?= $row['id_product']; ?>, '<?= htmlspecialchars($row['name_product']); ?>')" class="text-xs font-bold text-secondary hover:text-primary transition flex items-center gap-1">
                        <i class="fa-solid fa-cart-plus"></i> Beli Lagi
                    </button>
                    
                    <span class="text-gray-300">|</span>
                    <a href="invoice.php?id=<?= $row['id_order']; ?>" class="text-xs font-bold text-secondary hover:text-primary transition flex items-center gap-1">
                        <i class="fa-solid fa-file-invoice"></i> Invoice
                    </a>
                </div>
            </div>

            <?php } // Akhir looping ?>

        </div>

        <!-- PAGINATION -->
        <?php if ($total_pages > 1): ?>
        <div class="flex justify-center items-center gap-2 mt-8">
            <!-- Tombol Previous -->
            <?php if ($page > 1): ?>
                <a href="?page=<?= $page - 1; ?>&search=<?= urlencode($search); ?>&bulan=<?= urlencode($bulan); ?>" class="w-10 h-10 rounded-xl border-2 border-gray-300 bg-white flex items-center justify-center text-gray-500 hover:bg-gray-50 hover:text-primary transition">
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
                    <a href="?page=<?= $i; ?>&search=<?= urlencode($search); ?>&bulan=<?= urlencode($bulan); ?>" class="w-10 h-10 rounded-xl border-2 border-gray-300 bg-white flex items-center justify-center text-gray-600 text-sm font-bold hover:bg-gray-50 hover:text-primary transition">
                        <?= $i; ?>
                    </a>
                <?php endif; ?>
            <?php endfor; ?>

            <!-- Tombol Next -->
            <?php if ($page < $total_pages): ?>
                <a href="?page=<?= $page + 1; ?>&search=<?= urlencode($search); ?>&bulan=<?= urlencode($bulan); ?>" class="w-10 h-10 rounded-xl border-2 border-gray-300 bg-white flex items-center justify-center text-gray-500 hover:bg-gray-50 hover:text-primary transition">
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

    <!-- ================= POPUP BELI LAGI ================= -->
    <div id="beliLagiModal" class="fixed inset-0 z-[100] hidden items-center justify-center bg-black/60 backdrop-blur-sm p-4 transition-opacity duration-300">
        <div class="bg-white rounded-[2rem] p-8 max-w-sm w-full text-center relative overflow-hidden shadow-2xl">
            <div class="w-20 h-20 mx-auto bg-green-50 rounded-full flex items-center justify-center mb-4 border-4 border-white shadow-sm">
                <i class="fa-solid fa-cart-shopping text-4xl text-green-500"></i>
            </div>
            
            <h2 class="text-xl font-extrabold text-primary mb-2">Beli Lagi?</h2>
            <p class="text-sm text-gray-500 mb-6">Tambahkan <span id="namaProdukBeli" class="font-bold text-primary"></span> ke keranjang belanja Anda?</p>
            
            <div class="flex gap-3">
                <button onclick="closeBeliLagi()" class="flex-1 bg-gray-100 text-gray-600 py-3 rounded-xl font-bold hover:bg-gray-200 transition">Batal</button>
                <button onclick="confirmBeliLagi()" class="flex-1 bg-primary text-white py-3 rounded-xl font-bold hover:bg-secondary transition shadow-md">Ya, Tambahkan</button>
            </div>
        </div>
    </div>

    <!-- ================= JAVASCRIPT ================= -->
    <script>
        let produkBeliLagi = null;

        function openBeliLagi(idProduk, namaProduk) {
            produkBeliLagi = idProduk;
            document.getElementById('namaProdukBeli').innerText = namaProduk;
            
            const modal = document.getElementById('beliLagiModal');
            modal.classList.remove('hidden');
            modal.classList.add('flex');
        }

        function closeBeliLagi() {
            const modal = document.getElementById('beliLagiModal');
            modal.classList.add('hidden');
            modal.classList.remove('flex');
            produkBeliLagi = null;
        }

        function confirmBeliLagi() {
            if (!produkBeliLagi) return;
            window.location.href = `../action/actionkeranjang.php?tambah_lagi=${produkBeliLagi}`;
        }
    </script>

    <?php include '../layout/footer.php'; ?>

</body>
</html>