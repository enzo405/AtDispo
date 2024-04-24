<?php

namespace App\Controllers;

use App\Core\Controller;
use App\Core\Mailer;
use Models\Matieres;
use Models\OptionsFormation;
use Models\User;
use Models\Role;
use Models\Formations;
use Models\OrganismesFormation;
use Models\NomsFormation;


/**
 * Controlleur de la page d'attente de validation
 * @package App\Controllers
 */
class AdminWaitingController extends Controller
{
    /**
     * Constructeur du controller AdminWaitingController
     */
    public function __construct()
    {
        $this->access([1]);
    }

    /**
     * Affiche la page qui liste toutes les pages de validation
     * 
     * @return void
     */
    public function waitings(): void
    { 
        $this->getView("admin/waitings", [
            "statsUser" => User::countWaitingUsers(),
            "statsOrganism" => OrganismesFormation::countSelectBy(["valide" => 0]), 
            "statsMatiere" => Matieres::countSelectBy(["valide" => 0]),
            "statsOption" => OptionsFormation::countSelectBy(['valide' => 0]),
            "statsNomsFormation" => NomsFormation::countSelectBy(['valide' => 0])
        ], "admin")->addCSS("user.css")->render();
    }

    /**
     * Affiche la liste des utilisateurs en attente de validation
     * 
     * @return void
     */
    public function waitingUser(): void
    {
        // Récupération de la page et configuration de la limit en fonction de celle-ci
        $get = HTTP_REQUEST->getGetParams();
        $page = isset($get['page']) ? $get['page'] : 1; 
        $limit = 10;
        $offset = ($page - 1) * $limit;

        $this->getView("admin/user/waitingUser", [
            'userList' => User::getWaitingUsers($offset),
            'numberOfPages' => ceil(User::countWaitingUsers() / $limit),
            'roles' => Role::list(),
            'errorMessage' => $get["errorMessage"] ?? NULL
        ], "admin")->addCSS("validation.css")->render();
    }

    /**
     * Affiche la liste des organismes en attente de validation
     * 
     * @return void
     */
    public function waitingOrganisme(): void
    {
        // Récupération de la page et configuration de la limit en fonction de celle-ci
        $get = HTTP_REQUEST->getGetParams();
        $page = isset($get['page']) ? $get['page'] : 1; 
        $limit = 10;
        $offset = ($page - 1) * $limit;

        $this->getView("admin/organisme/waitingOrganisme", [
            'organismeList' => OrganismesFormation::selectBy(["valide" => 0], $offset), 
            'numberOfPages' => ceil(OrganismesFormation::countSelectBy(["valide" => 0]) / $limit),
            'errorMessage' => $get["errorMessage"] ?? NULL
        ], "admin")->addCSS("validation.css")->render();
    }

    /**
     * Affiche la liste des matieres en attente de validation
     * 
     * @return void
     */
    public function waitingMatiere(): void
    {
        // Récupération de la page et configuration de la limit en fonction de celle-ci
        $get = HTTP_REQUEST->getGetParams();
        $page = isset($get['page']) ? $get['page'] : 1; 
        $limit = 10;
        $offset = ($page - 1) * $limit;

        $this->getView("admin/matieres/waitingMatiere", [
            'matieresList' => Matieres::selectBy(["valide" => 0], $offset),
            'numberOfPages' => ceil(Matieres::countSelectBy(["valide" => 0]) / $limit),
            'errorMessage' => $get["errorMessage"] ?? NULL
        ], "admin")->addCSS("validation.css")->render();
    }


    /**
     * Ajoute une options pour la formation donné
     */
    public function waitingOption()
    {
        // Récupération de la page et configuration de la limit en fonction de celle-ci
        $get = HTTP_REQUEST->getGetParams();
        $page = isset($get['page']) ? $get['page'] : 1; 
        $limit = 10;
        $offset = ($page - 1) * $limit;

        $this->getView("admin/option/waitingOption", [
            'listOptions' => OptionsFormation::selectBy(['valide' => 0], $offset), 
            'numberOfPages' => ceil(OptionsFormation::countSelectBy(['valide' => 0]) / $limit),
            'errorMessage' => $get["errorMessage"] ?? NULL
        ], "admin")->addCSS("validation.css")->render();
    }

