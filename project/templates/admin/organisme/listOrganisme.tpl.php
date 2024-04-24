<h2 class="h2AValider">Liste des organismes</h2>
<div class="contenuListeAValider grid-5">
    <h3>Nom</h3>
    <h3>Adresse</h3>
    <h3>Ville</h3>
    <h3>Code Postal</h3>
    <h3>Action</h3>
    <?php if (empty($organismeList)) { ?>
        <p>Aucun organisme n'est présent dans la base de donnée</p>
    <?php } else { 
    // if ()
    foreach($organismeList as $organisme){ ?>
        <p class="<?= ($organisme->valide == 1 ? '' : 'standby-validation')?>"><?= $organisme->nomOrganismeFormation ?></p>
        <p><?= $organisme->adresse ?></p>
        <p><?= $organisme->codePostal ?></p>
        <p><?= $organisme->ville ?></p>
        <p>
            <span class="link-button"><a href="<?= SITE_ROOT ?>/admin/organismes/<?= $organisme->id ?>">Voir l'organisme</a></span>
        </p>
    <?php } } ?>
</div>
<div class="pagination">
    <?php for ($i = 1; $i <= $numberOfPages; $i++) { ?>
        <a href='/admin/organismes?page=<?= $i ?>'> <?= $i ?> </a>
    <?php } ?>
</div>