<?php
// db.php - Connexion à la base de données
$host = 'localhost'; // Nom du serveur
$dbname = 'gala_tickets'; // Nom de la base de données
$username = 'root'; // Nom d'utilisateur MySQL
$password = ''; // Mot de passe MySQL

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION); // Activation des erreurs PDO
} catch (PDOException $e) {
    die("Erreur de connexion : " . $e->getMessage()); // Gestion des erreurs
}
?>
