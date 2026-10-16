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
        'title' => 'Data Mahasiswa - Sistem Informasi',
        'heading' => 'Daftar Mahasiswa Terdaftar',
        'add_btn' => '+ Tambah Mahasiswa Baru',
        'logout_btn' => 'Keluar',
        'col_no' => 'No',
        'col_nim' => 'NIM',
        'col_nama' => 'Nama Lengkap',
        'col_email' => 'Email',
        'col_jk' => 'Jenis Kelamin',
        'col_jurusan' => 'Jurusan',
        'col_angkatan' => 'Angkatan',
        'col_hobi' => 'Hobi',
        'col_foto' => 'Foto',
        'col_aksi' => 'Aksi',
        'edit' => 'Edit',
        'hapus' => 'Hapus',
        'confirm_hapus' => 'Apakah Anda yakin ingin menghapus data ini?',
        'empty' => 'Belum ada data mahasiswa.',
        'switch_lang' => 'Switch to English'
    ],
    'en' => [
        'title' => 'Student Data - Information System',
        'heading' => 'Registered Students List',
        'add_btn' => '+ Add New Student',
        'logout_btn' => 'Logout',
        'col_no' => 'No',
        'col_nim' => 'Student ID',
        'col_nama' => 'Full Name',
        'col_email' => 'Email',
        'col_jk' => 'Gender',
        'col_jurusan' => 'Major',
        'col_angkatan' => 'Batch',
        'col_hobi' => 'Hobbies',
        'col_foto' => 'Photo',
        'col_aksi' => 'Action',
        'edit' => 'Edit',
        'hapus' => 'Delete',
        'confirm_hapus' => 'Are you sure you want to delete this data?',
        'empty' => 'No student data available.',
        'switch_lang' => 'Ubah ke Bahasa Indonesia'
    ]
];

$t = $lang[$_SESSION['lang']];
$current_lang = $_SESSION['lang'];
$target_lang = ($current_lang == 'id') ? 'en' : 'id';
?>
<!DOCTYPE html>
<html lang="<?php echo $current_lang; ?>">
<head>
    <meta charset="UTF-8">
    <title><?php echo $t['title']; ?></title>
    <style>
        body { font-family: Arial, sans-serif; margin: 30px; background-color: #f9f9f9; }
        .container { width: 90%; max-width: 1100px; background: white; padding: 25px; border-radius: 8px; box-shadow: 0px 0px 10px rgba(0,0,0,0.1); margin: auto; }
        .header-flex { display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px; }
        h2 { margin: 0; }
        .btn { text-decoration: none; padding: 8px 12px; border-radius: 4px; font-size: 14px; color: white; display: inline-block; }
        .btn-primary { background-color: #007bff; }
        .btn-primary:hover { background-color: #0056b3; }
        .btn-danger { background-color: #dc3545; }
        .btn-danger:hover { background-color: #c82333; }
        .btn-warning { background-color: #ffc107; color: #212529; }
        .btn-warning:hover { background-color: #e0a800; }
        .lang-bar { margin-bottom: 15px; text-align: right; }
        .lang-bar a { text-decoration: none; background: #e2e8f0; padding: 5px 10px; border-radius: 4px; color: #333; font-size: 14px; }
        table { width: 100%; border-collapse: collapse; margin-top: 15px; }
        table, th, td { border: 1px solid #ddd; }
        th, td { padding: 10px; text-align: left; font-size: 14px; }
        th { background-color: #f2f2f2; }
        img.foto-mhs { width: 50px; height: 50px; object-fit: cover; border-radius: 4px; }
        .actions { display: flex; gap: 5px; }
    </style>
</head>
<body>

<div class="container">
    <div class="lang-bar">
        <a href="index.php?lang=<?php echo $target_lang; ?>"><?php echo $t['switch_lang']; ?></a>
    </div>

    <div class="header-flex">
        <h2><?php echo $t['heading']; ?></h2>
        <div>
            <a href="form_pendaftaran.php" class="btn btn-primary"><?php echo $t['add_btn']; ?></a>
            <a href="logout.php" class="btn btn-danger" onclick="return confirm('Yakin ingin keluar?');"><?php echo $t['logout_btn']; ?></a>
        </div>
    </div>

    <table>
        <thead>
            <tr>
                <th><?php echo $t['col_no']; ?></th>
                <th><?php echo $t['col_nim']; ?></th>
                <th><?php echo $t['col_nama']; ?></th>
                <th><?php echo $t['col_email']; ?></th>
                <th><?php echo $t['col_jk']; ?></th>
                <th><?php echo $t['col_jurusan']; ?></th>
                <th><?php echo $t['col_angkatan']; ?></th>
                <th><?php echo $t['col_hobi']; ?></th>
                <th><?php echo $t['col_foto']; ?></th>
                <th><?php echo $t['col_aksi']; ?></th>
            </tr>
        </thead>
        <tbody>
            <?php
            $no = 1;
            $query = mysqli_query($conn, "SELECT * FROM mahasiswa ORDER BY nim DESC");
            
            if (mysqli_num_rows($query) > 0) {
                while ($row = mysqli_fetch_assoc($query)) {
                    echo "<tr>";
                    echo "<td>" . $no++ . "</td>";
                    echo "<td>" . htmlspecialchars($row['nim']) . "</td>";
                    echo "<td>" . htmlspecialchars($row['nama']) . "</td>";
                    echo "<td>" . htmlspecialchars($row['email']) . "</td>";
                    echo "<td>" . htmlspecialchars($row['jenis_kelamin']) . "</td>";
                    echo "<td>" . htmlspecialchars($row['jurusan']) . "</td>";
                    echo "<td>" . htmlspecialchars($row['angkatan']) . "</td>";
                    echo "<td>" . htmlspecialchars($row['hobi']) . "</td>";
                    echo "<td><img src='uploads/" . htmlspecialchars($row['pas_foto']) . "' class='foto-mhs' alt='Foto'></td>";
                    echo "<td class='actions'>
                            <a href='edit_mahasiswa.php?nim=" . $row['nim'] . "' class='btn btn-warning'>" . $t['edit'] . "</a>
                            <a href='hapus_mahasiswa.php?nim=" . $row['nim'] . "' class='btn btn-danger' onclick='return confirm(\"" . $t['confirm_hapus'] . "\");'>" . $t['hapus'] . "</a>
                          </td>";
                    echo "</tr>";
                }
            } else {
                echo "<tr><td colspan='10' style='text-align: center;'><strong>" . $t['empty'] . "</strong></td></tr>";
            }
            ?>
        </tbody>
    </table>
</div>

</body>
</html>