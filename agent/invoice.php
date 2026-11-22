<?php
session_start();
include __DIR__ . '/../koneksi.php';

if (!isset($_SESSION['username']) || $_SESSION['id_role'] != "2") {
    header("location:../index.php?pesan=akses_ditolak");
    exit();
}

$id_agent = $_SESSION['id_user'];
$id_order = $_GET['id'] ?? 0;

// Ambil data pesanan
$query_order = "SELECT o.*, u.username AS pembeli, u.no_hp, u.address 
                FROM orders o 
                JOIN users u ON o.id_user = u.id_user 
                WHERE o.id_order = '$id_order' AND o.id_agent = '$id_agent'";
$result_order = mysqli_query($koneksi, $query_order);
$order = mysqli_fetch_assoc($result_order);

if (!$order) { die("Invoice tidak ditemukan atau Anda tidak memiliki akses."); }

// Ambil data agent (depot)
$q_agent = mysqli_query($koneksi, "SELECT * FROM users WHERE id_user = '$id_agent'");
$agent = mysqli_fetch_assoc($q_agent);
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Invoice #ORD-<?= $order['id_order']; ?></title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        body { background-color: #f3f4f6; }
        @media print {
            body { background-color: white; }
            .no-print { display: none !important; }
            .shadow-lg { box-shadow: none !important; border: 1px solid #e5e7eb; }
        }
    </style>
</head>
<body class="font-sans text-gray-800 antialiased py-10">

    <div class="max-w-3xl mx-auto px-4">
        
        <!-- Tombol Aksi (Sembunyi saat di-print) -->
        <div class="no-print flex justify-between items-center mb-6">
            <a href="pesanan.php" class="text-sm font-semibold text-gray-600 hover:text-primary transition">
                <i class="fa-solid fa-arrow-left"></i> Kembali ke Pesanan
            </a>
            <button onclick="window.print()" class="bg-primary text-white px-4 py-2 rounded-lg font-semibold shadow hover:bg-secondary transition">
                <i class="fa-solid fa-print"></i> Cetak Invoice
            </button>
        </div>

        <!-- Kertas Invoice -->
        <div class="bg-white rounded-xl shadow-lg overflow-hidden border border-gray-200">
            
            <!-- Header Biru -->
            <div class="bg-[#0A3D7A] p-6 md:p-8 text-white flex justify-between items-center">
                <div>
                    <h1 class="text-2xl font-bold tracking-widest uppercase">INVOICE</h1>
                    <p class="text-sm text-white/70 mt-1"><?= htmlspecialchars($agent['depot'] ?? 'GalonKu Depot'); ?></p>
                </div>
                <div class="text-right">
                    <h2 class="text-xl font-bold">INV-<?= date('Ymd', strtotime($order['order_date'])); ?>-<?= $order['id_order']; ?></h2>
                    <p class="text-sm text-white/70 mt-1">Tanggal: <?= date('d M Y', strtotime($order['order_date'])); ?></p>
                </div>
            </div>

            <div class="p-6 md:p-8">
                
                <!-- Info Pembeli & Info Agent -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">
                    <div class="bg-gray-50 p-4 rounded-xl border border-gray-100">
                        <h3 class="text-sm font-bold text-gray-500 mb-3"><i class="fa-solid fa-user text-blue-500 mr-2"></i>Informasi Pembeli</h3>
                        <table class="w-full text-sm">
                            <tr><td class="text-gray-500 py-1">Nama</td><td class="font-semibold text-right"><?= htmlspecialchars($order['pembeli']); ?></td></tr>
                            <tr><td class="text-gray-500 py-1">Nomor HP</td><td class="font-semibold text-right"><?= htmlspecialchars($order['no_hp']); ?></td></tr>
                            <tr><td class="text-gray-500 py-1">Alamat</td><td class="font-semibold text-right leading-tight"><?= htmlspecialchars($order['address']); ?></td></tr>
                        </table>
                    </div>

                    <div class="bg-gray-50 p-4 rounded-xl border border-gray-100">
                        <h3 class="text-sm font-bold text-gray-500 mb-3"><i class="fa-solid fa-store text-blue-500 mr-2"></i>Informasi Depot</h3>
                        <table class="w-full text-sm">
                            <tr><td class="text-gray-500 py-1">Nama Depot</td><td class="font-semibold text-right"><?= htmlspecialchars($agent['depot'] ?? 'Pusat'); ?></td></tr>
                            <tr><td class="text-gray-500 py-1">Agent</td><td class="font-semibold text-right"><?= htmlspecialchars($agent['username']); ?></td></tr>
                            <tr><td class="text-gray-500 py-1">Status</td><td class="font-semibold text-green-600 text-right bg-green-100 rounded px-2 inline-block">Lunas</td></tr>
                        </table>
                    </div>
                </div>

                <!-- Rincian Produk -->
                <div class="mb-8">
                    <div class="flex justify-between items-center mb-4">
                        <h3 class="font-bold text-gray-700 flex items-center gap-2">
                            <i class="fa-solid fa-box text-blue-500"></i> Rincian Pesanan
                        </h3>
                    </div>
                    
                    <table class="w-full text-left border-collapse">
                        <thead>
                            <tr class="border-b-2 border-gray-100 text-xs text-gray-400 uppercase">
                                <th class="py-3 font-semibold">Produk</th>
                                <th class="py-3 font-semibold text-center">Kuantitas</th>
                                <th class="py-3 font-semibold text-right">Harga</th>
                                <th class="py-3 font-semibold text-right">Total</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php 
                            $q_detail = mysqli_query($koneksi, "SELECT od.*, p.name_product FROM order_detail od JOIN product p ON od.id_product = p.id_product WHERE od.id_order = '$id_order'");
                            while($item = mysqli_fetch_assoc($q_detail)): 
                                $harga_satuan = $item['subtotal'] / $item['quantity_item'];
                            ?>
                            <tr class="border-b border-gray-50 hover:bg-gray-50">
                                <td class="py-4 flex items-center gap-3">
                                    <div class="w-10 h-10 bg-blue-100 rounded flex items-center justify-center text-blue-500">
                                        <i class="fa-solid fa-droplet"></i>
                                    </div>
                                    <div>
                                        <p class="font-semibold text-gray-800"><?= htmlspecialchars($item['name_product']); ?></p>
                                        <p class="text-xs text-gray-500">Status: <?= $item['status']; ?></p>
                                    </div>
                                </td>
                                <td class="py-4 text-center text-sm"><?= $item['quantity_item']; ?> item</td>
                                <td class="py-4 text-right text-sm">Rp <?= number_format($harga_satuan, 0, ',', '.'); ?></td>
                                <td class="py-4 text-right font-semibold text-sm">Rp <?= number_format($item['subtotal'], 0, ',', '.'); ?></td>
                            </tr>
                            <?php endwhile; ?>
                        </tbody>
                    </table>
                </div>

                <!-- Ringkasan Pembayaran -->
                <div class="border-t-2 border-dashed border-gray-200 pt-6">
                    <div class="w-full md:w-1/2 ml-auto">
                        <div class="flex justify-between py-2 text-sm text-gray-600">
                            <span>Subtotal Produk</span>
                            <span>Rp <?= number_format($order['total_price'], 0, ',', '.'); ?></span>
                        </div>
                        <div class="flex justify-between py-2 text-sm text-gray-600">
                            <span>Ongkos Kirim</span>
                            <span>Rp 0</span>
                        </div>
                        <div class="flex justify-between py-3 border-t border-gray-200 mt-2">
                            <span class="font-bold text-gray-800 text-lg">Total Pembayaran</span>
                            <span class="font-extrabold text-[#0A3D7A] text-xl">Rp <?= number_format($order['total_price'], 0, ',', '.'); ?></span>
                        </div>
                    </div>
                </div>

                <!-- Footer Note -->
                <div class="mt-10 bg-blue-50 p-4 rounded-xl flex items-start gap-3 text-sm text-blue-800">
                    <i class="fa-solid fa-circle-info mt-0.5 text-blue-500"></i>
                    <p>Invoice ini merupakan bukti pesanan yang sah dari GalonKu. Harap simpan invoice ini sebagai bukti transaksi Anda.</p>
                </div>
            </div>
        </div>

        <div class="text-center text-xs text-gray-400 mt-8 no-print">
            © <?= date('Y'); ?> GalonKu. All rights reserved.
        </div>

    </div>

</body>
</html>