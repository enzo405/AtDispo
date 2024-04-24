<h2 class="h2Calendrier">Mon Agenda</h2>
<div class="feature-calendrier">
    <fieldset class="couleursLegende">
        <?php foreach ($etatsDispo as $etat) { ?>
            <div>
                <span class="legendeCouleur" style="background-color: <?= $etat->couleurEtatDisponibilite ?>;"></span>
                <span><?= $etat->libelleEtatDisponibilite ?></span>
            </div>
        <?php } ?>
    </fieldset>
    <div class="container-envoie">
        <p>Envoyer ses disponibilités en PDF :</p>
        <form action="<?= SITE_ROOT ?>/formateur/disponibilite/send" method="post">
            <input type="email" name="courriel" placeholder="Email du destinataire">
            <button name="submit" type="submit">Envoyer</button>
        </form>
    </div>
</div>
<div id="calendar"><?= $content ?></div>