<?php
// Récupération des données envoyées via l'URL
if (isset($_GET['ticketDetails'])) {
    $ticketDetails = json_decode($_GET['ticketDetails'], true);
    if (json_last_error() !== JSON_ERROR_NONE || !is_array($ticketDetails)) {
        die('Les données du ticket sont corrompues ou invalides.');
    }
} else {
    die('Le paramètre ticketDetails est manquant.');
}

// Vérification des données
if (!isset($ticketDetails['id'], $ticketDetails['name'], $ticketDetails['prenom'], $ticketDetails['email'], $ticketDetails['telephone'], $ticketDetails['cost'])) {
    die('Des informations manquent pour effectuer le paiement.');
}

$name = htmlspecialchars($ticketDetails['name']);
$prenom = htmlspecialchars($ticketDetails['prenom']);
$email = htmlspecialchars($ticketDetails['email']);
$cost = htmlspecialchars($ticketDetails['cost']);
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Paiement - <?= $name ?> <?= $prenom ?></title>
    <script src="https://cdn.kkiapay.me/k.js"></script>
</head>
<body>
    <h1>Effectuer votre paiement</h1>
    <p>Montant à payer : <strong><?= $cost ?> F CFA</strong></p>

    <!-- Widget Kkiapay -->
    <kkiapay-widget 
        amount="<?= $cost ?>" 
        key="134763e0d76111ef9e73d9bd36745045"
        position="center" 
        sandbox="true" 
        callback="http://localhost:8000/gala_fev2025/confirm.php?name=<?= urlencode($name) ?>&prenom=<?= urlencode($prenom) ?>&email=<?= urlencode($email) ?>&cost=<?= $cost ?>">
    </kkiapay-widget>
</body>
</html>
