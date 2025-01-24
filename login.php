<?php
session_start();  // Démarre la session

// Vérification si l'utilisateur est déjà connecté
if (isset($_SESSION['user_id'])) {
    header("Location: admin.php");
    exit;
}

include 'db.php'; // Connexion à la base de données

// Si la méthode POST est utilisée pour envoyer le formulaire de connexion
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Récupération des identifiants du formulaire
    $username = htmlspecialchars($_POST['username']);
    $password = htmlspecialchars($_POST['password']);

    // Vérification des identifiants dans la base de données
    $stmt = $pdo->prepare("SELECT * FROM users WHERE username = ?");
    $stmt->execute([$username]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    // Si l'utilisateur existe et que les mots de passe correspondent
    if ($user && $user['password'] == $password) {
        // Créer une session avec l'ID de l'utilisateur
        $_SESSION['user_id'] = $user['id'];
        $_SESSION['username'] = $user['username'];
        // $_SESSION['role'] = $user['role'];

        // Rediriger vers la page d'administration
        header("Location: admin.php");
        exit;
    } else {
        // Message d'erreur en cas d'identifiants incorrects
        $error = "Identifiants incorrects";
    }
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Connexion</title>
    <link rel="stylesheet" href="assets/css/bootstrap.min.css">
    <style>
        body {
            background-color: #f8f9fa;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }

        .login-container {
            background: white;
            padding: 30px;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            width: 100%;
            max-width: 400px;
        }

        h1 {
            margin-bottom: 20px;
        }

        .btn-primary {
            background-color: #343a40;
            border: none;
        }

        .btn-primary:hover {
            background-color: #495057;
        }
    </style>
</head>
<body>
    <div class="login-container">
        <h1 class="text-center">Connexion</h1>
        <?php if (isset($error)): ?>
            <div class="alert alert-danger"><?= $error ?></div>
        <?php endif; ?>
        <form method="POST">
            <div class="mb-3">
                <label for="username" class="form-label">Nom d'utilisateur</label>
                <input type="text" name="username" id="username" class="form-control" required>
            </div>
            <div class="mb-3">
                <label for="password" class="form-label">Mot de passe</label>
                <input type="password" name="password" id="password" class="form-control" required>
            </div>
            <button type="submit" class="btn btn-primary w-100">Se connecter</button>
        </form>
    </div>
</body>
</html>
