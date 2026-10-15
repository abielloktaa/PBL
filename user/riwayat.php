<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Riwayat - GalonKu</title>
    <?php include '../layout/assets.php'; ?>
</head>
<body class="font-sans antialiased bg-surface">

   
    <?php include '../layout/navbar.php'; ?>

    <main class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-6 md:py-8">

   
        <div class="mb-6">
            <h1 class="text-2xl md:text-3xl font-extrabold text-primary mb-2">Riwayat Transaksi</h1>
            <p class="text-accent text-sm md:text-base">Semua transaksi air & gas Anda tercatat di sini</p>
        </div>

    
        <div class="grid grid-cols-2 lg:grid-cols-4 gap-3 md:gap-4 mb-6">
            <div class="bg-gradient-to-br from-primary to-secondary rounded-2xl p-4 md:p-5 text-white shadow-pop relative overflow-hidden">
                <i class="fa-solid fa-wallet absolute -right-2 -bottom-2 text-6xl opacity-10"></i>
                <p class="text-white/70 text-xs mb-1">Total Belanja</p>
                <p class="font-extrabold text-lg md:text-2xl">Rp 1.2jt</p>
                <p class="text-[10px] text-support mt-1"><i class="fa-solid fa-arrow-up"></i> +12% bulan ini</p>
            </div>

            <div class="bg-white rounded-2xl p-4 md:p-5 shadow-soft relative overflow-hidden">
                <i class="fa-solid fa-receipt absolute -right-2 -bottom-2 text-6xl text-primary opacity-5"></i>
                <p class="text-accent text-xs mb-1">Total Transaksi</p>
                <p class="font-extrabold text-primary text-lg md:text-2xl">24</p>
                <p class="text-[10px] text-accent mt-1">Sepanjang waktu</p>
            </div>

            <div class="bg-white rounded-2xl p-4 md:p-5 shadow-soft relative overflow-hidden">
                <i class="fa-solid fa-droplet absolute -right-2 -bottom-2 text-6xl text-secondary opacity-5"></i>
                <p class="text-accent text-xs mb-1">Galon Terbeli</p>
                <p class="font-extrabold text-primary text-lg md:text-2xl">18</p>
                <p class="text-[10px] text-accent mt-1">Total galon</p>
            </div>

            <div class="bg-white rounded-2xl p-4 md:p-5 shadow-soft relative overflow-hidden">
                <i class="fa-solid fa-fire absolute -right-2 -bottom-2 text-6xl text-orange-500 opacity-5"></i>
                <p class="text-accent text-xs mb-1">Gas Terbeli</p>
                <p class="font-extrabold text-primary text-lg md:text-2xl">6</p>
                <p class="text-[10px] text-accent mt-1">Total tabung</p>
            </div>
        </div>

   
        <div class="bg-white rounded-2xl p-4 mb-6 shadow-soft flex flex-col md:flex-row gap-3">
            <div class="flex-1 relative">
                <i class="fa-solid fa-magnifying-glass absolute left-4 top-1/2 -translate-y-1/2 text-accent"></i>
                <input type="text" placeholder="Cari transaksi..." 
                    class="w-full pl-11 pr-4 py-3 rounded-xl border border-gray-200 focus:border-support focus:ring-2 focus:ring-support/30 outline-none transition text-sm">
            </div>
            <input type="month" 
                class="px-4 py-3 rounded-xl border border-gray-200 focus:border-support focus:ring-2 focus:ring-support/30 outline-none transition text-sm bg-white">
            <button class="px-6 py-3 rounded-xl bg-primary text-white text-sm font-semibold hover:bg-secondary transition">
                <i class="fa-solid fa-filter mr-2"></i>Filter
            </button>
        </div>

        <div class="space-y-3">

            <!-- Riwayat 1 -->
            <div class="bg-white rounded-2xl p-4 md:p-5 shadow-soft hover:shadow-pop transition-all">
                <div class="flex items-center gap-4">
                    <div class="w-12 h-12 md:w-14 md:h-14 rounded-xl bg-support/20 flex items-center justify-center flex-shrink-0">
                        <i class="fa-solid fa-droplet text-secondary text-lg md:text-xl"></i>
                    </div>
                    <div class="flex-1 min-w-0">
                        <div class="flex flex-wrap items-center gap-2 mb-1">
                            <h3 class="font-semibold text-primary text-sm">Galon Le Mineral 20L</h3>
                            <span class="text-[10px] bg-green-100 text-green-700 font-semibold px-2 py-0.5 rounded-full">Selesai</span>
                        </div>
                        <p class="text-xs text-accent">#GK-2024-1120 • 22 Nov 2024 • Wijaya Depot</p>
                    </div>
                    <div class="text-right flex-shrink-0">
                        <p class="font-bold text-primary text-sm">Rp 38.000</p>
                        <p class="text-[10px] text-accent">2 item</p>
                    </div>
                </div>
                <div class="flex gap-2 mt-3 pt-3 border-t border-gray-100">
                    <button class="text-xs text-secondary font-semibold hover:text-primary transition">Detail</button>
                    <span class="text-gray-300">•</span>
                    <button class="text-xs text-secondary font-semibold hover:text-primary transition">Beli Lagi</button>
                    <span class="text-gray-300">•</span>
                    <button class="text-xs text-secondary font-semibold hover:text-primary transition">Invoice</button>
                </div>
            </div>

   
            <div class="bg-white rounded-2xl p-4 md:p-5 shadow-soft hover:shadow-pop transition-all">
                <div class="flex items-center gap-4">
                    <div class="w-12 h-12 md:w-14 md:h-14 rounded-xl bg-orange-100 flex items-center justify-center flex-shrink-0">
                        <i class="fa-solid fa-fire text-orange-500 text-lg md:text-xl"></i>
                    </div>
                    <div class="flex-1 min-w-0">
                        <div class="flex flex-wrap items-center gap-2 mb-1">
                            <h3 class="font-semibold text-primary text-sm">Gas LPG 3Kg</h3>
                            <span class="text-[10px] bg-green-100 text-green-700 font-semibold px-2 py-0.5 rounded-full">Selesai</span>
                        </div>
                        <p class="text-xs text-accent">#GK-2024-1115 • 20 Nov 2024 • Toko Sejahtera</p>
                    </div>
                    <div class="text-right flex-shrink-0">
                        <p class="font-bold text-primary text-sm">Rp 75.000</p>
                        <p class="text-[10px] text-accent">3 item</p>
                    </div>
                </div>
                <div class="flex gap-2 mt-3 pt-3 border-t border-gray-100">
                    <button class="text-xs text-secondary font-semibold hover:text-primary transition">Detail</button>
                    <span class="text-gray-300">•</span>
                    <button class="text-xs text-secondary font-semibold hover:text-primary transition">Beli Lagi</button>
                    <span class="text-gray-300">•</span>
                    <button class="text-xs text-secondary font-semibold hover:text-primary transition">Invoice</button>
                </div>
            </div>

       
            <div class="bg-white rounded-2xl p-4 md:p-5 shadow-soft hover:shadow-pop transition-all">
                <div class="flex items-center gap-4">
                    <div class="w-12 h-12 md:w-14 md:h-14 rounded-xl bg-support/20 flex items-center justify-center flex-shrink-0">
                        <i class="fa-solid fa-droplet text-blue-400 text-lg md:text-xl"></i>
                    </div>
                    <div class="flex-1 min-w-0">
                        <div class="flex flex-wrap items-center gap-2 mb-1">
                            <h3 class="font-semibold text-primary text-sm">Galon Aqua 19L</h3>
                            <span class="text-[10px] bg-green-100 text-green-700 font-semibold px-2 py-0.5 rounded-full">Selesai</span>
                        </div>
                        <p class="text-xs text-accent">#GK-2024-1110 • 18 Nov 2024 • Toko Sejahtera</p>
                    </div>
                    <div class="text-right flex-shrink-0">
                        <p class="font-bold text-primary text-sm">Rp 20.000</p>
                        <p class="text-[10px] text-accent">1 item</p>
                    </div>
                </div>
                <div class="flex gap-2 mt-3 pt-3 border-t border-gray-100">
                    <button class="text-xs text-secondary font-semibold hover:text-primary transition">Detail</button>
                    <span class="text-gray-300">•</span>
                    <button class="text-xs text-secondary font-semibold hover:text-primary transition">Beli Lagi</button>
                    <span class="text-gray-300">•</span>
                    <button class="text-xs text-secondary font-semibold hover:text-primary transition">Invoice</button>
                </div>
            </div>

         
            <div class="bg-white rounded-2xl p-4 md:p-5 shadow-soft hover:shadow-pop transition-all">
                <div class="flex items-center gap-4">
                    <div class="w-12 h-12 md:w-14 md:h-14 rounded-xl bg-orange-100 flex items-center justify-center flex-shrink-0">
                        <i class="fa-solid fa-box text-secondary text-lg md:text-xl"></i>
                    </div>
                    <div class="flex-1 min-w-0">
                        <div class="flex flex-wrap items-center gap-2 mb-1">
                            <h3 class="font-semibold text-primary text-sm">Gas LPG 12Kg</h3>
                            <span class="text-[10px] bg-green-100 text-green-700 font-semibold px-2 py-0.5 rounded-full">Selesai</span>
                        </div>
                        <p class="text-xs text-accent">#GK-2024-1105 • 15 Nov 2024 • Wijaya Depot</p>
                    </div>
                    <div class="text-right flex-shrink-0">
                        <p class="font-bold text-primary text-sm">Rp 150.000</p>
                        <p class="text-[10px] text-accent">1 item</p>
                    </div>
                </div>
                <div class="flex gap-2 mt-3 pt-3 border-t border-gray-100">
                    <button class="text-xs text-secondary font-semibold hover:text-primary transition">Detail</button>
                    <span class="text-gray-300">•</span>
                    <button class="text-xs text-secondary font-semibold hover:text-primary transition">Beli Lagi</button>
                    <span class="text-gray-300">•</span>
                    <button class="text-xs text-secondary font-semibold hover:text-primary transition">Invoice</button>
                </div>
            </div>

        </div>

   
        <div class="flex justify-center items-center gap-2 mt-8">
            <button class="w-9 h-9 rounded-lg border border-gray-200 bg-white flex items-center justify-center text-accent hover:bg-surface transition">
                <i class="fa-solid fa-chevron-left text-xs"></i>
            </button>
            <button class="w-9 h-9 rounded-lg bg-primary text-white flex items-center justify-center text-sm font-semibold">1</button>
            <button class="w-9 h-9 rounded-lg border border-gray-200 bg-white flex items-center justify-center text-sm font-semibold text-accent hover:bg-surface transition">2</button>
            <button class="w-9 h-9 rounded-lg border border-gray-200 bg-white flex items-center justify-center text-sm font-semibold text-accent hover:bg-surface transition">3</button>
            <button class="w-9 h-9 rounded-lg border border-gray-200 bg-white flex items-center justify-center text-accent hover:bg-surface transition">
                <i class="fa-solid fa-chevron-right text-xs"></i>
            </button>
        </div>

    </main>

    <?php include '../layout/footer.php'; ?>

</body>
</html>