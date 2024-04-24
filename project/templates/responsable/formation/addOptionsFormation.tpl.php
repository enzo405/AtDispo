<div class="container">
    <div class="contenu">
        <div class="contenuFormulaire">
            <h2>Ajout d'options pour la Formation n°<?= $createdFormation->id ?></h2>
            <div class="info-generale">
                <ul>
                    <li>Date de Début de la formation: <?= date("l jS \of F Y",strtotime($createdFormation->dateDebutFormation)) ?></li>
                    <li>Date de Fin de la formation: <?= date("l jS \of F Y",strtotime($createdFormation->dateFinFormation)) ?></li>
                    <li>Nom de la Formation: <span class="<?= ($createdFormation->nomFormation->valide == 1 ? '' : 'standby-validation')?>"><?= $createdFormation->nomFormation->libelleNomFormation ?></span></li> 
                    <li>Information du Site de l'organisme de la formation: <?= $createdFormation->siteOrgaFormation->nomSiteOrgaFormation ?> - <?= $createdFormation->siteOrgaFormation->adresse ?> - <?= $createdFormation->siteOrgaFormation->codePostal ?></li>
                </ul>
            </div>
            <div class="formulaire medium-gap">
                <span class="link-button"><a href="<?= SITE_ROOT ?>/responsable/options/ask?nomsFormationID=<?= $createdFormation->nomFormation->id ?>">Demander l'ajout d'une option</a></span>
                <form method="post" action="<?= SITE_ROOT ?>/responsable/formations/<?= $createdFormation->id ?>/options/add" onsubmit="return confirmAction(event)">
                    <?php if(isset($errorMessage)) { ?>
                            <div class="error"><?= $errorMessage ?></div>
                    <?php } ?>
                    <span>Choississez les Options de la formation à <b>ajouter/enlever</b>:</span>
                    <div class="field">
                        <?php
                        $optionsFormation = $createdFormation->getOptionsFormation();
                        if (empty($options)) { ?>
                            <div class="small-text">Aucune option n'est disponible pour cette formation</div>
                        <?php } foreach ($options as $option) { ?>
                            <div class="checkbox-container">
                                <?php if (in_array($option, $optionsFormation)) { ?>
                                    <input type="checkbox" id="<?= $option->id ?>" name="options[<?= $option->id ?>]" value="<?= $option->id ?>" checked/>
                                <?php } else { ?>
                                    <input type="checkbox" id="<?= $option->id ?>" name="options[<?= $option->id ?>]" value="<?= $option->id ?>"/>
                                    <?php } ?>
                                    <label for="<?= $option->id ?>"><?= $option->libelleNomOptionFormation ?></label>
                            </div>
                        <?php } ?>
                    </div>
                    
                    <div class="boutonEnvoyer">
                        <button name="AddOptions" type="submit" class="registerbtn">Sauvegarder</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>