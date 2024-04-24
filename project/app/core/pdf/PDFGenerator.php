<?php

namespace App\Core;
use App\Exceptions\ResourceNotFound;
use App\Controllers\DisponibiliteController;
use Models\CalendriersDisponibilite;
use Models\EtatsDisponibilite;
use Models\User;
use TCPDF as TCPDF;

class PDFGenerator extends Controller
{
    private $title;
    private $fileNameOutput;
    private $outputType;

    /**
     * Récupération du titre et du mode d'output du PDF
     * 
     * @param string $title
     * @param string $outputType
     * @return void
     */
    public function __construct(string $outputType = 'I', string $title = 'Disponibilites') {
        $this->title = $title;
        $this->fileNameOutput = $title . '.pdf';
        $this->outputType = $outputType;
    }

    /**
     * Permet de générer un pdf pour le tableau de disponibilités
     */
    public function generatePDFDisponibilite() {
        $user = new User($_SESSION['userID']);
        $this->setTitle('Disponibilites_' . $user->nom . '_' . $user->prenom);
        $this->setFileName($this->getTitle() . '.pdf');
        
        $tcpdf = new TCPDF();
        $tcpdf->SetPrintHeader(false);
        $tcpdf->SetPrintFooter(false);
        $tcpdf->SetTitle($this->getTitle());
        $tcpdf->SetCreator('At-Dispo');
        $tcpdf->SetPageOrientation('L');
        $tcpdf->SetFont('helvetica', '', '10');
        
        // Les margins sur les tags sont enlevés 
        $tagvs = array('p' => array(0 => array('h' => 0, 'n' => 0), 1 => array('h' => 0, 'n' => 0)));
        $tcpdf->setHtmlVSpace($tagvs);
        
        $tcpdf->AddPage();
        
        // Récupération du contenu du PDF depuis une template
        ob_start();
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
        $content = $calendar->renderComposantToPdf();

        $this->render("formateur/disponibiliteToPdf", ["content" => $content, "year" => $year], "pdf");
        $content = ob_get_contents();
        ob_end_clean();

        $tcpdf->WriteHTML($content, true, false, true, false, '');        

        $tcpdf->lastPage();

        $outputType = $this->getOutputType();
        // Fin du contenu et affichage dans le navigateur avec 'I', 'D' pour le télécharger directement, 'S' pour le sortir en string, 'E' pour le sortir en base64
        switch($outputType) {
            case 'I':
            case 'D':
                return $tcpdf->Output($this->fileNameOutput, $outputType);
            case 'E':
                $start = 'Content';
                $end = '.pdf"';
                $output = $tcpdf->Output($this->fileNameOutput, $outputType);
                $startPosition = strpos($output, $start);
                $endPosition = strrpos($output, $end);

                return substr($output, 0, $startPosition) . substr($output, $endPosition + strlen($end));
            default:
                throw new \Exception('The generation of the PDF encountered an error');
        }
    }

    /**
     * Récupérer le nom du fichier
     * @return string
     */
    public function getFileName() {
        return $this->fileNameOutput;
    }

    /**
     * Définir le nom du pdf
     * @return void
     */
    private function setFileName(string $fileName) {
        $this->fileNameOutput = $fileName;
    }

    /**
     * Récupérer le titre du pdf
     * @return string
     */
    private function getTitle() {
        return $this->title;
    }

    /**
     * Définir le titre du pdf
     * @return void
     */
    private function setTitle(string $title) {
        $this->title = $title;
    }

    /**
     * Récupérer le type d'output du pdf
     * @return string
     */
    private function getOutputType() {
        return $this->outputType;
    }

    /**
     * Définir le type d'output du pdf
     * @return void
     */
    private function setOutputType(string $outputType) {
        $this->outputType = $outputType;
    }
}