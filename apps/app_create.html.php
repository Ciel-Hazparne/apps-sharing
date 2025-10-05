<?php
session_start();
require_once(__DIR__ . '/../security/isConnected.php');
require_once(__DIR__ . '/../partials/header.html.php');

$pageTitle = "Création App";
?>

<div class="container mt-4">

    <?php if (isset($_SESSION['flash'])): ?>
        <div class="alert alert-<?= htmlspecialchars($_SESSION['flash']['type']) ?> alert-dismissible fade show" role="alert">
            <?= htmlspecialchars($_SESSION['flash']['message']) ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
        <?php unset($_SESSION['flash']); ?>
    <?php endif; ?>

    <h1>Ajouter une application</h1>
    <form action="../apps/app_create.php" method="POST" enctype="multipart/form-data">
        <div class="mb-3">
            <label for="name" class="form-label">Nom de l'application</label>
            <input type="text" class="form-control" id="name" name="name" required value="<?= htmlspecialchars($name) ?>">
        </div>

        <div class="mb-3">
            <label for="description" class="form-label">Description de l'application</label>
            <textarea class="form-control" id="description" name="description" required placeholder="Fonctionnalités essentielles en quelques lignes."><?= htmlspecialchars($description) ?></textarea>
        </div>

        <div class="mb-3">
            <label for="file" class="form-label">Importez votre application compressée (format ZIP)</label>
            <input type="file" class="form-control" id="file" name="file" required>
        </div>

        <div class="mt-4 d-flex justify-content-between">
            <a href="../pages/home.html.php" class="btn btn-dark">
                <i class="fa fa-reply"></i> Retour
            </a>
            <button type="submit" class="btn btn-success">
                <i class="fa fa-upload"></i> Ajouter
            </button>
        </div>
    </form>
</div>

<?php require_once(__DIR__ . '/../partials/footer.html.php'); ?>
