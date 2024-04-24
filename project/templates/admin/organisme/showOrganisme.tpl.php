<div class="container">
    <div class="contenu">
        <div class="contenuFormulaire">
            <?php if (isset($errorMessage)){ ?>
                <p class="error"><?= $errorMessage ?></p>
            <?php } ?>
            <div class="formulaire big-gap">
                <div class="formulaire">
                    <h2>Modification d'un Organisme</h2>
                    <form action="<?= SITE_ROOT ?>/admin/organismes/edit" method="post" onsubmit="return confirmAction(event)">
                        <input type="hidden" name="organismeId" value="<?= $organisme->id ?>">
                        <div class="field">
                            <label for="nom">Nom :</label>
                            <input id="nom" type="text" name="nomOrganismeFormation" value="<?= $organisme->nomOrganismeFormation ?>">
                        </div>
                        <div class="field">
                            <label for="adresse">Adresse :</label>
                            <input id="adresse" type="text" name="adresse" value="<?= $organisme->adresse ?>">
                        </div>
    
                        <div class="field">
                            <label for="codePostal">Code Postal :</label>
                            <input id="codePostal" type="text" name="codePostal" value="<?= $organisme->codePostal ?>">
                        </div>
    
                        <div class="field">
                            <label for="ville">Ville :</label>
                            <input id="ville" type="text" name="ville" value="<?= $organisme->ville ?>">
                        </div>
                        <div class="field">
                            <input type="submit" value="Mettre à jour">
                        </div>
                    </form>
                </div>
                <div class="formulaire">
                    <form action="<?= SITE_ROOT ?>/admin/organismes/delete" method="post" onsubmit="return confirmAction(event)">
                        <input type="hidden" name="organismeId" value="<?= $organisme->id ?>"/>
                        <input class="reject-btn" name="delete" type="submit" value="Supprimer définitivement">
                    </form>
                </div>
                <div class="formulaire">
                    <h2>Ajout d'un Site de Formation :</h2>
                    <form action="<?= SITE_ROOT ?>/admin/organismes/site" method="post" onsubmit="return confirmAction(event)">
                        <div class="field">
                            <label for="nomSite">Nom :</label>
                            <input id="nomSite" type="text" name="nomSiteOrgaFormation">
                        </div>
                        <div class="field">
                            <label for="adresseSite">Adresse :</label>
                            <input id="adresseSite" type="text" name="adresse">
                        </div>
                        <div class="field">
                            <label for="codePostalSite">Code Postal :</label>
                            <input id="codePostalSite" type="text" name="codePostal">
                        </div>
                        <div class="field">
                            <label for="villeSite">Ville :</label>
                            <input id="villeSite" type="text" name="ville">
                        </div>
                        <input type="hidden" name="organismeId" value="<?= $organisme->id ?>"/>
                        <input class="accept-btn" type="submit" value="Ajouter" />
                    </form>
                </div>
                <div class="formulaire">
                    <h2>Supression d'un Site de Formation :</h2>
                    <ul class="update">
                    <?php foreach ($sites as $site) { ?>
                        <form action="<?= SITE_ROOT ?>/admin/organismes/site/delete" method="post" onsubmit="return confirmAction(event)">
                            <li>
                                <p><?= $site->toString() ?></p>
                                <input type="hidden" name="siteId" value="<?= $site->id ?>">
                                <input type="hidden" name="organismeId" value="<?= $organisme->id ?>"/>
                                <input class="reject-btn" type="submit" value="Supprimer">
                            </li>
                        </form>
                    <?php } ?>
                    </ul>
                </div>
                <div class="formulaire">
                    <h2>Création d'une Formation :</h2>
                    <form class="update" action="<?= SITE_ROOT ?>/admin/organismes/formation" method="post" onsubmit="return confirmAction(event)">
                        <div class="field">
                            <label for="dateDebut">Date de Début de la formation</label>
                            <input type="date" placeholder="01/01/2000" name="dateDebutFormation" id="dateDebut" required">
                        </div>
                    
                        <div class="field">
                            <label for="dateFin">Date de Fin de la formation</label>
                            <input type="date" placeholder="01/01/2000" name="dateFinFormation" id="dateFin" required">
                        </div>
                        
                        <div class="field">
                            <label for="nomFormation">Nom de Formation</label>
                            <select name="nomFormation" id="nomFormation">
                                <option value="" disabled selected>Choisissez un nom de formation</option>
                                <?php foreach ($nomFormations as $nomFormation) { ?>
                                    <option value="<?= $nomFormation->id ?>"><?= $nomFormation->libelleNomFormation ?></option>
                                <?php } ?>
                            </select>
                        </div>

                        <input type="hidden" name="organismeId" value="<?= $organisme->id ?>"/>
                        <input class="accept-btn" type="submit" value="Ajouter">
                    </form>
                </div>
                <div class="formulaire">
                    <h2>Suppression d'une Formation :</h2>
                    <ul class="update">
                    <?php if (empty($formations)) {
                            echo '<span>L\'organisme de formation ne possède aucune formation</span>';
                        } else {
                            foreach ($formations as $key => $formation) { ?>
                                <form action="<?= SITE_ROOT ?>/admin/organismes/formation/delete" method="post" onsubmit="return confirmAction(event)">
                                    <li>
                                        <p><?= $formation->toString(TRUE) ?></p>
                                        <input type="hidden" name="formationId" value="<?= $formation->id ?>">
                                        <input type="hidden" name="organismeId" value="<?= $organisme->id ?>"/>
                                        <input class="reject-btn" type="submit" value="Supprimer">
                                    </li>
                                </form>
                            <?php } 
                        } ?>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>