<?php

namespace App\Core;

use App\Core\View;
use App\Exceptions\AccessDeniedException;
use Models\User;
use App\Core\BDD;
use PDO;

abstract class Controller
{
    public function redirect($url)
    {
        header('Location: ' . SITE_ROOT . $url);
        exit();
    }

    /**
     * Empêche les utilisateurs non-connectés d'accéder à la page
     * @param string $redirect_url
     * @return void
     */
    public function needLogin(string $redirect_url = null)
    {
        if (!isset($_SESSION['userID'])) {
            $_SESSION['redirectAfterLogin'] = $redirect_url;

            $this->redirect('/login');
        }
    }

    /**
     * Empêche les utilisateurs connectés d'accéder à la page
     * @return void
     */
    public function notLogin()
    {
        if (isset($_SESSION['userID'])) {
            $this->redirect('/');
        }
    }


    /**
     * return access to the page
     * @param array $roleid
     *   1 = Admin
     *   2 = Responsable
     *   3 = Formateur
     *
     * @return bool
     */
    public function access(array $roleIds): bool
    {
        try {
            $this->needLogin($_SERVER['REQUEST_URI']);
            $user = new User($_SESSION['userID']);
            foreach ($roleIds as $roleId) {
                if ($user->access($roleId)) {
                    return TRUE;
                }
            }
            throw new AccessDeniedException();
        } catch (\Throwable $th) {
            throw new AccessDeniedException();
        }
    }

    /**
     * Permet de savoir si l'utilisateur a accès à la formation
     *
     * @param int $idFormation
     * @return bool
     */
    public function hasAccessToFormation(int $idFormation): bool{
        // Récupérer l'OrganismesFormation qui contient la formations
        $pdo = BDD::getInstance();

        $sql = 'SELECT * FROM Formations
            INNER JOIN SitesOrgaFormation ON Formations.idSiteOrgaFormation = SitesOrgaFormation.idSiteOrgaFormation
            INNER JOIN OrganismesFormation ON OrganismesFormation.idOrganismeFormation = SitesOrgaFormation.idOrganismeFormation 
            INNER JOIN Comptes ON Comptes.idOrganismeFormation = OrganismesFormation.idOrganismeFormation
            WHERE Formations.idFormation = :idFormation AND Comptes.idCompte = :idCompte;';

        $sth = $pdo->prepare($sql, [PDO::ATTR_CURSOR => PDO::CURSOR_FWDONLY]);
        
        $sth->execute([
            ":idFormation" => $idFormation,
            ":idCompte" => $_SESSION["userID"]
        ]);

        // Vérifier que l'utilisateur a accès à l'organisme de formation
        $result = $sth->fetch(PDO::FETCH_ASSOC);
        if($result){
            return TRUE;
        }
        throw new AccessDeniedException("Vous n'avez pas accès à cette formation");
    }

    /**
     * Permet obtenir un object View
     *
     * @param string $templatePath
     * @param array $variables
     * @param string $layout
     * @return View
     */
    public function getView($templatePath, $variables = [], $layout = 'commun'): View
    {
        return new View($templatePath, $variables, $layout);
    }

    /**
     * Permet de rendre une view simple
     * @param string $templatePath
     * @param array $variables
     * @param string $layout
     * @return void
     */
    public function render($templatePath, $variables = [], $layout = 'commun'): void
    {
        $view = $this->getView($templatePath, $variables, $layout);
        $view->render();
    }
}
