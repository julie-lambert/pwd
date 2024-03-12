<?php
require_once './vendor/autoload.php';
session_start();

use App\Route\Router;
use App\Controller\AuthenticationController;
use App\Controller\ShopController;

//On créé une variable d'environnement pour le chemin de base du projet (1ère méthode)
// $_ENV['BASE_DIR'] = '/' . (explode('/', __DIR__))[count(explode('/', __DIR__)) - 1];

//On créé une variable d'environnement pour le chemin de base du projet (2ème méthode)(la plus mieux)
$_ENV['BASE_DIR'] = substr($_SERVER['PHP_SELF'], 0, strrpos($_SERVER['PHP_SELF'], '/'));


//On vérifie si la variable url existe

if (!isset($_GET['url'])) {

    $_GET['url'] = '/';
}
$router = new Router($_GET['url']);


$router->get('/', function () {
    require_once 'src/view/home.php';
});

// Routes pour la Connexion/Inscription

//Connexion
$router->get('/login', function () {
    require_once 'src/view/login.php';
});
$router->post(
    '/login',
    function () {
        $auth = new AuthenticationController();
        $result = $auth->login($_POST['email'], $_POST['password']);
        //On require la vue login pour afficher le message
        require_once 'src/view/login.php';
        if ($result['success']) {
            header('refresh:3;url=/pwd/');
        }
    }
);


//============================> INSCRIPTION
$router->get('/register', function () {
    require_once 'src/view/register.php';
});
$router->post('/register', function () {
    $auth = new AuthenticationController();
    $result = $auth->register($_POST['email'], $_POST['password'], $_POST['password_confirm'], $_POST['firstname'], $_POST['lastname']);
    require_once 'src/view/register.php';
    if ($result['success']) {
        header('refresh:3;url=/pwd/login');
    }
});

//============================> DECONNEXION
$router->get('/logout', function () {
    require_once './logout.php';
});

//============================> PROFIL
$router->get('/profile', function () {

    $auth = new AuthenticationController();
    if (!$auth->profile()) {
        $message = "Vous n'êtes pas connecté vous allez être redirigé vers la page de connexion";
        header("refresh:3;url=/pwd/login");
    } else {
        $user = $_SESSION['user'];
    }

    require_once 'src/view/profile.php';
});
$router->post('/profile', function () {
    $auth = new AuthenticationController();


    if (isset($_POST['info'])) {

        $result = $auth->update($_POST['email'], $_POST['password'], $_POST['fullname']);
        $user = $_SESSION['user'];
    }
    if (isset($_POST['modifPassword'])) {
        $result = $auth->updatePassword($_POST['oldPassword'], $_POST['newPassword'], $_POST['confirmPassword']);
        $user = $_SESSION['user'];
    }
    require_once 'src/view/profile.php';
});

//===========================> SHOP

// Route pour tous les produits + pagination
$router->get('/shop', function () {
    $shop = new ShopController();
    if (isset($_GET['page'])) {
        $page = intval($_GET['page']);
    } else {
        $page = 1;
    }
    $allProducts = $shop->index($page);
    require_once 'src/view/shop.php';
});


//==========================> PRODUIT

// Route pour un produit en fonction de son id
$router->get('/product/:id', function ($id) {
    $shop = new ShopController();
    $finalProduct = $shop->showProduct($id, $_GET['product_type']);
    require_once 'src/view/product.php';
});

// Route pour ajouter un produit au panier
$router->post('/product/:id', function ($id) {

    $shop = new ShopController();
    $finalProduct = $shop->showProduct($id, $_GET['product_type']);

    $result = $shop->addProductToCart($id, $_POST['quantity']);
    if ($result['success']) {
        $message = $result['message'];
        // On redirige l'utilisateur aprés 3 secondes vers le shop en utilisant la variable d'environnement
        header("refresh:3; url=" . $_ENV['BASE_DIR'] . "/shop");
    } elseif (!$result['success']) {
        $error = $result['message'];
        header("refresh:3; url=" . $_ENV['BASE_DIR'] . "/login");
    }

    require_once 'src/view/product.php';
});

//==========================> PANIER


// Route pour le panier
$router->get('/cart', function () {
    if (!isset($_SESSION['user'])) {
        header("Location:" . $_ENV['BASE_DIR'] . "/login");
    }
    // On récupère les produits du panier avec leurs infos
    $total = 0;
    $shopController = new ShopController();
    $productsList = [];
    if (isset($_SESSION['cart']) && isset($_SESSION['productCart'])) {
        foreach ($_SESSION['productCart'] as $product) :
            $idProduct = $product->getProduct_id();
            $productDetails = $shopController->showProduct($idProduct);
            $productName = $productDetails->getName();
            $price = $productDetails->getPrice();
            $quantity = $product->getQuantity();
            $total += $price * $quantity;
            $productsList[] = [
                "idProduct" => $idProduct,
                "productName" => $productName,
                "price" => $price,
                "quantity" => $quantity,

            ];
        endforeach;
    }


    require_once 'src/view/cart.php';
});

// Routes pour supprimer un produit du panier ou mettre à jour la quantité d'un produit
$router->post('/cart', function () {
    $shopController = new ShopController();

    $total = 0;
    $productsList = [];
    // On récupère les produits du panier avec leurs infos
    foreach ($_SESSION['productCart'] as $product) :
        $idProduct = $product->getProduct_id();
        $productDetails = $shopController->showProduct($idProduct);
        $productName = $productDetails->getName();
        $price = $productDetails->getPrice();
        $quantity = $product->getQuantity();
        $total += $price * $quantity;
        $productsList[] = [
            "idProduct" => $idProduct,
            "productName" => $productName,
            "price" => $price,
            "quantity" => $quantity,

        ];
    endforeach;
    // On supprime un produit du panier
    if (isset($_POST['delete'])) {
        $idProduct = $_POST['id_product'];
        $result = $shopController->deleteProductCart($idProduct);
    }
    // On met à jour la quantité d'un produit dans le panier
    if (isset($_POST['update'])) {
        $idProduct = $_POST['id_product'];
        $quantity = $_POST['quantity'];
        $result = $shopController->updateProductCart($idProduct, $quantity);
    }
    require_once 'src/view/cart.php';
});

// Route pour valider le panier
$router->get('/checkout', function () {
    require_once 'src/view/checkout.php';
});



$router->run();
