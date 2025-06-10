<?php

namespace App\Auth;
use PDO;

use App\Database\Database;

class RegisterUser{


    private PDO $db;

    public function __construct()
    {
        $this->db = Database::getConnection();
    }

    public function register(string $name, string $password, string $email = null) : bool
    {
        if (empty($name) || empty($password) || empty($email)) 
        {
            throw new \InvalidArgumentException("Username, email and password are required.");
        }

        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

        $timestamp = date('Y-m-d H:i:s');

        $sql = "INSERT INTO users (name, password, email, created_at) VALUES (:name, :password, :email, :created_at)";
        try {
            $stmt = $this->db->prepare($sql);
            $stmt->bindParam(':name', $name, PDO::PARAM_STR);
            $stmt->bindParam(':password', $hashedPassword, PDO::PARAM_STR);
            $stmt->bindParam(':email', $email, PDO::PARAM_STR); 
            $stmt->bindParam(':created_at', $timestamp);
            $stmt->execute();
            return true; // Enregistrement réussi
        } catch (PDOException $e) {
            // Gérer les erreurs (ex: username déjà pris)
            error_log("Erreur lors de l'enregistrement: " . $e->getMessage());
            return false; // Enregistrement échoué
        }
    }
}

