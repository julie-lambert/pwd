<?php
require_once 'vendor/autoload.php';


use App\Controller\ShopController;

if (!isset($_SESSION['user'])) {
    header("Location: ./login.php");
} else {
    $user = $_SESSION['user'];
    $user_id = $user->getId();

    $shopController = new ShopController();
    $cartResult = $shopController->validateCart($user_id);
}




?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Checkout</title>
</head>

<body>

    <main>
        <section>
            <h2>Validation du panier</h2>
            <p>Ceci est une page de validation de panier</p>
        </section>
        <section>
            <?php if ($cartResult['success']) : ?>
                <h2 class="success"><?= $cartResult['message'] ?></h2>
                <?php header("refresh:2; url=". $_ENV['BASE_DIR'] ."/cart") ?>

            <?php elseif (!$cartResult['success']) : ?>
                <h2 class="error"><?= $cartResult['message'] ?></h2>
                <?php header("refresh:2; url=". $_ENV['BASE_DIR'] ."/cart") ?>
            <?php endif; ?>

        </section>
    </main>

</body>

</html>