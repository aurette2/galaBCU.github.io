<?php
require 'db.php';
session_start();

// Vérifiez si l'utilisateur est connecté
if (!isset($_SESSION['user_id'])) {
    // Rediriger vers la page de connexion si l'utilisateur n'est pas connecté
    header("Location: login.php");
    exit;
}

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
            background-color: rgb(151, 151, 178);
        }

        .navbar {
            background-color: #343a40;
        }

        .navbar-brand, .navbar-nav .nav-link {
            color: white !important;
        }

        h1 {
            margin: 20px 0;
            font-weight: 700;
            color: #343a40;
        }

        .table-container {
            margin-top: 20px;
            background-color: white;
            border-radius: 10px;
            padding: 20px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        table {
            margin-bottom: 0;
            border-radius: 5px;
            overflow: hidden;
        }

        th {
            background-color: rgb(1, 1, 2);
            color: black;
            text-align: center;
        }

        td {
            text-align: center;
        }

        tr:hover {
            background-color: rgb(222, 157, 157);
        }

        /* Styles supplémentaires pour la table responsive */
        .table-responsive {
            margin-top: 20px;
        }

        .navbar-nav .nav-link {
            font-size: 1rem;
        }

        @media (max-width: 767px) {
            .navbar-nav .nav-link {
                font-size: 0.9rem;
            }

            h1 {
                font-size: 1.5rem;
            }
        }
    </style>
</head>
<body>
    <!-- Navigation bar -->
    <nav class="navbar navbar-expand-lg navbar-dark">
        <div class="container-fluid">
            <a class="navbar-brand" href="#">Admin Gala</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="#">Dashboard</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="logout.php">Déconnexion</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <div class="container">
        <h1 class="text-center">Tableau de bord - Tickets</h1>

        <div class="table-container">
            <!-- Table responsive for smaller screens -->
            <div class="table-responsive">
                <table class="table table-striped table-bordered">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Nom</th>
                            <th>Prénom</th>
                            <th>Email</th>
                            <th>Téléphone</th>
                            <th>Type</th>
                            <th>Préférence Vin</th>
                            <th>Shooting</th>
                            <th>Statut</th>
                            <th>Actions</th>
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
                                <td><?= htmlspecialchars($ticket['preference_vin']) ?></td>
                                <td><?= htmlspecialchars($ticket['shooting']) ?></td>
                                <td><?= htmlspecialchars($ticket['status']) ?></td>
                                <td>
                                    <!-- Bouton Modifier -->
                                    <a href="edit.php?id=<?= $ticket['id'] ?>" class="btn btn-warning btn-sm">Modifier</a>
                                    
                                    <!-- Bouton Supprimer -->
                                    <form method="POST" action="delete.php" style="display:inline;">
                                        <input type="hidden" name="id" value="<?= $ticket['id'] ?>">
                                        <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Êtes-vous sûr de vouloir supprimer ce ticket ?');">Supprimer</button>
                                    </form>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <script src="assets/js/bootstrap.bundle.min.js"></script>
</body>
</html>
