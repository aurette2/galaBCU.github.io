<?php
include 'db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $type = $_POST['type'];
    $quantity = $_POST['quantity'];

    // Enregistrement dans la base de données
    $stmt = $pdo->prepare("INSERT INTO tickets (name, email, type, quantity, status) VALUES (?, ?, ?, ?, 'pending')");
    $stmt->execute([$name, $email, $type, $quantity]);

    // Redirection après l'insertion
    header('Location: confirm.php');
    exit;
}
?>
<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Achat de tickets - <?= SITE_NAME ?></title>

    <!-- Liens vers les fichiers CSS locaux -->
    <link rel="stylesheet" href="assets/css/bootstrap.min.css"> <!-- Bootstrap local -->
    <link rel="stylesheet" href="assets/css/style.css"> <!-- Votre fichier CSS personnalisé -->

    <!-- Google Fonts (optionnel) -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500;700&display=swap">
</head>

<body>
    <div class="container mt-5">
        <h1 class="text-center">Achetez vos tickets</h1>

        <!-- Formulaire d'achat de tickets -->
        <form method="POST">
            <div class="mb-3">
                <label for="name" class="form-label">Nom</label>
                <input type="text" name="name" id="name" class="form-control" required>
            </div>

            <div class="mb-3">
                <label for="email" class="form-label">Email</label>
                <input type="email" name="email" id="email" class="form-control" required>
            </div>

            <div class="mb-3">
                <label for="type" class="form-label">Type de ticket</label>
                <select name="type" id="type" class="form-select" required>
                    <option value="Solo">Solo</option>
                    <option value="Couple">Couple</option>
                </select>
            </div>

            <div class="mb-3">
                <label for="quantity" class="form-label">Quantité</label>
                <input type="number" name="quantity" id="quantity" class="form-control" required>
            </div>

            <button type="submit" class="btn btn-primary">Valider</button>
        </form>
    </div>

    <!-- Liens vers les fichiers JS locaux -->
    <script src="assets/js/bootstrap.min.js"></script> <!-- Bootstrap JS local -->
    <script src="assets/js/script.js"></script>
</body>

</html>
