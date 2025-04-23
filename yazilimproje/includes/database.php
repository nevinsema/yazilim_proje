<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "cilt_bakimi_db";

$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Bağlantı hatası: " . $conn->connect_error);
}

session_start(); // Kullanıcı oturumlarını yönetmek için
?>
<?php include 'includes/header.php'; ?>
<?php include 'includes/footer.php'; ?>