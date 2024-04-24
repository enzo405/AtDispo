<?php

namespace App\Router;

class HttpRequest
{
    private string $RequestMethod;

    private string $RequestUri;

    private array $RequestPostParams = [];

    private array $RequestGetParams = [];

    private array $RequestParamsValue;

    public function __construct()
    {
        $this->RequestMethod = $_SERVER['REQUEST_METHOD']; // Récupère le type de la Méthode (GET ou POST)
        $this->RequestUri = explode("?", $_SERVER['REQUEST_URI'])[0]; // Récupère l'uri (par exemple : "/veille/2/update")
        // valide les paramètres du formulaire
        $this->validateParams($_POST, $this->RequestPostParams);
        $this->validateParams($_GET, $this->RequestGetParams);
    }

    /**
     * validate the request parameters
     */
    private function validateParams($source, &$destination)
    {
        foreach ($source as $key => $value) {
            $key = trim(htmlspecialchars($key));

            // Si la valeur est un tableau, récursivement valider ses éléments
            if (is_array($value)) {
                $this->validateParams($value, $destination[$key]);
            } else {
                // Sinon, appliquer la validation
                $value = htmlspecialchars($value);
                // Ajouter ici toute logique de validation spécifique si nécessaire
                $destination[$key] = $value;
            }
        }
    }

    /**
     * Get the request parameters value
     *
     * @return array The request parameters value
     */
    public function getRequestParamsValue(): array
    {
        return $this->RequestParamsValue;
    }

    /**
     * Get the request post parameters
     *
     * @return array The request post parameters
     */
    public function getPostParams(): array
    {
        return $this->RequestPostParams;
    }

    /**
     * Get the request get parameters
     *
     * @return array
     */
    public function getGetParams(): array
    {
        return $this->RequestGetParams;
    }

    /**
     * Set the request parameters value
     *
     * @param mixed $paramsValue
     */
    public function setRequestParamsValue($paramsValue): void
    {
        $this->RequestParamsValue = $paramsValue;
    }

    /**
     * Get the request method
     *
     * @return string
     */
    public function getRequestMethod(): string
    {
        return $this->RequestMethod;
    }

    /**
     * Get the request URI
     *
     * @return string
     */
    public function getRequestUri(): string
    {
        return $this->RequestUri;
    }
}
