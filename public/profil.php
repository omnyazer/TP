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

<body class="bg-gradient" style="background: linear-gradient(135deg, #fde68a, #a5b4fc, #f9a8d4); min-height: 100vh;">

<nav class="navbar navbar-expand-lg navbar-light bg-white bg-opacity-75 shadow-sm">
    <div class="container">
        <a class="navbar-brand fw-bold" href="#" style="color:#6366F1;">Mon Espace</a>
        <div class="ms-auto">
            <a href="deconnexion.php" class="btn btn-sm px-3 py-1"
               style="background-color:#6366F1; border:none; color:#FFFFFF; border-radius:10px;">
                Se déconnecter
            </a>
        </div>
    </div>
</nav>

<div class="container d-flex align-items-center justify-content-center" style="min-height: calc(100vh - 72px);">
    <div class="row w-100">
        <div class="col-md-6 col-lg-5 mx-auto">
            <div class="card shadow border-0 rounded-4" style="background-color: #fdf2ff;">
                <div class="card-header text-center rounded-top-4"
                     style="background: linear-gradient(135deg, #bfdbfe, #fbcfe8);">
                    <h1 class="h4 mb-0">Mon profil</h1>
                </div>
                <div class="card-body p-4">
                    <p class="mb-2">
                        <strong>Pseudo :</strong>
                        <?= htmlspecialchars($connectedUser['pseudo']) ?>
                    </p>
                    <p class="mb-0">
                        <strong>Email :</strong>
                        <?= htmlspecialchars($connectedUser['mail']) ?>
                    </p>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>

