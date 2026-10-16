<?php
session_start();

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
        'title' => 'Sistem Pendaftaran Kampus',
        'heading' => 'Login Administrator',
        'username' => 'Nama Pengguna:',
        'password' => 'Kata Sandi:',
        'submit' => 'Masuk',
        'switch_lang' => 'Switch to English',
        'back_form' => 'Kembali ke Form Pendaftaran'
    ],
    'en' => [
        'title' => 'Campus Registration System',
        'heading' => 'Administrator Login',
        'username' => 'Username:',
        'password' => 'Password:',
        'submit' => 'Login',
        'switch_lang' => 'Ubah ke Bahasa Indonesia',
        'back_form' => 'Back to Registration Form'
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
        body { font-family: Arial, sans-serif; margin: 50px; background-color: #f9f9f9; }
        .container { width: 400px; background: white; padding: 25px; border-radius: 8px; box-shadow: 0px 0px 10px rgba(0,0,0,0.1); margin: auto; }
        .form-group { margin-bottom: 15px; }
        label { display: block; margin-bottom: 5px; font-weight: bold; }
        input[type="text"], input[type="password"] { width: 100%; padding: 8px; box-sizing: border-box; border: 1px solid #ccc; border-radius: 4px; }
        button { background-color: #007bff; color: white; padding: 10px 15px; border: none; border-radius: 4px; cursor: pointer; width: 100%; font-size: 16px; }
        button:hover { background-color: #0056b3; }
        .lang-bar { text-align: right; margin-bottom: 15px; }
        .lang-bar a { text-decoration: none; background: #e2e8f0; padding: 5px 10px; border-radius: 4px; color: #333; font-size: 14px; }
        .back-link { text-align: center; margin-top: 15px; }
        .back-link a { color: #007bff; text-decoration: none; font-size: 14px; }
        .back-link a:hover { text-decoration: underline; }
    </style>
</head>
<body>

<div class="container">
    <div class="lang-bar">
        <a href="login.php?lang=<?php echo $target_lang; ?>"><?php echo $t['switch_lang']; ?></a>
    </div>

    <h2><?php echo $t['heading']; ?></h2>
    
    <form action="proses_login.php" method="POST">
        <div class="form-group">
            <label><?php echo $t['username']; ?></label>
            <input type="text" name="username" required placeholder="Masukkan username">
        </div>
        
        <div class="form-group">
            <label><?php echo $t['password']; ?></label>
            <input type="password" name="password" required placeholder="Masukkan password">
        </div>

        <button type="submit"><?php echo $t['submit']; ?></button>
    </form>

    <div class="back-link">
        <a href="form_pendaftaran.php"><?php echo $t['back_form']; ?></a>
    </div>
</div>

</body>
</html>