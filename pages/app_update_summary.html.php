<?php
session_start();
require_once(__DIR__ . '/../partials/header.html.php');
?>

<div class="container mt-4">

    <?php if (isset($_SESSION['flash'])): ?>
        <div class="alert alert-<?= htmlspecialchars($_SESSION['flash']['type']) ?>">
            <?= htmlspecialchars($_SESSION['flash']['message']) ?>
        </div>
    <?php endif; ?>

    <?php if (
        isset($_SESSION['flash']['type']) &&
        $_SESSION['flash']['type'] === 'success' &&
        isset($_SESSION['updated_app'])
    ):
        $app = $_SESSION['updated_app'];
        ?>
        <h1>Récapitulatif de l'application mise à jour</h1>

        <div class="card">
            <div class="card-body">
                <h5 class="card-title"><?= htmlspecialchars($app['name']) ?></h5>
                <p class="card-text"><?= nl2br(htmlspecialchars($app['description'])) ?></p>
                <p class="card-text"><b>Auteur :</b> <?= htmlspecialchars($app['creator']) ?></p>
                <p class="card-text"><b>Fichier :</b> <?= htmlspecialchars($app['file']) ?></p>
                <a class="btn btn-dark mt-3" href="/index.php">
                    <i class="fa fa-reply"></i> Retour
                </a>
            </div>
        </div>
    <?php endif; ?>

</div>

<?php
// Nettoyage des sessions temporaires
unset($_SESSION['flash'], $_SESSION['updated_app']);
require_once(__DIR__ . '/../partials/footer.html.php');
?>