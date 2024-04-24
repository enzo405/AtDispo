<div class="container">
    <div class="contenu">
        <div class="contenuFormulaire">
            <h2>Ajout d'une matière pour l'évenement <?= $creneau->toString() ?></h1>
            <div class="formulaire">
                <form method="post" action="<?= SITE_ROOT ?>/responsable/calendrier/add/matiere" onsubmit="return confirmAction(event)">
                    <?php if(isset($errorMessage)) { ?>
                        <div class="error"><?= $errorMessage ?></div>
                    <?php } ?>

                    <div class="field">
                        <?php $matiereCreneau = $creneau->getMatiere()->id;
                        foreach ($matieres as $matiere) { ?>
                            <span>
                                <label for="<?= $matiere->id ?>"><?= $matiere->libelleMatiere ?></label>
                                <?php if ($matiereCreneau == $matiere->id) { ?>
                                <input type="radio" checked id="<?= $matiere->id ?>" name="matiereID" value="<?= $matiere->id ?>">
                                <?php } else { ?>
                                <input type="radio" id="<?= $matiere->id ?>" name="matiereID" value="<?= $matiere->id ?>">
                                <?php } ?>
                            </span>
                        <?php } ?>
                    </div>
                    <input type="hidden" name="creneauID" value="<?= $creneau->id ?>">
                    <input type="hidden" name="formationID" value="<?= $formation->id ?>">
            
                    <div class="boutonEnvoyer">
                        <button name="addMatiere" type="submit" class="registerbtn">Enregistrer</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>