<?php
session_start();
include 'db.php';

// Vérification que l'utilisateur est connecté
if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit;
}

// Vérification de la provenance de la requête
if (!isset($_SERVER['HTTP_REFERER']) || basename($_SERVER['HTTP_REFERER']) !== 'admin.php') {
    die('Accès non autorisé.');
}

// Récupération des informations du ticket à modifier
if (isset($_GET['id'])) {
    $ticketId = intval($_GET['id']);
    $stmt = $pdo->prepare("SELECT * FROM tickets WHERE id = ?");
    $stmt->execute([$ticketId]);
    $ticket = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$ticket) {
        die("Ticket introuvable.");
    }
}

// Mise à jour des informations du ticket
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = htmlspecialchars($_POST['name']);
    $prenom = htmlspecialchars($_POST['prenom']);
    $email = htmlspecialchars($_POST['email']);
    $telephone = htmlspecialchars($_POST['telephone']);
    $type = htmlspecialchars($_POST['type']);
    $preference_vin = htmlspecialchars($_POST['preference_vin']);
    $shooting = htmlspecialchars($_POST['shooting']);
    $status = htmlspecialchars($_POST['status']);

    $stmt = $pdo->prepare("
        UPDATE tickets 
        SET name = ?, prenom = ?, email = ?, telephone = ?, type = ?, preference_vin = ?, shooting = ?, status = ? 
        WHERE id = ?
    ");
    $stmt->execute([$name, $prenom, $email, $telephone, $type, $preference_vin, $shooting, $status, $ticketId]);

    header('Location: admin_dashboard.php');
    exit;
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Modifier Ticket</title>
    <link rel="stylesheet" href="assets/css/bootstrap.min.css">
    <style>
        body {
            background-color:rgb(88, 96, 110);
        }

        .form-container {
            max-width: 600px;
            margin: 0 auto;
            padding: 20px;
            background-color: white;
            border-radius: 8px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }

        .form-label {
            font-weight: bold;
        }

        .form-control[readonly] {
            background-color:rgb(241, 244, 247);
        }
    </style>
</head>
<body>

<div class="container d-flex justify-content-center align-items-center min-vh-100">
    <div class="form-container w-50">
        <h1 class="text-center mb-4">Modifier le ticket</h1>
        <form method="POST">
            <div class="mb-3">
                <label for="name" class="form-label">Nom</label>
                <input type="text" name="name" id="name" class="form-control" value="<?= htmlspecialchars($ticket['name']) ?>" readonly>
            </div>
            <div class="mb-3">
                <label for="prenom" class="form-label">Prénom</label>
                <input type="text" name="prenom" id="prenom" class="form-control" value="<?= htmlspecialchars($ticket['prenom']) ?>" readonly>
            </div>
            <div class="mb-3">
                <label for="email" class="form-label">Email</label>
                <input type="email" name="email" id="email" class="form-control" value="<?= htmlspecialchars($ticket['email']) ?>" readonly>
            </div>
            <div class="mb-3">
                <label for="telephone" class="form-label">Téléphone</label>
                <input type="tel" name="telephone" id="telephone" class="form-control" value="<?= htmlspecialchars($ticket['telephone']) ?>" readonly>
            </div>
            <div class="mb-3">
                <label for="type" class="form-label">Type</label>
                <select name="type" id="type" class="form-select">
                    <option value="Solo" <?= $ticket['type'] === 'Solo' ? 'selected' : '' ?>>Solo</option>
                    <option value="Couple" <?= $ticket['type'] === 'Couple' ? 'selected' : '' ?>>Couple</option>
                </select>
            </div>
            <div class="mb-3">
                <label for="preference_vin" class="form-label">Préférence Vin</label>
                <select name="preference_vin" id="preference_vin" class="form-select">
                    <option value="vin blanc" <?= $ticket['preference_vin'] === 'vin blanc' ? 'selected' : '' ?>>Vin Blanc</option>
                    <option value="vin rouge" <?= $ticket['preference_vin'] === 'vin rouge' ? 'selected' : '' ?>>Vin Rouge</option>
                    <option value="bierre" <?= $ticket['preference_vin'] === 'bierre' ? 'selected' : '' ?>>Bière</option>
                    <option value="sucrerie" <?= $ticket['preference_vin'] === 'sucrerie' ? 'selected' : '' ?>>Sucrerie</option>
                </select>
            </div>
            <div class="mb-3">
                <label for="shooting" class="form-label">Shooting</label>
                <select name="shooting" id="shooting" class="form-select">
                    <option value="no" <?= $ticket['shooting'] === 'no' ? 'selected' : '' ?>>Non</option>
                    <option value="yes" <?= $ticket['shooting'] === 'yes' ? 'selected' : '' ?>>Oui</option>
                </select>
            </div>
            <div class="mb-3">
                <label for="status" class="form-label">Statut</label>
                <select name="status" id="status" class="form-select">
                    <option value="pending" <?= $ticket['status'] === 'pending' ? 'selected' : '' ?>>En attente</option>
                    <option value="confirmed" <?= $ticket['status'] === 'confirmed' ? 'selected' : '' ?>>Confirmé</option>
                    <option value="canceled" <?= $ticket['status'] === 'canceled' ? 'selected' : '' ?>>Annulé</option>
                </select>
            </div>
            <button type="submit" class="btn btn-success w-100">Enregistrer les modifications</button>
        </form>
    </div>
</div>

<script src="assets/js/bootstrap.bundle.min.js"></script>
</body>
</html>
