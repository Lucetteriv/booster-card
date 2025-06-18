<?php

namespace App\Auth;
use PDO;
use App\Auth\AuthHelper;

use App\Database\Database;

class LoginUser{

    private PDO $db;

    public function __construct()
    {
        $this->db = Database::getConnection();
    }

    public function login(string $email, string $password): array
    {
         if (empty($email) || empty($password))
        {
            throw new \InvalidArgumentException("Username and password are required.");
        }

        $sql = "SELECT * FROM users  WHERE email = :email";
        try{
            $stmt = $this->db->prepare($sql);
            $stmt->bindParam(':email', $email, PDO::PARAM_STR);
            $stmt->execute();
            $user = $stmt->fetch(PDO::FETCH_ASSOC);

            if ($user && password_verify($password, $user['password'])) {
                AuthHelper::startSession();
                $_SESSION['user'] = $user;
                return $user;
            }
            else {
                echo 'Invalid password.';
            }
        }
        catch (PDOException $e) {
            // Gérer les erreurs (ex: username déjà pris)
            error_log("Erreur lors de l'enregistrement: " . $e->getMessage());
            return false; // Enregistrement échoué
        }




    }
};