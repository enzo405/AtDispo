<?php

namespace App\Controllers;

use App\Core\Controller;
use App\Exceptions\ResourceNotFound;
use Models\EtatsDisponibilite;

abstract class CalendarController extends Controller
{
    private int $year;
    private array $calendar = [];
    private array $idMapping = [];
    protected array $monthLibelle = [
        "1" => "Janvier",
        "2" => "Février",
        "3" => "Mars",
        "4" => "Avril",
        "5" => "Mai",
        "6" => "Juin",
        "7" => "Juillet",
        "8" => "Août",
        "9" => "Septembre",
        "10" => "Octobre",
        "11" => "Novembre",
        "12" => "Décembre"
    ];
    protected array $dayLibelle = [
        "1" => "Lundi",
        "2" => "Mardi",
        "3" => "Mercredi",
        "4" => "Jeudi",
        "5" => "Vendredi",
        "6" => "Samedi",
        "7" => "Dimanche"
    ];

    protected EtatsDisponibilite $defaultDisponibilite;
    /**
     * Create a calendar for a year
     * @param int $year
     * @return mixed
     */
    public function __construct(int $year = null)
    {
        if (empty($year) || !is_numeric($year) || strlen($year) !== 4) {
            $year = date("Y");
        }
        $this->year = $year;
        $this->defaultDisponibilite = new EtatsDisponibilite(3); // id 3 correspond à l'état "Undéfinie"

        $this->arrayCalendar();
    }

    /**
     * Matrice de l'année diviser par 5 jours semaine et 2 demi journée et n'affiche pas les week end
     */
    public function listCalendar(): array
    {
        $startMonth = 8;
        $TCalendar = [];

        foreach ($this->calendar as $month => $days) {
            // the year content into the matrice
            $year = $days["year"];

            // on ajoute 12 au mois si il est inferieur a 8
            $tempStartMonth = $startMonth < 8 ? $startMonth + 12 : $startMonth;
            $tempMonth = $month < 8 ? $month + 12 : $month;
            
            // dans le cas ou c'est le premier mois de l'année
            // on ajoute les jours manquant pour commencer la semaine
            if ($month == $startMonth) {
                $posDay = intval(date("N", strtotime("$year-$month-01")));
                foreach (range(1, $posDay) as $i) {
                    $tempYear = $month == 1 ? $year - 1 : $year;
                    $monthdays = cal_days_in_month(CAL_GREGORIAN, $month - 1, $tempYear);
                    $v = $monthdays - ($posDay - $i);
                    $date = date_parse(date("Y-m-d", strtotime($tempYear . "-" . $month - 1 . "-" . $v)));
                    $day = $this->dayDescription($date["day"], $date["month"], $date["year"]);
                    $day['LOCKED'] = TRUE;
                    $TCalendar[] = $day;
                }
            }
            // dans le cas ou la boucle est sur un mois inferieur au mois de depart
            if ($tempStartMonth <= $tempMonth) {
                $tYear = $days["year"];
                unset($days["year"]);
                // on ajouter les information d'un jour dans la matrice
                foreach ($days as $number => $content) {
                    $event = $this->dayDescription($number, $month, $tYear);
                    // permet de remplir les valeurs morning et afternoon
                    foreach($content as $key => $value) {
                        $event[$key] = $value;
                    }
                    $TCalendar[] = $event;
                }


                // dans le cas ou c'est le dernier mois de l'année
                // on ajoute les jours manquant pour finir la semaine
                if ($month == 7) {
                    $posDay = intval(date("N", strtotime("$year-$month-31")));
                    if ($posDay != 7) {
                        foreach (range(1, $posDay) as $i) {
                            $v = $i - $posDay;
                            $date = date_parse(date("Y-m-d", strtotime($year . "-" . $month + 1 . "-" . $i)));
                            $day = $this->dayDescription($date["day"], $date["month"], $date["year"]);
                            $day['LOCKED'] = TRUE;
                            $TCalendar[] = $day;
                        }
                    }
                }
            }
        }
        $TMCalendar = array_chunk($TCalendar, 7, TRUE);
        $MCalendar = [];
        foreach ($TMCalendar as $week) {
            $lastDayOfWeek = $week[array_key_last($week)];
            $month = $lastDayOfWeek["month"];
            $year = $lastDayOfWeek["year"];
            $weekNumber = date("W", strtotime($year . "-" . $month . "-" . $lastDayOfWeek["day"]));
            $MCalendar[$year . "-" . $month][] = [
                "content" => $week,
                "weekNumber" => $weekNumber
            ];
        }
        return $MCalendar;
    }

