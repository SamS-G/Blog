<?php


namespace App\src\model;

use App\config\Post;
use DateTime;

class User extends  Model
{
    private int $errors = 0;
    private int $id;
    private string $username;
    private string $password;
    private DateTime $createdAt;
    private int $role;
    private $status;

    /**
     * @return mixed
     */
    public function getStatus()
    {
        return $this->status;
    }

    /**
     * @param mixed $status
     */
    public function setStatus($status)
    {
        $this->status = $status;
    }

    /**
     * @param int $role
     */
    public function setRole(int $role)
    {
        $this->role = $role;
    }

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @param int $id
     */
    public function setId(int $id)
    {
        $this->id = $id;
    }

    /**
     * @return string
     */
    public function getUsername()
    {
        return $this->username;
    }

    /**
     * @param string $username
     */
    public function setUsername(string $username)
    {
        $this->username = $username;
    }

    /**
     * @return string
     */
    public function getPassword(): string
    {
        return $this->password;
    }

    /**
     * @param string $password
     */
    public function setPassword(string $password)
    {
        $this->password = $password;
    }

    /**
     * @return DateTime
     */
    public function getCreatedAt(): DateTime
    {
        return $this->createdAt;
    }

    /**
     * @param DateTime $createdAt
     */
    public function setCreatedAt(DateTime $createdAt)
    {
        $this->createdAt = $createdAt;
    }

    /**
     * Vérifie que les contraintes de longueurs et d'unicité soient respectées pour le nom d'utilisateur
     * @param Post $post
     * @return int|void
     */
    public function validateUsername(Post $post)
    {
        $result = $this->validation->validate('username', $post, 'username');

        if ($result['usernameDuplicate']) {
            $this->session->set('usernameDuplicate', "Nom d'utilisateur déjà utilisé");
            return $this->errors++;
        } elseif ($result['username']['max'] + $result['username']['min'] > 0) {
            $this->session->set('usernameConstraint', "Le nom d'utilisateur ne respect pas les contraintes de longueur");
            return $this->errors++;
        }
    }

    /**
     * Vérifie que les contraintes de longueurs et d'unicité soient respectées pour l'adresse mail
     * @param Post $post
     * @return int|void
     */
    public function validateEmail(Post $post)
    {
        $result = $this->validation->validate('email', $post, 'email');

        if ($result['email']['max'] + $result['email']['min'] > 0) {
            $this->session->set('mailConstraint', "L'email ne respect pas les contraintes, min 5, max 255 caractères");
            return $this->errors++;
        } elseif ($result['emailDuplicate']) {
            $this->session->set('mailDuplicate', "Cet email est déjà utilisé !");
            return $this->errors++;
        }
    }

    /**
     * Vérifie que les contraintes de longueur et de format soient respectées pour le mot de passe
     * @param Post $post
     * @return int|void
     */
    public function validatePassword(Post $post)
    {
        $result = $this->validation->validate('password', $post, 'password');
        if (!empty($result['password']['regex'])) {
            $this->session->set('passwordRegex', "Le mots de passe ne respect pas les contraintes");
            return $this->errors++;
        } elseif ($post->getPostParam('password') != $post->getPostParam('confirm_pass')) {
            $this->session->set('passwordDuplicate', "Les deux mots de passe ne sont pas identiques");
            return $this->errors++;
        }
    }
}