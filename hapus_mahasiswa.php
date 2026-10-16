<?php
session_start();

if (!isset($_SESSION['status_login']) || $_SESSION['status_login'] !== true) {
    header("Location: login.php");
    exit;
}

include 'Koneksi.php';

if (isset($_GET['nim'])) {
    $nim = mysqli_real_escape_string($conn, $_GET['nim']);

    $query_foto = mysqli_query($conn, "SELECT pas_foto FROM mahasiswa WHERE nim = '$nim'");
    $data = mysqli_fetch_assoc($query_foto);
    
    if ($data) {
        $file_foto = "uploads/" . $data['pas_foto'];
        if (file_exists($file_foto) && !empty($data['pas_foto'])) {
            unlink($file_foto); 
        }

        
        $hapus = mysqli_query($conn, "DELETE FROM mahasiswa WHERE nim = '$nim'");
        if ($hapus) {
            echo "<script>alert('Data berhasil dihapus!'); window.location='index.php';</script>";
        } else {
            echo "<script>alert('Gagal menghapus data.'); window.location='index.php';</script>";
        }
    } else {
        header("Location: index.php");
    }
} else {
    header("Location: index.php");
}
?>