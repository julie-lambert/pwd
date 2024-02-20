<?php

require_once "vendor/autoload.php";

use App\Route\Router;
if(!isset($_GET['url'])){
    $_GET['url'] = '/';
}
$router = new Router($_GET['url']);

$router->get('/', function(){
    require_once 'home.php';
});
$router->get('/shop', function(){
    echo 'Hello World';
});

$router->get('/posts/:id', function($id){
    echo 'Affichage du post ' . $id;
});

$router->run();