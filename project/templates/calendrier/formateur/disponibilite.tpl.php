<div>
    <form class="calendrier" action="<?= SITE_ROOT ?>/formateur/disponibilite/edit" method="post" onsubmit="return confirmAction(event)">
        <h3><i class="fa fa-calendar" aria-hidden="true"></i> Sem.</h3>
        <h3>Lundi</h3>
        <h3>Mardi</h3>
        <h3>Mercredi</h3>
        <h3>Jeudi</h3>
        <h3>Vendredi</h3> 
        <?php use Models\EtatsDisponibilite;
        foreach ($calendar as $monthYear => $weeks){
            $year = explode('-',$monthYear)[0];
            $month = explode('-',$monthYear)[1];
            if ($month >= $currentDate['month'] || $currentDate['year'] != $year) { ?>
                <?php foreach ($weeks as $week){
                    if ($week['weekNumber'] >= $currentWeek || $week["content"][array_key_last($week["content"])]['year'] > $currentDate['year']) {
                        array_shift($week["content"]);
                        array_pop($week["content"]); ?>
                        <div class="weekNumber"><p><?= $week['weekNumber'] ?></p></div>
                        <?php 
                        foreach ($week['content'] as $day) {
                            $dayDate =  $day["year"] . ":" . $day["month"] . ":" . $day["day"]; ?>
                            <div class="day">
                                <div class="dayNumber">
                                    <p><?= $day["day"] . (($day["day"] == 1) ? "er" : (($day["day"] == 2) ? "d" : (($day["day"] == 3) ? "e" : "")))?> 
                                    <?php foreach ($monthLibelle as $key => $value) {
                                        if ($key == $day['month']) {
                                            echo($value);
                                        }
                                    } ?></p>
                                </div>
                                <?php if ($day['LOCKED'] == TRUE) { ?>
                                    <div class="locked-creneau dayContent">
                                            <p><i class="fa-solid fa-lock"></i> Locked</p>
                                    </div>
                                <?php } else { ?>
                                    <div class="dayContent">
                                        <?php $creneaux = [
                                            "0" => [
                                                "name" => "morning",
                                                "libelle" => "Matin",
                                                "class" => "matin"
                                            ],
                                            "1" => [
                                                "name" => "afternoon",
                                                "libelle" => "Après-midi",
                                                "class" => "aprem"
                                            ],
                                        ];
                                        foreach ($creneaux as $keyCreneau => $creneau) {
                                            $sysName = $creneau['name'] . $dayDate;
                                            $name = $creneau['name']; ?>
                                            <div class="<?= $creneau['class']; ?>" style="background-color: <?= $day[$name]['color']; ?>">
                                                <h4>
                                                    <label for="<?= $sysName; ?>"><?= $creneau['libelle']; ?></label>
                                                </h4>
                                                <span>
                                                    <?php $id = $day[$name]["id"] ?? NULL;
                                                        $etat = $day[$name]["status"] ?? $undefinedId;
                                                        $options = NULL;
                                                        
                                                        if (isset($id)) {
                                                            if ($etat == EtatsDisponibilite::$enAttenteID) {
                                                                echo "<p>" . $day[$name]["title"] . "</p>";
                                                                $options = $status;
                                                                $options["valider"] = "Accepter";
                                                            }else{
                                                                $options = $status;
                                                                unset($options[5]);
                                                            }
                                                        }else{
                                                            $options = $status;
                                                            unset($options[5]);
                                                        }
                                                        if (isset($options)) {
                                                            unset($options[$etat]);
                                                            $options["!" . $etat] = $status[$etat];
                                                            if (isset($id)) {
                                                                echo "<input type='hidden' name='" . $dayDate . "!" . $keyCreneau . "[id]' value='" . $id . "'>";
                                                            }
                                                            echo "<select id='". $sysName . "' name='" . $dayDate . "!" . $keyCreneau . "[status]'>";

                                                            foreach ($options as $key => $value) {
                                                                if (str_starts_with($key, "!")) {
                                                                    echo "<option value='' selected>" . $value . "</option>";
                                                                }else{
                                                                    echo "<option value='" . $key . "' " . $selected . ">" . $value . "</option>";
                                                                }
                                                            }
                                                            echo "</select>";
                                                        } ?>
                                                </span>
                                            </div>
                                        <?php } ?>
                                   </div>
                                <?php } ?>
                            </div>
                        <?php } ?>
                    <?php } ?>
                <?php } ?>
            <?php } ?>
        <?php } ?>
        <input class="floating-submit" type="submit">
    </form>
</div>