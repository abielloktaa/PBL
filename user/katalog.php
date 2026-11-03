<?php

session_start();

if (!isset($_SESSION['username']) || $_SESSION['id_role'] != "1") {
    header("location:../index.php?pesan=akses_ditolak");
    exit();
}


$username = $_SESSION['username'];
$id_user  = $_SESSION['id_user'];
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Katalog - GalonKu</title>
    <?php include '../layout/assets.php'; ?>
</head>
<body class="font-sans antialiased bg-surface">


    <?php include '../layout/navbar.php'; ?>

    <main class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-6 md:py-8">

        <div class="mb-6">
            <h1 class="text-2xl md:text-3xl font-extrabold text-primary mb-1">Katalog Produk</h1>
            <p class="text-sm text-gray-500">Halo <span class="font-semibold capitalize"><?= htmlspecialchars($username); ?></span>, temukan kebutuhan air dan gasmu di sini.</p>
        </div>

     
        <div class="bg-white rounded-2xl p-4 mb-6 shadow-soft flex flex-col md:flex-row gap-3">
            <div class="flex-1 relative">
                <i class="fa-solid fa-magnifying-glass absolute left-4 top-1/2 -translate-y-1/2 text-accent text-sm"></i>
                <input type="text" placeholder="Cari produk..." 
                    class="w-full pl-11 pr-4 py-3 rounded-xl border border-gray-200 focus:border-support focus:ring-2 focus:ring-support/30 outline-none transition text-sm">
            </div>
            <select class="px-4 py-3 rounded-xl border border-gray-200 focus:border-support focus:ring-2 focus:ring-support/30 outline-none transition text-sm bg-white md:w-48">
                <option>Terbaru</option>
                <option>Termurah</option>
                <option>Termahal</option>
                <option>A-Z</option>
            </select>
        </div>


        <div class="flex gap-2 mb-6 overflow-x-auto pb-1">
            <button class="px-9 py-2 rounded-full bg-primary text-white text-xs font-semibold whitespace-nowrap">Semua</button>
            <button class="px-4 py-2 rounded-full bg-white text-accent hover:bg-support hover:text-primary text-xs font-semibold whitespace-nowrap transition shadow-soft border border-gray-400">Air Galon</button>
            <button class="px-4 py-2 rounded-full bg-white text-accent hover:bg-support hover:text-primary text-xs font-semibold whitespace-nowrap transition shadow-soft border border-gray-400">Gas LPG</button>
            <button class="px-4 py-2 rounded-full bg-white text-accent hover:bg-support hover:text-primary text-xs font-semibold whitespace-nowrap transition shadow-soft border border-gray-400">Air Mineral</button>
            <button class="px-4 py-2 rounded-full bg-white text-accent hover:bg-support hover:text-primary text-xs font-semibold whitespace-nowrap transition shadow-soft border border-gray-400">Promo</button>
        </div>

   
        <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4">

            <div class="bg-white p-3 rounded-2xl shadow-soft hover:shadow-pop transition-all group border border-gray-400">
                <div class="h-28 md:h-32 bg-gray-50 rounded-xl mb-3 flex items-center justify-center overflow-hidden border border-gray-300">
                    <i class="fa-solid fa-droplet text-secondary text-4xl opacity-50 group-hover:scale-110 transition-transform"></i>
                </div>
                <h3 class="font-semibold text-sm text-primary mb-1 truncate">Galon Le Mineral 20L</h3>
                <p class="text-xs text-accent mb-2"><i class="fa-solid fa-store mr-1"></i>Wijaya Depot</p>
                <div class="flex items-center justify-between">
                    <div>
                        <span class="font-bold text-primary text-sm">Rp 19.000</span>
                    </div>
               
                    <button onclick="tambahKeranjang(1)" class="w-8 h-8 rounded-full bg-secondary text-white flex items-center justify-center text-xs hover:bg-primary transition-colors" title="Tambah ke Keranjang">
                        <i class="fa-solid fa-plus"></i>
                    </button>
                </div>
            </div>

      

        </div>

    </main>

    <?php include '../layout/footer.php'; ?>

    <!-- Script sederhana untuk ngetes tombol keranjang -->
    <script>
        function tambahKeranjang(idProduk) {
            // Di sini nanti kamu bisa ganti dengan AJAX fetch ke proses_keranjang.php
            alert('Produk dengan ID ' + idProduk + ' berhasil ditambahkan ke keranjang!');
        }
    </script>
</body>
</html>