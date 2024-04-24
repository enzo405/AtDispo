<div class="contenuListeAValider grid-1">
    <h3>Matières</h3>
    <?php if (empty($listMatieres)) { ?>
        <p>Aucune matières n'exisite pour le moment</p>
    <?php } else { 
        foreach($listMatieres as $matiere){ ?>
            <p class="<?= ($matiere->valide == 1 ? '' : 'standby-validation')?>"><?= $matiere->libelleMatiere ?></p>
    <?php } } ?>
</div>
<div class="pagination">
    <?php for ($i = 1; $i <= $numberOfPages; $i++) { ?>
        <a href='/responsable/matieres?page=<?= $i ?>'> <?= $i ?> </a>
    <?php } ?>
</div>