<?php

require_once __DIR__ . '/../autoload.php';
SessionManager::start();

$userManager = new UserManager();
$loginError = "";
$loginSuccess = "";

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST["pseudo"], $_POST["password"])) {
    $pseudo = trim($_POST['pseudo']);
    $password = trim($_POST['password']);

    if (!FormValidator::isRequired($pseudo) || !FormValidator::isRequired($password)) {
        $loginError = "Veuillez remplir tous les champs";
    } else {
        $user = $userManager->authenticate($pseudo, $password);

        if ($user) {
            SessionManager::set('logged_in', true);
            SessionManager::set('connected_user', [
                'id'     => $user->getId(),
                'pseudo' => $user->getPseudo(),
                'mail'   => $user->getMail(),
            ]);

            $loginSuccess = "Connexion réussie. Bienvenue, " . htmlspecialchars($user->getPseudo()) . " !";
        } else {
            $loginError = "Pseudo ou mot de passe incorrect";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Connexion</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body class="bg-gradient" style="background: linear-gradient(135deg, #fde68a, #a5b4fc, #f9a8d4); min-height: 100vh;">

    <nav class="navbar navbar-expand-lg navbar-light bg-white bg-opacity-75 shadow-sm">
        <div class="container">
            <a class="navbar-brand fw-bold" href="#" style="color:#6366F1;">Mon Espace</a> 
            <div class="ms-auto">
                <a href="inscription.php" class="btn btn-sm px-3 py-1"
                   style="background-color:#6366F1; border:none; color:#FFFFFF; border-radius:10px;">
                    Inscription
                </a>
            </div>
        </div>
    </nav>

    <div class="container d-flex align-items-center justify-content-center" style="min-height: calc(100vh - 72px);">
        <div class="row w-100">
            <div class="col-md-6 col-lg-5 mx-auto">
                <div class="card shadow border-0 rounded-4" style="background-color: #fdf2ff;">
                    <div class="card-header text-center rounded-top-4" style="background: linear-gradient(135deg, #bfdbfe, #fbcfe8);">
                        <h1 class="h3 mb-0">Se connecter</h1>
                    </div>
                    <div class="card-body p-4">

                        <?php if ($loginError): ?>
                            <div class="alert alert-danger"><?= htmlspecialchars($loginError) ?></div>
                        <?php endif; ?>

                        <?php if ($loginSuccess): ?>
                            <div class="alert alert-success"><?= htmlspecialchars($loginSuccess) ?></div>
                        <?php endif; ?>

                        <form action="" method="post" class="mt-3">
                            <div class="mb-3">
                                <label for="pseudo" class="form-label">Pseudo</label>
                                <input type="text" class="form-control form-control-lg" id="pseudo" name="pseudo"
                                       value="<?= isset($_POST['pseudo']) ? htmlspecialchars($_POST['pseudo']) : '' ?>">
                            </div>
                            <div class="mb-3">
                                <label for="password" class="form-label">Mot de passe</label>
                                <input type="password" class="form-control form-control-lg" id="password" name="password">
                            </div>
                            <button type="submit" class="btn w-100 btn-lg mt-2"
                                    style="background-color:#6366f1; border-color:#6366f1; color:#ffffff;">
                                Se connecter
                            </button>
                        </form>

                        <p class="text-center mt-3 mb-0">
                            Pas encore de compte ?
                            <a href="inscription.php" class="fw-semibold" style="color:#6366f1;">Créer un compte</a>
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>

