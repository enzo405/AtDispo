<?php

namespace App\Controllers;

use App\Core\Mailer;
use App\Core\Controller;
use App\Exceptions\ResourceNotFound;
use Models\AffichagesTypesFermeture;
use Models\EtatsDisponibilite;
use Models\Matieres;
use Models\OptionsFormation;
use Models\SitesOrgaFormation;
use Models\User;
use Models\CalendriersDisponibilite;
use Models\Fermeture;
use Models\NomsFermeture;
use Models\OrganismesFormation;
use Models\TypesCreneau;
use Models\CreneauDisponibilite;
use Models\Formations;
use Models\NomsFormation;
use Models\Role;
use Models\TypesFermeture;
use App\Core\PDFGenerator;

class DebugController extends Controller
{
    public function __construct() {
        if (!MODE_DEV){
            throw new ResourceNotFound();
        }
    }

    public function index()
    {
        unset($_SESSION['routes_cache']);
        var_dump($_SESSION);
        $route_path = '../settings/routes.json';
		$jsonString = file_get_contents($route_path);
		$jsonData = json_decode($jsonString, true);
        $this->render('debug', ["routes" => $jsonData]);
    }

    public function testMailPost()
    {
        $to[] = "enzo.chaboisseau@gmail.com";
        $subject = "Réinitialisation de mot de passe";

        $mail = new Mailer($to, $subject);
        $cd = new CreneauDisponibilite(3);
        $calendrierDispo = new CalendriersDisponibilite($cd->getIdCalendrierDisponibilite());
        
        $mail->addTemplate("mail/ajoutEvenement", [
                "event" => $cd,
                "calendrierDispo" => $calendrierDispo
            ]);
        $mail->send();
        $this->redirect('/debug');
    }
}