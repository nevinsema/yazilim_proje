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

// Kullanıcının mevcut cilt sorunlarını çek
$mevcut_sorunlar = [];
$result = $conn->query("SELECT cilt_sorunu_id FROM kullanici_sorunlari WHERE kullanici_id = '$kullanici_id'");
while ($row = $result->fetch_assoc()) {
    $mevcut_sorunlar[] = $row['cilt_sorunu_id'];
}

// Cilt sorunlarını getir
$cilt_sorunlari = $conn->query("SELECT * FROM cilt_sorunlari");

// Güncelleme işlemi
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Önce eski kayıtları silelim
    $conn->query("DELETE FROM kullanici_sorunlari WHERE kullanici_id = '$kullanici_id'");

    if (isset($_POST['cilt_sorunlari']) && is_array($_POST['cilt_sorunlari'])) {
        foreach ($_POST['cilt_sorunlari'] as $sorun_id) {
            $sorun_id = (int)$sorun_id;
            $conn->query("INSERT INTO kullanici_sorunlari (kullanici_id, cilt_sorunu_id) VALUES ('$kullanici_id', '$sorun_id')");
        }
    }
    echo "<p>Cilt sorunlarınız başarıyla güncellendi!</p>";
}
?>

<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <title>Cilt Sorunlarını Güncelle</title>
</head>
<body>
<button class="geri-don" onclick="history.back()">⬅ Geri Dön</button>

<h2>Cilt Sorunlarını Güncelle</h2>
    <form method="POST">
        <label>Cilt Sorunları (Birden Fazla Seçebilirsiniz):</label><br>
        <select name="cilt_sorunlari[]" multiple required>
            <?php while ($row = $cilt_sorunlari->fetch_assoc()): ?>
                <option value="<?= $row['id'] ?>" <?= in_array($row['id'], $mevcut_sorunlar) ? 'selected' : '' ?>>
                    <?= $row['sorun_adi'] ?>
                </option>
            <?php endwhile; ?>
        </select><br>

        <button type="submit">Güncelle</button>
    </form>

    <p><a href="profile.php">Profil Sayfasına Dön</a></p>
</body>
</html>
<?php include 'includes/header.php'; ?>
<?php include 'includes/footer.php'; ?>