<?php
include 'db.php';

// Récupération des données de la table tickets
$stmt = $pdo->query("SELECT * FROM tickets");
$tickets = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Administration - Gala</title>
    <link rel="stylesheet" href="assets/css/bootstrap.min.css">
    <style>
        body {
            background-color: #f8f9fa;
        }

        h1 {
            margin-bottom: 20px;
        }

        table {
            background-color: white;
            border-radius: 5px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }

        th {
            background-color: #343a40;
            color: white;
        }
    </style>
</head>
<body>
<div class="container mt-5">
    <h1 class="text-center">Tableau de bord - Tickets</h1>
    <table class="table table-striped table-bordered">
        <thead>
            <tr>
                <th>ID</th>
                <th>Nom</th>
                <th>Prénom</th>
                <th>Email</th>
                <th>Téléphone</th>
                <th>Type</th>
                <th>Statut</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($tickets as $ticket): ?>
                <tr>
                    <td><?= htmlspecialchars($ticket['id']) ?></td>
                    <td><?= htmlspecialchars($ticket['name']) ?></td>
                    <td><?= htmlspecialchars($ticket['prenom']) ?></td>
                    <td><?= htmlspecialchars($ticket['email']) ?></td>
                    <td><?= htmlspecialchars($ticket['telephone']) ?></td>
                    <td><?= htmlspecialchars($ticket['type']) ?></td>
                    <td><?= htmlspecialchars($ticket['status']) ?></td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>
</body>
</html>