    /**
     * Create an array with all days of the year
     * @return void
     */
    private function arrayCalendar(): void
    {
        foreach (range(8, 19) as $month) {
            $year = $this->year;
            if ($month > 12) {
                $year = $year + 1;
                $month = $month - 12;
            }
            $monthdays = cal_days_in_month(CAL_GREGORIAN, $month, $year);
            foreach (range(1, $monthdays) as $day) {
                $this->calendar[$month][$day] = $this->dayDescription($day, $month, $year);
            }
            $this->calendar[$month]["year"] = $year;
        }
    }

    /**
     * Get the calendar
     * @return array
     */
    public function getCalendar(): array
    {
        return $this->calendar;
    }

    /**
     * Add random events to the calendar for testing
     * @return void
     */
    public function gerenateRandom()
    {
        foreach (range(1, 30) as $i) {
            $year = $this->year;
            $month = rand(1, 12);
            $day = rand(1, cal_days_in_month(CAL_GREGORIAN, $month, $year));
            $c = boolval(rand(0, 1));
            $demi = $c ? "morning" : "afternoon";
            $this->idMapping[$i] = [
                "month" => $month,
                "day" => $day,
                "demi" => $demi
            ];
            $this->calendar[$month][$day][$demi] = ["title" => "test", "color" => "red", "id" => $i];
        }
    }

    /**
     * Get the years
     * @return array [startYear, endYear]
     */
    public function getYear(): array
    {
        return [$this->year, $this->year];
    }

    /**
     * Load event into the calendar
     * @param array $event
     */
    public function loadEvents(array $events): void
    {
        foreach ($events as $event) {
            $this->addEvent($event);
        }
    }

    /**
     * Load holidays into the calendar
     * @param array $holidays
     * @return void
     */
    private function loadHolidays(array $holidays): void
    {
        foreach ($holidays as $holiday) {
            $this->addHolidays($holiday);
        }
    }

    /**
     * Add holidays to the calendar
     * @param array $holiday
     * @return void
     */
    private function addHolidays(array $holiday): void
    {
        $this->calendar[$holiday["month"]][$holiday["day"]]["holiday"] = [
            "title" => $holiday["title"],
            "color" => $holiday["color"],
        ];
    }

    /**
     * Add an event to the calendar
     * @param array $event
     * @return void
     */
    protected function addEvent(array $event): void
    {
        $this->idMapping[$event["id"]] = [
            "month" => $event["month"],
            "day" => $event["day"],
            "demi" => $event["demi"]
        ];
        $this->calendar[$event["month"]][$event["day"]][$event["demi"]] = [
            "id" => $event["id"]
        ];
        if (isset($event["hasAccess"])){
            $this->calendar[$event["month"]][$event["day"]][$event["demi"]]["hasAccess"] = $event["hasAccess"];
        }
        foreach ($event["data"] as $key => $value) {
            $this->calendar[$event["month"]][$event["day"]][$event["demi"]][$key] = $value;
        }
    }

    /**
     * Day Holiday Structure
     * 
     * @param string $month
     * @param string $day
     * @param string $title
     * @param string $color
     * @return array
     */
    public static function holidayStructure(string $month, string $day, string $title, string $color) : array {
        return [
            "month" => $month,
            "day" => $day,
            "title" => $title,
            "color" => $color
        ];
    }


    /**
     * description of a day
     */
    abstract protected function dayDescription(int $day, int $month, int $year, $undefined = []) : array;

    abstract public static function eventStructure(string $id, string $title, string $color, string $date, string $demi, string $status): array;

    /**
     * Remove an event from the calendar
     * @param int $eventID
     * @return void
     */
    private function removeEvent(int $eventID): void
    {
        if (!isset($this->idMapping[$eventID])) {
            throw new ResourceNotFound("Event not found");
        }
        $event = $this->idMapping[$eventID];
        $this->calendar[$event["month"]][$event["day"]][$event["demi"]] = NULL;
        $this->idMapping[$event["id"]] = NULL;
    }
}