<?php
session_start();

if (!isset($_SESSION['status_login']) || $_SESSION['status_login'] !== true) {
    header("Location: login.php");
    exit;
}

include 'Koneksi.php';

if (!isset($_SESSION['lang'])) {
    $_SESSION['lang'] = 'id';
}

if (isset($_GET['lang'])) {
    if ($_GET['lang'] == 'en' || $_GET['lang'] == 'id') {
        $_SESSION['lang'] = $_GET['lang'];
    }
}

$lang = [
    'id' => [
        'title' => 'Edit Data Mahasiswa',
        'heading' => 'Edit Data Mahasiswa',
        'nim' => 'NIM (Tidak dapat diubah):',
        'nama' => 'Nama Lengkap:',
        'email' => 'Email:',
        'jk' => 'Jenis Kelamin:',
        'laki' => 'Laki-laki',
        'perempuan' => 'Perempuan',
        'jurusan' => 'Jurusan:',
        'pilih_jurusan' => '-- Pilih Jurusan --',
        'angkatan' => 'Angkatan:',
        'hobi' => 'Hobi:',
        'membaca' => 'Membaca',
        'olahraga' => 'Olahraga',
        'coding' => 'Coding',
        'gaming' => 'Gaming',
        'traveling' => 'Traveling',
        'foto_sekarang' => 'Foto Saat Ini:',
        'foto_baru' => 'Ganti Pas Foto (Opsional, Maks 2MB):',
        'submit' => 'Simpan Perubahan',
        'back' => 'Kembali',
        'switch_lang' => 'Switch to English'
    ],
    'en' => [
        'title' => 'Edit Student Data',
        'heading' => 'Edit Student Data',
        'nim' => 'Student ID (Cannot be changed):',
        'nama' => 'Full Name:',
        'email' => 'Email:',
        'jk' => 'Gender:',
        'laki' => 'Male',
        'perempuan' => 'Female',
        'jurusan' => 'Major:',
        'pilih_jurusan' => '-- Select Major --',
        'angkatan' => 'Batch / Year:',
        'hobi' => 'Hobbies:',
        'membaca' => 'Reading',
        'olahraga' => 'Sports',
        'coding' => 'Coding',
        'gaming' => 'Gaming',
        'traveling' => 'Traveling',
        'foto_sekarang' => 'Current Photo:',
        'foto_baru' => 'Change Photo (Optional, Max 2MB):',
        'submit' => 'Save Changes',
        'back' => 'Back',
        'switch_lang' => 'Ubah ke Bahasa Indonesia'
    ]
];

$t = $lang[$_SESSION['lang']];
$current_lang = $_SESSION['lang'];
$target_lang = ($current_lang == 'id') ? 'en' : 'id';

if (!isset($_GET['nim'])) {
    header("Location: index.php");
    exit;
}

$nim = mysqli_real_escape_string($conn, $_GET['nim']);
$query = mysqli_query($conn, "SELECT * FROM mahasiswa WHERE nim = '$nim'");
$mhs = mysqli_fetch_assoc($query);

if (!$mhs) {
    echo "<script>alert('Data mahasiswa tidak ditemukan!'); window.location='index.php';</script>";
    exit;
}

