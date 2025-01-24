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

// Suppression du ticket
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['id'])) {
    $ticketId = intval($_POST['id']);
    $stmt = $pdo->prepare("DELETE FROM tickets WHERE id = ?");
    $stmt->execute([$ticketId]);

    // Redirection vers admin.php après suppression
    header('Location: admin.php');
    exit;
}
