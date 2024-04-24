<div class="container">
    <div class="contenu">
        <div class="contenuFormulaire">
            <h2>Ajout d'une matière pour <span class="<?= ($nomsFormation->valide == 1 ? '' : 'standby-validation')?>"><?= $nomsFormation->libelleNomFormation ?></span> (n°<?= $nomsFormation->id ?>)</h2>
            <div class="formulaire medium-gap">
                <span class="link-button"><a href="<?= SITE_ROOT ?>/responsable/matieres/ask">Faire la demande d'une matière</a></span>
                <?php $matieresNomsFormation = $nomsFormation->getMatieres(); ?>
                <form action="<?= SITE_ROOT ?>/responsable/noms-formation/matiere" method="POST" onsubmit="return confirmAction(event)">
                    <?php if(isset($errorMessage)) { ?>
                        <div class="error"><?= $errorMessage ?></div>
                    <?php } ?>
                    <input type="hidden" name="idNomFormation" value="<?= $nomsFormation->id ?>">
                    <span>Choississez les Matières que vous voulez <b>ajouter ou suprrimer</b> du nom de Formation :</span>
                    <div class="field">
                        <?php foreach ($matieres as $matiere) { ?>
                            <div class="checkbox-container">
                                <?php if (in_array($matiere, $matieresNomsFormation)) { ?>
                                    <input type="checkbox" id="<?= $matiere->id ?>" name="matieres[<?= $matiere->id ?>]" value="<?= $matiere->id ?>" checked/>
                                    <label for="<?= $matiere->id ?>"><?= $matiere->libelleMatiere ?></label>
                                <?php } else { ?>
                                    <input type="checkbox" id="<?= $matiere->id ?>" name="matieres[<?= $matiere->id ?>]" value="<?= $matiere->id ?>" unchecked/>
                                    <label for="<?= $matiere->id ?>"><?= $matiere->libelleMatiere ?></label>
                                <?php } ?>
                            </div>
                        <?php } ?>
                    </div>
                    <div class="boutonEnvoyer">
                        <button name="AddMatiere" type="submit" class="registerbtn">Enregistrer</button>
                    </div>
                </form>
                <div class="info">
                    Voici les formations qui seront affecté si vous ajouté les matières sélectionnées :
                    <ul>
                        <?php foreach ($formationForNomsFormation as $formation) { ?>
                            <li><?= $formation->toString() ?> <span class="link-button"><a href="<?= SITE_ROOT ?>/responsable/formations/<?= $formation->id ?>" target="_blank">Voir Formation</a></span></li>
                        <?php } ?>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>