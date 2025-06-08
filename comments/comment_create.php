<?php
session_start();

require_once(__DIR__ . '/../inc/requires.php');
require_once(__DIR__ . '/../security/isConnected.php');

$errors = [];
$success = false;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $app_id = (int) ($_POST['app_id'] ?? 0);
    $details = trim($_POST['details'] ?? '');
    $user_id = $_SESSION['LOGGED_USER']['user_id'] ?? 0;

    if ($app_id <= 0) {
        $errors[] = "Application inconnue.";
    }

    if ($user_id <= 0) {
        $errors[] = "Utilisateur non connecté.";
    }

    if ($details === '') {
        $errors[] = "Le commentaire ne peut pas être vide.";
    }

    if (empty($errors)) {
        $pdo = getPDO();
        createComment($pdo, $user_id, $app_id, $details);
        $_SESSION['flash'] = [
            'type' => 'success',
            'message' => "Votre commentaire a été publié avec succès."
        ];
        header("Location: ../apps/app_read.php?id=" . $app_id);
    } else {
        $_SESSION['flash'] = [
            'type' => 'danger',
            'message' => implode("<br>", $errors)
        ];
        header("Location: comment_create.html.php?app_id=" . $app_id);
    }
    exit;
}

header("Location: ../pages/home.php");
exit;
