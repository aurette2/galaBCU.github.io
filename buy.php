<?php 
include 'db.php';
include 'config.php';
require 'vendor/autoload.php'; // Include libraries for QR code and email handling

use Endroid\QrCode\QrCode;
use Endroid\QrCode\Writer\PngWriter;
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = $_POST['name'];
    $prenom = $_POST['prenom'];
    $email = $_POST['email'];
    $telephone = $_POST['telephone'];
    $type = $_POST['type'];

    // Enregistrement dans la base de données
    $stmt = $pdo->prepare("INSERT INTO tickets (name, prenom, email, telephone, type, status) VALUES (?, ?, ?, ?, ?, 'pending')");
    $stmt->execute([$name, $prenom, $email, $telephone, $type]);

    // Récupérer l'ID du ticket inséré
    $ticketId = $pdo->lastInsertId();

    // Vérifier le statut du ticket
    $ticket = $pdo->prepare("SELECT * FROM tickets WHERE id = ?");
    $ticket->execute([$ticketId]);
    $ticketDetails = $ticket->fetch(PDO::FETCH_ASSOC);

    // if ($ticketDetails && $ticketDetails['status'] === 'confirmed') {
        // Générer le QR code
        $qrData = "Ticket ID: {$ticketDetails['id']}\n" .
                  "Name: {$ticketDetails['name']} {$ticketDetails['prenom']}\n" .
                  "Email: {$ticketDetails['email']}\n" .
                  "Telephone: {$ticketDetails['telephone']}\n" .
                  "Type: {$ticketDetails['type']}\n" .
                  "Status: {$ticketDetails['status']}\n" .
                  "Created At: {$ticketDetails['created_at']}";

        $qrCode = new QrCode($qrData);
        $qrCode->setSize(300);
        $writer = new PngWriter();
        $qrFile = "qrcodes/ticket_{$ticketDetails['id']}.png";
        $writer->write($qrCode)->saveToFile($qrFile);

        // Envoyer un email avec le QR code
        // $mail = new PHPMailer(true);
        // try {
        //     // Configuration SMTP
        //     $mail->isSMTP();
        //     $mail->Host = 'smtp.example.com'; // Remplacez par votre hôte SMTP
        //     $mail->SMTPAuth = true;
        //     $mail->Username = 'your-email@example.com'; // Votre email SMTP
        //     $mail->Password = 'your-password'; // Mot de passe SMTP
        //     $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
        //     $mail->Port = 587;

        //     // Destinataire
        //     $mail->setFrom('your-email@example.com', 'Gala Organisateur');
        //     $mail->addAddress($ticketDetails['email'], "{$ticketDetails['name']} {$ticketDetails['prenom']}");

        //     // Pièce jointe : QR code
        //     $mail->addAttachment($qrFile);

        //     // Contenu de l'email
        //     $mail->isHTML(true);
        //     $mail->Subject = 'Confirmation de votre achat de ticket';
        //     $mail->Body    = "<h1>Merci pour votre achat !</h1><p>Voici votre ticket pour le Gala :</p>";
        //     $mail->AltBody = 'Merci pour votre achat !';

        //     $mail->send();
        // } catch (Exception $e) {
        //     echo "Erreur lors de l'envoi de l'email : {$mail->ErrorInfo}";
        // }

        // Rediriger vers la page de confirmation
        header('Location: confirmation.php');
        exit;
    // } else {
    //     // Si le statut n'est pas confirmé, afficher un message ou rediriger
    //     echo "Le statut du ticket est toujours en attente. Veuillez réessayer.";
    //     exit;
    // }
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
            overflow: hidden;
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
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            background: #002147; /* #ffffff;*/
            border-radius: 8px;
            padding: 30px;
            width: 90%;
            max-width: 500px;
            box-shadow: 0px 4px 6px rgba(0, 0, 0, 0.2);
            z-index: 2;
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
                        <a class="nav-link active" aria-current="page" href="index.php">Accueil</a>
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

    <!-- Overlay for the blur effect -->
    <div class="overlay"></div>

    <!-- Centered Form -->
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
                <input type="text" name="telephone" id="telephone" class="form-control" required>
            </div>

            <div class="mb-3">
                <label for="type" class="form-label">Type de ticket</label>
                <select name="type" id="type" class="form-select" required>
                    <option value="Solo">Solo</option>
                    <option value="Couple">Couple</option>
                </select>
            </div>

            <div class="text-center">
                <button type="submit" class="btn btn-primary w-100">Valider</button>
            </div>
        </form>
    </div>

    <!-- Footer -->
    <footer>
        &copy; <?= date('Y') ?> <?= SITE_NAME ?>. Tous droits réservés.
    </footer>

    <script src="assets/js/bootstrap.bundle.min.js"></script>
</body>

</html>
