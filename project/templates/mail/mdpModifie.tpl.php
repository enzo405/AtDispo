<!DOCTYPE html>
<html lang="fr">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Mot de passe modifié</title>
        <style>
            <?php echo file_get_contents(dirname(__FILE__) . '/../../public/assets/css/mail.css'); ?>
        </style>
    </head>
    <body>
        <div class="mdpModifieMail">
            <h2 class="h2TitreMail">Mot de Passe Modifié avec Succès</h2>
            <div class="contenuListeMail">
                <h3>Cher(e)
                    <?= $compte->prenom ?>
                    <?= $compte->nom ?>,
                </h3>
                <p>Votre mot de passe a été modifié avec succès.</p>

                <p>Si vous n'avez pas effectué cette modification, veuillez contacter le support technique.</p>

                <p>Merci.</p>

                <p><a href="<?= SITE_NAME . SITE_ROOT ?>/login">Accéder à la page de connexion</a></p>
            </div>
        </div>
    </body>
</html>