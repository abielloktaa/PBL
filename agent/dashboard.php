<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Agent - GalonKu</title>
    <?php include '../layout/assets.php'; ?>
</head>
<body class="font-sans antialiased bg-surface">

    <?php include '../layout/navbar.php'; ?>

    <div class="flex min-h-[calc(100vh-64px)]">


        <main class="flex-1 p-4 md:p-6 lg:p-8 overflow-x-hidden">

  
            <div class="flex items-center justify-between mb-6">
                <div>
                    <h1 class="text-2xl md:text-3xl font-extrabold text-primary">Dashboard</h1>
                    <p class="text-accent text-xl mt-1">Selamat datang kembali, <span class="font-semibold text-primary">Wijaya Depot</span> 👋</p>
                </div>
                

                <button class="lg:hidden w-10 h-10 rounded-full bg-white shadow-soft flex items-center justify-center text-primary relative">
                    <i class="fa-solid fa-bell"></i>
                    <span class="absolute top-2 right-2 w-2 h-2 bg-red-500 rounded-full"></span>
                </button>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-6">

                <div class="bg-white rounded-2xl p-5 shadow-soft border border-gray-50">
                    <div class="flex items-center justify-between mb-3">
                        <p class="text-accent text-sm font-medium">Pesanan Baru</p>
                        <div class="w-9 h-9 rounded-lg bg-support/20 flex items-center justify-center">
                            <i class="fa-solid fa-clipboard-list text-secondary text-sm"></i>
                        </div>
                    </div>
                    <p class="text-3xl font-extrabold text-primary mb-1">3</p>
                    <p class="text-xs text-accent">Menunggu diterima</p>
                </div>

                <div class="bg-white rounded-2xl p-5 shadow-soft border border-gray-50">
                    <div class="flex items-center justify-between mb-3">
                        <p class="text-accent text-sm font-medium">Pesanan Diproses</p>
                        <div class="w-9 h-9 rounded-lg bg-support/20 flex items-center justify-center">
                            <i class="fa-solid fa-clock text-secondary text-sm"></i>
                        </div>
                    </div>
                    <p class="text-3xl font-extrabold text-primary mb-1">7</p>
                    <p class="text-xs text-accent">Sedang disiapkan</p>
                </div>

                <div class="bg-white rounded-2xl p-5 shadow-soft border border-gray-50">
                    <div class="flex items-center justify-between mb-3">
                        <p class="text-accent text-sm font-medium">Pengantaran Hari Ini</p>
                        <div class="w-9 h-9 rounded-lg bg-support/20 flex items-center justify-center">
                            <i class="fa-solid fa-truck-fast text-secondary text-sm"></i>
                        </div>
                    </div>
                    <p class="text-3xl font-extrabold text-primary mb-1">4</p>
                    <p class="text-xs text-accent">2 Selesai</p>
                </div>
            </div>

  
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-4">


                <div class="lg:col-span-2 bg-white rounded-2xl shadow-soft p-5 border border-gray-50">
                    <div class="flex items-center justify-between mb-4">
                        <h2 class="text-lg font-bold text-primary">Pesanan Baru</h2>
                        <a href="pesanan_agent.php" class="text-sm text-secondary hover:text-primary font-semibold transition">Lihat Semua</a>
                    </div>

                    <div class="space-y-3">


                        <div class="flex items-center gap-3 p-3 rounded-xl hover:bg-surface transition">
                            <div class="w-12 h-12 rounded-lg bg-support/20 flex items-center justify-center flex-shrink-0">
                                <i class="fa-solid fa-droplet text-secondary"></i>
                            </div>
                            <div class="flex-1 min-w-0">
                                <p class="font-semibold text-primary text-sm">#PSN-001</p>
                                <p class="text-xs text-accent truncate">Budi Santoso — Jl. Merdeka No. 10</p>
                            </div>
                            <div class="flex gap-2 flex-shrink-0">
                                <button class="px-4 py-2 rounded-lg bg-surface text-accent text-xs font-semibold hover:bg-gray-200 transition">
                                    Tolak
                                </button>
                                <button class="px-4 py-2 rounded-lg bg-primary text-white text-xs font-semibold hover:bg-secondary transition">
                                    Terima
                                </button>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- PENGANTARAN HARI INI (Kanan, lebar 1) -->
                <div class="bg-white rounded-2xl shadow-soft p-5 border border-gray-50">
                    <div class="flex items-center justify-between mb-4">
                        <h2 class="text-lg font-bold text-primary">Pengantaran Hari Ini</h2>
                        <a href="#" class="text-secondary hover:text-primary transition">
                            <i class="fa-solid fa-arrow-right"></i>
                        </a>
                    </div>

                    <div class="space-y-3">

                        <!-- Item 1 -->
                        <div class="flex items-start gap-3 p-3 rounded-xl hover:bg-surface transition">
                            <div class="w-10 h-10 rounded-lg bg-secondary flex items-center justify-center flex-shrink-0">
                                <i class="fa-solid fa-user text-white text-xs"></i>
                            </div>
                            <div class="flex-1 min-w-0">
                                <p class="font-semibold text-primary text-sm">Nama — Alamat</p>
                                <span class="inline-block mt-1 bg-orange-100 text-orange-600 text-[10px] font-semibold px-2 py-0.5 rounded-full">
                                    Proses
                                </span>
                            </div>
                            <span class="text-xs font-bold text-primary flex-shrink-0">10:00</span>
                        </div>

                        <!-- Item 2 -->
                        <div class="flex items-start gap-3 p-3 rounded-xl hover:bg-surface transition">
                            <div class="w-10 h-10 rounded-lg bg-secondary flex items-center justify-center flex-shrink-0">
                                <i class="fa-solid fa-user text-white text-xs"></i>
                            </div>
                            <div class="flex-1 min-w-0">
                                <p class="font-semibold text-primary text-sm">Nama — Alamat</p>
                                <span class="inline-block mt-1 bg-orange-100 text-orange-600 text-[10px] font-semibold px-2 py-0.5 rounded-full">
                                    Proses
                                </span>
                            </div>
                            <span class="text-xs font-bold text-primary flex-shrink-0">12:15</span>
                        </div>

                    </div>
                </div>

            </div>

        </main>
    </div>

    <!-- ================= MOBILE BOTTOM NAV (Khusus HP) ================= -->
    <nav class="lg:hidden fixed bottom-0 left-0 right-0 bg-white border-t border-gray-100 shadow-lg z-40">
        <div class="grid grid-cols-4 py-2">
            <a href="dashboard_agent.php" class="flex flex-col items-center gap-1 py-2 text-primary">
                <i class="fa-solid fa-house text-lg"></i>
                <span class="text-[10px] font-semibold">Home</span>
            </a>
            <a href="pesanan_agent.php" class="flex flex-col items-center gap-1 py-2 text-accent">
                <i class="fa-solid fa-receipt text-lg"></i>
                <span class="text-[10px] font-semibold">Pesanan</span>
            </a>
            <a href="stok.php" class="flex flex-col items-center gap-1 py-2 text-accent">
                <i class="fa-solid fa-boxes-stacked text-lg"></i>
                <span class="text-[10px] font-semibold">Stok</span>
            </a>
            <a href="profil.php" class="flex flex-col items-center gap-1 py-2 text-accent">
                <i class="fa-solid fa-user text-lg"></i>
                <span class="text-[10px] font-semibold">Profil</span>
            </a>
        </div>
    </nav>

    <!-- Padding bawah untuk mobile nav -->
    <div class="lg:hidden h-20"></div>

    <?php include '../layout/footer.php'; ?>
</body>
</html>