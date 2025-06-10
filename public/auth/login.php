<?php
require_once dirname(__DIR__, 2) . "/config/bootstrap.php";
use App\Auth\LoginUser;

$loginUser = new LoginUser();

if ($_SERVER['REQUEST_METHOD'] === 'POST') 
{
    $email = $_POST['email'] ?? '';
    $password = $_POST['password'] ?? '';
     
    try {
        if ($loginUser->login($email, $password)) {
            // Enregistrement réussi
            echo "Connexion réussie!";
            // Redirection vers la page de connexion (à implémenter)
            header("Location:../index.php");
            exit();
        } else {
            // Enregistrement échoué (erreur gérée dans la classe RegisterUser)
            echo "Erreur lors de la connexion. Veuillez réessayer.";
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
    <h1>login</h1>
    <form method="post">

        <div>
            <label for="email">Email :</label>
            <input type="email" id="email" name="email">
        </div>
        <div>
            <label for="password">Mot de passe:</label>
            <input type="password" id="password" name="password" required>
        </div>
        <button type="submit">Se connecter</button>
    </form>
</body>
</html>