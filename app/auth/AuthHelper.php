<?php
// app/auth/AuthHelper.php

namespace App\Auth;

class AuthHelper
{
    /**
     * Démarre la session si elle n'est pas déjà démarrée
     */
    public static function startSession(): void
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
    }

    /**
     * Vérifie si un utilisateur est connecté
     */
    public static function isLoggedIn(): bool
    {
        self::startSession();
        return isset($_SESSION['user']) && !empty($_SESSION['user']) && isset($_SESSION['user']['id']);
    }

    /**
     * Récupère l'ID de l'utilisateur connecté
     */
    public static function getCurrentUserId(): ?int
    {
        self::startSession();
        return $_SESSION['user']['id'] ?? null;
    }

    /**
     * Récupère les informations de l'utilisateur connecté
     */
    public static function getCurrentUser(): ?array
    {
        self::startSession();
        return $_SESSION['user'] ?? null;
    }

    /**
     * Redirige vers la page de connexion si l'utilisateur n'est pas connecté
     */
    public static function requireAuth(): void
    {
        if (!self::isLoggedIn()) {
            header('Location:auth/login.php');
            exit;
        }
    }

    /**
     * Vérifie si la requête est un POST et contient un token CSRF valide
     */
    public static function validatePostRequest(): bool
    {
        return $_SERVER['REQUEST_METHOD'] === 'POST';
    }

    /**
     * Génère un token CSRF
     */
    public static function generateCSRFToken(): string
    {
        self::startSession();
        if (!isset($_SESSION['csrf_token'])) {
            $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
        }
        return $_SESSION['csrf_token'];
    }

    /**
     * Valide un token CSRF
     */
    public static function validateCSRFToken(string $token): bool
    {
        self::startSession();
        return isset($_SESSION['csrf_token']) && hash_equals($_SESSION['csrf_token'], $token);
    }
}