<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profile</title>
    <link rel="stylesheet" href="./assets/css/login.css">
</head>

<body>
    <?php
    require_once "header.php";
    ?>
    <div class="login-wrapper">
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
            <form method="post">
                <h3>Modifier mes informations</h3>
                <div class="input-box">
                    <div class="input-field">
                        <input type="text" name="fullname" placeholder="Nom complet" value="<?= $user->getFullname() ?>">
                    </div>
                    <div class="input-field">
                        <input type="email" name="email" placeholder="Email" value="<?= $user->getEmail() ?>">
                    </div>
                </div>
                <div class="input-box">
                    <div class="input-field">
                        <input type="password" name="password" placeholder="Mot de passe">
                    </div>
                    <div class="input-field ">
                        <input type="submit" name="info" value="Modifier" class="profil-btn" >
                    </div>
                </div>
                <?php if (isset($result['messageInfo'])) : ?>
                    <p class=<?php $result['success'] ? 'success-message' : 'error-message' ?>><?= $result['messageInfo'] ?> </p>
                <?php endif; ?>
            </form>
            <form method="post">
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