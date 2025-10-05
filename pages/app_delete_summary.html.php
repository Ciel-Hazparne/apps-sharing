<?php
session_start();
require_once(__DIR__ . '/../partials/header.html.php');
?>

<div class="container mt-4">

    <?php if (isset($_SESSION['flash'])): ?>
        <div class="alert alert-<?= htmlspecialchars($_SESSION['flash']['type']) ?>">
            <?= $_SESSION['flash']['message'] ?>
        </div>
    <?php endif; ?>

    <?php if (
        isset($_SESSION['flash']['type']) &&
        $_SESSION['flash']['type'] === 'success' &&
        isset($_SESSION['deleted_app'])
    ):
        $app = $_SESSION['deleted_app'];
        ?>
        <h1>Application supprimée</h1>

        <div class="card border-danger">
            <div class="card-body">
                <h5 class="card-title text-danger">
                    <?= htmlspecialchars($app['name']) ?>
                </h5>
                <p class="card-text"><b>Auteur :</b> <?= htmlspecialchars($app['creator']) ?></p>
                <p class="card-text"><b>Description :</b><br><?= nl2br(htmlspecialchars($app['description'])) ?></p>

                <?php if (!empty($app['file'])): ?>
                    <p class="card-text text-muted">
                        <b>Fichier supprimé :</b> <?= htmlspecialchars($app['file']) ?>
                    </p>
                <?php endif; ?>

                <a href="/index.php" class="btn btn-dark mt-3">
                    <i class="fa fa-reply"></i> Retour à l’accueil
                </a>
            </div>
        </div>
    <?php endif; ?>

</div>

<?php
// Nettoyage des variables temporaires
unset($_SESSION['flash'], $_SESSION['deleted_app']);
require_once(__DIR__ . '/../partials/footer.html.php');
?>