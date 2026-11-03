<?php 
session_start();
include __DIR__ . '/../koneksi.php';

if (isset($_POST['username']) && isset($_POST['password'])) {
    $username = mysqli_real_escape_string($koneksi, $_POST['username']);
    $password = mysqli_real_escape_string($koneksi, $_POST['password']);

    $l = mysqli_query($koneksi, "SELECT * FROM users WHERE username='$username' AND password='$password'");
    $c = mysqli_num_rows($l);

    if ($c > 0) {
        $d = mysqli_fetch_assoc($l);
        
        $_SESSION['username'] = $d['username'];
        $_SESSION['id_role']  = $d['id_role'];
        $_SESSION['id_user']  = $d['id_user']; 
       
        if ($d['id_role'] == "1") {
            header("location:../user/dashboard.php");
            exit();
        } else if ($d['id_role'] == "2") {
            header("location:../agent/dashboard.php");
            exit();
        } else if ($d['id_role'] == "3") {
            header("location:../admin/dashboard.php"); 
            exit();
        } else {
            header("location:../login.php?pesan=gagal");
            exit();
        }
    } else {
        header("location:../login.php?pesan=gagal");
        exit();
    }
} else {
    header("location:../login.php");
    exit();
}
?>