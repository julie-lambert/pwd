<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="./assets/css/login.css">
  <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
  <title>Connexion</title>
</head>

<body>
  <?php
  require_once "header.php";
  ?>

  <div class="login-wrapper">
    <form method="post">
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
      <input type="submit" class="login-btn" value="Connexion">
      <?php if (isset($result['message'])) : ?>
        <p class=<?php $result['success'] ? 'success-message' : 'error-message' ?>><?= $result['message'] ?> </p>
      <?php endif; ?>

      <p class="register-text">Vous n'avez pas encore de compte? <a href="/pwd/register">Inscrivez-vous ici</a></p>
    </form>
  </div>


</body>

</html>