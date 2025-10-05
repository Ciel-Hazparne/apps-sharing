<?php
session_start();
require_once(__DIR__ . '/../inc/requires.php');

// --- Validation des champs ---
if (
        empty($_POST['id']) || !is_numeric($_POST['id']) ||
        empty($_POST['name']) ||
        empty($_POST['description']) ||
        trim(strip_tags($_POST['name'])) === '' ||
        trim(strip_tags($_POST['description'])) === ''
) {
    $_SESSION['flash'] = [
            'type' => 'danger',
            'message' => "Tous les champs sont obligatoires."
    ];
    header('Location: /index.php');
    exit;
}

$id = (int) $_POST['id'];
$name = trim(strip_tags($_POST['name']));
$description = trim(strip_tags($_POST['description']));
$creator = $_SESSION['LOGGED_USER']['email'] ?? 'unknown';

$pdo = getPDO();

// --- Récupération du fichier existant ---
$app = retrieveApp($pdo, $id);
$oldFile = $app['file'] ?? null;
$fileName = $oldFile;

// --- Gestion d’un nouveau fichier uploadé ---
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

    // Supprime l'ancien fichier
    if ($oldFile && file_exists(__DIR__ . '/../files/' . $oldFile)) {
        unlink(__DIR__ . '/../files/' . $oldFile);
    }

    // Nouveau nom : exemple app_68e23975912239.21587666.zip
    $fileName = uniqid('app_', true) . '.zip';
    $destPath = __DIR__ . '/../files/' . $fileName;
    move_uploaded_file($fileTmpPath, $destPath);
}

// --- Mise à jour en BDD ---
$success = updateApp($pdo, $id, $name, $description, $creator, $fileName);

// --- Définition du message flash et redirection vers pages pour affichage ---
if ($success) {
    $_SESSION['flash'] = [
            'type' => 'success',
            'message' => "Votre application a été mise à jour avec succès."
    ];
    $_SESSION['updated_app'] = [
            'name' => $name,
            'description' => $description,
            'creator' => $creator,
            'file' => $fileName
    ];
} else {
    $_SESSION['flash'] = [
            'type' => 'danger',
            'message' => "Une erreur est survenue lors de la mise à jour."
    ];
}

header('Location: /pages/app_update_summary.html.php');
exit;