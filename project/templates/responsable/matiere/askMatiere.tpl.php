<div class="container">
    <div class="contenu">
        <div class="contenuFormulaire">
            <h2>Demande d'ajout d'une matières</h1>
            <div class="formulaire">
                <form method="post" action="<?= SITE_ROOT ?>/responsable/matieres/ask" onsubmit="return confirmAction(event)">
                    <?php if(isset($errorMessage)) { ?>
                        <div class="error"><?= $errorMessage ?></div>
                    <?php } ?>
                    <div class="field">
                        <label for="libelle">Nom de la matière</label>
                        <input type="text" placeholder="Nom" name="libelle" id="libelle" required>
                    </div>
                    <div class="boutonEnvoyer">
                        <button name="demanderMatiere" type="submit" class="registerbtn">Demander</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>