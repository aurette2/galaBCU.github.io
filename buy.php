<?php 
include 'db.php';
include 'config.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = $_POST['name'];
    $prenom = $_POST['prenom'];
    $email = $_POST['email'];
    $telephone = $_POST['telephone'];
    $type = $_POST['type'];

    // Enregistrement dans la base de données
    $stmt = $pdo->prepare("INSERT INTO tickets (name, prenom, email, telephone, type, status) VALUES (?, ?, ?, ?, ?, 'pending')");
    $stmt->execute([$name, $prenom, $email, $telephone, $type]);

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
    <style>
        /* Style général */
        body {
            background-color: #002147; /* Bleu nuit */
            color: #FFD700; /* Or */
            font-family: 'Arial', sans-serif;
        }

        /* Navbar */
        .navbar-dark .navbar-brand {
            color: #FFD700;
        }

        .navbar-dark .nav-link {
            color: #FFD700;
        }

        .navbar-dark .nav-link:hover {
            color: #e6b800;
        }

        /* Section Formulaire */
        .container {
            margin-top: 100px;
        }

        h1 {
            color: #FFD700; /* Or */
            font-weight: bold;
        }

        .form-control {
            background-color: #001f3f; /* Bleu nuit foncé */
            border: 1px solid #FFD700;
            color: #fff;
            font-size: 0.9rem; /* Réduction de la taille de police */
            padding: 5px 10px; /* Réduction de l'espace intérieur */
            height: auto; /* Ajuste automatiquement la hauteur selon le contenu */
            width: 50%; /* Réduction de la largeur des champs (optionnel) */
            margin: 0 auto; /* Centrer le champ (optionnel) */
        }

        .form-control::placeholder {
            color: #fff; /* Placeholder en gris clair */
        }

        /* Labels */
        label {
            color: #fff; /* Blanc*/ /* #FFD700;  Or */
            display: block; /* Assure que le label reste au-dessus de l'input */
            margin-bottom: 5px; /* Réduit l'espace sous le label */

        }

        .form-control:focus {
            background-color: #002147;
            border-color: #FFD700;
            box-shadow: 0 0 5px #FFD700;
            color: #fff; /* Blanc */
        }

        .btn-primary {
            background-color: #FFD700; /* Or */
            color: #002147; /* Bleu nuit */
            border: none;
            font-weight: bold;
        }

        .btn-primary:hover {
            background-color: #e6b800; /* Or plus foncé */
        }

        /* Footer */
        footer {
            background-color: #001f3f;
            color: #FFD700;
        }
    </style>
</head>

<body>
    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark fixed-top">
        <div class="container-fluid">
            <a class="navbar-brand" href="index.php"><?= SITE_NAME ?></a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item">
                        <a class="nav-link active" href="index.php">Accueil</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="index.php#about">À propos</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="buy.php">Acheter un ticket</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="index.php#contact">Contact</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>
    <!-- Fin Navbar -->

    <!-- Section d'achat de tickets -->
    <div class="container">
    <h1 class="text-center">Achetez vos tickets</h1>
    <form method="POST">
        <div class="mb-3">
            <label for="name" class="form-label">Nom</label>
            <input type="text" name="name" id="name" class="form-control" required>
        </div>

        <div class="mb-3">
            <label for="prenom" class="form-label">Prénom</label>
            <input type="text" name="prenom" id="prenom" class="form-control" required>
        </div>

        <div class="mb-3">
            <label for="email" class="form-label">Email</label>
            <input type="email" name="email" id="email" class="form-control" required>
        </div>

        <div class="mb-3">
            <label for="telephone" class="form-label">Téléphone</label>
            <input type="text" name="telephone" id="telephone" class="form-control" required>
        </div>

        <div class="mb-3">
            <label for="type" class="form-label">Type de ticket</label>
            <select name="type" id="type" class="form-select form-control" required>
                <option value="Solo">Solo</option>
                <option value="Couple">Couple</option>
            </select>
        </div>

        <div class="text-center">
            <button type="submit" class="btn btn-primary">Valider</button>
        </div>
    </form>
</div>
    <!-- Fin Section d'achat de tickets -->

    <!-- Footer -->
    <footer class="bg-dark text-white text-center py-3 mt-5">
        <p>&copy; <?= date('Y') ?> <?= SITE_NAME ?>. Tous droits réservés.</p>
    </footer>

    <script src="assets/js/bootstrap.bundle.min.js"></script>
</body>

</html>
