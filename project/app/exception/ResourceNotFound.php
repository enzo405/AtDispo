<?php

namespace App\Exceptions;

use App\Core\View;

class ResourceNotFound extends \Exception
{
    public function __construct($message = "Cette page n'existe pas", $code = 404, \Throwable $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }

    public function run() {
        header("HTTP/1.0 404 Not Found");
        if (!MODE_DEV) {
            (new View("erreur/404", ['message' => "Cette page n'existe pas"]))->addCSS('exception.css')->render();
        }
    }
}