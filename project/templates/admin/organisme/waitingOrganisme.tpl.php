<h2 class="h2AValider">Liste des nouveaux organismes à valider</h2>
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
        <p>Aucun organisme à valider</p>
    <?php } else {
    foreach ($organismeList as $organisme) { ?>
        <p><?= $organisme->nomOrganismeFormation ?></p>
        <p><?= $organisme->adresse ?></p>
        <p><?= $organisme->codePostal ?></p>
        <p><?= $organisme->ville ?></p>
        <form action="<?= SITE_ROOT ?>/admin/organismes/waiting" method="post" onsubmit="return confirmAction(event)">
            <input type="hidden" name="organismeID" value="<?= $organisme->id ?>">
            <p class="containerAction">
                <button name="validate" type="submit" class="accept-btn">Accepter</button>
                <button name="decline" type="submit" class="reject-btn">Refuser</button>
            </p>
        </form>
    <?php } } ?>
</div>
<div class="pagination">
    <?php for ($i = 1; $i <= $numberOfPages; $i++) { ?>
        <a href='/admin/organismes/waiting?page=<?= $i ?>'> <?= $i ?> </a>
    <?php } ?>
</div>