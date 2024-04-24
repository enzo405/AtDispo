<?php

namespace App\Router;

use App\Exceptions\ResourceNotFound;
use App\Router\Route;

class Router
{
	public array $routes;
	private $HttpRequest;

	function __construct()
	{
		$route_path = '../settings/routes.json';
		$jsonString = file_get_contents($route_path);
		$jsonData = json_decode($jsonString, true); // On le contenu du fichier qui contient les routes
		$this->routes = $jsonData;
		$this->HttpRequest = HTTP_REQUEST;
		$this->buildRoute();
		$this->run();
	}

	/**
	 * Création de toutes les routes si la session contient le cache
	 *
	 * @return void
	 */
	public function buildRoute(): void
	{
		if (!isset($_SESSION["routes_cache"]) || MODE_DEV) // Si la session contient des route
		{
			$_SESSION["routes_cache"] = [];
			foreach ($this->routes as $typeRequest => $routes) {
				$type = Route::requestMethodToType($typeRequest); // Transforme le string GET ou POST en un type HttpRequest::GET ou POST
				foreach ($routes as $route) {
					$_SESSION["routes_cache"][$typeRequest][] = new Route($type, $route['url'], $route['controllerName'], $route['actionName']); // Création de la route
				}
			}
		}
	}

	/**
	 * Fait le match entre toutes les regex de chaque route et l'url de HttpRequest
	 * Puis construits les paramètres pour avoir le tableau associatif [nameParams => valueParams]
	 * Appel la méthode call lorsque le match est correct !
	 *
	 * @return void
	 */
	public function run(): void
	{
		$routes = $_SESSION['routes_cache'];
		$uriRequest = $this->HttpRequest->getRequestUri();
		if (str_ends_with($uriRequest, "/")) {
			$uriRequest = substr($uriRequest, 0, -1);
		}
		$typeRequest = $this->HttpRequest->getRequestMethod();
		foreach ($routes[$typeRequest] as $route) {
			$result = preg_match($route->getRegexUri(), $uriRequest, $matches);
			array_shift($matches); // On enlève l'item 0 qui contient le string qui a match
			$this->HttpRequest->setRequestParamsValue($matches); // On assigne la liste des noms des params à notre object HttpRequest
			if ($result > 0) {
				$route->buildParams($this->HttpRequest); // On build pour avoir un tableau associatif [nameParams => valueParams]
				$route->call();
				return;
			}
		}
		throw new ResourceNotFound();
	}
}
