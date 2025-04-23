<?php
session_start();
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "cilt_bakimi_db";

$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Bağlantı hatası: " . $conn->connect_error);
}


$kullanici_id = $_SESSION['kullanici_id'];
$mesaj = "";

// Form gönderildiğinde isteği kaydet
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $konu = mysqli_real_escape_string($conn, $_POST['konu']);
    $mesaj_text = mysqli_real_escape_string($conn, $_POST['mesaj']);

    if (!empty($konu) && !empty($mesaj_text)) {
        $sql = "INSERT INTO istek_sikayetler (kullanici_id, konu, mesaj) VALUES ('$kullanici_id', '$konu', '$mesaj_text')";
        if ($conn->query($sql) === TRUE) {
            $mesaj = "Geri bildiriminiz başarıyla gönderildi!";
        } else {
            $mesaj = "Hata: " . $conn->error;
        }
    } else {
        $mesaj = "Lütfen tüm alanları doldurun.";
    }
}

// Kullanıcının önceki istek ve şikayetlerini getir
$son_gonderiler = $conn->query("SELECT konu, mesaj, tarih FROM istek_sikayetler WHERE kullanici_id = '$kullanici_id' ORDER BY tarih DESC");
?>

<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <title>İstek ve Şikayetler</title>
</head>
<body>
    
<button class="geri-don" onclick="history.back()">⬅ Geri Dön</button>
<h2>İstek ve Şikayetlerinizi Bize Ulaştırın</h2>

    <form method="POST">
        <label>Konu:</label>
        <input type="text" name="konu" required><br>

        <label>Mesajınız:</label>
        <textarea name="mesaj" required></textarea><br>

        <button type="submit">Gönder</button>
    </form>

    <p><?= $mesaj ?></p>

    <h3>Önceki Geri Bildirimleriniz</h3>
    <?php if ($son_gonderiler->num_rows > 0): ?>
        <ul>
            <?php while ($row = $son_gonderiler->fetch_assoc()): ?>
                <li><strong><?= htmlspecialchars($row['konu']) ?></strong> - <?= htmlspecialchars($row['mesaj']) ?> (<?= $row['tarih'] ?>)</li>
            <?php endwhile; ?>
        </ul>
    <?php else: ?>
        <p>Henüz bir geri bildiriminiz yok.</p>
    <?php endif; ?>

    <p><a href="profile.php">Profil Sayfasına Dön</a></p>
</body>
</html>
<?php include 'includes/header.php'; ?>
<?php include 'includes/footer.php'; ?>