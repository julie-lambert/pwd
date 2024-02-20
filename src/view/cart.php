<?php
require_once 'vendor/autoload.php';
session_start();

use App\Controller\ShopController;

if (!isset($_SESSION['user'])) {
    header("Location: ./login.php");
}

if (isset($_POST['delete'])) {
    $idProduct = $_POST['id_product'];
    $shopController = new ShopController();
    $result = $shopController->deleteProductCart($idProduct);
}

if (isset($_POST['update'])) {
    $idProduct = $_POST['id_product'];
    $quantity = $_POST['quantity'];
    $shopController = new ShopController();
    $result = $shopController->updateProductCart($idProduct, $quantity);
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="./assets/css/cart.css">
    <title>Cart</title>
</head>

<body>
    <?php
    require_once "header.php";
    ?>


    <main class="cart-container">
        <h1>Panier</h1>
        <?php if (!isset($_SESSION['cart']) || empty($_SESSION['cart'])) : ?>
            <h2>Votre panier est vide</h2>

        <?php else : ?>
            <?php if (isset($result)) : ?>
                <?php if ($result['success']) : ?>
                    <h2 class="success"><?= $result['message'] ?></h2>
                    <?php header("refresh:3; url=./cart.php") ?>

                <?php elseif (!$result['success']) : ?>
                    <h2 class="error"><?= $result['message'] ?></h2>
                    <?php header("refresh:3; url=./cart.php") ?>
                <?php endif; ?>
            <?php endif; ?>
            <section>
                <table>
                    <thead>
                        <tr>
                            <th>Produit</th>
                            <th>ID produit</th>
                            <th>Prix</th>
                            <th>Quantité</th>
                            <th>Supprimer</th>
                            <th>Total</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $total = 0;
                        $shopController = new ShopController();
                        foreach ($_SESSION['productCart'] as $product) :
                            $idProduct = $product->getProduct_id();
                            $productDetails = $shopController->showProduct($idProduct);
                            $productName = $productDetails->getName();
                            $price = $productDetails->getPrice();
                            $quantity = $product->getQuantity();
                            $total += $price * $quantity;
                        ?>
                            <tr>
                                <td><?= $productName ?></td>
                                <td><?= $idProduct ?></td>
                                <td><?= $price ?> €</td>
                                <td>
                                    <form action="" method="post">
                                        <input type="number" name="quantity" min="1" value="<?= $quantity ?>">
                                        <input type="hidden" name="id_product" value="<?= $idProduct ?>">
                                        <input type="submit" name="update" value="Modifier">
                                    </form>
                                </td>
                                <td>
                                    <form action="" method="post">
                                        <input type="hidden" name="id_product" value="<?= $idProduct ?>">
                                        <input type="submit" name="delete" value="Supprimer">
                                    </form>
                                </td>
                                <td><?= $price * $quantity ?> €</td>
                            </tr>
                        <?php endforeach; ?>
                        <tr>
                            <td colspan="5">Total</td>
                            <td><?= $total ?> €</td>
                        </tr>

                    </tbody>
                </table>
                <a href="./checkout.php">Valider le panier</a>

            </section>
        <?php endif; ?>

    </main>


</body>

</html>