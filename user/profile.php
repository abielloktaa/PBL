<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profil Saya - GalonKu</title>
    <?php include '../layout/assets.php'; ?>
</head>

<body class="font-sans antialiased bg-surface">

    <?php include '../layout/navbar.php'; ?>

    <main class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-6 md:py-8">

        <div class="mb-6">
            <h1 class="text-2xl md:text-3xl font-extrabold text-primary">Pengaturan Profil</h1>
            <p class="text-sm text-gray-700 mt-1">Perbarui informasi data diri dan alamat pengiriman Anda.</p>
        </div>


        <div class="flex flex-col lg:flex-row gap-6">
            
  
            <div class="lg:w-1/3">
                <div class="bg-white p-6 rounded-3xl shadow-soft border border-gray-100 text-center relative overflow-hidden">

                    <div class="absolute top-0 right-0 w-32 h-32 bg-[#EBF4FF] rounded-full blur-2xl -mr-10 -mt-10"></div>
                    
                    <div class="z-10 relative">
           
                        <div class="w-32 h-32 mx-auto rounded-full bg-gray-100 border-4 border-surface shadow-sm flex items-center justify-center overflow-hidden mb-4">
               
                            <i class="fa-solid fa-user text-6xl text-gray-300"></i>
                        </div>
                        
                        <h2 class="text-lg font-bold text-primary">Budi Santoso</h2>

                        <p class="text-xs text-accent mb-4">Customer</p>

          
                        <label for="foto" class="cursor-pointer inline-block bg-white text-primary border border-primary px-5 py-2 rounded-full font-semibold text-sm hover:bg-primary hover:text-white transition-all shadow-sm">
                            <i class="fa-solid fa-camera mr-1"></i> Ubah Foto
                        </label>
                        <input type="file" id="foto" name="foto" class="hidden" accept="image/*">
                        
                        <p class="text-xs text-gray-700 mt-3">Maksimal 2MB (JPG/PNG)</p>
                    </div>
                </div>
            </div>

  
            <div class="lg:w-2/3">
                <div class="bg-white p-6 md:p-8 rounded-3xl shadow-soft border border-gray-100">
                    
        
                    <form action="proses_update_profil.php" method="POST" enctype="multipart/form-data">
                  
                        <h3 class="text-lg font-bold text-primary mb-4 border-b border-gray-100 pb-2">Informasi Pribadi</h3>
                        
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                 
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Nama Lengkap</label>
                                <input type="text" name="nama" value="Budi Santoso" required class="w-full px-4 py-2 border border-gray-300 rounded-xl focus:ring-2 focus:ring-primary focus:border-primary outline-none transition-all text-sm">
                            </div>
           
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Alamat Email</label>
                                <input type="email" name="email" value="budi@example.com" disabled class="w-full px-4 py-2 border border-gray-300 rounded-xl focus:ring-2 focus:ring-primary focus:border-primary outline-none transition-all text-sm ">
                            </div>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
          
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Nomor WhatsApp</label>
                                <input type="tel" name="telepon" value="081234567890" required class="w-full px-4 py-2 border border-gray-300 rounded-xl focus:ring-2 focus:ring-primary focus:border-primary outline-none transition-all text-sm">
                            </div>
                            
                     
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Password Baru <span class="text-gray-400 font-normal">(Opsional)</span></label>
                                <input type="password" name="password" placeholder="••••••••" class="w-full px-4 py-2 border border-gray-300 rounded-xl focus:ring-2 focus:ring-primary focus:border-primary outline-none transition-all text-sm">
                            </div>
                        </div>

                        <h3 class="text-lg font-bold text-primary mb-4 border-b border-gray-100 pb-2 mt-6">Alamat Pengiriman</h3>
                        
                 
                            <label class="block text-sm font-medium text-gray-700 mb-1">Alamat Lengkap</label>
                            <textarea name="alamat" rows="3" required class="w-full px-4 py-2 border border-gray-300 rounded-xl focus:ring-2 focus:ring-primary focus:border-primary outline-none transition-all text-sm">Jl. Ahmad Yani No. 123, Batam, Kepulauan Riau</textarea>
                        </div>

                  
                        <div class="flex justify-end gap-3 mt-8 pt-6 border-t border-gray-100">
                            <a href="dashboard.php" class="bg-gray-100 text-gray-600 px-6 py-2.5 rounded-full font-semibold hover:bg-gray-200 transition-colors text-sm">
                                Batal
                            </a>
                            <button type="submit" class="bg-primary text-white px-6 py-2.5 rounded-full font-semibold shadow-lg hover:bg-secondary hover:-translate-y-0.5 transition-all text-sm">
                                Simpan Perubahan <i class="fa-solid fa-check ml-1"></i>
                            </button>
                        </div>

                    </form>

                </div>
            </div>

        </div>

    </main>

    <?php include '../layout/footer.php'; ?>

</body>
</html>