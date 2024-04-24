<div class="contenuListeAValider grid-2">
    <?php if (!empty($listOptions)){ ?>
        <h3>Options</h3>
        <h3>Noms Formation</h3>
        <?php foreach ($listOptions as $option) { 
            $nomFormation = $option->getNomFormation();
            ?>
            <p class="<?= ($option->valide == 1 ? '' : 'standby-validation') ?>"><?= $option->libelleNomOptionFormation ?></p>
            <p class="<?= ($nomFormation->valide == 1 ? '' : 'standby-validation') ?>"><?= $nomFormation->libelleNomFormation ?></p>
        <?php }
    } else {
        echo "<p>Aucune options n'est enregistré pour le moment</p>";
    } ?>
</div>
<div class="pagination">
    <?php for ($i = 1; $i <= $numberOfPages; $i++) { ?>
        <a href='/responsable/options?page=<?= $i ?>'> <?= $i ?> </a>
    <?php } ?>
</div>