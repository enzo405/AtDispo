<!DOCTYPE html>
<html lang="fr">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Bienvenue sur notre site !</title>
        <style>
            <?php echo file_get_contents(dirname(__FILE__) . '/../../public/assets/css/mail.css'); ?>
        </style>
    </head>
    <body>
        <div class="compteCreeMail">
            <h2 class="h2TitreMail">Bienvenue sur notre site !</h2>
            <div class="contenuListeMail">
                <p><?= $formateur->toString() ?> vous à invité à créer votre compte sur notre application web <a href="<?= SITE_NAME . SITE_ROOT ?>/register"><?= SITE_NAME ?></a></p>
            </div>
        </div>
    </body>
</html>