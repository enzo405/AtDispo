<h2 class="h2AValider">Liste des nouvelles matieres à valider</h2>
<?php if(isset($errorMessage)) {
    echo('<div class="error">' . $errorMessage . '</div>');
} ?>
<div class="contenuListeAValider grid-2">
    <h3>Nom</h3>
    <h3>Action</h3>
    <?php if (empty($matieresList)) { ?>
        <p>Aucune matière à valider</p>
    <?php } else {
    foreach ($matieresList as $matiere) { ?>
        <p><?= $matiere->libelleMatiere ?></p>
        <form action="<?= SITE_ROOT ?>/admin/matieres/waiting" method="post" onsubmit="return confirmAction(event)">
            <input type="hidden" name="matiereID" value="<?= $matiere->id ?>">
            <p class="containerAction">
                <button name="validate" type="submit" class="accept-btn">Accepter</button>
                <button name="decline" type="submit" class="reject-btn">Refuser</button>
            </p>
        </form>
    <?php } } ?>
</div>
<div class="pagination">
    <?php for ($i = 1; $i <= $numberOfPages; $i++) { ?>
        <a href='/admin/matieres/waiting?page=<?= $i ?>'> <?= $i ?> </a>
    <?php } ?>
</div>