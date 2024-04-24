<?php

namespace App\Core;
use PDO;

class BDD
{
    /**
     * Instance de la connexion à la base de données.
     */
    private static ?PDO $instance;

    /**
     * Constructeur de la connexion à la base de données.
     */
    private function __construct(
        string $dsn = DB_DNS,
        string $username = DB_USERNAME,
        string $password = DB_PWD
    ) {
        self::$instance = new PDO($dsn, $username, $password);
    }

    /**
     * Retourne l'instance de la connexion à la base de données.
     */
    public static function getInstance() {
        if (!isset(self::$instance)) {
            new self(DB_DNS, DB_USERNAME, DB_PWD);
        }

        return self::$instance;
    }

    /**
     * Empêche la copie externe de l'instance.
     */
    private function __clone () {
        // empeche la copie de l'instance
    }
}