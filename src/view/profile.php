<?php
require_once './vendor/autoload.php';
session_start();

use App\Controller\AuthenticationController;

$auth = new AuthenticationController();

if (!$auth->profile()) {
    $message = "Vous n'êtes pas connecté vous allez être redirigé vers la page de connexion";
    header("refresh:3;url=login.php");
} else {
    $user = $_SESSION['user'];
}

if (isset($_POST['info'])) {
    $result = $auth->update($_POST['email'], $_POST['password'], $_POST['fullname']);
    $user = $_SESSION['user'];
}
if (isset($_POST['modifPassword'])) {
    $result = $auth->updatePassword($_POST['oldPassword'], $_POST['newPassword'], $_POST['confirmPassword']);
    $user = $_SESSION['user'];
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profile</title>
    <link rel="stylesheet" href="./assets/css/profile.css">
</head>

<body>
    <?php
    require_once "header.php";
    ?>
    <div class="profil-container">
    <?php if (isset($message)) : ?>
        <p><?= $message ?></p>
    <?php else : ?>
        <h1>Bonjour </h1>
        <p>Nom complet : <?= $user->getFullname() ?></p>
        <p>Email : <?= $user->getEmail() ?></p>
        <?php foreach ($user->getRole() as $role) {
            $role === 'ROLE_ADMIN' ? $role = 'Administrateur' : $role = 'Utilisateur';
            echo "<p>Role : $role</p>";
        } ?>


        <a href="logout.php">Déconnexion</a>
    <?php endif; ?>
    <?php if (isset($user)) : ?>
        <form action="profile.php" method="post">
            <h3>Modifier mes informations</h3>
            <input type="text" name="fullname" placeholder="Nom complet" value="<?= $user->getFullname() ?>">
            <input type="email" name="email" placeholder="Email" value="<?= $user->getEmail() ?>">
            <input type="password" name="password" placeholder="Mot de passe">
            <input type="submit" name="info" value="Modifier">
            <?php if (isset($result['messageInfo'])) : ?>
                <p class=<?php $result['success'] ? 'success-message' : 'error-message' ?>><?= $result['messageInfo'] ?> </p>
            <?php endif; ?>
        </form>
        <form action="profile.php" method="post">
            <h3>Modifier mon mot de passe</h3>
            <input type="password" name="oldPassword" placeholder="Ancien mot de passe">
            <input type="password" name="newPassword" placeholder="Nouveau mot de passe">
            <input type="password" name="confirmPassword" placeholder="Confirmer le mot de passe">
            <input type="submit" name="modifPassword" value="Modifier">
            <?php if (isset($result['message'])) : ?>
                <p class=<?php $result['success'] ? 'success-message' : 'error-message' ?>><?= $result['message'] ?> </p>
            <?php endif; ?>
        </form>





    <?php endif; ?>
    </div>


</body>

</html>