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
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.6/dist/js/bootstrap.bundle.min.js" integrity="sha384-j1CDi7MgGQ12Z7Qab0qlWQ/Qqz24Gc6BM0thvEMVjHnfYGF0rmFCozFSxQBxwHKO" crossorigin="anonymous"></script>
    <link href="../../css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <h1>login</h1>
    <div class="container">
        <form method="post">
            <div>
                <label for="exampleInputEmail1" class="form-label mt-4">Email address</label>
                <input type="email" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" placeholder="Enter email">
                <small id="emailHelp" class="form-text text-muted">We'll never share your email with anyone else.</small>
            </div>
            <div>
                <label for="exampleInputPassword1" class="form-label mt-4">Password</label>
                <input type="password" class="form-control" id="exampleInputPassword1" placeholder="Password" autocomplete="off">
            </div>
            <button type="button" class="btn btn-primary">Se connecter</button>
        </form>
    </div>
</body>
</html>