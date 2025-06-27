<?php

/** 
 * /!\ Si vous avez des changements à faire merci de créer une fichier /settings/config.local.php et de faire vos changements dedans !
 * /!\ Si vous avez des changements à faire merci de créer une fichier /settings/config.local.php et de faire vos changements dedans !
 * /!\ Si vous avez des changements à faire merci de créer une fichier /settings/config.local.php et de faire vos changements dedans !
 */


/**
 * Information principal du site
 */
define('MODE_DEV', getenv('MODE_DEV') === 'true'); // true = mode développement, false = mode production
const SITE_NAME = 'atdispo.luhcaran.fr';
const SITE_ROOT = '';


/**
 * Email Information
 */
const EMAIL_FROM_NAME = 'AT Dispo';
const EMAIL_FROM = "no-reply@at-dispo.com";

/**
 * Database Information
 */
define('DB_HOST', getenv('DB_HOST')); // Host de la base de données, par défaut 'localhost'
define('DB_USERNAME', getenv('DB_USERNAME'));
define('DB_PWD', getenv('DB_PWD'));
const DB_NAME = 'AtDispo';
const DB_DNS = 'mysql:host=' . DB_HOST . ';dbname=' . DB_NAME;