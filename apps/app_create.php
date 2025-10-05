<?php
session_start();
require_once(__DIR__ . '/../inc/requires.php');

// --- Validation des champs obligatoires ---
if (
        empty($_POST['name']) ||
        empty($_POST['description']) ||
        trim(strip_tags($_POST['name'])) === '' ||
        trim(strip_tags($_POST['description'])) === ''
) {
    $_SESSION['flash'] = [
            'type' => 'danger',
            'message' => "Le nom et la description de l'application sont obligatoires."
    ];
    header('Location: /index.php');
    exit;
}

// --- Nettoyage et préparation des données ---
$name = trim(strip_tags($_POST['name']));
$description = trim(strip_tags($_POST['description']));
$creator = $_SESSION['LOGGED_USER']['email'] ?? 'unknown';
$uploadDir = __DIR__ . '/../files/';

// --- Gestion du fichier ZIP ---
if (!empty($_FILES['file']) && $_FILES['file']['error'] === UPLOAD_ERR_OK) {
    $fileTmpPath = $_FILES['file']['tmp_name'];
    $originalName = basename($_FILES['file']['name']);
    $fileExtension = strtolower(pathinfo($originalName, PATHINFO_EXTENSION));

    if ($fileExtension !== 'zip') {
        $_SESSION['flash'] = [
                'type' => 'danger',
                'message' => "Le fichier doit être au format ZIP."
        ];
        header('Location: /index.php');
        exit;
    }

    // Génération d’un nom unique et déplacement du fichier
    $file = uniqid('app_', true) . '.zip';
    $destPath = $uploadDir . $file;

    if (!move_uploaded_file($fileTmpPath, $destPath)) {
        $_SESSION['flash'] = [
                'type' => 'danger',
                'message' => "Erreur lors du téléchargement du fichier."
        ];
        header('Location: /index.php');
        exit;
    }
}

// --- Insertion en BDD ---
$pdo = getPDO();
$success = createApp($pdo, $name, $description, $creator, $file);

// --- Flash message + redirection ---
if ($success) {
    $_SESSION['flash'] = [
            'type' => 'success',
            'message' => "Votre application a été ajoutée avec succès."
    ];
    $_SESSION['created_app'] = [
            'name' => $name,
            'description' => $description,
            'creator' => $creator,
            'file' => $file
    ];
} else {
    $_SESSION['flash'] = [
            'type' => 'danger',
            'message' => "Une erreur est survenue lors de l'ajout de votre application."
    ];
}
// --- Redirection vers la page de récapitulatif ---
header('Location: /pages/app_create_summary.html.php');
exit;