<div>
    <h2 class="h2Calendrier">Agenda (n°<?= $calendarID ?>) de <?= $formateur->toString() ?></h2>
    <fieldset class="couleursLegende">
        <?php foreach ($etatsDispo as $etat) { ?>
            <div>
                <span class="legendeCouleur" style="background-color: <?= $etat->couleurEtatDisponibilite ?>;"></span>
                <span><?= $etat->libelleEtatDisponibilite ?></span>
            </div>
        <?php } ?>
    </fieldset>
    <div id="calendar"><?= $content ?></div>
</div>