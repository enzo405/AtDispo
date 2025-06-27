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
                    <h2>Login</h2>
                    <form action="<?= SITE_ROOT ?>/login" method="post">
                        <?php if(isset($errorMessage)) {
                            echo('<div class="error">' . $errorMessage . '</div>');
                        } ?>
                        <div class="field">
                            <label>E-mail</label>
                            <input value="test1@test.com" placeholder="Adresse E-mail" class="inputEmail" type="text" name="courriel" required>
                        </div>
                        <div class="field">
                            <label>Mot de passe</label>
                            <input value="test" placeholder="Mot de passe" class="inputMdp" type="password" name="password" id="passwordField" required>
                            <span toggle="#passwordField" class="toggle-password"><i class="fa fa-eye" aria-hidden="true"></i></span>
                        </div>
                        <div class="boutonEnvoyer">
                            <button type="submit">Se connecter</button>
                        </div>
                    </form>
                </div>
                <div class="recuperationLogin">
                    <a class="loginOublie" href="<?= SITE_ROOT ?>/passwordForget">Mot de passe oublié ?</a>
                    <div class="loginInscription">
                        <p class="loginPasIdentifiant">Pas d'identifiant ?</p>
                        <a class="loginCreer" href="<?= SITE_ROOT ?>/register">Créez le vôtre dès à présent.</a>
                    </div>
                </div>
            </div>
        </div>
    <?php } ?>
</div>