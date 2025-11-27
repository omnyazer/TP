<?php

class User
{
    protected ?int $id = null;
    protected string $pseudo;
    protected string $mail;
    protected string $mdp; 

    public function __construct(string $pseudo, string $mail, string $mdpHash, ?int $id = null)
    {
        $this->id = $id;
        $this->pseudo = $pseudo;
        $this->mail = $mail;
        $this->mdp = $mdpHash;
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getPseudo(): string
    {
        return $this->pseudo;
    }

    public function getMail(): string
    {
        return $this->mail;
    }

    public function getMdp(): string
    {
        return $this->mdp;
    }
}
