<!-- ================= NAVBAR ATAS GALONKU ================= -->
<nav class="bg-primary shadow-lg sticky top-0 z-50 w-full">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between items-center h-16 md:h-20">

            <!-- LOGO -->
            <a href="dashboard.php" class="flex-shrink-0 flex items-center cursor-pointer">
                <span class="text-xl md:text-2xl font-bold text-white tracking-tight">
                    Galon<span class="text-support">ku</span>
                </span>
            </a>

         
            <div class="hidden md:flex items-center space-x-6 lg:space-x-8">
                <a href="dashboard.php" class="text-gray-200 hover:text-support font-medium transition duration-300 text-sm lg:text-base">Dashboard</a>
                <a href="katalog.php" class="text-gray-200 hover:text-support font-medium transition duration-300 text-sm lg:text-base">Katalog</a>
                <a href="pesanan.php" class="text-gray-200 hover:text-support font-medium transition duration-300 text-sm lg:text-base">Pesanan</a>
                <a href="riwayat.php" class="text-gray-200 hover:text-support font-medium transition duration-300 text-sm lg:text-base">Riwayat</a>
            </div>

     
            <div class="flex items-center gap-2 md:gap-3">

                <a href="../user/pesanan.php" class="hidden md:flex relative w-10 h-10 rounded-full bg-secondary hover:bg-support items-center justify-center text-white transition">
                    <i class="fa-solid fa-cart-shopping text-sm"></i>
                </a>

       
                <div class="hidden md:block relative">
                    <button id="user-menu-btn" class="flex items-center gap-2 bg-secondary hover:bg-support transition rounded-full pl-1 pr-3 py-1 cursor-pointer">
                        <div class="w-8 h-8 rounded-full bg-support text-primary flex items-center justify-center font-bold text-sm">
                            <i class="fa-solid fa-user"></i>
                        </div>
                        <span class="text-white text-sm font-medium">User</span>
                        <i id="user-chevron" class="fa-solid fa-chevron-down text-white text-xs transition-transform duration-300"></i>
                    </button>

             
                    <div id="user-dropdown" class="hidden absolute right-0 mt-2 w-56 bg-white rounded-2xl shadow-pop border border-gray-100 overflow-hidden z-50">
                  
                        <div class="px-4 py-3 bg-gradient-to-br from-primary to-secondary text-white">
                            <p class="font-bold text-sm">User Galonku</p>
                            <p class="text-xs text-white/70 truncate">user@galonku.com</p>
                        </div>

          
                        <div class="py-2">
                            <a href="profil.php" class="flex items-center gap-3 px-4 py-2.5 text-sm text-primary hover:bg-surface transition">
                                <i class="fa-solid fa-user w-4 text-secondary"></i> Profil Saya
                            </a>
                            <a href="pesanan.php" class="flex items-center gap-3 px-4 py-2.5 text-sm text-primary hover:bg-surface transition">
                                <i class="fa-solid fa-box w-4 text-secondary"></i> Pesanan Saya
                            </a>
                            <a href="riwayat.php" class="flex items-center gap-3 px-4 py-2.5 text-sm text-primary hover:bg-surface transition">
                                <i class="fa-solid fa-clock-rotate-left w-4 text-secondary"></i> Riwayat
                            </a>
                            <a href="pengaturan.php" class="flex items-center gap-3 px-4 py-2.5 text-sm text-primary hover:bg-surface transition">
                                <i class="fa-solid fa-gear w-4 text-secondary"></i> Pengaturan
                            </a>
                        </div>

                
                        <div class="border-t border-gray-100 py-2">
                            <a href="logout.php" onclick="return confirm('Yakin ingin logout?')" 
                               class="flex items-center gap-3 px-4 py-2.5 text-sm text-red-500 hover:bg-red-50 transition font-semibold">
                                <i class="fa-solid fa-right-from-bracket w-4"></i> Logout
                            </a>
                        </div>
                    </div>
                </div>

         
                <a href="keranjang.php" class="md:hidden relative w-9 h-9 rounded-full bg-secondary flex items-center justify-center text-white">
                    <i class="fa-solid fa-cart-shopping text-xs"></i>
                </a>

                <button id="mobile-menu-btn" class="md:hidden text-white hover:text-support focus:outline-none p-1">
                    <svg id="icon-hamburger" class="h-6 w-6 block" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                    </svg>
                    <svg id="icon-close" class="h-6 w-6 hidden" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
        </div>
    </div>

    <div id="mobile-menu" class="hidden md:hidden bg-secondary border-t border-white/10">
        <div class="px-4 pt-3 pb-4 space-y-1">
      
            <div class="flex items-center gap-3 bg-primary/40 rounded-xl p-3 mb-3">
                <div class="w-10 h-10 rounded-full bg-support text-primary flex items-center justify-center font-bold">
                    <i class="fa-solid fa-user"></i>
                </div>
                <div class="min-w-0">
                    <p class="text-white font-semibold text-sm truncate">User Galonku</p>
                    <p class="text-white/60 text-xs truncate">user@galonku.com</p>
                </div>
            </div>

            <!-- Menu -->
            <a href="dashboard.php" class="block px-3 py-2.5 rounded-lg text-white font-medium hover:bg-primary hover:text-support transition">Dashboard</a>
            <a href="katalog.php" class="block px-3 py-2.5 rounded-lg text-white font-medium hover:bg-primary hover:text-support transition">Katalog</a>
            <a href="pesanan.php" class="block px-3 py-2.5 rounded-lg text-white font-medium hover:bg-primary hover:text-support transition">Pesanan</a>
            <a href="riwayat.php" class="block px-3 py-2.5 rounded-lg text-white font-medium hover:bg-primary hover:text-support transition">Riwayat</a>
            <a href="profil.php" class="block px-3 py-2.5 rounded-lg text-white font-medium hover:bg-primary hover:text-support transition">
                <i class="fa-solid fa-user mr-2"></i> Profil Saya
            </a>
            <a href="pengaturan.php" class="block px-3 py-2.5 rounded-lg text-white font-medium hover:bg-primary hover:text-support transition">
                <i class="fa-solid fa-gear mr-2"></i> Pengaturan
            </a>

            <div class="border-t border-white/20 my-2 pt-2"></div>

            <!-- Logout -->
            <a href="logout.php" onclick="return confirm('Yakin ingin logout?')" 
               class="block mt-2 text-center bg-red-500 text-white px-4 py-3 rounded-lg font-bold hover:bg-red-600 transition">
                <i class="fa-solid fa-right-from-bracket mr-2"></i> Logout
            </a>
        </div>
    </div>
