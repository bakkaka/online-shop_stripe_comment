<?php
session_start();
require_once '../config/db_connection.php'; // Connexion à la base de données

// Si l'utilisateur est authentifié
if ($user && password_verify($password, $user['password'])) {
    $_SESSION['user_id'] = $user['id'];
    $_SESSION['user_role'] = $user['role'];

    // Rediriger selon le rôle
    if ($user['role'] === 'vendeur') {
        header('Location: /admin/dashboard.php'); // Vendeur accède à l'admin
    } elseif ($user['role'] === 'admin') {
        header('Location: /admin/dashboard.php'); // Admin également
    } else {
        header('Location: /public/index.php'); // Acheteur accède au site public
    }
    exit;
}




if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = $_POST['email'];
    $password = $_POST['password'];

    // Vérifier les identifiants
    $stmt = $pdo->prepare('SELECT * FROM users WHERE email = :email');
    $stmt->execute(['email' => $email]);
    $user = $stmt->fetch();

    if ($user && password_verify($password, $user['password'])) {
        $_SESSION['user_id'] = $user['id'];
        $_SESSION['user_role'] = $user['role'];
        if ($user['role'] === 'admin') {
            header('Location: /admin/dashboard.php');
        } else {
            header('Location: /public/index.php');
        }
        exit;
    } else {
        $error = "Email ou mot de passe incorrect.";
    }
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Connexion</title>
    <link rel="stylesheet" href="/assets/css/bootstrap.min.css">
</head>
<body>
    <div class="container mt-5">
        <h2>Connexion</h2>
        <?php if (isset($error)): ?>
            <div class="alert alert-danger"><?= $error ?></div>
        <?php endif; ?>
        <form method="POST">
            <div class="mb-3">
                <label for="email" class="form-label">Email :</label>
                <input type="email" class="form-control" id="email" name="email" required>
            </div>
            <div class="mb-3">
                <label for="password" class="form-label">Mot de passe :</label>
                <input type="password" class="form-control" id="password" name="password" required>
            </div>
            <button type="submit" class="btn btn-primary">Se connecter</button>
        </form>
        <p class="mt-3">Pas encore de compte ? <a href="register.php">S'inscrire</a></p>
    </div>
</body>
</html>
