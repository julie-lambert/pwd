<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Register</title>
  <link rel="stylesheet" href="./assets/css/register.css">
  <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
</head>

<body>
  <?php
  require_once "header.php";
  ?>
  <div class="register-wrapper">
    <form method="post">
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

      <p class="register-text">Vous avez déjà un compte? <a href="/pwd/login">Connectez-vous ici</a></p>
    </form>
  </div>


</body>

</html>