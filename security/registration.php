<?php
session_start();
require_once(__DIR__ . '/../inc/requires.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $full_name = $_POST['full_name'];
    $age = $_POST['age'];
    $email = trim($_POST['email'] ?? '');
    $password = $_POST['password'] ?? '';
    $passwordConfirm = $_POST['password_confirm'] ?? '';

    if (!filter_var($email, FILTER_VALIDATE_EMAIL) || strlen($password) < 6) {
        $_SESSION['registration_error'] = "Email invalide ou mot de passe trop court (min. 6 caractères).";
        header('Location: registration.html.php');
        exit;
    }
    if ($password !== $passwordConfirm) {
        $_SESSION['registration_error'] = "Les mots de passe ne correspondent pas.";
        header('Location: registration.html.php');
        exit;
    }

    $pdo = getPDO();

    // Vérifier si l'email existe déjà
    if (getUserByEmail($pdo, $email)) {
        $_SESSION['registration_error'] = "Un compte existe déjà avec cette adresse email.";
        header('Location: registration.html.php');
        exit;
    }

    // Créer l'utilisateur
    if (createUser($pdo, $full_name, $age, $email, $password)) {
        $_SESSION['LOGGED_USER'] = ['email' => $email];
        header('Location: ../pages/home.html.php');
        exit;
    }

    $_SESSION['registration_error'] = "Erreur lors de la création du compte.";
    header('Location: registration.html.php');
    exit;
}

