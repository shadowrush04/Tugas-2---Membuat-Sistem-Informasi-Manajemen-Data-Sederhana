<!DOCTYPE html>
<html lang="id">
<head>
	<meta charset="UTF-8">
	<title>Form PEndaftaran Mahasiswa</title>
	<style>
		body { font-family: Arial, sans-serif; margin: 30px; background-color: #f9f9f9; }
        .container { width: 500px; background: white; padding: 25px; border-radius: 8px; box-shadow: 0px 0px 10px rgba(0,0,0,0.1); }
        .form-group { margin-bottom: 15px; }
        label { display: block; margin-bottom: 5px; font-weight: bold; }
        input[type="text"], input[type="email"], select, textarea { width: 100%; padding: 8px; box-sizing: border-box; border: 1px solid #ccc; border-radius: 4px; }
        textarea { resize: vertical; height: 80px; }
        .radio-group, .checkbox-group { margin-top: 5px; }
        button { background-color: #007bff; color: white; padding: 10px 15px; border: none; border-radius: 4px; cursor: pointer; width: 100%; font-size: 16px; }
        button:hover { background-color: #0056b3; }
	</style>
</head>
<body>

<div class="container">
	<h2>Form Pendaftaran Mahasiswa</h2>
	<form action="proses_pendaftaran.php" method="POST" enctype="multipart/form-data">
	
	<div class="form-group">
        <label>NIM:</label>
        <input type="text" name="nim" required placeholder="Contoh: 10124056">
    </div>
	
	<div class="form-group">
        <label>Nama Lengkap:</label>
        <input type="text" name="nama" required placeholder="Nama lengkap">
    </div>
	
	<div class="form-group">
        <label>Email:</label>
        <input type="email" name="email" required placeholder="email@user.com">
    </div>

    <div class="form-group">
        <label>Jenis Kelamin:</label>
            <div class="radio-group">
                <input type="radio" name="jenis_kelamin" value="Laki-laki" checked> Laki-laki
                <input type="radio" name="jenis_kelamin" value="Perempuan"> Perempuan
            </div>
    </div>

    <div class="form-group">
        <label>Jurusan:</label>
        <select name="jurusan" required>
            <option value="">-- Pilih Jurusan --</option>
            <option value="Teknik Informatika">Teknik Informatika</option>
            <option value="Sistem Informasi">Sistem Informasi</option>
            <option value="Teknik Komputer">Teknik Komputer</option>
        </select>
    </div>

    <div class="form-group">
        <label>Angkatan:</label>
        <input type="text" name="angkatan" value="2026" required>
    </div>

    <div class="form-group">
        <label>Hobi (Pilih minimal satu):</label>
        <div class="checkbox-group">
            <input type="checkbox" name="hobi[]" value="Membaca"> Membaca<br>
            <input type="checkbox" name="hobi[]" value="Olahraga"> Olahraga<br>
            <input type="checkbox" name="hobi[]" value="Coding"> Coding<br>
            <input type="checkbox" name="hobi[]" value="Gaming"> Gaming
			<input type="checkbox" name="hobi[]" value="Traveling"> Traveling
			
        </div>
    </div>

    <div class="form-group">
        <label>Upload Pas Foto (Format: JPG/PNG/GIF, Maks 2MB):</label>
        <input type="file" name="pas_foto" required>
    </div>

        <button type="submit">Daftar Sekarang</button>
    </form>
</div>

</body>
</html>