</nav>

<!-- ================= JAVASCRIPT ================= -->
<script>
    document.addEventListener('DOMContentLoaded', function () {

        // ===== 1. TOGGLE MOBILE MENU =====
        const btn = document.getElementById('mobile-menu-btn');
        const menu = document.getElementById('mobile-menu');
        const iconHamburger = document.getElementById('icon-hamburger');
        const iconClose = document.getElementById('icon-close');

        if (btn) {
            btn.addEventListener('click', () => {
                menu.classList.toggle('hidden');
                iconHamburger.classList.toggle('hidden');
                iconClose.classList.toggle('hidden');
            });

            menu.querySelectorAll('a').forEach(link => {
                link.addEventListener('click', () => {
                    menu.classList.add('hidden');
                    iconHamburger.classList.remove('hidden');
                    iconClose.classList.add('hidden');
                });
            });
        }

        // ===== 2. TOGGLE USER DROPDOWN (DESKTOP) =====
        const userBtn = document.getElementById('user-menu-btn');
        const userDropdown = document.getElementById('user-dropdown');
        const userChevron = document.getElementById('user-chevron');

        if (userBtn) {
            userBtn.addEventListener('click', (e) => {
                e.stopPropagation(); // Biar tidak bentrok dengan document click
                userDropdown.classList.toggle('hidden');
                userChevron.classList.toggle('rotate-180');
            });

            // Tutup dropdown kalau klik di luar
            document.addEventListener('click', (e) => {
                if (!userBtn.contains(e.target) && !userDropdown.contains(e.target)) {
                    userDropdown.classList.add('hidden');
                    userChevron.classList.remove('rotate-180');
                }
            });

            // Tutup dropdown kalau tekan ESC
            document.addEventListener('keydown', (e) => {
                if (e.key === 'Escape') {
                    userDropdown.classList.add('hidden');
                    userChevron.classList.remove('rotate-180');
                }
            });
        }
    });
</script>

