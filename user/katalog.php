<?php
session_start();

if (!isset($_SESSION['username']) || $_SESSION['id_role'] != "1") {
    header("location:../index.php?pesan=akses_ditolak");
    exit();
}

$username = $_SESSION['username'];
$id_user  = $_SESSION['id_user'];

// Tangkap parameter dari URL
$search   = isset($_GET['search']) ? $_GET['search'] : '';
$kategori = isset($_GET['kategori']) ? $_GET['kategori'] : 'Semua';
$sort     = isset($_GET['sort']) ? $_GET['sort'] : 'Terbaru';

// ==========================================
// KONFIGURASI PAGINATION
// ==========================================
$limit = 8; // Tampilkan 8 produk per halaman
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$offset = ($page - 1) * $limit;
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Katalog - GalonKu</title>
    <?php include '../layout/assets.php'; ?>
    <?php include __DIR__ . '/../koneksi.php'; ?>
</head>
<body class="font-sans antialiased bg-surface">

    <?php include '../layout/navbar.php'; ?>

    <main class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-6 md:py-8">

        <div class="mb-6">
            <h1 class="text-2xl md:text-3xl font-extrabold text-primary mb-1">Katalog Produk</h1>
            <p class="text-sm text-gray-500">Halo <span class="font-semibold capitalize"><?= htmlspecialchars($username); ?></span>, temukan kebutuhan air dan gasmu di sini.</p>
        </div>

        <!-- FORM PENCARIAN & FILTER -->
        <form action="" method="GET" class="bg-white rounded-2xl p-4 mb-6 shadow-sm border-2 border-gray-200 flex flex-col md:flex-row gap-3">
            <!-- Input Search -->
            <div class="flex-1 relative">
                <i class="fa-solid fa-magnifying-glass absolute left-4 top-1/2 -translate-y-1/2 text-gray-400 text-sm"></i>
                <input type="text" name="search" value="<?= htmlspecialchars($search); ?>" placeholder="Cari produk atau depot..." 
                    class="w-full pl-11 pr-4 py-3 rounded-xl border-2 border-gray-300 focus:border-primary focus:ring-2 focus:ring-primary/20 outline-none transition text-sm">
            </div>
            
            <!-- Select Sorting -->
            <select name="sort" onchange="this.form.submit()" class="px-4 py-3 rounded-xl border-2 border-gray-300 focus:border-primary focus:ring-2 focus:ring-primary/20 outline-none transition text-sm bg-white md:w-48 text-gray-600 font-medium cursor-pointer">
                <option value="Terbaru" <?= $sort == 'Terbaru' ? 'selected' : ''; ?>>Terbaru</option>
                <option value="Termurah" <?= $sort == 'Termurah' ? 'selected' : ''; ?>>Termurah</option>
                <option value="Termahal" <?= $sort == 'Termahal' ? 'selected' : ''; ?>>Termahal</option>
                <option value="A-Z" <?= $sort == 'A-Z' ? 'selected' : ''; ?>>A-Z</option>
            </select>

            <!-- Tombol Submit (Tersembunyi, muncul jika di-enter) -->
            <button type="submit" class="hidden">Cari</button>
        </form>

        <!-- FILTER KATEGORI -->
        <div class="flex gap-2 mb-6 overflow-x-auto pb-2 scrollbar-hide">
            <?php 
            $kategori_list = ['Semua', 'Air Galon', 'Gas LPG', 'Air Mineral', 'Promo'];
            foreach($kategori_list as $kat) {
                $activeClass = ($kategori == $kat) ? 'bg-primary text-white shadow-sm' : 'bg-white text-gray-600 hover:text-primary border-2 border-gray-200 hover:border-primary';
                // Saat ganti kategori, reset page ke 1
                $link = "?kategori=" . urlencode($kat) . "&search=" . urlencode($search) . "&sort=" . urlencode($sort) . "&page=1";
            ?>
                <a href="<?= $link; ?>" class="px-6 py-2 rounded-full text-xs font-bold whitespace-nowrap transition <?= $activeClass; ?>">
                    <?= $kat; ?>
                </a>
            <?php } ?>
        </div>

        <!-- GRID PRODUK -->
        <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4">

            <?php
            // ==========================================
            // LOGIKA QUERY BERDASARKAN FILTER & SEARCH
            // ==========================================
            $query_str = "SELECT product.*, users.username AS agent_name, users.depot 
                          FROM product 
                          JOIN users ON product.id_agent = users.id_user 
                          WHERE 1=1";

            if (!empty($search)) {
                $search_esc = mysqli_real_escape_string($koneksi, $search);
                $query_str .= " AND (product.name_product LIKE '%$search_esc%' OR users.username LIKE '%$search_esc%' OR users.depot LIKE '%$search_esc%')";
            }

            if ($kategori != 'Semua') {
                $kategori_esc = mysqli_real_escape_string($koneksi, $kategori);
                $query_str .= " AND product.name_product LIKE '%$kategori_esc%'";
            }

            // Hitung total data untuk Pagination
            $query_count = $query_str;
            $result_count = mysqli_query($koneksi, $query_count);
            $total_data = mysqli_num_rows($result_count);
            $total_pages = ceil($total_data / $limit);

            // Tambahkan Sorting dan Limit
            if ($sort == 'Termurah') {
                $query_str .= " ORDER BY product.price ASC";
            } elseif ($sort == 'Termahal') {
                $query_str .= " ORDER BY product.price DESC";
            } elseif ($sort == 'A-Z') {
                $query_str .= " ORDER BY product.name_product ASC";
            } else {
                $query_str .= " ORDER BY product.id_product DESC"; 
            }

            $query_str .= " LIMIT $limit OFFSET $offset";

            $data = mysqli_query($koneksi, $query_str);
            
            if (mysqli_num_rows($data) == 0) {
                echo '<div class="col-span-full bg-white p-10 rounded-2xl text-center border-2 border-gray-200">
                        <i class="fa-solid fa-box-open text-5xl text-gray-300 mb-3"></i>
                        <p class="text-gray-500 font-medium">Produk tidak ditemukan.</p>
                        <p class="text-sm text-gray-400 mt-1">Coba gunakan kata kunci lain atau hapus filter.</p>
                      </div>';
            }

            while ($row = mysqli_fetch_array($data)) {
            ?>
                <a href="detail_produk.php?id=<?= $row['id_product']; ?>" class="block bg-white p-3 rounded-2xl shadow-sm hover:shadow-md hover:border-primary/50 transition-all group border-2 border-gray-200">
                    <div class="h-32 md:h-40 bg-gray-50 rounded-xl mb-3 flex items-center justify-center overflow-hidden border border-gray-100">
                        <?php if (!empty($row['img']) && is_string($row['img']) && strpos($row['img'], 'dummy') === false) { ?>
                            <img src="../poto/<?= $row['img']; ?>" class="w-full h-full object-cover group-hover:scale-110 transition-transform" alt="<?= $row['name_product']; ?>">
                        <?php } else { ?>
                            <i class="fa-solid fa-droplet text-secondary text-5xl opacity-50 group-hover:scale-110 transition-transform"></i>
                        <?php } ?>
                    </div>

                    <h3 class="font-bold text-sm text-primary mb-1 truncate" title="<?= $row['name_product']; ?>">
                        <?= htmlspecialchars($row['name_product']); ?>
                    </h3>
                    
                    <p class="text-[11px] text-gray-500 mb-2 truncate" title="<?= htmlspecialchars($row['agent_name']); ?>">
                        <i class="fa-solid fa-store mr-1 text-secondary"></i> 
                        <?= htmlspecialchars($row['agent_name'] ?? 'GalonKu'); ?>
                    </p>

                    <div class="flex items-center justify-between mt-2 pt-2 border-t border-gray-100">
                        <div>
                            <p class="text-[10px] text-gray-400"><i class="fa-solid fa-box mr-1"></i> Stok: <?= $row['stock']; ?></p>
                            <span class="font-extrabold text-primary text-sm md:text-base">Rp <?= number_format($row['price'], 0, ',', '.'); ?></span>
                        </div>
                   
                        <button type="button" onclick="event.preventDefault(); window.location.href='detail_produk.php?id=<?= $row['id_product']; ?>';" class="w-8 h-8 rounded-full bg-secondary text-white flex items-center justify-center text-xs hover:bg-primary transition-colors shadow-sm" title="Lihat Detail">
                            <i class="fa-solid fa-plus"></i>
                        </button>
                    </div>
                </a>
            <?php } ?>
        </div> 

        <!-- PAGINATION -->
        <?php if ($total_pages > 1): ?>
        <div class="flex justify-center items-center gap-2 mt-8">
            <!-- Tombol Previous -->
            <?php if ($page > 1): ?>
                <a href="?page=<?= $page - 1; ?>&search=<?= urlencode($search); ?>&kategori=<?= urlencode($kategori); ?>&sort=<?= urlencode($sort); ?>" class="w-10 h-10 rounded-xl border-2 border-gray-300 bg-white flex items-center justify-center text-gray-500 hover:bg-gray-50 hover:text-primary transition">
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
                    <a href="?page=<?= $i; ?>&search=<?= urlencode($search); ?>&kategori=<?= urlencode($kategori); ?>&sort=<?= urlencode($sort); ?>" class="w-10 h-10 rounded-xl border-2 border-gray-300 bg-white flex items-center justify-center text-gray-600 text-sm font-bold hover:bg-gray-50 hover:text-primary transition">
                        <?= $i; ?>
                    </a>
                <?php endif; ?>
            <?php endfor; ?>

            <!-- Tombol Next -->
            <?php if ($page < $total_pages): ?>
                <a href="?page=<?= $page + 1; ?>&search=<?= urlencode($search); ?>&kategori=<?= urlencode($kategori); ?>&sort=<?= urlencode($sort); ?>" class="w-10 h-10 rounded-xl border-2 border-gray-300 bg-white flex items-center justify-center text-gray-500 hover:bg-gray-50 hover:text-primary transition">
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