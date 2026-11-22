<?php
session_start();
include __DIR__ . '/../koneksi.php'; 

if (!isset($_SESSION['username']) || $_SESSION['id_role'] != "1") {
    header("location:../index.php?pesan=belum_login");
    exit();
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Keranjang Belanja - GalonKu</title>
    <?php include '../layout/assets.php'; ?>
</head>
<body class="font-sans antialiased bg-surface">

    <?php include '../layout/navbar.php'; ?>

    <main class="max-w-4xl mx-auto px-4 py-8">
        <div class="flex justify-between items-center mb-6">
            <h1 class="text-2xl font-extrabold text-primary">Keranjang Belanja Anda</h1>
            <a href="katalog.php" class="text-sm font-semibold text-secondary hover:underline">
                <i class="fa-solid fa-plus mr-1"></i> Tambah Barang
            </a>
        </div>

        <?php if (empty($_SESSION['keranjang'])) : ?>
            <!-- Tampilan Jika Kosong -->
            <div id="tampilan-kosong" class="bg-white p-8 rounded-2xl shadow-soft text-center border border-gray-400">
                <i class="fa-solid fa-cart-shopping text-6xl text-gray-300 mb-4"></i>
                <p class="text-gray-500 mb-4">Keranjang masih kosong.</p>
                <a href="katalog.php" class="bg-primary text-white px-6 py-2 rounded-xl hover:bg-secondary transition">Belanja Sekarang</a>
            </div>
        <?php else : ?>
            
            <div id="tampilan-keranjang" class="bg-white rounded-2xl shadow-soft border border-gray-400 overflow-hidden">
                <div class="p-6">
                    <table class="w-full text-left">
                        <thead>
                            <tr class="border-b text-sm text-gray-500">
                                <th class="pb-3">Produk</th>
                                <th class="pb-3 text-center w-32">Jumlah</th>
                                <th class="pb-3 text-right">Subtotal</th>
                                <th class="pb-3 text-center w-12">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $total_belanja = 0;
                            foreach ($_SESSION['keranjang'] as $id_produk => $qty) {
                                $query = mysqli_query($koneksi, "SELECT * FROM product WHERE id_product = '$id_produk'");
                                $p = mysqli_fetch_assoc($query);
                                
                                if (!$p) continue; 

                                $subtotal = $p['price'] * $qty;
                                $total_belanja += $subtotal;
                            ?>
                            <tr class="border-b" id="row-<?= $id_produk; ?>">
                                <td class="py-4">
                                    <p class="font-semibold text-primary"><?= $p['name_product']; ?></p>
                                    <p class="text-xs text-gray-400">Rp <?= number_format($p['price'], 0, ',', '.'); ?> / item</p>
                                </td>
                                
                                <td class="py-4 text-center">
                                    <div class="flex items-center justify-center gap-2">
                                        <button type="button" onclick="updateQty(<?= $id_produk; ?>, -1, <?= $p['stock']; ?>)" class="w-7 h-7 rounded bg-gray-100 text-primary hover:bg-gray-200 transition">
                                            <i class="fa-solid fa-minus text-xs"></i>
                                        </button>
                                        
                                        <input type="number" id="qty-<?= $id_produk; ?>" value="<?= $qty; ?>" 
                                            onchange="updateQty(<?= $id_produk; ?>, 0, <?= $p['stock']; ?>)" 
                                            class="w-12 text-center py-1 border border-gray-300 rounded-lg text-sm font-bold text-primary focus:ring-2 focus:ring-secondary outline-none">
                                        
                                        <button type="button" onclick="updateQty(<?= $id_produk; ?>, 1, <?= $p['stock']; ?>)" class="w-7 h-7 rounded bg-gray-100 text-primary hover:bg-gray-200 transition">
                                            <i class="fa-solid fa-plus text-xs"></i>
                                        </button>
                                    </div>
                                </td>

                                <td class="py-4 text-right font-bold text-primary" id="subtotal-<?= $id_produk; ?>" data-price="<?= $p['price']; ?>">
                                    Rp <?= number_format($subtotal, 0, ',', '.'); ?>
                                </td>

                                <td class="py-4 text-center">
                                    <button type="button" onclick="hapusBarang(<?= $id_produk; ?>)" class="text-red-500 hover:text-red-700 transition" title="Hapus Barang">
                                        <i class="fa-solid fa-trash-can"></i>
                                    </button>
                                </td>
                            </tr>
                            <?php } ?>
                        </tbody>
                    </table>
                </div>

                <div class="bg-gray-50 p-6 flex flex-col md:flex-row justify-between items-center border-t border-gray-200 gap-4">
                    <div class="w-full md:w-auto text-center md:text-left">
                        <p class="text-sm text-gray-500">Total Pembayaran</p>
                        <p class="text-2xl font-extrabold text-primary" id="total-belanja-tampil">
                            Rp <?= number_format($total_belanja, 0, ',', '.'); ?>
                        </p>
                    </div>
                    
                    <div class="flex flex-col sm:flex-row gap-3 w-full md:w-auto">
                        <button type="button" onclick="checkout()" class="bg-primary text-white px-8 py-3 rounded-xl font-bold hover:bg-secondary transition w-full sm:w-auto">
                            Checkout Semua
                        </button>
                    </div>
                </div>
            </div>
        <?php endif; ?>
    </main>

    <!-- ================= POPUP KONFIRMASI HAPUS ================= -->
    <div id="deleteModal" class="fixed inset-0 z-[100] hidden items-center justify-center bg-black/60 backdrop-blur-sm p-4 transition-opacity duration-300">
        <div class="bg-white rounded-[2rem] p-8 max-w-sm w-full text-center relative overflow-hidden shadow-2xl">
            <div class="w-20 h-20 mx-auto bg-red-50 rounded-full flex items-center justify-center mb-4 border-4 border-white shadow-sm">
                <i class="fa-solid fa-trash-can text-4xl text-red-500"></i>
            </div>
            
            <h2 class="text-xl font-extrabold text-primary mb-2">Hapus Barang?</h2>
            <p class="text-sm text-gray-500 mb-6">Apakah Anda yakin ingin menghapus produk ini dari keranjang belanja Anda?</p>
            
            <div class="flex gap-3">
                <button onclick="closeDeleteModal()" class="flex-1 bg-gray-100 text-gray-600 py-3 rounded-xl font-bold hover:bg-gray-200 transition">Batal</button>
                <button onclick="confirmDelete()" class="flex-1 bg-red-500 text-white py-3 rounded-xl font-bold hover:bg-red-600 transition shadow-md">Ya, Hapus</button>
            </div>
        </div>
    </div>

    <!-- ================= JAVASCRIPT AJAX ================= -->
    <script>
        // Variabel untuk menyimpan ID produk yang akan dihapus
        let productToDelete = null;

        // Fungsi untuk Update Jumlah (Plus/Minus/Ketik Manual)
        function updateQty(idProduk, change, maxStock) {
            const input = document.getElementById('qty-' + idProduk);
            let currentVal = parseInt(input.value);
            let newVal = currentVal;

            if (change !== 0) {
                newVal = currentVal + change;
            }

            if (newVal > maxStock) {
                alert('Jumlah melebihi stok yang tersedia!');
                input.value = maxStock;
                newVal = maxStock;
            } else if (newVal < 0) {
                newVal = 0;
            }

            input.value = newVal;

            const formData = new FormData();
            formData.append('update_qty', '1');
            formData.append('id_produk', idProduk);
            formData.append('jumlah', newVal);

            // Pastikan path file PHP ini benar (sesuaikan folder action jika perlu)
            fetch('updatekeranjang.php', {
                method: 'POST',
                body: formData
            })
            .then(response => response.json())
            .then(data => {
                if (newVal === 0) {
                    document.getElementById('row-' + idProduk).remove();
                    cekKeranjangKosong();
                } else {
                    const price = parseInt(document.getElementById('subtotal-' + idProduk).getAttribute('data-price'));
                    const subtotalBaru = price * newVal;
                    document.getElementById('subtotal-' + idProduk).innerText = 'Rp ' + subtotalBaru.toLocaleString('id-ID');
                }
                hitungTotal();
            });
        }

        // 1. Fungsi saat tombol tong sampah diklik (Membuka Popup)
        function hapusBarang(idProduk) {
            productToDelete = idProduk;
            const modal = document.getElementById('deleteModal');
            modal.classList.remove('hidden');
            modal.classList.add('flex');
        }

        // 2. Fungsi saat tombol "Batal" di popup diklik
        function closeDeleteModal() {
            const modal = document.getElementById('deleteModal');
            modal.classList.add('hidden');
            modal.classList.remove('flex');
            productToDelete = null;
        }

        // 3. Fungsi saat tombol "Ya, Hapus" di popup diklik
        function confirmDelete() {
            if (!productToDelete) return;

            const formData = new FormData();
            formData.append('hapus', productToDelete);

            // Pastikan path file PHP ini benar
            fetch('update_keranjang.php', {
                method: 'POST',
                body: formData
            })
            .then(response => response.json())
            .then(data => {
                // Hapus baris tabel secara realtime
                document.getElementById('row-' + productToDelete).remove();
                hitungTotal();
                cekKeranjangKosong();
                closeDeleteModal();
            });
        }

        function hitungTotal() {
            let total = 0;
            const subtotals = document.querySelectorAll('[id^="subtotal-"]');
            
            subtotals.forEach(el => {
                const id = el.id.replace('subtotal-', '');
                const price = parseInt(el.getAttribute('data-price'));
                const qty = parseInt(document.getElementById('qty-' + id).value);
                total += (price * qty);
            });

            document.getElementById('total-belanja-tampil').innerText = 'Rp ' + total.toLocaleString('id-ID');
        }

        function cekKeranjangKosong() {
            const rows = document.querySelectorAll('tbody tr');
            if (rows.length === 0) {
                window.location.reload(); 
            }
        }

        function checkout() {
            window.location.href = 'checkout.php';
        }
    </script>

    <?php include '../layout/footer.php'; ?>
</body>
</html>