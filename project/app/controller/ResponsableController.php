<?php

namespace App\Controllers;

use App\Core\Controller;
use App\Core\Mailer;
use App\Exceptions\AccessDeniedException;
use App\Exceptions\ResourceNotFound;
use Models\CalendriersDisponibilite;
use Models\CreneauDisponibilite;
use Models\EtatsDisponibilite;
use Models\Formations;
use Models\Matieres;
use Models\TypesCreneau;
use Models\User;


class ResponsableController extends Controller
{
    /**
     * Constructeur du controller OrganismeController
     */
    public function __construct()
    {
        $this->access([2]);
    }

    /**
     * Affiche la liste des calendriers dont le responsable est responsable
     */
    public function listCalendrier()
    {
        $user = new User($_SESSION['userID']);
        $this->getView('calendrier/responsable/listCalendrier', [
            'listCalendrier' => $user->getCalendriers()
        ], 'responsable')->addCSS("validation.css")->render();
    }

    /**
     * Affiche le calendrier du formateur
     * @param int $idCalendrier on est obligé de mettre l'id du calendrier car un responsable peut être responsable de plusieurs calendriers
     */
    public function showCalendar(int $idCalendrier)
    {
        $get = HTTP_REQUEST->getRequestParamsValue();
        $responsable = new User($_SESSION['userID']);

        $calendarDispo = new CalendriersDisponibilite($idCalendrier);
        $formateur = $calendarDispo->getCompte();
        // On test si l'utilisateur est bien responsable du calendrier
        if (!in_array($_SESSION['userID'], $calendarDispo->getListCalendarAccess())) {
           throw new AccessDeniedException("Vous n'avez pas accès à ce calendrier");
        }

        if (isset($get['year'])) {
            $year = date_create($get['year'])->format("Y");
        } else {
            $year = CalendriersDisponibilite::getCurrentYear();
        }

        $requestEvents = $calendarDispo->getAllEvents();

        foreach ($requestEvents as $key => $event) {

            $eventName = isset($event['libelleMatiere']) ? $event['libelleMatiere'] : '';
            $eventName .= isset($event["nomSiteOrgaFormation"]) ? " - " . $event["nomSiteOrgaFormation"] : '';
            $eventName .= isset($event["nomOrganismeFormation"]) ? " - " . $event["nomOrganismeFormation"] : '';
            $eventName .= isset($event["adresse"]) ? " - " . $event["adresse"] : '';
            $eventName = $eventName ?: $event["libelleEtatDisponibilite"];
            
            $demi = $event["idTypeCreneau"] == 1 ? "morning" : "afternoon";
            $TEvent = EDTController::eventStructure($event["idCreneauDisponibilite"], $eventName, $event["couleurEtatDisponibilite"], $event["dateCreneauDisponibilite"], $demi, $event["idEtatDisponibilite"]);
            $creneau = new CreneauDisponibilite($event["idCreneauDisponibilite"]);
            $idFormation = $creneau->getIdFormation();
            if ($idFormation != null) {
                $TEvent["hasAccess"] = $responsable->hasAccessToFormation($idFormation);
            } else {
                $TEvent["hasAccess"] = TRUE; // si la formation n'est pas renseigné on affiche l'évenement
            }
            $events[] = $TEvent;
        }

        $calendar = new EDTController($year);
        $calendar->loadEvents($events ?? []);
        $content = $calendar->renderComposantResponsable();
        $this->render("responsable/creneau", [
            "content" => $content,
            "year" => $year,
            "formateur" => $formateur,
            "calendarID" => $calendarDispo->id,
            "etatsDispo" => EtatsDisponibilite::list(),
        ], "responsable");
    }

    /**
     * Faire une demande de disponibilité pour un formateur
     */
    public function askEvenement(int $idCreneau) {
        $user = new User($_SESSION['userID']);

        $creneau = new CreneauDisponibilite($idCreneau);
        // Si le créneau n'est pas disponibles
        if (!$creneau->isDisponible()) {
            throw new ResourceNotFound("Le créneau n'est pas disponible");
        }
        $this->getView('responsable/evenement/askEvenement', [
            "creneau" => $creneau,
            "formations" => Formations::getFormationsByOrgaFormation($user->getIdOrganismeFormation()),
        ], 'responsable')->addCSS("user.css")->render();
    }

    /**
     * Traitemenet de la page d'edit de la disponibilité d'un formateur
     */
    public function askEvenementPost() {
        $post = HTTP_REQUEST->getPostParams();
        $creneau = new CreneauDisponibilite($post["creneauID"]);
        if (!$creneau->isDisponible()) {
            throw new ResourceNotFound("Le créneau n'est pas disponible");
        }
        if (isset($post["demanderEvent"])) {
            $formation = new Formations($post["formationID"]);
            $this->redirect("/responsable/calendrier/$creneau->id/$formation->id/add/matiere");
        }
        $this->redirect("/responsable/calendrier/$creneau->id/ask-creneau?errorMessage=Une erreur est survenue lors de la demande de disponibilité");
    }

    
    /**
     * Ajoute une matière à un événement
     */
    public function addMatiereEvenement(int $idCreneau, int $idFormation) {
        $this->getView('responsable/evenement/addMatiereEvenement', [
            "creneau" => new CreneauDisponibilite($idCreneau),
            "formation" => new Formations($idFormation),
            "matieres" => Matieres::list(),
        ], 'responsable')->addCSS("user.css")->render();
    }

    /**
     * Traitement de la page d'ajout de matière à un événement
     */
    public function addMatiereEvenementPost() {
        $post = HTTP_REQUEST->getPostParams();
        $creneau = new CreneauDisponibilite($post["creneauID"]);
        $formation = new Formations($post["formationID"]);
        if (isset($post["addMatiere"])) {
            $creneau->setIdEtatDisponibilite(EtatsDisponibilite::$enAttenteID);
            $creneau->setIdFormation($formation->id);
            $creneau->setIdMatiere($post["matiereID"]);
            $errors = $creneau->validate();

            if (empty($errors)) {
                $creneau->save();

                // Envoie du mail d'ajout d'évènement
                $calendrierDispo = $creneau->getCalendrierDisponibilite();
                $to[] = $calendrierDispo->getCompte()->courriel;
                $subject = "Nouvelle demande d'évènement";

                $mail = new Mailer($to, $subject);

                $mail->addTemplate("mail/ajoutEvenement", [
                        "event" => $creneau,
                        "calendrierDispo" => $calendrierDispo
                    ]);
                $mail->send();

                $this->redirect("/responsable/calendrier/" . $creneau->getIdCalendrierDisponibilite());
            } else {
                $firstError = array_shift($errors)[0][1];
                $this->redirect("/responsable/calendrier/$creneau->id/$formation->id/add/matiere?errorMessage=$firstError");
            }
        }
        $this->redirect("/responsable/calendrier/$creneau->id/$formation->id/add/matiere?errorMessage=Une erreur est survenue lors de l'ajout de la matière");
    }
}