<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

$nav_username = isset($_SESSION['username']) ? $_SESSION['username'] : 'User';
$n    = isset($_SESSION['id_role']) ? $_SESSION['id_role'] : '';

$base = "/pbl/"; 
?>

<style>
    /* Tambahan CSS untuk animasi super smooth */
    .nav-expand {
        max-width: 80rem; /* max-w-7xl */
        padding-top: 0.625rem;
        padding-bottom: 0.625rem;
        padding-left: 1.25rem;
        padding-right: 1.25rem;
    }
    .nav-shrink {
        max-width: 18rem; /* Ukuran pas untuk ikon saja */
        padding-top: 0.375rem;
        padding-bottom: 0.375rem;
        padding-left: 1rem;
        padding-right: 1rem;
    }
    .menu-fade-out {
        opacity: 0;
        max-width: 0;
        padding: 0;
        margin: 0;
        border-width: 0;
        overflow: hidden;
        pointer-events: none;
    }
    .menu-fade-in {
        opacity: 1;
        max-width: 600px; /* Lebar maksimal menu */
    }
    .text-fade-out {
        opacity: 0;
        max-width: 0;
        margin-left: 0 !important;
        overflow: hidden;
        pointer-events: none;
    }
    .text-fade-in {
        opacity: 1;
        max-width: 150px;
    }
</style>

