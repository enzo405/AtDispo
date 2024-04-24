<h2 class="h2AValider">Voici les Calendriers de vos Formateurs :</h2>
<div class="contenuListeAValider grid-2">
    <h3>Nom</h3>
    <h3>Action</h3>
    <?php if (empty($listCalendrier)) { ?>
        <p>Aucun formateur n'est présent pour le moment</p>
    <?php } else { 
    foreach($listCalendrier as $calendrierUser){ ?>
        <p><?= $calendrierUser->toString() ?></p>
        <p>
            <span class="link-button"><a href="<?= SITE_ROOT ?>/responsable/calendrier/<?= $calendrierUser->id ?>">Voir le Calendrier</a></span>
        </p>
    <?php } } ?>
</div>