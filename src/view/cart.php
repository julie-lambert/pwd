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
                    <?php header("refresh:3; url=" . $_ENV['BASE_DIR'] . "/cart") ?>

                <?php elseif (!$result['success']) : ?>
                    <h2 class="error"><?= $result['message'] ?></h2>
                    <?php header("refresh:3; url=" . $_ENV['BASE_DIR'] . "/cart") ?>
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
                        foreach ($productsList as $product) :
                            $productName = $product['productName'];
                            $idProduct = $product['idProduct'];
                            $price = $product['price'];
                            $quantity = $product['quantity'];

                        ?>
                            <tr>
                                <td><?= $productName ?></td>
                                <td><?= $idProduct ?></td>
                                <td><?= $price ?> €</td>
                                <td>
                                    <form method="post">
                                        <input type="number" name="quantity" min="1" value="<?= $quantity ?>">
                                        <input type="hidden" name="id_product" value="<?= $idProduct ?>">
                                        <input type="submit" name="update" value="Modifier">
                                    </form>
                                </td>
                                <td>
                                    <form method="post">
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
                <a href="<?= $_ENV['BASE_DIR'] ?>/checkout">Valider le panier</a>

            </section>
        <?php endif; ?>


    </main>


</body>

</html>