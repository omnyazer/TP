<?php

require_once __DIR__ . '/../autoload.php';
SessionManager::start();

$userManager = new UserManager();

$errors = [];
$success = "";

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST["pseudo"], $_POST["email"], $_POST["password"], $_POST["password_confirm"])) {
    
    $pseudo = trim($_POST['pseudo']);
    $email = trim($_POST['email']);
    $password = trim($_POST['password']);
    $passwordConfirm = trim($_POST['password_confirm']);

    if (!FormValidator::isRequired($pseudo) || !FormValidator::isRequired($email) || !FormValidator::isRequired($password) || !FormValidator::isRequired($passwordConfirm)) {
        $errors[] = "Tous les champs sont requis";
    }

    if (!FormValidator::isEmail($email)) {
        $errors[] = "L'email n'est pas valide";
    }

    if (!FormValidator::minLength($pseudo, 4) || !FormValidator::maxLength($pseudo, 20)) {
        $errors[] = "Le pseudo doit faire entre 4 et 20 caractères";
    }

    if (!FormValidator::minLength($password, 6)) {
        $errors[] = "Le mot de passe doit faire au moins 6 caractères";
    }

    if ($password !== $passwordConfirm) {
        $errors[] = "Les mots de passe ne correspondent pas";
    }

    if (empty($errors) && $userManager->findByPseudo($pseudo)) {
        $errors[] = "Le pseudo est déjà pris";
    }

    if (empty($errors)) {
        $hashedPassword = password_hash($password, PASSWORD_ARGON2I);
        $newUser = new User($pseudo, $email, $hashedPassword);
        
        if ($userManager->insert($newUser)) {
            $success = "Inscription réussie !";
        } else {
            $errors[] = "Erreur lors de l'inscription, veuillez réessayer";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>inscription</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body class="bg-gradient" style="background: linear-gradient(135deg, #fde68a, #a5b4fc, #f9a8d4); min-height: 100vh;">

    <nav class="navbar navbar-expand-lg navbar-light bg-white bg-opacity-75 shadow-sm">
        <div class="container">
            <a class="navbar-brand fw-bold" href="#" style="color:#6366F1;">Mon Espace</a> 
             <div class="ms-auto">
                <a href="connexion.php" class="btn btn-sm px-3 py-1"
                style="background-color:#6366F1; border:none; color:#FFFFFF; border-radius:10px;">
                    Connexion
                </a>
            </div>
        </div>
    </nav>

    <div class="container d-flex align-items-center justify-content-center" style="min-height: calc(100vh - 72px);">
        <div class="row w-100">
            <div class="col-md-6 col-lg-5 mx-auto">
                <div class="card shadow border-0 rounded-4" style="background-color: #fdf2ff;">
                    <div class="card-header text-center rounded-top-4" style="background: linear-gradient(135deg, #bfdbfe, #fbcfe8);">
                        <h1 class="h3 mb-0 text-slate-700">Créer un compte</h1>
                    </div>
                    <div class="card-body p-4">

                        <?php if (!empty($errors)): ?>
                            <div class="alert alert-danger">
                                <ul class="mb-0">
                                    <?php foreach ($errors as $error): ?>
                                        <li><?= htmlspecialchars($error) ?></li>
                                    <?php endforeach; ?>
                                </ul>
                            </div>
                        <?php endif; ?>

                        <?php if ($success): ?>
                            <div class="alert alert-success">
                                <?= htmlspecialchars($success) ?>
                            </div>
                        <?php endif; ?>

                        <form action="" method="post" class="mt-3">
                            <div class="mb-3">
                                <label for="pseudo" class="form-label">Pseudo</label>
                                <input type="text" class="form-control form-control-lg" id="pseudo" name="pseudo"
                                       value="<?= isset($_POST['pseudo']) ? htmlspecialchars($_POST['pseudo']) : '' ?>">
                            </div>
                            <div class="mb-3">
                                <label for="email" class="form-label">Email</label>
                                <input type="text" class="form-control form-control-lg" id="email" name="email"
                                       value="<?= isset($_POST['email']) ? htmlspecialchars($_POST['email']) : '' ?>">
                            </div>
                            <div class="mb-3">
                                <label for="password" class="form-label">Mot de passe</label>
                                <input type="password" class="form-control form-control-lg" id="password" name="password">
                            </div>
                            <div class="mb-3">
                                <label for="password_confirm" class="form-label">Confirmer le mot de passe</label>
                                <input type="password" class="form-control form-control-lg" id="password_confirm" name="password_confirm">
                            </div>
                            <button type="submit" class="btn btn-primary w-100 btn-lg mt-2" style="background-color:#6366f1; border-color:#6366f1;">
                                S'inscrire
                            </button>
                        </form>

                        <p class="text-center mt-3 mb-0">
                            Déjà un compte ?
                            <a href="connexion.php" class="fw-semibold" style="color:#6366f1;">Se connecter</a>
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js"></script>
</body>


</html>
