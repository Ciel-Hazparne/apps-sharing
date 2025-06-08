<?php
session_start();
require_once(__DIR__ . '/../inc/requires.php');

// Récupération des données du formulaire
$dataApp = $_POST;

// Vérification des champs obligatoires
if (
    empty($dataApp['name']) ||
    empty($dataApp['description']) ||
    trim(strip_tags($dataApp['name'])) === '' ||
    trim(strip_tags($dataApp['description'])) === ''
) {
    echo "Il faut le nom de l'application et sa description pour soumettre le formulaire.";
    return;
}

// Nettoyage des données
$name = trim(strip_tags($dataApp['name']));
$description = trim(strip_tags($dataApp['description']));
$creator = $_SESSION['LOGGED_USER']['email'];

// Gestion du fichier ZIP
$uploadDir = __DIR__ . '/../files/';
$file = null;

if (
    isset($_FILES['file']) &&
    $_FILES['file']['error'] === UPLOAD_ERR_OK
) {
    $fileTmpPath = $_FILES['file']['tmp_name'];
    $originalName = basename($_FILES['file']['name']);
    $fileExtension = strtolower(pathinfo($originalName, PATHINFO_EXTENSION));

    if ($fileExtension !== 'zip') {
        echo "Le fichier doit être au format ZIP.";
        return;
    }

    // Nom unique pour éviter les collisions
    $file = uniqid('app_', true) . '.zip';
    $destPath = $uploadDir . $file;

    if (!move_uploaded_file($fileTmpPath, $destPath)) {
        echo "Erreur lors du téléchargement du fichier.";
        return;
    }
}

// Insertion en base
$pdo = getPDO();
$createdApp = createApp($pdo, $name, $description, $creator, $file);
?>

<?php require_once(__DIR__ . '/../partials/header.html.php'); ?>

<h1>Appli ajoutée avec succès !</h1>

<div class="card">
    <div class="card-body">
        <h5 class="card-title"><?= htmlspecialchars($name) ?></h5>
        <p class="card-text"><b>Email</b> : <?= htmlspecialchars($creator) ?></p>
        <p class="card-text"><b>Description</b> : <?= nl2br(htmlspecialchars($description)) ?></p>
        <?php if ($file): ?>
            <p class="card-text"><b>Fichier</b> : <a href="../files/<?= $file ?>" target="_blank"><?= $file ?></a></p>
        <?php endif; ?>
        <a href="../pages/home.html.php" class="btn btn-dark">
            <i class="fa fa-reply"></i> Retour à l'accueil
        </a>
    </div>

</div>

<?php require_once(__DIR__ . '/../partials/footer.html.php'); ?>
