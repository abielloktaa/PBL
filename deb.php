<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Keranjang Belanja - GalonKu</title>
    
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>

<body class="font-sans antialiased bg-gray-50">

    <!-- NAVBAR -->
    <nav class="bg-white shadow-sm py-4 px-6 mb-8">
        <div class="max-w-7xl mx-auto flex justify-between items-center">
            <h1 class="text-2xl font-bold text-blue-600">GalonKu</h1>
            <a href="#" class="text-gray-600 hover:text-blue-600 font-medium"><i class="fa-solid fa-arrow-left mr-2"></i>Lanjut Belanja</a>
        </div>
    </nav>

    <!-- KONTEN UTAMA -->
    <main class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8">
        <h2 class="text-3xl font-extrabold text-gray-800 mb-6">Keranjang Belanja</h2>

        <!-- BUG 1: Ada typo pada class Tailwind flexbox di sini. Akibatnya, di layar laptop, keranjang dan ringkasan tidak akan bersebelahan -->
        <div class="flex flex-col md:flex-ro gap-6">
            
            <!-- KOLOM KIRI: DAFTAR PRODUK -->
            <div class="w-full md:w-2/3">
                <div class="bg-white rounded-xl shadow-sm border border-gray-200">
                    
                    <!-- Item 1 -->
                    <div class="p-4 border-b border-gray-100 flex items-center justify-between">
                        <div class="flex items-center gap-4">
                            <div class="w-16 h-16 bg-blue-50 rounded-lg flex items-center justify-center">
                                <i class="fa-solid fa-droplet text-blue-500 text-2xl"></i>
                            </div>
                            <div>
                                <h3 class="font-bold text-gray-800">Galon Aqua 19L</h3>
                                <p class="text-sm text-gray-500">Rp 20.000</p>
                            </div>
                        </div>
                        
                        <!-- Tombol Qty -->
                        <div class="flex items-center gap-3">
                            <button onclick="ubahQty('qty-1', -1)" class="w-8 h-8 rounded-full bg-gray-100 hover:bg-gray-200 text-gray-600">-</button>
                            <!-- BUG 2: ID elemen ini tidak sesuai dengan yang dipanggil di JavaScript -->
                            <span id="quantity-1" class="font-semibold w-4 text-center">1</span>
                            <button onclick="ubahQty('qty-1', 1)" class="w-8 h-8 rounded-full bg-gray-100 hover:bg-gray-200 text-gray-600">+</button>
                        </div>
                    </div>

                    <!-- Item 2 -->
                    <div class="p-4 flex items-center justify-between">
                        <div class="flex items-center gap-4">
                            <div class="w-16 h-16 bg-red-50 rounded-lg flex items-center justify-center">
                                <i class="fa-solid fa-fire text-red-500 text-2xl"></i>
                            </div>
                            <div>
                                <h3 class="font-bold text-gray-800">Gas LPG 3kg</h3>
                                <p class="text-sm text-gray-500">Rp 25.000</p>
                            </div>
                        </div>
                        <div class="flex items-center gap-3">
                            <button class="w-8 h-8 rounded-full bg-gray-100 text-gray-600">-</button>
                            <span class="font-semibold w-4 text-center">1</span>
                            <button class="w-8 h-8 rounded-full bg-gray-100 text-gray-600">+</button>
                        </div>
                    </div>

                </div> <!-- Penutup card item -->
            </div>

            <!-- KOLOM KANAN: RINGKASAN -->
            <div class="w-full md:w-1/3">
                <div class="bg-white p-6 rounded-xl shadow-sm border border-gray-200">
                    <h3 class="text-lg font-bold text-gray-800 mb-4 border-b pb-2">Ringkasan Belanja</h3>
                    
                    <div class="flex justify-between mb-2 text-gray-600">
                        <span>Total Harga (2 Barang)</span>
                        <span>Rp 45.000</span>
                    </div>
                    <div class="flex justify-between mb-4 text-gray-600">
                        <span>Ongkos Kirim</span>
                        <span>Rp 5.000</span>
                    </div>
                    
                    <div class="border-t pt-4 flex justify-between font-bold text-lg text-gray-800 mb-6">
                        <span>Total Tagihan</span>
                        <!-- BUG 3: Hasil penjumlahan ini akan salah (menghasilkan Rp 45.0005.000) -->
                        <span id="total-harga" class="text-blue-600">Rp 45.0005.000</span>
                    </div>

                    <button onclick="bayarSekarang()" class="w-full bg-blue-600 text-white py-3 rounded-xl font-bold hover:bg-blue-700 transition">
                        Lanjut ke Pembayaran
                    </button>
                </div>
            <!-- BUG 4: Tag penutup </div> untuk kolom kanan hilang di sini -->
            
        </div>
    </main>

    <script>
        // BUG 5: Ada kesalahan logika pada matematika JavaScript
        function ubahQty(id, perubahan) {
            let elemen = document.getElementById("qty-1"); // ID ini benar, tapi masalahnya di HTML
            let qtySekarang = parseInt(elemen.innerText);
            let qtyBaru = qtySekarang + perubahan;
            
            if (qtyBaru >= 1) {
                elemen.innerText = qtyBaru;
            }
        }

        // BUG 6: Fungsi ini dipanggil oleh tombol, tapi namanya tidak cocok
        function checkout() {
            alert("Fitur pembayaran belum tersedia.");
        }
    </script>
</body>
</html>