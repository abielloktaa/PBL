<?php
session_start();
include __DIR__ . '/../koneksi.php';

if (!isset($_SESSION['username']) || $_SESSION['id_role'] != "1") {
    header("location:../index.php?pesan=akses_ditolak");
    exit();
}

// Ambil ID Agent dari URL
if (!isset($_GET['id']) || empty($_GET['id'])) {
    header("location:katalog.php");
    exit();
}

$id_agent = $_GET['id'];

// Ambil data profil depot (users)
$query_user = mysqli_query($koneksi, "SELECT * FROM users WHERE id_user = '$id_agent' AND id_role = 2");
$agent = mysqli_fetch_assoc($query_user);

if (!$agent) {
    echo "<script>alert('Depot tidak ditemukan!'); window.location='katalog.php';</script>";
    exit();
}

// Ambil semua produk yang dijual oleh depot ini
$query_produk = "SELECT * FROM product WHERE id_agent = '$id_agent' ORDER BY id_product DESC";
$result_produk = mysqli_query($koneksi, $query_produk);
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profil Depot <?= htmlspecialchars($agent['username']); ?> - GalonKu</title>
    <?php include '../layout/assets.php'; ?>
</head>
<body class="font-sans antialiased bg-surface">

    <?php include '../layout/navbar.php'; ?>

    <main class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8 py-6 md:py-8">
        
        <div class="mb-5 text-sm">
            <a href="katalog.php" class="text-accent hover:text-primary transition">
                <i class="fa-solid fa-arrow-left mr-1"></i> Kembali ke Katalog
            </a>
        </div>

        <!-- Bagian Header Profil Depot -->
        <div class="bg-white rounded-3xl shadow-soft border border-gray-400 overflow-hidden mb-8 relative">
            <div class="h-32 bg-gradient-to-r from-primary to-secondary"></div>
            
            <div class="px-6 md:px-10 pb-8 relative flex flex-col md:flex-row items-center md:items-end gap-5">
                <!-- Foto Profil Depot -->
                <div class="w-28 h-28 md:w-32 md:h-32 rounded-full bg-white border-4 border-white shadow-lg -mt-14 flex items-center justify-center overflow-hidden z-10 relative">
                    <?php if (!empty($agent['foto']) && strpos($agent['foto'], 'dummy') === false) { ?>
                        <img src="../poto/<?= $agent['foto']; ?>" class="w-full h-full object-cover">
                    <?php } else { ?>
                        <i class="fa-solid fa-store text-6xl text-gray-300"></i>
                    <?php } ?>
                </div>

                <!-- Info Nama -->
                <div class="flex-1 text-center md:text-left mt-2 md:mt-0">
                    <h1 class="text-2xl md:text-3xl font-extrabold text-primary capitalize"><?= htmlspecialchars($agent['username']); ?></h1>
                    <p class="text-sm text-secondary font-semibold mt-1">
                        <i class="fa-solid fa-shop"></i> <?= htmlspecialchars($agent['depot'] ?? 'Depot GalonKu'); ?>
                    </p>
                </div>

                <!-- FITUR HUBUNGI AGENT (WHATSAPP) -->
                <?php if (!empty($agent['no_hp'])) { ?>
                    <!-- Tampil jika no_hp ada -->
                    <a href="https://wa.me/62<?= preg_replace('/^0/', '', $agent['no_hp']); ?>?text=Halo%20<?= urlencode($agent['username']); ?>,%20saya%20ingin%20bertanya%20mengenai%20produk%20di%20depot%20Anda." 
                       target="_blank" 
                       class="bg-green-500 text-white px-6 py-2.5 rounded-full font-bold hover:bg-green-600 transition flex items-center gap-2 shadow-lg mt-2 md:mt-0 w-full md:w-auto justify-center">
                        <i class="fa-brands fa-whatsapp text-lg"></i> Hubungi Agent
                    </a>
                <?php } else { ?>
                    <!-- Tampil jika no_hp kosong -->
                    <button disabled class="bg-gray-300 text-gray-500 px-6 py-2.5 rounded-full font-bold cursor-not-allowed transition flex items-center gap-2 shadow-lg mt-2 md:mt-0 w-full md:w-auto justify-center">
                        <i class="fa-brands fa-whatsapp text-lg"></i> Kontak Belum Tersedia
                    </button>
                <?php } ?>
            </div>

            <!-- Alamat Depot -->
            <div class="px-6 md:px-10 pb-8 border-t border-gray-100 pt-5">
                <h3 class="text-xs font-bold text-gray-400 uppercase tracking-wider mb-1">Alamat Gudang/Depot</h3>
                <p class="text-primary text-sm">
                    <i class="fa-solid fa-location-dot text-secondary mr-1"></i>
                    <?= htmlspecialchars($agent['address'] ?? 'Alamat belum diatur'); ?>
                </p>
            </div>
        </div>

        <!-- Bagian Katalog Produk Depot -->
        <div class="mb-4 flex items-center justify-between">
            <h2 class="text-xl font-bold text-primary">Produk di Depot Ini</h2>
            <span class="text-sm text-gray-500"><?= mysqli_num_rows($result_produk); ?> Produk</span>
        </div>

        <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
            <?php 
            if (mysqli_num_rows($result_produk) == 0) {
                echo '<div class="col-span-full bg-white p-6 rounded-2xl border text-center text-gray-500 text-sm">Depot ini belum memiliki produk.</div>';
            }

            while ($row = mysqli_fetch_assoc($result_produk)) { 
            ?>
            <a href="detail_produk.php?id=<?= $row['id_product']; ?>" class="block bg-white p-3 rounded-2xl shadow-soft hover:shadow-pop transition-all group border border-gray-400">
                <div class="h-28 md:h-32 bg-gray-50 rounded-xl mb-3 flex items-center justify-center overflow-hidden border border-gray-300">
                    <?php if (!empty($row['img']) && strpos($row['img'], 'dummy') === false && strpos($row['img'], 'img_produk') !== false) { ?>
                        <img src="../agent/<?= $row['img']; ?>" class="w-full h-full object-cover group-hover:scale-110 transition-transform" alt="<?= $row['name_product']; ?>">
                    <?php } else { ?>
                        <i class="fa-solid fa-droplet text-secondary text-4xl opacity-50 group-hover:scale-110 transition-transform"></i>
                    <?php } ?>
                </div>

                <h3 class="font-semibold text-sm text-primary mb-1 truncate"><?= htmlspecialchars($row['name_product']); ?></h3>
                <p class="text-xs text-accent mb-2">Stok: <?= $row['stock']; ?></p>

                <div class="flex items-center justify-between">
                    <span class="font-bold text-primary text-sm">Rp <?= number_format($row['price'], 0, ',', '.'); ?></span>
                    <div class="w-7 h-7 rounded-full bg-secondary text-white flex items-center justify-center text-xs hover:bg-primary transition-colors">
                        <i class="fa-solid fa-plus"></i>
                    </div>
                </div>
            </a>
            <?php } ?>
        </div>

    </main>

    <?php include '../layout/footer.php'; ?>
</body>
</html>