<?php
session_start();
include 'Koneksi.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = mysqli_real_escape_string($conn, $_POST['username']);
    $password = mysqli_real_escape_string($conn, $_POST['password']);

    $query = mysqli_query($conn, "SELECT * FROM users WHERE username = '$username'");
    $user = mysqli_fetch_assoc($query);

    if ($user && $password === $user['password']) {
        // Set session login
        $_SESSION['status_login'] = true;
        $_SESSION['username'] = $user['username'];
        $_SESSION['nama_lengkap'] = $user['nama_lengkap'];
        
        echo "<script>alert('Login berhasil! Selamat datang, " . $user['nama_lengkap'] . "'); window.location='index.php';</script>";
        exit;
    } else {
        echo "<script>alert('Username atau Password salah!'); window.location='login.php';</script>";
        exit;
    }
} else {
    header("Location: login.php");
    exit;
}
?>