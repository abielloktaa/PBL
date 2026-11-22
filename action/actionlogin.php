<?php 
session_start();
include __DIR__ . '/../koneksi.php';

if (isset($_POST['username']) && isset($_POST['password'])) {
    
    $username = mysqli_real_escape_string($koneksi, $_POST['username']);
    $password = $_POST['password']; 

    // Cari user berdasarkan username
    $query = mysqli_query($koneksi, "SELECT * FROM users WHERE username='$username'");
    
    if (mysqli_num_rows($query) === 1) {
        $d = mysqli_fetch_assoc($query);
        
        // Verifikasi Password
        if (password_verify($password, $d['password'])) {
            
            // Set Session
            $_SESSION['username'] = $d['username'];
            $_SESSION['id_role']  = $d['id_role'];
            $_SESSION['id_user']  = $d['id_user']; 
           
            // Arahkan ke halaman yang sesuai DENGAN PARAMETER PESAN
            if ($d['id_role'] == "1") {
                header("location:../user/dashboard.php?pesan=login_berhasil");
                exit();
            } else if ($d['id_role'] == "2") {
                header("location:../agent/dashboard.php?pesan=login_berhasil");
                exit();
            } else if ($d['id_role'] == "3") {
                header("location:../admin/dashboard.php?pesan=login_berhasil"); 
                exit();
            } else {
                header("location:../login.php?pesan=gagal");
                exit();
            }
        } else {
            // Password salah
            header("location:../login.php?pesan=gagal");
            exit();
        }
    } else {
        // Username tidak ditemukan
        header("location:../login.php?pesan=gagal");
        exit();
    }
} else {
    header("location:../login.php");
    exit();
}
?>