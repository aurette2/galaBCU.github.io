<?php include 'db.php';
include 'config.php';
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
    <title>Achat - <?= SITE_NAME ?></title>
    <link rel="stylesheet" href="assets/css/bootstrap.min.css">
    <link rel="stylesheet" href="assets/css/style.css">
</head>

<body>
    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark fixed-top">
        <div class="container-fluid">
            <a class="navbar-brand" href="#"><?= SITE_NAME ?></a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item">
                        <a class="nav-link active" aria-current="page" href="index.php">Accueil</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#about">À propos</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="buy.php">Acheter un ticket</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#contact">Contact</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>
    <!-- Fin Navbar -->

    <!-- Section d'achat de tickets -->
    <div class="container mt-5 pt-5">
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
    <!-- Fin Section d'achat de tickets -->
    <br>
    <br>    
    <!-- Footer -->
    <footer class="bg-dark text-white text-center py-3">
        <p>&copy; <?= date('Y') ?> <?= SITE_NAME ?>. Tous droits réservés.</p>
    </footer>
    <script src="assets/js/bootstrap.bundle.min.js"></script>
</body>

</html>