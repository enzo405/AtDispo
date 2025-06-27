<?php

namespace App\Core;

use Models\User;

class View
{
    protected array $CSSFiles = [];
    protected array $JSFiles = [];
    protected string $title = 'At Dispo - AP3';
    protected string $pageDesc = '';
    protected string $templatePath;
    protected string $layout;
    protected array $variables;

    /**
     * @param string $templatePath chemin dans /templates de la vue du contenu
     * @param array $variables
     * @param string $layout Chemin de la layout depuis /templates/layouts
     */
    public function __construct(string $templatePath, array $variables = [], string $layout = 'commun')
    {
        $this->templatePath = $templatePath;
        $this->layout = $layout;
        $this->variables = $variables;
    }

    /**
     * Rendu de la vue
     * @return void
     */
    public function render(): Void
    {
        /*
         *  l'element view data contient l'ensemble d'information system utile pour la création d'une view
         */
        $viewData = [];
        $viewData['title'] = $this->title;
        $viewData['siteRoot'] = SITE_ROOT;
        $viewData['pageDesc'] = $this->pageDesc;
        $viewData['logged'] = isset($_SESSION['userID']);
        $viewData['CSSFiles'] = $this->getHTMLCSS();
        $viewData['JSFiles'] = $this->getHTMLJS();
        if (isset($_SESSION['userID'])) {
            $user = new User($_SESSION['userID']);
            $viewData["currentUser"] = $user;
            $viewData["roles"] = $user->roles;
        }
        if (MODE_DEV) {
            $viewData['Debug']['templatePath'] = dirname(__FILE__) . '/../../templates/' . $this->templatePath . '.tpl.php';
            $viewData['Debug']['layoutPath'] = dirname(__FILE__) . '/../../templates/layouts/' . $this->layout . ".tpl.php";
        }

        // instancie tout les variable passer a la vue
        foreach ($this->variables as $key => $value) {
            $viewData['variables'][$key] = $value;
            $$key = $value;
        }

        // charge le contenue html de la view dans une variable
        ob_start();
        include dirname(__FILE__) . '/../../templates/' . $this->templatePath . '.tpl.php';
        $content = ob_get_contents();
        ob_clean();

        include dirname(__FILE__) . '/../../templates/layouts/' . $this->layout . ".tpl.php";
    }

    /**
     * composant de la view
     * @return mixed
     *   return composant html
     */
    public function component(): mixed
    {
        /*
         *  l'element view data contient l'ensemble d'information system utile pour la création d'une view
         */
        $viewData = [];
        $viewData['title'] = $this->title;
        $viewData['siteRoot'] = SITE_ROOT;
        $viewData['pageDesc'] = $this->pageDesc;
        $viewData['logged'] = isset($_SESSION['userID']);
        $viewData['CSSFiles'] = $this->getHTMLCSS();
        $viewData['JSFiles'] = $this->getHTMLJS();
        if (MODE_DEV) {
            $viewData['Debug']['templatePath'] = dirname(__FILE__) . '/../../templates/' . $this->templatePath . '.tpl.php';
            $viewData['Debug']['layoutPath'] = dirname(__FILE__) . '/../../templates/layouts/' . $this->layout . ".tpl.php";
        }

        // instancie tout les variable passer a la vue
        foreach ($this->variables as $key => $value) {
            $viewData['variables'][$key] = $value;
            $$key = $value;
        }

        // charge le contenue html de la view dans une variable
        ob_start();
        include dirname(__FILE__) . '/../../templates/' . $this->templatePath . '.tpl.php';
        $content = ob_get_contents();
        ob_clean();

        return $content;
    }


    /**
     * Get html code for CSS files
     * @return string
     */
    private function getHTMLCSS(): string
    {
        $html = '';
        foreach ($this->CSSFiles as $CSSFile) {
            $html .= '<link rel="stylesheet" href="' . SITE_ROOT . "/assets/css/" . $CSSFile . '">' . "\n";
        }
        return $html;
    }

    /**
     * Get html code for JS files
     * @return string
     */
    private function getHTMLJS(): string
    {
        $html = '';
        foreach ($this->JSFiles as $JSFile) {
            $html .= '<script src="' . SITE_ROOT . "/assets/js/" . $JSFile . '"></script>' . "\n";
        }
        return $html;
    }

    /**
     * Set Title of the page
     * @param string $title
     * @return View
     */
    public function setTitle(string $title): View
    {
        $this->title = $title;
        return $this;
    }

    /**
     * Set Description of the page
     * @param string $pageDesc
     * @return View
     */
    public function setPageDesc(string $pageDesc): View
    {
        $this->pageDesc = $pageDesc;
        return $this;
    }

    /**
     * Ajoute un script JS lors du rendu de la page
     * @param string $JSFiles
     * @return View
     */
    public function addJS(string $JSFiles): View
    {
        $this->JSFiles[] = $JSFiles;
        return $this;
    }

    /**
     * Ajoute un fichier CSS lors du rendu de la page
     * @param string $CSSFiles
     * @return View
     */
    public function addCSS(string $CSSFiles): View
    {
        $this->CSSFiles[] = $CSSFiles;
        return $this;
    }
}
