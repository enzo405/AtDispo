<?php

namespace App\Controllers;

use App\Core\Controller;
use App\Core\Mail\AttachmentType;
use App\Core\PDFGenerator;
use App\Core\Mailer;
use App\Exceptions\InternalServerError;
use App\Exceptions\ResourceNotFound;
use App\Controllers\EDTController;
use Models\CalendriersDisponibilite;
use Models\EtatsDisponibilite;
use Models\User;
use Models\CreneauDisponibilite;
use PDO;

class FormateurController extends Controller
{
    public function __construct() {
        $this->access([3]);
    }

    public function showCalendar()
    {
        $user = new User($_SESSION['userID']);

        $get = HTTP_REQUEST->getRequestParamsValue();

        if (isset($get['year'])) {
            $year = date_create($get['year'])->format("Y");
        } else {
            $year = CalendriersDisponibilite::getCurrentYear();
        }

        try {
            $calendar = CalendriersDisponibilite::getCalendrierDisponibiliteByUser($user->id, $year);
        } catch (ResourceNotFound $e) {
            $calendar = new CalendriersDisponibilite();
            $calendar->setAnneeScolCalendrierDisponibilite($year);
            $calendar->idCompte = $user->id;
            $calendar->save();
        }

        $calendarDispo = CalendriersDisponibilite::getCalendrierDisponibiliteByUser($user->id, $year);

        $requestEvents = $calendarDispo->getAllEvents();

        foreach ($requestEvents as $key => $event) {

            $eventName = isset($event['libelleMatiere']) ? $event['libelleMatiere'] : '';
            $eventName .= isset($event["nomSiteOrgaFormation"]) ? " - " . $event["nomSiteOrgaFormation"] : '';
            $eventName .= isset($event["nomOrganismeFormation"]) ? " - " . $event["nomOrganismeFormation"] : '';
            $eventName .= isset($event["adresse"]) ? " - " . $event["adresse"] : '';
        
            $eventName = $eventName ?: $event["libelleEtatDisponibilite"];        
            
            $demi = $event["idTypeCreneau"] == 1 ? "morning" : "afternoon";
            $events[] = EDTController::eventStructure($event["idCreneauDisponibilite"], $eventName, $event["couleurEtatDisponibilite"], $event["dateCreneauDisponibilite"], $demi, $event["idEtatDisponibilite"]);
            
        }

        $calendar = new EDTController($year);
        $calendar->loadEvents($events ?? []);
        $content = $calendar->renderComposant();
        $this->render("formateur/calendrier", ["content" => $content, "year" => $year, "etatsDispo" => EtatsDisponibilite::list()], "formateur");
    }

    public function showDisponibilite()
    {
        $user = new User($_SESSION['userID']);

        $get = HTTP_REQUEST->getRequestParamsValue();

        if (isset($get['year'])) {
            $year = date_create($get['year'])->format("Y");
        } else {
            $year = CalendriersDisponibilite::getCurrentYear();
        }

        try {
            $calendar = CalendriersDisponibilite::getCalendrierDisponibiliteByUser($user->id, $year);
        } catch (ResourceNotFound $e) {
            $calendar = new CalendriersDisponibilite();
            $calendar->setAnneeScolCalendrierDisponibilite($year);
            $calendar->idCompte = $user->id;
            $calendar->save();
        }

        $calendarDispo = $calendar ?? CalendriersDisponibilite::getCalendrierDisponibiliteByUser($user->id, $year);

        $requestEvents = $calendarDispo->getAllEvents();

        foreach ($requestEvents as $key => $event) {

            $eventName = isset($event['libelleMatiere']) ? $event['libelleMatiere'] : '';
            $eventName .= isset($event["nomSiteOrgaFormation"]) ? " - " . $event["nomSiteOrgaFormation"] : '';
            $eventName .= isset($event["nomOrganismeFormation"]) ? " - " . $event["nomOrganismeFormation"] : '';
            $eventName .= isset($event["adresse"]) ? " - " . $event["adresse"] : '';
            $eventName = $eventName ?: $event["libelleEtatDisponibilite"];
        
            $demi = $event["idTypeCreneau"] == 1 ? "morning" : "afternoon";
            $events[] = DisponibiliteController::eventStructure($event["idCreneauDisponibilite"], $eventName, $event["couleurEtatDisponibilite"], $event["dateCreneauDisponibilite"], $demi, $event["idEtatDisponibilite"]);
        }
        $calendar = new DisponibiliteController($year);
        $calendar->loadEvents($events ?? []);
        $content = $calendar->renderComposant();


        $this->render("formateur/disponibilite", ["content" => $content, "year" => $year, "etatsDispo" => EtatsDisponibilite::list(), "errorMessage" => $get["errorMessage"] ?? NULL], "formateur");
    }

