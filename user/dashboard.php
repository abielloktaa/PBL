<?php
session_start();
include __DIR__ . '/../koneksi.php';

if (!isset($_SESSION['username']) || $_SESSION['id_role'] != "1") {
    header("location:../login.php?pesan=belum_login");
    exit();
}

$username = $_SESSION['username'];
$id_user  = $_SESSION['id_user'];

// ==========================================
// LOGIKA PENGECEKAN REMINDER (HARI INI / BESOK)
// ==========================================
$today = date('Y-m-d');
$besok = date('Y-m-d', strtotime('+1 day'));

$query_rem = mysqli_query($koneksi, "SELECT * FROM reminder WHERE id_user = '$id_user' AND (date = '$today' OR date = '$besok') LIMIT 1");
$reminder = mysqli_fetch_assoc($query_rem);

// Cegah popup reminder muncul jika baru login
if (isset($_GET['pesan']) && $_GET['pesan'] == 'login_berhasil') {
    $reminder = false; 
}
?>

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

        <div class="mb-6">
            <h1 class="text-2xl md:text-3xl font-extrabold text-primary mb-1">Dashboard</h1>
            <p class="text-sm text-gray-500">Halo <span class="font-semibold capitalize"><?= htmlspecialchars($username); ?></span>, temukan kebutuhan air dan gasmu di sini.</p>
        </div>
   
        <div class="bg-gradient-to-br from-[#EBF4FF] to-[#D9E8FF] rounded-3xl p-6 md:p-8 mb-8 relative overflow-hidden flex flex-col md:flex-row items-center justify-between border-2 border-blue-200 shadow-sm">
            <div class="z-10 md:w-1/2">
                <h1 class="text-3xl md:text-5xl font-extrabold text-primary leading-tight mb-4">
                    Belanja Air & Gas<br>Lebih Mudah
                </h1>
                <a href="katalog.php" class="inline-block bg-primary text-white px-6 py-3 rounded-full font-semibold shadow-md hover:bg-secondary hover:-translate-y-0.5 transition-all text-sm md:text-base">
                    Belanja Sekarang <i class="fa-solid fa-arrow-right ml-2"></i>
                </a>
            </div>

            <div class="z-10 md:w-1/2 flex justify-center mt-6 md:mt-0 relative">
                <img src="http://localhost/pbl/poto/galon.png" class="w-56 md:w-96 object-contain drop-shadow-2xl" alt="Galon">
            </div>
            <div class="absolute top-0 right-0 w-64 h-64 bg-white/40 rounded-full blur-3xl -mr-20 -mt-20"></div>
            <div class="absolute bottom-0 left-0 w-40 h-40 bg-support/30 rounded-full blur-2xl -ml-10 -mb-10"></div>
        </div>
        
        <div class="flex flex-col lg:flex-row gap-6 mb-8">
            <div class="lg:w-full">
                
                <!-- HEADER CAROUSEL & TOMBOL PANAH -->
                <div class="flex items-center justify-between mb-4">
                    <h2 class="text-xl font-bold text-primary">Produk Unggulan</h2>
                    <div class="flex space-x-2">
                        <button onclick="scrollKatalog(-1)" class="w-8 h-8 rounded-full border-2 border-gray-300 bg-white flex items-center justify-center hover:bg-gray-50 transition-colors text-gray-500 shadow-sm">
                            <i class="fa-solid fa-chevron-left text-xs"></i>
                        </button>
                        <button onclick="scrollKatalog(1)" class="w-8 h-8 rounded-full border-2 border-gray-300 bg-white flex items-center justify-center hover:bg-gray-50 transition-colors text-gray-500 shadow-sm">
                            <i class="fa-solid fa-chevron-right text-xs"></i>
                        </button>
                    </div>
                </div>

                <!-- CONTAINER CAROUSEL (Bisa Digeser) -->
                <div id="carouselContainer" class="flex gap-4 overflow-x-auto scroll-smooth scrollbar-hide px-1 pb-4">
                    <?php
                    $query = "SELECT product.*, users.username AS agent_name 
                              FROM product 
                              JOIN users ON product.id_agent = users.id_user"; 
                    
                    $data = mysqli_query($koneksi, $query);
                    while ($row = mysqli_fetch_array($data)) {
                    ?>
                    <!-- CARD PRODUK -->
                    <a href="detail_produk.php?id=<?= $row['id_product']; ?>" class="min-w-[220px] md:min-w-[250px] w-[220px] md:w-[250px] flex-shrink-0 flex flex-col bg-white p-3 rounded-2xl shadow-sm hover:shadow-md hover:border-primary/50 transition-all group border-2 border-gray-200 relative">
                        
                        <div class="h-32 bg-gray-50 rounded-xl mb-3 flex items-center justify-center overflow-hidden border border-gray-100">
                            <!-- PERBAIKAN: Mengarah ke folder ../poto/ -->
                            <?php if (!empty($row['img']) && is_string($row['img']) && strpos($row['img'], 'dummy') === false) { ?>
                                <img src="../poto/<?= $row['img']; ?>" class="w-full h-full object-cover group-hover:scale-110 transition-transform" alt="<?= $row['name_product']; ?>">
                            <?php } else { ?>
                                <i class="fa-solid fa-droplet text-secondary text-4xl opacity-50 group-hover:scale-110 transition-transform"></i>
                            <?php } ?>
                        </div>
                        
                        <h3 class="font-bold text-sm text-primary mb-1 truncate" title="<?= $row['name_product']; ?>">
                            <?= htmlspecialchars($row['name_product']); ?>
                        </h3>
                        
                        <p class="text-[11px] text-gray-500 mb-2 truncate">
                            <i class="fa-solid fa-store mr-1 text-secondary"></i> <?= htmlspecialchars($row['agent_name'] ?? 'GalonKu'); ?>
                        </p>
                        
                        <div class="flex items-center justify-between mt-auto pt-2 border-t border-gray-100">
                            <div>
                                <p class="text-[10px] text-gray-700">Stok: <?= $row['stock']; ?></p>
                                <span class="font-extrabold text-primary text-sm">Rp <?= number_format($row['price'], 0, ',', '.'); ?></span>
                            </div>
                            <span class="w-8 h-8 rounded-full bg-secondary text-white flex items-center justify-center text-xs group-hover:bg-primary transition-colors shadow-sm">
                                <i class="fa-solid fa-plus"></i>
                            </span>
                        </div>
                    </a>
                    <?php } ?>
                </div> 
                
            </div> 
        </div> 
    </main>

    <!-- ================= POPUP LOGIN BERHASIL ================= -->
    <?php if (isset($_GET['pesan']) && $_GET['pesan'] == 'login_berhasil'): ?>
    <div id="loginModal" class="fixed inset-0 z-[100] flex items-center justify-center bg-black/60 backdrop-blur-sm p-4 transition-opacity duration-300">
        <div class="bg-white rounded-[2rem] p-8 max-w-sm w-full text-center relative overflow-hidden shadow-2xl">
            <div class="absolute top-0 left-0 w-full h-24 bg-gradient-to-br from-[#EBF4FF] to-[#D9E8FF]"></div>
            
            <div class="relative z-10 pt-4">
                <div class="w-20 h-20 mx-auto bg-white rounded-full shadow-md flex items-center justify-center mb-4 border-4 border-white">
                    <i class="fa-solid fa-hand-peace text-4xl text-secondary animate-bounce"></i>
                </div>
                
                <h2 class="text-2xl font-extrabold text-primary mb-2">Halo, <?= htmlspecialchars($username); ?>!</h2>
                <p class="text-sm text-gray-500 mb-6">Selamat datang kembali di GalonKu. Semoga harimu menyenangkan!</p>
                
                <button onclick="document.getElementById('loginModal').style.display='none'" class="w-full bg-primary text-white py-3 rounded-xl font-bold hover:bg-secondary transition shadow-md">
                    Mulai Belanja
                </button>
            </div>
        </div>
    </div>
    <?php endif; ?>

    <!-- ================= POPUP REMINDER ================= -->
    <?php if ($reminder): ?>
    <div id="reminderModal" class="fixed inset-0 z-[100] flex items-center justify-center bg-black/60 backdrop-blur-sm p-4 transition-opacity duration-300">
        <div class="bg-white rounded-[2rem] p-8 max-w-sm w-full text-center relative overflow-hidden shadow-2xl transform transition-transform duration-300">
            
            <div class="absolute top-0 left-0 w-full h-32 bg-gradient-to-br from-[#EBF4FF] to-[#D9E8FF]"></div>
            
            <div class="relative z-10 pt-4">
                <div class="w-24 h-24 mx-auto bg-white rounded-full shadow-lg flex items-center justify-center mb-5 border-4 border-white">
                    <i class="fa-solid fa-bell text-5xl text-secondary animate-bounce"></i>
                </div>
                
                <h2 class="text-2xl font-extrabold text-primary mb-2">Waktunya Belanja!</h2>
                <p class="text-sm text-gray-500 mb-8 leading-relaxed">
                    Halo <span class="font-bold text-primary"><?= htmlspecialchars($username); ?></span>, sepertinya persediaan galon atau gasmu sudah menipis. Yuk, pesan sekarang agar tidak kehabisan!
                </p>
                
                <div class="flex flex-col gap-3">
                    <a href="katalog.php" class="w-full bg-primary text-white py-3.5 rounded-2xl font-bold hover:bg-secondary transition-all shadow-md hover:shadow-lg">
                        <i class="fa-solid fa-cart-shopping mr-2"></i> Pesan Sekarang
                    </a>
                    <button onclick="document.getElementById('reminderModal').style.display='none'" class="w-full bg-gray-100 text-gray-500 py-3.5 rounded-2xl font-semibold hover:bg-gray-200 transition-all">
                        Nanti Saja
                    </button>
                </div>
            </div>
        </div>
    </div>
    <?php endif; ?>

    <!-- ================= JAVASCRIPT UNTUK CAROUSEL ================= -->
    <script>
        function scrollKatalog(direction) {
            const container = document.getElementById('carouselContainer');
            // Jarak geser (lebar card 250px + gap 16px = sekitar 266px)
            const scrollAmount = 266; 
            
            if (direction === 1) {
                container.scrollLeft += scrollAmount;
            } else {
                container.scrollLeft -= scrollAmount;
            }
        }
    </script>

    <?php include '../layout/footer.php'; ?>
</body>
</html>