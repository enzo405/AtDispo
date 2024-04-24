<h2 class="h2AValider">S'ajouter un nouvel organisme</h2>
<?php if(isset($errorMessage)) {
    echo('<div class="error">' . $errorMessage . '</div>');
} ?>
<div class="contenuListeAValider grid-5">
    <h3>Nom</h3>
    <h3>Adresse</h3>
    <h3>Code Postal</h3>
    <h3>Ville</h3>
    <h3>Action</h3>
    <?php if (empty($organismeList)) { ?>
        <p>Il n'y a aucun organisme auquel vous pouvez vous ajouter.</p>
    <?php } else { ?>
    <?php foreach($organismeList as $organisme){ ?>
        <p><?= $organisme->nomOrganismeFormation ?></p>
        <p><?= $organisme->adresse ?></p>
        <p><?= $organisme->codePostal ?></p>
        <p><?= $organisme->ville ?></p>
        <form action="<?= SITE_ROOT ?>/responsable/organismes/add" method="post" onsubmit="return confirmAction(event)">
            <p>
                <input type="hidden" name="organismeID" value="<?= $organisme->id ?>">
                <button name="ajouterOrga" type="submit" class="accept-btn">Ajouter</button>
            </p>
        </form>
    <?php } } ?>
</div>