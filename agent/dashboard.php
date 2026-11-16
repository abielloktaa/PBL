<?php
session_start();
include __DIR__ . '/../koneksi.php';

// Proteksi Halaman untuk Role Agent (id_role = 2)
if (!isset($_SESSION['username']) || $_SESSION['id_role'] != "2") {
    header("location:../index.php?pesan=akses_ditolak");
    exit();
}

$username = $_SESSION['username'];
$id_user  = $_SESSION['id_user']; // ID Agent yang sedang login

// =======================================================
// 1. QUERY STATISTIK UNTUK KOTAK ATAS
// =======================================================
// A. Pesanan Masuk (Total pesanan untuk agent ini)
$q_baru = mysqli_query($koneksi, "SELECT COUNT(id_order) AS total FROM orders WHERE id_agent = '$id_user'");
$d_baru = mysqli_fetch_assoc($q_baru);
$total_pesanan = $d_baru['total'] ?? 0;

// B. Pesanan Diproses 
$pesanan_diproses = $total_pesanan; 

// C. Pengantaran Hari Ini (Pesanan yang tanggal ordernya hari ini)
$tgl_hari_ini = date('Y-m-d');
$q_hari_ini = mysqli_query($koneksi, "SELECT COUNT(id_order) AS total FROM orders WHERE id_agent = '$id_user' AND DATE(order_date) = '$tgl_hari_ini'");
$d_hari_ini = mysqli_fetch_assoc($q_hari_ini);
$pengantaran_hari_ini = $d_hari_ini['total'] ?? 0;

// =======================================================
// 2. QUERY PESANAN BARU (Menampilkan 3 pesanan terakhir)
// =======================================================
$query_pesanan = "SELECT o.id_order, o.total_price, u.username AS pembeli, u.address 
                  FROM orders o 
                  JOIN users u ON o.id_user = u.id_user 
                  WHERE o.id_agent = '$id_user' 
                  ORDER BY o.order_date DESC LIMIT 3";
$result_pesanan = mysqli_query($koneksi, $query_pesanan);
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Agent - GalonKu</title>
    <?php include '../layout/assets.php'; ?>
