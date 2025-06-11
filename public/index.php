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
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.6/dist/js/bootstrap.bundle.min.js" integrity="sha384-j1CDi7MgGQ12Z7Qab0qlWQ/Qqz24Gc6BM0thvEMVjHnfYGF0rmFCozFSxQBxwHKO" crossorigin="anonymous"></script>
    <link href="../css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <nav class="navbar navbar-expand-lg bg-primary" data-bs-theme="light">
  <div class="container-fluid">
    <a class="navbar-brand" href="#">Navbar</a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarColor01" aria-controls="navbarColor01" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarColor01">
      <ul class="navbar-nav me-auto">
        <li class="nav-item">
          <a class="nav-link active" href="#">Home
            <span class="visually-hidden">(current)</span>
          </a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="#">Features</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="#">Pricing</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="#">About</a>
        </li>
        <li class="nav-item dropdown">
          <a class="nav-link dropdown-toggle" data-bs-toggle="dropdown" href="#" role="button" aria-haspopup="true" aria-expanded="false">Dropdown</a>
          <div class="dropdown-menu">
            <a class="dropdown-item" href="#">Action</a>
            <a class="dropdown-item" href="#">Another action</a>
            <a class="dropdown-item" href="#">Something else here</a>
            <div class="dropdown-divider"></div>
            <a class="dropdown-item" href="#">Separated link</a>
          </div>
        </li>
      </ul>
      <?php if ($estConnecte):?>
      <form class="d-flex" action="../app/auth/LogOutUser.php" method="post">
        <button class="btn btn-secondary my-2 my-sm-0" type="submit">Déconnexion</button>
      </form>
      <?php else: ?>
        <button class="btn btn-secondary my-2 my-sm-0" type="submit"><a href="auth/register.php">S'inscrire</a></button> <button class="btn btn-secondary my-2 my-sm-0" type="submit"><a href="auth/login.php">Se connecter</a></button>
      <?php endif; ?>
    </div>
  </div>
</nav>
<?php if ($estConnecte):  echo 'Bienvenu ' . htmlspecialchars($_SESSION['user']['name'])?>

<?php else: ?>
<p>Veuillez vous connecter pour ouvrir les packs.</p>
<?php endif; ?>
</body>
</html>
