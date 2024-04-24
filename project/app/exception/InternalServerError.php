<?php

namespace App\Exceptions;
use App\Core\View;

class InternalServerError extends \Exception
{
    public function __construct($message = "Un problème est survenue veuillez quitter le navire", $code = 404, \Throwable $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }

    public function run() {
        header("HTTP/1.0 500 Internal Server Error");
        if (!MODE_DEV) {
            (new View("erreur/500", ['message' => "Un problème est survenue"]))->addCSS('exception.css')->render();
        }
    }
}