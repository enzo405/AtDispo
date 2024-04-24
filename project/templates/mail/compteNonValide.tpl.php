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

                <h3 class="h3CompteCree">Nom d'utilisateur :</h3>
                <p class="pCompteCree"><?= $compte->nom ?></p>

                <h3 class="h3CompteCree">Prénom d'utilisateur :</h3>
                <p class="pCompteCree"><?= $compte->prenom ?></p>

                <h3 class="h3CompteCree">Adresse e-mail :</h3>
                <p class="pCompteCree"><?= $compte->courriel ?></p>

                <p class="pCompteCree">Votre compte n'a malheureusement pas été validé.</p>
                <p class="pCompteCree">Veuillez vous rapprocher d'At-Dispo afin d'obtenir de plus amples informations sur la nature du refus.</p>

                <p>Merci pour votre attente et à bientôt sur At-Dispo.</p>
            </div>
        </div>
    </body>
</html>