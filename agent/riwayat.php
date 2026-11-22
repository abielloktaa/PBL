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
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Riwayat Pesanan - Agent</title>
    <?php include '../layout/assets.php'; ?>
</head>
<body class="font-sans antialiased bg-surface">
    <?php include '../layout/navbar.php'; ?>

    <main class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-6 md:py-8">
        
        <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center mb-6 gap-4">
            <div>
                <h1 class="text-2xl md:text-3xl font-extrabold text-primary mb-1">Riwayat Pesanan Selesai</h1>
                <p class="text-sm text-gray-500">Daftar pesanan yang telah selesai Anda proses.</p>
            </div>
            
            <!-- Tombol Kembali ke Pesanan Masuk -->
            <a href="pesanan.php" class="bg-white border-2 border-gray-300 text-gray-700 px-4 py-2 rounded-xl text-sm font-bold hover:bg-gray-100 transition shadow-sm flex items-center gap-2">
                <i class="fa-solid fa-arrow-left"></i> Kembali ke Pesanan Masuk
            </a>
        </div>

        <div class="space-y-4">
            <?php
            // Query KHUSUS mengambil pesanan yang statusnya SELESAI
            $query = "SELECT DISTINCT o.id_order, o.order_date, o.total_price, u.username AS pembeli, u.no_hp, u.address 
                      FROM orders o 
                      JOIN users u ON o.id_user = u.id_user 
                      JOIN order_detail od ON o.id_order = od.id_order
                      WHERE o.id_agent = '$id_user' AND od.status = 'SELESAI'
                      ORDER BY o.order_date DESC";
            
            $result = mysqli_query($koneksi, $query);

            if (mysqli_num_rows($result) == 0) {
                echo '<div class="bg-white p-10 rounded-2xl shadow-sm border-2 border-gray-200 text-center">
                        <i class="fa-solid fa-clock-rotate-left text-5xl text-gray-300 mb-3"></i>
                        <p class="text-gray-500 text-sm font-medium">Belum ada riwayat pesanan yang selesai.</p>
                      </div>';
            }

            while ($row = mysqli_fetch_assoc($result)) {
                $id_order = $row['id_order'];
            ?>
            
            <!-- CARD RIWAYAT PESANAN -->
            <div class="bg-white rounded-2xl shadow-sm border-2 border-gray-200 overflow-hidden">
                
                <!-- Header Card -->
                <div class="bg-gray-50 p-4 md:p-5 flex flex-col sm:flex-row justify-between items-start border-b-2 border-gray-200 gap-4">
                    <div>
                        <div class="flex items-center gap-2 mb-1">
                            <p class="font-bold text-primary text-lg">#ORD-<?= $row['id_order']; ?></p>
                            <span class="text-[10px] font-bold px-2.5 py-1 rounded-md border bg-green-100 text-green-700 border-green-200">
                                SELESAI
                            </span>
                        </div>
                        <p class="text-xs text-gray-500 font-medium"><?= date('d M Y, H:i', strtotime($row['order_date'])); ?></p>
                    </div>
                    
                    <div class="text-left sm:text-right w-full sm:w-auto flex sm:flex-col justify-between items-center sm:items-end">
                        <p class="text-xs text-gray-500">Total Pendapatan</p>
                        <p class="font-extrabold text-primary text-xl">Rp <?= number_format($row['total_price'], 0, ',', '.'); ?></p>
                    </div>
                </div>

                <!-- Rincian Barang -->
                <div class="p-4 md:p-5 space-y-3">
                    <?php 
                    $q_detail = "SELECT od.*, p.name_product 
                                 FROM order_detail od 
                                 JOIN product p ON od.id_product = p.id_product 
                                 WHERE od.id_order = '$id_order'";
                    $res_detail = mysqli_query($koneksi, $q_detail);
                    
                    while($d = mysqli_fetch_assoc($res_detail)): 
                    ?>
                    <div class="flex justify-between items-center border-b border-gray-100 pb-2 last:border-0 last:pb-0">
                        <div>
                            <p class="font-semibold text-gray-800 text-sm"><?= htmlspecialchars($d['name_product']); ?> <span class="text-gray-500 text-xs font-normal">x<?= $d['quantity_item']; ?></span></p>
                        </div>
                        <p class="font-bold text-primary text-sm">Rp <?= number_format($d['subtotal'], 0, ',', '.'); ?></p>
                    </div>
                    <?php endwhile; ?>
                </div>

                <!-- Info Pembeli & Aksi -->
                <div class="bg-gray-50 p-4 md:p-5 border-t-2 border-gray-200 flex flex-col lg:flex-row justify-between items-center gap-4">
                    <!-- Info Pembeli -->
                    <div class="text-sm w-full lg:w-auto">
                        <p class="font-bold text-gray-800"><i class="fa-solid fa-user text-gray-400 mr-2"></i><?= htmlspecialchars($row['pembeli']); ?></p>
                        <p class="text-gray-600 mt-1"><i class="fa-solid fa-location-dot text-gray-400 mr-2"></i><?= htmlspecialchars($row['address'] ?? 'Alamat tidak tersedia'); ?></p>
                    </div>

                    <!-- Tombol Aksi -->
                    <div class="flex flex-col sm:flex-row gap-2 w-full lg:w-auto">
                        <!-- Tombol Invoice -->
                        <a href="invoice.php?id=<?= $row['id_order']; ?>" class="w-full sm:w-auto text-center bg-primary border-2 border-primary text-white px-4 py-2.5 rounded-xl text-sm font-bold hover:bg-secondary hover:border-secondary transition shadow-sm flex items-center justify-center gap-1">
                            <i class="fa-solid fa-file-invoice"></i> Lihat Invoice
                        </a>
                    </div>
                </div>
            </div>
            
            <?php } ?>
        </div>

    </main>

    <?php include '../layout/footer.php'; ?>
</body>
</html>