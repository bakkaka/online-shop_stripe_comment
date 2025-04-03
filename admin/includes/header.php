<?php
session_start();

// Vérifiez si l'utilisateur est authentifié et s'il a le rôle "admin"
if (!isset($_SESSION['user_role']) || $_SESSION['user_role'] !== 'admin') {
    header('Location: /public/login.php'); // Redirige vers la page de connexion
    exit;
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="/assets/css/bootstrap.min.css">
    <link rel="stylesheet" href="/assets/css/admin.css">
    <title>Administration</title>
</head>
<body>
    <header class="navbar navbar-expand-lg navbar-dark bg-dark">
        <div class="container-fluid">
            <a class="navbar-brand" href="/admin/dashboard.php">AdminPanel</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#adminNavbar" aria-controls="adminNavbar" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="adminNavbar">
                <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                    <li class="nav-item">
                        <a class="nav-link" href="/admin/products.php">Produits</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="/admin/categories.php">Catégories</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="/admin/materials.php">Matériaux</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="/admin/users.php">Utilisateurs</a>
                    </li>
                </ul>
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item">
                        <a class="nav-link text-danger" href="/public/logout.php">Déconnexion</a>
                    </li>
                </ul>
            </div>
        </div>
    </header>
    <main class="container mt-4">
