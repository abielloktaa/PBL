<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Masuk - GalonKu</title>
    <?php include 'layout/assets.php'; ?>
</head>
<body class="font-sans text-primary antialiased auth-page min-h-screen flex items-center justify-center p-4">

    <div class="w-full max-w-5xl bg-white rounded-3xl shadow-card border border-gray-200 overflow-hidden flex flex-col md:flex-row min-h-[600px]">
        

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

                <form action="user/dashboard.php" method="POST" class="space-y-5">

                    <div>
                        <label class="block text-sm font-medium text-primary mb-1.5">Email</label>
                        
                        <div class="relative">
                            <i class="fa-solid fa-envelope absolute left-3.5 top-1/2 -translate-y-1/2 text-gray-400 text-sm"></i>
                            <input type="" name="email" placeholder="username" class="input-clean w-full pl-10 pr-4 py-3 rounded-xl text-sm" >
                        </div>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-primary mb-1.5">Password</label>
                        <div class="relative">
                            <i class="fa-solid fa-lock absolute left-3.5 top-1/2 -translate-y-1/2 text-gray-400 text-sm"></i>
                            <input type="password" name="password" placeholder="••••••••" class="input-clean w-full pl-10 pr-4 py-3 rounded-xl text-sm" required>
                        </div>
                    </div>
                    <div class="flex justify-end">
                        <a href="#" class="text-xs font-medium text-secondary hover:text-primary">Lupa password?</a>
                    </div>
                    <button type="submit" class="w-full bg-gradient-to-r from-primary to-secondary text-white py-3 rounded-xl font-semibold text-sm shadow-md hover:shadow-lg hover:-translate-y-0.5 transition-all">
                        Masuk Sekarang
                    </button>
                </form>

                <p class="text-center text-sm text-accent mt-8">
                    Belum punya akun? <a href="register.php" class="text-secondary font-semibold hover:underline">Daftar sekarang</a>
                </p>
            </div>
        </div>
    </div>

</body>
</html>