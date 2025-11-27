<?php

require_once __DIR__ . '/../autoload.php';
SessionManager::start();

if (!SessionManager::get('logged_in')) {
    header('Location: connexion.php');
    exit;
}

$connectedUser = SessionManager::get('connected_user');
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Profil</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<div class="container mt-5">
    <h1>Mon profil</h1>

    <div class="card">
        <div class="card-body">
            <p><strong>Pseudo :</strong> <?= htmlspecialchars($connectedUser['pseudo']) ?></p>
            <p><strong>Email :</strong> <?= htmlspecialchars($connectedUser['mail']) ?></p>
        </div>
    </div>

    <a href="deconnexion.php" class="btn btn-secondary mt-3">Se déconnecter</a>
</div>
</body>
</html>
