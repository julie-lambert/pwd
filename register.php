<?php
require_once './vendor/autoload.php';

use App\Controller\AuthenticationController;

$auth = new AuthenticationController();



if (isset($_POST['email']) && isset($_POST['password']) && isset($_POST['firstname']) && isset($_POST['lastname']) && isset($_POST['password_confirm'])) {
  if ($_POST['password'] !== $_POST['password_confirm']) {
    $result = [
      'success' => false,
      'message' => 'Les mots de passe ne correspondent pas'
    ];
  } else {
    $fullname = $_POST['firstname'] . ' ' . $_POST['lastname'];
    $result = $auth->register($_POST['email'], $_POST['password'], $fullname);
    if ($result['success']) {
      header('refresh:2;url=./login.php');
    } 
  }
}


?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Register</title>
  <link rel="stylesheet" href="./style/css/register.css">
  <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
</head>

<body>
  <div class="register-wrapper">
    <form action="register.php" method="post">
      <h1>Inscription</h1>
      <div class="input-box">
        <div class="input-field">
          <input type="text" placeholder="Prénom" name="firstname" required>
          <i class='bx bxs-user'></i>
        </div>
        <div class="input-field">
          <input type="text" placeholder="Nom" name="lastname" required>
          <i class='bx bxs-user'></i>
        </div>
      </div>

      <div class="input-box">
        <div class="input-field">
          <input type="text" placeholder="Pseudo" name="username">
          <i class='bx bxs-user'></i>
        </div>
        <div class="input-field">
          <input type="email" placeholder="Email" name="email" required>
          <i class='bx bx-envelope'></i>
        </div>
      </div>

      <div class="input-box">
        <div class="input-field">
          <input type="password" placeholder="Mot de passe" name="password" required>
          <i class='bx bx-lock-alt'></i>
        </div>
        <div class="input-field">
          <input type="password" placeholder="Confirmation du mot de passe" name="password_confirm" required>
          <i class='bx bx-lock-alt'></i>
        </div>
      </div>

      <input type="submit" class="register-btn" value="S'inscrire">
      <?php if (isset($result['message'])) : ?>
        <p class=<?php $result['success'] ? 'success-message' : 'error-message' ?>><?= $result['message'] ?> </p>
      <?php endif; ?>

      <p class="register-text">Vous avez déjà un compte? <a href="./login.php">Connectez-vous ici</a></p>
    </form>
  </div>


</body>

</html>