<!-- ================= NAVBAR FLOATING PILL (SMOOTH SCROLL) ================= -->
<nav id="mainNavbar" class="fixed top-4 left-0 right-0 z-50 px-4">
    <!-- Container utama dengan transisi cubic-bezier agar sangat halus -->
    <div id="navbarContainer" class="nav-expand mx-auto bg-[#0A3D7A]/95 backdrop-blur-md border border-white/10 shadow-2xl rounded-full flex justify-between items-center transition-all duration-700 ease-[cubic-bezier(0.25,1,0.5,1)]">
        
        <!-- Logo -->
        <a href="<?= $base ?>user/dashboard.php" class="flex items-center cursor-pointer pl-2 flex-shrink-0">
            <span class="text-xl md:text-2xl font-extrabold text-white tracking-tight">
                Galon<span class="text-support">ku</span>
            </span>
        </a>

        <!-- ========================================== -->
        <!-- 1. KELOMPOK MENU DESKTOP (Tengah)          -->
        <!-- ========================================== -->
        <div id="desktopMenu" class="menu-fade-in hidden md:flex items-center space-x-1 bg-black/20 rounded-full p-1 border border-white/5 transition-all duration-700 ease-[cubic-bezier(0.25,1,0.5,1)]">
            
            <?php if ($n == "1"): ?>
                <a href="<?= $base ?>user/dashboard.php" class="text-gray-300 hover:text-white hover:bg-white/10 px-4 py-2 rounded-full font-medium transition text-sm whitespace-nowrap">Dashboard</a>
                <a href="<?= $base ?>user/katalog.php" class="text-gray-300 hover:text-white hover:bg-white/10 px-4 py-2 rounded-full font-medium transition text-sm whitespace-nowrap">Katalog</a>
                <a href="<?= $base ?>user/pesanan.php" class="text-gray-300 hover:text-white hover:bg-white/10 px-4 py-2 rounded-full font-medium transition text-sm whitespace-nowrap">Pesanan</a>
                <a href="<?= $base ?>user/riwayat.php" class="text-gray-300 hover:text-white hover:bg-white/10 px-4 py-2 rounded-full font-medium transition text-sm whitespace-nowrap">Riwayat</a>

            <?php elseif ($n == "2"): ?>
                <a href="<?= $base ?>agent/dashboard.php" class="text-gray-300 hover:text-white hover:bg-white/10 px-4 py-2 rounded-full font-medium transition text-sm whitespace-nowrap">Dashboard</a>
                <a href="<?= $base ?>agent/produk.php" class="text-gray-300 hover:text-white hover:bg-white/10 px-4 py-2 rounded-full font-medium transition text-sm whitespace-nowrap">Produk</a>
                <a href="<?= $base ?>agent/pesanan.php" class="text-gray-300 hover:text-white hover:bg-white/10 px-4 py-2 rounded-full font-medium transition text-sm whitespace-nowrap">Pesanan</a>
                <a href="<?= $base ?>agent/riwayat_pesanan.php" class="text-gray-300 hover:text-white hover:bg-white/10 px-4 py-2 rounded-full font-medium transition text-sm whitespace-nowrap">Riwayat</a>

            <?php elseif ($n == "3"): ?>
                <a href="<?= $base ?>admin/dashboard.php" class="text-gray-300 hover:text-white hover:bg-white/10 px-4 py-2 rounded-full font-medium transition text-sm whitespace-nowrap">Dashboard</a>
                <a href="<?= $base ?>admin/users.php" class="text-gray-300 hover:text-white hover:bg-white/10 px-4 py-2 rounded-full font-medium transition text-sm whitespace-nowrap">Data User</a>
            <?php endif; ?>

        </div>

        <!-- ========================================== -->
        <!-- 2. RIGHT SIDE (Cart & Profile)             -->
        <!-- ========================================== -->
        <div class="flex items-center gap-2 md:gap-3 pr-2 flex-shrink-0">

            <!-- Cart -->
            <?php if ($n == "1"): ?>
                <a href="<?= $base ?>user/keranjang.php" class="relative w-9 h-9 md:w-10 md:h-10 rounded-full bg-secondary hover:bg-support flex items-center justify-center text-white transition shadow-lg shadow-secondary/20">
                    <i class="fa-solid fa-cart-shopping text-sm"></i>
                </a>
            <?php endif; ?>

            <!-- User Dropdown -->
            <div class="relative hidden md:block">
                <button id="user-menu-btn" class="flex items-center gap-2 bg-white/10 hover:bg-white/20 border border-white/10 transition rounded-full pl-1.5 pr-3 py-1.5 cursor-pointer">
                    <div class="w-7 h-7 rounded-full bg-support text-primary flex items-center justify-center font-bold text-xs shadow-sm flex-shrink-0">
                        <i class="fa-solid fa-user"></i>
                    </div>
                    <span id="userText" class="text-fade-in text-white text-sm font-semibold capitalize transition-all duration-700 ease-[cubic-bezier(0.25,1,0.5,1)] whitespace-nowrap overflow-hidden">
                        <?= htmlspecialchars($nav_username); ?>
                    </span>
                    <i id="user-chevron" class="fa-solid fa-chevron-down text-white/70 text-[10px] transition-transform duration-300"></i>
                </button>

                <!-- Dropdown Menu -->
                <div id="user-dropdown" class="hidden absolute right-0 mt-3 w-60 bg-white rounded-2xl shadow-2xl border border-gray-100 overflow-hidden z-50 transform origin-top-right transition-all">
                    
                    <div class="px-5 py-4 bg-gradient-to-br from-[#0A3D7A] to-[#3770BF] text-white">
                        <p class="font-bold text-base capitalize"><?= htmlspecialchars($nav_username); ?></p>
                        <p class="text-xs text-white/70 truncate mt-0.5"><?= htmlspecialchars($nav_username); ?>@galonku.com</p>
                    </div>

                    <div class="py-2">
                        <?php if ($n == "1"): ?>
                            <a href="<?= $base ?>user/profile.php" class="flex items-center gap-3 px-5 py-2.5 text-sm text-gray-700 hover:bg-blue-50 hover:text-primary transition font-medium"><i class="fa-solid fa-user w-4 text-secondary"></i> Profil Saya</a>
                            <a href="<?= $base ?>user/reminder.php" class="flex items-center gap-3 px-5 py-2.5 text-sm text-gray-700 hover:bg-blue-50 hover:text-primary transition font-medium"><i class="fa-solid fa-clock w-4 text-secondary"></i> Pengingat</a>
                        <?php elseif ($n == "2"): ?>
                            <a href="<?= $base ?>agent/profile.php" class="flex items-center gap-3 px-5 py-2.5 text-sm text-gray-700 hover:bg-blue-50 hover:text-primary transition font-medium"><i class="fa-solid fa-user w-4 text-secondary"></i> Profil Depot</a>
                            <a href="<?= $base ?>agent/produk.php" class="flex items-center gap-3 px-5 py-2.5 text-sm text-gray-700 hover:bg-blue-50 hover:text-primary transition font-medium"><i class="fa-solid fa-box w-4 text-secondary"></i> Produk Saya</a>
                        <?php elseif ($n == "3"): ?>
                            <a href="<?= $base ?>admin/profile.php" class="flex items-center gap-3 px-5 py-2.5 text-sm text-gray-700 hover:bg-blue-50 hover:text-primary transition font-medium"><i class="fa-solid fa-user w-4 text-secondary"></i> Profil Admin</a>
                        <?php endif; ?>
                    </div>

                    <div class="border-t border-gray-100 py-2">
                        <button onclick="openLogoutModal(event)" class="w-full text-left flex items-center gap-3 px-5 py-2.5 text-sm text-red-500 hover:bg-red-50 transition font-bold">
                            <i class="fa-solid fa-right-from-bracket w-4"></i> Logout
                        </button>
                    </div>
                </div>
            </div>

            <!-- Hamburger (mobile only) -->
            <button id="mobile-menu-btn" class="md:hidden w-9 h-9 rounded-full bg-white/10 border border-white/10 flex items-center justify-center text-white hover:bg-white/20 transition">
                <svg id="icon-menu" class="h-5 w-5 transition-transform duration-300" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                </svg>
            </button>
        </div>
    </div>

    <!-- ========================================== -->
    <!-- 3. KELOMPOK MENU MOBILE (Floating Card)    -->
    <!-- ========================================== -->
    <div id="mobile-menu" class="hidden md:hidden mt-2 max-w-sm mx-auto">
        <div class="bg-[#0A3D7A]/95 backdrop-blur-md border border-white/10 shadow-2xl rounded-3xl px-4 pt-4 pb-6 space-y-1">
            
            <?php if ($n == "1"): ?>
                <a href="<?= $base ?>user/dashboard.php" class="block px-4 py-3 rounded-xl text-white font-medium hover:bg-white/10 transition">Dashboard</a>
                <a href="<?= $base ?>user/katalog.php" class="block px-4 py-3 rounded-xl text-white font-medium hover:bg-white/10 transition">Katalog</a>
                <a href="<?= $base ?>user/pesanan.php" class="block px-4 py-3 rounded-xl text-white font-medium hover:bg-white/10 transition">Pesanan</a>
                <a href="<?= $base ?>user/riwayat.php" class="block px-4 py-3 rounded-xl text-white font-medium hover:bg-white/10 transition">Riwayat</a>
                <a href="<?= $base ?>user/profile.php" class="block px-4 py-3 rounded-xl text-white font-medium hover:bg-white/10 transition"><i class="fa-solid fa-user mr-2"></i> Profil Saya</a>
            <?php elseif ($n == "2"): ?>
                <a href="<?= $base ?>agent/dashboard.php" class="block px-4 py-3 rounded-xl text-white font-medium hover:bg-white/10 transition">Dashboard</a>
                <a href="<?= $base ?>agent/produk.php" class="block px-4 py-3 rounded-xl text-white font-medium hover:bg-white/10 transition">Kelola Produk</a>
                <a href="<?= $base ?>agent/pesanan.php" class="block px-4 py-3 rounded-xl text-white font-medium hover:bg-white/10 transition">Pesanan Masuk</a>
                <a href="<?= $base ?>agent/riwayat_pesanan.php" class="block px-4 py-3 rounded-xl text-white font-medium hover:bg-white/10 transition">Riwayat</a>
                <a href="<?= $base ?>agent/profile.php" class="block px-4 py-3 rounded-xl text-white font-medium hover:bg-white/10 transition"><i class="fa-solid fa-user mr-2"></i> Profil Depot</a>
            <?php elseif ($n == "3"): ?>
                <a href="<?= $base ?>admin/dashboard.php" class="block px-4 py-3 rounded-xl text-white font-medium hover:bg-white/10 transition">Dashboard</a>
                <a href="<?= $base ?>admin/users.php" class="block px-4 py-3 rounded-xl text-white font-medium hover:bg-white/10 transition">Data User</a>
                <a href="<?= $base ?>admin/profile.php" class="block px-4 py-3 rounded-xl text-white font-medium hover:bg-white/10 transition"><i class="fa-solid fa-user mr-2"></i> Profil Admin</a>
            <?php endif; ?>

            <div class="border-t border-white/10 my-3 pt-3"></div>
            <button onclick="openLogoutModal(event)" class="block w-full text-center bg-red-500/90 text-white px-4 py-3 rounded-xl font-bold hover:bg-red-600 transition shadow-lg shadow-red-500/20">
                <i class="fa-solid fa-right-from-bracket mr-2"></i> Logout
            </button>
        </div>
    </div>
