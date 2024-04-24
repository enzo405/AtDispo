<?php

namespace App\Router;

use App\Controllers\PageNotFoundController;
use App\Exceptions\InternalServerError;

class Route
{
	private HttpType $type;
	private string $url;
	private string $controllerName;
	private string $actionName;
	public array $nameParams = [];
	private string $regexUri;

	private array $params = []; // Tableau associatif [nameParams => valueParams]

	function __construct(HttpType $type, string $url, string $controllerName, string $actionName)
	{
		$this->type = $type;
		$this->url = $url;
		$this->controllerName = $controllerName;
		$this->actionName = $actionName;
		$this->prepareRoute();
	}

	public function getRegexUri(): string
	{
		return $this->regexUri;
	}

	public function setRegexUri($regexUri): void
	{
		$this->regexUri = $regexUri;
	}

	public function getType(): HttpType
	{
		return $this->type;
	}

	public function setType($type): void
	{
		$this->type = $type;
	}

	public function getUrl(): string
	{
		return $this->url;
	}

	public function setUrl($url): void
	{
		$this->url = $url;
	}

	public function getControllerName(): string
	{
		return $this->controllerName;
	}

	public function setControllerName($controllerName): void
	{
		$this->controllerName = $controllerName;
	}

	public function getActionName(): string
	{
		return $this->actionName;
	}

	public function setActionName($actionName): void
	{
		$this->actionName = $actionName;
	}

	public function getParams(): array
	{
		return $this->params;
	}

	public function setParams($params): void
	{
		$this->params = $params;
	}

	/**
	 * Fait le traitement de l'uri de la route pour avoir la regex voulu
	 * Crée le tableau qui contient les noms des paramètres
	 * 
	 * @return void
	 */
	private function prepareRoute(): void
	{
		$matches = [];
		$regResult = preg_match_all("/<str:[\w]*>|<int:[\w]*>/mu", $this->getUrl(), $matches);
		// Remplacements str
		$regexUri = preg_replace("/<str:[\w]*>/", "([a-zA-Z0-9-_]*)", $this->getUrl());
		// Remplacements int
		$regexUri = preg_replace("/<int:[\w]*>/", "([0-9]*)", $regexUri);
		// Remplacements des / par des \/
		$regexUri = "/^" . str_replace("/", "\/", $regexUri) . "$/";
		$this->setRegexUri($regexUri);

		// On vérifie qu'il y a eu des matches
		if ($regResult > 0) {
			foreach ($matches[0] as $matche) {
				array_shift($matches); // Enlève l'item d'index 0 qui contient le string qui a match
				$this->nameParams[] = str_replace(['<', '>'], "", $matche); // Récupère les noms des variables et on les stockent dans les params
			}
		}
	}


	/**
	 * Fait le tableau associatif des paramètres [nameParams => valueParams]
	 *
	 * @param HttpRequest $HttpRequest Contient l'object HttpRequest création lors de la création du Router
	 * @return void
	 */
	public function buildParams(HttpRequest $HttpRequest): void
	{
		$valueParams = $HttpRequest->getRequestParamsValue(); // On récupère le tableau qui contient toutes les valeurs des paramètres de l'url
		$nameParams = $this->nameParams; // Tableau qui contient le nom des paramètres définit dans le routes.json
		$params = [];
		$i = 0;
		// Traitement des variables pour avoir un tableau associatif (key => value)
		foreach ($valueParams as $value) {
			$nameParamWithType = $nameParams[$i];
			if (str_starts_with($nameParamWithType, "int:")) {
				$value = intval($value);
			} elseif (str_starts_with($nameParamWithType, "str:")) {
				$value = htmlspecialchars($value);
			} else {
				throw new \Exception('Not Handled Exception');
			}
			$nameParam = str_replace(["str:", "int:"], "", $nameParamWithType);
			$params[$nameParam] = $value;
			$i++;
		}
		$this->setParams($params);
	}


	/**
	 * Transforme le type de requête en object HttpType
	 *
	 * @param string $type "GET" ou "POST"
	 * @return HttpType
	 */
	static public function requestMethodToType(string $type): HttpType
	{
		return $type == "GET"
			? HttpType::GET
			: HttpType::POST;
	}


	/**
	 * Fait l'appel de la méthode du controller
	 * Appel le PageNotFoundController si la classe n'existe pas
	 *
	 * @return void
	 */
	public function call(): void
	{
		$namespaceAndController = "\App\Controllers" . '\\' . $this->getControllerName();
		if (class_exists($namespaceAndController)) {
			$controller = new $namespaceAndController(); // Instanciation de la classe du Controller (new HomeController())
			if (method_exists($controller, $this->getActionName())) {
				$params = $this->getParams(); // On récupère le table associatif qui contient paramètres build 
				call_user_func_array([$controller, $this->getActionName()], $params);
			} else if (MODE_DEV) { // si le DEV_MODE est activé 
				throw new InternalServerError('Method ' . $this->getControllerName() . '->' . $this->getActionName() . '() not found !');
			}
		} else if (MODE_DEV) { // si le DEV_MODE est activé 
			throw new InternalServerError('Controller not found : ' . $this->getControllerName());
		} else {
			throw new InternalServerError(); // Si on arrive là, y'a un problème chef
		}
	}
}
