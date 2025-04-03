<?php
session_start();

// Vérifiez si l'utilisateur est connecté et s'il est un vendeur
if (!isset($_SESSION['user_id']) || $_SESSION['user_role'] !== 'vendeur') {
    // Rediriger vers la page de connexion publique s'il n'est pas authentifié
    header('Location: /public/login.php');
    exit;
}
?>
