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

// Oturum kontrolü
if (!isset($_SESSION['kullanici_id'])) {
    die("Hata: Kullanıcı oturumda bulunamadı.");
}
$kullanici_id = $_SESSION['kullanici_id'];

// Kullanıcının cilt tipini güvenli şekilde çekme
$stmt = $conn->prepare("SELECT cilt_tipi_id FROM kullanicilar WHERE id = ?");
$stmt->bind_param("i", $kullanici_id);
$stmt->execute();
$result = $stmt->get_result();
$row = $result->fetch_assoc();
$cilt_tipi_id = $row['cilt_tipi_id'] ?? null;
$stmt->close();

if (!$cilt_tipi_id) {
    die("Hata: Kullanıcının cilt tipi belirlenemedi.");
}

// Cilt tipine göre beslenme önerilerini güvenli şekilde çekme
$stmt = $conn->prepare("SELECT oneri_metni FROM beslenme_onerileri WHERE cilt_tipi_id = ?");
$stmt->bind_param("i", $cilt_tipi_id);
$stmt->execute();
$oneriler = $stmt->get_result();
$stmt->close();
?>

<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <title>Beslenme Önerileri</title>
</head>
<body>

<?php include 'includes/header.php'; ?>

<button class="geri-don" onclick="history.back()">⬅ Geri Dön</button>

<h2>Cilt Tipinize Göre Beslenme Önerileri</h2>

<?php if ($oneriler->num_rows > 0): ?>
    <ul>
        <?php while ($row = $oneriler->fetch_assoc()): ?>
            <li><?= htmlspecialchars($row['oneri_metni']) ?></li>
        <?php endwhile; ?>
    </ul>
<?php else: ?>
    <p>Bu cilt tipi için beslenme önerisi bulunamadı.</p>
<?php endif; ?>

<p><a href="profile.php">Profil Sayfasına Dön</a></p>

<?php include 'includes/footer.php'; ?>

</body>
</html>
