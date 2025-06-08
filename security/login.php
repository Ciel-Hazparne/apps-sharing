<?php

session_start();
require_once(__DIR__ . '/../inc/requires.php');

$pdo = getPDO(); // on instancie PDO
$users = getAllUsers($pdo); // on récupère les utilisateurs

$loginData = $_POST;

if (isset($loginData['email']) && isset($loginData['password'])) {
    if (!filter_var($loginData['email'], FILTER_VALIDATE_EMAIL)) {
        $_SESSION['LOGIN_ERROR_MESSAGE'] = 'Email incorrect ou invalide';
    } else {
        foreach ($users as $user) {
            if (
                $user['email'] === $loginData['email'] &&
                $user['password'] === $loginData['password']
            ) {
                $_SESSION['LOGGED_USER'] = [
                    'email' => $user['email'],
                    'user_id' => $user['user_id'],
                ];
            }
        }

        if (!isset($_SESSION['LOGGED_USER'])) {
            $_SESSION['LOGIN_ERROR_MESSAGE'] = sprintf(
                'Les informations envoyées ne permettent pas de vous identifier : (%s/%s)',
                $loginData['email'],
                strip_tags($loginData['password'])
            );
        }
    }

    // Redirige vers home si connecté, sinon retour au login
    if (isset($_SESSION['LOGGED_USER'])) {
        redirectToUrl('../pages/home.html.php');
    } else {
        redirectToUrl('login.html.php');
    }
}
