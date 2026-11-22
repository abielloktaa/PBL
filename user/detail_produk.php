<?php
session_start();
include __DIR__ . '/../koneksi.php';

if (!isset($_SESSION['username']) || $_SESSION['id_role'] != "1") {
    header("location:../login.php?pesan=belum_login");
    exit();
}

$username = $_SESSION['username'];

if (!isset($_GET['id']) || empty($_GET['id'])) {
    header("location:katalog.php");
    exit();
}

$id_produk = (int)$_GET['id'];

// Ambil data produk + data agent (Menggunakan LEFT JOIN agar aman jika id_agent bermasalah)
$query = "SELECT product.*, users.username AS agent_name, users.no_hp AS agent_hp, users.depot 
          FROM product 
          LEFT JOIN users ON product.id_agent = users.id_user 
          WHERE product.id_product = '$id_produk'";
$result = mysqli_query($koneksi, $query);
$produk = mysqli_fetch_assoc($result);

// JIKA PRODUK TIDAK DITEMUKAN
if (!$produk) {
    echo "<script>alert('Produk dengan ID $id_produk tidak ditemukan di database!'); window.location='katalog.php';</script>";
    exit();
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= htmlspecialchars($produk['name_product']); ?> - GalonKu</title>
    <?php include '../layout/assets.php'; ?>
</head>
<body class="font-sans antialiased bg-surface">

    <?php include '../layout/navbar.php'; ?>

    <main class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8 py-6 md:py-8">

        <div class="mb-5 text-sm">
            <a href="katalog.php" class="text-gray-500 hover:text-primary transition font-medium flex items-center gap-1">
                <i class="fa-solid fa-arrow-left"></i> Kembali ke Katalog
            </a>
        </div>

        <!-- CARD UTAMA DENGAN GARIS TEBAL -->
        <div class="bg-white rounded-3xl shadow-sm border-2 border-gray-200 overflow-hidden hover:shadow-md transition-shadow">
            <div class="flex flex-col md:flex-row">
                
                <!-- Bagian Gambar Produk -->
                <div class="md:w-2/5 bg-gray-50 p-8 flex items-center justify-center min-h-[300px] border-b-2 md:border-b-0 md:border-r-2 border-gray-200">
                    <!-- PERBAIKAN: Mengarah ke folder ../poto/ -->
                    <?php if (!empty($produk['img']) && is_string($produk['img']) && strpos($produk['img'], 'dummy') === false) { ?>
                        <img src="../poto/<?= $produk['img']; ?>" class="w-full h-full max-h-[300px] object-contain drop-shadow-lg" alt="<?= htmlspecialchars($produk['name_product']); ?>">
                    <?php } else { ?>
                        <i class="fa-solid fa-droplet text-8xl md:text-9xl text-secondary opacity-30"></i>
                    <?php } ?>
                </div>

                <!-- Bagian Detail Produk -->
                <div class="md:w-3/5 p-6 md:p-8 flex flex-col justify-center">
                    
                    <span class="bg-blue-50 text-secondary border border-blue-100 text-xs font-bold px-3 py-1 rounded-full w-max mb-3">
                        Kategori Galon/Gas
                    </span>

                    <h1 class="text-2xl md:text-3xl font-extrabold text-primary mb-3 leading-tight">
                        <?= htmlspecialchars($produk['name_product']); ?>
                    </h1>

                    <!-- Info Agent / Depot -->
                    <div class="flex flex-wrap items-center gap-2 text-sm mb-5 bg-gray-50 p-3 rounded-xl border border-gray-100">
                        <i class="fa-solid fa-store text-secondary"></i> 
                        
                        <?php if (!empty($produk['agent_name'])) { ?>
                            <a href="portofolio_depot.php?id=<?= $produk['id_agent']; ?>" class="hover:text-primary hover:underline transition font-bold text-gray-700">
                                <?= htmlspecialchars($produk['agent_name']); ?> 
                                <span class="font-normal text-gray-500">(<?= htmlspecialchars($produk['depot'] ?? 'Pusat'); ?>)</span>
                            </a>
                        <?php } else { ?>
                            <span class="font-bold text-gray-700">GalonKu Pusat</span>
                        <?php } ?>
                        
                        <!-- FITUR HUBUNGI AGENT -->
                        <?php if (!empty($produk['agent_hp'])) { ?>
                            <a href="https://wa.me/62<?= preg_replace('/^0/', '', $produk['agent_hp']); ?>?text=Halo%20<?= urlencode($produk['agent_name']); ?>,%20saya%20tertarik%20dengan%20produk%20<?= urlencode($produk['name_product']); ?>" 
                               target="_blank" 
                               class="ml-auto bg-green-100 text-green-700 hover:bg-green-200 border border-green-200 px-3 py-1 rounded-lg text-xs font-bold transition flex items-center gap-1">
                                <i class="fa-brands fa-whatsapp"></i> Chat
                            </a>
                        <?php } ?>
                    </div>

                    <div class="border-t-2 border-dashed border-gray-200 py-4 mb-4">
                        <p class="text-3xl md:text-4xl font-extrabold text-primary">
                            Rp <?= number_format($produk['price'], 0, ',', '.'); ?>
                        </p>
                    </div>

                    <div class="mb-6">
                        <h3 class="font-bold text-primary text-sm mb-2">Deskripsi</h3>
                        <p class="text-sm text-gray-600 leading-relaxed">
                            Ini adalah produk <?= htmlspecialchars($produk['name_product']); ?>. Kualitas terjamin, higienis, dan langsung dikirim ke rumah Anda oleh depot terdekat.
                        </p>
                    </div>

                    <!-- Stok & Input Jumlah -->
                    <div class="flex flex-col sm:flex-row sm:items-center gap-4 mb-6">
                        <div class="flex items-center gap-2 text-sm font-medium text-gray-600">
                            <i class="fa-solid fa-boxes-stacked text-secondary"></i>
                            Stok: <span class="font-bold text-primary text-base"><?= $produk['stock']; ?></span>
                        </div>

                        <div class="flex items-center gap-3">
                            <span class="text-sm font-bold text-primary">Jumlah:</span>
                            <div class="flex items-center bg-gray-100 rounded-xl border border-gray-200">
                                <button onclick="changeQty(-1)" class="w-10 h-10 flex items-center justify-center text-primary hover:bg-gray-200 rounded-l-xl transition">
                                    <i class="fa-solid fa-minus text-xs"></i>
                                </button>
                                <input id="qty" type="number" value="1" min="1" max="<?= $produk['stock']; ?>" readonly
                                    class="w-12 h-10 text-center bg-transparent font-bold text-primary outline-none">
                                <button onclick="changeQty(1)" class="w-10 h-10 flex items-center justify-center text-primary hover:bg-gray-200 rounded-r-xl transition">
                                    <i class="fa-solid fa-plus text-xs"></i>
                                </button>
                            </div>
                        </div>
                    </div>

                    <!-- Tombol Aksi -->
                    <div class="flex flex-col sm:flex-row gap-3 pt-4 border-t-2 border-gray-100">
                        <form action="../action/actionkeranjang.php" method="POST" class="flex-1">
                            <input type="hidden" name="id_produk" value="<?= $produk['id_product']; ?>">
                            <input type="hidden" name="qty" id="qty_hidden" value="1">
                            
                            <button type="submit" name="tambah_keranjang" 
                                class="w-full bg-primary text-white py-3.5 rounded-xl font-bold hover:bg-secondary transition shadow-md flex items-center justify-center gap-2">
                                <i class="fa-solid fa-cart-plus"></i>
                                Tambah ke Keranjang
                            </button>
                        </form>

                        <button onclick="buyNow()" 
                            class="flex-1 bg-support text-primary py-3.5 rounded-xl font-bold hover:bg-blue-300 transition shadow-md flex items-center justify-center gap-2">
                            <i class="fa-solid fa-bolt"></i>
                            Beli Langsung
                        </button>
                    </div>

                </div>
            </div>
        </div>

    </main>

    <!-- ================= JAVASCRIPT ================= -->
    <script>
        const hargaProduk = <?= $produk['price']; ?>;
        const stokProduk  = <?= $produk['stock']; ?>;
        const namaProduk  = "<?= htmlspecialchars($produk['name_product']); ?>";
        const idProduk    = <?= $produk['id_product']; ?>;

        function changeQty(delta) {
            const input = document.getElementById('qty');
            let val = parseInt(input.value) + delta;
            
            if (val < 1) val = 1;
            if (val > stokProduk) {
                val = stokProduk;
                alert('Jumlah melebihi stok tersedia!');
            }
            input.value = val;
            
            document.getElementById('qty_hidden').value = val;
        }

        function buyNow() {
            const qty = parseInt(document.getElementById('qty').value);
            const total = hargaProduk * qty;
            
            alert(`🛒 Beli Langsung:\n${namaProduk}\nJumlah: ${qty}\nTotal: Rp ${total.toLocaleString('id-ID')}`);
        }

        document.querySelector('input[type=number]').addEventListener('keydown', e => e.preventDefault());
    </script>

    <?php include '../layout/footer.php'; ?>
</body>
</html>