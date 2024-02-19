<?php
require_once 'vendor/autoload.php';
session_start();

use App\Controller\ShopController;


$finalProduct = (new ShopController())->showProduct($_GET['id_product'], $_GET['product_type']);

if (isset($_SESSION['user'])) {
  $user = $_SESSION['user'];
  $user_id = $user->getId();
}

if (isset($_POST['addCart'])) {
  $quantity = $_POST['quantity'];
  $product_id = $_GET['id_product'];
  $result = (new ShopController())->addProductToCart($product_id, $quantity, $user_id);
  if ($result['success']) {
    $message = $result['message'];
    header("refresh:3; url=./shop.php");
  } elseif (!$result['success']) {
    $error = $result['message'];
    header("refresh:3; url=./login.php");
  }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Produit</title>
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css" />
  <link rel="stylesheet" href="./assets/css/product.css">
</head>

<body>
  <!-- HEADER -->
  <header class="product-header">
    <a href="shop.php">Retour à la boutique</a>
    <h1>DÉTAILS DU PRODUIT</h1>
    <div class="user-head">
      <a href="cart.php">Voir mon panier</a>
      <?php if (isset($_SESSION['user'])) : ?>
        <a href="profile.php">Mon profil</a>
        <a href="logout.php">Se déconnecter</a>
      <?php else : ?>
        <a href="login.php">Se connecter</a>
    </div>
  <?php endif; ?>
  </header>


  <?php if ($finalProduct) : ?>
    <?php if ($finalProduct == "Vous devez être connecté pour accéder à cette page") : ?>
      <h2><?= $finalProduct ?>, vous allez être redirigé</h2>
    <?php else : ?>
      <main>
        <section data-model="00">
          <!-- CAROUSEL -->
          <div class="carousel">
            <div class="swiper">
              <div class="swiper-wrapper">
                <?php foreach ($finalProduct->getPhotos() as $photo) : ?>
                  <div class="swiper-slide">
                    <img src="<?= $photo ?>" alt="photo de <?= $finalProduct->getName() ?>">
                  </div>
                <?php endforeach; ?>
              </div>
            </div>
            <div class="swiper-controls">
              <div class="swiper-pagination"></div>
              <div class="button-swiper-nav button-left"><span>
                </span>
              </div>
              <div class="button-swiper-nav button-right"><span></span></div>
            </div>
          </div>
          <div class="card">
            <h2><small><?= $finalProduct->getName() ?></small></h2>
            <hr />
            <p><?= $finalProduct->getDescription() ?></p>
            <hr />
            <div class="price-quantity">
              <p><?= $finalProduct->getPrice() ?> €</p>
              <!-- Formulaire ajout de produits -->
              <form action="" method="post">
                <h3>Ajouter au panier</h3>
                <?php if (isset($message)) : ?>
                  <p class="success"><?= $message ?></p>
                <?php elseif (isset($error)) : ?>
                  <p class="error"><?= $error ?></p>
                <?php endif; ?>

                <input type="number" min="1" value="1" name="quantity">
                <input name="addCart" type="submit" value="Ajouter au Panier">

              </form>
            </div>


            <hr />
            <div class="photos">
              <?php foreach ($finalProduct->getPhotos() as $photo) : ?>
                <div class="active">
                  <img src="<?= $photo ?>" alt="photo de <?= $finalProduct->getName() ?>">
                </div>
              <?php endforeach; ?>
            <?php endif; ?>
          <?php else : ?>
            <h2>Le produit demandé n'est pas disponible</h2>
          <?php endif; ?>
            </div>
          </div>

        </section>

      </main>

      <script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>
      <script src="./scripts/productScript.js"></script>

</body>


</html>