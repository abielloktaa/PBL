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

        <!-- Header -->
        <div class="mb-6">
            <h1 class="text-2xl md:text-3xl font-extrabold text-primary mb-1">Katalog Produk</h1>
            <p class="text-accent text-sm">Temukan air dan gas berkualitas dari depot terpercaya</p>
        </div>

        <!-- Search & Sort -->
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

        <!-- Kategori -->
        <div class="flex gap-2 mb-6 overflow-x-auto pb-1">
            <button class="px-4 py-2 rounded-full bg-primary text-white text-xs font-semibold whitespace-nowrap">Semua</button>
            <button class="px-4 py-2 rounded-full bg-white text-accent hover:bg-support hover:text-primary text-xs font-semibold whitespace-nowrap transition shadow-soft">Air Galon</button>
            <button class="px-4 py-2 rounded-full bg-white text-accent hover:bg-support hover:text-primary text-xs font-semibold whitespace-nowrap transition shadow-soft">Gas LPG</button>
            <button class="px-4 py-2 rounded-full bg-white text-accent hover:bg-support hover:text-primary text-xs font-semibold whitespace-nowrap transition shadow-soft">Air Mineral</button>
            <button class="px-4 py-2 rounded-full bg-white text-accent hover:bg-support hover:text-primary text-xs font-semibold whitespace-nowrap transition shadow-soft">Promo</button>
        </div>

        <!-- Info Jumlah -->
        <p class="text-accent text-sm mb-4">Menampilkan <span class="font-bold text-primary">1</span> produk</p>

        <!-- Grid Produk -->
        <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4">

            <!-- Produk 1 -->
            <div class="bg-white p-3 rounded-2xl shadow-soft hover:shadow-pop transition-all group">
                <span class="inline-block bg-support text-primary text-[10px] font-bold px-2 py-0.5 rounded-full mb-2">PROMO</span>
                <div class="h-28 md:h-32 bg-gray-50 rounded-xl mb-3 flex items-center justify-center overflow-hidden">
                    <i class="fa-solid fa-droplet text-secondary text-4xl opacity-50 group-hover:scale-110 transition-transform"></i>
                </div>
                <h3 class="font-semibold text-sm text-primary mb-1 truncate">Galon Le Mineral 20L</h3>
                <p class="text-xs text-accent mb-2"><i class="fa-solid fa-store mr-1"></i>Wijaya Depot</p>
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-[10px] text-accent line-through">Rp 22.000</p>
                        <span class="font-bold text-primary text-sm">Rp 19.000</span>
                    </div>
                    <button class="w-8 h-8 rounded-full bg-secondary text-white flex items-center justify-center text-xs hover:bg-primary transition-colors">
                        <i class="fa-solid fa-plus"></i>
                    </button>
                </div>
            </div>

        </div>

    </main>

    <?php include '../layout/footer.php'; ?>
</body>
</html>