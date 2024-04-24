<div class="calendrier">
    <h3><i class="fa fa-calendar" aria-hidden="true"></i> Sem.</h3>
    <h3>Lundi</h3>
    <h3>Mardi</h3>
    <h3>Mercredi</h3>
    <h3>Jeudi</h3>
    <h3>Vendredi</h3>
    <?php foreach ($calendar as $monthYear => $weeks){
        $year = explode('-',$monthYear)[0];
        $month = explode('-',$monthYear)[1];
        if ($month >= $currentDate['month'] || $currentDate['year'] != $year) { ?>
            <?php foreach ($weeks as $week){
                if ($week['weekNumber'] >= $currentWeek || $week["content"][array_key_last($week["content"])]['year'] > $currentDate['year']) {
                    array_shift($week["content"]);
                    array_pop($week["content"]); ?>
                    <div class="weekNumber"><p><?= $week['weekNumber'] ?></p></div>
                    <?php foreach ($week['content'] as $day){ ?>
                        <div class="day">
                            <div class="dayNumber">
                                <p><?= $day["day"] . (($day["day"] == 1) ? "er" : (($day["day"] == 2) ? "d" : (($day["day"] == 3) ? "e" : "")))?>
                                <?php foreach ($monthLibelle as $key => $value) {
                                    if ($key == $day['month']) {
                                        echo($value);
                                    }
                                } ?>
                                </p>
                            </div>
                            <div class="dayContent">
                                <div class="matin" style="background-color: <?= $day["morning"]["color"]; ?>;">
                                    <h4>Matin</h4>
                                    <span><p><?= $day["morning"]["title"]; ?></p></span>
                                </div>
                                <div class="aprem" style="background-color: <?= $day["afternoon"]["color"]; ?>;">
                                    <h4>Après-midi</h4>
                                    <span><p><?= $day["afternoon"]["title"]; ?></p></span>
                                </div>
                            </div>
                        </div>
                    <?php } ?>
                <?php } ?>
            <?php } ?>
        <?php } ?>
    <?php } ?>
</div>