<?php
session_start();
include __DIR__ . '/../koneksi.php';

$id_user  = $_SESSION['id_user'];

// 1. Ambil data teks dari form
$nama     = $_POST['nama'];
$no_hp    = $_POST['no_hp'];
$alamat   = $_POST['alamat'];
$password = $_POST['password'];

// 2. Ambil data user lama dari database
$query_user = mysqli_query($koneksi, "SELECT * FROM users WHERE id_user = '$id_user'");
$user       = mysqli_fetch_assoc($query_user);

// 3. Update data teks (Password Opsional)
if (!empty($password)) {
    $query = "UPDATE users SET username = '$nama', no_hp = '$no_hp', address = '$alamat', password = '$password' WHERE id_user = '$id_user'";
} else {
    $query = "UPDATE users SET username = '$nama', no_hp = '$no_hp', address = '$alamat' WHERE id_user = '$id_user'";
}
mysqli_query($koneksi, $query);

// =======================================================
// PERBAIKAN: UPDATE SESSION USERNAME AGAR NAVBAR BERUBAH
// =======================================================
$_SESSION['username'] = $nama;

// 4. Logika Upload Foto
if (isset($_FILES['foto']) && $_FILES['foto']['error'] == 0) {
    $nama_file = $_FILES['foto']['name'];
    $ukuran    = $_FILES['foto']['size'];
    $tmp_file  = $_FILES['foto']['tmp_name'];
    $ekstensi  = strtolower(pathinfo($nama_file, PATHINFO_EXTENSION));
    
    $format_diizinkan = ['jpg', 'jpeg', 'png'];
    
    if (in_array($ekstensi, $format_diizinkan) && $ukuran <= 2000000) {
        
        // Buat nama file unik
        $nama_file_baru = 'user_' . $id_user . '_' . time() . '.' . $ekstensi;
        
        // Path folder tujuan (masuk ke folder poto)
        $folder_tujuan = __DIR__ . '/../poto/';
        
        // Pindahkan file
        if (move_uploaded_file($tmp_file, $folder_tujuan . $nama_file_baru)) {
            
            // Hapus foto lama jika ada (Opsional)
            if (!empty($user['foto']) && file_exists($folder_tujuan . $user['foto'])) {
                unlink($folder_tujuan . $user['foto']);
            }

            // QUERY UNTUK MENYIMPAN NAMA FILE KE DATABASE
            mysqli_query($koneksi, "UPDATE users SET foto = '$nama_file_baru' WHERE id_user = '$id_user'");
            
        } else {
            die("Gagal memindahkan file. Cek izin akses folder.");
        }
    } else {
        die("Format file salah atau ukuran lebih dari 2MB.");
    }
}

// 5. Kembali ke halaman profil
header("location: ../user/profile.php?pesan=update_berhasil");
exit;
?>