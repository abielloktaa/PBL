<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard - GalonKu</title>
    <?php include '../layout/assets.php'; ?>
</head>
<body class="font-sans antialiased bg-surface">

    <?php include '../layout/navbar.php'; ?>

    <main class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-6 md:py-8">

   
        <div class="bg-gradient-to-br from-[#EBF4FF] to-[#D9E8FF] rounded-3xl p-6 md:p-8 mb-8 relative overflow-hidden flex flex-col md:flex-row items-center justify-between border border-blue-100 shadow-soft">
            <div class="z-10 md:w-1/2">
                <h1 class="text-3xl md:text-5xl font-extrabold text-primary leading-tight mb-4">
                    Belanja Air & Gas<br>Lebih Mudah
                </h1>
                <p class="text-accent mb-6 max-w-md text-sm md:text-base">Dapatkan harga terbaik untuk kebutuhan air dan gas Anda. Antar langsung ke depan pintu!</p>
                <a href="katalog.php" class="inline-block bg-primary text-white px-6 py-3 rounded-full font-semibold shadow-lg hover:bg-secondary hover:-translate-y-0.5 transition-all text-sm md:text-base">
                    Belanja Sekarang <i class="fa-solid fa-arrow-right ml-2"></i>
                </a>
            </div>

            <div class="z-10 md:w-1/2 flex justify-center mt-6 md:mt-0 relative">
                <img src="http://localhost/pbl/poto/galon.png" class="w-56 md:w-96 object-contain drop-shadow-2xl">
            </div>
            <div class="absolute top-0 right-0 w-64 h-64 bg-white/40 rounded-full blur-3xl -mr-20 -mt-20"></div>
            <div class="absolute bottom-0 left-0 w-40 h-40 bg-support/30 rounded-full blur-2xl -ml-10 -mb-10"></div>
        </div>
        <!-- Produk + Promo -->
        <div class="flex flex-col lg:flex-row gap-6 mb-8">
            <div class="lg:w-3/4">
                <div class="flex items-center justify-between mb-4">
                    <h2 class="text-xl font-bold text-primary">Produk Unggulan</h2>
                    <div class="flex space-x-2">
                        <button class="w-8 h-8 rounded-full border border-gray-200 bg-white flex items-center justify-center hover:bg-gray-50 transition-colors">
                            <i class="fa-solid fa-chevron-left text-xs"></i>
                        </button>
                        <button class="w-8 h-8 rounded-full border border-gray-200 bg-white flex items-center justify-center hover:bg-gray-50 transition-colors">
                            <i class="fa-solid fa-chevron-right text-xs"></i>
                        </button>
                    </div>
                </div>

                <div class="grid grid-cols-2 md:grid-cols-4 gap-4">


                    <div class="bg-white p-3 rounded-2xl shadow-soft hover:shadow-pop transition-all relative group">
                        <div class="h-32 bg-gray-50 rounded-lg mb-3 flex items-center justify-center overflow-hidden">
                            <i class="fa-solid fa-droplet text-secondary text-4xl opacity-50 group-hover:scale-110 transition-transform"></i>
                        </div>
                        <h3 class="font-semibold text-sm text-primary mb-1 truncate">Galon Le Mineral 20L</h3>
                        <p class="text-xs text-accent mb-2">Wijaya Depot</p>
                        <div class="flex items-center justify-between">
                            <span class="font-bold text-primary">Rp 19.000</span>
                            <button class="w-7 h-7 rounded-full bg-secondary text-white flex items-center justify-center text-xs hover:bg-primary transition-colors">
                                <i class="fa-solid fa-plus"></i>
                            </button>
                        </div>
                    </div>

    </main>

    <?php include '../layout/footer.php'; ?>

</body>
</html>