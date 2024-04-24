<div class="container">
    <div class="contenu">
        <div class="contenuFormulaire">
            <h2>Modification d'un utilisateur</h2>
            <div class="formulaire">
                <form action="<?= SITE_ROOT ?>/admin/users/<?= $user->id ?>" method="post" onsubmit="return confirmAction(event)">
                    <h3>Changement des informations personnelles</h3>
                    <div class="field">
                        <p>Identifiant : <?= $user->id ?></p>
                    </div>
                    <?php
                    if(isset($errors['nom'])) {
                        foreach($errors['nom'] as $error){?>
                            <div class="error"><?= $error[1] ?></div>
                    <?php } } ?>
                    <div class="field">
                        <label for="nom">Nom :</label>
                        <input id="nom" type="text" name="nom" value="<?= $user->nom; ?>">
                    </div>
                    <?php
                    if(isset($errors['prenom'])) {
                        foreach($errors['prenom'] as $error){?>
                            <div class="error"><?= $error[1] ?></div>
                    <?php } } ?>
                    <div class="field">
                        <label for="prenom">Prénom :</label>
                        <input id="prenom" type="text" name="prenom" value="<?= $user->prenom; ?>">
                    </div>
                    <?php
                    if(isset($errors['courriel'])) {
                        foreach($errors['courriel'] as $error){?>
                            <div class="error"><?= $error[1] ?></div>
                    <?php } } ?>
                    <div class="field">
                        <label for="courriel">Email :</label>
                        <input id="courriel" type="text" name="courriel" value="<?= $user->courriel; ?>">
                    </div>
                    <div class="boutonEnvoyer">
                        <button type="submit">Mettre à jour</button>
                    </div>
                </form>
                <div class="boutonEnvoyer">
                    <form action="<?= SITE_ROOT ?>/admin/users/delete" method="post" onsubmit="return confirmAction(event)">
                        <input type="hidden" name="userId" value="<?= $user->id ?>" />
                        <button name="delete"  type="submit">Supprimer définitivement</button>
                    </form>
                </div>                
                <div>
                    <ul class="update">
                        <h3>Roles de l'utilisateur</h3>
                        <?php $useroles = $user->roles;
                        foreach ($useroles as $role) { ?>
                            <form action="<?= SITE_ROOT . '/admin/users/' . $user->id . '/role/delete' ?>" method="post" onsubmit="return confirmAction(event)">
                                <li>
                                    <p><?= $role->libelleTypeCompte; ?></p>
                                    <input type="hidden" name="roleid" value="<?= $role->id ?>">
                                    <input type="submit" value="Retirer">
                                </li>
                            </form>
                        <?php } ?>
                    </ul>
                    <?php if (count($roles) != count($useroles)) { ?>
                    <form class="update" action="<?= SITE_ROOT . '/admin/users/' . $user->id . '/role/add' ?>" method="post" onsubmit="return confirmAction(event)">
                        <select name="role">
                            <?php $i = 0;
                            foreach ($roles as $role) {
                                if (!in_array($role, $useroles)) {
                                    $i++; ?>
                                    <option value="<?= $role->id ?>"><?= $role->libelleTypeCompte ?></option>
                                <?php }
                            }?>
                        </select>
                        <input type="submit" value="Ajouter">
                    </form>
                    <?php } else { ?>
                        <span>L'utilisateur possède déja tous les roles</span>
                    <?php } ?>
                </div>
            </div>
        </div>
    </div>
</div>