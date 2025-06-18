<<<<<<< HEAD
<?php 
include '../config/bootstrap.php';
use App\Class\Collection;

$collection = new Collection();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
     if($_POST['booster']){
        $booster = json_decode($_POST['booster'], true);
        try{
              $collection->Store($booster);
        } catch (\InvalidArgumentException $e) {
               echo "Erreur de validation: " . $e->getMessage();
           }
     } else {
        echo "Aucun booster trouvé.";
        exit();
     }
    
 }


$estConnecte = isset($_SESSION['user']);

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $booster = $_POST['booster'];
        }

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.6/dist/js/bootstrap.bundle.min.js" integrity="sha384-j1CDi7MgGQ12Z7Qab0qlWQ/Qqz24Gc6BM0thvEMVjHnfYGF0rmFCozFSxQBxwHKO" crossorigin="anonymous"></script>
    <link href="../css/bootstrap.min.css" rel="stylesheet">
    <link href="../css/card.css" rel="stylesheet">
    <script src="../js/cards.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/gsap@3.13.0/dist/gsap.min.js"></script>

</head>
<body>
    <nav class="navbar navbar-expand-lg bg-primary" data-bs-theme="light">
  <div class="container-fluid">
    <a class="navbar-brand" href="#">Booster</a>
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
        <?php if ($estConnecte):?>
        <li class="nav-item">
          <a class="nav-link" href="../public/collection.php">Collection</a>
        </li>
        <?php else:?>
        <li class="nav-item">
          <a class="nav-link" href="../public/index.php">Collection</a>
        </li>
          <?php endif ?>
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

<?php if ($estConnecte):  echo 'Collection de ' . htmlspecialchars($_SESSION['user']['name']);?>
<?php endif; ?>
<div class="container vh-100">
  <div class="row justify-content-center align-items-center h-100">
    <div class="col-3 position-relative">
      <?php $i = 9; ?>
      <?php foreach($booster as $card):?>
        <div class="card <?= Collection::Store($booster[$key])?>" id="card">
          <div class="top-card">
            <p><?= $card['name']['fr'];?></p>
            <div class="stat">
              </div>
              <div class="top-type">
              <p class="pv"><small>PV</small><?= $card['stats']['hp'];?></p>
              <?php foreach($card['types'] as $type):?>
                <?php $types = $type['name']?>
                <img class="type" src="<?= $type['image'];?>" alt="image">
              <?php endforeach; ?>
            </div>
          </div>
          <div class="image">
            <img src="<?= $card['sprites']['regular'];?>" alt="image">
          </div>
          <div class="bottom-card">
            <div class="stat">
              <p>Points d'attaque</p>
              <p><?= $card['stats']['atk'];?></p>
            </div>
            <div class="stat">
              <p>Points de defense</p>
              <p><?= $card['stats']['def'];?></p>
            </div>
            <div class="stat">
              <p>Attaque speciale</p>
              <p><?= $card['stats']['spe_atk'];?></p>
            </div>
            <div class="stat">
              <p>Defence speciale</p>
              <p><?= $card['stats']['spe_def'];?></p>
            </div>
            <div class="stat">
              <p>Vitesse</p>
              <p><?= $card['stats']['vit'];?></p>
            </div>
          </div>
          <p><?= $card['category'];?></p>
        </div>
        <?php $i--; ?>
      <?php endforeach; ?>
      
=======
<?php
// public/collection.php

require_once '../config/bootstrap.php';

use App\Auth\AuthHelper;
use App\Class\Collection;

// Vérifier que l'utilisateur est connecté
AuthHelper::requireAuth();

$collection = new Collection();
$userCards = $collection->getUserCollection(AuthHelper::getCurrentUserId());
$totalCards = $collection->getUserCollectionCount(AuthHelper::getCurrentUserId());
$currentUser = AuthHelper::getCurrentUser();
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ma Collection - Pokémon TCG</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .card-pokemon {
            transition: transform 0.3s;
            height: 100%;
        }
        .card-pokemon:hover {
            transform: scale(1.05);
        }
        .card-image {
            height: 300px;
            object-fit: contain;
        }
        .rarity-badge {
            position: absolute;
            top: 10px;
            right: 10px;
        }
        .quantity-badge {
            position: absolute;
            top: 10px;
            left: 10px;
            background: rgba(0,0,0,0.8);
            color: white;
        }
    </style>
