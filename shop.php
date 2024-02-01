<?php
require_once 'vendor/autoload.php';
session_start();


use App\Model\Clothing;
use App\Model\Electronic;
use App\Controller\ShopController;

$shop = new ShopController();

if(isset($_GET['page'])){
  $page = $_GET['page'];
} else {
  $page = 1;
}

$allProducts = $shop->index($page);





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
  
  <h2>Produits</h2>

  <div class="products">
    <?php if($page > 1): ?>
      <a href="shop.php?page=<?= $page - 1 ?>">Page précédente</a>
    <?php endif; ?>
      <a href="shop.php?page=<?= $page + 1 ?>">Page suivante</a>

    <?php foreach ($allProducts as $product) : 
      $type = $shop->productType($product->getId());
      ?>
      <div class="product">
        <h3><?= $product->getName() ?></h3>
        <img src="<?= $product->getPhotos()[0] ?>" alt="">
        <p><?=  $product->getPrice() ?> €</p>
        <p><?= $product->getDescription() ?></p>
        <p><?= $product->getQuantity() ?></p>
        <a href="product.php?id_product=<?= $product->getId(), '&product_type=', $type ?>">Voir le produit</a>
      </div>
    <?php endforeach; ?>
  </div>


</body>

</html>