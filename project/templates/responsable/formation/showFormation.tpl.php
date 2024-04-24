<div class="container">
    <div class="contenu">
        <div class="information-generale">
            <h2><?= $formation->toString(TRUE) ?></h2>
            <span>Nom de Formation: <span class="<?= ($formation->nomFormation->valide == 1 ? '' : 'standby-validation')?>"><?= $formation->nomFormation->libelleNomFormation ?></span></span>
            <span><b>Matières:</b></span>
            <span class="link-button"><a href="<?= SITE_ROOT ?>/responsable/noms-formation/<?= $formation->getIdNomFormation() ?>/matiere">Ajouter des matières</a></span>
            <ul>
                <?php $matieres = $formation->nomFormation->getMatieres();
                if (empty($matieres)) { ?>
                    <li>Aucune matieres</li>
                <?php } else {
                    foreach ($matieres as $matiere) { ?>
                    <li class="<?= ($formation->nomFormation->valide == 1 ? '' : 'standby-validation')?>"> <?= $matiere->libelleMatiere?></li>
                <?php }} ?>
            </ul>
            <span><b>Options:</b></span>
            <span class="link-button"><a href="<?= SITE_ROOT ?>/responsable/formations/<?= $formation->id ?>/options/add">Ajouter des options</a></span>
            <ul>
                <?php $options = $formation->getOptionsFormation();
                if (empty($options)) { ?>
                    <li>Aucune options</li>
                <?php } else {
                    foreach ($options as $option) { ?>
                    <li class="<?= ($formation->nomFormation->valide == 1 ? '' : 'standby-validation')?>"> <?= $option->libelleNomOptionFormation ?></li>
                <?php }} ?>
            </ul>
        </div>
    </div>
</div>