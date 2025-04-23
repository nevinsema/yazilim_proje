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

// Kullanıcı bilgilerini veritabanından çek
$sql = "SELECT * FROM kullanicilar WHERE id = '$kullanici_id'";
$result = $conn->query($sql);
$user = $result->fetch_assoc();

// Cilt tiplerini getir
$cilt_tipleri = $conn->query("SELECT * FROM cilt_tipleri");

// Güncelleme işlemi
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $isim = mysqli_real_escape_string($conn, $_POST['isim']);
    $yas = (int)$_POST['yas'];
    $cilt_tipi_id = (int)$_POST['cilt_tipi'];

    // Şifre değiştirilecek mi?
    if (!empty($_POST['yeni_sifre'])) {
        $sifre = password_hash($_POST['yeni_sifre'], PASSWORD_DEFAULT);
        $sql = "UPDATE kullanicilar SET isim='$isim', yas='$yas', cilt_tipi_id='$cilt_tipi_id', sifre='$sifre' WHERE id='$kullanici_id'";
    } else {
        $sql = "UPDATE kullanicilar SET isim='$isim', yas='$yas', cilt_tipi_id='$cilt_tipi_id' WHERE id='$kullanici_id'";
    }

    if ($conn->query($sql) === TRUE) {
        $_SESSION['isim'] = $isim; // Oturum bilgisini güncelle
        echo "<p>Profiliniz başarıyla güncellendi!</p>";
    } else {
        echo "<p>Hata: " . $conn->error . "</p>";
    }
}
?>

<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <title>Profil Güncelle</title>
</head>
<body>
    <h2>Profilini Güncelle</h2>
    <form method="POST">
        <label>İsim:</label>
        <input type="text" name="isim" value="<?= htmlspecialchars($user['isim']) ?>" required><br>

        <label>Yaş:</label>
        <input type="number" name="yas" min="10" max="100" value="<?= $user['yas'] ?>" required><br>

        <label>Cilt Tipi:</label>
        <select name="cilt_tipi" required>
            <?php while ($row = $cilt_tipleri->fetch_assoc()): ?>
                <option value="<?= $row['id'] ?>" <?= $row['id'] == $user['cilt_tipi_id'] ? 'selected' : '' ?>>
                    <?= $row['tip_adi'] ?>
                </option>
            <?php endwhile; ?>
        </select><br>

        <label>Yeni Şifre (Opsiyonel):</label>
        <input type="password" name="yeni_sifre"><br>

        <button type="submit">Güncelle</button>
    </form>

    <p><a href="profil.php">Profil Sayfasına Dön</a></p>
</body>
</html>
<?php include 'includes/header.php'; ?>
<?php include 'includes/footer.php'; ?>