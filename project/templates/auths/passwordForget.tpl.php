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
                    <h2>Réinitialisation du mot de passe</h2>
                    <?php if (isset($message)) { ?>
                        <div class="small-text"><?= $message ?></div>
                    <?php } ?>
                    <form method="post" action="<?= SITE_ROOT ?>/passwordForget">
                        <?php if(isset($errorMessage)) { ?>
                            <div class="error"><?= $errorMessage ?></div>
                        <?php } ?>
                        <div class="field">
                            <label for="email" class="reset-label">Adresse e-mail :</label>
                            <input type="email" name="email" id="email" class="reset-input" required>
                        </div>
                        <div class="boutonEnvoyer">
                            <button type="submit">Demander une réinitialisation de mot de passe</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    <?php } ?>
</div>