$hobi_terpilih = explode(', ', $mhs['hobi']);

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nama     = mysqli_real_escape_string($conn, htmlspecialchars($_POST['nama']));
    $email    = mysqli_real_escape_string($conn, filter_var($_POST['email'], FILTER_SANITIZE_EMAIL));
    $jk       = mysqli_real_escape_string($conn, $_POST['jenis_kelamin'] ?? '');
    $jurusan  = mysqli_real_escape_string($conn, $_POST['jurusan'] ?? '');
    $angkatan = mysqli_real_escape_string($conn, htmlspecialchars($_POST['angkatan']));
    $hobi_arr = isset($_POST['hobi']) ? $_POST['hobi'] : [];
    $hobi     = mysqli_real_escape_string($conn, implode(', ', $hobi_arr));

    if (!empty($_FILES['pas_foto']['name'])) {
        $nama_file = $_FILES['pas_foto']['name'];
        $ukuran_file = $_FILES['pas_foto']['size'];
        $tmp_file = $_FILES['pas_foto']['tmp_name'];
        $ekstensi_diizinkan = ['jpg', 'jpeg', 'png', 'gif'];
        
        $x = explode('.', $nama_file);
        $ekstensi = strtolower(end($x));

        if (!in_array($ekstensi, $ekstensi_diizinkan)) {
            echo "<script>alert('Ekstensi file foto tidak diizinkan!');</script>";
        } elseif ($ukuran_file > 2097152) {
            echo "<script>alert('Ukuran file terlalu besar! Maksimal 2MB.');</script>";
        } else {
            $foto_lama = "uploads/" . $mhs['pas_foto'];
            if (file_exists($foto_lama) && !empty($mhs['pas_foto'])) {
                unlink($foto_lama);
            }

            $nama_file_baru = uniqid() . '_' . $nama_file;
            move_uploaded_file($tmp_file, "uploads/" . $nama_file_baru);

            $update = mysqli_query($conn, "UPDATE mahasiswa SET nama='$nama', email='$email', jenis_kelamin='$jk', jurusan='$jurusan', angkatan='$angkatan', hobi='$hobi', pas_foto='$nama_file_baru' WHERE nim='$nim'");
        }
    } else {
        $update = mysqli_query($conn, "UPDATE mahasiswa SET nama='$nama', email='$email', jenis_kelamin='$jk', jurusan='$jurusan', angkatan='$angkatan', hobi='$hobi' WHERE nim='$nim'");
    }

    if (isset($update) && $update) {
        echo "<script>alert('Data berhasil diperbarui!'); window.location='index.php';</script>";
    } else {
        echo "<script>alert('Gagal memperbarui data!');</script>";
    }
}
?>
<!DOCTYPE html>
<html lang="<?php echo $current_lang; ?>">
<head>
    <meta charset="UTF-8">
    <title><?php echo $t['title']; ?></title>
    <style>
        body { font-family: Arial, sans-serif; margin: 30px; background-color: #f9f9f9; }
        .container { width: 500px; background: white; padding: 25px; border-radius: 8px; box-shadow: 0px 0px 10px rgba(0,0,0,0.1); margin: auto; }
        .form-group { margin-bottom: 15px; }
        label { display: block; margin-bottom: 5px; font-weight: bold; }
        input[type="text"], input[type="email"], select { width: 100%; padding: 8px; box-sizing: border-box; border: 1px solid #ccc; border-radius: 4px; }
        input[readonly] { background-color: #e9ecef; cursor: not-allowed; }
        .radio-group, .checkbox-group { margin-top: 5px; }
        button, .btn-back { background-color: #007bff; color: white; padding: 10px 15px; border: none; border-radius: 4px; cursor: pointer; width: 100%; font-size: 16px; text-decoration: none; display: inline-block; text-align: center; box-sizing: border-box; margin-top: 5px; }
        button:hover { background-color: #0056b3; }
        .btn-back { background-color: #6c757d; }
        .btn-back:hover { background-color: #5a6268; }
        .lang-bar { text-align: right; margin-bottom: 15px; }
        .lang-bar a { text-decoration: none; background: #e2e8f0; padding: 5px 10px; border-radius: 4px; color: #333; font-size: 14px; }
        img.preview-foto { width: 60px; height: 60px; object-fit: cover; border-radius: 4px; margin-top: 5px; display: block; }
    </style>
</head>
<body>

<div class="container">
    <div class="lang-bar">
        <a href="edit_mahasiswa.php?nim=<?php echo $nim; ?>&lang=<?php echo $target_lang; ?>"><?php echo $t['switch_lang']; ?></a>
    </div>

    <h2><?php echo $t['heading']; ?></h2>
    
    <form action="" method="POST" enctype="multipart/form-data">
        <div class="form-group">
            <label><?php echo $t['nim']; ?></label>
            <input type="text" name="nim" value="<?php echo htmlspecialchars($mhs['nim']); ?>" readonly>
        </div>
        
        <div class="form-group">
            <label><?php echo $t['nama']; ?></label>
            <input type="text" name="nama" value="<?php echo htmlspecialchars($mhs['nama']); ?>" required>
        </div>
        
        <div class="form-group">
            <label><?php echo $t['email']; ?></label>
            <input type="email" name="email" value="<?php echo htmlspecialchars($mhs['email']); ?>" required>
        </div>

        <div class="form-group">
            <label><?php echo $t['jk']; ?></label>
            <div class="radio-group">
                <input type="radio" name="jenis_kelamin" value="Laki-laki" <?php echo ($mhs['jenis_kelamin'] == 'Laki-laki') ? 'checked' : ''; ?>> <?php echo $t['laki']; ?>
                <input type="radio" name="jenis_kelamin" value="Perempuan" <?php echo ($mhs['jenis_kelamin'] == 'Perempuan') ? 'checked' : ''; ?>> <?php echo $t['perempuan']; ?>
            </div>
        </div>

        <div class="form-group">
            <label><?php echo $t['jurusan']; ?></label>
            <select name="jurusan" required>
                <option value=""><?php echo $t['pilih_jurusan']; ?></option>
                <option value="Teknik Informatika" <?php echo ($mhs['jurusan'] == 'Teknik Informatika') ? 'selected' : ''; ?>>Teknik Informatika</option>
                <option value="Sistem Informasi" <?php echo ($mhs['jurusan'] == 'Sistem Informasi') ? 'selected' : ''; ?>>Sistem Informasi</option>
                <option value="Teknik Komputer" <?php echo ($mhs['jurusan'] == 'Teknik Komputer') ? 'selected' : ''; ?>>Teknik Komputer</option>
            </select>
        </div>

        <div class="form-group">
            <label><?php echo $t['angkatan']; ?></label>
            <input type="text" name="angkatan" value="<?php echo htmlspecialchars($mhs['angkatan']); ?>" required>
        </div>

        <div class="form-group">
            <label><?php echo $t['hobi']; ?></label>
            <div class="checkbox-group">
                <input type="checkbox" name="hobi[]" value="Membaca" <?php echo in_array('Membaca', $hobi_terpilih) ? 'checked' : ''; ?>> <?php echo $t['membaca']; ?><br>
                <input type="checkbox" name="hobi[]" value="Olahraga" <?php echo in_array('Olahraga', $hobi_terpilih) ? 'checked' : ''; ?>> <?php echo $t['olahraga']; ?><br>
                <input type="checkbox" name="hobi[]" value="Coding" <?php echo in_array('Coding', $hobi_terpilih) ? 'checked' : ''; ?>> <?php echo $t['coding']; ?><br>
                <input type="checkbox" name="hobi[]" value="Gaming" <?php echo in_array('Gaming', $hobi_terpilih) ? 'checked' : ''; ?>> <?php echo $t['gaming']; ?><br>
                <input type="checkbox" name="hobi[]" value="Traveling" <?php echo in_array('Traveling', $hobi_terpilih) ? 'checked' : ''; ?>> <?php echo $t['traveling']; ?>
            </div>
        </div>

        <div class="form-group">
            <label><?php echo $t['foto_sekarang']; ?></label>
            <?php if (!empty($mhs['pas_foto'])): ?>
                <img src="uploads/<?php echo htmlspecialchars($mhs['pas_foto']); ?>" class="preview-foto" alt="Foto">
            <?php else: ?>
                <small>Tidak ada foto</small>
            <?php endif; ?>
        </div>

        <div class="form-group">
            <label><?php echo $t['foto_baru']; ?></label>
            <input type="file" name="pas_foto">
        </div>

        <button type="submit"><?php echo $t['submit']; ?></button>
        <a href="index.php" class="btn-back"><?php echo $t['back']; ?></a>
    </form>
</div>

</body>
</html>