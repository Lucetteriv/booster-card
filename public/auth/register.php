<?php

require_once dirname(__DIR__, 2) . "/config/bootstrap.php";
use App\Auth\RegisterUser;

$registerUser = new RegisterUser();

if ($_SERVER['REQUEST_METHOD'] === 'POST') 
{
    $name = $_POST['name'] ?? '';
    $password = $_POST['password'] ?? '';
    $email = $_POST['email'] ?? ''; 
    try {
        if ($registerUser->register($name, $password, $email)) {
            // Enregistrement réussi
            echo "Inscription réussie!";
            // Redirection vers la page de connexion (à implémenter)
            header("Location:login.php");
            exit();
        } else {
            // Enregistrement échoué (erreur gérée dans la classe RegisterUser)
            echo "Erreur lors de l'inscription. Veuillez réessayer.";
        }
    } catch (\InvalidArgumentException $e) {
        echo "Erreur de validation: " . $e->getMessage();
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
     
</head>
<body>
    <h1>registration</h1>
    <form method="post">
        <div>
            <label for="name">Nom d'utilisateur:</label>
            <input type="text" id="name" name="name" required>
        </div>
        <div>
            <label for="password">Mot de passe:</label>
            <input type="password" id="password" name="password" required>
        </div>
        <div>
            <label for="email">Email :</label>
            <input type="email" id="email" name="email">
        </div>
        <button type="submit">S'inscrire</button>
    </form>
</body>
</html>