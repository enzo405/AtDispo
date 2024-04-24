<h2 class="h2AValider">Demande d'ajout d'un nom de formation</h2>
<?php if(isset($errorMessage)) {
    echo('<div class="error">' . $errorMessage . '</div>');
} ?>
<div class="contenuListeAValider grid-2">
    <h3>Nom de la Formation</h3>
    <h3>Action</h3>
    <?php if (empty($listNomsFormations)) { ?>
        <p>Il n'y a aucun num de formations à valider.</p>
    <?php } else { 
    foreach($listNomsFormations as $nomFormation) { ?>
        <p><?= $nomFormation->libelleNomFormation ?></p>
        <form action="<?= SITE_ROOT ?>/admin/noms-formation/waiting" method="post" onsubmit="return confirmAction(event)">
            <input type="hidden" name="nomFormationID" value="<?= $nomFormation->id ?>">
            <p class="containerAction">
                <button name="validate" type="submit" class="accept-btn">Accepter</button>
                <button name="decline" type="submit" class="reject-btn">Refuser</button>
            </p>
        </form>
    <?php } } ?>
</div>
<div class="pagination">
    <?php for ($i = 1; $i <= $numberOfPages; $i++) { ?>
        <a href='/admin/noms-formations/waiting?page=<?= $i ?>'> <?= $i ?> </a>
    <?php } ?>
</div>