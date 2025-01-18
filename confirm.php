<?php
// Get the QR code file path from the URL
$qrFile = isset($_GET['qrFile']) ? $_GET['qrFile'] : null;
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