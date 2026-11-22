<!-- ==================== FOOTER UTAMA ==================== -->
<footer class="bg-white border-t-2 border-gray-200 mt-auto py-8 relative z-10 w-full">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex flex-col md:flex-row justify-between items-center gap-6">
            
            <!-- Kiri: Logo & Deskripsi -->
            <div class="text-center md:text-left md:w-1/3">
                <a href="/pbl/user/dashboard.php" class="text-2xl font-extrabold text-primary tracking-tight">
                    Galon<span class="text-secondary">ku</span>
                </a>
                <p class="text-sm text-gray-500 mt-2 max-w-xs mx-auto md:mx-0">
                    Solusi mudah untuk memenuhi kebutuhan air galon dan gas LPG Anda langsung ke depan pintu.
                </p>
            </div>

            <!-- Kanan: Link Cepat & Sosmed -->
            <div class="flex flex-col sm:flex-row gap-8 md:gap-16 text-center sm:text-left md:w-2/3 justify-end">
                <div>
                    <h3 class="text-sm font-bold text-primary mb-3">Menu Cepat</h3>
                    <ul class="space-y-2 text-sm text-gray-500">
                        <li><a href="/pbl/user/katalog.php" class="hover:text-secondary transition">Katalog Produk</a></li>
                        <li><a href="/pbl/user/riwayat.php" class="hover:text-secondary transition">Riwayat Belanja</a></li>
                        <li><a href="/pbl/user/profile.php" class="hover:text-secondary transition">Profil Saya</a></li>
                    </ul>
                </div>
                <div>
                    <h3 class="text-sm font-bold text-primary mb-3">Hubungi Kami</h3>
                    <ul class="space-y-2 text-sm text-gray-500">
                        <li><i class="fa-brands fa-whatsapp text-green-500 mr-2"></i> +62 812-3456-7890</li>
                        <li><i class="fa-solid fa-envelope text-secondary mr-2"></i> support@galonku.com</li>
                        <li><i class="fa-solid fa-location-dot text-red-500 mr-2"></i> Batam, Indonesia</li>
                    </ul>
                </div>
            </div>

        </div>

        <!-- Garis Bawah & Copyright -->
        <div class="border-t border-gray-100 mt-8 pt-6 flex flex-col md:flex-row justify-between items-center text-xs text-gray-700">
            <p>&copy; <?= date('Y'); ?> GalonKu. All rights reserved.</p>
            <div class="flex gap-4 mt-3 md:mt-0">
                <a href="#" class="hover:text-primary transition">Syarat & Ketentuan</a>
                <a href="#" class="hover:text-primary transition">Kebijakan Privasi</a>
            </div>
        </div>
    </div>
</footer>