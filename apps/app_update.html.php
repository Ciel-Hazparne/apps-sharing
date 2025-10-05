<?php
session_start();

require_once(__DIR__ . '/../inc/requires.php');
$pageTitle = "Mise à jour App";

$dataApp = $_GET;

if (!isset($dataApp['id']) || !is_numeric($dataApp['id'])) {
    echo "Il faut indiquer l'identifiant de l'application pour la modifier.";
    return;
}

// Insertion via la fonction
$pdo = getPDO();
$id = (int)$_GET['id'];// on instancie PDO
$app = retrieveApp($pdo, $id);

if (!$app) {
    echo "Aucune application trouvée.";
    return;
}
?>

<?php require_once(__DIR__ . '/../partials/header.html.php'); ?>

    <div>
        <h1>Mettre à jour <?= $app['name']; ?></h1>
        <form action="app_update.php" method="POST" enctype="multipart/form-data">
            <div class="mb-3">
                <input type="hidden" class="form-control" id="id" name="id" value="<?= $app['app_id']; ?>">
            </div>
            <div class="mb-3">
                <label for="name" class="form-label">Nom de l'appli</label>
                <input type="text" class="form-control" id="name" name="name" value="<?= htmlspecialchars($app['name']) ?>">
            </div>
            <div class="mb-3">
                <label for="description" class="form-label">Description de l'appli</label>
                <textarea class="form-control" placeholder="Fonctionnalités essentielles en quelques lignes." id="description"
                          name="description"><?= $app['description']; ?></textarea>
            </div>
            <div class="mb-3">
                <label for="file" class="form-label">Remplacer le fichier (ZIP)</label>
                <input type="file" class="form-control" id="file" name="file">
                <?php if (!empty($app['file'])): ?>
                    <p>Fichier actuel : <a href="../files/<?= htmlspecialchars($app['file']) ?>" target="_blank"><?= htmlspecialchars($app['file']) ?></a></p>
                <?php endif; ?>
            </div>
            <div class="mt-4">
                <a href="../pages/home.html.php" class="btn btn-dark">
                    <i class="fa fa-reply"></i> Retour
                </a>
                <button type="submit" class="btn btn-success"><i class="fa fa-check"></i> Mettre à jour</button>
            </div>
        </form>
        <br/>
    </div>

<?php require_once(__DIR__ . '/../partials/footer.html.php'); ?>