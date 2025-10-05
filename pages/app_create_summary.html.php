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
        isset($_SESSION['created_app'])
    ):
        $app = $_SESSION['created_app'];
        ?>
        <h1>Récapitulatif de l'application ajoutée</h1>

        <div class="card">
            <div class="card-body">
                <h5 class="card-title"><?= htmlspecialchars($app['name']) ?></h5>
                <p class="card-text"><b>Email :</b> <?= htmlspecialchars($app['creator']) ?></p>
                <p class="card-text"><b>Description :</b><br><?= nl2br(htmlspecialchars($app['description'])) ?></p>

                <?php if (!empty($app['file'])): ?>
                    <p class="card-text">
                        <b>Fichier :</b>
                        <a href="../files/<?= htmlspecialchars($app['file']) ?>" target="_blank">
                            <?= htmlspecialchars($app['file']) ?>
                        </a>
                    </p>
                <?php endif; ?>

                <a href="../pages/home.html.php" class="btn btn-dark mt-3">
                    <i class="fa fa-reply"></i> Retour à l'accueil
                </a>
            </div>
        </div>
    <?php endif; ?>

</div>

<?php
// Nettoyage des données temporaires
unset($_SESSION['flash'], $_SESSION['created_app']);
require_once(__DIR__ . '/../partials/footer.html.php');
?>