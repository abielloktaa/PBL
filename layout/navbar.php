<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Ambil data session
$nav_username = isset($_SESSION['username']) ? $_SESSION['username'] : 'User';
$n    = isset($_SESSION['id_role']) ? $_SESSION['id_role'] : '';

$base = "/pbl/"; 
?>

<nav class="bg-primary shadow-lg sticky top-0 z-50 w-full">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between items-center h-16 md:h-20">

            <!-- Logo -->
            <a href="<?= $base ?>user/dashboard.php" class="flex items-center cursor-pointer">
                <span class="text-xl md:text-2xl font-bold text-white tracking-tight">
                    Galon<span class="text-support">ku</span>
                </span>
            </a>

            <!-- ========================================== -->
            <!-- 1. KELOMPOK MENU DESKTOP                   -->
            <!-- ========================================== -->
            <div class="hidden md:flex items-center space-x-6 lg:space-x-8">
                
                <?php if ($n == "1"): ?>
                    <!-- MENU KONSUMEN -->
                    <a href="<?= $base ?>user/dashboard.php" class="text-gray-200 hover:text-support font-medium transition text-sm lg:text-base">Dashboard</a>
                    <a href="<?= $base ?>user/katalog.php" class="text-gray-200 hover:text-support font-medium transition text-sm lg:text-base">Katalog</a>
                    <a href="<?= $base ?>user/pesanan.php" class="text-gray-200 hover:text-support font-medium transition text-sm lg:text-base">Pesanan</a>
                    <a href="<?= $base ?>user/riwayat.php" class="text-gray-200 hover:text-support font-medium transition text-sm lg:text-base">Riwayat</a>

                <?php elseif ($n == "2"): ?>
                    <!-- MENU AGENT -->
                    <a href="<?= $base ?>agent/dashboard.php" class="text-gray-200 hover:text-support font-medium transition text-sm lg:text-base">Dashboard</a>
                    <a href="<?= $base ?>agent/produk.php" class="text-gray-200 hover:text-support font-medium transition text-sm lg:text-base">Kelola Produk</a>
                    <a href="<?= $base ?>agent/pesanan_masuk.php" class="text-gray-200 hover:text-support font-medium transition text-sm lg:text-base">Pesanan Masuk</a>

                <?php elseif ($n == "3"): ?>
                    <!-- MENU ADMIN -->
                    <a href="<?= $base ?>admin/dashboard.php" class="text-gray-200 hover:text-support font-medium transition text-sm lg:text-base">Dashboard</a>
                    <a href="<?= $base ?>admin/users.php" class="text-gray-200 hover:text-support font-medium transition text-sm lg:text-base">Data User</a>
                <?php endif; ?>

            </div>

            <!-- Right Side -->
            <div class="flex items-center gap-2 md:gap-3">

                <!-- Cart (Hanya untuk Konsumen) -->
                <?php if ($n == "1"): ?>
                    <a href="<?= $base ?>user/keranjang.php" class="relative w-9 h-9 md:w-10 md:h-10 rounded-full bg-secondary hover:bg-support flex items-center justify-center text-white transition">
                        <i class="fa-solid fa-cart-shopping text-xs md:text-sm"></i>
                    </a>
                <?php endif; ?>

                <!-- User Dropdown (desktop only) -->
                <div class="relative hidden md:block">
                    <button id="user-menu-btn" class="flex items-center gap-2 bg-secondary hover:bg-support transition rounded-full pl-1 pr-3 py-1 cursor-pointer">
                        <div class="w-8 h-8 rounded-full bg-support text-primary flex items-center justify-center font-bold text-sm">
                            <i class="fa-solid fa-user"></i>
                        </div>
                        <span class="text-white text-sm font-medium capitalize"><?= htmlspecialchars($nav_username); ?></span>
                        <i id="user-chevron" class="fa-solid fa-chevron-down text-white text-xs transition-transform duration-300"></i>
                    </button>

                    <div id="user-dropdown" class="hidden absolute right-0 mt-2 w-56 bg-white rounded-2xl shadow-pop border border-gray-100 overflow-hidden z-50">
                        
                        <div class="px-4 py-3 bg-gradient-to-br from-primary to-secondary text-white">
                            <p class="font-bold text-sm capitalize"><?= htmlspecialchars($nav_username); ?></p>
                            <p class="text-xs text-white/70 truncate"><?= htmlspecialchars($nav_username); ?>@galonku.com</p>
                        </div>

                        <div class="py-2">
                            <?php if ($n == "1"): ?>
                                <a href="<?= $base ?>user/profile.php" class="flex items-center gap-3 px-4 py-2.5 text-sm text-primary hover:bg-surface transition"><i class="fa-solid fa-user w-4 text-secondary"></i> Profil Saya</a>
                                <a href="<?= $base ?>user/pesanan.php" class="flex items-center gap-3 px-4 py-2.5 text-sm text-primary hover:bg-surface transition"><i class="fa-solid fa-box w-4 text-secondary"></i> Pesanan Saya</a>
                                <a href="<?= $base ?>user/riwayat.php" class="flex items-center gap-3 px-4 py-2.5 text-sm text-primary hover:bg-surface transition"><i class="fa-solid fa-clock-rotate-left w-4 text-secondary"></i> Riwayat</a>

                            <?php elseif ($n == "2"): ?>
                                <a href="<?= $base ?>agent/profile.php" class="flex items-center gap-3 px-4 py-2.5 text-sm text-primary hover:bg-surface transition"><i class="fa-solid fa-user w-4 text-secondary"></i> Profil Depot</a>
                                <a href="<?= $base ?>agent/produk.php" class="flex items-center gap-3 px-4 py-2.5 text-sm text-primary hover:bg-surface transition"><i class="fa-solid fa-box w-4 text-secondary"></i> Produk Saya</a>

                            <?php elseif ($n == "3"): ?>
                                <a href="<?= $base ?>admin/profile.php" class="flex items-center gap-3 px-4 py-2.5 text-sm text-primary hover:bg-surface transition"><i class="fa-solid fa-user w-4 text-secondary"></i> Profil Admin</a>
                                <a href="<?= $base ?>admin/pengaturan.php" class="flex items-center gap-3 px-4 py-2.5 text-sm text-primary hover:bg-surface transition"><i class="fa-solid fa-gear w-4 text-secondary"></i> Pengaturan Sistem</a>
                            <?php endif; ?>
                        </div>

                        <div class="border-t border-gray-100 py-2">
                            <!-- Link Logout Otomatis Menyesuaikan Role -->
                            <a href="<?= $base ?><?= ($n == '2') ? 'agent' : (($n == '3') ? 'admin' : 'user') ?>/logout.php" onclick="return confirm('Yakin ingin logout?')" 
                               class="flex items-center gap-3 px-4 py-2.5 text-sm text-red-500 hover:bg-red-50 transition font-semibold">
                                <i class="fa-solid fa-right-from-bracket w-4"></i> Logout
                            </a>
                        </div>
                    </div>
                </div>

                <!-- Hamburger (mobile only) -->
                <button id="mobile-menu-btn" class="md:hidden text-white hover:text-support p-1">
                    <svg id="icon-menu" class="h-6 w-6 transition-transform duration-300" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                    </svg>
                </button>
            </div>
        </div>
    </div>

    <!-- ========================================== -->
    <!-- 2. KELOMPOK MENU MOBILE                    -->
    <!-- ========================================== -->
    <div id="mobile-menu" class="hidden md:hidden bg-secondary border-t border-white/10">
        <div class="px-4 pt-3 pb-4 space-y-1">

            <!-- User Info -->
            <div class="flex items-center gap-3 bg-primary/40 rounded-xl p-3 mb-3">
                <div class="w-10 h-10 rounded-full bg-support text-primary flex items-center justify-center font-bold">
                    <i class="fa-solid fa-user"></i>
                </div>
                <div class="min-w-0">
                    <p class="text-white font-semibold text-sm truncate capitalize"><?= htmlspecialchars($nav_username); ?></p>
                    <?php if ($n == "1"): ?>
                        <p class="text-white/60 text-xs">Konsumen</p>
                    <?php elseif ($n == "2"): ?>
                        <p class="text-white/60 text-xs">Agent Depot</p>
                    <?php else: ?>
                        <p class="text-white/60 text-xs">Administrator</p>
                    <?php endif; ?>
                </div>
            </div>

            <!-- List Menu Mobile -->
            <?php if ($n == "1"): ?>
                <!-- MOBILE KONSUMEN -->
                <a href="<?= $base ?>user/dashboard.php" class="block px-3 py-2.5 rounded-lg text-white font-medium hover:bg-primary hover:text-support transition">Dashboard</a>
                <a href="<?= $base ?>user/katalog.php" class="block px-3 py-2.5 rounded-lg text-white font-medium hover:bg-primary hover:text-support transition">Katalog</a>
                <a href="<?= $base ?>user/pesanan.php" class="block px-3 py-2.5 rounded-lg text-white font-medium hover:bg-primary hover:text-support transition">Pesanan</a>
                <a href="<?= $base ?>user/riwayat.php" class="block px-3 py-2.5 rounded-lg text-white font-medium hover:bg-primary hover:text-support transition">Riwayat</a>
                <a href="<?= $base ?>user/profile.php" class="block px-3 py-2.5 rounded-lg text-white font-medium hover:bg-primary hover:text-support transition"><i class="fa-solid fa-user mr-2"></i> Profil Saya</a>

            <?php elseif ($n == "2"): ?>
                <!-- MOBILE AGENT -->
                <a href="<?= $base ?>agent/dashboard.php" class="block px-3 py-2.5 rounded-lg text-white font-medium hover:bg-primary hover:text-support transition">Dashboard</a>
                <a href="<?= $base ?>agent/produk.php" class="block px-3 py-2.5 rounded-lg text-white font-medium hover:bg-primary hover:text-support transition">Kelola Produk</a>
                <a href="<?= $base ?>agent/pesanan_masuk.php" class="block px-3 py-2.5 rounded-lg text-white font-medium hover:bg-primary hover:text-support transition">Pesanan Masuk</a>
                <a href="<?= $base ?>agent/profile.php" class="block px-3 py-2.5 rounded-lg text-white font-medium hover:bg-primary hover:text-support transition"><i class="fa-solid fa-user mr-2"></i> Profil Depot</a>

            <?php elseif ($n == "3"): ?>
                <!-- MOBILE ADMIN -->
                <a href="<?= $base ?>admin/dashboard.php" class="block px-3 py-2.5 rounded-lg text-white font-medium hover:bg-primary hover:text-support transition">Dashboard</a>
                <a href="<?= $base ?>admin/users.php" class="block px-3 py-2.5 rounded-lg text-white font-medium hover:bg-primary hover:text-support transition">Data User</a>
               
                <a href="<?= $base ?>admin/profile.php" class="block px-3 py-2.5 rounded-lg text-white font-medium hover:bg-primary hover:text-support transition"><i class="fa-solid fa-user mr-2"></i> Profil Admin</a>
            <?php endif; ?>

            <div class="border-t border-white/20 my-2 pt-2"></div>

            <a href="<?= $base ?><?= ($n == '2') ? 'agent' : (($n == '3') ? 'admin' : 'user') ?>/logout.php" onclick="return confirm('Yakin ingin logout?')" 
               class="block text-center bg-red-500 text-white px-4 py-3 rounded-lg font-bold hover:bg-red-600 transition">
                <i class="fa-solid fa-right-from-bracket mr-2"></i> Logout
            </a>
        </div>
    </div>
