<!DOCTYPE html>
<html lang="fr">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Ajout en tant que responsable d'un Calendrier !</title>
        <style>
            <?php echo file_get_contents(dirname(__FILE__) . '/../../public/assets/css/mail.css'); ?>
        </style>
    </head>
    <body>
        <div class="compteCreeMail">
            <h2 class="h2TitreMail">Bonjour <?= $responsable->toString() ?></h2>
            <p>Le formateur <?= $formateur->toString() ?> vous à ajouté en tant que responsable de son calendrier</p>
            <p>Vous pouvez dès à présent accéder à son calendrier en cliquant sur le lien ci-dessous</p>
            <a href="<?= SITE_NAME . SITE_ROOT ?>/responsable/calendrier/<?= $calendrierID ?>">Cliquez ici pour y accéder</a>
        </div>
    </body>
</html>