</head>
<body class="bg-light">
<nav class="navbar navbar-expand-lg navbar-dark bg-primary">
        <div class="container">
            <a class="navbar-brand" href="./index.php">Pokémon TCG</a>
            <div class="navbar-nav ms-auto">
                <?php if (!AuthHelper::isLoggedIn()): ?>
                  <a class="nav-link" href="./auth/login.php">Connexion</a>
                  <a class="nav-link" href="./auth/register.php">Inscription</a>
                  <?php else: ?>
                    <span class="navbar-text me-3">Bonjour, <?= htmlspecialchars($currentUser['name']) ?></span>
                    <a class="nav-link" href="./index.php">Ouvrir un Booster</a>
                    <a class="nav-link active" href="./collection.php">Ma Collection</a>
                    <a class="nav-link" href="./auth/logout.php">Déconnexion</a>
                <?php endif; ?>
            </div>
        </div>
    </nav>

    <div class="container mt-4">
        <div class="row">
            <div class="col-12">
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <h1>Ma Collection</h1>
                    <div class="text-muted">
                        <strong><?= $totalCards ?></strong> cartes au total
                    </div>
                </div>

                <?php if (empty($userCards)): ?>
                    <div class="text-center py-5">
                        <h3 class="text-muted">Votre collection est vide</h3>
                        <p>Ouvrez votre premier booster pour commencer votre collection !</p>
                        <a href="../index.php" class="btn btn-primary">Ouvrir un Booster</a>
                    </div>
                <?php else: ?>
                    <div class="row">
                        <?php foreach ($userCards as $card): ?>
                            <div class="col-lg-3 col-md-4 col-sm-6 mb-4">
                                <div class="card card-pokemon">
                                    <div class="position-relative">
                                        <img src="<?= htmlspecialchars($card['image_url']) ?>"
                                             class="card-img-top card-image"
                                             alt="<?= htmlspecialchars($card['name']) ?>">

                                        <?php if ($card['quantity'] > 1): ?>
                                            <span class="badge quantity-badge">x<?= $card['quantity'] ?></span>
                                        <?php endif; ?>

                                        <?php if (!empty($card['rarity'])): ?>
                                            <span class="badge bg-warning rarity-badge">
                                                <?= htmlspecialchars($card['pokemon_category']) ?>
                                            </span>
                                        <?php endif; ?>
                                    </div>

                                    <div class="card-body">
                                        <h5 class="card-title"><?= htmlspecialchars($card['name']) ?></h5>

                                        <?php if (!empty($card['pokemon_category'])): ?>
                                            <p class="card-text">
                                                <small class="text-muted">
                                                    <?= htmlspecialchars($card['pokemon_category']) ?>
                                                </small>
                                            </p>
                                        <?php endif; ?>

                                        <?php if (!empty($card['hp'])): ?>
                                            <div class="mb-2">
                                                <span class="badge bg-danger">HP: <?= $card['hp'] ?></span>
                                            </div>
                                        <?php endif; ?>

                                        <?php
                                        $types = json_decode($card['types'], true);
                                        if (!empty($types)):
                                        ?>
                                            <div class="mb-2">
                                                <?php foreach ($types as $type): ?>
                                                    <span class="badge bg-secondary me-1"><?= htmlspecialchars($type) ?></span>
                                                <?php endforeach; ?>
                                            </div>
                                        <?php endif; ?>

                                        <!-- Stats détaillées -->
                                        <?php if ($card['attack'] || $card['defense'] || $card['special_attack'] || $card['special_defense'] || $card['speed']): ?>
                                            <div class="mb-2">
                                                <small class="text-muted">Stats:</small><br>
                                                <?php if ($card['attack']): ?>
                                                    <span class="badge bg-warning text-dark me-1">ATK: <?= $card['attack'] ?></span>
                                                <?php endif; ?>
                                                <?php if ($card['defense']): ?>
                                                    <span class="badge bg-info text-dark me-1">DEF: <?= $card['defense'] ?></span>
                                                <?php endif; ?>
                                                <?php if ($card['special_attack']): ?>
                                                    <span class="badge bg-success me-1">SP.ATK: <?= $card['special_attack'] ?></span>
                                                <?php endif; ?>
                                                <?php if ($card['special_defense']): ?>
                                                    <span class="badge bg-primary me-1">SP.DEF: <?= $card['special_defense'] ?></span>
                                                <?php endif; ?>
                                                <?php if ($card['speed']): ?>
                                                    <span class="badge bg-dark me-1">VIT: <?= $card['speed'] ?></span>
                                                <?php endif; ?>
                                            </div>
                                        <?php endif; ?>

                                        <small class="text-muted">
                                            Obtenue le <?= date('d/m/Y à H:i', strtotime($card['obtained_at'])) ?>
                                        </small>
                                    </div>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
>>>>>>> 96b9879 (finito)
</body>
</html>