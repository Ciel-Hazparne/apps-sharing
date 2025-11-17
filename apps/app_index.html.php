<?php
session_start();
require_once(__DIR__ . '/../inc/requires.php');
$pageTitle = "Liste Apps";

if (!isset($_SESSION['LOGGED_USER'])) {
    redirectToUrl('../index.php');
}

$pdo = getPDO();
$apps = getAllApps($pdo);
$users = getAllUsers($pdo);

$pageTitle = "Accueil";
require_once(__DIR__ . '/../partials/header.html.php');
?>

<h1 class="mb-4">Liste des applications</h1>
<table class="table table-bordered table-striped align-middle">
    <thead class="table-dark">
    <tr>
        <th>ID</th>
        <th>Nom</th>
        <th>Description</th>
        <th>Fichier</th>
        <th>Créateur</th>
        <th>Commentaires</th>
        <th>Actions</th>
    </tr>
    </thead>
    <tbody>
    <?php foreach (getApps($apps) as $app) : ?>
        <tr>
            <td><?= $app['app_id']; ?></td>
            <td>
                <a href="../apps/app_read.php?id=<?= $app['app_id']; ?>"
                   class="text-decoration-none text-primary">
                    <?= htmlspecialchars($app['name']); ?>
                </a>
            </td>
            <td><?= nl2br(htmlspecialchars($app['description'])); ?></td>
            <td>
                <a href="../files/<?= $app['file']; ?>"
                   class="text-decoration-none">Télécharger</a>
            </td>
            <td><?= displayCreator($app['creator'], $users); ?></td>
            <td><?= countComments($pdo, $app['app_id']); ?></td>
            <td>
                <a href="../apps/app_update.html.php?id=<?= $app['app_id']; ?>" class="btn btn-warning btn-sm"><i class="fa fa-pencil-square-o"></i> Modifier</a>
                <a href="../apps/app_delete.php?id=<?= $app['app_id']; ?>"
                   class="btn btn-danger btn-sm"
                   onclick="return confirm('Confirmer la suppression ?');"><i class="fa fa-trash-o"></i> Supprimer</a>
            </td>
        </tr>
    <?php endforeach; ?>
    </tbody>
</table>

<div class="mt-4 d-flex justify-content-start gap-2">
    <a href="../pages/home.html.php" class="btn btn-dark">
        <i class="fa fa-reply"></i> Retour
    </a>
    <a href="../apps/app_create.html.php" class="btn btn-success">
        <i class="fa fa-upload"></i> Ajouter une application
    </a>
</div>

