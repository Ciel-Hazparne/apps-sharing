<?php
session_start();

require_once(__DIR__ . '/../inc/requires.php');
require_once(__DIR__ . '/../security/isConnected.php');
require_once(__DIR__ . '/../partials/header.html.php');

if (isset($_SESSION['flash'])): ?>
    <div class="alert alert-<?= $_SESSION['flash']['type']; ?>">
        <?= $_SESSION['flash']['message']; ?>
    </div>
    <?php unset($_SESSION['flash']); ?>
<?php endif; ?>

<?php
if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    echo "Pas d'identifiant d'application valide.";
    return;
}

$id = (int)$_GET['id'];
$pdo = getPDO();
$appDetails = showApp($pdo, $id);

if (empty($appDetails)) {
    echo "L'application n'existe pas.";
    return;
}

$app = [
    'app_id'      => $appDetails[0]['app_id'],
    'name'        => $appDetails[0]['name'],
    'description' => $appDetails[0]['description'],
    'creator'     => $appDetails[0]['creator'],
    'file'        => $appDetails[0]['file'],
    'comments'    => [],
];

foreach ($appDetails as $detail) {
    if (!empty($detail['comment_id'])) {
        $app['comments'][] = [
            'comment_id' => $detail['comment_id'],
            'details'    => $detail['details'],
            'user_id'    => (int) $detail['user_id'],
            'full_name'  => $detail['full_name'],
            'created_at' => $detail['comment_date'],
        ];
    }
}
?>

<h1><?= htmlspecialchars($app['name']) ?></h1>

<div class="row">
    <article class="col">
        <p><?= nl2br(htmlspecialchars($app['description'])) ?></p>
        <?php if (!empty($app['file'])) : ?>
            <a href="../files/<?= htmlspecialchars($app['file']); ?>" class="btn btn-sm btn-success mt-2" download>
                <i class="fa fa-download"></i> Télécharger l’application
            </a>
        <?php endif; ?>
    </article>
    <aside class="col">
        <p><i>Crée par <?= htmlspecialchars($app['creator']) ?></i></p>
    </aside>
</div>

<hr>
<h2>Commentaires</h2>

<?php if (!empty($app['comments'])) : ?>
    <?php foreach ($app['comments'] as $comment) : ?>
        <div class="comment mb-3">
            <p><strong><?= htmlspecialchars($comment['full_name']) ?></strong> — <?= $comment['created_at'] ?></p>
            <p><?= nl2br(htmlspecialchars($comment['details'])) ?></p>
        </div>
    <?php endforeach; ?>
<?php else : ?>
    <p>Aucun commentaire pour le moment.</p>
<?php endif; ?>

<hr>
<?php if (isset($_SESSION['LOGGED_USER'])) : ?>
    <div class="mb-3">
        <a href="../comments/comment_create.html.php?app_id=<?= $app['app_id']; ?>"
           class="btn btn-primary"><i class="fa fa-pencil-square-o"></i> Laisser un commentaire
        </a>
    </div>
<?php endif; ?>

<div class="mt-4">
    <a href="../pages/home.php" class="btn btn-dark">
        <i class="fa fa-reply"></i> Retour
    </a>
</div>

<?php require_once(__DIR__ . '/../partials/footer.html.php'); ?>
