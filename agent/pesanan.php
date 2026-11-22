<?php
session_start();
include __DIR__ . '/../koneksi.php';

if (!isset($_SESSION['username']) || $_SESSION['id_role'] != "2") {
    header("location:../index.php?pesan=akses_ditolak");
    exit();
}

$id_user = $_SESSION['id_user'];
$pesan_sukses = false;

// ==========================================
// PROSES UPDATE STATUS PESANAN (SEMUA BARANG)
// ==========================================
if (isset($_POST['update_status_order'])) {
    $id_order = $_POST['id_order'];
    $status_baru = $_POST['status_baru'];
    
    $query_update = "UPDATE order_detail SET status = '$status_baru' WHERE id_order = '$id_order'";
    if (mysqli_query($koneksi, $query_update)) {
        $pesan_sukses = true; 
    }
}

// ==========================================
// PROSES TOLAK / HAPUS PESANAN
// ==========================================
if (isset($_GET['tolak'])) {
    $id_hapus = $_GET['tolak'];
    
    mysqli_query($koneksi, "DELETE FROM history WHERE id_order = '$id_hapus'");
    mysqli_query($koneksi, "DELETE FROM order_detail WHERE id_order = '$id_hapus'");
    $hapus_order = mysqli_query($koneksi, "DELETE FROM orders WHERE id_order = '$id_hapus' AND id_agent = '$id_user'");
    
    if ($hapus_order) {
        echo "<script>alert('Pesanan berhasil ditolak dan dihapus!'); window.location='pesanan.php';</script>";
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pesanan Masuk - Agent</title>
    <?php include '../layout/assets.php'; ?>
</head>
<body class="font-sans antialiased bg-surface">
    <?php include '../layout/navbar.php'; ?>

    <main class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-6 md:py-8">
        
        <div class="mb-6 flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
            <div>
                <h1 class="text-2xl md:text-3xl font-extrabold text-primary mb-1">Pesanan Masuk</h1>
                <p class="text-sm text-gray-500">Daftar pesanan dari konsumen yang perlu Anda proses.</p>
            </div>
            <!-- Tombol ke Riwayat -->
            <a href="riwayat_pesanan.php" class="bg-white border-2 border-gray-300 text-gray-700 px-4 py-2 rounded-xl text-sm font-bold hover:bg-gray-100 transition shadow-sm flex items-center gap-2">
                <i class="fa-solid fa-clock-rotate-left"></i> Riwayat Selesai
            </a>
        </div>

        <div class="space-y-4">
            <?php
            // QUERY DIPERBARUI: Hanya ambil pesanan yang statusnya BUKAN 'SELESAI'
            $query = "SELECT o.id_order, o.order_date, o.total_price, u.username AS pembeli, u.no_hp, u.address 
                      FROM orders o 
                      JOIN users u ON o.id_user = u.id_user 
                      WHERE o.id_agent = '$id_user' 
                      AND o.id_order NOT IN (
                          SELECT id_order FROM order_detail WHERE status = 'SELESAI'
                      )
                      ORDER BY o.order_date DESC";
            
            $result = mysqli_query($koneksi, $query);

            if (mysqli_num_rows($result) == 0) {
                echo '<div class="bg-white p-8 rounded-2xl shadow-sm border-2 border-gray-200 text-center">
                        <i class="fa-solid fa-box-open text-5xl text-gray-300 mb-3"></i>
                        <p class="text-gray-500 text-sm font-medium">Belum ada pesanan masuk saat ini.</p>
                      </div>';
            }

            while ($row = mysqli_fetch_assoc($result)) {
                $id_order = $row['id_order'];

                $q_status = mysqli_query($koneksi, "SELECT status FROM order_detail WHERE id_order = '$id_order' LIMIT 1");
                $d_status = mysqli_fetch_assoc($q_status);
                $status_pesanan = $d_status['status'] ?? 'MENUNGGU KONFIRMASI AGENT';

                $badge_class = "bg-gray-100 text-gray-700 border-gray-200";
                $bg_header = "bg-gray-50";
                
                if ($status_pesanan == 'MENUNGGU KONFIRMASI AGENT') {
                    $badge_class = "bg-red-100 text-red-700 border-red-200";
                    $bg_header = "bg-red-50/50";
                } elseif ($status_pesanan == 'DIPROSES') {
                    $badge_class = "bg-blue-100 text-blue-700 border-blue-200";
                    $bg_header = "bg-blue-50/50";
                } elseif ($status_pesanan == 'PENGANTARAN') {
                    $badge_class = "bg-orange-100 text-orange-700 border-orange-200";
                    $bg_header = "bg-orange-50/50";
                }
            ?>
            
            <!-- CARD PESANAN -->
            <div class="bg-white rounded-2xl shadow-sm border-2 border-gray-200 overflow-hidden hover:shadow-md transition-shadow">
                
                <!-- Header Pesanan -->
                <div class="<?= $bg_header; ?> p-4 md:p-5 flex flex-col sm:flex-row justify-between items-start border-b-2 border-gray-200 gap-4">
                    <div>
                        <div class="flex items-center gap-2 mb-1">
                            <p class="font-bold text-primary text-lg">#ORD-<?= $row['id_order']; ?></p>
                            <span class="text-[10px] font-bold px-2.5 py-1 rounded-md border <?= $badge_class; ?>">
                                <?= str_replace('MENUNGGU KONFIRMASI AGENT', 'MENUNGGU', $status_pesanan); ?>
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

                <!-- Info Pembeli & Form Aksi -->
                <div class="bg-gray-50 p-4 md:p-5 border-t-2 border-gray-200 flex flex-col lg:flex-row justify-between items-center gap-4">
                    <!-- Info Pembeli -->
                    <div class="text-sm w-full lg:w-auto">
                        <p class="font-bold text-gray-800"><i class="fa-solid fa-user text-gray-400 mr-2"></i><?= htmlspecialchars($row['pembeli']); ?></p>
                        <p class="text-gray-600 mt-1"><i class="fa-solid fa-location-dot text-gray-400 mr-2"></i><?= htmlspecialchars($row['address'] ?? 'Alamat tidak tersedia'); ?></p>
                    </div>

                    <!-- Tombol Aksi -->
                    <div class="flex flex-col sm:flex-row gap-2 w-full lg:w-auto">
                        
                        <button onclick="openTolakModal(<?= $row['id_order']; ?>)" class="w-full sm:w-auto text-center bg-red-100 text-red-600 border border-red-200 px-4 py-2.5 rounded-xl text-sm font-bold hover:bg-red-200 transition shadow-sm flex items-center justify-center gap-1">
                            <i class="fa-solid fa-xmark"></i> Tolak
                        </button>

                        <form action="" method="POST" class="flex items-center gap-2 bg-white p-1.5 rounded-xl border-2 border-gray-200 w-full sm:w-auto">
                            <input type="hidden" name="id_order" value="<?= $row['id_order']; ?>">
                            
                            <select name="status_baru" class="text-sm border-none bg-transparent focus:ring-0 outline-none font-bold text-gray-700 cursor-pointer flex-1">
                                <option value="MENUNGGU KONFIRMASI AGENT" <?= $status_pesanan == 'MENUNGGU KONFIRMASI AGENT' ? 'selected' : ''; ?>>Menunggu</option>
                                <option value="DIPROSES" <?= $status_pesanan == 'DIPROSES' ? 'selected' : ''; ?>>Diproses</option>
                                <option value="PENGANTARAN" <?= $status_pesanan == 'PENGANTARAN' ? 'selected' : ''; ?>>Pengantaran</option>
                                <option value="SELESAI" <?= $status_pesanan == 'SELESAI' ? 'selected' : ''; ?>>Selesai</option>
                            </select>
                            
                            <button type="submit" name="update_status_order" class="bg-primary text-white px-4 py-2 rounded-lg hover:bg-secondary transition text-sm font-bold shadow-sm">
                                Update
                            </button>
                        </form>

                        <?php if (!empty($row['no_hp'])): ?>
                        <a href="https://wa.me/62<?= preg_replace('/^0/', '', $row['no_hp']); ?>?text=Halo%20<?= urlencode($row['pembeli']); ?>,%20pesanan%20Anda%20sedang%20kami%20proses." target="_blank" class="w-full sm:w-auto text-center bg-green-500 text-white px-5 py-2.5 rounded-xl text-sm font-bold hover:bg-green-600 transition shadow-sm flex items-center justify-center gap-1">
                            <i class="fa-brands fa-whatsapp text-lg"></i>
                        </a>
                        <?php endif; ?>

                        <a href="invoice.php?id=<?= $row['id_order']; ?>" class="w-full sm:w-auto text-center bg-white border-2 border-gray-300 text-gray-700 px-4 py-2.5 rounded-xl text-sm font-bold hover:bg-gray-100 transition shadow-sm flex items-center justify-center gap-1">
                            <i class="fa-solid fa-file-invoice text-secondary"></i> Invoice
                        </a>

                    </div>
                </div>
            </div>
            
            <?php } ?>
        </div>

    </main>

    <!-- ================= POPUP KONFIRMASI TOLAK ================= -->
    <div id="tolakModal" class="fixed inset-0 z-[100] hidden items-center justify-center bg-black/60 backdrop-blur-sm p-4 transition-opacity duration-300">
        <div class="bg-white rounded-[2rem] p-8 max-w-sm w-full text-center relative overflow-hidden shadow-2xl">
            <div class="w-20 h-20 mx-auto bg-red-50 rounded-full flex items-center justify-center mb-4 border-4 border-white shadow-sm">
                <i class="fa-solid fa-triangle-exclamation text-4xl text-red-500"></i>
            </div>
            
            <h2 class="text-xl font-extrabold text-primary mb-2">Tolak Pesanan?</h2>
            <p class="text-sm text-gray-500 mb-6 leading-relaxed">Pesanan ini akan dihapus permanen dari sistem dan tidak dapat dikembalikan.</p>
            
            <div class="flex gap-3">
                <button onclick="closeTolakModal()" class="flex-1 bg-gray-100 text-gray-600 py-3 rounded-xl font-bold hover:bg-gray-200 transition">Batal</button>
                <a href="#" id="btnHapusPesanan" class="flex-1 bg-red-500 text-white py-3 rounded-xl font-bold hover:bg-red-600 transition shadow-md">Ya, Tolak</a>
            </div>
        </div>
    </div>

    <!-- ================= POPUP SUKSES UPDATE STATUS ================= -->
    <?php if ($pesan_sukses): ?>
    <div id="suksesModal" class="fixed inset-0 z-[100] flex items-center justify-center bg-black/60 backdrop-blur-sm p-4 transition-opacity duration-300">
        <div class="bg-white rounded-[2rem] p-8 max-w-sm w-full text-center relative overflow-hidden shadow-2xl">
            <div class="w-20 h-20 mx-auto bg-green-50 rounded-full flex items-center justify-center mb-4 border-4 border-white shadow-sm">
                <i class="fa-solid fa-check text-4xl text-green-500"></i>
            </div>
            
            <h2 class="text-xl font-extrabold text-primary mb-2">Berhasil!</h2>
            <p class="text-sm text-gray-500 mb-6 leading-relaxed">Status pesanan berhasil diperbarui menjadi <span class="font-bold text-primary"><?= $_POST['status_baru'] ?? ''; ?></span>.</p>
            
            <button onclick="document.getElementById('suksesModal').style.display='none'" class="w-full bg-primary text-white py-3 rounded-xl font-bold hover:bg-secondary transition shadow-md">
                Tutup
            </button>
        </div>
    </div>
    <?php endif; ?>

    <!-- ================= JAVASCRIPT ================= -->
    <script>
        function openTolakModal(idOrder) {
            document.getElementById('btnHapusPesanan').href = 'pesanan.php?tolak=' + idOrder;
            const modal = document.getElementById('tolakModal');
            modal.classList.remove('hidden');
            modal.classList.add('flex');
        }

        function closeTolakModal() {
            const modal = document.getElementById('tolakModal');
            modal.classList.add('hidden');
            modal.classList.remove('flex');
        }
    </script>

    <?php include '../layout/footer.php'; ?>
</body>
</html>