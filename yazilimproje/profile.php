<!DOCTYPE html>
<?php
session_start();
if (!isset($_SESSION['kullanici_id'])) {
    echo "<script>alert('Profilinize erişmek için giriş yapmalısınız!'); window.location.href = 'login.php';</script>";
    exit();
}
?>

<?php

require 'includes/database.php';

if (!isset($_SESSION['kullanici_id'])) {
    header("Location: login.php");
    exit();
}
session_start();
if (!isset($_SESSION['kullanici_id'])) {
    header("Location: login.php");
    exit();
}

echo "<h2>Hoş geldin, " . $_SESSION['isim'] . "!</h2>";
echo "<p><a href='logout.php'>Çıkış Yap</a></p>";
echo "<p><a href='profil_guncelle.php'>Bilgilerimi Güncelle</a></p>";
echo "<p><a href='cilt_sorunlari_guncelle.php'>Cilt Sorunlarını Güncelle</a></p>";
echo "<p><a href='cilt_rutinleri.php'>Cilt Bakım Rutinlerini Yönet</a></p>";
echo "<p><a href='beslenme_onerileri.php'>Cilt Tipime Uygun Beslenme Önerileri</a></p>";
echo "<p><a href='istek_sikayet.php'>İstek ve Şikayetlerimi Bildir</a></p>";

?>
<?php include 'includes/header.php'; ?>
<?php include 'includes/footer.php'; ?>
<?php
require 'includes/database.php';

if (!isset($_SESSION['kullanici_id'])) {
    header("Location: login.php");
    exit();
}
?>
<?php
session_start();
if (!isset($_SESSION['kullanici_id'])) {
    header("Location: login.php"); // Kullanıcı giriş yapmadıysa giriş sayfasına yönlendir
    exit();
}
?>