    public function sendDisponibilitePost()
    {
        $pdf = new PDFGenerator('E');
        $attachment = $pdf->generatePDFDisponibilite();

        $post = HTTP_REQUEST->getPostParams();

        if (empty($post['courriel'])) {
            $this->redirect('/formateur/disponibilite?errorMessage=Veuillez entrer un courriel');
        }

        $user = new User($_SESSION['userID']);
        
        $to[] = $post['courriel'];
        $subject = "Disponibilités de " . $user->nom . " " . $user->prenom;

        $mail = new Mailer($to, $subject);
        $mail->addTemplate('mail/disponibilitePdf', ['formateur' => $user]);
        $mail->addHeader("X-Mailer", 'PHP\\' . phpversion());
        $mail->addAttachmentBase64($attachment, $pdf->getFileName(), AttachmentType::PDF);
        $mail->send();

        $this->redirect("/formateur/disponibilite");
    }

    public function editDisponibilitePost()
    {
        $post = HTTP_REQUEST->getPostParams();

        $get = HTTP_REQUEST->getRequestParamsValue();
        if (isset($get['year'])) {
            $year = date_create($get['year'])->format("Y");
        } else {
            $year = CalendriersDisponibilite::getCurrentYear();
        }

        $calendar = CalendriersDisponibilite::getCalendrierDisponibiliteByUser($_SESSION['userID'], $year);
        foreach ($post as $strDate => $event)
        {
            $explose = explode("!", $strDate);
            $status = $event['status'] ?? NULL;
            $id = $event['id'] ?? NULL;
            if (isset($status) && $status == "") {
                continue;
            }
            
            $semi = $explose[1] == 0 ? 1 : 2;
            $dateTimeObject = \DateTime::createFromFormat("Y-m-d", str_replace(':', '-', $explose[0]));

            if ($dateTimeObject == FALSE) {
                throw new InternalServerError("Invalid date format");
            }

            if (isset($id)) {
                $creneau = new CreneauDisponibilite($id);
                if ($status == "valider") {
                    $creneau->setIdEtatDisponibilite(EtatsDisponibilite::$pasDisponibleID);
                } else {
                    $creneau->setIdEtatDisponibilite($status); // status est égale à l'id de l'état
                    // Dans ce cas l'utilisateur n'a pas valider, on agit comme si le créneau à été refusé
                    if ($status == EtatsDisponibilite::$pasDisponibleID) {
                        $creneau->setIdMatiere(NULL);
                        $creneau->setIdFormation(NULL);
                    }
                }
                $creneau->save();
            }else{
                $creneau = new CreneauDisponibilite();
                $creneau->setIdCalendrierDisponibilite($calendar->id);
                $creneau->setIdEtatDisponibilite($status);
                $creneau->dateCreneauDisponibilite = $dateTimeObject->format("Y-m-d");
                $creneau->setIdTypeCreneau($semi);
                $creneau->save();
            }
        }
        $this->redirect("/formateur/disponibilite");
    }

    /**
     * Affiche la page de gestion des resonsable de calendrier
     */
    public function responsableCalendrier() {
        $get = HTTP_REQUEST->getGetParams();
        $user = new User($_SESSION['userID']);
        $this->getView("formateur/responsableCalendrier", [
            "hasAccessResponsable" => $user->getUsersAccessToCalendar(),
            "listCalendrier" => $user->getAllCalendriersDisponibilite(),
            "errorMessage" => $get["errorMessage"] ?? NULL
        ], "formateur")->addCSS("validation.css")->addCSS("user.css")->render();
    }

    /**
     * Traitement de la page d'ajout d'un responsable de calendrier
     */
    public function addResponsablePost() {
        $post = HTTP_REQUEST->getPostParams();

        if (isset($post["addResponsable"])) {
            $formateur = new User($_SESSION['userID']);
            $responsables = User::selectBy(["courriel" => $post["courriel"]]);
            $to[] = $post["courriel"];
            if (!empty($responsables)) {
                $responsable = $responsables[0];
                $alreadyExist = $formateur->addAccessToCalendar($post["calendrierID"], $responsable->id);
                if (!$alreadyExist) {
                    $this->redirect("/formateur/calendrier/responsable?errorMessage=Vous avez déjà ajouté ce responsable pour ce calendrier");
                }
                $subject = "Ajout Responsable Calendrier";
                $mail = new Mailer($to, $subject);
                $mail->addTemplate("mail/ajoutResponsable", [
                    "formateur" => $formateur,
                    "responsable" => $responsable,
                    "calendrierID" => $post["calendrierID"]
                ]);
            } else {
                $subject = "Création de Compte";
                $mail = new Mailer($to, $subject);
                $mail->addTemplate("mail/creationCompte", [
                    "mail" => $post["courriel"],
                    "formateur" => $formateur,
                ]);
            }
            
            $mail->send();
        }
        $this->redirect("/formateur/calendrier/responsable");
    }

    /**
     * Méthode de traitement des supressions de responsables de calendrier
     */
    public function removeResponsablePost() {
        $post = HTTP_REQUEST->getPostParams();

        if (isset($post['decline'])) {
            $user = new User($_SESSION['userID']);
            $responsable = new User($post['userID']);
            $calendar = new CalendriersDisponibilite($post['calendarID']);
            $user->removeAccessToCalendar($calendar->id, $responsable->id);
            $this->redirect("/formateur/calendrier/responsable");
        }
        $this->redirect("/formateur/calendrier/responsable?errorMessage=Veuillez selectionner une action");
    }
}