<?php

namespace App\Controllers;

use App\Core\Controller;
use Models\Formations;
use Models\NomsFormation;
use Models\OptionsFormation;

class OptionsFormationController extends Controller
{
    /**
     * Constructeur du controller OptionsFormationController
     */
    public function __construct() {
        $this->access([2]);
    }

    public function listOption()
    {
        // Récupération de la page et configuration de la limit en fonction de celle-ci
        $get = HTTP_REQUEST->getGetParams();
        $page = isset($get['page']) ? $get['page'] : 1; 
        $limit = 10; 
        $offset = ($page - 1) * $limit;

        $this->getView("responsable/option/listOption", [
            'listOptions' => OptionsFormation::list($offset),
            'numberOfPages' => ceil(OptionsFormation::count() / $limit)
        ], "responsable")->addCSS("validation.css")->render();
    }

    /**
     * Demande une options pour la formation donné
     */
    public function askOption()
    {
        $get = HTTP_REQUEST->getGetParams();
        $listNomsFormation = NomsFormation::selectBy(['valide' => 1]);
        $this->getView("responsable/option/askOption", [
            'listNomsFormation' => $listNomsFormation,
            'errorMessage' => $get["errorMessage"] ?? NULL,
            'nomsFormationID' => $get["nomsFormationID"] ?? NULL
        ], "responsable")->addCSS("user.css")->render();
    }

    /**
     * Traitement du formulaire de demande d'option
     */
    public function askOptionPost()
    {
        $errors = [];
        $post = HTTP_REQUEST->getPostParams();
        if (isset($post['libelle'])) {
            $option = new OptionsFormation();

            $option->libelleNomOptionFormation = trim($post["libelle"]);
            $option->setIdNomFormation($post['idNomsFormation']);
            $errors = $option->validate();

            if (empty($errors)){
                $option->save();
                $this->redirect("/responsable/formations");
            } else {
                $this->redirect("/responsable/option/ask?errorMessage=L'option n'est pas valide");
            }
        }
        $this->redirect("/responsable/option/ask?errorMessage=Veuillez remplir tout les champs");
    }
}