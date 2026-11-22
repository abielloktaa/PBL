<?php
session_start();
include __DIR__ . '/../koneksi.php';

// Proteksi Halaman Agent
if (!isset($_SESSION['username']) || $_SESSION['id_role'] != "2") {
    header("location:../index.php?pesan=akses_ditolak");
    exit();
}

$id_user = $_SESSION['id_user'];

// ==========================================
// 1. PROSES TAMBAH PRODUK (CREATE)
// ==========================================
if (isset($_POST['tambah_produk'])) {
    $nama_produk = mysqli_real_escape_string($koneksi, $_POST['nama_produk']);
    $harga       = $_POST['harga'];
    $stok        = $_POST['stok'];
    
    $img_query = "NULL"; 

    if (isset($_FILES['img']) && $_FILES['img']['error'] == 0) {
        $ekstensi = strtolower(pathinfo($_FILES['img']['name'], PATHINFO_EXTENSION));
        if (in_array($ekstensi, ['jpg', 'jpeg', 'png'])) {
            $nama_file_baru = 'prod_' . $id_user . '_' . time() . '.' . $ekstensi;
            
            // PERBAIKAN: Folder tujuan diarahkan ke ../poto/
            $folder_tujuan = __DIR__ . '/../poto/';
            
            if (!is_dir($folder_tujuan)) mkdir($folder_tujuan, 0777, true);
            
            if (move_uploaded_file($_FILES['img']['tmp_name'], $folder_tujuan . $nama_file_baru)) {
                $img_query = "'$nama_file_baru'";
            }
        }
    }

    $query = "INSERT INTO product (id_agent, img, name_product, price, stock) 
              VALUES ('$id_user', $img_query, '$nama_produk', '$harga', '$stok')";
    
    if (mysqli_query($koneksi, $query)) {
        echo "<script>alert('Produk berhasil ditambahkan!'); window.location='produk.php';</script>";
    } else {
        echo "<script>alert('Gagal menambah produk: " . mysqli_error($koneksi) . "');</script>";
    }
}

// ==========================================
// 2. PROSES EDIT PRODUK (UPDATE)
// ==========================================
if (isset($_POST['edit_produk'])) {
    $id_produk   = $_POST['id_produk'];
    $nama_produk = mysqli_real_escape_string($koneksi, $_POST['nama_produk']);
    $harga       = $_POST['harga'];
    $stok        = $_POST['stok'];
    
    $q_lama = mysqli_query($koneksi, "SELECT img FROM product WHERE id_product = '$id_produk'");
    $d_lama = mysqli_fetch_assoc($q_lama);

    $update_img_query = ""; 

    if (isset($_FILES['img']) && $_FILES['img']['error'] == 0) {
        $ekstensi = strtolower(pathinfo($_FILES['img']['name'], PATHINFO_EXTENSION));
        if (in_array($ekstensi, ['jpg', 'jpeg', 'png'])) {
            $nama_file_baru = 'prod_' . $id_user . '_' . time() . '.' . $ekstensi;
            
            // PERBAIKAN: Folder tujuan diarahkan ke ../poto/
            $folder_tujuan = __DIR__ . '/../poto/';
            
            if (move_uploaded_file($_FILES['img']['tmp_name'], $folder_tujuan . $nama_file_baru)) {
                // Hapus file gambar lama
                if (!empty($d_lama['img']) && !str_contains($d_lama['img'], 'dummy') && file_exists($folder_tujuan . $d_lama['img'])) {
                    unlink($folder_tujuan . $d_lama['img']);
                }
                $update_img_query = ", img = '$nama_file_baru'";
            }
        }
    }

    $query = "UPDATE product SET 
                name_product = '$nama_produk', 
                price = '$harga', 
                stock = '$stok' 
                $update_img_query 
              WHERE id_product = '$id_produk' AND id_agent = '$id_user'";
    
    if (mysqli_query($koneksi, $query)) {
        echo "<script>alert('Produk berhasil diupdate!'); window.location='produk.php';</script>";
    } else {
        echo "<script>alert('Gagal mengupdate produk: " . mysqli_error($koneksi) . "');</script>";
    }
}

