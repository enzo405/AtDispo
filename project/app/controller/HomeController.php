<?php

namespace App\Controllers;

use App\Core\Controller;
use Models\User;

class HomeController extends Controller
{
    public function index()
    {
        /*savoir s'il est login*/
        $this->needLogin();
        
        $userInstance = new User($_SESSION['userID']);
        $userRoles = [];
        foreach($userInstance->roles as $role){
            $userRoles[] = $role->id;
        }

        if (in_array(1, array_values($userRoles))) {
            $this->redirect("/admin");
        } elseif (in_array(2, array_values($userRoles))) {
            $this->redirect("/responsable");
        } elseif (in_array(3, array_values($userRoles))) {
            $this->redirect("/formateur");
        }
    }

    /**
     * Message de bienvenue pour l'administrateur.
     *
     * @return void
     */
    public function welcomeAdmin(): void{
        $this->access([1]);
        $this->getView('admin/welcome', [], "admin")->addCSS('user.css')->render();
    }

    /**
     * Message de bienvenue pour le responsable pédagogique.
     *
     * @return void
     */
    public function welcomeResponsable(): void{
        $this->access([2]);
        $this->getView('responsable/welcome', [], "responsable")->addCSS('user.css')->render();
    }

    /**
     * Message de bienvenue pour le formateur.
     *
     * @return void
     */
    public function welcomeFormateur(): void{
        $this->access([3]);
        $this->getView('formateur/welcome', [], "formateur")->addCSS('user.css')->render();
    }

    /**
     * Affiche les mentions légales.
     *
    * @return void
    */
    public function mentionsLegales(): void
    {
        $this->getView('commun/mentionsLegales', [], 'commun')->addCSS('commun.css')->render();
    }
}
