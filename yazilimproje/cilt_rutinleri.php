<?php
session_start();

// Kullanıcı oturumu kontrolü
if (!isset($_SESSION['kullanici_id'])) {
    header("Location: login.php");
    exit(); // Yönlendirme sonrası kodun çalışmaması için çıkış yapıyoruz
}

// Veritabanı bağlantısı
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "cilt_bakimi_db";

$conn = new mysqli($servername, $username, $password, $dbname);

// Bağlantı hatası kontrolü
if ($conn->connect_error) {
    die("<div class='error-box'>⚠ Veritabanı bağlantı hatası: " . $conn->connect_error . "</div>");
}

// Kullanıcı ID'sini değişkene al
$kullanici_id = $_SESSION['kullanici_id'];

// Tablonun varlığını kontrol et
$tableCheck = $conn->query("SHOW TABLES LIKE 'cilt_bakim_rutinleri'");
if ($tableCheck->num_rows == 0) {
    die("<div class='error-box'>⚠ 'cilt_bakim_rutinleri' tablosu bulunamadı. Lütfen veritabanını kontrol edin.</div>");
}

// Kullanıcının cilt bakım rutinlerini çekme
$sql = "SELECT * FROM cilt_bakim_rutinleri WHERE kullanici_id = $kullanici_id";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <title>Cilt Bakım Rutinim</title>
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
            padding: 10px 60px;
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
            max-width: 600px;
            margin: auto;
            margin-top: 15vh;
            text-align: center;
        }

        h2 {
            color: #4CAF50;
            margin-bottom: 20px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        th, td {
            border: 1px solid #ddd;
            padding: 8px;
        }

        th {
            background-color: #4CAF50;
            color: #fff;
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
    <button onclick="location.href='cilt_rutinleri.php'">Cilt Bakım Rutinim</button>
    <button onclick="location.href='beslenme.php'">Beslenme Önerileri</button>
    <button onclick="location.href='logout.php'">Çıkış</button>
</div>

<div class="container">
    <button class="geri-don" onclick="history.back()">⬅ Geri Dön</button>

    <h2>Cilt Bakım Rutinim</h2>

    <?php if ($result->num_rows > 0) { ?>
        <table>
            <tr>
                <th>Rutin Adı</th>
                <th>Detay</th>
                <th>Tarih</th>
            </tr>
            <?php while ($row = $result->fetch_assoc()) { ?>
                <tr>
                    <td><?php echo htmlspecialchars($row['rutin_adi']); ?></td>
                    <td><?php echo htmlspecialchars($row['rutin_detay']); ?></td>
                    <td><?php echo htmlspecialchars($row['tarih']); ?></td>
                </tr>
            <?php } ?>
        </table>
    <?php } else { ?>
        <p>📋 Henüz bir cilt bakım rutininiz bulunmamaktadır.</p>
    <?php } ?>
</div>

<!-- Footer -->
<div class="footer">
    © 2025 Cilt Bakımı Sistemi. Tüm hakları saklıdır.
</div>

</body>
</html>

<?php
// Veritabanı bağlantısını kapat
$conn->close();
?>