// ==========================================
// 3. PROSES HAPUS PRODUK (DELETE)
// ==========================================
if (isset($_GET['hapus'])) {
    $id_hapus = $_GET['hapus'];
    
    $q_lama = mysqli_query($koneksi, "SELECT img FROM product WHERE id_product = '$id_hapus'");
    $d_lama = mysqli_fetch_assoc($q_lama);
    
    // PERBAIKAN: Path hapus file diarahkan ke ../poto/
    if (!empty($d_lama['img']) && !str_contains($d_lama['img'], 'dummy') && file_exists(__DIR__ . '/../poto/' . $d_lama['img'])) {
        unlink(__DIR__ . '/../poto/' . $d_lama['img']);
    }

    $query = "DELETE FROM product WHERE id_product = '$id_hapus' AND id_agent = '$id_user'";
    if (mysqli_query($koneksi, $query)) {
        echo "<script>alert('Produk berhasil dihapus!'); window.location='produk.php';</script>";
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kelola Produk - Agent</title>
    <?php include '../layout/assets.php'; ?>
</head>
<body class="font-sans antialiased bg-surface">
    <?php include '../layout/navbar.php'; ?>

    <main class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-6 md:py-8">
        
        <div class="flex justify-between items-center mb-6">
            <div>
                <h1 class="text-2xl font-extrabold text-primary">Kelola Produk</h1>
                <p class="text-sm text-gray-500">Daftar produk yang Anda jual di GalonKu.</p>
            </div>
            <button onclick="document.getElementById('modalTambah').classList.remove('hidden')" class="bg-primary text-white px-4 py-2 rounded-xl text-sm font-semibold hover:bg-secondary transition">
                <i class="fa-solid fa-plus mr-1"></i> Tambah Produk
            </button>
        </div>

        <!-- Tabel Produk -->
        <div class="bg-white rounded-2xl shadow-soft border border-gray-400 overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full text-left">
                    <thead class="bg-gray-50 border-b text-sm text-gray-500">
                        <tr>
                            <th class="p-4">Gambar</th>
                            <th class="p-4">Nama Produk</th>
                            <th class="p-4">Harga</th>
                            <th class="p-4">Stok</th>
                            <th class="p-4 text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $query = "SELECT * FROM product WHERE id_agent = '$id_user' ORDER BY id_product DESC";
                        $result = mysqli_query($koneksi, $query);
                        
                        if (mysqli_num_rows($result) == 0) {
                            echo "<tr><td colspan='5' class='p-6 text-center text-gray-500'>Belum ada produk yang dijual.</td></tr>";
                        }

                        while ($row = mysqli_fetch_assoc($result)) {
                        ?>
                        <tr class="border-b hover:bg-gray-50">
                            <td class="p-4">
                                <div class="w-16 h-16 bg-gray-100 rounded-lg overflow-hidden flex items-center justify-center border border-gray-200">
                                    <?php if (!empty($row['img']) && !str_contains($row['img'], 'dummy')) { ?>
                                        <!-- PERBAIKAN: Panggil gambar dari folder ../poto/ -->
                                        <img src="../poto/<?= $row['img']; ?>" class="w-full h-full object-cover">
                                    <?php } else { ?>
                                        <i class="fa-solid fa-droplet text-secondary text-2xl"></i>
                                    <?php } ?>
                                </div>
                            </td>
                            <td class="p-4 font-semibold text-primary"><?= htmlspecialchars($row['name_product']); ?></td>
                            <td class="p-4 text-sm font-medium">Rp <?= number_format($row['price'], 0, ',', '.'); ?></td>
                            <td class="p-4 text-sm font-medium"><?= $row['stock']; ?></td>
                            <td class="p-4 text-center">
                                <!-- Tombol Edit -->
                                <button onclick="editProduk(<?= $row['id_product']; ?>, '<?= htmlspecialchars($row['name_product']); ?>', <?= $row['price']; ?>, <?= $row['stock']; ?>)" class="text-blue-500 hover:text-blue-700 bg-blue-50 hover:bg-blue-100 p-2 rounded-lg mx-1 transition" title="Edit">
                                    <i class="fa-solid fa-pen-to-square"></i>
                                </button>
                                <!-- Tombol Hapus -->
                                <a href="produk.php?hapus=<?= $row['id_product']; ?>" onclick="return confirm('Yakin ingin menghapus produk ini?')" class="text-red-500 hover:text-red-700 bg-red-50 hover:bg-red-100 p-2 rounded-lg mx-1 transition inline-block" title="Hapus">
                                    <i class="fa-solid fa-trash"></i>
                                </a>
                            </td>
                        </tr>
                        <?php } ?>
                    </tbody>
                </table>
            </div>
        </div>

    </main>

    <!-- ================= MODAL TAMBAH PRODUK ================= -->
    <div id="modalTambah" class="hidden fixed inset-0 bg-black/50 z-50 flex items-center justify-center p-4">
        <div class="bg-white rounded-2xl w-full max-w-md p-6 shadow-lg">
            <h2 class="text-xl font-bold text-primary mb-4">Tambah Produk Baru</h2>
            <form action="" method="POST" enctype="multipart/form-data">
                <div class="mb-3">
                    <label class="block text-sm font-medium mb-1">Nama Produk</label>
                    <input type="text" name="nama_produk" required class="w-full border rounded-xl px-4 py-2 text-sm focus:ring-2 focus:ring-primary outline-none">
                </div>
                <div class="grid grid-cols-2 gap-3 mb-3">
                    <div>
                        <label class="block text-sm font-medium mb-1">Harga (Rp)</label>
                        <input type="number" name="harga" required class="w-full border rounded-xl px-4 py-2 text-sm focus:ring-2 focus:ring-primary outline-none">
                    </div>
                    <div>
                        <label class="block text-sm font-medium mb-1">Stok</label>
                        <input type="number" name="stok" required class="w-full border rounded-xl px-4 py-2 text-sm focus:ring-2 focus:ring-primary outline-none">
                    </div>
                </div>
                <div class="mb-5">
                    <label class="block text-sm font-medium mb-1">Foto Produk (Opsional)</label>
                    <input type="file" name="img" accept="image/*" class="w-full text-sm border rounded-xl px-4 py-2 file:mr-4 file:py-1 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-primary/10 file:text-primary hover:file:bg-primary/20">
                </div>
                <div class="flex justify-end gap-2">
                    <button type="button" onclick="document.getElementById('modalTambah').classList.add('hidden')" class="px-4 py-2 text-sm font-semibold text-gray-600 bg-gray-100 rounded-xl">Batal</button>
                    <button type="submit" name="tambah_produk" class="px-4 py-2 text-sm font-semibold text-white bg-primary rounded-xl">Simpan Produk</button>
                </div>
            </form>
        </div>
    </div>

    <!-- ================= MODAL EDIT PRODUK ================= -->
    <div id="modalEdit" class="hidden fixed inset-0 bg-black/50 z-50 flex items-center justify-center p-4">
        <div class="bg-white rounded-2xl w-full max-w-md p-6 shadow-lg">
            <h2 class="text-xl font-bold text-primary mb-4">Edit Produk</h2>
            <form action="" method="POST" enctype="multipart/form-data">
                <input type="hidden" name="id_produk" id="edit_id">
                <div class="mb-3">
                    <label class="block text-sm font-medium mb-1">Nama Produk</label>
                    <input type="text" name="nama_produk" id="edit_nama" required class="w-full border rounded-xl px-4 py-2 text-sm focus:ring-2 focus:ring-primary outline-none">
                </div>
                <div class="grid grid-cols-2 gap-3 mb-3">
                    <div>
                        <label class="block text-sm font-medium mb-1">Harga (Rp)</label>
                        <input type="number" name="harga" id="edit_harga" required class="w-full border rounded-xl px-4 py-2 text-sm focus:ring-2 focus:ring-primary outline-none">
                    </div>
                    <div>
                        <label class="block text-sm font-medium mb-1">Stok</label>
                        <input type="number" name="stok" id="edit_stok" required class="w-full border rounded-xl px-4 py-2 text-sm focus:ring-2 focus:ring-primary outline-none">
                    </div>
                </div>
                <div class="mb-5">
                    <label class="block text-sm font-medium mb-1">Ganti Foto (Opsional)</label>
                    <input type="file" name="img" accept="image/*" class="w-full text-sm border rounded-xl px-4 py-2 file:mr-4 file:py-1 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-primary/10 file:text-primary hover:file:bg-primary/20">
                    <p class="text-xs text-gray-400 mt-1">Biarkan kosong jika tidak ingin mengganti foto.</p>
                </div>
                <div class="flex justify-end gap-2">
                    <button type="button" onclick="document.getElementById('modalEdit').classList.add('hidden')" class="px-4 py-2 text-sm font-semibold text-gray-600 bg-gray-100 rounded-xl">Batal</button>
                    <button type="submit" name="edit_produk" class="px-4 py-2 text-sm font-semibold text-white bg-primary rounded-xl">Update Produk</button>
                </div>
            </form>
        </div>
    </div>

    <!-- SCRIPT UNTUK MENGISI DATA DI MODAL EDIT -->
    <script>
        function editProduk(id, nama, harga, stok) {
            document.getElementById('edit_id').value = id;
            document.getElementById('edit_nama').value = nama;
            document.getElementById('edit_harga').value = harga;
            document.getElementById('edit_stok').value = stok;
            
            // Tampilkan Modal
            document.getElementById('modalEdit').classList.remove('hidden');
        }
    </script>

    <?php include '../layout/footer.php'; ?>
</body>
</html>