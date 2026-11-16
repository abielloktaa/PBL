<?php
include __DIR__ . '/../koneksi.php';

$username   = $_POST['username'];
$password    = $_POST['password'];
$no_hp        = $_POST['no_hp'];
$email        = $_POST['email'];
$address   = $_POST['address'];
$depot   = $_POST['depot'];

// Hash password sebelum disimpan (best practice)
$password_hash = password_hash($password, PASSWORD_DEFAULT);

$query = "INSERT INTO users (username, password, no_hp, email, address, depot, id_role) 
          VALUES ('$username', '$password_hash', '$no_hp', '$email', '$address', '$depot', 1)";
$data = mysqli_query($koneksi, $query);

header("location:../login.php");
exit;
?>
