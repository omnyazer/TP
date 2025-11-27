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

<body>
    <div class="container mt-5">
        <div class="row">
            <div class="col-md-6 mx-auto">
                <h1>Inscription</h1>

                <?php if (!empty($errors)): ?>
                    <div class="alert alert-danger">
                        <ul>
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

                <form action="" method="post">
                    <div class="mb-3">
                        <label for="pseudo" class="form-label">Pseudo</label>
                        <input type="text" class="form-control" id="pseudo" name="pseudo" value="<?= isset($_POST['pseudo']) ? htmlspecialchars($_POST['pseudo']) : '' ?>">
                    </div>
                    <div class="mb-3">
                        <label for="email" class="form-label">Email</label>
                        <input type="text" class="form-control" id="email" name="email" value="<?= isset($_POST['email']) ? htmlspecialchars($_POST['email']) : '' ?>">
                    </div>
                    <div class="mb-3">
                        <label for="password" class="form-label">Mot de passe</label>
                        <input type="password" class="form-control" id="password" name="password">
                    </div>
                    <div class="mb-3">
                        <label for="password_confirm" class="form-label">Confirmer le mot de passe</label>
                        <input type="password" class="form-control" id="password_confirm" name="password_confirm">
                    </div>
                    <button type="submit" class="btn btn-primary">S'inscrire</button>
                </form>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>
