<?php

namespace App\Controllers;

use App\Core\Controller;
use Models\Formations;
use Models\NomsFormation;
use Models\OrganismesFormation;
use Models\SitesOrgaFormation;

/**
 * Class AdminOrganismeController
 * @package App\Controllers
 */
class AdminOrganismeController extends Controller
{
    /**
     * Constructeur du controller AdminOrganismeController
     */
    public function __construct()
    {
        $this->access([1]);
    }

    /**
     * Affiche la liste des organismes
     *
     * @return void
     */
    public function listOrganisme(): void
    {
        // Récupération de la page et configuration de la limit en fonction de celle-ci
        $get = HTTP_REQUEST->getGetParams();
        $page = isset($get['page']) ? $get['page'] : 1; 
        $limit = 10; 
        $offset = ($page - 1) * $limit;
        
        $this->getView('admin/organisme/listOrganisme', ["organismeList" => OrganismesFormation::list($offset), "numberOfPages" => ceil(OrganismesFormation::count() / $limit)], 'admin')->addCSS("validation.css")->render();
    }

    /**
     * affiche et edit un organisme
     *
     * @param integer $id
     * @return void
     */
    public function showOrganisme(int $organismeId): void
    {
        $get = HTTP_REQUEST->getGetParams();
        $this->getView('admin/organisme/showOrganisme',
        [
            "errorMessage" => $get['errorMessage'] ?? NULL,
            "organisme" => new OrganismesFormation($organismeId),
            "sites" => SitesOrgaFormation::selectBy(["idOrganismeFormation" => $organismeId]),
            "formations" => Formations::getFormationsByOrgaFormation($organismeId),
            "allFormations" => Formations::list(),
            "allSites" => SitesOrgaFormation::list(),
            "nomFormations" => NomsFormation::selectBy(["valide" => 1])
        ],
        'admin')->addCSS("user.css")->render();
    }

    /**
     * Post - Modification d'un organisme
     *
     * @return void
     */
    public function editOrganismePost(){
        $post = HTTP_REQUEST->getPostParams();
        $organismeId = $post['organismeId'];
        if (isset($post['nomOrganismeFormation']) && isset($post['adresse']) && isset($post['codePostal']) && isset($post['ville'])) {
            $organisme = new OrganismesFormation($organismeId);
            $organisme->nomOrganismeFormation = trim($post['nomOrganismeFormation']);
            $organisme->adresse = trim($post['adresse']);
            $organisme->codePostal = trim($post['codePostal']);
            $organisme->ville = trim($post['ville']);
            $errors = $organisme->validate();
            if (empty($errors)) {
                $organisme->save();
                $this->redirect("/admin/organismes/$organismeId");
            } else {
                $firstError = array_shift($errors)[0][1];
                $this->redirect("/admin/organismes/$organismeId?errorMessage=$firstError");
            }
        }
        $this->redirect("/admin/organismes/$organismeId?errorMessage=Veuillez remplir tous les champs");
    }

    /**
     * Post - Supression d'un organisme
     *
     * @return void
     */
    public function deleteOrganismePost(){
        $post = HTTP_REQUEST->getPostParams();

        if (isset($post['delete'])) {
            $organisme = new OrganismesFormation($post['organismeId']);
            $organisme->delete();
        }
        $this->redirect('/admin/organismes');
    }

    /**
     * Post - Supression d'un organisme site
     */
    public function deleteSitePost(): void
    {
        $site = new SitesOrgaFormation((int)HTTP_REQUEST->getPostParams()['siteId']); // Si siteId n'existe pas, une 404 sera levée
        $site->delete();
        $organismeId = HTTP_REQUEST->getPostParams()['organismeId'];
        $this->redirect("/admin/organismes/$organismeId");
    }

    /**
     * Post - Ajout d'un orgaSite à l'organisme
     * @return void
     */
    public function addSitePost(){
        $post = HTTP_REQUEST->getPostParams();
        $site = new SitesOrgaFormation();
        $organismeId = $post['organismeId'];
        $site->setIdOrganismeFormation($organismeId);
        $site->nomSiteOrgaFormation = $post['nomSiteOrgaFormation'];
        $site->adresse = $post['adresse'];
        $site->codePostal = $post['codePostal'];
        $site->ville = $post['ville'];
        $errors = $site->validate();
        if (empty($errors)) {
            $site->save();
            $this->redirect("/admin/organismes/$organismeId");
        } else {
            $firstError = array_shift($errors)[0][1];
            $this->redirect("/admin/organismes/$organismeId?errorMessage=$firstError");
        }
    }

    /**
     * Post - Ajout d'une formations à l'organisme
     * @return void
     */
    public function addFormationPost(){
        $post = HTTP_REQUEST->getPostParams();
        
        $organisme = new OrganismesFormation($post['organismeId'] ?? 0);
        $organismeId = $organisme->id;
        $siteOrga = $organisme->getSiteOrganisme();

        if (!isset($siteOrga->id)){
            $this->redirect("/admin/organismes/$organismeId?errorMessage=Veuillez ajouter un site à l'organisme avant d'ajouter une formation");
        }

        $formation = new Formations();
        $formation->dateDebutFormation = $post["dateDebutFormation"];
        $formation->dateFinFormation = $post["dateFinFormation"];
        $formation->setIdNomFormation($post["nomFormation"]);
        $formation->setIdSiteOrgaFormation($siteOrga->id);
        $errors = $formation->validate();
        if (empty($errors)) {
            $formation->save();
            $this->redirect("/admin/organismes/$organismeId");
        } else {
            $firstError = array_shift($errors)[0][1];
            $this->redirect("/admin/organismes/$organismeId?errorMessage=$firstError");
        }
    }

    /**
     * Post - Suppression d'une formations à l'organisme
     * @return void
     */
    public function deleteFormationPost(){
        $post = HTTP_REQUEST->getPostParams();
        $formation = new Formations($post['formationId'] ?? 0); // Si formationId n'existe pas, une 404 sera levée
        $formation->delete();
        $organismeId = $post['organismeId'];
        $this->redirect("/admin/organismes/$organismeId");
    }
}