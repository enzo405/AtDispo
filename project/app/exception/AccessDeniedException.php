<?php

namespace App\Exceptions;

use App\Core\View;

class AccessDeniedException extends \Exception
{
    public function __construct($message = "Vous n'avez pas les droits nécessaires pour accéder à cette page", $code = 403, \Throwable $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }

    public function run() {
        header("HTTP/1.0 403 Forbidden");
        if (!MODE_DEV) {
            (new View("erreur/403", ['message' => "Vous n'avez pas les droits nécessaires pour accéder à cette page"]))->addCSS('exception.css')->render();
        }
    }
}