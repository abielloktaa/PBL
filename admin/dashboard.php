<?php
session_start();
include __DIR__ . '/../koneksi.php';

if (!isset($_SESSION['username'])) {
    header("location:../index.php?pesan=akses_ditolak");
    exit();
}

$username = $_SESSION['username'];


$q_users = mysqli_query($koneksi, "SELECT COUNT(id_user) AS total FROM users WHERE id_role = '1'");
$d_users = mysqli_fetch_assoc($q_users);

$q_agents = mysqli_query($koneksi, "SELECT COUNT(id_user) AS total FROM users WHERE id_role = '2'");
$d_agents = mysqli_fetch_assoc($q_agents);

$q_orders = mysqli_query($koneksi, "SELECT COUNT(id_order) AS total FROM orders");
$d_orders = mysqli_fetch_assoc($q_orders);
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Admin - GalonKu</title>
    <?php include '../layout/assets.php'; ?>
</head>
<body class="font-sans antialiased bg-surface">

    <?php include '../layout/navbar.php'; ?>

    <main class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-6 md:py-8">

        <div class="mb-6">
            <h1 class="text-2xl md:text-3xl font-extrabold text-primary mb-1">Dashboard Admin</h1>
            <p class="text-sm text-gray-500">Selamat datang kembali, <span class="font-semibold capitalize"><?= htmlspecialchars($username); ?></span>. Kelola sistem GalonKu di sini.</p>
        </div>

        <!-- Ringkasan Statistik -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
            <div class="bg-white rounded-2xl p-6 shadow-sm border-2 border-gray-200">
                <div class="flex items-center gap-4 mb-4">
                    <div class="w-12 h-12 rounded-xl bg-blue-100 flex items-center justify-center text-blue-600">
                        <i class="fa-solid fa-users text-xl"></i>
                    </div>
                    <div>
                        <p class="text-sm text-gray-500 font-medium">Total Konsumen</p>
                        <p class="text-2xl font-extrabold text-primary"><?= $d_users['total'] ?? 0; ?></p>
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-2xl p-6 shadow-sm border-2 border-gray-200">
                <div class="flex items-center gap-4 mb-4">
                    <div class="w-12 h-12 rounded-xl bg-purple-100 flex items-center justify-center text-purple-600">
                        <i class="fa-solid fa-store text-xl"></i>
                    </div>
                    <div>
                        <p class="text-sm text-gray-500 font-medium">Total Agent Depot</p>
                        <p class="text-2xl font-extrabold text-primary"><?= $d_agents['total'] ?? 0; ?></p>
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-2xl p-6 shadow-sm border-2 border-gray-200">
                <div class="flex items-center gap-4 mb-4">
                    <div class="w-12 h-12 rounded-xl bg-green-100 flex items-center justify-center text-green-600">
                        <i class="fa-solid fa-receipt text-xl"></i>
                    </div>
                    <div>
                        <p class="text-sm text-gray-500 font-medium">Total Transaksi</p>
                        <p class="text-2xl font-extrabold text-primary"><?= $d_orders['total'] ?? 0; ?></p>
                    </div>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-2xl shadow-sm border-2 border-gray-200 p-8 text-center">
            <h2 class="text-xl font-bold text-primary mb-2">Selamat Datang di Panel Admin</h2>
            <p class="text-gray-500 mb-6">Anda memiliki akses penuh untuk mengelola pengguna dan sistem GalonKu.</p>
            <a href="users.php" class="inline-block bg-primary text-white px-6 py-3 rounded-xl font-bold hover:bg-secondary transition shadow-md">
                <i class="fa-solid fa-users-gear mr-2"></i> Kelola Pengguna
            </a>
        </div>

    </main>

    <?php if (isset($_GET['pesan']) && $_GET['pesan'] == 'login_berhasil'): ?>
    <div id="loginModal" class="fixed inset-0 z-[100] flex items-center justify-center bg-black/60 backdrop-blur-sm p-4 transition-opacity duration-300">
        <div class="bg-white rounded-[2rem] p-8 max-w-sm w-full text-center relative overflow-hidden shadow-2xl">
            
            <div class="absolute top-0 left-0 w-full h-24 bg-gradient-to-br from-gray-100 to-gray-200"></div>
            
            <div class="relative z-10 pt-4">
                <div class="w-20 h-20 mx-auto bg-white rounded-full shadow-md flex items-center justify-center mb-4 border-4 border-white">
                    <i class="fa-solid fa-user-shield text-4xl text-primary animate-bounce"></i>
                </div>
                
                <h2 class="text-2xl font-extrabold text-primary mb-2">Akses Diterima!</h2>
                <p class="text-sm text-gray-500 mb-6">Selamat datang Admin <span class="font-bold text-primary"><?= htmlspecialchars($username); ?></span>. Sistem siap dikelola.</p>
                
                <button onclick="document.getElementById('loginModal').style.display='none'" class="w-full bg-primary text-white py-3 rounded-xl font-bold hover:bg-secondary transition shadow-md">
                    Masuk ke Panel
                </button>
            </div>
        </div>
    </div>
    <?php endif; ?>

    <?php include '../layout/footer.php'; ?>
</body>
</html>