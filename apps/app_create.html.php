<?php
session_start();

require_once(__DIR__ . '/../security/isConnected.php');
require_once(__DIR__ . '/../partials/header.html.php');
$pageTitle = "Création App";
?>
<div>
    <h1>Ajouter une appli</h1>
    <form action="app_create.php" method="POST" enctype="multipart/form-data">
        <div class="mb-3">
            <label for="name" class="form-label">Nom de l'appli</label>
            <input type="text" class="form-control" id="name" name="name" required>
        </div>
        <div class="mb-3">
            <label for="description" class="form-label">Description de l'appli</label>
            <label for="description"></label>
            <textarea class="form-control" placeholder="Fonctionnalités essentielles en quelques lignes." id="description" name="description" required></textarea>
        </div>
        <div class="mb-3">
            <label for="file">Importez votre appli compressée (format Zip)</label>
            <input type="file" class="form-control" id="file" name="file" required>
        </div>

        <div class="mt-4">
            <a href="../pages/home.html.php" class="btn btn-dark">
                <i class="fa fa-reply"></i> Retour
            </a>
            <button type="submit" class="btn btn-success"><i class="fa fa-upload"></i> Ajouter</button>
        </div>
    </form>
</div>

<?php require_once(__DIR__ . '/../partials/footer.html.php'); ?>