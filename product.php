<?php
require_once 'vendor/autoload.php';
session_start();

use App\Controller\ShopController;


$finalProduct = (new ShopController())->showProduct($_GET['id_product'], $_GET['product_type']);

if (isset($_SESSION['user'])) {
  $user = $_SESSION['user'];
  $user_id = $user->getId();
}

if (isset($_SESSION['cart'])) {
  var_dump($_SESSION['cart']);
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
</head>

<body>
  <?php if ($finalProduct) : ?>
    <?php if ($finalProduct == "Vous devez être connecté pour accéder à cette page") : ?>
      <h2><?= $finalProduct ?>, vous allez être redirigé</h2>
    <?php else : ?>
      <h1><?= $finalProduct->getName() ?></h1>

      <p><?= $finalProduct->getDescription() ?></p>
      <p><?= $finalProduct->getPrice() ?> €</p>
      <p><?= $finalProduct->getQuantity() ?></p>
      <?php foreach ($finalProduct->getPhotos() as $photo) : ?>
        <img width=450 height=450 src="<?= $photo ?>" alt="photo de <?= $finalProduct->getName() ?>">
      <?php endforeach; ?>
    <?php endif; ?>
  <?php else : ?>
    <h2>Le produit demandé n'est pas disponible</h2>
  <?php endif; ?>

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


</body>


</html>