<div class="container">
    <div class="contenu">
        <div class="information-generale">
            <h2><?= $formation->toString(TRUE) ?></h2>
            <span>Nom de Formation: <span class="<?= ($formation->nomFormation->valide == 1 ? '' : 'standby-validation')?>"><?= $formation->nomFormation->libelleNomFormation ?></span></span>
            <span><b>Matières:</b></span>
            <ul>
                <?php $matieres = $formation->nomFormation->getMatieres();
                if (empty($matieres)) { ?>
                    <li class="<?= ($formation->nomFormation->valide == 1 ? '' : 'standby-validation')?>"> Aucune matière</li>
                <?php } else {
                    foreach ($matieres as $matiere) { ?>
                    <li class="<?= ($formation->nomFormation->valide == 1 ? '' : 'standby-validation')?>"> <?= $matiere->libelleMatiere?></li>
                <?php }} ?>
            </ul>
            <span><b>Options:</b></span>
            <ul>
                <?php $options = $formation->getOptionsFormation();
                if (empty($options)) { ?>
                    <li class="<?= ($formation->nomFormation->valide == 1 ? '' : 'standby-validation')?>"> Aucune option</li>
                <?php } else {
                    foreach ($options as $option) { ?>
                    <li class="<?= ($formation->nomFormation->valide == 1 ? '' : 'standby-validation')?>"> <?= $option->libelleNomOptionFormation ?></li>
                <?php }} ?>
            </ul>
        </div>
    </div>
</div>