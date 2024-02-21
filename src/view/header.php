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
        <a href="shop.php" class="active">Retour à la boutique</a>
      <?php else : ?>
        <a href="index.php">Home</a>
      <?php endif
      ?>
      <a href="/pwd/shop">Shop</a>
    </div>
    <div>
      <?php
      if (isset($_SESSION['user'])) : ?>
        <a href="/pwd/profile">Profil</a>
        <a href="cart.php">Panier</a>
        <a href="/pwd/logout">Déconnexion</a>
      <?php else : ?>
        <a href="/pwd/register">Inscription/Connexion</a>
      <?php endif; ?>
    </div>
  </nav>
</body>

</html>