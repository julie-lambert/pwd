<?php



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
    <form action="" method="post">
      <h1>Inscription</h1>

      <div class="input-box">
        <div class="input-field">
          <input type="text" placeholder="Nom" id="firstname" required>
          <i class='bx bxs-user'></i>
        </div>
        <div class="input-field">
          <input type="text" placeholder="Prénom" id="lastname" required>
          <i class='bx bxs-user'></i>
        </div>
      </div>

      <div class="input-box">
        <div class="input-field">
          <input type="text" placeholder="Pseudo" id="username" required>
          <i class='bx bxs-user'></i>
        </div>
        <div class="input-field">
          <input type="email" placeholder="Email" id="email" required>
          <i class='bx bx-envelope'></i>
        </div>
      </div>

      <div class="input-box">
        <div class="input-field">
          <input type="password" placeholder="Mot de passe" id="password" required>
          <i class='bx bx-lock-alt'></i>
        </div>
        <div class="input-field">
          <input type="password" placeholder="Confirmation du mot de passe" id="password_confirm" required>
          <i class='bx bx-lock-alt'></i>
        </div>
      </div>

      <button type="submit" class="register-btn">S'inscrire</button>
      <!-- <p class="register-text">Vous avez déjà un compte? <a href="./login.php">Connectez-vous ici</a></p> -->
    </form>
  </div>


</body>

</html>