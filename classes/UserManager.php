<?php

class UserManager
{
    protected PDO $pdo;

    public function __construct()
    {
        $this->pdo = Database::getConnection();
    }

    public function findByPseudo(string $pseudo): ?User
    {
        $sql = "SELECT * FROM user WHERE pseudo = :pseudo";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute(['pseudo' => $pseudo]);
        $data = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($data) {
            return new User(
                $data['pseudo'],
                $data['mail'],
                $data['mdp'],
                (int)$data['id']
            );
        }

        return null;
    }

    public function insert(User $user): bool
    {
        $sql = "INSERT INTO user (pseudo, mail, mdp) VALUES (:pseudo, :mail, :mdp)";
        $stmt = $this->pdo->prepare($sql);

        return $stmt->execute([
            'pseudo' => $user->getPseudo(),
            'mail'   => $user->getMail(),
            'mdp'    => $user->getMdp(),
        ]);
    }

    public function authenticate(string $pseudo, string $password): ?User
    {
        $user = $this->findByPseudo($pseudo);
        if ($user && password_verify($password, $user->getMdp())) {
            return $user;
        }
        return null;
    }
}
