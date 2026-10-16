<?php
session_start();
include 'Koneksi.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nim       = mysqli_real_escape_string($conn, htmlspecialchars($_POST['nim']));
    $nama      = mysqli_real_escape_string($conn, htmlspecialchars($_POST['nama']));
    $email     = mysqli_real_escape_string($conn, filter_var($_POST['email'], FILTER_SANITIZE_EMAIL));
    $jk        = mysqli_real_escape_string($conn, $_POST['jenis_kelamin'] ?? '');
    $jurusan   = mysqli_real_escape_string($conn, $_POST['jurusan'] ?? '');
    $angkatan  = mysqli_real_escape_string($conn, htmlspecialchars($_POST['angkatan']));
    $hobi_arr  = isset($_POST['hobi']) ? $_POST['hobi'] : [];
    $hobi      = mysqli_real_escape_string($conn, implode(', ', $hobi_arr));

    if (empty($nim) || empty($nama) || empty($email) || empty($jurusan)) {
        echo "<script>alert('Error: Data wajib tidak boleh kosong!'); window.location='form_pendaftaran.php';</script>";
        exit;
    } else {
        $nama_file = $_FILES['pas_foto']['name'];
        $ukuran_file = $_FILES['pas_foto']['size'];
        $tmp_file = $_FILES['pas_foto']['tmp_name'];
        $ekstensi_diizinkan = ['jpg', 'jpeg', 'png', 'gif'];
        
        $x = explode('.', $nama_file);
        $ekstensi = strtolower(end($x));

        if (!in_array($ekstensi, $ekstensi_diizinkan)) {
            echo "<script>alert('Ekstensi file foto tidak diizinkan! (Gunakan JPG/PNG/GIF)'); window.location='form_pendaftaran.php';</script>";
            exit;
        } elseif ($ukuran_file > 2097152) { // Maksimal 2MB
            echo "<script>alert('Ukuran file foto terlalu besar! Maksimal 2MB.'); window.location='form_pendaftaran.php';</script>";
            exit;
        } else {
            $nama_file_baru = uniqid() . '_' . $nama_file;
            $path = "uploads/" . $nama_file_baru;

            if (move_uploaded_file($tmp_file, $path)) {
                $query = "INSERT INTO mahasiswa (nim, nama, email, jenis_kelamin, jurusan, angkatan, hobi, pas_foto) 
                          VALUES ('$nim', '$nama', '$email', '$jk', '$jurusan', '$angkatan', '$hobi', '$nama_file_baru')";
                
                if (mysqli_query($conn, $query)) {
                    echo "<script>alert('Pendaftaran berhasil!'); window.location='index.php';</script>";
                } else {
                    echo "<script>alert('Gagal menyimpan ke database: " . mysqli_error($conn) . "'); window.location='form_pendaftaran.php';</script>";
                }
            } else {
                echo "<script>alert('Gagal mengunggah foto!'); window.location='form_pendaftaran.php';</script>";
            }
        }
    }
} else {
    header("Location: form_pendaftaran.php");
    exit;
}
?>