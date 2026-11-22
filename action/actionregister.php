<?php
session_start();
include __DIR__ . '/../koneksi.php';

// Ambil data langsung dari form
$username = $_POST['username'];
$password = $_POST['password'];
$no_hp    = $_POST['no_hp'];
$email    = $_POST['email'];
$address  = $_POST['address'];
$depot    = $_POST['depot'];

// Hash password sebelum disimpan
$password_hash = password_hash($password, PASSWORD_DEFAULT);

// Cek apakah username atau email sudah ada
$cek_user = mysqli_query($koneksi, "SELECT * FROM users WHERE username = '$username' OR email = '$email'");
if (mysqli_num_rows($cek_user) > 0) {
    // Kembali ke halaman REGISTER dengan pesan gagal
    header("location:../register.php?pesan=gagal");
    exit;
}

// Proses Insert ke Database
$query = "INSERT INTO users (username, password, no_hp, email, address, depot, id_role) 
          VALUES ('$username', '$password_hash', '$no_hp', '$email', '$address', '$depot', 1)";
$data = mysqli_query($koneksi, $query);

if ($data) {
    // PERUBAHAN PENTING: Tetap arahkan ke register, tapi dengan parameter berhasil
    header("location:../register.php?pesan=berhasil");
    exit;
} else {
    // Jika gagal, kembalikan ke register
    header("location:../register.php?pesan=gagal");
    exit;
}
?>