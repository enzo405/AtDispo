<div class="container">
    <div class="contenu">
        <div class="ImageLogin">
            <img src="<?= SITE_ROOT ?>/assets/img/café.png" width="100%" alt="monsieur qui prend un café">
        </div>
        <div class="contenuFormulaire">
            <div class="formulaire">
                <h2>Inscription</h2>
                <form method="post" action="<?= SITE_ROOT ?>/register">
                        <?php if(isset($errorMessage)) { ?>
                            <div class="error"><?= $errorMessage ?></div>
                        <?php } ?>
                    <div class="field">
                        <label for="nom">Nom</label>
                        <input type="text" placeholder="Nom" name="nom" id="nom" required>
                    </div>
                    <div class="field">
                        <label for="prenom">Prénom</label>
                        <input type="text" placeholder="Prénom" name="prenom" id="prenom" required>
                    </div>
                    <div class="field">
                        <label for="courriel">Adresse E-mail</label>
                        <input type="courriel" placeholder="Adresse E-mail" name="courriel" id="courriel" required>
                    </div>
                    <div class="field">
                        <label for="psw">Mot de passe</label>
                        <input type="password" placeholder="Mot de passe" name="psw" id="psw" required>
                    </div>
                    <div class="field">
                        <label for="confirm-psw">Confirmation mot de passe</label>
                        <input type="password" placeholder="Confirmation mot de passe" name="confirm-psw" id="confirm-psw" required>
                    </div>
                    <div class="boutonEnvoyer">
                        <button type="submit" class="registerbtn">S'inscrire</button>
                    </div>
                </form>
            </div>
        </div>  
    </div>
</div>
