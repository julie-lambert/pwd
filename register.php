<?php



?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Register</title>
</head>

<body>
  <h1>Register</h1>
  <form action="" method="post">
    <label for="firstname">Prénom</label>
    <input type="text" name="firstname" id="firstname" required>
    <label for="lastname">Nom</label>
    <input type="text" name="lastname" id="lastname" required>
    <label for="email">Email</label>
    <input type="email" name="email" id="email" required>
    <label for="password">Mot de passe</label>
    <input type="password" name="password" id="password" required>
    <label for="password_confirm">Confirmation du mot de passe</label>
    <input type="password" name="password_confirm" id="password_confirm" required>
    <input type="submit" value="Inscription">
  </form>

</body>

</html>