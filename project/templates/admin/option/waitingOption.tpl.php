<h2 class="h2AValider">Liste des nouvelles options à valider</h2>
<?php if(isset($errorMessage)) {
    echo('<div class="error">' . $errorMessage . '</div>');
} ?>
<div class="contenuListeAValider grid-3">
    <h3>Nom Option</h3>
    <h3>Nom Formation</h3>
    <h3>Action</h3>
    <?php if (empty($listOptions)) { ?>
        <p>Aucune option à valider</p>
    <?php } else { 
        foreach($listOptions as $option){ ?>
            <p><?= $option->libelleNomOptionFormation ?></p>
            <p><?= $option->getNomFormation()->libelleNomFormation ?></p>
            <form action="<?= SITE_ROOT ?>/admin/options/waiting" method="post" onsubmit="return confirmAction(event)">
                <input type="hidden" name="optionID" value="<?= $option->id ?>">
                <p class="containerAction">
                    <button name="validate" type="submit" class="accept-btn">Accepter</button>
                    <button name="decline" type="submit" class="reject-btn">Refuser</button>
                </p>
            </form>
    <?php } } ?>
</div>
<div class="pagination">
    <?php for ($i = 1; $i <= $numberOfPages; $i++) { ?>
        <a href='/admin/options/waiting?page=<?= $i ?>'> <?= $i ?> </a>
    <?php } ?>
</div>