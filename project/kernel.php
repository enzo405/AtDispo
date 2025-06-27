<?php
// rajoute auto load
require_once("../vendor/autoload.php");

use App\Router\Router;
use App\Router\HttpRequest;

const HTTP_REQUEST = new HttpRequest();

$dotenv = Dotenv\Dotenv::createImmutable(__DIR__, 'stack.env');
$dotenv->load();

try {
    ob_start();
    // Import du fichier de conf
    if (file_exists(__DIR__ . '/settings/config.local.php')) {
        include '../settings/config.local.php';
    } else {
        include '../settings/config.php';
    }

    if (MODE_DEV) {
        error_reporting(E_ALL);
        ini_set("display_errors", 1);
    }

    // Création de la session
    session_start();

    // on démarer le router
    (new Router());
} catch (Exception $e) {
    if (MODE_DEV) {
        echo $e->getMessage();
    } else {
        ob_end_clean();
        if (method_exists($e, "run")) {
            $e->run();
        } else {
            header("HTTP/1.1 500 Internal Server Error");
        }
    }
}
