<?php

require_once 'vendor/autoload.php';

use App\Model\Clothing;
use App\Model\Electronic;

// findAll Clothing

$clothing = new Clothing();
$allClothing = $clothing->findAll();



// findAll Electronic

$electronic = new Electronic();
$allElectronic = $electronic->findAll();



?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>MY-LITTLE-MVC-SHOP</title>
</head>

<body>
  <h1>MY-LITTLE-MVC-SHOP</h1>
  <h2>Clothing</h2>
  <ul>
    <?php foreach ($allClothing as $clothing) :
      $clothingImages = $clothing->getPhotos();
      $idProduct = $clothing->getId();
    ?>
      <li>
        <a href="product.php?id_product=<?= $idProduct,'&product_type=clothing'?>"><?= $clothing->getName() ?></a>
        <p><?= $clothing->getPrice() ?> €</p>
        <p><?= $clothing->getDescription() ?></p>
        <p><?= $clothing->getQuantity() ?></p>
        <p><?= $clothing->getCategory_id() ?></p>
        <img src="<?= $clothingImages[0] ?>" alt="" height=340 width=340>

      </li>
    <?php endforeach; ?>
  </ul>
  <h2>Electronic</h2>
  <ul>
    <?php foreach ($allElectronic as $electronic) :
      $electronicImages = $electronic->getPhotos();
      $idProduct = $electronic->getId();
    ?>

      <li>
      <a href="product.php?id_product=<?= $idProduct,'&product_type=electronic'?>"><?= $electronic->getName() ?></a>
        <p><?= $electronic->getPrice() ?> €</p>
        <p><?= $electronic->getDescription() ?></p>
        <p><?= $electronic->getQuantity() ?></p>
        <p><?= $electronic->getCategory_id() ?></p>
        <img src="<?= $electronicImages[0] ?>" alt="" height=340 width=340>
      </li>
    <?php endforeach; ?>
  </ul>


</body>

</html>