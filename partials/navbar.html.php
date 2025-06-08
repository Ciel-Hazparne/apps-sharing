<nav class="navbar navbar-expand-lg bg-primary" data-bs-theme="dark">
    <div class="container-fluid">
        <a class="navbar-brand" href="../pages/home.html.php"><img src="/images/LogoBtsCielIrHasparren.jpg" alt="Logo BTS CIEL IT Hasparren" width="50" height="50"> Apps Sharing</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent"
                aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <!-- Menu gauche -->
            <ul class="navbar-nav me-auto mb-5 mb-lg-0">
                <li class="nav-item">
                    <a class="nav-link" aria-current="page" href="../pages/home.html.php">
                        <i class="fa fa-home"></i> Accueil
                    </a>
                </li>
                <?php if (isset($_SESSION['LOGGED_USER'])) : ?>
                    <li class="nav-item">
                        <a class="nav-link" href="../apps/app_create.html.php">
                            <i class="fa fa-file-code-o"></i> Ajouter une appli
                        </a>
                    </li>
                <?php endif; ?>
            </ul>

            <!-- Menu droite -->
            <?php if (isset($_SESSION['LOGGED_USER'])) : ?>
                <ul class="navbar-nav ms-auto mb-5 mb-lg-0">
                    <li class="nav-item">
                        <a class="nav-link" href="#"><i class="fa fa-user-circle-o"></i>
                            <?= htmlspecialchars($_SESSION['LOGGED_USER']['email']) ?></a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="../users/profile.html.php"><i class="fa fa-user-circle"></i> Profil</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="../security/logout.php">
                            <i class="fa fa-sign-out"></i> Déconnexion
                        </a>
                    </li>
                </ul>
            <?php endif; ?>
        </div>
    </div>
</nav>
