<?php
require_once './vendor/autoload.php';
session_start();

use App\Route\Router;
use App\Controller\AuthenticationController;
use App\Controller\ShopController;

// $_ENV['BASE_DIR'] = '/' . (explode('/', __DIR__))[count(explode('/', __DIR__)) - 1];

//On créé une variable d'environnement pour le chemin de base du projet
$_ENV['BASE_DIR'] = substr($_SERVER['PHP_SELF'], 0, strrpos($_SERVER['PHP_SELF'], '/'));







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


//Inscription
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

//Deconnexion
$router->get('/logout', function () {
    require_once './logout.php';
});

//Profil
$router->get('/profile', function () {

    $auth = new AuthenticationController();
    if (!$auth->profile()) {
        $message = "Vous n'êtes pas connecté vous allez être redirigé vers la page de connexion";
        header("refresh:3;url=/pwd/login");
    } else {
        $user = $_SESSION['user'];
    }
    var_dump($user);
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

//======================> Shop

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


//========================> Produit
// Route pour un produit en fonction de son id
$router->get('/product/:id', function ($id) {
    $shop = new ShopController();
    $finalProduct = $shop->showProduct($id, $_GET['product_type']);
    // var_dump($finalProduct);
    require_once 'src/view/product.php';
});


//======================> Panier

// Route pour ajouter un produit au panier
$router->post('/product/:id', function ($id) {
    $shop = new ShopController();
    $result = $shop->addProductToCart($id, $_POST['quantity']);
    require_once 'src/view/product.php';
});

// Route pour le panier
$router->get('/cart', function () {
    require_once 'src/view/cart.php';
});

// Route pour supprimer un produit du panier
$router->post('/cart/:id', function ($id) {
    $shop = new ShopController();
    $result = $shop->removeProductFromCart($id, $_SESSION['user']->getId());
    require_once 'src/view/cart.php';
});

// Route pour vider le panier
$router->get('/empty-cart', function () {
    $shop = new ShopController();
    $result = $shop->emptyCart($_SESSION['user']->getId());
    require_once 'src/view/cart.php';
});

// Route pour valider le panier
$router->get('/validate-cart', function () {
    $shop = new ShopController();
    $result = $shop->validateCart($_SESSION['user']->getId());
    require_once 'src/view/cart.php';
});












$router->run();
