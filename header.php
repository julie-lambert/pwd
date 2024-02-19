<?php


?>


<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="./assets/css/header.css">
</head>

<body>

  <nav>
    <div>

      <?php
      if ($_SERVER['PHP_SELF'] == '/my-little-mvc/product.php') : ?>
        <a href="shop.php" class="active">Retour à la boutique</a>
      <?php else : ?>
        <a href="index.php">Home</a>
      <?php endif
      ?>
      <a href="shop.php">Shop</a>
    </div>
    <div>
      <?php
      if (isset($_SESSION['user'])) : ?>
      <a href="profile.php">Profil</a>
      <a href="cart.php">Panier</a>
      <a href="logout.php">Déconnexion</a>
      <?php else : ?>
      <a href="register.php">Inscription/Connexion</a>
      <?php endif; ?>
    </div>
  </nav>
</body>

</html>