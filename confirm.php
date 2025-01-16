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
            padding: 30px;
            text-align: center;
            box-shadow: 0 8px 15px rgba(0, 0, 0, 0.2);
        }

        .confirmation-box h1 {
            font-size: 2.5rem;
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
    </style>
</head>
<body>
    <div class="confirmation-box">
        <h1>Merci pour votre achat !</h1>
        <p>Un email de confirmation vous a été envoyé. Nous avons hâte de vous voir au Gala du 14 Février !</p>
        <a href="index.php">Retour à l'accueil</a>
    </div>
</body>
</html>
