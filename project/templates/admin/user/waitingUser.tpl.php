<h2 class="h2AValider">Liste des nouveaux utilisateurs à valider</h2>
<?php if(isset($errorMessage)) {
    echo('<div class="error">' . $errorMessage . '</div>');
} ?>
<div class="contenuListeAValider grid-5">
    <h3>Nom</h3>
    <h3>Prénom</h3>
    <h3>Courriel</h3>
    <h3>Role</h3>
    <h3>Action</h3>
    <?php if (empty($userList)) { ?>
        <p>Aucun utilisateur à valider</p>
    <?php } else { ?>
        <?php foreach($userList as $user){ ?>
            <p><?= $user->nom ?></p>
            <p><?= $user->prenom ?></p>
            <p><?= $user->courriel ?></p>
            <p>
                <select id="selectRoleID-<?= $user->id ?>">
                    <option value="0">-- Choisir Role --</option>
                    <?php foreach($roles as $role){ ?>
                        <option value="<?= $role->id ?>"><?= $role->libelleTypeCompte ?></option>
                    <?php } ?>
                </select>
            </p>
            <form action="<?= SITE_ROOT ?>/admin/users/waiting" method="post" onsubmit="return confirmActionUserWaiting(event, <?= $user->id ?>)">
                <input type="hidden" name="userID" value="<?= $user->id ?>">
                <input type="hidden" name="roleID" id="hiddenRoleID<?= $user->id ?>" value="0"> <!-- Valeur par défaut qui est remplie avec un script JS (pas faisable autrement (je rappel qu'il restais moins de 24h avant le rendu)) -->
                <p class="containerAction">
                    <button name="validate" type="submit" class="accept-btn">Accepter</button>
                    <button name="decline" type="submit" class="reject-btn">Refuser</button>
                </p>
            </form>
    <?php } } ?>
</div>
<div class="pagination">
    <?php for ($i = 1; $i <= $numberOfPages; $i++) { ?>
        <a href='/admin/users/validation?page=<?= $i ?>'> <?= $i ?> </a>
    <?php } ?>
</div>
<script>
    async function confirmActionUserWaiting(event, userID) {
        event.preventDefault(); // Stop la soumission du formulaire

        var selectRoleID = document.getElementById("selectRoleID-" + userID).value;
        document.getElementById("hiddenRoleID" + userID).value = selectRoleID;
        
        // Affiche une modale avec les boutons de sur-validations
        var confirmation = await createConfirmationBox(
            "Êtes-vous sûr de continuer?",
            "confirm"
        );
        
        // Si oui alors on valide le formulaire
        if (confirmation) {
            // Append hidden input for the clicked button
            var clickedButton = event.submitter;
            var buttonName = clickedButton.name;
            var hiddenInput = document.createElement("input");
            hiddenInput.type = "hidden";
            hiddenInput.name = buttonName;
            hiddenInput.value = "true";
            event.target.appendChild(hiddenInput);

            // Submit the form
            event.target.submit();
        }
    }
</script>