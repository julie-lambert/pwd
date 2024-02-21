<?php

require_once "vendor/autoload.php";

use App\Route\Router;

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
$router->post('/login', function () {
    echo ('Connexion');
});

//Inscription
$router->get('/register', function () {
    require_once 'src/view/register.php';
});
$router->post('/register', function () {
    echo ('Inscription');
});




$router->run();
