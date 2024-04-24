<!DOCTYPE html>
<html lang="fr">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Réinitialisation du mot de passe</title>
        <style>
            <?php echo file_get_contents(dirname(__FILE__) . '/../../public/assets/css/mail.css'); ?>
        </style>
    </head>
    <body>
        <div class="mdpOublieMail">
            <h2 class="h2TitreMail">Réinitialisation du Mot de Passe</h2>
            <div class="contenuListeMail">
                <h3>Cher(e) <?= $compte->prenom ?> <?= $compte->nom ?>,</h3>
                <p>Vous avez demandé la réinitialisation de votre mot de passe.</p>
                <p>Cliquez sur le lien ci-dessous pour réinitialiser votre mot de passe :</p>
            
                <p><a href="<?= SITE_NAME . SITE_ROOT . $urlReinitialisation ?>">Réinitialiser le mot de passe</a></p>

                <p>Si vous n'avez pas demandé cette réinitialisation, veuillez ignorer cet e-mail.</p>

                <p>Merci.</p>
            </div>
        </div>
    </body>
</html>