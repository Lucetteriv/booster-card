<?php

include '../config/bootstrap.php';

use App\Database\Database;
Database::getconnection();

session_start();

$estConnecte = isset($_SESSION['user']);

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    
</head>
<body>
    <?php if ($estConnecte): 
        echo 'Bienvenu ' . htmlspecialchars($_SESSION['user']['name'])?>
        <form action="../app/auth/LogOutUser.php" method="post">
            <button type="submit">Déconnexion</button>
        </form>
    <?php else: ?>
        <p>Vous n'êtes pas connecté.</p>
        <a href="auth/register.php">S'inscrire</a> | <a href="auth/login.php">Se connecter</a>
    <?php endif; ?>
</body>
</html>
