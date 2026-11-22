<?php
session_start();
include __DIR__ . '/../koneksi.php';

if (!isset($_SESSION['username']) || $_SESSION['id_role'] != "1") {
    header("location:../index.php?pesan=akses_ditolak");
    exit();
}

$id_user = $_SESSION['id_user'];
$pesan_sukses = false;

// Proses Tambah Reminder
if (isset($_POST['tambah_reminder'])) {
    $date = $_POST['date'];
    $time = $_POST['time'];
    
    $query = "INSERT INTO reminder (id_user, date, time) VALUES ('$id_user', '$date', '$time')";
    if (mysqli_query($koneksi, $query)) {
        $pesan_sukses = true; // Tandai berhasil untuk memunculkan popup
    }
}

// Proses Hapus Reminder (Diubah menggunakan AJAX/GET)
if (isset($_GET['hapus'])) {
    $id_reminder = $_GET['hapus'];
    mysqli_query($koneksi, "DELETE FROM reminder WHERE id_reminder = '$id_reminder' AND id_user = '$id_user'");
    header("location:reminder.php");
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pengingat - GalonKu</title>
    <?php include '../layout/assets.php'; ?>
</head>
<!-- PERBAIKAN 1: Tambahkan flex flex-col min-h-screen di body -->
<body class="font-sans antialiased bg-surface flex flex-col min-h-screen">

    <?php include '../layout/navbar.php'; ?>

    <!-- PERBAIKAN 2: Tambahkan flex-1 w-full di main -->
    <main class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8 py-6 md:py-8 w-full flex-1">

        <div class="flex justify-between items-center mb-6">
            <div>
                <h1 class="text-2xl md:text-3xl font-extrabold text-primary mb-1">Jadwal Pengingat</h1>
                <p class="text-sm text-gray-500">Atur jadwal agar Anda tidak lupa membeli galon atau gas.</p>
            </div>
            <button onclick="document.getElementById('modalTambah').classList.replace('hidden', 'flex')" class="bg-primary text-white px-5 py-2.5 rounded-xl text-sm font-bold hover:bg-secondary transition shadow-md">
                <i class="fa-solid fa-plus mr-2"></i> Buat Pengingat
            </button>
        </div>

        <div class="bg-white rounded-2xl shadow-sm border-2 border-gray-200 overflow-hidden">
            <table class="w-full text-left">
                <thead class="bg-gray-50 border-b-2 border-gray-200 text-sm text-gray-500">
                    <tr>
                        <th class="p-4 font-bold">Tanggal</th>
                        <th class="p-4 font-bold">Waktu</th>
                        <th class="p-4 font-bold text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $query = mysqli_query($koneksi, "SELECT * FROM reminder WHERE id_user = '$id_user' ORDER BY date ASC, time ASC");
                    if (mysqli_num_rows($query) == 0) {
                        echo "<tr><td colspan='3' class='p-10 text-center text-gray-500'>
                                <i class='fa-solid fa-calendar-xmark text-4xl text-gray-300 mb-3'></i>
                                <p class='font-medium'>Belum ada pengingat yang dibuat.</p>
                              </td></tr>";
                    }
                    while ($row = mysqli_fetch_assoc($query)) {
                        $is_lewat = ($row['date'] < date('Y-m-d')) ? 'text-gray-400 line-through' : 'text-primary';
                    ?>
                    <tr class="border-b border-gray-100 hover:bg-gray-50 transition" id="row-<?= $row['id_reminder']; ?>">
                        <td class="p-4 font-semibold <?= $is_lewat; ?>">
                            <i class="fa-solid fa-calendar-days text-secondary mr-2"></i>
                            <?= date('d F Y', strtotime($row['date'])); ?>
                        </td>
                        <td class="p-4 font-semibold <?= $is_lewat; ?>">
                            <i class="fa-solid fa-clock text-secondary mr-2"></i>
                            <?= $row['time']; ?> WIB
                        </td>
                        <td class="p-4 text-center">
                            <button type="button" onclick="openHapusModal(<?= $row['id_reminder']; ?>)" class="text-red-500 hover:text-red-700 bg-red-50 hover:bg-red-100 p-2 rounded-lg transition shadow-sm" title="Hapus">
                                <i class="fa-solid fa-trash"></i>
                            </button>
                        </td>
                    </tr>
                    <?php } ?>
                </tbody>
            </table>
        </div>

    </main>

    <!-- ================= MODAL TAMBAH REMINDER ================= -->
    <div id="modalTambah" class="hidden fixed inset-0 bg-black/60 backdrop-blur-sm z-[100] items-center justify-center p-4">
        <div class="bg-white rounded-[2rem] w-full max-w-md p-8 shadow-2xl relative overflow-hidden">
            
            <!-- Hiasan Atas -->
            <div class="absolute top-0 right-0 w-32 h-32 bg-blue-50 rounded-bl-full -mr-10 -mt-10"></div>

            <div class="relative z-10">
                <div class="flex items-center gap-4 mb-6">
                    <div class="w-12 h-12 bg-blue-100 rounded-xl flex items-center justify-center text-secondary">
                        <i class="fa-solid fa-calendar-plus text-xl"></i>
                    </div>
                    <div>
                        <h2 class="text-xl font-extrabold text-primary">Buat Pengingat</h2>
                        <p class="text-xs text-gray-500">Atur jadwal antar galon Anda.</p>
                    </div>
                </div>

                <form action="" method="POST">
                    <div class="mb-4">
                        <label class="block text-sm font-bold text-gray-700 mb-1.5">Tanggal</label>
                        <div class="relative">
                            <i class="fa-solid fa-calendar absolute left-4 top-1/2 -translate-y-1/2 text-gray-400"></i>
                            <input type="date" name="date" required min="<?= date('Y-m-d'); ?>" class="w-full pl-11 border-2 border-gray-200 rounded-xl px-4 py-3 text-sm focus:border-primary outline-none transition">
                        </div>
                    </div>
                    <div class="mb-6">
                        <label class="block text-sm font-bold text-gray-700 mb-1.5">Waktu</label>
                        <div class="relative">
                            <i class="fa-solid fa-clock absolute left-4 top-1/2 -translate-y-1/2 text-gray-400"></i>
                            <input type="time" name="time" required class="w-full pl-11 border-2 border-gray-200 rounded-xl px-4 py-3 text-sm focus:border-primary outline-none transition">
                        </div>
                    </div>
                    <div class="flex gap-3">
                        <button type="button" onclick="document.getElementById('modalTambah').classList.replace('flex', 'hidden')" class="flex-1 px-4 py-3 text-sm font-bold text-gray-600 bg-gray-100 rounded-xl hover:bg-gray-200 transition">Batal</button>
                        <button type="submit" name="tambah_reminder" class="flex-1 px-4 py-3 text-sm font-bold text-white bg-primary rounded-xl hover:bg-secondary transition shadow-md">Simpan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- ================= POPUP KONFIRMASI HAPUS ================= -->
    <div id="hapusModal" class="fixed inset-0 z-[100] hidden items-center justify-center bg-black/60 backdrop-blur-sm p-4 transition-opacity duration-300">
        <div class="bg-white rounded-[2rem] p-8 max-w-sm w-full text-center relative overflow-hidden shadow-2xl">
            <div class="w-20 h-20 mx-auto bg-red-50 rounded-full flex items-center justify-center mb-4 border-4 border-white shadow-sm">
                <i class="fa-solid fa-trash-can text-4xl text-red-500"></i>
            </div>
            
            <h2 class="text-xl font-extrabold text-primary mb-2">Hapus Pengingat?</h2>
            <p class="text-sm text-gray-500 mb-6">Apakah Anda yakin ingin menghapus jadwal pengingat ini?</p>
            
            <div class="flex gap-3">
                <button onclick="closeHapusModal()" class="flex-1 bg-gray-100 text-gray-600 py-3 rounded-xl font-bold hover:bg-gray-200 transition">Batal</button>
                <button onclick="confirmHapus()" class="flex-1 bg-red-500 text-white py-3 rounded-xl font-bold hover:bg-red-600 transition shadow-md">Ya, Hapus</button>
            </div>
        </div>
    </div>

    <!-- ================= POPUP BERHASIL TAMBAH ================= -->
    <?php if ($pesan_sukses): ?>
    <div id="suksesModal" class="fixed inset-0 z-[100] flex items-center justify-center bg-black/60 backdrop-blur-sm p-4 transition-opacity duration-300">
        <div class="bg-white rounded-[2rem] p-8 max-w-sm w-full text-center relative overflow-hidden shadow-2xl">
            <div class="w-20 h-20 mx-auto bg-green-50 rounded-full flex items-center justify-center mb-4 border-4 border-white shadow-sm">
                <i class="fa-solid fa-check text-4xl text-green-500"></i>
            </div>
            
            <h2 class="text-xl font-extrabold text-primary mb-2">Berhasil!</h2>
            <p class="text-sm text-gray-500 mb-6">Jadwal pengingat baru berhasil ditambahkan.</p>
            
            <button onclick="document.getElementById('suksesModal').style.display='none'" class="w-full bg-primary text-white py-3 rounded-xl font-bold hover:bg-secondary transition shadow-md">
                Tutup
            </button>
        </div>
    </div>
    <?php endif; ?>

    <!-- ================= JAVASCRIPT ================= -->
    <script>
        let reminderToDelete = null;

        function openHapusModal(idReminder) {
            reminderToDelete = idReminder;
            const modal = document.getElementById('hapusModal');
            modal.classList.remove('hidden');
            modal.classList.add('flex');
        }

        function closeHapusModal() {
            const modal = document.getElementById('hapusModal');
            modal.classList.add('hidden');
            modal.classList.remove('flex');
            reminderToDelete = null;
        }

        function confirmHapus() {
            if (reminderToDelete) {
                // Arahkan ke URL hapus (menggunakan metode GET sesuai kode PHP di atas)
                window.location.href = 'reminder.php?hapus=' + reminderToDelete;
            }
        }
    </script>

    <?php include '../layout/footer.php'; ?>
</body>
</html>