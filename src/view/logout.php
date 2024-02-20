<?php

require_once './vendor/autoload.php';
session_start();

use App\Controller\AuthenticationController;

$auth = new AuthenticationController();

if(!$auth->profile()){
    $message= "Vous n'êtes pas connecté vous allez être redirigé vers la page de connexion";
    header("refresh:3;url=login.php");
} else {
    $auth->logout();
}