<?php

require_once '../config/bootstrap.php';
// Code à ajouter dans votre index.php (au début du fichier, après les includes)

use App\Auth\AuthHelper;
use App\Class\Collection;
use App\Class\Booster;

// Gestion de l'ajout à la collection
$collectionMessage = '';
$collectionSuccess = false;
$currentUser = AuthHelper::getCurrentUser();

if (AuthHelper::validatePostRequest() && isset($_POST['booster'])) {
    // Vérifier que l'utilisateur est connecté
    if (!AuthHelper::isLoggedIn()) {
        $collectionMessage = "Vous devez être connecté pour ajouter des cartes à votre collection.";
    } else {
        try {
            // Décoder les données du booster
            $boosterData = json_decode($_POST['booster'], true);

            if (!$boosterData || !is_array($boosterData)) {
                throw new Exception("Données du booster invalides.");
            }

<<<<<<< HEAD
//var_dump($booster);
=======
            // Créer l'instance de Collection et ajouter le booster
            $collection = new Collection();
            $result = $collection->addBoosterToCollection(AuthHelper::getCurrentUserId(), $boosterData);

            $collectionSuccess = $result['success'];
            $collectionMessage = $result['message'];
>>>>>>> 96b9879 (finito)

            if (!empty($result['errors'])) {
                $collectionMessage .= " Erreurs: " . implode(', ', $result['errors']);
            }

        } catch (Exception $e) {
            $collectionMessage = "Erreur lors de l'ajout du booster : " . $e->getMessage();
        }
    }
}

// Le reste de votre code existant pour générer le booster...
// Après la génération du $booster, vous pouvez afficher le message:
?>

<!DOCTYPE html>
<html lang="en">
<head>
<<<<<<< HEAD
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
<?php if ($estConnecte):  echo 'Bienvenu ' . htmlspecialchars($_SESSION['user']['name'])?>
<?php $booster = Booster::generateBooster();?>

<div class="container vh-100">
  <div class="row justify-content-center align-items-center h-100">
    <div class="col-3 position-relative">
      <?php $i = 9; ?>
      <?php foreach($booster as $key => $card):?>
        <div class="card <?= Booster::getPokemonType($booster[$key])?>" id="card"
            data-nom="<?= $card['name']['fr'] ?>"
            data-pv="<?= $card['stats']['hp'] ?>"
            data-atk="<?= $card['stats']['atk'] ?>" 
            data-def="<?= $card['stats']['def'] ?>"
            data-spe_atk="<?= $card['stats']['spe_atk'] ?>"
            data-spe_def="<?= $card['stats']['spe_def'] ?>"
            data-vit="<?= $card['stats']['vit'] ?>"
            data-image="<?= $card['sprites']['regular'] ?>"
            data-category="<?= $card['category'] ?>">

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
      <?php else: ?>
      <p>Veuillez vous connecter pour ouvrir les packs.</p>
      <?php endif; ?>
        <?php $booster = json_encode($booster)?>
      <form class="AddToCol" action="collection.php" method="post" style="display: block;">
        <input type="hidden" name="booster" value="<?= htmlspecialchars($booster)?>">
        <button class="btn btn-primary" type="submit">Ajouter a la collection</button>
      </form>
    </div>
  </div>
</div>
=======
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="../css/components/card.css">
  <script src="https://cdn.jsdelivr.net/npm/gsap@3.13.0/dist/gsap.min.js"></script>
  <script src="../js/pack-opening.js"></script>
  <title>Document</title>
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
<?php if (!empty($collectionMessage)): ?>
    <div class="alert <?= $collectionSuccess ? 'alert-success' : 'alert-danger' ?> mt-3">
        <?= htmlspecialchars($collectionMessage) ?>
    </div>
<?php endif; ?>

<?php if (AuthHelper::isLoggedIn()): ?>
<?php $booster = Booster::generateBooster();?>
<div class="container vh-100">
  <div class="row justify-content-center align-items-center h-100">
    <div class="col-3 position-relative">
      <?php foreach($booster as $key => $card):?>
        <div id="card-<?= $key;?>" class="pokemon-card <?= $card['types'][0]['name'];?>">
          <div class="top-card">
            <p><?= $card['name']['fr'];?></p>
            <span>
              <p><small>PV</small><?= $card['stats']['hp'];?></p>
              <img src="<?= $card['types'][0]['image'];?>" alt="<?= $card['types'][0]['name'];?>"></img>
            </span>
          </div>
          <div class="card-illustration">
            <img src="<?= $card['sprites']['regular'];?>" alt="<?= $card['name']['fr'];?>">
          </div>
          <div class="card-stats">
            <p>Attaque: <?= $card['stats']['atk'];?></p>
            <p>Défense: <?= $card['stats']['def'];?></p>
            <p>Attaque Spéciale: <?= $card['stats']['spe_atk'];?></p>
            <p>Défense Spéciale: <?= $card['stats']['spe_def'];?></p>
            <p>Vitesse: <?= $card['stats']['vit'];?></p>
            <div class="d-flex justify-content-between">
              <p><?= $card['category'];?></p>
              <p>#<?= $card['pokedex_id'];?></p>
            </div>
          </div>
        </div>
      <?php endforeach; ?>
      <form id="add-to-collection-form" method="post" class="justify-content-center" style="display: none;">
        <input type="hidden" name="booster" value="<?= htmlspecialchars(json_encode($booster));?>">
        <button type="submit" class="btn btn-primary">Ajouter à la collection</button>
      </form>
    </div>
  </div>
</div>

<!-- Votre formulaire existant, mais avec amélioration -->
<form id="add-to-collection-form" method="post" class="justify-content-center" style="display: none;">
    <input type="hidden" name="booster" value="<?= htmlspecialchars(json_encode($booster)); ?>">
    <input type="hidden" name="csrf_token" value="<?= AuthHelper::generateCSRFToken(); ?>">

    <?php if (AuthHelper::isLoggedIn()): ?>
        <button type="submit" class="btn btn-primary">Ajouter à la collection</button>
    <?php else: ?>
        <a href="/public/auth/login.php" class="btn btn-warning">Connectez-vous pour ajouter à votre collection</a>
    <?php endif; ?>
</form>
<?php else: ?>
    <div class="container mt-5">
        <div class="alert alert-warning">
            Vous devez être connecté pour ouvrir un booster.
            <a href="./auth/login.php" class="alert-link">Connectez-vous</a> ou <a href="./auth/register.php" class="alert-link">inscrivez-vous</a>.
        </div>
    </div>
<?php endif; ?>
>>>>>>> 96b9879 (finito)
</body>
</html>
