<?php

namespace App\Controllers;

use App\Core\Controller;
use Models\Formations;
use Models\NomsFormation;


/**
 * Class AdminFormationController
 * @package App\Controllers
 */
class AdminFormationController extends Controller
{
    /**
     * Constructeur du controller AdminFormationController
     */
    public function __construct()
    {
        $this->access([1]);
    }

    /**
     * Liste toutes les formations.
     *
     * @return void
     */
    public function listFormation(): void
    {
        // Récupération de la page et configuration de la limit en fonction de celle-ci
        $get = HTTP_REQUEST->getGetParams();
        $page = isset($get['page']) ? $get['page'] : 1; 
        $limit = 10; 
        $offset = ($page - 1) * $limit;

        $formations = [];
        foreach (Formations::list($offset) as $formation) {
            $formations[$formation->getIdNomFormation()][] = new Formations($formation->id);
        }
        $this->getView('admin/formation/listFormation', ["formationsList" => $formations, "numberOfPages" => ceil(Formations::count() / $limit)], "admin")->addCSS('validation.css')->render();
    }

    /**
     * Permet de voire une formation/edit une formation.
     *
     * @return void
     */
    public function showFormation(int $idFormation): void
    {
        $formation = new Formations($idFormation);
        $this->getView("admin/formation/showFormation", ["formation" => $formation], "admin")->addCSS("user.css")->render();
    }

    /**
     * Post - suppression formation.
     *
     * @return void
     */
    public function deleteFormationPost(): void
    {
        $formationId = (int)HTTP_REQUEST->getPostParams()['formationId'];
        $formation = new Formations($formationId);
        $formation->delete();
        $this->redirect("/admin/formations");
    }
}
