<?php
include 'db.php'; // Connexion à la base de données
require 'vendor/autoload.php'; // Chargement des bibliothèques nécessaires


use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

// Vérification si les paramètres nécessaires sont présents dans l'URL
if (!isset($_GET['transaction_id']) || !isset($_GET['name']) || !isset($_GET['prenom']) || !isset($_GET['email']) || !isset($_GET['cost'])) {
    die('Paramètres manquants dans la requête.');
}

// Récupération et sécurisation des données GET
$transactionId = htmlspecialchars($_GET['transaction_id']);
$name = htmlspecialchars($_GET['name']);
$prenom = htmlspecialchars($_GET['prenom']);
$email = htmlspecialchars($_GET['email']);
$cost = (int) $_GET['cost'];

// Génération du chemin du QR code
$qrFile = "qrcodes/ticket_{$name}.png";
if (!file_exists($qrFile)) {
    $qrFile = null; // Si le fichier n'existe pas, définir comme null
}

// Vérification si la transaction est valide
if ($transactionId) {
    // Mise à jour du statut dans la base de données
    $stmt = $pdo->prepare("UPDATE tickets SET status = 'confirmed', transaction_id = ? WHERE email = ? AND cost = ?");
    $stmt->execute([$transactionId, $email, $cost]);

    // Envoi d'un email avec le ticket
    try {
        $mail = new PHPMailer();
        $mail->isSMTP();
        $mail->Host = 'smtp.gmail.com';
        $mail->SMTPAuth = true;
        $mail->Username = 'eventjoy.gala@gmail.com';
        $mail->Password = 'yzheimqshukuqdqj'; // Remplacez par votre mot de passe
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
        $mail->Port = 587;

        $mail->setFrom('eventjoy.gala@gmail.com', 'Gala BCU Organisateur');
        $mail->addAddress($email, "$name $prenom");

        // Ajout d'un contenu personnalisé
        $mail->isHTML(true);
        $mail->Subject = "Confirmation de votre paiement pour le Gala BCU";
        $mail->Body = "
            <h1>Bonjour $name $prenom,</h1>
            <p>Merci pour votre achat ! Voici les détails de votre ticket :</p>
            <ul>
                <li><strong>Transaction ID :</strong> $transactionId</li>
                <li><strong>Montant :</strong> $cost F CFA</li>
            </ul>
            <p>Nous avons hâte de vous accueillir au Gala. À bientôt !</p>
        ";

        // Ajout du QR code en pièce jointe, si disponible
        if ($qrFile && file_exists($qrFile)) {
            $mail->addAttachment($qrFile);
        }

        $mail->send();
    } catch (Exception $e) {
        echo "Erreur lors de l'envoi de l'email : {$mail->ErrorInfo}";
    }
} ?>
<!DOCTYPE html>
<html lang='fr'>
<head>
    <meta charset='UTF-8'>
    <meta name='viewport' content='width=device-width, initial-scale=1.0'>
    <link rel='stylesheet' href='assets/css/bootstrap.min.css'>
    <style>
        body {
            background-color: #002147; /* Bleu nuit */
            color: #FFD700; /* Or */
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
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

        .confirmation-box {
            background-color: #001f3f; /* Bleu nuit plus foncé */
            border: 2px solid #FFD700; /* Or */
            border-radius: 10px;
            padding: 20px;
            text-align: center;
            box-shadow: 0 8px 15px rgba(0, 0, 0, 0.2);
        }

        .confirmation-box h1 {
            font-size: 2rem;
            margin-bottom: 20px;
        }

        .confirmation-box p {
            color: #fff;
            font-size: 1.2rem;
            margin-bottom: 20px;
        }

        .confirmation-box a {
            display: inline-block;
            padding: 10px 20px;
            background-color: #FFD700; /* Or */
            color: #002147; /* Bleu nuit */
            font-weight: bold;
            text-decoration: none;
            border-radius: 5px;
            transition: background-color 0.3s ease, transform 0.2s ease;
        }

        .confirmation-box a:hover {
            background-color: #e6b800; /* Or légèrement plus foncé */
            transform: scale(1.05);
        }
        .qr-section img {
            margin-top: 20px;
            max-width: 200px;
        }
    </style>
    <title>Confirmation de Paiement</title>
    <link rel='stylesheet' href='https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css'>
</head>
<body>
    <div class='container mt-5'>
        <div class='shadow p-4 confirmation-box'>
            <?php if ($transactionId): ?>
                <h1 class='text-success'>Paiement réussi !</h1>
                <p>Merci, <strong><?= htmlspecialchars($name) ?> <?= htmlspecialchars($prenom) ?></strong>. Votre paiement de <strong><?= htmlspecialchars($cost) ?> F CFA</strong> a été confirmé avec succès.</p>
                <p>Un email contenant votre ticket vous a été envoyé à <strong><?= htmlspecialchars($email) ?></strong>.</p>
                <hr>
                <?php if ($qrFile && file_exists("qrcodes/ticket_{$name}.png")): ?>
                    <div class='qr-section'>
                        <img src='<?= htmlspecialchars($qrFile) ?>' alt='QR Code'>
                        <a href='<?= htmlspecialchars($qrFile) ?>' download>Télécharger le code QR</a>
                    </div>
                <?php else: ?>
                    <p>Le code QR n'est pas disponible.</p>
                <?php endif; ?>
                <br><br>
                <a href='index.html' class='btn btn-primary'>Retour à la page d'accueil</a>
            <?php else: ?>
                <h1 class='text-danger'>Paiement échoué</h1>
                <p>Une erreur est survenue lors de la validation de votre paiement.</p>
                <p>Veuillez réessayer ou contacter notre support pour assistance.</p>
                <a href='index.html' class='btn btn-primary'>Retour à la page d'accueil</a>
            <?php endif; ?>
        </div>
    </div>
</body>
</html>