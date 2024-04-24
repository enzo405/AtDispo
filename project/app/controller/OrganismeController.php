<?php

namespace App\Controllers;

use App\Core\Controller;
use Models\User;
use Models\Role;
use Models\OrganismesFormation;
use App\Exceptions\ResourceNotFound;

class OrganismeController extends Controller
{
    /**
     * Constructeur du controller OrganismeController
     */
    public function __construct()
    {
        $this->access([2]);
    }

    /**
     * Demande d'organisme
     */
    public function askOrganisme()
    {
        $get = HTTP_REQUEST->getGetParams();
        $this->getView("responsable/organisme/askOrganisme", ['errorMessage' => $get["errorMessage"] ?? NULL], "responsable")->addCSS("user.css")->render();
    }

    /**
     * Traitement du formulaire de demande d'organisme
     */
    public function askOrganismePost()
    {
        $errors = [];
        $post = HTTP_REQUEST->getPostParams();
        
        if (isset($post["demanderOrga"])) {
            $organisme = new OrganismesFormation();
            // A la soumission du formulaire on assigne les valeurs post 
            $organisme->nomOrganismeFormation = trim($post['nom']);
            $organisme->adresse = trim($post['adresse']);
            $organisme->codePostal = trim($post['codePostal']);
            $organisme->ville = trim($post['ville']);

            // on valide ce qui va être entré dans la BDD
            $errors = $organisme->validate();
            if (empty($errors)) {
                // si il n'y a pas d'erreur on sauvegarde
                $organisme->valide = 0;
                $organisme->save();
                $this->redirect("/responsable/organismes/add");
            } else {
                $firstError = array_shift($errors)[0][1];
                $this->redirect("/responsable/organismes/ask?errorMessage=$firstError");
            }
        }
        $this->redirect("/responsable/organismes/ask?errorMessage=Le formulaire n'est pas valide");
    }

    /**
     * Ajout d'un organisme
     */
    public function addOrganisme()
    {
        $get = HTTP_REQUEST->getGetParams();
        $this->getView("responsable/organisme/addOrganisme", ["organismeList" => OrganismesFormation::selectBy(['valide' => 1]), 'errorMessage' => $get["errorMessage"] ?? NULL], "responsable")->addCSS("validation.css")->render();
    }

    /**
     * Traitement du formulaire d'ajout d'un organisme
     */
    public function addOrganismePost()
    {
        $post = HTTP_REQUEST->getPostParams();
        $user = new User($_SESSION['userID']);
        // à la soumission du formulaire on ajoute l'organisme et si l'organisme existe pas il renvoie une erreur
        if (isset($post["ajouterOrga"])) {
            $user->addOrganisme($post['organismeID']);
            $this->redirect("/responsable");
        }
        $this->redirect("/responsable/organismes/add?errorMessage=Cette organisme n'existe pas");
    }
}