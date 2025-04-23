<?php
session_start();
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "cilt_bakimi_db";

// Veritabanı bağlantısını oluştur
$conn = new mysqli($servername, $username, $password, $dbname);

// Bağlantı hatasını kontrol et
if ($conn->connect_error) {
    die("<div class='error-box'>⚠ Bağlantı hatası: " . $conn->connect_error . "</div>");
}

$hataMesaji = ""; // Kullanıcıya gösterilecek hata mesajı

// POST isteği kontrolü
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $sifre = $_POST['sifre'];

    // Kullanıcıyı veritabanından çek
    $sql = "SELECT * FROM kullanicilar WHERE email = '$email'";
    $result = $conn->query($sql);

    // SQL hatasını kontrol et
    if (!$result) {
        $hataMesaji = "⚠ Sistemde bir hata oluştu. Lütfen daha sonra tekrar deneyin.";
        error_log("SQL Hatası: " . mysqli_error($conn)); // Hatayı log dosyasına kaydet
    } else {
        // Kullanıcı var mı kontrol et
        if ($result->num_rows == 1) {
            $user = $result->fetch_assoc();
            if (password_verify($sifre, $user['sifre'])) {
                $_SESSION['kullanici_id'] = $user['id'];
                $_SESSION['isim'] = $user['isim'];
                header("Location: profil.php"); // Başarılı girişte yönlendirme
                exit();
            } else {
                $hataMesaji = "⚠ Hatalı şifre!";
            }
        } else {
            $hataMesaji = "⚠ Böyle bir kullanıcı bulunamadı!";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <title>Giriş Yap</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: rgba(239, 239, 244, 0.82);
            background-image: url('img/arkaplan9 (1).png');
            background-size: cover;
            background-position: center;
            background-repeat: no-repeat;
            display: flex;
            flex-direction: column;
            height: 100vh;
            margin: 0;
            justify-content: flex-start;
        }

        .top-buttons {
            display: flex;
            justify-content: space-around;
            background-color: rgba(187, 182, 198, 0.8);
            padding: 10px;
            position: relative;
        }

        .top-buttons button {
            background-color: #fff;
            color: rgb(67, 132, 185);
            padding: 10px 30px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            width: auto;
        }

        .top-buttons button:hover {
            background-color: #1976D2;
            color: #fff;
        }

        .container {
            background-color: #ffffff;
            padding: 30px;
            border-radius: 15px;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.2);
            width: 100%;
            max-width: 400px;
            margin: auto;
            margin-top: 15vh;
            text-align: center;
        }

        h2 {
            color: #4CAF50;
            margin-bottom: 20px;
        }

        input, button {
            width: 100%;
            padding: 10px;
            margin: 8px 0;
            border: 1px solid #ddd;
            border-radius: 5px;
            box-sizing: border-box;
            background-color: rgb(255, 125, 45);
            color: #fff;
            font-weight: bold;
        }

        input {
            background-color: #fff;  /* Beyaz arka plan */
            color: #000;             /* Siyah metin */
        }

        button:hover {
            background-color: #1976D2;
        }

        .geri-don {
            background-color: rgb(255, 125, 45);
            color: #fff;
            border: none;
            padding: 8px 15px;
            border-radius: 5px;
            cursor: pointer;
            margin-bottom: 20px;
        }

        .geri-don:hover {
            background-color: #1976D2;
        }

        .footer {
            background-color: #333;
            color: #fff;
            text-align: center;
            padding: 10px 0;
            width: 100%;
            position: fixed;
            bottom: 0;
        }
    </style>
</head>
<body>

<!-- Üst Menü -->
<div class="top-buttons">
    <button onclick="location.href='anasayfa.php'">Ana Sayfa</button>
    <button onclick="location.href='profil.php'">Profilim</button>
    <button onclick="location.href='istek_sikayet.php'">İstek & Şikayet</button>
    <button onclick="location.href='cilt_bakim_rutinim.php'">Cilt Bakım Rutinim</button>
    <button onclick="location.href='beslenme_onerileri.php'">Beslenme Önerileri</button>
    <button onclick="location.href='logout.php'">Çıkış</button>
</div>

<div class="container">
    <button class="geri-don" onclick="history.back()">⬅ Geri Dön</button>

    <h2>Giriş Yap</h2>

    <?php if (!empty($hataMesaji)) { ?>
        <div class="error-box"><?php echo $hataMesaji; ?></div>
    <?php } ?>

    <form method="POST">
        <label for="email">E-posta:</label>
        <input type="email" id="email" name="email" required><br>

        <label for="sifre">Şifre:</label>
        <input type="password" id="sifre" name="sifre" required><br>

        <button type="submit">GİRİŞ</button>
    </form>
</div>

<!-- Footer -->
<div class="footer">
    © 2025 Cilt Bakımı Sistemi. Tüm hakları saklıdır.
</div>

</body>
</html>