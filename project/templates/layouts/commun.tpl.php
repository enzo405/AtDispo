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
            </div>
        </header>
        <div class="content background-formes">
            <main>
                <?= $content ?>
            </main>
        </div>
        <footer>
            <a href="<?= SITE_ROOT ?>/mentions-legales">Mentions légales</a>
        </footer>
        <?= $viewData['JSFiles'] ?>
    </body>
</html>