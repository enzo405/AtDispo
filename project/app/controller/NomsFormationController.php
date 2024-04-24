<?php

namespace App\Controllers;

use App\Core\Controller;
use Models\Matieres;
use Models\NomsFormation;

class NomsFormationController extends Controller
{
    /**
     * Constructeur du controller NomsFormationController
     */
    public function __construct() {
        $this->access([2]);
    }

    /**
     * Demande de nom de formation
     */
    public function askNomsFormation()
    {
        $get = HTTP_REQUEST->getGetParams();
        $this->getView("responsable/nomsFormation/askNomsFormation", ['errorMessage' => $get["errorMessage"] ?? NULL], "responsable")->addCSS("user.css")->render();
    }


    /**
     * Traitement du formulaire de demande de nom de formation
     */
    public function askNomsFormationPost()
    {
        $post = HTTP_REQUEST->getPostParams();

        // A la soumission du formulaire on assigne les valeurs post 
        if (isset($post["demanderFormation"])) {
            $nomFormation = new NomsFormation();
            $nomFormation->libelleNomFormation = trim($post['nom']);
            // on valide ce qui va être entré dans la BDD
            $errors = $nomFormation->validate();
            if (empty($errors)) {
                // si il n'y a pas d'erreur on sauvegarde
                $nomFormation->save();
                $this->redirect("/responsable/formations");
            } else {
                $firstError = array_shift($errors)[0][1];
                $this->redirect("/responsable/noms-formation/ask?errorMessage=$firstError");
            }
        }
        $this->redirect("/responsable/noms-formation/ask");
    }

    public function addMatiere(int $idNomsFormation){
        $get = HTTP_REQUEST->getGetParams();
        $matieres = Matieres::selectBy(["valide" => 1]);
        $nomsFormation = new NomsFormation($idNomsFormation);
        $formationForNomsFormation = $nomsFormation->getFormations();

        $this->getView("responsable/nomsFormation/addMatiere", [
            'errorMessage' => $get["errorMessage"] ?? NULL,
            'matieres' => $matieres,
            'nomsFormation' => $nomsFormation,
            "formationForNomsFormation" => $formationForNomsFormation

        ], "responsable")->addCSS("user.css")->render();
    }
 
    public function addMatierePost(){
        $post = HTTP_REQUEST->getPostParams();
        $nomsFormation = new NomsFormation($post["idNomFormation"]);
        $matieres = [];
        // On récupère toutes les matières dans le post
        foreach ($post["matieres"] as $idMatiere) {
            $matieres[] = new Matieres($idMatiere);
        }
        if (!isset($post["AddMatiere"])) {
            $this->redirect("/responsable/noms-formation/$nomsFormation->id/matiere?errorMessage=Le formulaire n'est pas valide");
        } else {
            $nomsFormation->saveMatieres($matieres);
            $this->redirect("/responsable/noms-formation/$nomsFormation->id/matiere");
        }
    }
}