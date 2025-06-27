<!DOCTYPE html>
<html lang="en">
    <head>
        <?php include(__DIR__ . "/../composant/head.php"); ?>
        <link rel="stylesheet" href="<?= SITE_ROOT ?>/assets/css/main.css">
        <?= $viewData['CSSFiles'] ?>
    </head>
    <body>
        <header>
            <div>
                <a href="/">
                    <img src="<?= SITE_ROOT ?>/assets/img/logo.png" alt="LOGO" id="Logo" />
                    <h1>AT-Dispos Demo</h1>
                </a>
                <span><i class="fa-solid fa-bars"></i></span>
            </div>
        </header>
        <div class="content background-color">
            <nav>
                <aside>
                    <h3>Bienvenue <?= $viewData['currentUser']->prenom ?></h3>
                    <hr>
                    <h3>Utilisateur</h3>
                    <ul>
                        <li><a href="<?= SITE_ROOT ?>/settings">Mes paramètres</a></li>
                        <li><a href="<?= SITE_ROOT ?>/logout">Se déconnecter</a></li>
                    </ul>
                    <?php
                        if (count($viewData['roles']) > 1) {
                            ?>
                        <hr>
                        <h3>Changement de vue</h3>
                        <ul>
                            <?php
                                foreach ($viewData['roles'] as $role) {
                                    switch ($role->id) {
                                        case 2:
                                            echo '<li><a href=" '. SITE_ROOT . '/responsable">Responsable</a></li>';
                                            break;
                                        case 1:
                                            echo '<li><a href=" '. SITE_ROOT . '/admin">Administrateur</a></li>';
                                            break;
                                    }
                                }
                            ?>
                        </ul>
                    <?php } ?>
                    <hr>
                    <h3>Planning</h3>
                    <ul>
                        <li><a href="<?= SITE_ROOT ?>/formateur/calendrier">Calendrier</a></li>
                        <li><a href="<?= SITE_ROOT ?>/formateur/disponibilite">Disponibilités</a></li>
                        <li><a href="<?= SITE_ROOT ?>/formateur/calendrier/responsable">Ajout d'un Responsable</a></li>
                    </ul>
                </aside>
            </nav>
            <main class="border-left">
                <?= $content ?>
            </main>
        </div>
        <footer>
            <a href="<?= SITE_ROOT ?>/mentions-legales">Mentions légales</a>
        </footer>
        <?= $viewData['JSFiles'] ?>
    </body>
</html>