</nav>

<!-- ================= JAVASCRIPT ================= -->
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const btn = document.getElementById('mobile-menu-btn');
        const menu = document.getElementById('mobile-menu');
        const iconMenu = document.getElementById('icon-menu');

        if (btn) {
            btn.addEventListener('click', () => {
                menu.classList.toggle('hidden');
                iconMenu.classList.toggle('rotate-90');
            });

            menu.querySelectorAll('a').forEach(link => {
                link.addEventListener('click', () => {
                    menu.classList.add('hidden');
                    iconMenu.classList.remove('rotate-90');
                });
            });
        }

        const userBtn = document.getElementById('user-menu-btn');
        const userDropdown = document.getElementById('user-dropdown');
        const userChevron = document.getElementById('user-chevron');

        if (userBtn) {
            userBtn.addEventListener('click', (e) => {
                e.stopPropagation();
                userDropdown.classList.toggle('hidden');
                userChevron.classList.toggle('rotate-180');
            });

            document.addEventListener('click', (e) => {
                if (!userBtn.contains(e.target) && !userDropdown.contains(e.target)) {
                    userDropdown.classList.add('hidden');
                    userChevron.classList.remove('rotate-180');
                }
            });

            document.addEventListener('keydown', (e) => {
                if (e.key === 'Escape') {
                    userDropdown.classList.add('hidden');
                    userChevron.classList.remove('rotate-180');
                }
            });
        }
    });
</script>