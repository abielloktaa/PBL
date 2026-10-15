<?php
// Simulasi data produk (nanti bisa diganti ambil dari database)
$produk = [
    'id' => 1,
    'nama' => 'Galon Le Mineral 20L',
    'depot' => 'Wijaya Depot',
    'harga' => 19000,
    'harga_lama' => 22000,
    'rating' => 4.8,
    'terjual' => 120,
    'stok' => 25,
    'kategori' => 'Air Galon',
    'deskripsi' => 'Air mineral berkualitas tinggi yang diproses melalui filtrasi berlapis. Cocok untuk kebutuhan sehari-hari keluarga Anda.',
    'icon' => 'fa-droplet',
    'icon_color' => 'text-secondary'
];
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $produk['nama'] ?> - GalonKu</title>
    <?php include '../layout/assets.php'; ?>
</head>
<body class="font-sans antialiased bg-surface">

    <?php include '../layout/navbar.php'; ?>

    <main class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8 py-6 md:py-8">

        <!-- BREADCRUMB -->
        <div class="mb-5 text-sm">
            <a href="katalog.php" class="text-accent hover:text-primary transition">
                <i class="fa-solid fa-arrow-left mr-1"></i> Kembali ke Katalog
            </a>
        </div>

        <!-- CARD DETAIL PRODUK -->
        <div class="bg-white rounded-2xl shadow-soft overflow-hidden">
            <div class="flex flex-col md:flex-row">

                <!-- GAMBAR / ICON -->
                <div class="md:w-2/5 bg-gradient-to-br from-[#EBF4FF] to-[#D9E8FF] p-8 flex items-center justify-center min-h-[250px]">
                    <i class="fa-solid <?= $produk['icon'] ?> <?= $produk['icon_color'] ?> text-8xl md:text-9xl opacity-70"></i>
                </div>

                <!-- INFO PRODUK -->
                <div class="md:w-3/5 p-5 md:p-7">

                    <!-- Kategori & Rating -->
                    <div class="flex items-center gap-3 mb-2">
                        <span class="bg-surface text-secondary text-xs font-semibold px-3 py-1 rounded-full">
                            <?= $produk['kategori'] ?>
                        </span>
                        <div class="flex items-center gap-1 text-sm">
                            <i class="fa-solid fa-star text-yellow-400 text-xs"></i>
                            <span class="font-semibold text-primary"><?= $produk['rating'] ?></span>
                            <span class="text-accent text-xs">(<?= $produk['terjual'] ?> terjual)</span>
                        </div>
                    </div>

                    <!-- Nama Produk -->
                    <h1 class="text-2xl md:text-3xl font-extrabold text-primary mb-2">
                        <?= $produk['nama'] ?>
                    </h1>

                    <!-- Depot -->
                    <p class="text-accent text-sm mb-4">
                        <i class="fa-solid fa-store mr-1"></i><?= $produk['depot'] ?>
                    </p>

                    <!-- Harga -->
                    <div class="border-t border-b border-gray-100 py-4 mb-4">
                        <?php if ($produk['harga_lama']): ?>
                            <p class="text-sm text-accent line-through">
                                Rp <?= number_format($produk['harga_lama'], 0, ',', '.') ?>
                            </p>
                        <?php endif; ?>
                        <p class="text-3xl font-extrabold text-primary">
                            Rp <?= number_format($produk['harga'], 0, ',', '.') ?>
                        </p>
                    </div>

                    <!-- Deskripsi -->
                    <div class="mb-4">
                        <h3 class="font-bold text-primary text-sm mb-2">Deskripsi</h3>
                        <p class="text-sm text-accent leading-relaxed">
                            <?= $produk['deskripsi'] ?>
                        </p>
                    </div>

                    <!-- Info Stok & Pengiriman -->
                    <div class="flex flex-wrap gap-4 mb-5 text-sm">
                        <div class="flex items-center gap-2 text-accent">
                            <i class="fa-solid fa-boxes-stacked text-secondary"></i>
                            Stok: <span class="font-bold text-primary"><?= $produk['stok'] ?></span>
                        </div>
                        <div class="flex items-center gap-2 text-accent">
                            <i class="fa-solid fa-truck-fast text-secondary"></i>
                            Estimasi 1-2 jam
                        </div>
                    </div>

                    <!-- Quantity -->
                    <div class="flex items-center gap-4 mb-5">
                        <span class="text-sm font-semibold text-primary">Jumlah:</span>
                        <div class="flex items-center bg-surface rounded-lg">
                            <button onclick="changeQty(-1)" class="w-10 h-10 flex items-center justify-center text-primary hover:bg-support/30 rounded-l-lg transition">
                                <i class="fa-solid fa-minus text-xs"></i>
                            </button>
                            <input id="qty" type="number" value="1" min="1" max="<?= $produk['stok'] ?>" readonly
                                class="w-12 h-10 text-center bg-transparent font-bold text-primary outline-none">
                            <button onclick="changeQty(1)" class="w-10 h-10 flex items-center justify-center text-primary hover:bg-support/30 rounded-r-lg transition">
                                <i class="fa-solid fa-plus text-xs"></i>
                            </button>
                        </div>
                    </div>

                    <!-- Tombol Aksi -->
                    <div class="flex flex-col sm:flex-row gap-3">
                        <button onclick="addToCart()" 
                            class="flex-1 bg-primary text-white py-3 rounded-xl font-semibold hover:bg-secondary transition flex items-center justify-center gap-2">
                            <i class="fa-solid fa-cart-plus"></i>
                            Tambah ke Keranjang
                        </button>
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
        const hargaProduk = <?= $produk['harga'] ?>;
        const stokProduk = <?= $produk['stok'] ?>;
        const namaProduk = "<?= $produk['nama'] ?>";

        function changeQty(delta) {
            const input = document.getElementById('qty');
            let val = parseInt(input.value) + delta;
            if (val < 1) val = 1;
            if (val > stokProduk) {
                val = stokProduk;
                alert('Jumlah melebihi stok tersedia!');
            }
            input.value = val;
        }

        function addToCart() {
            const qty = document.getElementById('qty').value;
            const total = hargaProduk * qty;
            
            alert(`✅ ${namaProduk}\nJumlah: ${qty}\nTotal: Rp ${total.toLocaleString('id-ID')}\n\nBerhasil ditambahkan ke keranjang!`);
            
            // TODO: Kirim ke backend
            // fetch('tambah_keranjang.php', { method: 'POST', body: ... })
        }

        function buyNow() {
            const qty = document.getElementById('qty').value;
            const total = hargaProduk * qty;
            
            alert(`🛒 Beli Langsung:\n${namaProduk}\nJumlah: ${qty}\nTotal: Rp ${total.toLocaleString('id-ID')}`);
            
            // TODO: Redirect ke checkout
            // window.location.href = 'checkout.php?id=<?= $produk['id'] ?>&qty=' + qty;
        }

        // Hilangkan spinner input number
        document.querySelector('input[type=number]').addEventListener('keydown', e => e.preventDefault());
    </script>

    <?php include '../layout/footer.php'; ?>
</body>
</html>