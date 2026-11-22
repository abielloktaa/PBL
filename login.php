<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Masuk - GalonKu</title>
    <?php include 'layout/assets.php'; ?>
</head>
<body class="font-sans text-primary antialiased auth-page min-h-screen flex items-center justify-center p-4">

    <div class="w-full max-w-5xl bg-white rounded-3xl shadow-xl border border-gray-400 overflow-hidden flex flex-col md:flex-row min-h-[600px]">
        
        <div class="w-full md:w-5/12 relative bg-gradient-to-br from-[#002B58] via-[#0A3D7A] to-[#3770BF] p-8 md:p-10 flex flex-col justify-between overflow-hidden">
            <div class="absolute inset-0 z-0 opacity-60">
                <svg class="w-full h-full" viewBox="0 0 500 800" preserveAspectRatio="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M0,200 C150,100 350,300 500,200 L500,800 L0,800 Z" fill="rgba(255,255,255,0.03)"></path>
                    <path d="M0,500 C150,600 350,400 500,550 L500,800 L0,800 Z" fill="rgba(255,255,255,0.08)"></path>
                </svg>
            </div>
            <div class="relative z-10">
                <div class="flex items-center mb-12">
                    <i class="fa-solid fa-droplet text-white text-2xl mr-3"></i>
                    <span class="font-bold text-xl text-white">GalonKu</span>
                </div>
                <h1 class="text-3xl font-bold text-white leading-tight mb-3">Selamat Datang di GalonKu!</h1>
                <p class="text-white/70 text-sm">Solusi mudah untuk memenuhi kebutuhan galon air dan gas Anda.</p>
            </div>
        </div>

        <div class="w-full md:w-7/12 bg-white p-8 md:p-12 flex flex-col justify-center">
            <div class="max-w-md w-full mx-auto">
                <h2 class="text-2xl font-bold text-primary mb-2">Masuk Akun</h2>
                <p class="text-sm text-accent mb-8">Selamat datang kembali, silahkan masuk untuk melanjutkan.</p>

                <form action="action/actionlogin.php" method="POST" class="space-y-5">
                    <div>
                        <label class="block text-sm font-medium text-primary mb-1.5">Username</label>
                        <div class="relative">
                            <i class="fa-solid fa-envelope absolute left-3.5 top-1/2 -translate-y-1/2 text-gray-400 text-sm"></i>
                            <input type="text" name="username" placeholder="Masukkan username Anda" class="border border-gray-500 input-clean w-full pl-10 pr-4 py-3 rounded-xl text-sm" required>
                        </div>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-primary mb-1.5">Password</label>
                        <div class="relative">
                            <i class="fa-solid fa-lock absolute left-3.5 top-1/2 -translate-y-1/2 text-gray-400 text-sm"></i>
                            <input type="password" name="password" placeholder="••••••••" class="border border-gray-500 input-clean w-full pl-10 pr-4 py-3 rounded-xl text-sm" required>
                        </div>
                    </div>
                    <button type="submit" class="border border-gray-300 w-full bg-gradient-to-r from-primary to-secondary text-white py-3 rounded-xl font-semibold text-sm shadow-xl hover:shadow-lg hover:-translate-y-0.5 transition-all mt-4">
                        Masuk Sekarang
                    </button>
                </form>

                <p class="text-center text-sm text-accent mt-8">
                    Belum punya akun? <a href="register.php" class="text-secondary font-semibold hover:underline">Daftar sekarang</a>
                </p>
            </div>
        </div>
    </div>

    <!-- ================= POP-UP GAGAL LOGIN ================= -->
    <?php if (isset($_GET['pesan']) && $_GET['pesan'] == 'gagal'): ?>
    <div id="gagalModal" class="fixed inset-0 z-[100] flex items-center justify-center bg-black/60 backdrop-blur-sm p-4 transition-opacity duration-300">
        <div class="bg-white rounded-[2rem] p-8 max-w-sm w-full text-center relative overflow-hidden shadow-2xl">
            <!-- Icon Silang Merah -->
            <div class="w-20 h-20 mx-auto bg-red-50 rounded-full flex items-center justify-center mb-4 border-4 border-white shadow-sm">
                <i class="fa-solid fa-triangle-exclamation text-4xl text-red-500"></i>
            </div>
            
            <h2 class="text-xl font-extrabold text-primary mb-2">Login Gagal!</h2>
            <p class="text-sm text-gray-500 mb-6 leading-relaxed">Username atau Password yang Anda masukkan salah. Silakan periksa kembali data Anda.</p>
            
            <button onclick="document.getElementById('gagalModal').style.display='none'" class="w-full bg-primary text-white py-3 rounded-xl font-bold hover:bg-secondary transition shadow-md">
                Coba Lagi
            </button>
        </div>
    </div>
    <?php endif; ?>

    <!-- ================= POP-UP BERHASIL DAFTAR ================= -->
    <?php if (isset($_GET['pesan']) && $_GET['pesan'] == 'berhasil_daftar'): ?>
    <div id="suksesModal" class="fixed inset-0 z-[100] flex items-center justify-center bg-black/60 backdrop-blur-sm p-4 transition-opacity duration-300">
        <div class="bg-white rounded-[2rem] p-8 max-w-sm w-full text-center relative overflow-hidden shadow-2xl">
            <!-- Icon Centang Hijau -->
            <div class="w-20 h-20 mx-auto bg-green-50 rounded-full flex items-center justify-center mb-4 border-4 border-white shadow-sm">
                <i class="fa-solid fa-check text-4xl text-green-500"></i>
            </div>
            
            <h2 class="text-xl font-extrabold text-primary mb-2">Pendaftaran Berhasil!</h2>
            <p class="text-sm text-gray-500 mb-6 leading-relaxed">Akun Anda berhasil dibuat. Silakan masuk menggunakan akun baru Anda.</p>
            
            <button onclick="document.getElementById('suksesModal').style.display='none'" class="w-full bg-primary text-white py-3 rounded-xl font-bold hover:bg-secondary transition shadow-md">
                Mulai Login
            </button>
        </div>
    </div>
    <?php endif; ?>

</body>
</html>