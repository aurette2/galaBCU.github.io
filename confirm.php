<?php
include 'db.php'; // Connexion à la base de données
require 'vendor/autoload.php'; // Chargement des bibliothèques nécessaires

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

// Vérification de la transaction via Kkiapay API
$curl = curl_init();
curl_setopt_array($curl, [
    CURLOPT_URL => "https://api.kkiapay.me/api/v1/transactions/status?transactionId=$transactionId",
    CURLOPT_RETURNTRANSFER => true,
    CURLOPT_HTTPHEADER => [
        "Authorization: Bearer 134763e0d76111ef9e73d9bd36745045", // Clé d'authentification
        "Content-Type: application/json"
    ]
]);

$response = curl_exec($curl);
curl_close($curl);

$data = json_decode($response, true);

// Génération du chemin du QR code
$qrFile = "qrcodes/$transactionId.png";
if (!file_exists($qrFile)) {
    $qrFile = null; // Si le fichier n'existe pas, définir comme null
}

// Vérification si la transaction est valide
if ($data && isset($data['status']) && $data['status'] === 'SUCCESS') {
    // Mise à jour du statut dans la base de données
    $stmt = $pdo->prepare("UPDATE tickets SET status = 'paid', transaction_id = ? WHERE email = ? AND cost = ?");
    $stmt->execute([$transactionId, $email, $cost]);

    // Envoi d'un email avec le ticket
    try {
        $mail = new PHPMailer\PHPMailer\PHPMailer();
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

    // Confirmation visuelle
    echo "<html>
    <head>
        <title>Confirmation de Paiement</title>
        <link rel='stylesheet' href='https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css'>
    </head>
    <body class='bg-light'>
        <div class='container mt-5'>
            <div class='card shadow p-4'>
                <h1 class='text-success'>Paiement réussi !</h1>
                <p>Merci, <strong>$name $prenom</strong>. Votre paiement de <strong>$cost F CFA</strong> a été confirmé avec succès.</p>
                <p>Un email contenant votre ticket vous a été envoyé à <strong>$email</strong>.</p>
                <hr>
                <a href='index.php' class='btn btn-primary'>Retour à la page d'accueil</a>
            </div>
        </div>
    </body>
    </html>";
} else {
    // Si la transaction a échoué
    echo "<html>
    <head>
        <title>Échec du Paiement</title>
        <link rel='stylesheet' href='https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css'>
    </head>
    <body class='bg-light'>
        <div class='container mt-5'>
            <div class='card shadow p-4'>
                <h1 class='text-danger'>Paiement échoué</h1>
                <p>Une erreur est survenue lors de la validation de votre paiement.</p>
                <p>Veuillez réessayer ou contacter notre support pour assistance.</p>
                <a href='index.php' class='btn btn-primary'>Retour à la page d'accueil</a>
            </div>
        </div>
    </body>
    </html>";;
    // var_dump($response);
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