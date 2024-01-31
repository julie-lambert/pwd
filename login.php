<?php
session_start();
require_once './vendor/autoload.php';

use App\Controller\AuthenticationController;

$auth = new AuthenticationController();

if (isset($_POST['email']) && isset($_POST['password'])) {
  $result = $auth->login($_POST['email'], $_POST['password']);
  if ($result['success']) {
    header('refresh:2;url=./shop.php');
  }
}

?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="./style/css/login.css">
  <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
  <title>Connexion</title>
</head>

<body>

  <div class="login-wrapper">
    <form action="login.php" method="post">
      <h1>Connexion</h1>
      <div class="input-box">
        <div class="input-field">
          <input type="text" placeholder="Email" name="email">
          <i class='bx bxs-envelope'></i>
        </div>
        <div class="input-field">
          <input type="password" placeholder="Mot de passe" name="password" required>
          <i class='bx bx-lock-alt'></i>
        </div>
      </div>
      <input type="submit" class="login-btn" value="Connexion"></input>
    </form>
  </div>


</body>

</html>