<?php
session_start();
include __DIR__ . '/../koneksi.php';

// Proteksi Halaman Admin (Role 3)
if (!isset($_SESSION['username']) || $_SESSION['id_role'] != "3") {
    header("location:../index.php?pesan=akses_ditolak");
    exit();
}

$pesan_sukses = false;
$pesan_error = false;
$error_msg = "";

// ==========================================
// 1. PROSES TAMBAH USER/AGENT (CREATE)
// ==========================================
if (isset($_POST['tambah_user'])) {
    $username = $_POST['username'];
    $password = $_POST['password'];
    $no_hp    = $_POST['no_hp'];
    $email    = $_POST['email'];
    $address  = $_POST['address'];
    $depot    = $_POST['depot'];
    $id_role  = $_POST['id_role'];

    // Cek duplikasi username/email
    $cek = mysqli_query($koneksi, "SELECT * FROM users WHERE username = '$username' OR email = '$email'");
    if (mysqli_num_rows($cek) > 0) {
        $pesan_error = true;
        $error_msg = "Username atau Email sudah digunakan!";
    } else {
        // Hash password
        $password_hash = password_hash($password, PASSWORD_DEFAULT);
        
        $query = "INSERT INTO users (username, password, no_hp, email, address, depot, id_role) 
                  VALUES ('$username', '$password_hash', '$no_hp', '$email', '$address', '$depot', '$id_role')";
        
        if (mysqli_query($koneksi, $query)) {
            $pesan_sukses = true;
        } else {
            $pesan_error = true;
            $error_msg = "Gagal menambah pengguna: " . mysqli_error($koneksi);
        }
    }
}

// ==========================================
// 2. PROSES EDIT USER/AGENT (UPDATE)
// ==========================================
if (isset($_POST['edit_user'])) {
    $id_user  = $_POST['id_user'];
    $username = $_POST['username'];
    $no_hp    = $_POST['no_hp'];
    $email    = $_POST['email'];
    $address  = $_POST['address'];
    $depot    = $_POST['depot'];
    $id_role  = $_POST['id_role'];
    $password = $_POST['password'];

    if (!empty($password)) {
        // Jika password diisi, update dengan hash baru
        $password_hash = password_hash($password, PASSWORD_DEFAULT);
        $query = "UPDATE users SET 
                    username = '$username', 
                    password = '$password_hash', 
                    no_hp = '$no_hp', 
                    email = '$email', 
                    address = '$address', 
                    depot = '$depot', 
                    id_role = '$id_role' 
                  WHERE id_user = '$id_user'";
    } else {
        // Jika password kosong, jangan update password
        $query = "UPDATE users SET 
                    username = '$username', 
                    no_hp = '$no_hp', 
                    email = '$email', 
                    address = '$address', 
                    depot = '$depot', 
                    id_role = '$id_role' 
                  WHERE id_user = '$id_user'";
    }

    if (mysqli_query($koneksi, $query)) {
        $pesan_sukses = true;
    } else {
        $pesan_error = true;
        $error_msg = "Gagal mengupdate pengguna: " . mysqli_error($koneksi);
    }
}

