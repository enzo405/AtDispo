<div class="container">
    <div class="contenu">
        <div class="contenuFormulaire">
            <h2>Demande d'ajout d'un organisme de formation</h1>
            <div class="formulaire">
                <form method="post" action="<?= SITE_ROOT ?>/responsable/organismes/ask" onsubmit="return confirmAction(event)">
                    <?php
                        if(isset($errorMessage)) { ?>
                            <div class="error"><?= $errorMessage ?></div>
                    <?php } ?>
                    <div class="field">
                        <label for="nom">Nom de l'organisme</label>
                        <input type="text" placeholder="Nom" name="nom" id="nom" required">
                    </div>
                    <div class="field">
                        <label for="adresse">Adresse de l'organisme</label>
                        <input type="text" placeholder="Adresse" name="adresse" id="adresse" required>
                    </div>
                    <div class="field">
                        <label for="codePostal">Code Postal de l'organisme</label>
                        <input type="text" placeholder="Code Postal" name="codePostal" id="codePostal" required>
                    </div>
                    <div class="field">
                        <label for="ville">Ville de l'organisme</label>
                        <input type="text" placeholder="Ville" name="ville" id="ville" required>
                    </div>
                    <div class="boutonEnvoyer">
                        <button name="demanderOrga" type="submit" class="registerbtn">Demander</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>