<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pesanan - GalonKu</title>
    <?php include '../layout/assets.php'; ?>
</head>
<body class="font-sans antialiased bg-surface">

    <?php include '../layout/navbar.php'; ?>

    <main class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-6 md:py-8">

  
        <div class="mb-6">
            <h1 class="text-2xl md:text-3xl font-extrabold text-primary mb-2">Pesanan Saya</h1>
        </div>

        <div class="bg-white rounded-2xl p-2 mb-6 shadow-soft flex gap-1 overflow-x-auto scrollbar-hide">
            <button class="px-4 md:px-6 py-2.5 rounded-xl bg-primary text-white text-xs md:text-sm font-semibold whitespace-nowrap">
                Semua <span class="ml-1 bg-white/20 px-2 py-0.5 rounded-full text-[10px]">4</span>
            </button>
            <button class="px-4 md:px-6 py-2.5 rounded-xl text-accent hover:bg-surface text-xs md:text-sm font-semibold whitespace-nowrap transition">Diproses</button>
            <button class="px-4 md:px-6 py-2.5 rounded-xl text-accent hover:bg-surface text-xs md:text-sm font-semibold whitespace-nowrap transition">Dikirim</button>
            <button class="px-4 md:px-6 py-2.5 rounded-xl text-accent hover:bg-surface text-xs md:text-sm font-semibold whitespace-nowrap transition">Selesai</button>
            <button class="px-4 md:px-6 py-2.5 rounded-xl text-accent hover:bg-surface text-xs md:text-sm font-semibold whitespace-nowrap transition">Dibatalkan</button>
        </div>

  
        <div class="space-y-4">

            <div class="bg-white rounded-2xl p-4 md:p-6 shadow-soft">
                <div class="flex flex-wrap justify-between items-start gap-3 pb-4 border-b border-gray-100">
                    <div>
                        <p class="text-xs text-accent mb-1">No. Pesanan</p>
                        <p class="font-bold text-primary text-sm">#GK-2024-1123</p>
                    </div>
                    <div class="text-right">
                        <span class="inline-flex items-center gap-1 bg-support/20 text-secondary text-xs font-semibold px-3 py-1.5 rounded-full">
                            <i class="fa-solid fa-truck"></i> Dikirim
                        </span>
                        <p class="text-xs text-accent mt-1">23 Nov 2024, 14:30</p>
                    </div>
                </div>

                <div class="flex items-center gap-4 py-4">
                    <div class="w-16 h-16 bg-gray-50 rounded-xl flex items-center justify-center flex-shrink-0">
                        <i class="fa-solid fa-droplet text-secondary text-2xl"></i>
                    </div>
                    <div class="flex-1 min-w-0">
                        <h3 class="font-semibold text-primary text-sm truncate">Galon Le Mineral 20L</h3>
                        <p class="text-xs text-accent">Wijaya Depot • 2 item</p>
                    </div>
                    <p class="font-bold text-primary text-sm">Rp 38.000</p>
                </div>

                <!-- Progress Bar -->
                <div class="relative pt-2 pb-4">
                    <div class="flex justify-between text-[10px] text-accent mb-2">
                        <span>Pesanan dibuat</span>
                        <span>Diproses</span>
                        <span class="text-secondary font-bold">Dikirim</span>
                        <span>Selesai</span>
                    </div>
                    <div class="h-1.5 bg-gray-100 rounded-full overflow-hidden">
                        <div class="h-full bg-gradient-to-r from-primary to-support rounded-full" style="width: 60%"></div>
                    </div>
                </div>

                <div class="flex flex-col sm:flex-row gap-2 pt-4 border-t border-gray-100">
                    <button class="flex-1 text-center bg-primary text-white py-2.5 rounded-xl text-sm font-semibold hover:bg-secondary transition">
                        Lacak Pesanan
                    </button>
                    <button class="flex-1 text-center border border-gray-200 text-accent py-2.5 rounded-xl text-sm font-semibold hover:bg-surface transition">
                        Hubungi Kurir
                    </button>
                </div>
            </div>

        </div>
    </main>

    <?php include '../layout/footer.php'; ?>
</body>
</html>