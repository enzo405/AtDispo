<?php

namespace App\Controllers;

use App\Controllers\CalendarController;
use Models\EtatsDisponibilite;

class DisponibiliteController extends CalendarController
{
    /**
     * get the structure for a event
     * @param string $id
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
        return [
            "data" => [
                "title" => $title,
                "color" => $color,
                "status" => $status,
            ],
            "id" => $id,
            "demi" => $demi,
            "month" => $date["month"],
            "day" => $date["day"],
            "year" => $date["year"]
        ];
    }

    public function renderCalendar()
    {
        $currentDate = date_parse(date("Y-m"));
        $currentWeek = date('W');
        // get all EtatsDisponibilite
        $etatsDisponibilite = EtatsDisponibilite::list();
        $status = [];
        foreach ($etatsDisponibilite as $key => $value) {
            $status[$value->id] = $value->libelleEtatDisponibilite;
        }

        $this->getView("calendrier/formateur/disponibilite", ["calendar" => $this->listCalendar(), "currentDate" => $currentDate, "currentWeek" => $currentWeek, "monthLibelle" => $this->monthLibelle, "dayLibelle" => $this->dayLibelle, "status" => $status, "undefinedId" => 3],"formateur")->addCSS("calendrier.css")->render();
    }

    public function renderCalendarPost()
    {
        var_dump($_POST);
    }

    /**
     * Return composer calendar to impletant into your view
     */
    public function renderComposant(): mixed
    {
        $currentDate = date_parse(date("Y-m"));
        $currentWeek = date('W');

        // get all EtatsDisponibilite
        $etatsDisponibilite = EtatsDisponibilite::list();
        $status = [];
        foreach ($etatsDisponibilite as $key => $value) {
            $status[$value->id] = $value->libelleEtatDisponibilite;
        }
        
        return $this->getView("calendrier/formateur/disponibilite", ["calendar" => $this->listCalendar(), "currentDate" => $currentDate, "currentWeek" => $currentWeek, "monthLibelle" => $this->monthLibelle, "dayLibelle" => $this->dayLibelle, "status" => $status, "undefinedId" => 3],"formateur")->addCSS("calendrier.css")->component();
    }

    /**
     * Return composer calendar to impletant into your view
     */
    public function renderComposantToPdf(): mixed
    {
        $currentDate = date_parse(date("Y-m"));
        $currentWeek = date('W');

        // get all EtatsDisponibilite
        $etatsDisponibilite = EtatsDisponibilite::list();
        $status = [];
        foreach ($etatsDisponibilite as $key => $value) {
            $status[$value->id] = $value->libelleEtatDisponibilite;
        }
        
        return $this->getView("calendrier/formateur/disponibiliteToPdf", ["calendar" => $this->listCalendar(), "currentDate" => $currentDate, "currentWeek" => $currentWeek, "monthLibelle" => $this->monthLibelle, "dayLibelle" => $this->dayLibelle, "status" => $status, "undefinedId" => 3],"formateur")->addCSS("calendrier.css")->component();
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
            "holiday" => NULL
        ];
    }
}