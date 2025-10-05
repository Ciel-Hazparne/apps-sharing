<?php
session_start();
require_once(__DIR__ . '/../inc/requires.php');
require_once(__DIR__ . '/../partials/header.html.php');

$pageTitle = "Mise à jour App";

// Récupération des données GET
$id = (int)($_GET['id'] ?? 0);
if ($id <= 0) {
    $_SESSION['flash'] = [
            'type' => 'danger',
            'message' => "Identifiant de l'application manquant."
    ];
    header('Location: app_update.html.php');
    exit;
}

$pdo = getPDO();
$app = retrieveApp($pdo, $id);
if (!$app) {
    $_SESSION['flash'] = [
            'type' => 'danger',
            'message' => "Aucune application trouvée."
    ];
    header('Location: app_update.html.php');
    exit;
}

// Pré-remplissage en cas d'erreur précédente
$name = $_SESSION['form_data']['name'] ?? $app['name'];
$description = $_SESSION['form_data']['description'] ?? $app['description'];
unset($_SESSION['form_data']);
?>

<div class="container mt-4">

    <?php if (isset($_SESSION['flash'])): ?>
        <div class="alert alert-<?= htmlspecialchars($_SESSION['flash']['type']) ?> alert-dismissible fade show" role="alert">
            <?= htmlspecialchars($_SESSION['flash']['message']) ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
        <?php unset($_SESSION['flash']); ?>
    <?php endif; ?>

    <h1>Mettre à jour <?= htmlspecialchars($app['name']); ?></h1>
    <form action="../apps/app_update.php" method="POST" enctype="multipart/form-data">
        <input type="hidden" name="id" value="<?= $app['app_id']; ?>">

        <div class="mb-3">
            <label for="name" class="form-label">Nom de l'application</label>
            <input type="text" class="form-control" id="name" name="name" required value="<?= htmlspecialchars($name) ?>">
        </div>

        <div class="mb-3">
            <label for="description" class="form-label">Description de l'application</label>
            <textarea class="form-control" id="description" name="description" required placeholder="Fonctionnalités essentielles en quelques lignes."><?= htmlspecialchars($description) ?></textarea>
        </div>

        <div class="mb-3">
            <label for="file" class="form-label">Remplacer le fichier (ZIP)</label>
            <input type="file" class="form-control" id="file" name="file">
            <?php if (!empty($app['file'])): ?>
                <p>Fichier actuel : <a href="../files/<?= htmlspecialchars($app['file']) ?>" target="_blank"><?= htmlspecialchars($app['file']) ?></a></p>
            <?php endif; ?>
        </div>

        <div class="mt-4 d-flex justify-content-between">
            <a href="../pages/home.html.php" class="btn btn-dark">
                <i class="fa fa-reply"></i> Retour
            </a>
            <button type="submit" class="btn btn-success">
                <i class="fa fa-check"></i> Mettre à jour
            </button>
        </div>
    </form>
</div>

<?php require_once(__DIR__ . '/../partials/footer.html.php'); ?>