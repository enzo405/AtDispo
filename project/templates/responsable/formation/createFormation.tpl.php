<div class="container">
    <div class="contenu">
        <div class="contenuFormulaire">
            <h2>Création d'une Formation</h1>
            <div class="formulaire">
                <form method="post" action="<?= SITE_ROOT ?>/responsable/formations/create" onsubmit="return confirmAction(event)">
                    <?php
                        if(isset($errorMessage)) { ?>
                            <div class="error"><?= $errorMessage ?></div>
                    <?php } ?>

                    <div class="field">
                        <label for="dateDebut">Date de Début de la formation</label>
                        <input type="date" placeholder="01/01/2000" name="dateDebutFormation" id="dateDebut" required">
                    </div>
                    
                    <div class="field">
                        <label for="dateFin">Date de Fin de la formation</label>
                        <input type="date" placeholder="01/01/2000" name="dateFinFormation" id="dateFin" required">
                    </div>
                    
                    <div class="field">
                        <label for="nom">Nom de Formation</label>
                        <select name="nomFormation" id="nom">
                            <option value="" disabled selected>Choisissez un nom de formation</option>
                            <?php foreach ($nomFormations as $nomFormation) { ?>
                                <option value="<?= $nomFormation->id ?>"><?= $nomFormation->libelleNomFormation ?></option>
                            <?php } ?>
                        </select>
                    </div>

                    <div class="field">
                        <label for="siteOrga">Site de la formation</label>
                        <select name="siteOrgaFormation" id="siteOrga">
                            <option value="" disabled selected>Choisissez un site de la formation</option>
                            <?php foreach ($siteOrganismes as $siteOrganisme) { ?>
                                <option value="<?= $siteOrganisme->id ?>"><?= $siteOrganisme->nomSiteOrgaFormation ?></option>
                            <?php } ?>
                        </select>
                    </div>

                    <div class="boutonEnvoyer">
                        <button name="demanderOrga" type="submit" class="registerbtn">Demander</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>