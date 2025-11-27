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
    <title>connexion</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>
    <div class="container mt-5">
        <div class="row">
            <div class="col-md-6 mx-auto">
                <h1>Connexion</h1>

                <?php if ($loginError): ?>
                    <div class="alert alert-danger"><?= htmlspecialchars($loginError) ?></div>
                <?php endif; ?>

                <?php if ($loginSuccess): ?>
                    <div class="alert alert-success"><?= htmlspecialchars($loginSuccess) ?></div>
                <?php endif; ?>

                <form action="" method="post">
                    <div class="mb-3">
                        <label for="pseudo" class="form-label">Pseudo</label>
                        <input type="text" class="form-control" id="pseudo" name="pseudo" value="<?= isset($_POST['pseudo']) ? htmlspecialchars($_POST['pseudo']) : '' ?>">
                    </div>
                    <div class="mb-3">
                        <label for="password" class="form-label">Mot de passe</label>
                        <input type="password" class="form-control" id="password" name="password">
                    </div>
                    <button type="submit" class="btn btn-primary">Se connecter</button>
                </form>
            </div>
        </div>
        
        

    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>
