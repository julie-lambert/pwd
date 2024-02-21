<?php

require_once './vendor/autoload.php';
session_start();

use App\Controller\AuthenticationController;

$auth = new AuthenticationController();

if (!$auth->profile()) {
    header("Location: /pwd/login");
} else {
    $auth->logout();
}
