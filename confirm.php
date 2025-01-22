<?php

// Chargement des fichiers requis
require 'vendor/autoload.php';
require 'config.php';

// Importation des classes nécessaires de PHPMailer
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

// Récupération des données via $_GET et validation
$qrFile = isset($_GET['qrFile']) ? $_GET['qrFile'] : null;
$ticketDetails = isset($_GET['ticketDetails']) ? $_GET['ticketDetails'] : null;

// Vérifiez que les détails du ticket et le fichier QR sont présents
if ($ticketDetails && is_array($ticketDetails)) {
    // Extraction des données du ticket
    $ticketId = $ticketDetails['id'] ?? null;
    $name = $ticketDetails['name'] ?? null;
    $prenom = $ticketDetails['prenom'] ?? null;
    $email = $ticketDetails['email'] ?? null;

    // Validation des champs nécessaires
    if (!$qrFile || !$email || !$name || !$prenom || !$ticketId) {
        die("Erreur : Paramètres manquants ou invalides.");
    }

    // Envoi de l'email avec PHPMailer
    $mail = new PHPMailer(true);
    try {
        $mail->isSMTP();
        $mail->Host = 'smtp.gmail.com';
        $mail->SMTPAuth = true;
        $mail->Username = 'eventjoy.gala@gmail.com'; // Votre email SMTP
        $mail->Password = 'yzheimqshukuqdqj'; // Mot de passe SMTP
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
        $mail->Port = 587;

        $mail->setFrom('eventjoy.gala@gmail.com', 'Gala BCU Organisateur');
        $mail->addAddress($email, "$name $prenom");

        // Ajout du fichier QR en pièce jointe
        if (file_exists($qrFile)) {
            $mail->addAttachment($qrFile);
        } else {
            die("Erreur : Le fichier QR code est introuvable.");
        }

        $mail->isHTML(true);
        $mail->Subject = 'Confirmation de votre achat';
        $mail->Body = "<h1>Merci $name !</h1><p>Voici votre ticket (ID : $ticketId) pour le Gala.</p>";

        $mail->send();
        echo "Email envoyé avec succès à $email.";
    } catch (Exception $e) {
        die("Erreur lors de l'envoi de l'email : {$mail->ErrorInfo}");
    }
} else {
    die("Erreur : Paramètres du ticket manquants ou invalides.");
}
?>


<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Confirmation - Gala</title>
    <link rel="stylesheet" href="assets/css/bootstrap.min.css">
    <style>
        body {
            background-color: #002147; /* Bleu nuit */
            color: #FFD700; /* Or */
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
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
</head>
<body>
    <div class="confirmation-box" style="max-width: 460px; margin: 0 auto;">
        <h1>Merci pour votre achat !</h1>
        <p>Un email de confirmation vous a été envoyé. Nous avons hâte de vous voir au Gala du 14 Février !</p>

        <?php if ($qrFile && file_exists($qrFile)): ?>
            <div class="qr-section">
                <p>Vous pouvez télécharger votre code QR ici :</p>
                <a href="<?= htmlspecialchars($qrFile) ?>" download>Télécharger le code QR</a>
                <img src="<?= htmlspecialchars($qrFile) ?>" alt="QR Code">
            </div>
        <?php else: ?>
            <p>Le code QR n'est pas disponible.</p>
        <?php endif; ?>
            <br><br>
        <a href="index.php">Retour à l'accueil</a>
    </div>
</body>
</html>