<?php

namespace App\Controllers;

use App\Controllers\CalendarController;
use Models\CreneauDisponibilite;

class EDTController extends CalendarController
{
    /**
     * get the structure for a event
     * @param string $id // correspond à l'idCreneauDisponibilite
     * @param string $title
     * @param string $color
     * @param string $date
     * @param string $demi
     * @return array
     */
    public static function eventStructure(string $id, string $title, string $color, string $date, string $demi, string $status): array
    {
        $dateTimeObject = \DateTime::createFromFormat("Y-m-d", $date);
        if ($dateTimeObject == FALSE) {
            throw new \Exception("Invalid date format");
        }
        $date = date_parse($dateTimeObject->format("Y-m-d"));
        // $date = date("Y-m-d", strtotime($date));
        return [
            "data" => [
                "title" => $title,
                "color" => $color,
            ],
            "id" => $id,
            "demi" => $demi,
            "status" => $status,
            "month" => $date["month"],
            "day" => $date["day"],
            "year" => $date["year"]
        ];
    }

    public function renderCalendar()
    {
        $this->getView("calendrier/formateur/creneau", [
            "calendar" => $this->listCalendar(), 
            "currentDate" => date_parse(date("Y-m")), 
            "currentWeek" => date('W'), 
            "monthLibelle" => $this->monthLibelle, 
            "dayLibelle" => $this->dayLibelle
        ],"formateur")->addCSS("calendrier.css")->render();
    }

    /**
     * Return composer calendar to impletant into your view
     */
    public function renderComposant(): mixed
    {
        $currentDate = date_parse(date("Y-m"));
        $currentWeek = date('W');
        return $this->getView("calendrier/formateur/creneau", ["calendar" => $this->listCalendar(), "currentDate" => $currentDate, "currentWeek" => $currentWeek, "monthLibelle" => $this->monthLibelle, "dayLibelle" => $this->dayLibelle],"formateur")->addCSS("calendrier.css")->component();
    }

    /**
     * Return composer calendar to impletant into your view
     */
    public function renderComposantResponsable(): mixed
    {
        $currentDate = date_parse(date("Y-m"));
        $currentWeek = date('W');
        return $this->getView("calendrier/responsable/creneau", ["calendar" => $this->listCalendar(), "currentDate" => $currentDate, "currentWeek" => $currentWeek, "monthLibelle" => $this->monthLibelle, "dayLibelle" => $this->dayLibelle],"responsable")->addCSS("calendrier.css")->component();
    }


    /**
     * description of a day
     */
    protected function dayDescription(int $day, int $month, int $year, $undefined = []): array
    {
        return [
            "name"  => date("N", strtotime("$year-$month-$day")),
            "day" => $day,
            "month" => $month,
            "year" => $year,
            "LOCKED" => FALSE,
            "morning" => [
                "title" => $this->defaultDisponibilite->libelleEtatDisponibilite,
                "color" => $this->defaultDisponibilite->couleurEtatDisponibilite,
                "id" => NULL,
            ],
            "afternoon" => [
                "title" => $this->defaultDisponibilite->libelleEtatDisponibilite,
                "color" => $this->defaultDisponibilite->couleurEtatDisponibilite,
                "id" => NULL,
            ],
            "holiday" => []
        ];
    }
}