<?php
session_start();
require_once(__DIR__ . '/../inc/requires.php');
$pageTitle = "Accueil";

if (!isset($_SESSION['LOGGED_USER'])) {
    redirectToUrl('../index.php');
}

$pdo = getPDO();
$apps = getAllApps($pdo);
$users = getAllUsers($pdo);

$pageTitle = "Accueil";
require_once(__DIR__ . '/../partials/header.html.php');
?>

<h1 class="mb-4">Site de partage de solutions logicielles</h1>

<div class="row">
    <?php foreach (getApps($apps) as $app) : ?>
        <div class="col-md-6 col-lg-4 mb-4">
            <div class="card h-100 shadow-sm border-primary">
                <div class="card-body d-flex flex-column">
                    <h4 class="card-title">
                        <a href="../apps/app_read.php?id=<?= $app['app_id']; ?>"
                           class="text-decoration-none text-primary"> <?= htmlspecialchars($app['name']); ?>
                            <span class="ms-2 text-info" style="font-size: 1rem;">
                                <i class="fa fa-hand-o-left"></i> Infos</span>
                        </a>
                    </h4>
                    <p class="card-text text-danger-emphasis"><i class="fa fa-file-code-o text-secondary"></i> <?= nl2br(htmlspecialchars($app['description'])); ?></p>
                    <span class="card-text"><i class="fa fa-download text-secondary"></i> Télécharger l'appli :
                    <a href="../files/<?= $app['file']; ?>"
                       class="text-decoration-none text-primary"> <?= htmlspecialchars($app['name']); ?>
                    </a></span>
                    <?php $commentCount = countComments($pdo, $app['app_id']); ?>
                    <p class="mt-2 mb-0">
                        <i class="fa fa-comments-o text-secondary"></i>
                        Commentaires : <?= $commentCount ?>
                    </p>
                    <p class="mt-2 mb-0 text-muted"><i class="fa fa-user text-secondary"></i>
                        <small>Créateur : <?= displayCreator($app['creator'], $users); ?></small>
                    </p>
                </div>
                <div class="card-footer bg-transparent border-top-0 d-flex justify-content-between">
                    <a href="../apps/app_update.html.php?id=<?= $app['app_id']; ?>" class="btn btn-sm btn-warning">
                        <i class="fa fa-pencil-square-o"></i> Modifier</a>
                    <a href="../apps/app_delete.php?id=<?= $app['app_id']; ?>"
                       class="btn btn-sm btn-danger"
                       onclick="return confirm('Etes-vous certain de vouloir supprimer cette application ? Cette action est irréversible.');">
                        <i class="fa fa-trash-o"></i> Supprimer
                    </a>
                </div>
            </div>
        </div>
    <?php endforeach; ?>
</div>

<?php require_once(__DIR__ . '/../partials/footer.html.php'); ?>
