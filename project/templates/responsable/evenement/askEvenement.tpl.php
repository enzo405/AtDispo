<div class="container">
    <div class="contenu">
        <div class="contenuFormulaire">
            <h2>Demande d'ajout d'évenement</h1>
            <div class="formulaire">
                <form method="post" action="<?= SITE_ROOT ?>/responsable/calendrier/ask-creneau" onsubmit="return confirmAction(event)">
                    <?php if(isset($errorMessage)) { ?>
                        <div class="error"><?= $errorMessage ?></div>
                    <?php } ?>

                    <div class="field">
                        <label for="formationID">Formation</label>
                        <select name="formationID" id="formationID">
                            <option value="0" disabled selected>Choisissez une formation</option>
                            <?php foreach ($formations as $formation) { ?>
                                <option value="<?= $formation->id ?>"><?= $formation->toString() ?></option>
                            <?php } ?>
                        </select>
                    </div>
                    <input type="hidden" name="creneauID" value="<?= $creneau->id ?>">
                    <div class="boutonEnvoyer">
                        <button name="demanderEvent" type="submit" class="registerbtn">Demander</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>