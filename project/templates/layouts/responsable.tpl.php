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
                                        case 3:
                                            echo '<li><a href=" '. SITE_ROOT . '/formateur">Formateur</a></li>';
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
                    <h3>Formations</h3>
                    <ul>
                        <li><a href="<?= SITE_ROOT ?>/responsable/formations">Liste</a></li>
                        <li><a href="<?= SITE_ROOT ?>/responsable/formations/create">Création</a></li>
                    </ul>
                    <hr>
                    <h3>Formateur</h3>
                    <ul>
                        <li><a href="<?= SITE_ROOT ?>/responsable/calendriers">Liste Calendriers</a></li>
                    </ul>
                    <hr>
                    <h3>Organismes</h3>
                    <ul>
                        <li><a href="<?= SITE_ROOT ?>/responsable/organismes/add">S'ajouter</a></li>
                        <li><a href="<?= SITE_ROOT ?>/responsable/organismes/ask">Demande d'ajout</a></li>
                    </ul>
                    <hr>
                    <h3>Matières</h3>
                    <ul>
                        <li><a href="<?= SITE_ROOT ?>/responsable/matieres">Liste</a></li>
                        <li><a href="<?= SITE_ROOT ?>/responsable/matieres/ask">Demande d'ajout</a></li>
                    </ul>
                    <hr>
                    <h3>Options</h3>
                    <ul>
                        <li><a href="<?= SITE_ROOT ?>/responsable/options">Liste</a></li>
                        <li><a href="<?= SITE_ROOT ?>/responsable/options/ask">Demande d'ajout</a></li>
                    </ul>
                    <hr>
                    <h3>Noms formation</h3>
                    <ul>
                        <li><a href="<?= SITE_ROOT ?>/responsable/noms-formation/ask">Demande d'ajout</a></li>
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