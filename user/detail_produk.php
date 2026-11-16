<?php
session_start();
include __DIR__ . '/../koneksi.php';

// Proteksi Halaman
if (!isset($_SESSION['username']) || $_SESSION['id_role'] != "1") {
    header("location:../index.php?pesan=akses_ditolak");
    exit();
}

$username = $_SESSION['username'];

// 1. Ambil ID dari URL
if (!isset($_GET['id']) || empty($_GET['id'])) {
    header("location:katalog.php");
    exit();
}

$id_produk = $_GET['id'];

// 2. Query ambil data produk + data Agent (Depot & No HP)
$query = "SELECT product.*, users.username AS agent_name, users.no_hp AS agent_hp, users.depot 
          FROM product 
          JOIN users ON product.id_agent = users.id_user 
          WHERE product.id_product = '$id_produk'";
$result = mysqli_query($koneksi, $query);
$produk = mysqli_fetch_assoc($result);

// Jika produk tidak ditemukan
if (!$produk) {
    echo "<script>alert('Produk tidak ditemukan!'); window.location='katalog.php';</script>";
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
            <a href="katalog.php" class="text-accent hover:text-primary transition">
                <i class="fa-solid fa-arrow-left mr-1"></i> Kembali ke Katalog
            </a>
        </div>

        <div class="bg-white rounded-2xl shadow-soft overflow-hidden">
            <div class="flex flex-col md:flex-row">

                <!-- Bagian Gambar Produk -->
                <div class="md:w-2/5 bg-gradient-to-br from-[#EBF4FF] to-[#D9E8FF] p-8 flex items-center justify-center min-h-[250px]">
                    <?php if (!empty($produk['img']) && strpos($produk['img'], 'dummy') === false) { ?>
                        <img src="<?= $produk['img']; ?>" class="w-full h-full max-h-[300px] object-contain mix-blend-multiply drop-shadow-xl" alt="<?= htmlspecialchars($produk['name_product']); ?>">
                    <?php } else { ?>
                        <i class="fa-solid fa-droplet text-8xl md:text-9xl text-secondary opacity-70"></i>
                    <?php } ?>
                </div>

                <!-- Bagian Detail Produk -->
                <div class="md:w-3/5 p-5 md:p-7">
                    <div class="flex items-center gap-3 mb-2">
                        <span class="bg-surface text-secondary text-xs font-semibold px-3 py-1 rounded-full">
                            Kategori Galon/Gas
                        </span>
                    </div>

                    <h1 class="text-2xl md:text-3xl font-extrabold text-primary mb-2">
                        <?= htmlspecialchars($produk['name_product']); ?>
                    </h1>

                    <!-- TAMPILAN NAMA DEPOT / AGENT -->
                    <div class="text-accent text-sm mb-4 flex items-center gap-2">
    <i class="fa-solid fa-store mr-1 text-secondary"></i> 
    
    <!-- TAUTAN KE HALAMAN PORTOFOLIO DEPOT -->
    <a href="portofolio_depot.php?id=<?= $produk['id_agent']; ?>" class="hover:text-primary hover:underline transition font-medium">
        <?= htmlspecialchars($produk['agent_name'] ?? 'GalonKu'); ?> 
        (<?= htmlspecialchars($produk['depot'] ?? 'Pusat'); ?>)
    </a>
    
    <!-- FITUR HUBUNGI AGENT (WHATSAPP) -->
    <?php if (!empty($produk['agent_hp'])) { ?>
        <a href="https://wa.me/62<?= preg_replace('/^0/', '', $produk['agent_hp']); ?>?text=Halo%20<?= urlencode($produk['agent_name']); ?>,%20saya%20tertarik%20dengan%20produk%20<?= urlencode($produk['name_product']); ?>" 
           target="_blank" 
           class="ml-auto bg-green-100 text-green-700 hover:bg-green-200 px-3 py-1 rounded-full text-xs font-semibold transition flex items-center gap-1">
            <i class="fa-brands fa-whatsapp"></i> Hubungi Agent
        </a>
    <?php } ?>
</div>
                    <div class="border-t border-b border-gray-100 py-4 mb-4">
                        <!-- Format Harga -->
                        <p class="text-3xl font-extrabold text-primary">
                            Rp <?= number_format($produk['price'], 0, ',', '.'); ?>
                        </p>
                    </div>

                    <div class="mb-4">
                        <h3 class="font-bold text-primary text-sm mb-2">Deskripsi</h3>
                        <p class="text-sm text-accent leading-relaxed">
                            Ini adalah produk <?= htmlspecialchars($produk['name_product']); ?>. Kualitas terjamin, higienis, dan langsung dikirim ke rumah Anda oleh depot terdekat.
                        </p>
                    </div>

                    <!-- Stok -->
                    <div class="flex flex-wrap gap-4 mb-5 text-sm">
                        <div class="flex items-center gap-2 text-accent">
                            <i class="fa-solid fa-boxes-stacked text-secondary"></i>
                            Stok: <span class="font-bold text-primary"><?= $produk['stock']; ?></span>
                        </div>
                    </div>

                    <!-- Input Jumlah -->
                    <div class="flex items-center gap-4 mb-5">
                        <span class="text-sm font-semibold text-primary">Jumlah:</span>
                        <div class="flex items-center bg-surface rounded-lg">
                            <button onclick="changeQty(-1)" class="w-10 h-10 flex items-center justify-center text-primary hover:bg-support/30 rounded-l-lg transition">
                                <i class="fa-solid fa-minus text-xs"></i>
                            </button>
                            <input id="qty" type="number" value="1" min="1" max="<?= $produk['stock']; ?>" readonly
                                class="w-12 h-10 text-center bg-transparent font-bold text-primary outline-none">
                            <button onclick="changeQty(1)" class="w-10 h-10 flex items-center justify-center text-primary hover:bg-support/30 rounded-r-lg transition">
                                <i class="fa-solid fa-plus text-xs"></i>
                            </button>
                        </div>
                    </div>

                    <!-- Tombol Aksi -->
                    <div class="flex flex-col sm:flex-row gap-3">
                        
                        <!-- FORM TAMBAH KERANJANG -->
                        <form action="../action/actionkeranjang.php" method="POST" class="flex-1">
                            <input type="hidden" name="id_produk" value="<?= $produk['id_product']; ?>">
                            <!-- Input hidden ini akan diisi oleh JS di bawah -->
                            <input type="hidden" name="qty" id="qty_hidden" value="1">
                            
                            <button type="submit" name="tambah_keranjang" 
                                class="w-full bg-primary text-white py-3 rounded-xl font-semibold hover:bg-secondary transition flex items-center justify-center gap-2">
                                <i class="fa-solid fa-cart-plus"></i>
                                Tambah ke Keranjang
                            </button>
                        </form>

                        <!-- Tombol Beli Langsung -->
                        <button onclick="buyNow()" 
                            class="flex-1 bg-support text-primary py-3 rounded-xl font-bold hover:bg-blue-300 transition flex items-center justify-center gap-2">
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
            
            // Sinkronkan nilai ke input hidden untuk form
            document.getElementById('qty_hidden').value = val;
        }

        function buyNow() {
            const qty = parseInt(document.getElementById('qty').value);
            const total = hargaProduk * qty;
            
            // Arahkan ke halaman checkout atau proses langsung
            // window.location.href = `checkout.php?id=${idProduk}&qty=${qty}`;
            
            alert(`🛒 Beli Langsung:\n${namaProduk}\nJumlah: ${qty}\nTotal: Rp ${total.toLocaleString('id-ID')}`);
        }

        document.querySelector('input[type=number]').addEventListener('keydown', e => e.preventDefault());
    </script>

    <?php include '../layout/footer.php'; ?>
</body>
</html>