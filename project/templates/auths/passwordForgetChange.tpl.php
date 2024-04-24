<div class="container">
    <?php if ($viewData['logged']) {?>
        <div class="formulaire">
            <h2>Actuellement connecté(e)</h2>
        </div>
    <?php } else { ?>
        <div class="contenu loginHeight">
            <div class="ImageLogin">
                <img src="<?= SITE_ROOT ?>/assets/img/café.png" width="100%" alt="monsieur qui prend un café">
            </div>
            <div class="contenuFormulaire">
                <div class="formulaire">
                    <h2>Changement de Mot De Passe:</h2>
                    <form method="post" action="<?= SITE_ROOT ?>/passwordChange/<?= $token ?>">
                        <?php if(isset($errorMessage)) { ?>
                            <div class="error"><?= $errorMessage ?></div>
                        <?php } ?>
                        <div class="field">
                            <label for="newPassword">Nouveau Mot De Passe</label>
                            <input type="password" name="newPassword">
                        </div>
                        <div class="field">
                            <label for="confirmNewPassword">Confirmation Nouveau Mot De Passe</label>
                            <input type="password" name="confirmNewPassword">
                        </div>
                        <div class="boutonEnvoyer">
                            <button type="submit">Appliquer les Changements</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    <?php } ?>
</div>