        /**
     * Validation d'un nom de formation
     */
    public function waitingNomsFormation()
    {
        // Récupération de la page et configuration de la limit en fonction de celle-ci
        $get = HTTP_REQUEST->getGetParams();
        $page = isset($get['page']) ? $get['page'] : 1; 
        $limit = 10; 
        $offset = ($page - 1) * $limit;

        $this->getView("admin/nomsFormation/waitingNomsFormation", 
        [
            'listNomsFormations' => NomsFormation::selectBy(['valide' => 0], $offset),
            'numberOfPages' => ceil(NomsFormation::countSelectBy(['valide' => 0]) / $limit),
            'errorMessage' => $get["errorMessage"] ?? NULL
        ], "admin")->addCSS("validation.css")->render();
    }

    /**
     * Traitement de la Validation d'un user
     * 
     * @return void
     */
    public function waitingUserPost(): void
    {
        $post = HTTP_REQUEST->getPostParams();
        
        if (!isset($post['userID'])) {
            $this->redirect('/admin/users/waiting?errorMessage=Veuillez choisir un utilisateur');
        }
        
        $user = new User($post['userID']);
        
        if (isset($post["decline"])) {
            $to[] = $user->courriel;
            $subject = "Votre compte At-Dispo | Non validé";
            $mail = new Mailer($to, $subject);
            $mail->addTemplate('mail/compteNonValide', ['compte' => $user]);
            $mail->addHeader("X-Mailer", 'PHP\\' . phpversion());
            $mail->send();

            $user->delete();
            $this->redirect("/admin/users/waiting");
        } else if ($post['roleID'] != 0 && isset($post["validate"])) {
            $to[] = $user->courriel;
            $subject = "Votre compte At-Dispo | Validé";
            $mail = new Mailer($to, $subject);
            $mail->addTemplate('mail/compteValide', ['compte' => $user]);
            $mail->addHeader("X-Mailer", 'PHP\\' . phpversion());
            $mail->send();
            
            $role = new Role($post['roleID']);
            $user->addRole($role->id);
            $this->redirect("/admin/users/waiting");
        } else {
            $this->redirect('/admin/users/waiting?errorMessage=Veuillez choisir un rôle');
        }
    }

    /**
     * Traitement de la Validation d'un organisme
     * 
     * @return void
     */
    public function waitingOrganismePost(): void
    {
        $post = HTTP_REQUEST->getPostParams();
        if (isset($post['organismeID'])) {
            $organisme = new OrganismesFormation($post['organismeID']);
            if (isset($post["decline"])) {
                $organisme->delete();
            } else if (isset($post["validate"])) {
                $organisme->valide = 1;
                $organisme->save();
            }
            $this->redirect("/admin/organismes/waiting");
        }
        $this->redirect('/admin/organismes/waiting?errorMessage=Veuillez choisir un organisme');
    }

    /**
     * Traitement de la Validation d'une matiere
     * 
     * @return void
     */
    public function waitingMatierePost(): void
    {
        $post = HTTP_REQUEST->getPostParams();
        if (isset($post['matiereID'])) {
            $matiere = new Matieres($post['matiereID']);
            if (isset($post["decline"])) {
                $matiere->delete();
            } else if (isset($post["validate"])) {
                $matiere->valide = 1;
                $matiere->save();
            }
            $this->redirect("/admin/matieres/waiting");
        }
        $this->redirect('/admin/matieres/waiting?errorMessage=Veuillez choisir une matiere');
    }

    /**
     * Traitement du formulaire d'ajout d'option
     */
    public function waitingOptionPost()
    {
        $post = HTTP_REQUEST->getPostParams();
        $option = new OptionsFormation($post["optionID"]);

        if (isset($post["validate"])){
            $option->valide = 1;
            $option->save();
            $this->redirect("/admin/options/waiting");
        } else if (isset($post["decline"])){
            $option->delete();
            $this->redirect("/admin/options/waiting");
        }
    }
    
        /*
    * Traitement de validation d'un nom de formation
    */
    public function waitingNomsFormationPost(): void
    {
        $post = HTTP_REQUEST->getPostParams();
        $nomFormations = NomsFormation::selectBy(["idNomFormation" => $post["nomFormationID"]]);
        if (isset($post["nomFormationID"]) && !empty($nomFormations)){
            $nomFormation = $nomFormations[0];
            if (isset($post["validate"])){
                $nomFormation->valide = 1;
                $nomFormation->save();
                $this->redirect("/admin/noms-formation/waiting");
            } else if (isset($post["decline"])){
                $nomFormation->delete();
                $this->redirect("/admin/noms-formation/waiting");
            }
        } else {
            $this->redirect("/admin/noms-formation/waiting?errorMessage=Le formulaire n'est pas valide");
        }
    }


}