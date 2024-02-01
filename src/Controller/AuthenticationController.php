<?php

namespace App\Controller;

use App\Model\User;

class AuthenticationController
{

    public function register($email, $password, $fullname)
    {
        if (isset($email) && isset($password) && isset($fullname)) {
            $email = htmlspecialchars($email);
            $fullname = htmlspecialchars($fullname);
        } else {
            return [
                'success' => false,
                'message' => 'Veuillez remplir tous les champs'
            ];
        }

        $user = new User();
        $result = $user->findOneByEmail($email);

        if ($result) {

            return [
                'success' => false,
                'message' => 'Cet email est déjà utilisé'
            ];
        } else {
            $user->setEmail($email);
            $user->setFullname($fullname);
            $user->setPassword(password_hash($password, PASSWORD_DEFAULT));
            $user->setRole(['ROLE_USER']);
            $user->create();
            return [
                'success' => true,
                'message' => 'Votre compte a bien été créé'
            ];
        }
    }

    public function login($email, $password)
    {
        if (isset($email) && isset($password)) {
            $email = htmlspecialchars($email);
        } else {
            return [
                'success' => false,
                'message' => 'Veuillez remplir tous les champs'
            ];
        }

        $user = new User();
        $result = $user->findOneByEmail($email);
        if ($result) {
            if (password_verify($password, $result->getPassword())) {
                $_SESSION['user'] = $result;
                return [
                    'success' => true,
                    'message' => 'Vous êtes connecté'
                ];
            } else {
                return [
                    'success' => false,
                    'message' => 'Les identifiants fournis ne correspondent à aucun utilisateurs'
                ];
            }
        } else {
            return [
                'success' => false,
                'message' => 'Les identifiants fournis ne correspondent à aucun utilisateurs'
            ];
        }
    }

    public function profile(){
        if(!isset($_SESSION['user'])){
            return false;
            
        }else{
            return true ;
        }
    }

    public function update($email, $password, $fullname)
    {
        if (isset($email) && isset($password) && isset($fullname)) {
            $email = htmlspecialchars($email);
            $fullname = htmlspecialchars($fullname);
        } else {
            return [
                'success' => false,
                'messageInfo' => 'Veuillez remplir tous les champs'
            ];
        }

        $user = new User($_SESSION['user']->getId(), $_SESSION['user']->getFullname(), $_SESSION['user']->getEmail(), $_SESSION['user']->getPassword(), $_SESSION['user']->getRole());
        $result = $user->findOneByEmail($email);

        if ($result) {

            return [
                'success' => false,
                'messageInfo' => 'Cet email est déjà utilisé'
            ];
        } else {

            if (password_verify($password, $_SESSION['user']->getPassword())) {
                $user->setEmail($email);
                $user->setFullname($fullname);
                $user->update();
                $_SESSION['user'] = $user;
                return [
                    'success' => true,
                    'messageInfo' => 'Votre compte a bien été modifié'
                ];
            } else {
                return [
                    'success' => false,
                    'messageInfo' => 'Les identifiants fournis ne correspondent à aucun utilisateurs'
                ];
            }
        }
    }

    public function updatePassword($old, $new, $confirmNew)
    {
        if (isset($old) && isset($new) && isset($confirmNew)) {
     
        } else {
            return [
                'success' => false,
                'message' => 'Veuillez remplir tous les champs'
            ];
        }

        if ($new !== $confirmNew) {
            return [
                'success' => false,
                'message' => 'Les mots de passe ne correspondent pas'
            ];
        }

        if (password_verify($old, $_SESSION['user']->getPassword())) {
            $user = new User($_SESSION['user']->getId(), $_SESSION['user']->getFullname(), $_SESSION['user']->getEmail(), $_SESSION['user']->getPassword(), $_SESSION['user']->getRole());
            $user->setPassword(password_hash($new, PASSWORD_DEFAULT));
            $user->update();
            $_SESSION['user'] = $user;
            return [
                'success' => true,
                'message' => 'Votre mot de passe a bien été modifié'
            ];
        } else {
            return [
                'success' => false,
                'message' => 'Les identifiants fournis ne correspondent à aucun utilisateurs'
            ];
        }

    }

    public function logout(){
        session_destroy();
        header('Location: ./login.php');
    }
}
