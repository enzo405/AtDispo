<?php

namespace App\Exceptions;

use App\Core\View;

class DisabledForDemoException extends \Exception
{
    public function __construct($message = "Vous n'avez pas l'autorisation d'accéder à cette fonctionnalité dans la version de démo.", $code = 405, \Throwable $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }

    public function run() {
        header("HTTP/1.0 405 Method Not Allowed");
        (new View("erreur/demo", ['message' => "Vous n'avez pas l'autorisation d'accéder à cette fonctionnalité dans la version de démo."]))->addCSS('exception.css')->render();
    }
}