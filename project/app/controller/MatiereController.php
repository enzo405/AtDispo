<?php

namespace App\Controllers;

use App\Core\Controller;
use Models\Matieres;

class MatiereController extends Controller
{
    /**
     * Constructeur du controller MatiereController
     */
    public function __construct() {
        $this->access([2]);
    }

    /**
     * Affiche la liste des matieres
     */
    public function listMatiere(){
        // Récupération de la page et configuration de la limit en fonction de celle-ci
        $get = HTTP_REQUEST->getGetParams();
        $page = isset($get['page']) ? $get['page'] : 1; 
        $limit = 10;
        $offset = ($page - 1) * $limit;

        $this->getView("responsable/matiere/listMatiere", ["listMatieres" => Matieres::list($offset), "numberOfPages" => ceil(Matieres::count() / $limit)], 'responsable')->addCSS("validation.css")->render();
    }

    /**
     * Demande de matière
     */
    public function askMatiere()
    {
        $get = HTTP_REQUEST->getGetParams();
        $this->getView("responsable/matiere/askMatiere", ['errorMessage' => $get["errorMessage"] ?? NULL], "responsable")->addCSS("user.css")->render();
    }

    /**
     * Traitement du formulaire de demande de matiere
     */
    public function askMatierePost()
    {
        $errors = [];
        $post = HTTP_REQUEST->getPostParams();
        // A la soumission du formulaire on assigne les valeurs post 
        if (isset($post["demanderMatiere"])) {
            $matiere = new Matieres();
            $matiere->libelleMatiere = trim($post['libelle']);
            $errors = $matiere->validate();

            if (empty($errors)) {
                $matiere->save();
                $this->redirect("/responsable/matieres");
            } else {
                $firstError = array_shift($errors)[0][1];
                $this->redirect("/responsable/matieres/ask?errorMessage=$firstError");
            }
        }
        $this->redirect("/responsable/matieres/ask?errorMessage=Veuillez remplir le formulaire");
    }
}