</nav>

<!-- Spacer -->
<div class="h-20 md:h-24"></div>

<!-- POPUP MODAL LOGOUT -->
<div id="logoutModal" class="fixed inset-0 z-[100] hidden items-center justify-center bg-black/60 backdrop-blur-sm p-4 transition-opacity duration-300">
    <div class="bg-white rounded-[2rem] p-8 max-w-sm w-full text-center relative overflow-hidden shadow-2xl">
        <div class="w-20 h-20 mx-auto bg-red-50 rounded-full flex items-center justify-center mb-4 border-4 border-white shadow-sm">
            <i class="fa-solid fa-right-from-bracket text-4xl text-red-500"></i>
        </div>
        <h2 class="text-xl font-extrabold text-primary mb-2">Keluar Akun?</h2>
        <p class="text-sm text-gray-500 mb-6">Apakah Anda yakin ingin keluar dari aplikasi GalonKu?</p>
        <div class="flex gap-3">
            <button onclick="closeLogoutModal()" class="flex-1 bg-gray-100 text-gray-600 py-3 rounded-xl font-bold hover:bg-gray-200 transition">Batal</button>
            <a href="<?= $base ?><?= ($n == '2') ? 'agent' : (($n == '3') ? 'admin' : 'user') ?>/logout.php" class="flex-1 bg-red-500 text-white py-3 rounded-xl font-bold hover:bg-red-600 transition shadow-md">Ya, Keluar</a>
        </div>
    </div>
