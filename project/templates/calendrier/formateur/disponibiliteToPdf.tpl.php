<table border="1" cellpadding="7">
    <tbody>
        <tr>
            <th>N° Semaine</th>
            <th>Lundi</th>
            <th>Mardi</th>
            <th>Mercredi</th>
            <th>Jeudi</th>
            <th>Vendredi</th>
        </tr>
        <?php use Models\EtatsDisponibilite;
        foreach ($calendar as $monthYear => $weeks){ 
            $year = explode('-',$monthYear)[0];
            $month = explode('-',$monthYear)[1];
            if ($month >= $currentDate['month'] || $currentDate['year'] != $year) { ?>
                <?php foreach ($weeks as $week){
                    if ($week['weekNumber'] >= $currentWeek || $week["content"][array_key_last($week["content"])]['year'] > $currentDate['year']) {
                        array_shift($week["content"]);
                        array_pop($week["content"]); ?>
                        <tr>
                            <td style="text-align: center"><p><?= $week['weekNumber'] ?></p></td>
                            <?php foreach ($week['content'] as $day){
                                $dayDate =  $day["year"] . ":" . $day["month"] . ":" . $day["day"];
                                ?>
                                <td>
                                    <p><?= $day["day"] . (($day["day"] == 1) ? "er" : (($day["day"] == 2) ? "d" : (($day["day"] == 3) ? "e" : "")))?> 
                                    <?php 
                                    foreach ($monthLibelle as $key => $value) {
                                        if ($key == $day['month']) {
                                            echo($value);
                                        }
                                    }
                                    ?>
                                    </p>
                                    <div class="dayContent">
                                        <?php if ($day['LOCKED'] == TRUE) { ?>
                                        <div style="background-color: <?= $day["locked"]["color"]; ?>">
                                            <p>LOCKED</p>
                                        </div>
                                        <?php } else { ?>
                                        <div class="matin" style="background-color: <?= $day["morning"]["color"]; ?>;">
                                            <h4>Matin</h4>
                                            <p><?= $day["morning"]["title"]; ?></p>
                                        </div>
                                        <div class="aprem" style="background-color: <?= $day["afternoon"]["color"]; ?>;">
                                            <h4>Après-midi</h4>
                                            <p><?= $day["afternoon"]["title"]; ?></p>
                                        </div>
                                        <?php } ?>
                                    </div>
                                </td>
                            <?php } ?>
                        </tr>
                    <?php } ?>
                <?php } ?>
            <?php } ?>
        <?php } ?>
    </tbody>
</table>