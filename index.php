<?php

require_once "vendor/autoload.php";

use App\Route\Router;

$router = new Router();

$router->addRoute('GET', '/home', function(){
    // require_once "home.php";
    echo "Home";
    exit;
});

$router->matchRoute();