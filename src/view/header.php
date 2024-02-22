<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="/pwd/assets/css/header.css">
</head>

<body>

  <nav>
    <div>

      <?php
      // if product.php est contenu dans $_SERVER['PHP_SELF'] alors on affiche le lien "Retour à la boutique"

      if (str_contains($_SERVER['PHP_SELF'], 'product.php')) : ?>
        <a href="<?= $_ENV['BASE_DIR'] ?>/shop" class="active">Retour à la boutique</a>
      <?php else : ?>
        <a href="<?= $_ENV['BASE_DIR'] ?>/">Home</a>
      <?php endif
      ?>
      <a href="<?= $_ENV['BASE_DIR'] ?>/shop">Shop</a>
    </div>
    <div>
      <?php
      if (isset($_SESSION['user'])) : ?>
        <a href="<?= $_ENV['BASE_DIR'] ?>/profile">Profil</a>
        <a href="<?= $_ENV['BASE_DIR'] ?>/cart">Panier</a>
        <a href="<?= $_ENV['BASE_DIR'] ?>/logout">Déconnexion</a>
      <?php else : ?>
        <a href="<?= $_ENV['BASE_DIR'] ?>/register">Inscription/Connexion</a>
      <?php endif; ?>
    </div>
  </nav>
</body>

</html>