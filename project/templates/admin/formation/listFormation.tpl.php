<div class="contenuListeAValider grid-5">
    <?php if (!empty($formationsList)){ ?>
        <h3>Formations</h3>
        <h3>Date</h3>
        <h3>Options</h3>
        <h3>Matières</h3>
        <h3>Actions</h3>
        <?php foreach ($formationsList as $formations) {
            foreach ($formations as $formation) { ?>
                <p class="formation-name">
                    <span class="<?= ($formation->nomFormation->valide == 1 ? '' : 'standby-validation')?>">
                        <?= $formation->toString() ?>
                    </span>
                </p>
                <p><?= date('d/m/Y', strtotime($formation->dateDebutFormation)) . " à " . date('d/m/Y', strtotime($formation->dateFinFormation)); ?></p>
                <p>
                    <?php $options = [];
                    foreach ($formation->getOptionsFormation() as $optionFormation) {
                        $options[] = $optionFormation;
                    }
                    if (!empty($options)) {
                        foreach ($options as $option) {
                            echo "<span class='" . ($option->valide == 1 ? '' : 'standby-validation') . "'>" . $option->libelleNomOptionFormation . "</span>";
                        }
                    } else {
                        echo "Aucune options";
                    } ?>
                </p>
                <p>
                    <?php $matieres = [];
                    foreach ($formation->nomFormation->getMatieres() as $matiere) {
                        $matieres[] = $matiere;
                    }
                    if (!empty($matieres)) {
                        foreach ($matieres as $matiere) {
                            echo "<span class='" . ($matiere->valide == 1 ? '' : 'standby-validation') . "'>" . $matiere->libelleMatiere . "</span>";
                        }
                    } else {
                        echo "<span>Aucune matières</span>";
                    } ?>
                </p>
                <p>
                    <span class="link-button"><a href="<?= SITE_ROOT ?>/admin/formations/<?= $formation->id ?>">Voir la formation</a></span>
                </p>
            <?php }
        }
    } else {
        echo "<p>Aucune formation n'est présente dans votre organisme pour le moment</p>";
    } ?>
</div>
<div class="pagination">
    <?php for ($i = 1; $i <= $numberOfPages; $i++) { ?>
        <a href='/admin/formations?page=<?= $i ?>'> <?= $i ?> </a>
    <?php } ?>
</div>