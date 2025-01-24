<?php
// db.php - Connexion à la base de données
// $host = 'localhost'; // Nom du serveur
// $dbname = 'gala_tickets'; // Nom de la base de données
// $username = 'root'; // Nom d'utilisateur MySQL
// $password = ""; // Mot de passe MySQL

// try {
//     $pdo = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);

$host = 'ep-small-silence-a21l43uv.eu-central-1.pg.koyeb.app'; // Database host
$dbname = 'koyebdb'; // Database name
$username = 'koyeb-adm'; // Database username
$password = 'npg_0ZqhBcUTw7WJ'; // Database password
$sslmode = 'require'; // SSL mode

try {
    // DSN for PostgreSQL
    $dsn = "pgsql:host=$host;dbname=$dbname;sslmode=$sslmode";
    // Create a PDO instance
    $pdo = new PDO($dsn, $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION); // Activation des erreurs PDO
    //echo "Connexion réussie à la base de données."; // Message de confirmation
} catch (PDOException $e) {
    die("Erreur de connexion : " . $e->getMessage()); // Gestion des erreurs
}
?>
