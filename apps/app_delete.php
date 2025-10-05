<?php
session_start();
require_once(__DIR__ . '/../inc/requires.php');

// --- Validation de l'identifiant ---
if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    $_SESSION['flash'] = [
            'type' => 'danger',
            'message' => "Identifiant manquant ou invalide."
    ];
    header('Location: /index.php');
    exit;
}

$id = (int) $_GET['id'];
$pdo = getPDO();

// --- Vérification de l'application ---
$app = retrieveApp($pdo, $id);
if (!$app) {
    $_SESSION['flash'] = [
            'type' => 'danger',
            'message' => "Application introuvable."
    ];
    header('Location: /index.php');
    exit;
}

// --- Suppression du fichier associé ---
if (!empty($app['file'])) {
    $filePath = __DIR__ . '/../files/' . $app['file'];
    if (file_exists($filePath)) {
        unlink($filePath);
    }
}

// --- Suppression en base ---
$deleted = deleteApp($pdo, $id);

// --- Message flash et stockage temporaire ---
if ($deleted) {
    $_SESSION['flash'] = [
            'type' => 'success',
            'message' => "L'application <b>" . htmlspecialchars($app['name']) . "</b> a été supprimée avec succès."
    ];
    $_SESSION['deleted_app'] = [
            'name' => $app['name'],
            'description' => $app['description'],
            'creator' => $app['creator'] ?? 'inconnu',
            'file' => $app['file']
    ];
} else {
    $_SESSION['flash'] = [
            'type' => 'danger',
            'message' => "Une erreur est survenue lors de la suppression."
    ];
}

// --- Redirection vers la page de récapitulatif ---
header('Location: /pages/app_delete_summary.html.php');
exit;