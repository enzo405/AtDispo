<div class="container">
    <div class="contenu">
        <div class="contenuFormulaire">
            <h2>Paramètres Utilisateur</h2>
            <?php
                if(isset($errorMessage)) { ?>
                    <div class="error"><?= $errorMessage ?></div>
                <?php } ?>
            <div class="formulaire">
                <form action="<?= SITE_ROOT ?>/settings" method="POST" onsubmit="return confirmAction(event)">
                    <h3>Changement des informations personnelles</h3>
                    <div class="field">
                        <label>Nom</label>
                        <input type="text" name="nom" placeholder="Nom" value="<?= $user->nom ?>">
                    </div>
                    <div class="field">
                        <label>Prenom</label>
                        <input type="text" name="prenom" placeholder="Prenom" value="<?= $user->prenom ?>">
                    </div>
                    <div class="field">
                        <label>E-mail</label>
                        <input type="email" name="courriel" placeholder="Courriel" value="<?= $user->courriel ?>">
                    </div>
                    <div class="boutonEnvoyer">
                        <button type="submit" name="infosSettings">Changer ses paramètres</button>
                    </div>
                </form>
                <form action="<?= SITE_ROOT ?>/settings" method="POST" onsubmit="return confirmAction(event)">
                    <h3>Changement du mot de passe</h3>
                    <div class="field">
                        <label>Ancien mot de passe</label>
                        <input type="password" name="oldPassword" placeholder="Ancien mot de passe">
                    </div>
                    <div class="field">
                        <label>Nouveau mot de passe</label>
                        <input type="password" name="newPassword" placeholder="Nouveau mot de passe">
                    </div>
                    <div class="field">
                        <label>Confirmation mot de passe</label>
                        <input type="password" name="confirmationPassword" placeholder="Confirmer le nouveau mot de passe">
                    </div>
                    <div class="boutonEnvoyer">
                        <button type="submit" name="passwordSettings">Changer ses paramètres</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>