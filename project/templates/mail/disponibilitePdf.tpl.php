<!DOCTYPE html>
<html lang="fr">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Disponibilités</title>
        <style>
            <?php echo file_get_contents(dirname(__FILE__) . '/../../public/assets/css/mail.css'); ?>
        </style>
    </head>
    <body>
        <div class="planningPdfMail">
            <h2 class="h2TitreMail">Disponibilités de <?= $formateur->nom . " " . $formateur->prenom ?></h2>
            <div class="contenuListeMail">
                <h3>Adresse e-mail :</h3>
                <p><?= $formateur->courriel ?></p>
                
                <p>Vous trouverez ci-joint les disponibilités de <?= $formateur->nom . " " . $formateur->prenom ?> au format PDF.</p>

                <p>Merci pour votre engagement !</p>
            </div>
        </div>
    </body>
</html>