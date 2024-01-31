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
}
