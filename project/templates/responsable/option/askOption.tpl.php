<div class="container">
    <div class="contenu">
        <div class="contenuFormulaire">
            <h2>Demande d'ajout d'une option</h1>
            <div class="formulaire">
                <form action="<?= SITE_ROOT ?>/responsable/options/ask" method="post" onsubmit="return confirmAction(event)">
                    <?php if(isset($errorMessage)) { ?>
                        <div class="error"><?= $errorMessage ?></div>
                    <?php } ?>
                    <div class="field">
                        <label for="libelle">Nom de l'option</label>
                        <input type="text" placeholder="Nom" name="libelle" id="libelle" required>
                    </div>
                    <div class="field">
                        <label for="idNomsFormation">Choississez le Nom de Formation</label>
                        <select name="idNomsFormation">
                            <option disabled value="">--Choississez une formation--</option>
                            <?php foreach ($listNomsFormation as $nomsFormation) { 
                                if ($nomsFormationID == $nomsFormation->id) {
                                    echo "<option value='$nomsFormation->id' selected>$nomsFormation->libelleNomFormation</option>";
                                } else {
                                    echo "<option value='$nomsFormation->id'>$nomsFormation->libelleNomFormation</option>";
                                }
                            } ?>
                        </select>
                    </div>
                    <div class="boutonEnvoyer">
                        <button name="demanderFormation" type="submit" class="registerbtn">Demander</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>