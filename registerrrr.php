<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar - GalonKu</title>
    <?php include 'layout/assets.php'; ?>
</head>
<body class="font-sans text-primary antialiased auth-page min-h-screen flex items-center justify-center p-4">

    <div class="w-full max-w-5xl bg-white rounded-3xl shadow-card border border-gray-200 overflow-hidden flex flex-col md:flex-row min-h-[650px]">

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

        <div class="w-full md:w-7/12 bg-white p-8 md:p-12 flex flex-col justify-center overflow-y-auto">
            <div class="max-w-lg w-full mx-auto">
                <h2 class="text-2xl font-bold text-primary mb-2">Gabung Dengan Kami</h2>
                <p class="text-sm text-accent mb-8">Lengkapi data diri Anda untuk membuat akun GalonKu.</p>

                <form action="login.php" method="POST" class="space-y-4">
                    <div>
                        <label class="block text-sm font-medium text-primary mb-1.5">Nama Lengkap</label>
                        <div class="relative">
                            <i class="fa-solid fa-user absolute left-3.5 top-1/2 -translate-y-1/2 text-gray-400 text-sm"></i>
                            <input type="text" name="nama_lengkap" placeholder="Lorem Ipsum" class="border border-gray-300 input-clean w-full pl-10 pr-4 py-3 rounded-xl text-sm" required>
                        </div>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm font-medium text-primary mb-1.5">No. Handphone</label>
                            <div class="flex">
                                <span class="inline-flex items-center px-3 rounded-l-xl border border-r-0 border-gray-200 bg-gray-50 text-accent text-sm font-medium">+62</span>
                                <input type="tel" name="no_hp" placeholder="895-3620-42424" class="border border-gray-300 input-clean w-full px-4 py-3 rounded-r-xl text-sm" required>
                            </div>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-primary mb-1.5">Email</label>
                            <div class="relative">
                                <i class="fa-solid fa-envelope absolute left-3.5 top-1/2 -translate-y-1/2 text-gray-400 text-sm"></i>
                                <input type="email" name="email" placeholder="loremipsum@gmail.com" class="border border-gray-300 input-clean w-full pl-10 pr-4 py-3 rounded-xl text-sm" required>
                            </div>
                        </div>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-primary mb-1.5">Password</label>
                        <div class="relative">
                            <i class="fa-solid fa-lock absolute left-3.5 top-1/2 -translate-y-1/2 text-gray-400 text-sm"></i>
                            <input type="password" name="password" placeholder="Minimal 6 karakter" class="border border-gray-300 input-clean w-full pl-10 pr-4 py-3 rounded-xl text-sm" required>
                        </div>
                    </div>

                    <button type="submit" class="w-full bg-gradient-to-r from-primary to-secondary text-white py-3 rounded-xl font-semibold text-sm shadow-md hover:shadow-lg hover:-translate-y-0.5 transition-all mt-4">
                        Daftar
                    </button>
                </form>

                <p class="text-center text-sm text-accent mt-6">
                    Sudah punya akun? <a href="login.php" class="text-secondary font-semibold hover:underline">Masuk di sini</a>
                </p>
            </div>
        </div>
    </div>

</body>
</html>