<?php

namespace App\Controllers;

use App\Core\Controller;
use Models\Formations;
use Models\OptionsFormation;
use Models\SitesOrgaFormation;
use Models\User;
use Models\NomsFormation;

class FormationController extends Controller
{
    private User $currentUser;
    /**
     * Constructeur du controller FormationController
     */
    public function __construct() {
        $this->currentUser = new User($_SESSION['userID']);
        $this->access([2]);
    }

    /**
     * Affiche la liste des formations avec leurs nomsFormation, optionsFormation et les matieres
     */
    public function listFormation()
    {
        // Récupération de la page et configuration de la limit en fonction de celle-ci
        $get = HTTP_REQUEST->getGetParams();
        $page = isset($get['page']) ? $get['page'] : 1;
        $limit = 10;
        $offset = ($page - 1) * $limit;

        $organismeFormation = $this->currentUser->organismeFormation; // On récupère l'organisme de formation de l'utilisateur
        $formations = [];
        if (isset($organismeFormation)) {
            foreach (Formations::getFormationsByOrgaFormation($organismeFormation->id, $offset) as $formation) {
                $formations[$formation->getIdNomFormation()][] = new Formations($formation->id);
            }
            $this->getView('responsable/formation/listFormation', ["formationsList" => $formations, "numberOfPages" => ceil(Formations::countFormationsByOrgaFormation($organismeFormation->id) / $limit), "organismeFormation" => $organismeFormation], "responsable")->addCSS('validation.css')->render();
        }else{
            $this->getView('responsable/formation/listFormation', ["formationsList" => $formations, "numberOfPages" => 0, "organismeFormation" => NULL], "responsable")->addCSS('validation.css')->render();
        }
    }

    /**
     * Permet de voire une formation/edit une formation.
     *
     * @return void
     */
    public function showFormation(int $idFormation): void
    {
        $this->hasAccessToFormation($idFormation); // Renvoie une 403 si l'utilisateur n'a pas accès à la formation
        $formation = new Formations($idFormation);
        $this->getView("responsable/formation/showFormation", ["formation" => $formation], "responsable")->addCSS("user.css")->render();
    }

    /**
     * Permet la 1ère étape de la création d'une formation
     */
    public function createFormation()
    {
        $get = HTTP_REQUEST->getGetParams();
        $organismeFormation = $this->currentUser->organismeFormation;
        if (!isset($organismeFormation->id)) {
            $this->redirect("/responsable/organismes/add?errorMessage=Vous devez d'abord ajouter un organisme de formation");
        }

        // On récupère les sites de formation disponibles pour la formation
        $siteOrganismes = SitesOrgaFormation::selectBy(["idOrganismeFormation" => $organismeFormation->id]);

        // On récupère les noms de formation disponibles pour la formation
        $nomFormations = NomsFormation::selectBy(["valide" => 1]);

        $this->getView('responsable/formation/createFormation', [
            "nomFormations" => $nomFormations,
            "siteOrganismes" => $siteOrganismes,
            "errorMessage" => $get["errorMessage"] ?? NULL
        ], "responsable")->addCSS('user.css')->render();
    }

    /**
     * Traitement de la 1ère étape de la création d'une formation
     */
    public function createFormationPost()
    {
        $post = HTTP_REQUEST->getPostParams();
        $createdFormation = new Formations();
        if (!isset($post["dateDebutFormation"]) || !isset($post["dateFinFormation"]) || !isset($post["nomFormation"]) || !isset($post["siteOrgaFormation"])) {
            $this->redirect('/responsable/formations/create?errorMessage=Veuillez remplir tous les champs');
        }

        if (strtotime($post["dateDebutFormation"]) > strtotime($post["dateFinFormation"])) {
            $this->redirect('/responsable/formations/create?errorMessage=La date de début de formation doit être antérieure à la date de fin de formation');
        }

        $createdFormation->dateDebutFormation = $post["dateDebutFormation"];
        $createdFormation->dateFinFormation = $post["dateFinFormation"];
        $createdFormation->setIdNomFormation($post["nomFormation"]);
        $createdFormation->setIdSiteOrgaFormation($post["siteOrgaFormation"]);
        $errors = $createdFormation->validate();

        if (empty($errors)) {
            $createdFormation->save();
            $this->redirect("/responsable/formations/$createdFormation->id/options/add");
        } else {
            $firstError = array_shift($errors)[0][1];
            $this->redirect("/responsable/formations/create?errorMessage=$firstError");
        }
    }

    /**
     * Permet la 2ème étape de la création d'une formation
     */
    public function addOptionsFormation(int $idFormation)
    {
        $this->hasAccessToFormation($idFormation); // Renvoie une 403 si l'utilisateur n'a pas accès à la formation
        $get = HTTP_REQUEST->getGetParams();

        $createdFormation = new Formations($idFormation);

        $this->getView('responsable/formation/addOptionsFormation', [
            "createdFormation" => $createdFormation, // On passe la formation créée en paramètre pour pouvoir récupérer son idNomFormation et son idSiteOrgaFormation
            "options" => OptionsFormation::selectBy(['idNomFormation' => $createdFormation->getIdNomFormation(), 'valide' => 1]),
            "errorMessage" => $get["errorMessage"] ?? NULL
        ], "responsable")->addCSS('user.css')->render();
    }

    /**
     * Traitement de la 2ème étape de la création d'une formation
     */
    public function addOptionsFormationPost(int $idFormation)
    {
        $this->hasAccessToFormation($idFormation); // Renvoie une 403 si l'utilisateur n'a pas accès à la formation

        $post = HTTP_REQUEST->getPostParams();
        $options = [];
        // On récupère toutes les options dans le post
        foreach ($post['options'] as $optionId) {
            $options[] = new OptionsFormation($optionId);
        }

        if (!isset($post["AddOptions"]) || empty($options)) {
            $this->redirect("/responsable/formations/$idFormation/options/add?errorMessage=Veuillez sélectionner au moins une option");
        }
        $createdFormation = new Formations($idFormation);
        $createdFormation->saveOption($options);
        $this->redirect("/responsable/formations/$idFormation/options/add");
    }
}