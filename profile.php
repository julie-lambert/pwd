<?php
require_once './vendor/autoload.php';
session_start();

use App\Controller\AuthenticationController;

$auth = new AuthenticationController();

if(!$auth->profile()){
    $message= "Vous n'êtes pas connecté vous allez être redirigé vers la page de connexion";
    header("refresh:3;url=login.php");
} else {
    $user = $_SESSION['user'];
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profile</title>
</head>
<body>
    <?php if(isset($message)): ?>
        <p><?= $message ?></p>
        <?php else: ?>
            <h1>Bonjour </h1>
            <p>Nom complet : <?= $user->getFullname() ?></p>
            <p>Email : <?= $user->getEmail() ?></p>
            <?php foreach($user->getRole() as $role) {
                $role === 'ROLE_ADMIN' ? $role = 'Administrateur' : $role = 'Utilisateur';
                echo "<p>Role : $role</p>";
            }?>
                
                
     <a href="logout.php">Déconnexion</a>
    <?php endif; ?>
    <?php if(isset($user)): ?>
        <form action="profile.php" method="post">
            <input type="text" name="fullname" placeholder="Nom complet" value="<?= $user->getFullname() ?>">
            <input type="email" name="email" placeholder="Email" value="<?= $user->getEmail() ?>">
            <input type="password" name="password" placeholder="Mot de passe">
            <input type="password" name="password_confirm" placeholder="Confirmer le mot de passe">
            <input type="submit" value="Modifier">
        </form>





    <?php endif; ?>


</body>
</html>