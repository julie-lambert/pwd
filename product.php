<?php

require_once 'vendor/autoload.php';

use App\Model\Clothing;
use App\Model\Electronic;
use App\Model\Product;

//Si la clé id_product existe dans l'url et que sa valeur est un int
if (isset($_GET['id_product']) && ctype_digit($_GET['id_product'])) {
  //On récupère la valeur de la clé id_product
  $idProduct = $_GET['id_product'];
  //On instancie un objet de la classe Clothing ou Electronic en fonction de la valeur de la clé product_type
  if ($_GET['product_type'] === 'clothing') {
    $product = new Clothing();
  } elseif ($_GET['product_type'] === 'electronic') {
    $product = new Electronic();
  } else {
    $product = new Product();
    $horsType= "Ce produit est hors catégorie";
  }
}

$finalProduct = $product->findOneById($idProduct);
//On récupere le produit avec le findOneById de la classe Product
?>

<!DOCTYPE html>
<html lang="fr">
  
  <?php if ($finalProduct) :?>
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title><?= $finalProduct->getName() ?></title>
</head>
<body>
  <h1><?= $finalProduct->getName() ?></h1>
  <?php if(isset($horsType)): ?>
    <h3><?= $horsType ?></h3>
  <?php endif; ?>
  <p><?= $finalProduct->getPrice() ?> €</p>
  <p><?= $finalProduct->getDescription() ?></p>
  <p><?= $finalProduct->getQuantity() ?></p>
  <p><?= $finalProduct->getCategory_id() ?></p>
  <div id="slider">
    <?php foreach ($finalProduct->getPhotos() as $photo) : ?>
      <img src="<?= $photo ?>" alt="" height=340 width=340>
    <?php endforeach; ?>
  </div>
  <?php else: ?>
    <p>Le produit demandé n'est pas disponible</p>
  <?php endif; ?>
</body>
</html>