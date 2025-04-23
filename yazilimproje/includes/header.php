<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cilt Bakım Uygulaması</title>
    <link rel="stylesheet" href="/css/style.css">
</head>
<body>
<nav>
    <a href="index.php">Ana Sayfa</a>
    <a href="profile.php">Profilim</a>
    <a href="istek_sikayet.php">İstek & Şikayet</a>
    <a href="logout.php">Çıkış</a>
</nav>

    <nav>
    <ul>
        <?php if (isset($_SESSION['kullanici_id'])): ?> 
            <li><a href="profile.php">Profilim</a></li>
            <li><a href="cilt_rutinleri.php">Cilt Bakım Rutini</a></li>
            <li><a href="beslenme_onerileri.php">Beslenme Önerileri</a></li>
            <li><a href="istek_sikayet.php">İstek & Şikayet</a></li>
            <li><a href="logout.php">Çıkış Yap</a></li>
        <?php else: ?>
            <li><a href="login.php">Giriş Yap</a></li>
            <li><a href="register.php">Kayıt Ol</a></li>
        <?php endif; ?>
    </ul>
</nav>