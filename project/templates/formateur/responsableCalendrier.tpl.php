<h2 class="h2AValider">Voici la liste des responsable qui ont accès à votre Calendrier</h2>
<?php if(isset($errorMessage)) {
    echo('<div class="error">' . $errorMessage . '</div>');
} ?>
<div class="contenuListeAValider grid-3">
    <?php if (!empty($hasAccessResponsable)){ ?>
        <h3>Responsable</h3>
        <h3>Année Calendrier</h3>
        <h3>Action</h3>
        <?php foreach ($hasAccessResponsable as $value) { 
            $user = $value["user"];
            $calendar = $value["calendrier"] ?>
            <p><?= $user->courriel ?></p>
            <p><?= $calendar->anneeScolCalendrierDisponibilite ?></p>
            <form action="<?= SITE_ROOT ?>/formateur/calendrier/responsable/remove" method="post" onsubmit="return confirmAction(event)">
                <input type="hidden" name="userID" value="<?= $user->id ?>">
                <input type="hidden" name="calendarID" value="<?= $calendar->id ?>">
                <p class="containerAction">
                    <button name="decline" type="submit" class="reject-btn">Supprimer l'accès</button>
                </p>
            </form>
        <?php }
    } else {
        echo "<p>Aucun utilisateurs n'est responsable de votre calendrier pour le moment</p>";
    } ?>
</div>
<div class="container" style="height: auto;">
    <div class="contenu" style="min-height: auto;">
        <div class="information-generale">
            <h2>Ajouter un responsable:</h2>
            <form action="<?= SITE_ROOT ?>/formateur/calendrier/responsable/add" method="POST" onsubmit="return confirmAction(event)">
                <div class="field">
                    <label for="calendriers">Pour le calendrier:</label>
                    <select name="calendrierID" id="calendriers">
                        <option selected disabled>Choississez le calendrier</option>
                        <?php foreach ($listCalendrier as $calendrier) { ?>
                            <option value="<?= $calendrier->id ?>"><?= $calendrier->toString() ?></option>
                        <?php } ?>
                    </select>
                </div>
                <div class="field">
                    <input type="text" name="courriel" placeholder="Courriel" required>
                </div>
                <div class="field">
                    <input type="submit" name="addResponsable" value="Ajouter">
                </div>
            </form>
        </div>
    </div>
</div>