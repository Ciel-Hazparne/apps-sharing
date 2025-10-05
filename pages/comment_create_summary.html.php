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
        isset($_SESSION['created_comment'])
    ):
        $comment = $_SESSION['created_comment'];
        ?>
        <h1>Commentaire ajouté</h1>

        <div class="card">
            <div class="card-body">
                <p class="card-text"><b>Utilisateur :</b> <?= htmlspecialchars($comment['user_id']) ?></p>
                <p class="card-text"><b>Application :</b> <?= htmlspecialchars($comment['app_id']) ?></p>
                <p class="card-text"><b>Commentaire :</b><br><?= nl2br(htmlspecialchars($comment['details'])) ?></p>

                <a href="../apps/app_read.php?id=<?= urlencode($comment['app_id']) ?>" class="btn btn-dark mt-3">
                    <i class="fa fa-reply"></i> Retour à l'application
                </a>
            </div>
        </div>
    <?php endif; ?>

</div>

<?php
// Nettoyage des variables temporaires
unset($_SESSION['flash'], $_SESSION['created_comment']);
require_once(__DIR__ . '/../partials/footer.html.php');
?>