// ==========================================
// 3. PROSES HAPUS USER/AGENT (DELETE)
// ==========================================
if (isset($_GET['hapus'])) {
    $id_hapus = $_GET['hapus'];
    
    // Cegah admin menghapus akunnya sendiri
    if ($id_hapus == $_SESSION['id_user']) {
        echo "<script>alert('Anda tidak bisa menghapus akun Anda sendiri!'); window.location='users.php';</script>";
    } else {
        // Hapus relasi data terlebih dahulu agar tidak error Foreign Key
        mysqli_query($koneksi, "DELETE FROM history WHERE id_user = '$id_hapus'");
        mysqli_query($koneksi, "DELETE FROM reminder WHERE id_user = '$id_hapus'");
        mysqli_query($koneksi, "DELETE FROM orders WHERE id_user = '$id_hapus' OR id_agent = '$id_hapus'");
        
        $hapus = mysqli_query($koneksi, "DELETE FROM users WHERE id_user = '$id_hapus'");
        if ($hapus) {
            echo "<script>alert('Data pengguna berhasil dihapus!'); window.location='users.php';</script>";
        } else {
            echo "<script>alert('Gagal menghapus pengguna: " . mysqli_error($koneksi) . "');</script>";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kelola Pengguna - Admin GalonKu</title>
    <?php include '../layout/assets.php'; ?>
</head>
<body class="font-sans antialiased bg-surface">
    <?php include '../layout/navbar.php'; ?>

    <main class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-6 md:py-8">
        
        <!-- Header Halaman -->
        <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center mb-6 gap-4">
            <div>
                <h1 class="text-2xl md:text-3xl font-extrabold text-primary mb-1">Kelola Pengguna</h1>
                <p class="text-sm text-gray-500">Daftar semua akun Konsumen, Agent Depot, dan Admin.</p>
            </div>
            <button onclick="document.getElementById('modalTambah').classList.replace('hidden', 'flex')" class="bg-primary text-white px-5 py-2.5 rounded-xl text-sm font-bold hover:bg-secondary transition shadow-md flex items-center gap-2">
                <i class="fa-solid fa-plus"></i> Tambah Pengguna
            </button>
        </div>

        <!-- Tabel Data Pengguna -->
        <div class="bg-white rounded-2xl shadow-sm border-2 border-gray-200 overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full text-left">
                    <thead class="bg-gray-50 border-b-2 border-gray-200 text-sm text-gray-500">
                        <tr>
                            <th class="p-4 font-bold">ID</th>
                            <th class="p-4 font-bold">Nama / Username</th>
                            <th class="p-4 font-bold">Kontak</th>
                            <th class="p-4 font-bold">Role</th>
                            <th class="p-4 font-bold text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $query = "SELECT * FROM users ORDER BY id_role ASC, id_user DESC";
                        $result = mysqli_query($koneksi, $query);
                        
                        if (mysqli_num_rows($result) == 0) {
                            echo "<tr><td colspan='5' class='p-6 text-center text-gray-500'>Belum ada data pengguna.</td></tr>";
                        }

                        while ($row = mysqli_fetch_assoc($result)) {
                            $role_text = "Konsumen";
                            $role_badge = "bg-blue-100 text-blue-700 border-blue-200";
                            if ($row['id_role'] == '2') {
                                $role_text = "Agent Depot";
                                $role_badge = "bg-purple-100 text-purple-700 border-purple-200";
                            } elseif ($row['id_role'] == '3') {
                                $role_text = "Administrator";
                                $role_badge = "bg-red-100 text-red-700 border-red-200";
                            }
                        ?>
                        <tr class="border-b border-gray-100 hover:bg-gray-50 transition">
                            <td class="p-4 text-sm font-medium"><?= $row['id_user']; ?></td>
                            <td class="p-4">
                                <p class="font-bold text-primary capitalize"><?= htmlspecialchars($row['username']); ?></p>
                                <p class="text-xs text-gray-500"><?= htmlspecialchars($row['email']); ?></p>
                            </td>
                            <td class="p-4 text-sm">
                                <p><i class="fa-solid fa-phone text-gray-400 mr-1"></i> <?= htmlspecialchars($row['no_hp'] ?? '-'); ?></p>
                                <?php if ($row['id_role'] == '2'): ?>
                                    <p class="text-xs text-gray-500 mt-1"><i class="fa-solid fa-store text-gray-400 mr-1"></i> <?= htmlspecialchars($row['depot']); ?></p>
                                <?php endif; ?>
                            </td>
                            <td class="p-4">
                                <span class="text-[11px] font-bold px-2.5 py-1 rounded-md border <?= $role_badge; ?>">
                                    <?= $role_text; ?>
                                </span>
                            </td>
                            <td class="p-4 text-center">
                                <!-- Tombol Edit -->
                                <button onclick="editUser(<?= $row['id_user']; ?>, '<?= htmlspecialchars($row['username']); ?>', '<?= htmlspecialchars($row['no_hp']); ?>', '<?= htmlspecialchars($row['email']); ?>', '<?= htmlspecialchars($row['address']); ?>', '<?= htmlspecialchars($row['depot']); ?>', '<?= $row['id_role']; ?>')" class="text-blue-500 hover:text-blue-700 bg-blue-50 hover:bg-blue-100 p-2 rounded-lg mx-1 transition" title="Edit">
                                    <i class="fa-solid fa-pen-to-square"></i>
                                </button>
                                <!-- Tombol Hapus (Memanggil Modal) -->
                                <button onclick="openHapusModal(<?= $row['id_user']; ?>, '<?= htmlspecialchars($row['username']); ?>')" class="text-red-500 hover:text-red-700 bg-red-50 hover:bg-red-100 p-2 rounded-lg mx-1 transition" title="Hapus">
                                    <i class="fa-solid fa-trash"></i>
                                </button>
                            </td>
                        </tr>
                        <?php } ?>
                    </tbody>
                </table>
            </div>
        </div>
    </main>

    <!-- ================= MODAL TAMBAH USER ================= -->
    <div id="modalTambah" class="hidden fixed inset-0 bg-black/60 backdrop-blur-sm z-[100] items-center justify-center p-4">
        <div class="bg-white rounded-3xl w-full max-w-md p-6 shadow-2xl relative overflow-hidden">
            <div class="absolute top-0 left-0 w-full h-2 bg-primary"></div>
            <h2 class="text-xl font-bold text-primary mb-4 mt-2">Tambah Pengguna Baru</h2>
            <form action="" method="POST">
                <div class="grid grid-cols-2 gap-3 mb-3">
                    <div>
                        <label class="block text-sm font-bold mb-1">Username</label>
                        <input type="text" name="username" required class="w-full border-2 border-gray-200 rounded-xl px-4 py-2 text-sm focus:border-primary outline-none">
                    </div>
                    <div>
                        <label class="block text-sm font-bold mb-1">Password</label>
                        <input type="password" name="password" required class="w-full border-2 border-gray-200 rounded-xl px-4 py-2 text-sm focus:border-primary outline-none">
                    </div>
                </div>
                <div class="grid grid-cols-2 gap-3 mb-3">
                    <div>
                        <label class="block text-sm font-bold mb-1">No. HP</label>
                        <input type="tel" name="no_hp" required class="w-full border-2 border-gray-200 rounded-xl px-4 py-2 text-sm focus:border-primary outline-none">
                    </div>
                    <div>
                        <label class="block text-sm font-bold mb-1">Role Akses</label>
                        <select name="id_role" required class="w-full border-2 border-gray-200 rounded-xl px-4 py-2 text-sm focus:border-primary outline-none bg-white">
                            <option value="1">Konsumen</option>
                            <option value="2">Agent Depot</option>
                            <option value="3">Administrator</option>
                        </select>
                    </div>
                </div>
                <div class="mb-3">
                    <label class="block text-sm font-bold mb-1">Email</label>
                    <input type="email" name="email" required class="w-full border-2 border-gray-200 rounded-xl px-4 py-2 text-sm focus:border-primary outline-none">
                </div>
                <div class="mb-3">
                    <label class="block text-sm font-bold mb-1">Alamat Lengkap</label>
                    <textarea name="address" rows="2" required class="w-full border-2 border-gray-200 rounded-xl px-4 py-2 text-sm focus:border-primary outline-none"></textarea>
                </div>
                <div class="mb-6">
                    <label class="block text-sm font-bold mb-1">Nama Depot <span class="text-gray-400 font-normal">(Khusus Agent)</span></label>
                    <input type="text" name="depot" class="w-full border-2 border-gray-200 rounded-xl px-4 py-2 text-sm focus:border-primary outline-none">
                </div>
                <div class="flex justify-end gap-2">
                    <button type="button" onclick="document.getElementById('modalTambah').classList.replace('flex', 'hidden')" class="px-5 py-2.5 text-sm font-bold text-gray-600 bg-gray-100 rounded-xl hover:bg-gray-200 transition">Batal</button>
                    <button type="submit" name="tambah_user" class="px-5 py-2.5 text-sm font-bold text-white bg-primary rounded-xl hover:bg-secondary transition shadow-md">Simpan Pengguna</button>
                </div>
            </form>
        </div>
    </div>

    <!-- ================= MODAL EDIT USER ================= -->
    <div id="modalEdit" class="hidden fixed inset-0 bg-black/60 backdrop-blur-sm z-[100] items-center justify-center p-4">
        <div class="bg-white rounded-3xl w-full max-w-md p-6 shadow-2xl relative overflow-hidden">
            <div class="absolute top-0 left-0 w-full h-2 bg-secondary"></div>
            <h2 class="text-xl font-bold text-primary mb-4 mt-2">Edit Data Pengguna</h2>
            <form action="" method="POST">
                <input type="hidden" name="id_user" id="edit_id">
                <div class="grid grid-cols-2 gap-3 mb-3">
                    <div>
                        <label class="block text-sm font-bold mb-1">Username</label>
                        <input type="text" name="username" id="edit_username" required class="w-full border-2 border-gray-200 rounded-xl px-4 py-2 text-sm focus:border-primary outline-none">
                    </div>
                    <div>
                        <label class="block text-sm font-bold mb-1">Password Baru</label>
                        <input type="password" name="password" placeholder="Kosongkan jika tetap" class="w-full border-2 border-gray-200 rounded-xl px-4 py-2 text-sm focus:border-primary outline-none">
                    </div>
                </div>
                <div class="grid grid-cols-2 gap-3 mb-3">
                    <div>
                        <label class="block text-sm font-bold mb-1">No. HP</label>
                        <input type="tel" name="no_hp" id="edit_no_hp" required class="w-full border-2 border-gray-200 rounded-xl px-4 py-2 text-sm focus:border-primary outline-none">
                    </div>
                    <div>
                        <label class="block text-sm font-bold mb-1">Role Akses</label>
                        <select name="id_role" id="edit_role" required class="w-full border-2 border-gray-200 rounded-xl px-4 py-2 text-sm focus:border-primary outline-none bg-white">
                            <option value="1">Konsumen</option>
                            <option value="2">Agent Depot</option>
                            <option value="3">Administrator</option>
                        </select>
                    </div>
                </div>
                <div class="mb-3">
                    <label class="block text-sm font-bold mb-1">Email</label>
                    <input type="email" name="email" id="edit_email" required class="w-full border-2 border-gray-200 rounded-xl px-4 py-2 text-sm focus:border-primary outline-none">
                </div>
                <div class="mb-3">
                    <label class="block text-sm font-bold mb-1">Alamat Lengkap</label>
                    <textarea name="address" id="edit_address" rows="2" required class="w-full border-2 border-gray-200 rounded-xl px-4 py-2 text-sm focus:border-primary outline-none"></textarea>
                </div>
                <div class="mb-6">
                    <label class="block text-sm font-bold mb-1">Nama Depot <span class="text-gray-400 font-normal">(Khusus Agent)</span></label>
                    <input type="text" name="depot" id="edit_depot" class="w-full border-2 border-gray-200 rounded-xl px-4 py-2 text-sm focus:border-primary outline-none">
                </div>
                <div class="flex justify-end gap-2">
                    <button type="button" onclick="document.getElementById('modalEdit').classList.replace('flex', 'hidden')" class="px-5 py-2.5 text-sm font-bold text-gray-600 bg-gray-100 rounded-xl hover:bg-gray-200 transition">Batal</button>
                    <button type="submit" name="edit_user" class="px-5 py-2.5 text-sm font-bold text-white bg-primary rounded-xl hover:bg-secondary transition shadow-md">Update Data</button>
                </div>
            </form>
        </div>
    </div>

    <!-- ================= POPUP SUKSES ================= -->
    <?php if ($pesan_sukses): ?>
    <div id="suksesModal" class="fixed inset-0 z-[100] flex items-center justify-center bg-black/60 backdrop-blur-sm p-4 transition-opacity duration-300">
        <div class="bg-white rounded-[2rem] p-8 max-w-sm w-full text-center relative overflow-hidden shadow-2xl">
            <div class="w-20 h-20 mx-auto bg-green-50 rounded-full flex items-center justify-center mb-4 border-4 border-white shadow-sm">
                <i class="fa-solid fa-check text-4xl text-green-500"></i>
            </div>
            <h2 class="text-xl font-extrabold text-primary mb-2">Berhasil!</h2>
            <p class="text-sm text-gray-500 mb-6">Data pengguna berhasil disimpan ke database.</p>
            <button onclick="document.getElementById('suksesModal').style.display='none'" class="w-full bg-primary text-white py-3 rounded-xl font-bold hover:bg-secondary transition shadow-md">
                Tutup
            </button>
        </div>
    </div>
    <?php endif; ?>

    <!-- ================= POPUP GAGAL ================= -->
    <?php if ($pesan_error): ?>
    <div id="gagalModal" class="fixed inset-0 z-[100] flex items-center justify-center bg-black/60 backdrop-blur-sm p-4 transition-opacity duration-300">
        <div class="bg-white rounded-[2rem] p-8 max-w-sm w-full text-center relative overflow-hidden shadow-2xl">
            <div class="w-20 h-20 mx-auto bg-red-50 rounded-full flex items-center justify-center mb-4 border-4 border-white shadow-sm">
                <i class="fa-solid fa-triangle-exclamation text-4xl text-red-500"></i>
            </div>
            <h2 class="text-xl font-extrabold text-primary mb-2">Gagal!</h2>
            <p class="text-sm text-gray-500 mb-6"><?= htmlspecialchars($error_msg); ?></p>
            <button onclick="document.getElementById('gagalModal').style.display='none'" class="w-full bg-primary text-white py-3 rounded-xl font-bold hover:bg-secondary transition shadow-md">
                Coba Lagi
            </button>
        </div>
    </div>
    <?php endif; ?>

    <!-- ================= POPUP KONFIRMASI HAPUS ================= -->
    <div id="hapusModal" class="fixed inset-0 z-[100] hidden items-center justify-center bg-black/60 backdrop-blur-sm p-4 transition-opacity duration-300">
        <div class="bg-white rounded-[2rem] p-8 max-w-sm w-full text-center relative overflow-hidden shadow-2xl">
            <div class="w-20 h-20 mx-auto bg-red-50 rounded-full flex items-center justify-center mb-4 border-4 border-white shadow-sm">
                <i class="fa-solid fa-trash-can text-4xl text-red-500"></i>
            </div>
            
            <h2 class="text-xl font-extrabold text-primary mb-2">Hapus Pengguna?</h2>
            <p class="text-sm text-gray-500 mb-6 leading-relaxed">Apakah Anda yakin ingin menghapus akun <span id="namaHapus" class="font-bold"></span>? Semua pesanan dan riwayat terkait akan ikut terhapus.</p>
            
            <div class="flex gap-3">
                <button onclick="closeHapusModal()" class="flex-1 bg-gray-100 text-gray-600 py-3 rounded-xl font-bold hover:bg-gray-200 transition">Batal</button>
                <a href="#" id="btnHapusPesanan" class="flex-1 bg-red-500 text-white py-3 rounded-xl font-bold hover:bg-red-600 transition shadow-md">Ya, Hapus</a>
            </div>
        </div>
    </div>

    <!-- ================= JAVASCRIPT ================= -->
    <script>
        function editUser(id, username, no_hp, email, address, depot, role) {
            document.getElementById('edit_id').value = id;
            document.getElementById('edit_username').value = username;
            document.getElementById('edit_no_hp').value = no_hp;
            document.getElementById('edit_email').value = email;
            document.getElementById('edit_address').value = address;
            document.getElementById('edit_depot').value = depot;
            document.getElementById('edit_role').value = role;
            
            document.getElementById('modalEdit').classList.replace('hidden', 'flex');
        }

        function openHapusModal(idUser, username) {
            document.getElementById('namaHapus').innerText = username;
            document.getElementById('btnHapusPesanan').href = 'users.php?hapus=' + idUser;
            
            const modal = document.getElementById('hapusModal');
            modal.classList.remove('hidden');
            modal.classList.add('flex');
        }

        function closeHapusModal() {
            const modal = document.getElementById('hapusModal');
            modal.classList.add('hidden');
            modal.classList.remove('flex');
        }
    </script>

    <?php include '../layout/footer.php'; ?>
</body>
</html>