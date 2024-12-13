<?php
// Povezivanje sa MySQL bazom
$host = 'localhost';
$dbname = 'restoran';
$username = 'root';
$password = '';
// Kreiranje PDO objekta
try {
$pdo = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
// Postavljanje PDO opcije za izuzetke
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
die("Greška pri povezivanju sa bazom: " . $e->getMessage());
}
?>