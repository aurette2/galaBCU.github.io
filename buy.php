<?php
include 'db.php';
require 'vendor/autoload.php';
require 'config.php';

// Chargement des dépendances pour PHPMailer et QR Code
use Endroid\QrCode\QrCode;
use Endroid\QrCode\Writer\PngWriter;
// use FedaPay\FedaPay; // SDK FedaPay


// Vérification de la méthode POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Récupération et validation des données
    $name = isset($_POST['name']) ? htmlspecialchars($_POST['name']) : null;
    $prenom = isset($_POST['prenom']) ? htmlspecialchars($_POST['prenom']) : null;
    $email = isset($_POST['email']) ? filter_var($_POST['email'], FILTER_VALIDATE_EMAIL) : null;
    $telephone = isset($_POST['telephone']) ? htmlspecialchars($_POST['telephone']) : null;
    $type = isset($_POST['type']) ? htmlspecialchars($_POST['type']) : null;
    $preference_vin = isset($_POST['preference_vin']) ? htmlspecialchars($_POST['preference_vin']) : null;
    $shooting = isset($_POST['shooting']) ? htmlspecialchars($_POST['shooting']) : null;

    if (!$name || !$prenom || !$email || !$telephone || !$type || !$preference_vin || !$shooting) {
        die('Veuillez remplir tous les champs correctement.');
    }

    // Calcul du coût
        $cost = 0;
    if ($type === 'Solo') {
        $cost += 20000;
    } elseif ($type === 'Couple') {
        $cost += 30000;
    }
    if ($shooting === 'yes') {
        $cost += 1000;
    }

    // Insertion dans la base de données
    $stmt = $pdo->prepare("
            INSERT INTO tickets (name, prenom, email, telephone, type, preference_vin, shooting, cost, status)
            VALUES (?, ?, ?, ?, ?, ?, ?, ?, 'pending')
        ");
        $stmt->execute([$name, $prenom, $email, $telephone, $type, $preference_vin, $shooting, $cost]);


    $ticketId = $pdo->lastInsertId();

    // Fetch the ticket details
    $ticket = $pdo->prepare("SELECT * FROM tickets WHERE id = ?");
    $ticket->execute([$ticketId]);
    $ticketDetails = $ticket->fetch(PDO::FETCH_ASSOC);
    // echo''.$ticketDetails['name'].'';
    // Génération du QR code
    // $qrData = "Ticket ID: $ticketId\nName: $name $prenom\nType: $type\nTotal Cost: $cost";
    $qrData = "Ticket ID: {$ticketDetails['id']}\n" .
                    "Name: {$ticketDetails['name']} {$ticketDetails['prenom']}\n" .
                    "Email: {$ticketDetails['email']}\n" .
                    "Telephone: {$ticketDetails['telephone']}\n" .
                    "Type: {$ticketDetails['type']}\n" .
                    "Préférence en vin: {$ticketDetails['preference_vin']}\n" .
                    "Shooting: {$ticketDetails['shooting']} (Coût additionnel: 1000F)\n" .
                    "Total Cost: {$cost}F\n" .
                    "Status: {$ticketDetails['status']}\n" .
                    "Created At: {$ticketDetails['created_at']}";
        
    $qrCode = new QrCode($qrData);
    $writer = new PngWriter();
    $qrDir = 'qrcodes/';
    if (!is_dir($qrDir)) {
        mkdir($qrDir, 0777, true);
    }
    $qrFile = "{$qrDir}ticket_{$name}.png";
    $writer->write($qrCode)->saveToFile($qrFile);

    // Encodage des détails du ticket en JSON avant redirection
    $ticketDetailsJson = json_encode($ticketDetails);
    header("Location: pay.php?ticketDetails=" . urlencode($ticketDetailsJson)."");
    exit();

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
            margin-top:100px ;
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
    </style>
<script src="https://cdn.kkiapay.me/k.js"></script>
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
                        <a class="nav-link" href="buy.php">Acheter un ticket</a>
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
                    <h1>Achetez vos tickets</h1>
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
                            <input type="tel" pattern="[0-9]{10}" name="telephone" id="telephone" 
                                class="form-control" placeholder="0162898017" required>
                        </div>

                        <div class="mb-3">
                            <label for="type" class="form-label">Type de ticket</label>
                            <select name="type" id="type" class="form-select" required>
                                <option value="Solo">Solo</option>
                                <option value="Couple">Couple</option>
                            </select>
                        </div>

                        <div class="mb-3">
                            <label for="preference_vin" class="form-label">Préférence en vin</label>
                            <select name="preference_vin" id="preference_vin" class="form-select" required>
                                <option value="vin blanc">Vin Blanc</option>
                                <option value="vin rouge">Vin Rouge</option>
                                <option value="bierre">Bière</option>
                                <option value="sucrerie">Sucrerie</option>
                            </select>
                        </div>

                        <div class="mb-3">
                            <label for="shooting" class="form-label">Shooting avec l'artiste</label>
                            <select name="shooting" id="shooting" class="form-select" required>
                                <option value="no">Non</option>
                                <option value="yes">Oui (+1000f)</option>
                            </select>
                        </div>
                        <div class="text-center">
                        <button class="kkiapay-widget btn btn-primary w-100" type="submit">Acheter</button>
                        </div>
                    </form>
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