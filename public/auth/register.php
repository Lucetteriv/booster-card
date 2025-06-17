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

<style>html, body{height: 100%;} .form-container{max-width: 320px;}</style>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.6/dist/js/bootstrap.bundle.min.js" integrity="sha384-j1CDi7MgGQ12Z7Qab0qlWQ/Qqz24Gc6BM0thvEMVjHnfYGF0rmFCozFSxQBxwHKO" crossorigin="anonymous"></script>
    <link href="../../css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="d-flex align-items-center ">
    <div class="w-100 m-auto form-container">
        <div class="text-center">
            <h1>Inscription</h1>
        </div>
        <form method="post">
             <div class="col-12">
                <label for="name" class="form-label mt-4">Nom d'utilisateur:</label>
                <input type="text" class="form-control" id="name" name="name" required>
            </div>
            <div class="col-12" >
                <label for="email" class="form-label mt-4">Email address</label>
                <input type="email" class="form-control" id="email" name="email" aria-describedby="emailHelp" placeholder="Enter email">
                <small id="emailHelp" class="form-text text-muted">We'll never share your email with anyone else.</small>
            </div>
            <div class="col-12">
                <label for="exampleInputPassword1" class="form-label mt-4">Password</label>
                <input type="password" class="form-control" name="password" id="exampleInputPassword1" placeholder="Password" autocomplete="off">
            </div>
            <button type="submit" class="btn btn-primary mt-3 w-100">S'inscrire</button>
        </form>
    </div>
</body>
