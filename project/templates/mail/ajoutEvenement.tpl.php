<!DOCTYPE html>
<html lang="fr">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Ajout d'événement</title>
        <style>
            <?php echo file_get_contents(dirname(__FILE__) . '/../../public/assets/css/mail.css'); ?>
        </style>
    </head>
    <body>
        <h2 class="h2TitreMail">Nouvelle demande d'évènement</h2>
        <div class="contenuListeMail">
            <?php $matiere = $event->getMatiere();
            $compte = $calendrierDispo->getCompte() ?>
            <h3>Informations sur l'Évènement :</h3>
            <p><strong>Formateur :</strong> <?= $compte->nom ?> <?= $compte->prenom ?></p>
            <?php if ($matiere->id != NULL) { ?>
                <p><strong>Matière :</strong> <?= $matiere->libelleMatiere ?></p>
            <?php } ?>
            <p><strong>Date :</strong> <?=  date("l jS \of F Y",strtotime($event->dateCreneauDisponibilite)) . " (" . $event->typeCreneau->libelleTypeCreneau . ")" ?></p>
            <p><strong>Lieu :</strong> <?=  $event->getFormation()->siteOrgaFormation->nomSiteOrgaFormation ?></p>

            <p>Merci pour votre contribution !</p>

            <p>Consultez la demande d'évènement <a href="<?= SITE_NAME . SITE_ROOT ?>/formateur/disponibilite">ici</a>.</p>
        </div>
    </body>
</html>