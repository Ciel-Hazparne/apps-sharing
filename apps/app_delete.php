<?php
session_start();
require_once(__DIR__ . '/../inc/requires.php');

if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    echo "Identifiant manquant.";
    return;
}

$id = (int)$_GET['id'];

$pdo = getPDO();
$app = retrieveApp($pdo, $id);

if (!$app) {
    echo "Application introuvable.";
    return;
}

// Supprime le fichier
if (!empty($app['file'])) {
    $filePath = __DIR__ . '/../files/' . $app['file'];
    if (file_exists($filePath)) {
        unlink($filePath);
    }
}

// Supprime de la base
$deleted = deleteApp($pdo, $id);

require_once(__DIR__ . '/../partials/header.html.php');
?>

<div>
    <?php if ($deleted): ?>
        <h1>Application supprimée avec succès</h1>
        <a href="/index.php" class="btn btn-secondary"><i class="fa fa-reply"></i> Retour à l’accueil</a>
    <?php else: ?>
        <div class="alert alert-danger">La suppression a échoué.</div>
    <?php endif; ?>
</div>

<?php require_once(__DIR__ . '/../partials/footer.html.php'); ?>