</div>

<!-- ================= JAVASCRIPT ================= -->
<script>
    let lastScrollTop = 0;
    const navbarContainer = document.getElementById('navbarContainer');
    const desktopMenu = document.getElementById('desktopMenu');
    const userText = document.getElementById('userText');

    window.addEventListener('scroll', function() {
        let scrollTop = window.pageYOffset || document.documentElement.scrollTop;

        // Scroll ke bawah (mengecil)
        if (scrollTop > lastScrollTop && scrollTop > 50) {
            
            // Ubah ukuran container (CSS Class)
            navbarContainer.classList.remove('nav-expand');
            navbarContainer.classList.add('nav-shrink');

            // Sembunyikan menu tengah (CSS Class)
            if(desktopMenu) {
                desktopMenu.classList.remove('menu-fade-in');
                desktopMenu.classList.add('menu-fade-out');
            }

            // Sembunyikan teks nama user (CSS Class)
            if(userText) {
                userText.classList.remove('text-fade-in');
                userText.classList.add('text-fade-out');
            }

        } 
        // Scroll ke atas (membesar)
        else {
            
            navbarContainer.classList.remove('nav-shrink');
            navbarContainer.classList.add('nav-expand');

            if(desktopMenu) {
                desktopMenu.classList.remove('menu-fade-out');
                desktopMenu.classList.add('menu-fade-in');
            }

            if(userText) {
                userText.classList.remove('text-fade-out');
                userText.classList.add('text-fade-in');
            }
        }
        
        lastScrollTop = scrollTop <= 0 ? 0 : scrollTop;
    });

    // Logika Modal & Dropdown (Sama seperti sebelumnya)
    function openLogoutModal(event) {
        if(event) event.preventDefault();
        document.getElementById('logoutModal').classList.replace('hidden', 'flex');
        const dropdown = document.getElementById('user-dropdown');
        if(dropdown) dropdown.classList.add('hidden');
    }

    function closeLogoutModal() {
        document.getElementById('logoutModal').classList.replace('flex', 'hidden');
    }

    document.addEventListener('DOMContentLoaded', function () {
        const btn = document.getElementById('mobile-menu-btn');
        const menu = document.getElementById('mobile-menu');
        const iconMenu = document.getElementById('icon-menu');

        if (btn) {
            btn.addEventListener('click', () => {
                menu.classList.toggle('hidden');
                iconMenu.classList.toggle('rotate-90');
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