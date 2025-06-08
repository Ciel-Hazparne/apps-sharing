<?php
session_start();

require_once(__DIR__ . '/../inc/requires.php');
require_once(__DIR__ . '/../security/isConnected.php');
require_once(__DIR__ . '/../partials/header.html.php');
$pageTitle = "création commentaire";

if (isset($_SESSION['flash'])): ?>
    <div class="alert alert-<?= $_SESSION['flash']['type']; ?>">
        <?= $_SESSION['flash']['message']; ?>
    </div>
    <?php unset($_SESSION['flash']); ?>
<?php endif; ?>

<?php
$app_id = isset($_GET['app_id']) ? (int) $_GET['app_id'] : 0;
?>

<h1>Ajouter un commentaire</h1>

<form action="comment_create.php" method="POST">
    <input type="hidden" name="app_id" value="<?= $app_id; ?>">

    <div class="mb-3">
        <label for="details" class="form-label">Votre commentaire</label>
        <textarea class="form-control" id="details" name="details" rows="4" required></textarea>
    </div>

    <button type="submit" class="btn btn-success">Envoyer</button>
    <a href="../apps/app_show.php?id=<?= $app_id; ?>" class="btn btn-secondary">Annuler</a>
</form>

<?php require_once(__DIR__ . '/../partials/footer.html.php'); ?>
