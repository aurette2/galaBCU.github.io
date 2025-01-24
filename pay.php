<?php
require 'config.php';

// Récupération des données envoyées via l'URL
if (isset($_GET['ticketDetails'])) {
    $ticketDetails = $_GET['ticketDetails'];
    // json_decode($_GET['ticketDetails'], true);
    // if (json_last_error() !== JSON_ERROR_NONE || !is_array($ticketDetails)) {
    //     die('Les données du ticket sont corrompues ou invalides.');
    // }
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

    <style>
        /* Réinitialisation de marges et padding */
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        /* Full page background */
        body {
            margin: 0;
            padding: 0;
            height: 100vh;
            background: url('assets/images/background.jpeg') no-repeat center center fixed;
            background-size: cover;
            font-family: 'Arial', sans-serif;
            overflow-y: auto;
        }

        /* Overlay for blur effect */
        .overlay {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.5); /* Dark transparent background */
            backdrop-filter: blur(10px); /* Blur effect */
            z-index: 1;
        }
        /* Navbar */
        .navbar-dark .navbar-brand {
            color: #FFD700; /* Or */
        }

        .navbar-dark .nav-link {
            color: #FFD700; /* Or */
        }

        .navbar-dark .nav-link:hover {
            color: #e6b800; /* Or plus foncé */
        }

        /* Centered modal form */
        .form-container {
            position: relative;
            top: 48%;
            left: 50%;
            transform: translate(-50%, -50%);
            background: #002147; /* #ffffff;*/
            border-radius: 8px;
            padding: 30px;
            width: 90%;
            max-width: 500px;
            box-shadow: 0px 4px 6px rgba(0, 0, 0, 0.2);
            z-index: 2;
            margin-top: 100px;
        }

        h1 {
            color: #FFD700;
            font-weight: bold;
            text-align: center;
        }

        label {
            font-weight: bold;
            color: #fff;
        }

        .btn-primary {
            background-color: #FFD700;
            color: #002147;
            font-weight: bold;
            border: none;
        }

        .btn-primary:hover {
            background-color: #e6b800;
        }

        footer {
            position: absolute;
            bottom: 10px;
            width: 100%;
            color: white;
            text-align: center;
            font-size: 14px;
            z-index: 1;
        }

        /* Conteneur principal
        .payment-container {
            background-color: #fff;
            border-radius: 8px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
            padding: 20px;
            width: 100%;
            max-width: 600px;
            text-align: center;
        } */

        /* Titre principal */
        h1 {
            font-size: 24px;
            margin-bottom: 20px;
        }

        /* Montant du paiement */
        p {
            color: #fff;
            font-size: 18px;
            margin-bottom: 30px;
        }

        /* Personnalisation du widget Kkiapay */
        kkiapay-widget {
            margin-top: 20px;
        }
    </style>
</head>
<body>
    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark fixed-top">
        <div class="container-fluid">
            <a class="navbar-brand" href="index.html"><?= SITE_NAME ?></a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item">
                        <a class="nav-link active" aria-current="page" href="index.html">Accueil</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="index.html#about">À propos</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="index.html#contact">Contact</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>
    <!-- Overlay for the blur effect -->
    <div class="overlay"></div>
    <!-- Centered Form -->
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-12 col-md-8 col-lg-6">
                <div class="form-container">
                    <h1>Effectuer votre paiement</h1>
                    <p>Montant à payer : <strong><?= $cost ?> F CFA</strong></p>
                    <div class="text-center">
                    <!-- Widget Kkiapay -->
                    <kkiapay-widget 
                        amount="<?= $cost ?>" 
                        key="134763e0d76111ef9e73d9bd36745045"
                        position="center" 
                        sandbox="true" 
                        callback="https://galabcu.koyeb.app/confirm.php?name=<?= urlencode($name) ?>&prenom=<?= urlencode($prenom) ?>&email=<?= urlencode($email) ?>&cost=<?= $cost ?>">
                    </kkiapay-widget>
                    </div>
                </div>
            </div>
        </div> 
    </div>

     <!-- Footer -->
     <footer>
        &copy; <?= date('Y') ?> <?= SITE_NAME ?>. Tous droits réservés.
    </footer>

    <script src="assets/js/bootstrap.bundle.min.js"></script>
</body>
</html>
