<div class="container">
    <div class="contenu">
        <div class="contenuFormulaire">
            <h2>Demande d'ajout d'un nom de formation</h1>
            <div class="formulaire">
                <form method="post" action="<?= SITE_ROOT ?>/responsable/noms-formation/ask" onsubmit="return confirmAction(event)">
                    <?php if(isset($errorMessage)) { ?>
                        <div class="error"><?= $errorMessage ?></div>
                    <?php } ?>
                    <div class="field">
                        <label for="nom">Nom de la formation</label>
                        <input type="text" placeholder="Nom" name="nom" id="nom" required>
                    </div>
                    <div class="boutonEnvoyer">
                        <button name="demanderFormation" type="submit" class="registerbtn">Demander</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>