</head>
<body class="font-sans antialiased bg-surface">

    <?php include '../layout/navbar.php'; ?>

    <div class="flex min-h-[calc(100vh-64px)]">
        <main class="flex-1 p-4 md:p-6 lg:p-8 overflow-x-hidden">

            <div class="flex items-center justify-between mb-6">
                <div>
                    <h1 class="text-2xl md:text-3xl font-extrabold text-primary">Dashboard</h1>
                    <p class="text-accent text-sm mt-1">Selamat datang kembali, <span class="font-semibold text-primary capitalize"><?= htmlspecialchars($username); ?></span> 👋</p>
                </div>
                
                <button class="lg:hidden w-10 h-10 rounded-full bg-white shadow-soft flex items-center justify-center text-primary relative">
                    <i class="fa-solid fa-bell"></i>
                    <span class="absolute top-2 right-2 w-2 h-2 bg-red-500 rounded-full"></span>
                </button>
            </div>

            <!-- STATISTIK KOTAK ATAS -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-6">
                <div class="bg-white rounded-2xl p-5 shadow-soft border border-gray-50">
                    <div class="flex items-center justify-between mb-3">
                        <p class="text-accent text-sm font-medium">Pesanan Masuk</p>
                        <div class="w-9 h-9 rounded-lg bg-support/20 flex items-center justify-center">
                            <i class="fa-solid fa-clipboard-list text-secondary text-sm"></i>
                        </div>
                    </div>
                    <p class="text-3xl font-extrabold text-primary mb-1"><?= $total_pesanan; ?></p>
                    <p class="text-xs text-accent">Total pesanan</p>
                </div>

                <div class="bg-white rounded-2xl p-5 shadow-soft border border-gray-50">
                    <div class="flex items-center justify-between mb-3">
                        <p class="text-accent text-sm font-medium">Pesanan Diproses</p>
                        <div class="w-9 h-9 rounded-lg bg-support/20 flex items-center justify-center">
                            <i class="fa-solid fa-clock text-secondary text-sm"></i>
                        </div>
                    </div>
                    <p class="text-3xl font-extrabold text-primary mb-1"><?= $pesanan_diproses; ?></p>
                    <p class="text-xs text-accent">Sedang disiapkan</p>
                </div>

                <div class="bg-white rounded-2xl p-5 shadow-soft border border-gray-50">
                    <div class="flex items-center justify-between mb-3">
                        <p class="text-accent text-sm font-medium">Pengantaran Hari Ini</p>
                        <div class="w-9 h-9 rounded-lg bg-support/20 flex items-center justify-center">
                            <i class="fa-solid fa-truck-fast text-secondary text-sm"></i>
                        </div>
                    </div>
                    <p class="text-3xl font-extrabold text-primary mb-1"><?= $pengantaran_hari_ini; ?></p>
                    <p class="text-xs text-accent">Jadwal antar</p>
                </div>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-4">
                <!-- PESANAN BARU (KIRI) -->
                <div class="lg:col-span-2 bg-white rounded-2xl shadow-soft p-5 border border-gray-50">
                    <div class="flex items-center justify-between mb-4">
                        <h2 class="text-lg font-bold text-primary">Pesanan Terbaru</h2>
                        <a href="pesanan_agent.php" class="text-sm text-secondary hover:text-primary font-semibold transition">Lihat Semua</a>
                    </div>

                    <div class="space-y-3">
                        <?php if (mysqli_num_rows($result_pesanan) == 0) : ?>
                            <p class="text-sm text-accent text-center py-4">Belum ada pesanan masuk.</p>
                        <?php else : ?>
                            <?php while($row = mysqli_fetch_assoc($result_pesanan)) : ?>
                            <div class="flex items-center gap-3 p-3 rounded-xl hover:bg-surface transition border border-gray-100">
                                <div class="w-12 h-12 rounded-lg bg-support/20 flex items-center justify-center flex-shrink-0">
                                    <i class="fa-solid fa-droplet text-secondary"></i>
                                </div>
                                <div class="flex-1 min-w-0">
                                    <p class="font-semibold text-primary text-sm">#ORD-<?= $row['id_order']; ?> (Rp <?= number_format($row['total_price'], 0, ',', '.'); ?>)</p>
                                    <p class="text-xs text-accent truncate"><?= htmlspecialchars($row['pembeli']); ?> — <?= htmlspecialchars($row['address'] ?? 'Alamat belum diisi'); ?></p>
                                </div>
                            </div>
                            <?php endwhile; ?>
                        <?php endif; ?>
                    </div>
                </div>

                <!-- PENGANTARAN HARI INI (KANAN) -->
                <div class="bg-white rounded-2xl shadow-soft p-5 border border-gray-50">
                    <div class="flex items-center justify-between mb-4">
                        <h2 class="text-lg font-bold text-primary">Pengantaran Hari Ini</h2>
                        <a href="#" class="text-secondary hover:text-primary transition">
                            <i class="fa-solid fa-arrow-right"></i>
                        </a>
                    </div>

                    <div class="space-y-3">
                        <p class="text-sm text-accent text-center py-4">Belum ada jadwal pengantaran untuk hari ini.</p>
                    </div>
                </div>
            </div>

        </main>
    </div>

    <!-- MOBILE BOTTOM NAV -->
    <nav class="lg:hidden fixed bottom-0 left-0 right-0 bg-white border-t border-gray-100 shadow-lg z-40">
        <div class="grid grid-cols-4 py-2">
            <a href="dashboard_agent.php" class="flex flex-col items-center gap-1 py-2 text-primary">
                <i class="fa-solid fa-house text-lg"></i>
                <span class="text-[10px] font-semibold">Home</span>
            </a>
            <a href="pesanan_agent.php" class="flex flex-col items-center gap-1 py-2 text-accent">
                <i class="fa-solid fa-receipt text-lg"></i>
                <span class="text-[10px] font-semibold">Pesanan</span>
            </a>
            <a href="stok.php" class="flex flex-col items-center gap-1 py-2 text-accent">
                <i class="fa-solid fa-boxes-stacked text-lg"></i>
                <span class="text-[10px] font-semibold">Stok</span>
            </a>
            <a href="profil.php" class="flex flex-col items-center gap-1 py-2 text-accent">
                <i class="fa-solid fa-user text-lg"></i>
                <span class="text-[10px] font-semibold">Profil</span>
            </a>
        </div>
    </nav>

    <div class="lg:hidden h-20"></div>

    <?php include '../layout/footer.php'; ?>
</body>
</html>